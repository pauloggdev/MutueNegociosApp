<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use App\Models\empresa\Armazen;
use App\Models\empresa\AtualizacaoStocks;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\ExistenciaStock;
use App\Models\empresa\Produto;
use App\Rules\Empresa\EmpresaUnique;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\Empresa\TraitEmpresaAutenticada;

class ExistenciaStockController extends Controller
{

    use VerificaSeEmpresaTipoAdmin;
    use TraitEmpresaAutenticada;
    use VerificaSeUsuarioAlterouSenha;

    public function __construct()
    {
        // $this->middleware('auth');
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

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        $data['guard'] = $empresa['guard'];

        $data['atualizacaostock'] = AtualizacaoStocks::with(['produtos', 'armazens', 'status'])->where('empresa_id', $empresa['empresa']['id'])->orderBY('id', 'DESC')->get();

        //  dd($data['atualizacaostock']);
        return view('empresa.existenciaStock.index', $data);
    }
    public function listarExistenciaStock()
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['existenciastock'] = ExistenciaStock::where('empresa_id', $empresa['empresa']['id'])->get();

        return response()->json($data, 200);
    }

    public function actualizarProdutoStockNovo()
    {

        $TIPO_FUNCIONARIO = 3;
        $TIPO_ADMIN = 2;
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        if ($empresa['tipo_user_id'] === $TIPO_FUNCIONARIO) {
            $data['router'] = "/empresa/funcionario";
            $redirecionar = "empresa/home";
        } else if ($empresa['tipo_user_id'] === $TIPO_ADMIN) {
            $data['router'] = "/empresa";
            $redirecionar = "empresa/home";
        }
        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect($redirecionar);
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }


        $data['produtos'] = Produto::with(['existenciaEstock', 'statuGeral'])->where('stocavel', 'Sim')->where('empresa_id', $empresa['empresa']['id'])->get();
        $data['armazens'] = Armazen::where('empresa_id', $empresa['empresa']['id'])->get();


        return view('empresa.operacao.actualizarStockNovo', $data);
    }
    public function listarProdutoExistenciaStock($produtoId, $armazemId)
    {
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $data = ExistenciaStock::with(['produtos', 'armazens'])
            ->where('armazem_id', $armazemId)->where('produto_id', $produtoId)
            ->where('empresa_id', $empresa_id)->first();

        return response()->json($data, 200);
    }
    public function actualizarStock(Request $request)
    {
        $OPERACAO_DIMINUIR = 1;
        $OPERACAO_ADICIONAR = 2;
        $OPERACAO_ATUALIZAR = 3;

        if (isset($_GET['operacao']) && !empty($_GET['operacao'])) {
            $operacao = $_GET['operacao'];
        }
        $message = [
            'produto_id.required' => 'É obrigatório a indicação de um valor para o campo produto',
            'armazem_id.required' => 'É obrigatório a indicação de um valor para o campo armazém',
            'quantidade_nova.required' => 'É obrigatório quantidade',
            'operacao.required' => 'É obrigatório a indicação da operação',
        ];

        $this->validate($request, [
            'produto_id' => ['required'],
            'armazem_id' => ['required'],
            'quantidade_nova' => ['numeric', 'min:0', function ($attribute, $quantidade, $fail) use ($OPERACAO_ADICIONAR, $OPERACAO_DIMINUIR, $request) {
                if ($request->quantidade_nova != 0 && $request->quantidade_nova == null) {
                    $fail('informe a quantidade em estoque');
                }
                if ($request->quantidade_antes === $request->quantidade_nova) {
                    if ($OPERACAO_DIMINUIR != $request->operacao && $OPERACAO_ADICIONAR != $request->operacao) {
                        $fail('Efectue alteração no estoque');
                    }
                }
                if ($OPERACAO_ADICIONAR == $request->operacao) {
                    if ($request->quantidade_nova === 0) {
                        $fail('sem quantidade para aumentar');
                    }
                }
                if ($OPERACAO_DIMINUIR == $request->operacao) {

                    if ($request->quantidade_nova > $request->quantidade_antes) {
                        $fail('deve mininuir uma quantidade menor ou igual a quantidade antiga');
                    } else if ($request->quantidade_nova === 0) {
                        $fail('sem quantidade para reduzir');
                    }
                }
            }],

        ], $message);

        $this->actualizarHistoricoStock($request, $operacao);
        return $this->atualizarExistenciaStock($request, $operacao);
    }
    public function actualizarHistoricoStock($request, $operacao)
    {

        $OPERACAO_DIMINUIR = 1;
        $OPERACAO_ADICIONAR = 2;
        $OPERACAO_ATUALIZAR = 3;


        if ($OPERACAO_DIMINUIR == $operacao) {
            $descricao = "Reduzido " . $request->quantidade_nova . " produto(s) no estoque";
            $quantidadeNova = $request->quantidade_antes - $request->quantidade_nova;
        } else if ($OPERACAO_ADICIONAR == $operacao) {
            $quantidadeNova = $request->quantidade_antes + $request->quantidade_nova;
            $descricao = "Adicionado " . $request->quantidade_nova . " produto(s) no estoque";
        } else {
            $quantidadeNova = $request->quantidade_nova;
            $descricao = "Actualizado o estoque com a quantidade " . $request->quantidade_nova;
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            $tipo_user_id = 2; //Empresa
        } else {
            $tipo_user_id = 3; //Funcionario
            $empresa_id = Auth::user()->empresa_id;
        }
        $atualizacaoStocks = new AtualizacaoStocks();

        $atualizacaoStocks->empresa_id = $empresa_id;
        $atualizacaoStocks->produto_id = $request->produto_id;
        $atualizacaoStocks->quantidade_antes = $request->quantidade_antes;
        $atualizacaoStocks->quantidade_nova = $quantidadeNova;
        $atualizacaoStocks->user_id = Auth::user()->id;
        $atualizacaoStocks->tipo_user_id = $tipo_user_id;
        $atualizacaoStocks->canal_id = $request->canal_id;
        $atualizacaoStocks->status_id = $request->status_id;
        $atualizacaoStocks->armazem_id = $request->armazem_id;
        $atualizacaoStocks->descricao = $request->descricao ? $request->descricao : $descricao;
        $atualizacaoStocks->save();

        return $atualizacaoStocks;
    }

    public function atualizarExistenciaStock($request, $operacao)
    {
        $OPERACAO_DIMINUIR = 1;
        $OPERACAO_ADICIONAR = 2;
        $OPERACAO_ATUALIZAR = 3;

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $existenciaEstoque = ExistenciaStock::where('produto_id', $request->produto_id)->where('empresa_id', $empresa_id)->where('armazem_id', $request->armazem_id)->first();

        if ($OPERACAO_DIMINUIR == $operacao) {
            $existenciaEstoque->quantidade = $request->quantidade_antes - $request->quantidade_nova;
        } else if ($OPERACAO_ADICIONAR == $operacao) {
            $existenciaEstoque->quantidade = $request->quantidade_antes + $request->quantidade_nova;
        } else if ($OPERACAO_ATUALIZAR == $operacao) {
            $existenciaEstoque->quantidade = $request->quantidade_nova;
        }
        $existenciaEstoque->save();
        return $existenciaEstoque;
    }




    public function editarEstoque(Request $request)
    {
        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
            $operacao = null;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $operacao = Auth::user()->id;
        }

        // $this->validate($request, [
        //     'novaQuantidade' => ['required', new EmpresaUnique('existencias_stocks', $request->id)],
        // ]);

        // try{

        //  dd($request->all());
        $existenciaStock = ExistenciaStock::where('id', $request->id)->first();

        $existenciaStock->produto_id = $request->produto_id;
        $existenciaStock->armazem_id = $request->armazem_id;
        $existenciaStock->tipo_stocagem_id = $request->tipo_stocagem_id;
        $existenciaStock->status_id = $request->status_id;
        $existenciaStock->user_id = $operacao;
        $existenciaStock->quantidade = $request->novaQuantidade;
        $existenciaStock->canal_id = 2;
        $existenciaStock->empresa_id = $empresa_id;
        $existenciaStock->observacao = $request->observacao;
        $existenciaStock->save();


        DB::table('actualizacao_stocks')->insert([

            "empresa_id" => $empresa_id,
            "produto_id" => $request->produto_id,
            "quantidade_antes" => $request->quantidade,
            "quantidade_nova" => $request->novaQuantidade,
            "user_id" => $operacao,
            "canal_id" => 2,
            "status_id" => $request->status_id //dados de vir do request
        ]);

        if ($existenciaStock) {
            return response()->json($existenciaStock, 200);
        }
    }

    public function imprimirExistenciaStock()
    {

        $armazemId = $_GET['armazem'];

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;


        //dd($empresaLogotipo);
        //dd($caminho);

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'existenciaStock',
                'report_jrxml' => 'existenciaStock.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    'diretorio' => $caminho,
                    'armazemId' => $armazemId
                ]

            ]
        );
    }
    public function imprimirExistenciaStocksPorId($existenciaId)
    {


        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;


        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'existenciaStockPorId1',
                'report_jrxml' => 'existenciaStockPorId1.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    'diretorio' => $caminho,
                    'existenciaStockId' => $existenciaId
                ]

            ]
        );
    }

    public function imprimirActualizacaoStock($actualizaStockId)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        //empresa_id=> 47
        //diretorio=>C:\laragon\www\api-mutue-negocio\public/upload//utilizadores/cliente/avatarEmpresa.png
        //actualizaStockId=> 6

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'actualizaStock',
                'report_jrxml' => 'actualizaStock.jrxml',
                'report_parameters' => [
                    'empresa_id' => $empresa['empresa']['id'],
                    'diretorio' => $caminho,
                    'actualizaStockId' => $actualizaStockId
                ]

            ]
        );


        // $reportController = new ReportsController();
        // return $reportController->show(
        //     [
        //         'report_file' => 'actualizaStock',
        //         'report_jrxml' => 'actualizaStock.jrxml',
        //         'report_parameters' => [
        //             'empresa_id' => $empresa['empresa']['id'],
        //             'diretorio' => $caminho,
        //             'actualizaStockId' => $actualizaStockId
        //         ]

        //     ]
        // );

        // $reportController = new ReportController();
        // $reportController->imprimirActualizacaoStock($actualizaStockId);
    }
}
