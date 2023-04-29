<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use App\Models\admin\FormaPagamento;
use App\Models\admin\Pagamento;
use App\Models\contsys\SubConta;
use App\Models\empresa\CanalComunicacao;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\EntradaStock;
use App\Models\empresa\FormaPagamentoGeral;
use App\Models\empresa\Fornecedor;
use App\Models\empresa\PagamentoFornecedor;
use App\Models\empresa\Pais;
use App\Models\empresa\Statu;
use App\Rules\Empresa\EmpresaUnique;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FornecedorController extends Controller
{
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;

    public function __construct()
    {
        //$this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;


        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $data['fornecedores'] = Fornecedor::with(['statuGeral', 'pais'])->where('empresa_id', $empresa['empresa']['id'])->get();

        $data['status'] = Statu::all();
        $data['paises'] = Pais::all();

        return view('empresa.fornecedores.index', $data);
    }

    public function pagamentoFacturaFornecedor()
    {
        $LICENCAS_ATIVO = 1;
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['guard'] = $empresa['guard'];

       
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $data['fornecedores'] = Fornecedor::with(['statuGeral', 'pais'])->where('empresa_id', $empresa['empresa']['id'])->get();
        $data['pagamentofornecedor'] = PagamentoFornecedor::with(['statuGeral', 'entradaProduto', 'fornecedor'])->where('empresa_id', $empresa['empresa']['id'])->get();
        $data['pagamentos'] = FormaPagamentoGeral::get();

        return view('empresa.fornecedores.pagamentoFactura', $data);
    }

    public function listarFornecedores()
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['fornecedores'] = Fornecedor::with(['statuGeral', 'pais'])->where('empresa_id', $empresa['empresa']['id'])->get();

        return response()->json($data, 200);
    }
    public function listarFacturasFornecedores($fornecedorId)
    {

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $CREDITO = 2;
        $data['facturas'] = EntradaStock::where('fornecedor_id', $fornecedorId)->where('empresa_id', $empresa['empresa']['id'])->where('statusPagamento', $CREDITO)->get();

        return response()->json($data, 200);
    }
    public function listarPagamentosFacturasFornecedores()
    {

        if (isset($_GET['nFactura']) && isset($_GET['fornecedorId'])) {
            $nFactura = $_GET['nFactura'];
            $fornecedorId = $_GET['fornecedorId'];
        }

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $data['pagamentoEfecturados'] = PagamentoFornecedor::where('empresa_id', $empresa['empresa']['id'])
            ->where('fornecedor_id', $fornecedorId)
            ->where('nFactura', $nFactura)
            ->get();
        return response()->json($data, 200);
    }
    public function pagamentoFornecedor(Request $request)
    {

        //dd($request->all());
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $STATUS_ATIVO = 1;


        $mensagem = [
            "nFactura.required" => "É obrigatório a indicação de um valor para o campo número da factura",
            "formaPagamentoId.required" => "É obrigatório a indicação de um valor para o campo forma pagamento",
            "fornecedor_id.required" => "É obrigatório a indicação de um valor para o campo fornecedor",
            "nextPagamento.required" => "É obrigatório a indicação de um valor para o campo número do recibo",
            "nextPagamento.unique" => "O valor indicado para o campo Nº Recibo já se encontra registado",
            "conta_fornecedor.required" => "É obrigatório a indicação de um valor para o campo conta corrente",
            "valor.required" => "É obrigatório a indicação de um valor para o campo valor entregue"
        ];
        $this->validate($request, [
            'valor' => ['required', 'numeric'],
            'formaPagamentoId' => ['required'],
            'fornecedor_id' => ['required'],
            'conta_fornecedor' => ['required'],
            'nFactura' => ['required'],
            'nextPagamento' => ['required', new EmpresaUnique('pagamento_fornecedor', 'mysql2')],
            'valor' => ['required', function ($attribute, $value, $fail) use ($request) {
                if ($value <= 0) {
                    $fail('É obrigatório a indicação de um valor para o campo valor entregue');
                }
                if ($value > $request->divida) {
                    $fail('O valor entregue não deve ser maior que dívida');
                }
            }]
        ], $mensagem);

        if ($this->pagouNaTotalidade($request->divida, $request->valor)) {
            $this->actualizarDividaPagoTotal($request, $empresa);
        }

        $pagamentoFornecedor = new PagamentoFornecedor();
        $pagamentoFornecedor->dataPagamento = Carbon::now();
        $pagamentoFornecedor->valor = $request->valor;
        $pagamentoFornecedor->formaPagamentoId = $request->formaPagamentoId;
        $pagamentoFornecedor->entrada_produto_id = $request->entrada_produto_id;
        $pagamentoFornecedor->conta_fornecedor = $request->conta_fornecedor;
        $pagamentoFornecedor->fornecedor_id = $request->fornecedor_id;
        $pagamentoFornecedor->user_id = $empresa['operador'];
        $pagamentoFornecedor->tipo_user_id = $empresa['tipo_user_id'];
        $pagamentoFornecedor->nFactura = $request->nFactura;
        $pagamentoFornecedor->status_id = $STATUS_ATIVO;
        $pagamentoFornecedor->nextPagamento = $request->nextPagamento;
        $pagamentoFornecedor->empresa_id = $empresa['empresa']['id'];
        $pagamentoFornecedor->save();

        //return $this->imprimirPagamentoFornecedor($pagamentoFornecedor->id, 1);

        return response()->json($pagamentoFornecedor, 200);
    }
    public function imprimirFornecedores()
    {
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'fornecedores',
                'report_jrxml' => 'fornecedores.jrxml',
                'report_parameters' => [
                    "diretorio" =>  $caminho,
                    "empresa_id" =>  $empresa['empresa']['id'],
                ]
            ]
        );
    }
    public function imprimirPagamentoFornecedor($pagamentoFornecedorId, $viaImpressao)
    {

        // if($_GET['viaImpressao'] && !empty($_GET['viaImpressoa'])){
        //     $viaImpressao = $_GET['viaImpressao'];
        // }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'pagamentoFornecedor',
                'report_jrxml' => 'pagamentoFornecedor.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    "viaImpressao" => $viaImpressao,
                    'logotipo' => $caminho,
                    'pagamentoId' => $pagamentoFornecedorId
                ]

            ]
        );

        // $reportController = new ReportController();
        // return $reportController->imprimirPagamentoFornecedor($pagamentoFornecedorId, $viaImpressao);
    }

    public function pagouNaTotalidade($divida, $valorEntregue)
    {
        return $divida == $valorEntregue;
    }

    public function actualizarDividaPagoTotal($request, $empresa)
    {
        $STATUS_PAGO = 1;
        $entradaStock = EntradaStock::where('fornecedor_id', $request->fornecedor_id)
            ->where('id', $request->entrada_produto_id)->where('empresa_id', $empresa['empresa']['id'])->first();
        $entradaStock->statusPagamento = $STATUS_PAGO;
        $entradaStock->save();
    }
    public function buscarDividaRestante($entradaProdutoId, $fornecedorId)
    {
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $totalPago = PagamentoFornecedor::where('fornecedor_id', $fornecedorId)
            ->where('entrada_produto_id', $entradaProdutoId)->where('empresa_id', $empresa['empresa']['id'])->sum('valor');
        return response()->json($totalPago, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }


        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $telefone_contacto = preg_replace("/[^A-Za-z0-9]+/", "", $request->telefone_contacto);
        $telefone_empresa = preg_replace("/[^A-Za-z0-9]+/", "", $request->telefone_empresa);

        $data_contracto = date_format(date_create($request->data_contracto), 'Y-m-d');

        $mensagem = [
            'endereco.required' => 'É obrigatório a indicação de um valor para o campo endereço'
        ];

        $this->validate($request, [

            'nome' => ['required', 'string', 'max:255', 'min:5'],
            'telefone_empresa' => ['required', 'digits:9', new EmpresaUnique('fornecedores', 'mysql2')],
            'email_empresa' => ['required', 'email', 'max:255', new EmpresaUnique('fornecedores', 'mysql2')],
            'nif' => ['required', 'string', 'max:14', new EmpresaUnique('fornecedores', 'mysql2')],
            'telefone_empresa' => ['required', new EmpresaUnique('fornecedores', 'mysql2')],
            'pessoal_contacto' => ['required', 'string', 'max:255'],
            'telefone_contacto' => ['required', new EmpresaUnique('fornecedores', 'mysql2')],
            'email_contacto' => ['required', 'email', 'max:255', new EmpresaUnique('fornecedores', 'mysql2')],
            'status_id' => ['required', 'numeric'],
            'data_contracto' => ['required'],
            'endereco' => ['required'],
            'pais_nacionalidade_id' => ['required', 'numeric'],

        ], $mensagem);


        $empresaContsysId = $this->buscarEmpresaContsysId($empresa['empresa']);
        $contaCorrente = $this->buscarContaCorrente($empresaContsysId);

        DB::beginTransaction();

        try {
            $fornecedorId = DB::connection('mysql2')->table('fornecedores')->insertGetId([
                'nome' => $request->nome,
                'telefone_empresa' => $telefone_empresa,
                'email_empresa' => $request->email_empresa,
                'nif' => $request->nif,
                'website' => $request->website,
                'pessoal_contacto' => $request->pessoal_contacto,
                'telefone_contacto' => $telefone_contacto,
                'email_contacto' => $request->email_contacto,
                'status_id' => $request->status_id,
                'endereco' => $request->endereco,
                'data_contracto' => $data_contracto,
                'conta_corrente' => $contaCorrente,
                'pais_nacionalidade_id' => $request->pais_nacionalidade_id,
                'user_id' => $empresa['operador'],
                'tipo_user_id' => 2, //empresa
                'canal_id' => 2, // canal do cliente
                'empresa_id' => $empresa['empresa']['id']
            ]);


            $CONTA_ATIVO = 3;
            $CONTA_TIPO_FORNECEDOR = 17;


            $utilizador = DB::connection('mysql3')->table('utilizadores')
                ->where('email', Auth::user()->email)
                ->where('empresa_id', $empresa['empresa']['id'])->first();

            DB::connection('mysql3')->table('subcontas')->insertGetId([
                'Numero' => $contaCorrente,
                'Descricao' => $request->nome,
                'CodConta' => $CONTA_TIPO_FORNECEDOR,
                'CodUtilizador' => $utilizador->Codigo,
                'DataCadastro' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
                'CodTipoConta' => $CONTA_ATIVO,
                'CodEmpresa' => $empresaContsysId,
                'Movimentar' => "SIM",
                'codigoFornecedor' => $fornecedorId
            ]);

            DB::commit();
            // $this->cadastrarSubContaContsys($data);
            //  return response()->json($fornecedorId, 200);
        } catch (\Exception $th) {
            DB::rollBack();
            return redirect()->back()->withErrors("Erro ao cadastrar fornecedor");
        }
    }
    public function buscarEmpresaContsysId($empresa)
    {
        return DB::connection('mysql3')->table('empresas')->where('referenciaEmpresa', $empresa->referencia)->first()->Codigo;
    }
    public function buscarContaCorrente($empresaId)
    {
        $CONTA_TIPO_FORNECEDOR = 17;
        $resultado =  DB::connection('mysql3')->table('subcontas')->orderBy('Codigo', 'DESC')
            ->where('CodConta', $CONTA_TIPO_FORNECEDOR)
            ->where('CodEmpresa', $empresaId)->limit(1)->first();

        if ($resultado) {
            $array = explode('.', $resultado->Numero);
            $ultimoElemento = (int) end($array);
            array_pop($array);
            $ultimoElemento++;
            array_push($array, (string)$ultimoElemento);
            $contaCorrente = implode(".", $array);
        } else {
            $contaCorrente = "32.1.2.1.1";
        }

        return $contaCorrente;
    }
    public function cadastrarSubContaContsys($data)
    {


        $subConta = new SubConta();
        $subConta->Numero = $data['Numero'];
        $subConta->Descricao = $data['Descricao'];
        $subConta->CodConta = $data['CodConta'];
        $subConta->CodUtilizador = $data['CodUtilizador'];
        $subConta->DataCadastro = $data['DataCadastro'];
        $subConta->CodTipoConta = $data['CodTipoConta'];
        $subConta->CodEmpresa = $data['CodEmpresa'];
        $subConta->Movimentar = $data['Movimentar'];
        $subConta->codigoFornecedor = $data['codigoFornecedor'];
        $subConta->save();

        return response()->json($subConta, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        $id = base64_decode($id);

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $fornecedor = Fornecedor::where('id', $id)->where('empresa_id', $empresa_id)->first();

        if (!$fornecedor) {
            return redirect()->back();
        }


        $data['fornecedor'] = Fornecedor::findOrfail($fornecedor->id);

        $data['fornecedor'] = Fornecedor::find($id);
        $data['canalComunicacao'] = CanalComunicacao::all();
        $data['status'] = Statu::all();
        $data['paises'] = Pais::all();

        return view('empresa.fornecedores.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $telefone_contacto = preg_replace("/[^A-Za-z0-9]+/", "", $request->telefone_contacto);
        $telefone_empresa = preg_replace("/[^A-Za-z0-9]+/", "", $request->telefone_empresa);




        $data_contracto = date_format(date_create($request->data_contracto), 'Y-m-d');

        $mensagem = [
            'endereco.required' => 'É obrigatório a indicação de um valor para o campo endereço'
        ];

        $this->validate($request, [
            'nome' => ['required', 'string', 'max:255', 'min:5'],
            'telefone_empresa' => ['required', 'digits:9', new EmpresaUnique('fornecedores', 'mysql2', 'id', $id)],
            'email_empresa' => ['required', 'email', 'max:255', new EmpresaUnique('fornecedores', 'mysql2', 'id', $id)],
            'nif' => ['required', 'string', 'max:14', new EmpresaUnique('fornecedores', 'mysql2', 'id', $id)],
            'telefone_empresa' => ['required', 'digits:9', new EmpresaUnique('fornecedores', 'mysql2', 'id', $id)],
            'pessoal_contacto' => ['required', 'string', 'max:255'],
            'telefone_contacto' => ['required', 'digits:9', new EmpresaUnique('fornecedores', 'mysql2', 'id', $id)],
            'email_contacto' => ['required', 'email', 'max:255', new EmpresaUnique('fornecedores', 'mysql2', 'id', $id)],
            'status_id' => ['required', 'numeric'],
            'endereco' => ['required'],
            'data_contracto' => ['required'],
            'pais_nacionalidade_id' => ['required', 'numeric']
        ], $mensagem);

        try {

            $fornecedor = Fornecedor::where('empresa_id', $request->empresa_id)->find($id);
            $fornecedor->nome = $request->nome;
            $fornecedor->telefone_empresa = $telefone_empresa;
            $fornecedor->email_empresa = $request->email_empresa;
            $fornecedor->nif = $request->nif;
            $fornecedor->website = $request->website;
            $fornecedor->pessoal_contacto = $request->pessoal_contacto;
            $fornecedor->telefone_contacto = $telefone_contacto;
            $fornecedor->email_contacto = $request->email_contacto;
            $fornecedor->status_id = $request->status_id;
            $fornecedor->data_contracto = $data_contracto;
            $fornecedor->pais_nacionalidade_id = $request->pais_nacionalidade_id;
            $fornecedor->endereco = $request->endereco;
            $fornecedor->user_id = $empresa['operador'];
            $fornecedor->tipo_user_id = $empresa['tipo_user_id'];
            $fornecedor->canal_id = 2; // canal do cliente
            $fornecedor->empresa_id = $empresa['empresa']['id'];
            $fornecedor->save();


            if ($fornecedor) {
                $empresaContsysId = $this->buscarEmpresaContsysId($empresa['empresa']);
                $this->updateFornecedorContsys($request, $empresaContsysId, $id);
                return response()->json($fornecedor, 200);
            } else {
                return response()->json('Erro ao editar o fornecedor', 200);
            }
        } catch (\Exception $th) {
            return redirect()->back()->withErrors("Erro de sistema");
        }
    }

    public function updateFornecedorContsys($request, $empresaContsysId, $codigoFornecedor)
    {
        $subConta = SubConta::where('codigoFornecedor', $codigoFornecedor)->where('CodEmpresa', $empresaContsysId)->first();
        $subConta->Descricao = $request->nome;
        $subConta->save();
        //return response()->json($subConta, 200);
    }

    // public function detalhes($id)
    // {
    //     if (Auth::guard('web')->check()) {
    //         if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
    //             return view('admin.dashboard');
    //         }
    //     }

    //     $id = base64_decode($id);

    //     if (Auth::guard('web')->check()) {
    //         $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
    //         $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
    //     } else {
    //         $empresa_id = Auth::user()->empresa_id;
    //     }

    //     $fornecedor = Fornecedor::where('id', $id)->where('empresa_id', $empresa_id)->first();

    //     if (!$fornecedor) {
    //         return redirect()->back();
    //     }

    //     $data['fornecedor'] = Fornecedor::findOrfail($fornecedor->id);

    //     $data_contrato = $data['fornecedor']['data_contracto'] ? date('d-m-Y', strtotime($data['fornecedor']['data_contracto'])) : '';
    //     $data['fornecedor']['data_contracto'] = $data_contrato;

    //     return view('empresa.fornecedores.detalhes', $data);
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $fornecedor = Fornecedor::where('empresa_id', $empresa['empresa']['id'])->find($id);
        $fornecedor->delete();

        if ($fornecedor) {
            $empresaContsysId = $this->buscarEmpresaContsysId($empresa['empresa']);
            $this->deletarFornecedorContsys($empresaContsysId, $id);
            return response()->json($fornecedor, 200);
        } else {
            return response()->json("Não é possível eliminar este Fornecedor, está a ser utilizado por uma entidade", 500);
        }
    }
    public function deletarFornecedorContsys($empresaContsysId, $fornecedorId)
    {
        $subConta = SubConta::where('codigoFornecedor', $fornecedorId)->where('CodEmpresa', $empresaContsysId)->first();
        $subConta->delete();
    }

    public function listarFornecedoresApi()
    {

        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
        }
        $data['fornecedores'] = Fornecedor::with(['statuGeral', 'pais'])->where('empresa_id', $empresa_id)->get();

        return response()->json($data, 200);
    }
}
