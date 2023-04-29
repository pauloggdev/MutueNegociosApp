<?php

namespace App\Http\Controllers\empresa;

use App\Admin\LicencaEmpresa;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\ReportsController;
use Illuminate\Support\Str;

use App\Http\Controllers\Controller;
use App\Jobs\JobPedidoActivacaoLicenca;
use App\Models\admin\AtivacaoLicenca;
use App\Models\admin\Empresa;
use App\Models\admin\Factura;
use App\Models\admin\Licenca;
use App\Models\admin\Pagamento;
use App\Models\empresa\Factura as EmpresaFactura;
use App\Models\admin\Factura as AdminFactura;
use App\Models\admin\LicencaEmpresa as AdminLicencaEmpresa;
use App\Models\admin\User;
use App\Notifications\admin\PedidoAtivacaoLicenca;
use App\Rules\Empresa\EmpresaUnicaAdmin;
use App\Rules\Empresa\EmpresaUnique;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PDF;
use phpseclib\Crypt\RSA;
use phpseclib\Crypt\RSA as Crypt_RSA;

use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use DateTime;
use Illuminate\Support\Facades\Notification;
use Keygen\Keygen;


class LicencaController extends Controller
{
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;


    private $isApi;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->isApi = $request->is('api/*');
    }

    public function atribuirValorDefaultLicenca()
    {

        $empresaCliente = $this->pegarEmpresaAutenticadaGuardOperador();
        $empresa = DB::connection('mysql')->table('empresas')->where('referencia', $empresaCliente['empresa']['referencia'])->first();

        $empresaLicenca = DB::connection('mysql')->table('licenca_empresa')
            ->where('empresa_id', $empresa->id)->first();

        if (!$empresaLicenca) {
            $licencas =  DB::connection('mysql')->table('licencas')->get();
            foreach ($licencas as $key => $licenca) {
                DB::connection('mysql')->table('licenca_empresa')->insert([
                    'licenca_id' => $licenca->id,
                    'empresa_id' => $empresa->id,
                    'valor' => $licenca->valor,
                ]);
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {




        $users =  DB::connection('mysql2')->table('users_cliente')->get();


        $this->atribuirValorDefaultLicenca();

        $LICENCAS_ATIVO = 1;
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresaCliente = $this->pegarEmpresaAutenticadaGuardOperador();
        $empresa  = DB::connection('mysql')->table('empresas')->where('referencia', $empresaCliente['empresa']['referencia'])->first();
        $data['guard'] = $empresaCliente['guard'];

        
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }
        $data['licencas'] = AdminLicencaEmpresa::with(['licenca'])->where('empresa_id', $empresa->id)->get();
        return view('empresa.licencas.index', $data);
    }

    public function minhasLicencas()
    {

        $LICENCAS_ATIVO = 1;
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $data['guard'] = $empresa['guard'];

        if ( $infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresaAdmin = Empresa::where('referencia', $empresa['empresa']['referencia'])->first();
        $data['licencas']  = AtivacaoLicenca::with('licenca')->where('empresa_id', $empresaAdmin['id'])->where('status_licenca_id', $LICENCAS_ATIVO)->get();
        return view('empresa.licencas.minhasLicencas', $data);
    }

    public function pegarDependencias()
    {
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $referencia = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['referencia'];
        $empresa_id = DB::connection("mysql")->table('empresas')->where('referencia', $referencia)->first()->id;

        $data['formaPagamentos'] = DB::connection('mysql')->table('formas_pagamentos')->orderBy('descricao', 'ASC')->get();
        // $data['contaMovimento'] = DB::connection('mysql')->table('bancos')->orderBy('designacao', 'ASC')->get();
        $data['coordenadaBancarias'] = DB::connection('mysql')->table('coordenadas_bancarias')
            ->join('bancos', 'bancos.id', 'coordenadas_bancarias.banco_id')
            ->orderBy('bancos.id', 'ASC')->get();

        $FACTURA_DIVIDA = 1;
        $data['buscaReferencias'] = DB::connection('mysql')->table('factura_items')
            ->join('facturas', 'facturas.id', 'factura_items.factura_id')
            ->join('licencas', 'factura_items.licenca_id', 'licencas.id')
            ->select('facturas.*', 'factura_items.*', 'licencas.*')
            ->where('facturas.empresa_id', $empresa_id)
            ->where('facturas.statusFactura', $FACTURA_DIVIDA)
            ->orderBy('facturas.id', 'DESC')
            ->get();



        return Response()->json($data, 200);
    }

    public function pedidoAtivacaoLicenca($id)
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
            return view('admin.dashboard');
        }

        $id = base64_decode($id);

        if (Auth::guard('web')->check()) {
            $empresa_id = Empresa::where('user_id', Auth::user()->id)->first()->id;
            $operador = Auth::user()->id;
        }

        $ativaocaoLicenca = new AtivacaoLicenca();
        $ativaocaoLicenca->licenca_id = $id;
        $ativaocaoLicenca->empresa_id = $empresa_id;
        $ativaocaoLicenca->user_id = $operador;
        $ativaocaoLicenca->canal_id = 3; //Portal admin
        $ativaocaoLicenca->status_licenca_id = 8; //status Pendente
        $ativaocaoLicenca->save();

        if ($ativaocaoLicenca)
            return redirect()->back()->withSuccess('Operação efectuada com Sucesso!');
    }


    public function create()
    {
        //
    }

    public function buscarReferenciaFactura($faturaRereference)
    {
        $data['dados_factura'] = DB::connection('mysql')->table('factura_items')
            ->join('facturas', 'facturas.id', 'factura_items.factura_id')
            ->select('facturas.*', 'factura_items.*')
            ->where('facturas.faturaReference', $faturaRereference)
            ->where('facturas.user_id', Auth::user()->id)
            ->orderBy('facturas.id', 'DESC')
            ->limit(1)
            ->get();

        return response()->json($data);
    }

    public function salvarPedidoFactura(Request $request)
    {

        $numSequenciaFactura = 0;


        $validate = Validator::make($request->all(), [
            'quantidade' => ['required', 'numeric', 'min:1'],
            // 'custo_licenca' => ['required', 'numeric'],
            'total_a_pagar' => ['required', 'numeric'],
            'valor_extenso' => ['required', 'string'],
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }
        $empresaRamosSoft = Empresa::where('id', 1)->first(); //Pega empresa desenvolvedora

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']; //empresa cliente
        $empresaAdmin = DB::connection('mysql')->table('empresas')->where('referencia', $empresa['referencia'])->first();

        //Recupera informações da tabela parametros para o campo data_vencimento da factura
        $paramentro = DB::connection('mysql')->table('parametros')->where('id', 20)->first();

        //Recupera informações da última factura cadastrada no banco de dados
        $facturas = DB::connection('mysql')->table('facturas')
            ->where('empresa_id', $empresaAdmin->id)
            ->where('tipo_documento', 'FACTURA')
            ->orderBy('id', 'DESC')->limit(1)->first();


        /**
         * hashAnterior inicia vazio
         */
        $hashAnterior = "";
        if ($facturas) {
            $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
            $hashAnterior = $facturas->hashValor;
        } else {
            $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        //Manipulação de datas: data da factura e data actual
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/
        if ($data_factura->diffInYears($datactual) == 0) {
            if ($facturas) {
                $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
                $numSequenciaFactura = intval($facturas->numSequenciaFactura) + 1;
            } else {
                $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaFactura = 1;
            }
        } else if ($data_factura->diffInYears($datactual) > 0) {
            $numSequenciaFactura = 1;
        }
        $numeracaoFactura = 'FT ' . mb_strtoupper(substr(Str::slug($empresaRamosSoft->nome), 0, 3) . '' . date('Y')) . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);

        $rsa = new Crypt_RSA(); //Algoritimo RSA

        $privatekey = "MIICXAIBAAKBgQCqJsIyoKXnIyhFSwNZFE1lyGcsqn+6alTls2kzK8AsxIT21vD3
        ct0M8DlAUiPaeODU+wFmVpcGkSVRysDzXF6XvtBrZMk9qWbYrjuiXwAcMupXcR7d
        UWbc4QQbVqVYjE+MaOaR8YircAbq8bwHPpF+TYdQD5VdoAgE5YR240R4FQIDAQAB
        AoGAZq6pN2BXfltrLBYO2S01YB1Gll/2YQtWXKCe9fCLMvkNvOEN3mcFG4/FHRn0
        5R1ZoW4w9A+BaMcjHG8dbj/qHPD/9G3qvXmNN1J3d4vIe5QMqNEl8/OrdGGtxVlt
        QxDXjnsWr2vtayRZb7puxkxOBlLTyxfLlMVI3kefnv9U/+kCQQDdqzXNZsQiUIaP
        9GBaKE4/0rANYIINhf291u7XgyjuCdo+q3xuOyK0MNcJ/+ei0jLkXx9ao35mRggC
        nrJwWvnHAkEAxID4wrgWkb/7DEdf0xsMW2gk7Lq2L0/GziK1A3kMTUfCOfBy+fhY
        Suuu+1tw0oSlklYYlCzPT1CI+xf0HxofQwJAUxjzumRj8lktmJmL5UBm1RYuWVVs
        a5VnYdtI/hF1LocTAZtXshsJD3OfqWf9ddRGr8XZAyl3IO/v4MuNKQFx0QJATq7d
        7QpNbzsSSU5jHmLcRdWjw27X+IXXMz9Of/9+X4t2SEDxqQo6QHWy8U8iFAmtSrVS
        zjJLKJU05GYpCDMrhQJBAL6uhphR3SQgypTLlRB+XezzrDsjYBTPWjbGHekmT69k
        YODqjiQlUizmtxgJ3cZLU/hOFyJJ41qF+o2+SmwYy5s=";

        $publickey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCqJsIyoKXnIyhFSwNZFE1lyGcs
        qn+6alTls2kzK8AsxIT21vD3ct0M8DlAUiPaeODU+wFmVpcGkSVRysDzXF6XvtBr
        ZMk9qWbYrjuiXwAcMupXcR7dUWbc4QQbVqVYjE+MaOaR8YircAbq8bwHPpF+TYdQ
        D5VdoAgE5YR240R4FQIDAQAB";

        // Lendo a private key
        $rsa->loadKey($privatekey);

        /*Texto que deverá ser assinado com a assinatura RSA::SIGNATURE_PKCS1, e o Texto estará mais ou menos assim após as
        Concatenações com os dados preliminares da factura: 2020-09-14;2020-09-14T20:34:09;FP PAT2020/1;457411.2238438; */
        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoFactura . ';' . $request->valor_a_pagar . ';' . $hashAnterior;

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);

        // Verificando se o texto $plaintext foi ou está mesmo assinado 
        // echo $rsa->verify($plaintext, $signaturePlaintext) ? 'Verificado' : 'Não Verificado';

        DB::beginTransaction();

        try {
            $facturaId = DB::connection('mysql')->table('facturas')->insertGetId([
                'total_preco_factura' => $request->total_a_pagar,
                'valor_entregue' => 0,
                'valor_a_pagar' => $request->total_a_pagar,
                'troco' => 0,
                'valor_extenso' => $request->valor_extenso,
                'codigo_moeda' => 1, //kz
                'desconto' => 0,
                'retencao' => 0,
                'total_iva' => 0,
                'multa' => 0,
                'nome_do_cliente' => $empresaAdmin->nome,
                'telefone_cliente' => $empresaAdmin->pessoal_Contacto,
                'nif_cliente' => $empresaAdmin->nif,
                'email_cliente' => $empresaAdmin->email,
                'endereco_cliente' => $empresaAdmin->endereco,
                'numeroItems' => 1,
                'tipo_documento' => 'FACTURA',
                // 'tipoFolha' => $this->tipoDocumento($request->tipoFolha),
                'tipoFolha' => 'A4',
                'retificado' => 'Não',
                'canal_id' => 2, //canal cliente
                'status_id' => 1, //status ativo
                'empresa_id' => $empresaAdmin->id,
                'descricao' => mb_strtoupper('Licença ' . $request->designacao),
                'user_id' => Auth::user()->id,
                'faturaReference' => mb_strtoupper(Keygen::numeric(9)->generate()),
                'data_vencimento' => Carbon::now()->addDays($paramentro->vida),
                'numSequenciaFactura' => $numSequenciaFactura,
                'numeracaoFactura' => $numeracaoFactura,

            ]);

            DB::connection('mysql')->table('facturas')->where('id', $facturaId)->where('empresa_id', $empresaAdmin->id)
                ->update(['hashValor' => base64_encode($signaturePlaintext)]);

            $designacao_produto = 'Licença ' . $request->designacao;
            DB::connection('mysql')->table('factura_items')->insert([
                'descricao_produto' => mb_strtoupper($designacao_produto),
                'factura_id' => $facturaId,
                'licenca_id' => $request->id,
                'preco_produto' => $request->total_a_pagar,
                'desconto_produto' => 0,
                'quantidade_produto' => $request->quantidade,
                'total_preco_produto' => $request->total_a_pagar,
                'retencao_produto' => 0,
                'incidencia_produto' => 0,
                'iva_produto' => 0
            ]);

            DB::commit();

            return response()->json($facturaId, 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }
    }

    public function tipoDocumento($tipoDocummento)
    {

        switch ($tipoDocummento) {

            case 1:
                return "A4";
                break;
            case 2:
                return "A5";
                break;
            default:
                return "TICKET";
                break;
        }
    }


    public function salvarPagamento(Request $request)
    {


        $data = json_decode($request->addPagamento, true);

        if ($this->verificarLicencaDefinitivo($data['empresa_id'], $data['licenca_id'])) {
            return response()->json(['isValid' => false, 'errors' => 'A empresa já contém pedido licenca definitivo'], 500);
        }

        $mensagem = [
            'referenciaFactura.required' => 'Informe a referência',
            'nFactura.required' => 'Informe a referência',
            'numero_operacao_bancaria.required' => 'Informe a número da operação bancaria',
            'conta_movimentada_id.required' => 'Informe a conta movimentada',
            'forma_pagamento_id.required' => 'Informe a forma de pagamento',
            'data_pago_banco.required' => 'Informe a data de pagamento no banco',
            'nFactura.unique' => 'Factura já registado'
        ];

        $STATUS_DESACTIVO = 2;
        $STATUS_PEDENTE = 3;

        $validate = Validator::make($data, [
            'totalPago' => ['required'],
            'data_pago_banco' => ['required'],
            'numero_operacao_bancaria' => ['required', new EmpresaUnicaAdmin('pagamentos', 'mysql')],
            'forma_pagamento_id' => ['required', 'numeric', 'min:1'],
            'conta_movimentada_id' => ['required', 'numeric', 'min:1'],
            'referenciaFactura' => ['required', function ($attribute, $value, $fail) {
                $referenciaFactura = DB::connection('mysql')->table('pagamentos')->where('referenciaFactura', $value)->first();
                if ($referenciaFactura) {
                    $fail('Referência factura já enviado');
                }
            }]
            // 'nFactura' => ['required', new EmpresaUnicaAdmin('pagamentos', 'mysql')],

        ], $mensagem);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }


        if (isset($request->comprovativo_bancario) && !empty($request->comprovativo_bancario)) {
            if (!in_array($request->comprovativo_bancario->getClientOriginalExtension(), ["jpeg", "png", "jpg", "pdf"])) {
                return response()->json(['isValid' => false, 'errors' => 'comprovativo bancario no formato não suportado'], 422);
            }
            $comprovativo_bancario = $request->comprovativo_bancario->store('/admin/licenca');
        } else {
            return response()->json(['isValid' => false, 'errors' => 'Adicione o comprovativo bancario'], 422);
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']; //empresa cliente
        $empresaAdmin = DB::connection('mysql')->table('empresas')->where('referencia', $empresa['referencia'])->first();

        //$cliente = Empresa::where('user_id', Auth::user()->id)->first();

        $date = new DateTime($data['data_pago_banco']);
        $data_pago_banco = $date->format('Y-m-d H:i:s');


        DB::beginTransaction();

        try {

            $pagamentoId = DB::connection('mysql')->table('pagamentos')->insertGetId([

                'valor_depositado' => $data['totalPago'],
                'quantidade' => $data['quantidade'],
                'totalPago' => $data['totalPago'],
                'conta_movimentada_id' => $data['conta_movimentada_id'],
                'data_pago_banco' => $data_pago_banco,
                'forma_pagamento_id' => $data['forma_pagamento_id'],
                'numero_operacao_bancaria' => mb_strtoupper($data['numero_operacao_bancaria']),
                'observacao' => ($data['observacao']) ? $data['observacao'] : '',
                'referenciaFactura' => mb_strtoupper($data['referenciaFactura']),
                'canal_id' => $data['canal_id'],
                'descricao' => "Liquidação da factura " . $data['nFactura'],
                'nFactura' => $data['nFactura'],
                'status_id' => $STATUS_DESACTIVO,
                'user_id' => Auth::user()->id,
                'factura_id' => $data['factura_id'],
                'empresa_id' => $data['empresa_id'],
                'comprovativo_bancario' => $comprovativo_bancario
            ]);

            $activacaoLicencaId = DB::connection('mysql')->table('activacao_licencas')->insertGetId([
                'licenca_id' =>  $data['licenca_id'],
                'empresa_id' => $empresaAdmin->id,
                'canal_id' => $data['canal_id'], //Portal admin
                'status_licenca_id' => $STATUS_PEDENTE, //status Pendente
                'pagamento_id' => $pagamentoId,
            ]);

            $activacaoDeLicenca = AtivacaoLicenca::with(['licenca'])->where('id', $activacaoLicencaId)->where('empresa_id', $data['empresa_id'])->first();

            //DADOS PARA ENVIAR NO EMAIL
            $dataEmail['nome'] = $empresa->nome;
            $dataEmail['emailEmpresa'] = $empresa->email;
            $dataEmail['assunto'] = 'Pedido de Activação de Licença';
            $dataEmail['tipoLicenca'] = $activacaoDeLicenca->licenca->designacao;

            JobPedidoActivacaoLicenca::dispatch($dataEmail)->delay(now()->addSecond('5'));


            //  return response()->json($pagamentoId, 200);

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
        }




        //  $pagamento->save();

        // if ($pagamento) {

        //  $this->actualizarFacturaStatuPago($data['factura_id']);
        // $ativaocaoLicenca->licenca_id =  $data['licenca_id'];
        // $ativaocaoLicenca->empresa_id = $empresaAdmin->id;
        // // $ativaocaoLicenca->user_id = $empresaAdmin->id;
        // $ativaocaoLicenca->canal_id = $data['canal_id']; //Portal admin
        // $ativaocaoLicenca->status_licenca_id = $STATUS_PEDENTE; //status Pendente
        // $ativaocaoLicenca->pagamento_id = $pagamento->id;
        // $ativaocaoLicenca->save();





        // dd($dataEmail);
        //     // $data['data'] = $activacaoDeLicenca;


        //     // Notification::route('mail', 'mutuenegocio@gmail.com')
        //     // ->notify(new PedidoAtivacaoLicenca($data));

        // $cliente = Empresa::where('id', 1)->first();

        //     //dd($data);


        // $cliente->notify(new PedidoAtivacaoLicenca($dataEmail));


        //     if ($ativaocaoLicenca) {
        //         return response()->json($pagamento, 200);
        //     }
        // }
    }
    // public function imprimirReciboLicenca($reciboFacturaLicencaId, $viaImpressao)
    // {

    //     $reportController = new ReportController();
    //     return $reportController->imprimirReciboLicenca($reciboFacturaLicencaId, $viaImpressao);
    // }

    public function verificarLicencaDefinitivo($empresaId, $licencaId)
    {
        $LICENCA_DEFINITIVA = 4;
        $STATUS_ACTIVO = 1;
        $ativacaoLicenca = DB::connection('mysql')->table('activacao_licencas')->where('licenca_id', $licencaId)->where('empresa_id', $empresaId)->first();
        if ($ativacaoLicenca && $ativacaoLicenca->licenca_id == $LICENCA_DEFINITIVA && $ativacaoLicenca->status_licenca_id == $STATUS_ACTIVO) {
            return $ativacaoLicenca;
        }
        return false;
    }


    public function imprimirFactura($idFactura)
    {

        $A4 = 1;
        $A5 = 2;
        $TICKET = 3;

        $empresa_mysql2 = $this->pegarEmpresaAutenticadaGuardOperador()['empresa'];
        $empresa = Empresa::where('referencia', $empresa_mysql2['referencia'])->first();

        if (isset($_GET['viaImpressao']) && !empty($_GET['viaImpressao'])) {
            $viaImpressao = $_GET['viaImpressao'];
        }
        // if ($FORMATODOCUMENTO == $A4) {
        //     $filename = "facturas"; //filename
        // } else if ($FORMATODOCUMENTO == $TICKET) {
        //     $filename = "FacturaTicket";
        // }
        // else {//tipo A5
        //     $filename = "Facturas_A5";
        // }
        $filename = "facturas"; //filename


        //Logotipo da ramossoft
        $caminho = public_path() . "/upload/default.jpg";
        $subreportFactura = public_path() . '/upload/admin/relatorios/';

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    "empresa_id" => $empresa->id,
                    "facturaId" => $idFactura,
                    "viaImpressao" => $viaImpressao,
                    "logotipo" => $caminho,
                    "subreportFactura" => $subreportFactura
                ]

            ]
        );
    }

    public function imprimirReciboPagamento(Request $request, $id, $refTipoFactura)
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
            return view('admin.dashboard');
        }

        $empresa = Empresa::where('user_id', Auth::user()->id)->first();

        $data['recibo'] = DB::connection('mysql')->table('pagamentos')
            ->join('facturas', 'facturas.id', 'pagamentos.factura_id')
            ->join('empresas', 'empresas.id', 'pagamentos.empresa_id')
            ->join('tipos_regimes', 'tipos_regimes.id', 'empresas.tipo_regime_id')
            ->join('moedas', 'moedas.id', 'facturas.codigo_moeda')
            ->join('formas_pagamentos', 'formas_pagamentos.id', 'pagamentos.forma_pagamento_id')
            ->select('facturas.*', 'pagamentos.*', 'empresas.*', 'tipos_regimes.Designacao AS regime_empresa', 'facturas.id AS factura_id', 'pagamentos.id AS pagamento_id', 'pagamentos.created_at AS dataPagamento', 'pagamentos.observacao AS obs', 'moedas.designacao AS moeda', 'moedas.cambio AS cambio', 'formas_pagamentos.descricao AS forma_pagamento')
            ->where('pagamentos.id', $id)->first();

        if ($refTipoFactura == 1) {
            return view('pdf.licencas.recibo_pagamento', $data);
            // $factura = 'a4';
            // $path = 'pdf.licencas.recibo_pagamento';
        } elseif ($refTipoFactura == 2) {
            return view('pdf.licencas.recibo_pagamento_A5', $data);
            // $factura = 'a5';
            // $path = 'pdf.licencas.recibo_pagamento_A5';
        }

        // $pdf = PDF::loadView($path,$data)->setPaper($factura, 'portrait');
        // return $pdf->stream('recibo_pagamento.pdf');

        // $pdf = PDF::loadView('pdf.licencas.recibo_pagamento', $data)->setPaper('a4', 'portrait');
        // return $pdf->stream('recibo_pagamento.pdf');

        //return view('pdf.licencas.recibo_pagamento', $data);

    }
}
