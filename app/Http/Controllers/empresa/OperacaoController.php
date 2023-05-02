<?php

namespace App\Http\Controllers\empresa;

use App\Repositories\Empresa\FacturaRepositorio;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\empresa\Empresa_Cliente;
use App\Models\admin\Empresa;
use App\Models\empresa\AnulacaoDocumento;
use App\Models\empresa\Cliente;
use App\Models\empresa\Factura;
use App\Models\empresa\NotaCredito;
use App\Models\empresa\NotaDebito;
use App\Models\empresa\Recibos;
use App\Models\empresa\Produto;
use App\Models\empresa\RecibosItem;
use App\Models\empresa\TipoDocumento;
use App\Rules\Empresa\EmpresaUnique;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use phpseclib\Crypt\RSA;
use phpseclib\Crypt\RSA as Crypt_RSA;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use App\Models\empresa\Statu;
use App\Http\Controllers\empresa\ReportController;
use App\Models\contsys\Movimento;
use App\Models\contsys\MovimentoItems;
use App\Models\empresa\EntradaStock;
use App\Models\empresa\ExistenciaStock;
use App\Models\empresa\FacturaItems;
use App\Models\empresa\FormaPagamentoGeral;
use App\Models\empresa\NotaCreditoItems;

class OperacaoController extends Controller
{
    use VerificaSeEmpresaTipoAdmin;
    use TraitEmpresaAutenticada;
    use VerificaSeUsuarioAlterouSenha;



    public function entradaProdutoStockIndex()
    {

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

        $data['entradastock'] = EntradaStock::with(['entradaStockItems', 'entradaStockItems.produto', 'armazem', 'fornecedor', 'formaPagamento'])->where('empresa_id', $empresa['empresa']['id'])->get();
        return view('empresa.operacao.entradaProdutoStockIndex', $data);
    }
    public function entradaProdutoStockNovo()
    {


        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        $data['guard'] = $empresa['guard'];
        $data['formapagamentos'] = FormaPagamentoGeral::get();
        return view('empresa.operacao.entradaProdutoStockNovo', $data);
    }



    /**
     * Display a listing of the resource.
     *
     */
    public function depositoReciboIndex()
    {
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;
        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        $data['guard'] = $empresa['guard'];

        $data['dataRecibos'] = Recibos::with(['cliente', 'formaPagamento'])->where('empresa_id', $empresa['empresa']['id'])->get();
        return view('empresa.operacao.depositoReciboIndex', $data);
    }


    public function notaCreditoIndex()
    {

        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $data['guard'] = $empresa['guard'];

        $data['dataNotaCredito'] = NotaCredito::with('cliente')->where('tipoNotaCredito', 1)->where('empresa_id', $empresa['empresa']['id'])->get();
        return view('empresa.operacao.notaCreditoIndex', $data);
    }
    public function notaDebitoIndex()
    {

        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        $data['guard'] = $empresa['guard'];

        $data['dataNotaDebito'] = NotaDebito::with('cliente')->where('empresa_id', $empresa['empresa']['id'])->get();

        return view('empresa.operacao.notaDebitoIndex', $data);
    }
    public function listarFactura($id)
    {
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {

                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $data['factura'] = Factura::with(['facturas_items', 'facturas_items.produto.tipoTaxa'])->where('id', $id)->where('empresa_id', $empresa_id)->first();


        //valor total entregue pelo id da factura
        $data['totalEntregue'] = DB::connection('mysql2')->table('recibos_items')->where('factura_id', $id)->where('anulado', 1)->where('empresa_id', $empresa_id)->sum('valor_entregue');

        return response()->json($data);
    }
    public function listarClientes()
    {
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

       
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }


        //Pega o cliente diversos
        $cliente = Cliente::where('empresa_id', $empresa_id)->orderBy('id', 'asc')->first();

        $data['clientes'] = Cliente::where('id', '!=', $cliente->id)->where('empresa_id', $empresa_id)->get();

        return response()->json($data, 200);
    }
    public function salvarNotaCredito(Request $request, FacturaRepositorio $facturaRepositorio)
    {

        $notaCredito = new NotaCredito();

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            $empresa = Empresa::where('user_id', Auth::user()->id)->first();
            $operador = Auth::user()->id;
            $tipo_user_id = 2; //tipo empresa

        } else {
            $empresa_id = Auth::user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
            $operador = Auth::user()->id;
            $tipo_user_id = 3; //tipo funcionario

        }


        //Pega o ultimo recibo
        $ultimaNotaCredito = DB::connection('mysql2')->table('notas_credito')->where('empresa_id', $empresa_id)
            ->whereNull('facturaId')->whereNull('reciboId')
            ->orderBy('id', 'DESC')->limit(1)->first();

        $hashAnterior = "";
        if ($ultimaNotaCredito) {
            $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaNotaCredito->created_at);
            $hashAnterior = $ultimaNotaCredito->created_at;
        } else {
            $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        //Manipulação de datas: data actual
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        //dd($ultimaNotaCredito);


        /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/

        if ($data_notaCredito->diffInYears($datactual) == 0) {

            if ($ultimaNotaCredito) {
                $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaNotaCredito->created_at);
                $numSequenciaNotaCredito = intval($ultimaNotaCredito->numSequenciaNotaCredito) + 1;
            } else {
                $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaNotaCredito = 1;
            }
        } else if ($data_notaCredito->diffInYears($datactual) > 0) {
            $numSequenciaNotaCredito = 1;
        }

        $numeracaoDocumento = 'NC ' . mb_strtoupper(substr($empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaNotaCredito; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);



        $rsa = new Crypt_RSA(); //Algoritimo RSA

        $privatekey = $facturaRepositorio->pegarChavePrivada();

        $publickey = $facturaRepositorio->pegarChavePublica();

        // Lendo a private key
        $rsa->loadKey($privatekey);

        /*Texto que deverá ser assinado com a assinatura RSA::SIGNATURE_PKCS1, e o Texto estará mais ou menos assim após as
        Concatenações com os dados preliminares da factura: 2020-09-14;2020-09-14T20:34:09;FP PAT2020/1;457411.2238438; */

        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoDocumento . ';' . number_format($request['valor_credito'], 2, ".", "") . ';' . $hashAnterior;


        // dd($plaintext);

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);


        $this->validate($request, [
            'descricao' => ['required', 'min:2', 'max:255'],
            'cliente_id' => ['required'],
            'valor_credito' => ['required'],
        ]);

        $TIPO_CREDITO = 1;
        $TIPO_DOCUMENTO = 5;

        $notaCredito->cliente_id = $request->cliente_id;
        $notaCredito->empresa_id = $empresa_id;
        $notaCredito->numeracaoDocumento = 'NC ' . mb_strtoupper(substr($empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaNotaCredito;
        $notaCredito->valor_credito = $request->valor_credito;
        $notaCredito->descricao = $request->descricao;
        $notaCredito->valor_extenso = $request->valor_extenso;
        $notaCredito->numSequenciaNotaCredito = $numSequenciaNotaCredito;
        $notaCredito->user_id = $operador;
        $notaCredito->tipo_user_id = $tipo_user_id;
        $notaCredito->tipoNotaCredito = $TIPO_CREDITO;
        $notaCredito->tipo_documento = $TIPO_DOCUMENTO;
        $notaCredito->nome_do_cliente = $request->nome_do_cliente;
        $notaCredito->telefone_cliente = $request->telefone_cliente;
        $notaCredito->nif_cliente = $request->nif_cliente;
        $notaCredito->email_cliente = $request->email_cliente;
        $notaCredito->endereco_cliente = $request->endereco_cliente;
        $notaCredito->conta_corrente_cliente = $request->conta_corrente_cliente;
        $notaCredito->save();

        NotaCredito::where('id', $notaCredito->id)->limit(1)->update(['hash' => base64_encode($signaturePlaintext)]); //Actualiza sempre o Hash da última factura

        $viaImpressao = 1; // 1 - via impressão



        if ($notaCredito) {
            $hash = base64_encode($signaturePlaintext);
            $tipoMovimento = 2;
            $movimento = $this->salvarMovimentosContsys($notaCredito, $hash, $tipoMovimento);
            $this->cadastrarMovimentosItems($notaCredito, $movimento, $tipoMovimento);
            return $this->imprimirNotaCredito($notaCredito->id, $viaImpressao);
        }

        // return response()->json($notaCredito, 200);
    }

    public function salvarMovimentosContsys($notaCreditoOuDebito, $hash, $tipoMovimento)
    {

        $CREDITO = 2;
        $DEBITO = 1;

        $movimentos = new Movimento();


        if ($tipoMovimento == $CREDITO) {
            $movimentos->Descricao = 'dar saldo ao cliente, cliente: ' . $notaCreditoOuDebito->nome_do_cliente;
            $movimentos->TipoMovimento = "NOTA CREDITO";
            $movimentos->CodigoContaDebito = 1;
            $movimentos->TipoDocumento = 3;
        } else if ($tipoMovimento == $DEBITO) {
            $movimentos->Descricao = 'retirar saldo ao cliente, cliente: ' . $notaCreditoOuDebito->nome_do_cliente;
            $movimentos->TipoMovimento = "NOTA DEBITO";
            $movimentos->CodigoContaDebito = 2;
            $movimentos->TipoDocumento = 1;
        }

        $movimentos->DataMovimento = $notaCreditoOuDebito->created_at;
        $movimentos->CodigoUtilizador = $this->getUtilizadorContsysId($notaCreditoOuDebito->empresa_id, $notaCreditoOuDebito->user_id);
        $movimentos->CodEmpresa = $this->getEmpresaContsysId($notaCreditoOuDebito);
        $movimentos->AnoFinanceiro = date("Y");
        $movimentos->CodigoStatus = 1;
        $movimentos->CodigoContaCredito = 0;
        $movimentos->CodigoCentroCusto = 1;
        $movimentos->telefoneCliente = $notaCreditoOuDebito->telefone_cliente;
        $movimentos->nifCliente = $notaCreditoOuDebito->nif_cliente;
        $movimentos->NomeCliente = $notaCreditoOuDebito->nome_do_cliente;
        $movimentos->morada = $notaCreditoOuDebito->endereco_cliente;
        $movimentos->hash = $hash;
        $movimentos->forma = 0;
        $movimentos->save();
        return $movimentos;
    }
    public function cadastrarMovimentosItems($notaCreditoOuDebito, $movimentos, $tipoMovimento)
    {

        $CREDITO = 2;
        $DEBITO = 1;
        $movimentosItems = new MovimentoItems();

        if ($tipoMovimento == $CREDITO) {
            $codigoTipoMovimento = $CREDITO;
            $movimentosItems->Valor = $notaCreditoOuDebito->valor_credito;
        } else if ($tipoMovimento == $DEBITO) {
            $codigoTipoMovimento = $DEBITO;
            $movimentosItems->Valor = $notaCreditoOuDebito->valor_debito;
        }


        $movimentosItems->CodigoConta = $this->getSubContaContsys($notaCreditoOuDebito);
        $movimentosItems->CodigoTipoMovimento = $codigoTipoMovimento;
        $movimentosItems->OBS = $notaCreditoOuDebito->descricao;
        $movimentosItems->CodigoMoeda = 1; //moeda kz
        $movimentosItems->Cambio = 1;
        $movimentosItems->CodigoMovimento = $movimentos->Codigo;
        $movimentosItems->CodigoContaDebito = 1;
        $movimentosItems->CodigoContaCredito = 1;
        $movimentosItems->save();
    }

    public function getUtilizadorContsysId($empresaId, $userId)
    {
        $userContsys = DB::connection('mysql3')->table('utilizadores')->where('UserId', $userId)->where('empresa_id', $empresaId)->first();
        return $userContsys->Codigo;
    }
    public function getSubContaContsys($dataCliente)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador()['empresa'];

        $empresaContsys = DB::connection('mysql3')->table('empresas')->where('referenciaEmpresa', $empresa['referencia'])->first();
        $subContaContsys = DB::connection('mysql3')->table('subcontas')->where('codigoCliente', $dataCliente->cliente_id)->where('CodEmpresa', $empresaContsys->Codigo)->first();
        return $subContaContsys->Codigo;
    }

    public function getEmpresaContsysId($dataEmpresa)
    {

        $empresa = DB::connection('mysql2')->table('empresas')->where('id', $dataEmpresa->empresa_id)->first();
        $empresaContsys = DB::connection('mysql3')->table('empresas')->where('referenciaEmpresa', $empresa->referencia)->first();
        return $empresaContsys->Codigo;
    }

    public function imprimirNotaCredito($idNotaCredito, $viaImpressao = NULL)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'notaCredito',
                'report_jrxml' => 'notaCredito.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    'notaCreditoId' =>(int) $idNotaCredito,
                    'logotipo' => $caminho
                ]

            ]
        );
    }


    public function imprimirTodasNotaCredito()
    {
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'todasNotaCredito',
                'report_jrxml' => 'todasNotaCredito.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    'logotipo' => $caminho
                ]

            ]
        );
    }

    public function salvarNotaDebito(Request $request)
    {




        $notaDebito = new NotaDebito();


        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {

                return view('admin.dashboard');
            }
        }
        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            $empresa = Empresa::where('user_id', Auth::user()->id)->first();
            $operador = Auth::user()->id;
            $tipo_user_id = 2; //tipo empresa

        } else {
            $empresa_id = Auth::user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
            $operador = Auth::user()->id;
            $tipo_user_id = 3; //tipo funcionario

        }

        //Pega o ultimo recibo
        $ultimaNotaDebito = DB::connection('mysql2')->table('notas_debito_clientes')->where('empresa_id', $empresa_id)->orderBy('id', 'DESC')->limit(1)->first();

        $hashAnterior = "";
        if ($ultimaNotaDebito) {
            $data_notaDebito = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaNotaDebito->created_at);
            $hashAnterior = $ultimaNotaDebito->created_at;
        } else {
            $data_notaDebito = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        //Manipulação de datas: data actual
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        //dd($ultimaNotaCredito);


        /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/

        if ($data_notaDebito->diffInYears($datactual) == 0) {

            if ($ultimaNotaDebito) {
                $data_notaDebito = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaNotaDebito->created_at);
                $numSequenciaNotaDebito = intval($ultimaNotaDebito->numSequenciaNotaDebito) + 1;
            } else {
                $data_notaDebito = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaNotaDebito = 1;
            }
        } else if ($data_notaDebito->diffInYears($datactual) > 0) {
            $numSequenciaNotaDebito = 1;
        }


        $numeracaoNotaDebito = 'ND ' . mb_strtoupper(substr($empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaNotaDebito; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);



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

        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoNotaDebito . ';' . number_format($request['valor_debito'], 2, ".", "") . ';' . $hashAnterior;


        // dd($plaintext);

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);



        $this->validate($request, [
            'descricao' => ['required', 'min:2', 'max:255'],
            'cliente_id' => ['required'],
            'valor_debito' => ['required'],
        ]);

        $notaDebito->cliente_id = $request->cliente_id;
        $notaDebito->empresa_id = $empresa_id;
        $notaDebito->numeracaoNotaDebito = 'ND ' . mb_strtoupper(substr($empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaNotaDebito;
        $notaDebito->valor_debito = $request->valor_debito;
        $notaDebito->valor_extenso = $request->valor_extenso;
        $notaDebito->descricao = $request->descricao;
        $notaDebito->numSequenciaNotaDebito = $numSequenciaNotaDebito;
        $notaDebito->user_id = $operador;
        $notaDebito->tipo_user_id = $tipo_user_id;
        $notaDebito->nome_do_cliente = $request->nome_do_cliente;
        $notaDebito->telefone_cliente = $request->telefone_cliente;
        $notaDebito->nif_cliente = $request->nif_cliente;
        $notaDebito->email_cliente = $request->email_cliente;
        $notaDebito->endereco_cliente = $request->endereco_cliente;
        $notaDebito->conta_corrente_cliente = $request->conta_corrente_cliente;
        $notaDebito->save();

        NotaDebito::where('id', $notaDebito->id)->limit(1)->update(['hash' => base64_encode($signaturePlaintext)]); //Actualiza sempre o Hash da última factura


        $viaImpressao = 1; // 1- via impressão


        if ($notaDebito) {
            $hash = base64_encode($signaturePlaintext);
            $tipoMovimento = 1;
            $movimento = $this->salvarMovimentosContsys($notaDebito, $hash, $tipoMovimento);
            $this->cadastrarMovimentosItems($notaDebito, $movimento, $tipoMovimento);
            return $this->imprimirNotaDebito($notaDebito->id, $viaImpressao);
        }

        //return response()->json($notaDebito, 200);
    }
    public function imprimirNotaDebito($idDebito, $viaImpressao = NULL)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'notaDebito',
                'report_jrxml' => 'notaDebito.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    'notaDebitoId' => $idDebito,
                    'logotipo' => $caminho
                ]

            ]
        );
    }
    public function imprimirTodasNotaDebito()
    {
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'todasNotaDebito2',
                'report_jrxml' => 'todasNotaDebito2.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    'logotipo' => $caminho
                ]

            ]
        );
    }

    public function listarNotaCredito()
    {

        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $notaCredito = NotaCredito::with('cliente')->where('empresa_id', $empresa_id)->get();

        return response()->json($notaCredito, 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function comparaDataDocumentoAnteriorComAtual()
    {

        if (isset($_GET['tabela']) && !empty($_GET['tabela'])) {
            $tabela = $_GET['tabela'];
        }
        $verificadorDocumento = new VerificadorDocumento($tabela);
        if (!$verificadorDocumento->comparaDataDocumentoAnteriorComActual()) {
            return [
                $this->confirm('Existe um documento com data superior á data actual', [
                    'showConfirmButton' => 'OK',
                    'showCancelButton' => false

                ])
               
            ];
        }

        return ["status" => 200];
    }
    public function emitirRecibo(Request $request)
    {

        $recibo = new Recibos();

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {

                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            $empresa = Empresa::where('user_id', Auth::user()->id)->first();
            $tipo_user_id = 2; //empresa
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
            $tipo_user_id = 3; //funcionario
        }

        $verificadorDocumento = new VerificadorDocumento('facturas');
        if (!$verificadorDocumento->comparaDataDocumentoAnteriorComActual()) {
            return [
                $this->confirm('Existe um documento com data superior á data actual', [
                    'showConfirmButton' => 'OK',
                    'showCancelButton' => false

                ])
               
            ];
        }



        $recibo = new Recibos();

        //Pega o ultimo recibo
        $ultimoRecibo = DB::connection('mysql2')->table('recibos')->where('empresa_id', $empresa_id)->orderBy('id', 'DESC')->limit(1)->first();

        /**
         * hashAnterior inicia vazio
         */
        $hashAnterior = "";
        if ($ultimoRecibo) {

            $data_recibo = Carbon::createFromFormat('Y-m-d H:i:s', $ultimoRecibo->created_at);
            $hashAnterior = $ultimoRecibo->hash;
        } else {
            $data_recibo = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        //Manipulação de datas: data actual
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/

        if ($data_recibo->diffInYears($datactual) == 0) {

            if ($ultimoRecibo) {
                $data_recibo = Carbon::createFromFormat('Y-m-d H:i:s', $ultimoRecibo->created_at);
                $numSequenciaRecibo = intval($ultimoRecibo->numSequenciaRecibo) + 1;
            } else {
                $data_recibo = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaRecibo = 1;
            }
        } else if ($data_recibo->diffInYears($datactual) > 0) {
            $numSequenciaRecibo = 1;
        }

        $numeracaoFactura = 'RC ' . mb_strtoupper(substr($empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaRecibo; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);



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

        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoFactura . ';' . number_format($request['valor_total_entregue'], 2, ".", "") . ';' . $hashAnterior;


        // dd($plaintext);

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);

        $recibo->cliente_id = $request['cliente']['id'];
        $recibo->valor_total_entregue = $request['valor_total_entregue'];
        $recibo->observacao = $request['observacao'];
        $recibo->total_retencao = $request['total_retencao'];
        $recibo->taxa = $request['taxa'];
        $recibo->valor_extenso = $request['valor_extenso'];
        $recibo->forma_pagamento_id = $request['forma_pagamento_id'];
        $recibo->anulado = 1; //não anulado
        $recibo->user_id = Auth::user()->id;
        $recibo->tipo_user_id = $tipo_user_id;
        $recibo->numeracao_recibo = 'RC ' . mb_strtoupper(substr($empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaRecibo;
        $recibo->numSequenciaRecibo = $numSequenciaRecibo;
        $recibo->empresa_id = $empresa_id;

        $recibo->nome_do_cliente = $request['nome_do_cliente'];
        $recibo->telefone_cliente = $request['telefone_cliente'];
        $recibo->nif_cliente = $request['nif_cliente'];
        $recibo->email_cliente = $request['email_cliente'];
        $recibo->endereco_cliente = $request['email_cliente'];
        $recibo->conta_corrente_cliente = $request['conta_corrente_cliente'];
        $recibo->save();

        Recibos::where('id', $recibo->id)->limit(1)->update(['hash' => base64_encode($signaturePlaintext)]); //Actualiza sempre o Hash da última factura

        $total_retencao = 0;

        $hash = $recibo->hash;
        foreach ($request->all()['reciboItem'] as $key => $value) {
            # code...
            $reciboItem = new RecibosItem();

            $reciboItem->recibo_id = $recibo->id;
            $reciboItem->factura_id = $value['factura_id'];
            $reciboItem->valor_entregue = $value['valor_entregue'];
            $reciboItem->retencao = $value['retencao'];
            $reciboItem->borderoux = $value['borderoux'];
            $reciboItem->empresa_id = $empresa_id;
            $reciboItem->descricao = "Liquidação da factura " . $value['factura_numeracao'];
            $reciboItem->save();


            if ($reciboItem) {
                $facturaReferencia = $value['factura_numeracao'];
                $movimento = $this->salvarMovimentosContsysRecibo($reciboItem, $facturaReferencia, $hash, $recibo);
                $this->cadastrarMovimentosItemsRecibo1($recibo, $reciboItem, $movimento);
                $this->cadastrarMovimentosItemsRecibo2($recibo, $reciboItem, $movimento);
            }

            //Atualizar o status da factura depois de debitar a factura

            //Pega o valor a pagar da factura
            $valorPagar = $this->valorPagarFacura($value['factura_id'], $empresa_id);

            //Pega o valor total entregue do recibo
            $TotalEntregueRecibo = $this->TotalEntregueRecibo($value['factura_id'], $empresa_id);


            //calcular o valor faltante
            $pagoTodaFactura = $valorPagar['valor_a_pagar'] - $TotalEntregueRecibo;

            if ($pagoTodaFactura == 0) {
                //atualiza o statu da factura como pago
                Factura::where('empresa_id', $empresa_id)
                    ->where('id', $value['factura_id'])
                    ->where('tipo_documento', 2)
                    ->update(['statusFactura' => 2]); //status pago
            }
        }

        $viaImpressao = 1; // 1- via impressão
        if ($recibo) {
            return $this->imprimirRecibo($recibo->id, $viaImpressao);
        }
    }
    public function cadastrarMovimentosItemsRecibo1($recibo, $reciboItem, $movimento)
    {

        // $CREDITO = 2;
        $DEBITO = 1;
        $movimentosItems = new MovimentoItems();
        $movimentosItems->CodigoConta = 338; //conta BFA
        $movimentosItems->CodigoTipoMovimento = $DEBITO;
        $movimentosItems->Valor = $reciboItem->valor_entregue;
        $movimentosItems->OBS = $reciboItem->descricao;
        $movimentosItems->CodigoMoeda = 1; //moeda kz
        $movimentosItems->Cambio = 1;
        $movimentosItems->CodigoMovimento = $movimento->Codigo;
        $movimentosItems->CodigoContaDebito = 1;
        $movimentosItems->CodigoContaCredito = 1;
        $movimentosItems->save();
    }
    public function cadastrarMovimentosItemsRecibo2($recibo, $reciboItem, $movimento)
    {

        $CREDITO = 2;
        $movimentosItems = new MovimentoItems();
        $movimentosItems->CodigoConta = $this->getSubContaContsys($recibo);
        $movimentosItems->CodigoTipoMovimento = $CREDITO;
        $movimentosItems->Valor = $reciboItem->valor_entregue;
        $movimentosItems->OBS = $reciboItem->descricao;
        $movimentosItems->CodigoMoeda = 1; //moeda kz
        $movimentosItems->Cambio = 1;
        $movimentosItems->CodigoMovimento = $movimento->Codigo;
        $movimentosItems->CodigoContaDebito = 1;
        $movimentosItems->CodigoContaCredito = 1;
        $movimentosItems->save();
    }

    public function salvarMovimentosContsysRecibo($reciboItem, $facturaReferencia, $hash, $recibo)
    {

        $movimento = new Movimento();
        $movimento->DataMovimento = $reciboItem->created_at;
        $movimento->Descricao = $reciboItem->descricao;
        $movimento->CodigoUtilizador = $this->getUtilizadorContsysId($reciboItem->empresa_id, $recibo->user_id);
        $movimento->CodEmpresa = $this->getEmpresaContsysId($reciboItem);
        $movimento->AnoFinanceiro = date("Y");
        $movimento->CodigoStatus = 1;
        $movimento->CodigoContaDebito = 0;
        $movimento->CodigoContaCredito = 0;
        $movimento->CodigoCentroCusto = 1;
        $movimento->CodigoFactura = $facturaReferencia;
        $movimento->TipoMovimento = "RECIBO";
        $movimento->telefoneCliente = $recibo->telefone_cliente;
        $movimento->nifCliente = $recibo->nif_cliente;
        $movimento->NomeCliente = $recibo->nome_do_cliente;
        $movimento->morada = $recibo->endereco_cliente;
        $movimento->TipoDocumento = 1;
        $movimento->hash = $hash;
        $movimento->forma = 1;
        $movimento->save();
        return $movimento;
    }


    public function imprimirRecibo($reciboId, $viaImpressao = NULL)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'reciboFacturas1',
                'report_jrxml' => 'reciboFacturas1.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    'logotipo' => $caminho,
                    'reciboId' => $reciboId,
                    'viaImpressao' => $viaImpressao
                ]

            ]
        );
    }
    public function imprimirTodasRecibos()
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'todosRecibos',
                'report_jrxml' => 'todosRecibos.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    'logotipo' => $caminho
                ]

            ]
        );
    }


    public function TotalEntregueRecibo($idFactura, $empresa_id)
    {

        $TotalEntregue = RecibosItem::where('empresa_id', $empresa_id)
            ->where('factura_id', $idFactura)
            ->sum('valor_entregue');

        return $TotalEntregue;
    }

    public function valorPagarFacura($idFactura, $empresa_id)
    {

        $valorPagar = Factura::where('empresa_id', $empresa_id)->where('id', $idFactura)
            ->select('valor_a_pagar')
            ->where('tipo_documento', 2)->first();


        return $valorPagar;
    }

    public function listarTotalReciboItem()
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {

                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $totalValorEntregue = DB::connection('mysql2')->table('recibos_items')->where('empresa_id', $empresa_id)->sum('valor_entregue');


        return response()->json($totalValorEntregue, 200);
    }




    public function createRecibo()
    {


        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        $data['guard'] = $empresa['guard'];
        $PAGT_CREDITO = 2;

        $data['formapagamentos'] = DB::connection('mysql2')->table('formas_pagamentos_geral')->where('id', '!=', $PAGT_CREDITO)->get();

        return view('empresa.operacao.depositoReciboCreate', $data);
    }


    public function ListarClientesComFacturasRecibo()
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {

                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }



        $clientesFacturas = Cliente::where('clientes.diversos', 'Não')
            ->select('clientes.id')
            ->join('facturas', 'clientes.id', '=', 'facturas.cliente_id')
            ->where('clientes.empresa_id', $empresa_id)->where('facturas.anulado', 1)
            ->get();

        $clientesFacturaRecibo = Cliente::select('clientes.id')
            ->join('facturas', 'clientes.id', '=', 'facturas.cliente_id')
            ->where('clientes.empresa_id', $empresa_id)->where('facturas.anulado', 1)
            ->get();



        $clientesRecibos = Cliente::where('clientes.diversos', 'Não')
            ->select('clientes.id')
            ->join('recibos', 'clientes.id', '=', 'recibos.cliente_id')
            ->where('clientes.empresa_id', $empresa_id)->where('recibos.anulado', 1)
            ->get();


        $arrayIds = array();

        foreach ($clientesFacturas as $key => $ft) {
            array_push($arrayIds, $ft->id);
        }
        foreach ($clientesRecibos as $key => $rc) {
            array_push($arrayIds, $rc->id);
        }
        foreach ($clientesFacturaRecibo as $key => $ftRecibo) {
            array_push($arrayIds, $ftRecibo->id);
        }


        $collection = collect($arrayIds);
        $array = $collection->unique();


        //lista clientes com facturas e com recibos que não estão anulados
        $clientes = Cliente::where('clientes.empresa_id', $empresa_id)
            ->whereIn('id', $arrayIds)
            ->get();


        //   dd($clientes);



        // return $array;


        // dd($clientes);



        // ->where('facturas.anulado', 1)
        // ->where('clientes.empresa_id', $empresa_id)
        // ->orwhere(function ($query) use ($empresa_id) {
        //     $query->orWhere('recibos.anulado', 1);
        // })->get();

        // dd($clientes);

        // $array = array();

        // foreach($clientes as $key=>$cliente){

        //     dd($cliente);

        // }





        // //Lista apenas facturas
        // $clienteComFacturaOuReciboAnular = Factura::with('cliente')->where('anulado',1)->where('statusFactura', 1)->where('tipo_documento', 2)->where('empresa_id', $empresa_id)->get();

        // dd( $clienteComFacturaOuReciboAnular);
        // if(!$clienteComFacturaOuReciboAnular){

        //     $clienteComFacturaOuReciboAnular = Recibos::with('cliente')->where('anulado',1)->where('empresa_id', $empresa_id)->get();

        // }

        // dd($clienteComFacturaOuReciboAnular);
        return response()->json($clientes, 200);
    }
    public function ListarClientesComFacturas()
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {

                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $data['facturas'] = Factura::with('cliente')->where('facturas.empresa_id', $empresa_id)
            ->where('anulado', 1)
            ->where('tipo_documento', 2) //tipo factura
            ->where('statusFactura', 1) //status de dívida
            ->get();

        $arrayIds = array();

        foreach ($data['facturas'] as $key => $factura) {
            array_push($arrayIds, $factura->cliente->id);
        }

        $collection = collect($arrayIds);
        $array = $collection->unique();

        //lista clientes com facturas e com recibos que não estão anulados
        $data['clientes'] = Cliente::where('clientes.diversos', 'Não')
            ->where('clientes.empresa_id', $empresa_id)
            ->whereIn('id', $array)
            ->get();

        return response()->json($data, 200);
    }

    public function rectificacaoFacturaIndex(FacturaRepositorio $facturaRepositorio)
    {

        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        $data['guard'] = $empresa['guard'];

        $data['facturas'] = NotaCredito::with(['tipoDocumento', 'factura'])
            ->where('retificado', "Sim")
            ->where('empresa_id', $empresa['empresa']['id'])
            ->where(function ($query) {
                $query->where('tipo_documento', 1)
                    ->orWhere('tipo_documento', 2);
            })
            ->get();

        $data['status'] = Statu::all();

        return view('empresa.operacao.rectificacaoFacturaIndex', $data);
    }
    public function anulacaoFacturaIndex()
    {


        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ( $infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        $data['guard'] = $empresa['guard'];

        $data['documentosAnulados'] = NotaCredito::with(['cliente', 'tipoDocumento'])
        ->where('tipoNotaCredito', 2)
        ->where('empresa_id', $empresa['empresa']['id'])
        ->get();

        // dd($data);
        return view('empresa.operacao.anulacaoFacturaIndex', $data);
    }
    
    public function criarRectificacaoFactura()
    {

        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        $data['guard'] = $empresa['guard'];
        return view('empresa.operacao.rectificacaoFacturaCreate', $data);
    }
    public function criarAnulacaoFactura()
    {


        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ( $infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['guard'] = $empresa['guard'];

        return view('empresa.operacao.anulacaoFacturaCreate', $data);
    }
    public function criarAnulacaoRecibo()
    {


        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ( $infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['guard'] = $empresa['guard'];

        return view('empresa.operacao.anulacaoReciboCreate', $data);
    }
    public function listarTipoDocumentos()
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {

                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }


        //Lista apenas facturas, factura recibo e recibo
        $facturas = TipoDocumento::whereIn('id', array(1, 2, 6))->get();

        return response()->json($facturas, 200);
    }

    public function listarFacturasRefDocumentoEcliente($tipoDocumento, $idCliente)
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {

                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $facturas = Factura::where('tipo_documento', $tipoDocumento)->where('retificado', "Não")->where('anulado', 1)->where('cliente_id', $idCliente)->where('empresa_id', $empresa_id)->get();

        return response()->json($facturas, 200);
    }
    public function salvarDocumentoAnuladoRecibos(Request $request, FacturaRepositorio $facturaRepositorio)
    {

        //dd($request->all());
        $message = [
            'cliente_id.required' => 'É obrigatório buscar o recibo',
            'descricao.required' => 'É obrigatório a indicação do motivo da anulação'
        ];
        $this->validate($request, [
            'cliente_id' => ['required'],
            'descricao' => ['required'],
        ], $message);

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $operador = $empresa['operador'];
        $tipo_user_id = $empresa['tipo_user_id'];

        $ultimaNotaCredito = DB::connection('mysql2')->table('notas_credito')
            ->where('empresa_id', $request->empresa_id)
            ->where(function ($query) {
                $query->Where('facturaId', '!=', null)
                    ->orWhere('reciboId', '!=', null);
            })
            ->orderBy('id', 'DESC')->limit(1)->first();

        $hashAnterior = "";
        if ($ultimaNotaCredito) {
            $hashAnterior = $ultimaNotaCredito->hash;
            $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaNotaCredito->created_at);
        } else {
            $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        // //Manipulação de datas: data actual
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        // /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        // E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/

        if ($data_notaCredito->diffInYears($datactual) == 0) {

            if ($ultimaNotaCredito) {
                $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaNotaCredito->created_at);
                $numSequenciaNotaCredito = intval($ultimaNotaCredito->numSequenciaNotaCredito) + 1;
            } else {
                $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaNotaCredito = 1;
            }
        } else if ($data_notaCredito->diffInYears($datactual) > 0) {
            $numSequenciaNotaCredito = 1;
        }

        $numeracaoDocumento = 'NC ' . mb_strtoupper(substr($empresa['empresa']['nome'], 0, 3) . '' . date('Y')) . '/' . $numSequenciaNotaCredito;

        $rsa = new Crypt_RSA(); //Algoritimo RSA
        $privatekey = $facturaRepositorio->pegarChavePrivada();
        $publickey = $facturaRepositorio->pegarChavePublica();

        // Lendo a private key
        $rsa->loadKey($privatekey);

        /*Texto que deverá ser assinado com a assinatura RSA::SIGNATURE_PKCS1, e o Texto estará mais ou menos assim após as
        Concatenações com os dados preliminares da factura: 2020-09-14;2020-09-14T20:34:09;FP PAT2020/1;457411.2238438; */
        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoDocumento . ';' . number_format($request->valor_total_entregue + $request->total_retencao, 2, ".", "") . ';' . $hashAnterior;

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);
        $hash = base64_encode($signaturePlaintext);

        try {
            $notaCreditoId = DB::connection('mysql2')->table('notas_credito')->insertGetId([
                'empresa_id' => $request->empresa_id,
                'descricao' => $request->descricao,
                'cliente_id' => $request->cliente_id,
                'numSequenciaNotaCredito' => $numSequenciaNotaCredito,
                'valor_extenso' => $request->valor_extenso,
                'nome_do_cliente' => $request->nome_do_cliente,
                'user_id' => $operador,
                'tipo_user_id' => $tipo_user_id,
                'tipo_documento' => 6, //recibo
                'hash' => $hash,
                'telefone_cliente' => $request->telefone_cliente,
                'nif_cliente' => $request->nif_cliente,
                'email_cliente' => $request->email_cliente,
                'endereco_cliente' => $request->endereco_cliente,
                'conta_corrente_cliente' => $request->conta_corrente_cliente,
                'anulado' => 2, // status anulado
                'numeracaoDocumento' => $numeracaoDocumento,
                'tipoNotaCredito' => 2, //anulação
                'valor_entregue' => $request->valor_total_entregue, //anulação
                'created_at' => $datactual,
                'updated_at' => $datactual,
                'reciboId' => $request->id
            ]);

            DB::connection('mysql2')->table('recibos')->where('empresa_id', $request->empresa_id)
                ->where('id', $request->id)->update(['anulado' => 2]);
            DB::connection('mysql2')->table('recibos_items')->where('empresa_id', $request->empresa_id)
                ->where('id', $request->id)->update(['anulado' => 2]);

            //insert contsys
            $observacao = "ANULAÇÃO DO DOCUMENTO (RECIBO) Nº " . $request->numeracao_recibo;
            $valor = $request->valor_total_entregue;
            $descricao = 'ANULAÇÃO DO DOCUMENTO (RECIBO), CLIENTE: ' . $request->nome_do_cliente;


            $empresa = DB::connection('mysql2')->table('empresas')->where('id', $request->empresa_id)->first();
            $empresaContsys = DB::connection('mysql3')->table('empresas')->where('referenciaEmpresa', $empresa->referencia)->first();

            $movimentoId = DB::connection('mysql3')->table('movimentos')->insertGetId([
                "Descricao" => $descricao,
                "TipoMovimento" => "NOTA CREDITO",
                "CodigoContaDebito" => 1,
                "TipoDocumento" => 3,
                "DataMovimento" => $request->created_at,
                "CodigoUtilizador" => $this->getUtilizadorContsysId($request->empresa_id, $request->user_id),
                "CodEmpresa" => $empresaContsys->Codigo,
                "AnoFinanceiro" => date("Y"),
                "CodigoStatus" => 1,
                "CodigoContaCredito" => 0,
                "CodigoCentroCusto" => 1,
                "telefoneCliente" => $request->telefone_cliente,
                "nifCliente" => $request->nif_cliente,
                "NomeCliente" => $request->nome_do_cliente,
                "morada" => $request->endereco_cliente,
                "hash" => $hash,
                "forma" => 0
            ]);
            DB::connection('mysql3')->table('movimentos_item')->insertGetId([
                "codigoTipoMovimento" => 1,
                "Valor" => $valor,
                "CodigoConta" => $empresaContsys->Codigo,
                "OBS" => $observacao,
                "CodigoMoeda" => 1, //moeda kz
                "Cambio" => 1,
                "CodigoMovimento" => $movimentoId,
                "CodigoContaDebito" => 1,
                "CodigoContaCredito" => 1
            ]);

            $SUBCONTA_NACIONAL = 391;
            DB::connection('mysql3')->table('movimentos_item')->insertGetId([
                "codigoTipoMovimento" => 2,
                "Valor" => $valor,
                "CodigoConta" => $SUBCONTA_NACIONAL,
                "OBS" => $observacao,
                "CodigoMoeda" => 1, //moeda kz
                "Cambio" => 1,
                "CodigoMovimento" => $movimentoId,
                "CodigoContaDebito" => 1,
                "CodigoContaCredito" => 1
            ]);
            return response()->json($notaCreditoId, 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function salvarDocumentoAnuladoFacturas(Request $request, FacturaRepositorio $facturaRepositorio)
    {

        $message = [
            'cliente_id.required' => 'É obrigatório buscar a factura',
            'descricao.required' => 'É obrigatório a indicação do motivo da anulação'
        ];
        $this->validate($request, [
            'cliente_id' => ['required'],
            'descricao' => ['required'],
        ], $message);

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $operador = $empresa['operador'];
        $tipo_user_id = $empresa['tipo_user_id'];

        $ultimaNotaCredito = DB::connection('mysql2')->table('notas_credito')
            ->where('empresa_id', $request->empresa_id)
            ->where(function ($query) {
                $query->Where('facturaId', '!=', null)
                    ->orWhere('reciboId', '!=', null);
            })
            ->orderBy('id', 'DESC')->limit(1)->first();

        $hashAnterior = "";
        if ($ultimaNotaCredito) {
            $hashAnterior = $ultimaNotaCredito->hash;
            $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaNotaCredito->created_at);
        } else {
            $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        // //Manipulação de datas: data actual
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        // /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        // E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/

        if ($data_notaCredito->diffInYears($datactual) == 0) {

            if ($ultimaNotaCredito) {
                $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaNotaCredito->created_at);
                $numSequenciaNotaCredito = intval($ultimaNotaCredito->numSequenciaNotaCredito) + 1;
            } else {
                $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaNotaCredito = 1;
            }
        } else if ($data_notaCredito->diffInYears($datactual) > 0) {
            $numSequenciaNotaCredito = 1;
        }

        $numeracaoDocumento = 'NC ' . mb_strtoupper(substr($empresa['empresa']['nome'], 0, 3) . '' . date('Y')) . '/' . $numSequenciaNotaCredito;

        if ($facturaRepositorio->verificarFacturaContemRecibo($request->id)) {
            return response()->json(['isValid' => false, 'errors' => 'Sem permissão para anular, documento contém recibo'], 500);
            // return response()->json(['errors'=>"Sem permissão para anular, documento contém recibo"], 500);
        }

        $rsa = new Crypt_RSA(); //Algoritimo RSA
        $privatekey = $facturaRepositorio->pegarChavePrivada();
        $publickey = $facturaRepositorio->pegarChavePublica();

        // Lendo a private key
        $rsa->loadKey($privatekey);

        /*Texto que deverá ser assinado com a assinatura RSA::SIGNATURE_PKCS1, e o Texto estará mais ou menos assim após as
        Concatenações com os dados preliminares da factura: 2020-09-14;2020-09-14T20:34:09;FP PAT2020/1;457411.2238438; */
        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoDocumento . ';' . number_format($request->valor_a_pagar + $request->retencao, 2, ".", "") . ';' . $hashAnterior;

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);
        $hash = base64_encode($signaturePlaintext);

        try {

            $notaCreditoId = DB::connection('mysql2')->table('notas_credito')->insertGetId([

                'empresa_id' => $request->empresa_id,
                'tipoNotaCredito' => 2, //anulação
                'cliente_id' => $request->cliente_id,
                'total_preco_factura' => $request->total_preco_factura,
                'descricao' => $request->descricao,
                'numSequenciaNotaCredito' => $numSequenciaNotaCredito,
                'valor_extenso' => $request->valor_extenso,
                'nome_do_cliente' => $request->nome_do_cliente,
                'user_id' => $operador,
                'tipo_user_id' => $tipo_user_id,
                'tipo_documento' => $request->tipo_documento,
                'hash' => $hash,
                'statusFactura' => $request->statusFactura,
                'retificado' => $request->retificado,
                'tipoFolha' => $request->tipoFolha,
                'telefone_cliente' => $request->telefone_cliente,
                'nif_cliente' => $request->nif_cliente,
                'email_cliente' => $request->email_cliente,
                'endereco_cliente' => $request->endereco_cliente,
                'conta_corrente_cliente' => $request->conta_corrente_cliente,
                'nextFactura' => $request->nextFactura,
                'faturaReference' => $request->faturaReference,
                'total_incidencia' => $request->total_incidencia,
                'desconto' => $request->desconto,
                'valor_a_pagar' => $request->valor_a_pagar,
                'numeroItems' => $request->numeroItems,
                'formas_pagamento_id' => $request->formas_pagamento_id,
                'anulado' => 2, // status anulado
                'armazen_id' => $request->armazen_id,
                'retencao' => $request->retencao,
                'multa' => $request->multa,
                'valor_entregue' => $request->valor_entregue,
                'total_iva' => $request->total_iva,
                'troco' => $request->troco,
                'numeracaoDocumento' => $numeracaoDocumento,
                'data_vencimento' => $request->data_vencimento,
                'codigo_moeda' => $request->codigo_moeda,
                'retornaStock' => $request->retornarStock ? "Sim" : "Não",
                'facturaId' => $request->id,
                'created_at' => $datactual,
                'updated_at' => $datactual,
            ]);

            foreach ($request->facturas_items as $key => $facturaItem) {
                DB::connection('mysql2')->table('nota_credito_items')->insert([
                    'descricao_produto' => $facturaItem['descricao_produto'],
                    'preco_compra_produto' => $facturaItem['preco_compra_produto'],
                    'preco_venda_produto' => $facturaItem['preco_venda_produto'],
                    'quantidade_produto' => $facturaItem['quantidade_produto'],
                    'desconto_produto' => $facturaItem['desconto_produto'],
                    'incidencia_produto' => $facturaItem['incidencia_produto'],
                    'retencao_produto' => $facturaItem['retencao_produto'],
                    'iva_produto' => $facturaItem['iva_produto'],
                    'total_preco_produto' => $facturaItem['total_preco_produto'],
                    'produto_id' => $facturaItem['produto_id'],
                    'factura_id' => $facturaItem['factura_id'],
                    'codigoNotaCredito' => $notaCreditoId
                ]);

                //Voltar o produto no estoque
                if ($request->retornarStock && $facturaItem['produto']['stocavel'] == "Sim") {
                    DB::connection('mysql2')->table('existencias_stocks')->where('produto_id', $facturaItem['produto_id'])
                        ->where('armazem_id', $request->armazen_id)->where('empresa_id', $empresa['empresa']['id'])
                        ->increment('quantidade', $facturaItem['quantidade_produto']);
                }
            }
            //Actualizar o status da facturas
            DB::connection('mysql2')->table('facturas')->where('empresa_id', $request->empresa_id)
                ->where('id', $request->id)->update(['anulado' => 2]);

            //insert contsys
            $observacao = "ANULAÇÃO DO DOCUMENTO (FACTURA) Nº " . $request->numeracaoFactura;
            $valor = $request->valor_a_pagar;
            $descricao = 'ANULAÇÃO DO DOCUMENTO (FACTURA), CLIENTE: ' . $request->nome_do_cliente;

            $empresa = DB::connection('mysql2')->table('empresas')->where('id', $request->empresa_id)->first();
            $empresaContsys = DB::connection('mysql3')->table('empresas')->where('referenciaEmpresa', $empresa->referencia)->first();

            $movimentoId = DB::connection('mysql3')->table('movimentos')->insertGetId([
                "Descricao" => $descricao,
                "TipoMovimento" => "NOTA CREDITO",
                "CodigoContaDebito" => 1,
                "TipoDocumento" => 3,
                "DataMovimento" => $request->created_at,
                "CodigoUtilizador" => $this->getUtilizadorContsysId($request->empresa_id, $request->user_id),
                "CodEmpresa" => $empresaContsys->Codigo,
                "AnoFinanceiro" => date("Y"),
                "CodigoStatus" => 1,
                "CodigoContaCredito" => 0,
                "CodigoCentroCusto" => 1,
                "telefoneCliente" => $request->telefone_cliente,
                "nifCliente" => $request->nif_cliente,
                "NomeCliente" => $request->nome_do_cliente,
                "morada" => $request->endereco_cliente,
                "hash" => $hash,
                "forma" => 0
            ]);
            DB::connection('mysql3')->table('movimentos_item')->insertGetId([
                "codigoTipoMovimento" => 1,
                "Valor" => $valor,
                "CodigoConta" => $empresaContsys->Codigo,
                "OBS" => $observacao,
                "CodigoMoeda" => 1, //moeda kz
                "Cambio" => 1,
                "CodigoMovimento" => $movimentoId,
                "CodigoContaDebito" => 1,
                "CodigoContaCredito" => 1
            ]);

            $SUBCONTA_NACIONAL = 391;
            DB::connection('mysql3')->table('movimentos_item')->insertGetId([
                "codigoTipoMovimento" => 2,
                "Valor" => $valor,
                "CodigoConta" => $SUBCONTA_NACIONAL,
                "OBS" => $observacao,
                "CodigoMoeda" => 1, //moeda kz
                "Cambio" => 1,
                "CodigoMovimento" => $movimentoId,
                "CodigoContaDebito" => 1,
                "CodigoContaCredito" => 1
            ]);
            return response()->json($notaCreditoId, 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function adicionarMovimentosContsys($notaCredito, $hash, $tipoDoc, $factura, $recibo)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        DB::beginTransaction();

        try {

            if ($tipoDoc == 6) {
                $observacao = "ANULAÇÃO DO DOCUMENTO (RECIBO) Nº " . $recibo->numeracao_recibo;
                $recibo = Recibos::where('id', $notaCredito->reciboId)->where('empresa_id', $empresa['empresa']['id'])->first();
                $valor = $recibo->valor_total_entregue;
                $descricao = 'ANULAÇÃO DO DOCUMENTO (RECIBO), CLIENTE: ' . $notaCredito->nome_do_cliente;
            } else if ($tipoDoc == 2) {
                $observacao = "ANULAÇÃO DO DOCUMENTO (FACTURA) Nº " . $factura->numeracaoFactura;
                $valor = $notaCredito->valor_a_pagar;
                $descricao = 'ANULAÇÃO DO DOCUMENTO (FACTURA), CLIENTE: ' . $notaCredito->nome_do_cliente;
            }

            $movimentoId = DB::connection('mysql3')->table('movimentos')->insertGetId([

                "Descricao" => $descricao,
                "TipoMovimento" => "NOTA CREDITO",
                "CodigoContaDebito" => 1,
                "TipoDocumento" => 3,
                "DataMovimento" => $notaCredito->created_at,
                "CodigoUtilizador" => $this->getUtilizadorContsysId($notaCredito->empresa_id, $notaCredito->user_id),
                "CodEmpresa" => $this->getEmpresaContsysId($notaCredito),
                "AnoFinanceiro" => date("Y"),
                "CodigoStatus" => 1,
                "CodigoContaCredito" => 0,
                "CodigoCentroCusto" => 1,
                "telefoneCliente" => $notaCredito->telefone_cliente,
                "nifCliente" => $notaCredito->nif_cliente,
                "NomeCliente" => $notaCredito->nome_do_cliente,
                "morada" => $notaCredito->endereco_cliente,
                "hash" => $hash,
                "forma" => 0

            ]);
            DB::connection('mysql3')->table('movimentos_item')->insertGetId([
                "codigoTipoMovimento" => 1,
                "Valor" => $valor,
                "CodigoConta" => $this->getSubContaContsys($notaCredito),
                "OBS" => $observacao,
                "CodigoMoeda" => 1, //moeda kz
                "Cambio" => 1,
                "CodigoMovimento" => $movimentoId,
                "CodigoContaDebito" => 1,
                "CodigoContaCredito" => 1
            ]);

            $SUBCONTA_NACIONAL = 391;

            DB::connection('mysql3')->table('movimentos_item')->insertGetId([
                "codigoTipoMovimento" => 2,
                "Valor" => $valor,
                "CodigoConta" => $SUBCONTA_NACIONAL,
                "OBS" => $observacao,
                "CodigoMoeda" => 1, //moeda kz
                "Cambio" => 1,
                "CodigoMovimento" => $movimentoId,
                "CodigoContaDebito" => 1,
                "CodigoContaCredito" => 1
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
    public function imprimirDocumentoAnuladoFacturas($docAnuladoId)
    {
        if (isset($_GET['viaImpressao']) && !empty($_GET['viaImpressao'])) {
            $viaImpressao = $_GET['viaImpressao'];
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;
        $DIR_SUBREPORT = public_path() . "/upload/documentos/empresa/relatorios/";



        $filename = "documento_anuladoFacturas"; //filename
        $options = [
            "empresa_id" => $empresa['empresa']['id'],
            "docAnuladoId" => $docAnuladoId,
            "viaImpressao" => $viaImpressao,
            "logotipo" => $caminho,
            "DIR_SUBREPORT" => $DIR_SUBREPORT
        ]; //parametros where do report

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => $options
            ]
        );
    }

    public function imprimirDocumentoAnuladoRecibos($docAnuladoId)
    {
        if (isset($_GET['viaImpressao']) && !empty($_GET['viaImpressao'])) {
            $viaImpressao = $_GET['viaImpressao'];
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $filename = "documento_anuladoRecibo"; //filename
        $options = ["empresa_id" => $empresa['empresa']['id'], "docAnuladoId" => $docAnuladoId, "viaImpressao" => $viaImpressao, "logotipo" => $caminho]; //parametros where do report

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => $options

            ]
        );
    }
    public function imprimirDocumentoRetificado($docRetificadoId, $idFactura)
    {

        if (isset($_GET['viaImpressao']) && !empty($_GET['viaImpressao'])) {
            $viaImpressao = $_GET['viaImpressao'];
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;
        $DIR_SUBREPORT = public_path() . "/upload/documentos/empresa/relatorios/";


        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'documento_retificadoFacturas',
                'report_jrxml' => 'documento_retificadoFacturas.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    'logotipo' => $caminho,
                    'docAnuladoId' => $docRetificadoId,
                    'facturaId' => $idFactura,
                    'viaImpressao' => $viaImpressao,
                    'DIR_SUBREPORT' => $DIR_SUBREPORT
                ]

            ]
        );

        // $reportController = new ReportController();
        // return $reportController->imprimirDocumentoRetificado($docRetificadoId, $idFactura, $viaImpressao);
    }
    // public function reimprimirDocumentoRetificado($idFactura, $viaImpressao = 1)
    // {
    //     $reportController = new ReportController();
    //     return $reportController->imprimirDocumentoRetificado($idFactura, $viaImpressao = NULL);


    // }




    /*

    public function imprimirDocumentoAnulado($idDocAnulado, $tipoDocumento, $facturaId, $viaImpressao = NULL)
    {

        //dd($idDocAnulado);


        $data['viaImpressao'] = $viaImpressao;

        $TIPO_DOC_RECIBO = 6;

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {

                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        if ($tipoDocumento == $TIPO_DOC_RECIBO) { //é recibo

            //fazer aqui o relacionamento com recibo
            $data['documentoAnulado'] = AnulacaoDocumento::with(['recibo', 'cliente', 'empresa'])->where('id', $idDocAnulado)->where('empresa_id', $empresa_id)->first();

            //dd($data['documentoAnulado']);

            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdf.empresa.relatorios.documento_anuladoRecibo', $data);
            return $pdf->stream();



        } else {

            $data['documentoAnulado'] = AnulacaoDocumento::with(['factura', 'factura.facturas_items', 'factura.facturas_items.produto.tipoTaxa', 'cliente', 'empresa'])->where('id', $idDocAnulado)->where('empresa_id', $empresa_id)->first();


            // $data['docAnuladoItem'] = DB::table('produtos')
            //     ->join('tipotaxa', 'tipotaxa.codigo', '=', 'produtos.codigo_taxa')
            //     ->leftJoin('motivo', 'motivo.codigo', '=', 'produtos.motivo_isencao_id')
            //     ->join('factura_items', 'factura_items.produto_id', '=', 'produtos.id')
            //     ->join('facturas', 'facturas.id', '=', 'factura_items.factura_id')
            //     ->join('documento_anulados', 'documento_anulados.factura_id', '=', 'facturas.id')
            //     ->select(DB::raw('SUM(facturas.total_incidencia) AS total_incidencia, tipotaxa.descricao AS taxa'))
            //     ->where('documento_anulados.empresa_id', $empresa_id)
            //     ->where('documento_anulados.id', $idDocAnulado)
            //     ->groupBy('codigo_taxa')
            //     ->get();

                $data['facturaTaxa'] = DB::select('
                SELECT motivo.codigoMotivo AS motivoCodigo, tipotaxa.descricao,motivo.descricao AS motivoDescricao,SUM(factura_items.incidencia_produto) AS total_incidencia,SUM(factura_items.iva_produto) AS total_iva,factura_items.factura_id from facturas INNER JOIN factura_items ON factura_items.factura_id = facturas.id
                INNER JOIN produtos ON factura_items.produto_id = produtos.id
                INNER JOIN tipotaxa ON tipotaxa.codigo = produtos.codigo_taxa
                INNER JOIN motivo ON tipotaxa.codigoMotivo = motivo.codigo WHERE facturas.id = "'.$facturaId.'" AND facturas.empresa_id = "'.$empresa_id.'" GROUP BY tipotaxa.codigo
                ');


               // dd($data['facturaTaxa']);


            $pdf = App::make('dompdf.wrapper');
            $pdf->loadView('pdf.empresa.relatorios.documento_anuladoFacturas', $data);
            return $pdf->stream();
            //$users = Produto::sum('preco_venda')->groupBy('codigo_taxa')->get();


        }
    }
    */



    public function listarRecibosRecCliente($idCliente)
    {



        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {

                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $recibos = Recibos::where('cliente_id', $idCliente)->where('anulado', 1)->where('empresa_id', $empresa_id)->get();


        return response()->json($recibos, 200);
    }
    public function verificaAplicacaoRetencaoRecibo($facturaId)
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {

                return view('admin.dashboard');
            }
        }
        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $dadosRetencao = RecibosItem::select('retencao')->where('factura_id', $facturaId)->where('empresa_id', $empresa_id)->get();

        $return = false;

        for ($i = 0; $i < count($dadosRetencao); $i++) {

            if ($dadosRetencao[$i]->retencao > 0) {
                $return = true;
                //return ;
            }
        }

        return response()->json($return, 200);
    }

    public function ListarClientesFacturasComFaturaRecibo()
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }
        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }
        $clientesFacturas = Cliente::where('clientes.diversos', 'Não')
            ->select('clientes.id')
            ->join('facturas', 'clientes.id', '=', 'facturas.cliente_id')
            ->where('clientes.empresa_id', $empresa_id)->where('facturas.anulado', 1)
            ->where('facturas.retificado', "Não")
            ->get();

        $clientesFacturaRecibo = Cliente::select('clientes.id')
            ->join('facturas', 'clientes.id', '=', 'facturas.cliente_id')
            ->where('clientes.empresa_id', $empresa_id)->where('facturas.anulado', 1)
            ->where('facturas.retificado', "Não")
            ->get();

        $arrayIds = array();


        foreach ($clientesFacturas as $key => $ft) {
            array_push($arrayIds, $ft->id);
        }

        foreach ($clientesFacturaRecibo as $key => $ftRecibo) {
            array_push($arrayIds, $ftRecibo->id);
        }

        $collection = collect($arrayIds);
        $array = $collection->unique();

        //lista clientes com facturas e com recibos que não estão anulados
        $clientes = Cliente::where('clientes.empresa_id', $empresa_id)
            ->whereIn('id', $array)
            ->get();


        return response()->json($clientes, 200);
    }

    public function ListarFacturasAoSelecionarDocumento($idCliente, $tipoDocumento)
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }
        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }


        $facturas = Factura::where('empresa_id', $empresa_id)->where('retificado', "Não")->where('anulado', 1)->where('tipo_documento', $tipoDocumento)->where('cliente_id', $idCliente)->get();

        return response()->json($facturas, 200);
    }


    public function voltarQtProdutoEstoque($facturaId)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $factura = DB::connection('mysql2')->table('facturas')
            ->where('empresa_id', $empresa['empresa']['id'])
            ->where('id', $facturaId)->first();

        $facturaItens = FacturaItems::with(['produto'])->where('factura_id', $factura->id)->get();
        foreach ($facturaItens as $key => $ft) {

            if ($ft->produto['stocavel'] == "Sim") {
                ExistenciaStock::where('produto_id', $ft['produto_id'])
                    ->where('armazem_id', $factura->armazen_id)->where('empresa_id', $empresa['empresa']['id'])
                    ->increment('quantidade', $ft['quantidade_produto']);
            }
        }
    }
}
