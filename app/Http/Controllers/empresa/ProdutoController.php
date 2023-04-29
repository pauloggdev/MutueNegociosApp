<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use App\Models\admin\Statu as AdminStatu;
use App\Models\empresa\Armazen;
use App\Models\empresa\AtualizacaoStocks;
use App\Models\empresa\CanalComunicacao;
use App\Models\empresa\Categoria;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\Produto;
use App\Models\empresa\ExistenciaStock;
use App\Models\empresa\Fabricante;
use App\Models\empresa\Marca;
use App\Models\empresa\Statu;
use App\Models\empresa\TipoMotivoIva;
use App\Models\empresa\TipoTaxa;
use App\Models\empresa\UnidadeMedida;
use App\Rules\Empresa\EmpresaUnique;
use App\Rules\Empresa\EmpresaUniqueApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Empresa\ProductRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;

class ProdutoController extends Controller
{
    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;


    private $admin_system = 1;
    private $empresa_system = 2;
    private $funcionario_system = 3;

    public function __construct()
    {
        //$this->middleware('auth');
        // $this->middleware(['role_or_permission:Admin|Docente','auth'])->except('getProvaDoCandidato','guardarProvaDoCandidato');
        //if ((Auth::guard('web')->user()->tipo_user_id) == 1) {return view('admin.dashboard');}
    }


    public function listarProdutosVendas()
    {
        $produtos = Produto::with(['statuGeral', 'categoria', 'existenciaEstock', 'tipoTaxa'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('status_id', 1)->get();
        return response()->json($produtos, 200);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductRepository $productRepository)
    {

        $STATUS_ATIVO = 1;
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

        $data['status'] = Statu::all();
        $data['produtos'] = Produto::with('statuGeral', 'categoria', 'tipoTaxa')->where('empresa_id', $empresa['empresa']['id'])->get();
        return view('empresa.produtos.index', $data);
    }
    public function indexMaisVendidos()
    {

        $STATUS_ATIVO = 1;
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

        // $data['fatura_items'] = DB::connection('mysql2')->table('factura_items')
        //     ->leftJoin('produtos', 'produtos.id', 'factura_items.produto_id')
        //     ->leftJoin('tipotaxa', 'tipotaxa.codigo', 'produtos.codigo_taxa')
        //     ->leftJoin('motivo', 'motivo.codigo', 'produtos.motivo_isencao_id')
        //     ->leftJoin('unidade_medidas', 'unidade_medidas.id', 'produtos.unidade_medida_id')
        //     ->select('factura_items.*', 'produtos.*', 'motivo.descricao AS motivo', 'unidade_medidas.designacao AS unidade', 'tipotaxa.*', 'produtos.descricao AS descProduto', 'tipotaxa.descricao AS descricao_taxa')
        //     ->where('factura_items.factura_id', $id)->orderBy('produtos.descricao', 'ASC')->get();

        // $data['produtomaisvendido'] = DB::connection('mysql2')->table('facturas')
        // ->Join('factura_items','facturas.id','factura_items.factura_id')
        // ->Join('produtos','produtos.id','factura_items.produto_id')
        // ->select('factura_items.*', 'produtos.*')
        // ->where('facturas.empresa_id', $empresa['empresa']['id'])
        // ->groupby('factura_items.descricao_produto')
        // ->orderBy('factura_items.quantidade_produto', 'desc')->get();





        $data['produtomaisvendido'] = DB::select('
        select produtos.designacao, produtos.preco_venda, produtos.preco_compra,
        sum(factura_items.quantidade_produto) as qtVendidos, produtos.id,produtos.stocavel
        from facturas 
        INNER JOIN factura_items ON facturas.id = factura_items.factura_id  
        INNER JOIN produtos ON produtos.id = factura_items.produto_id  
        WHERE facturas.empresa_id = "' . $empresa['empresa']['id'] . '"
        GROUP by factura_items.descricao_produto, produtos.designacao,
        produtos.preco_venda, produtos.preco_compra, produtos.id,produtos.stocavel
        order by sum(factura_items.quantidade_produto) desc');

        // dd($data['produtomaisvendido']);
        // dd($data['produtoMaisVendido']);


        return view('empresa.produtos.produtomaisvendidos', $data);
    }
    public function listarProdutos(ProductRepository $productRepository)
    {
        
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $data = $productRepository->all();

        return response()->json($data, 200);
    }


    public function stock()
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

        $data['armazens'] = DB::connection('mysql2')->table('armazens')->where('empresa_id', $empresa['empresa']['id'])->where('status_id', 1)->get();
        $data['produtoStock'] = ExistenciaStock::with(['produtos', 'armazens', 'status'])->where('empresa_id', $empresa['empresa']['id'])->where('status_id', 1)->get();
        return view('empresa.produtos.produtoStockIndex', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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

        $data['canais_comunicacao'] = CanalComunicacao::all();
        $data['status'] = Statu::all();


        $REGIME_SIMPLIFICADO = 2;
        $REGIME_EXCLUSAO = 3;
        $REGIME_GERAL = 1;


        if ($empresa['empresa']['tiporegime']['id'] ==  $REGIME_SIMPLIFICADO) {

            $data['taxas'] = TipoTaxa::where('empresa_id', null)
                ->where('codigo', 1)
                ->get();

            $data['motivos'] = TipoMotivoIva::where('empresa_id', null)
                ->where('codigo', 9)
                ->orwhere('codigo', 8)
                ->get();
        }

        if ($empresa['empresa']['tiporegime']['id'] == $REGIME_EXCLUSAO) {
            $data['taxas'] = TipoTaxa::where('empresa_id', null)
                ->where('codigo', 1)->get();

            $data['motivos'] = TipoMotivoIva::where('codigo', 7)
                ->where('empresa_id', null)
                ->orwhere('codigo', 8)
                ->get();
        }

        if ($empresa['empresa']['tiporegime']['id'] ==  $REGIME_GERAL) {
            $data['taxas'] = TipoTaxa::where('empresa_id', null)
                ->get();


            $data['motivos'] = TipoMotivoIva::where('empresa_id', null)
                ->where('codigo', '!=', 7)
                ->where('codigo', '!=', 9)
                ->get();
        }


        $data['fabricantes'] = Fabricante::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['status'] = AdminStatu::get();
        $data['unidademedidas'] = UnidadeMedida::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['categorias'] = Categoria::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['marcas'] = Marca::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['armazens'] = Armazen::where('empresa_id', $empresa['empresa']['id'])->get();

        return view('empresa.produtos.create', $data);
    }


    public function listarArmazens()
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        $canais_comunicacao = CanalComunicacao::all();
        $status = Statu::all();

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $data['armazens'] = DB::connection('mysql2')->table('armazens')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('id', 'ASC')->get();

        return  response()->json($data, 200);
    }

    public function store(Request $request)
    {


        $CANAL_CLIENTE = 2;
        $STATUS_ATIVO = 1;
        $REGIME_GERAL = 1;
        $REGIME_TRANSITORIO = 2;
        $REGIME_NAO_SUJEICAO = 3;

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }
        $message = [
            'designacao.required' => 'É obrigatório a indicação de um valor para o campo designação',
            'designacao.unique' => 'produto já cadastrado',
            'preco_venda.required' => 'É obrigatório a indicação de um valor para o campo preço venda',
            'status_id.required' => 'É obrigatório a indicação de um valor para o campo status',
            'stocavel.required' => 'É obrigatório a indicação de um valor para o campo Controlar Stock',
            'fabricante_id.required' => 'É obrigatório a indicação de um valor para o campo fabricante',
            'armazens.required' => 'É obrigatório a indicação de um valor para o campo armazens',
        ];
        $validator = Validator::make($request->all(), [
            'designacao' => ['required', 'min:3', 'max:255', new EmpresaUnique('produtos', 'mysql2')],
            'preco_venda' => ['required', 'min:0'],
            'status_id' => ['required'],
            'codigo_taxa' => ['required'],
            'fabricante_id' => ['required'],
            'motivo_isencao_id' => [function ($atributo, $valor, $fail) use ($request) {
                if ($request->taxa <= 0 && $request->motivo_isencao_id == NULL) {
                    $fail('informe o motivo de isenção');
                }
            }],
            'stocavel' => ['required', function ($attribute, $estocavel, $fail) use ($request) {
                if ($estocavel == 1 && ($request->all()['quantidade'] == NULL && $request->all()['quantidade'] != 0)) {
                    $fail('informe a quantidade em estoque');
                }
            }],
            'armazens' => ['required']
        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        $message = [
            'armazem_id.required' => 'É obrigatório a indicação de um valor para o campo armazém',
            'quantidade.required' => 'É obrigatório a quantidade'
        ];
        foreach ($request->all()['armazens'] as $data) {

            $validator = Validator::make($data, [
                'armazem_id' => ['required'],
                'quantidade' => ['required']
            ], $message);

            if ($validator->fails()) {
                return response()->json($validator->errors()->messages(), 400);
            }
        }
        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $regime_empresa_id = Empresa::where('referencia', $referencia)->where('status_id', 1)->first()->tipo_regime_id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $regime_empresa_id = Empresa_Cliente::where('id', $empresa_id)->where('status_id', 1)->first()->tipo_regime_id;
        }

        if ($regime_empresa_id == $REGIME_GERAL) {
            if ($request->taxa > 0) {
                $motivo_isencao = NULL;
            } else {
                $motivo_isencao = $request->motivo_isencao_id;
            }
            $codigo_taxa = $request->codigo_taxa;
        } else if (($regime_empresa_id == $REGIME_TRANSITORIO) || ($regime_empresa_id == $REGIME_NAO_SUJEICAO)) {
            if ($request->motivo_isencao_id) {
                $motivo_isencao = $request->motivo_isencao_id;
                $codigo_taxa = 1;
            } else {
                $motivo_isencao = NULL;
                $codigo_taxa = $request->codigo_taxa;
            }
        }
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $produto = new Produto();

        $data_expiracao = date_format(date_create($request->data_expiracao), 'Y-m-d');

        try {
            $produto->designacao = $request->designacao;
            $produto->referencia = $request->referencia;
            $produto->codigo_barra = $request->codigo_barra;
            $produto->fabricante_id =  $request->fabricante_id ? $request->fabricante_id : $this->pegarFabricanteDefaultEmpresaAutenticada($empresa)->id;
            $produto->status_id = $request->status_id;
            $produto->descricao = $request->descricao;
            $produto->data_expiracao = $data_expiracao;
            $produto->quantidade_minima = $request->quantidade_minima ? $request->quantidade_minima : 0;
            $produto->quantidade_critica = $request->quantidade_critica ? $request->quantidade_critica : 0;
            $produto->preco_compra = $request->preco_compra;
            $produto->preco_venda = $request->preco_venda;
            $produto->stocavel = $request->stocavel;
            $produto->classe_id = $request->classe_id;
            $produto->unidade_medida_id = $request->unidade_medida_id ?  $request->unidade_medida_id : $this->retornarUnidadeMedidaDefault()->id;
            $produto->categoria_id = $request->categoria_id ? $request->categoria_id : 1;
            $produto->marca_id = $request->marca_id;
            $produto->descricao = $request->descricao;
            $produto->canal_id = $request->canal_id ? $request->canal_id : $CANAL_CLIENTE;
            $produto->user_id = $empresa['operador'];
            $produto->codigo_taxa = $codigo_taxa;
            $produto->motivo_isencao_id = $motivo_isencao;
            $produto->empresa_id = $empresa['empresa']['id'];
            $produto->save();

            foreach ($request->all()['armazens'] as $armazem) {
                $existenciaEstoque = new ExistenciaStock();
                $existenciaEstoque->produto_id = $produto->id;
                $existenciaEstoque->armazem_id = $armazem['armazem_id'];
                if ($request->stocavel == "Não") {
                    $existenciaEstoque->quantidade = 0;
                } else {
                    $existenciaEstoque->quantidade = $armazem['quantidade'] ? (int) $armazem['quantidade'] : 0;
                }
                $existenciaEstoque->canal_id = $CANAL_CLIENTE;
                $existenciaEstoque->user_id = $empresa['operador'];
                $existenciaEstoque->status_id = $STATUS_ATIVO;
                $existenciaEstoque->empresa_id = $empresa['empresa']['id'];
                $existenciaEstoque->observacao = $request->descricao;
                $existenciaEstoque->save();

                if ($existenciaEstoque) {

                    $actualizaStock = new AtualizacaoStocks();
                    $actualizaStock->empresa_id = $empresa['empresa']['id'];
                    $actualizaStock->produto_id = $produto->id;
                    if ($request->stocavel == "Não") {
                        $actualizaStock->quantidade_antes = 0;
                        $actualizaStock->quantidade_nova = 0;
                    } else {
                        $actualizaStock->quantidade_antes = $armazem['quantidade'] ? (int) $armazem['quantidade'] : 0;
                        $actualizaStock->quantidade_nova = $armazem['quantidade'] ? (int) $armazem['quantidade'] : 0;
                    }
                    $actualizaStock->user_id = $empresa['operador'];
                    $actualizaStock->tipo_user_id = 2; //Empresa
                    $actualizaStock->canal_id = $CANAL_CLIENTE;
                    $actualizaStock->status_id = $STATUS_ATIVO;
                    $actualizaStock->armazem_id = $armazem['armazem_id'];
                    $actualizaStock->descricao = $request->descricao;
                    $actualizaStock->save();
                }
            }




            // foreach ($this->listarTodosArmazens($empresa) as $key => $todosArmazens) {
            //     $existenciaEstoque = new ExistenciaStock();

            //     $quantidade = 0;
            //     foreach ($request->all()['armazens'] as $armazemSelecionados) {
            //         if ($todosArmazens->id == $armazemSelecionados['id']) {
            //             $quantidade = $request->quantidade;
            //             break;
            //         }
            //     }
            //     $existenciaEstoque->produto_id = $produto->id;
            //     $existenciaEstoque->armazem_id = $todosArmazens->id;
            //     $existenciaEstoque->quantidade = (int) $quantidade;
            //     $existenciaEstoque->canal_id = $CANAL_CLIENTE;
            //     $existenciaEstoque->user_id = $empresa['operador'];
            //     $existenciaEstoque->status_id = $STATUS_ATIVO;
            //     $existenciaEstoque->empresa_id = $empresa['empresa']['id'];
            //     $existenciaEstoque->observacao = $request->descricao;
            //     $existenciaEstoque->save();
            // }
        } catch (\Exception $th) {
        }
        return response()->json($produto, 200);
    }

    public function listarTodosArmazens($empresa)
    {
        return DB::connection('mysql2')->table('armazens')->where('empresa_id', $empresa['empresa']['id'])->get();
    }


    public function pegarFabricanteDefaultEmpresaAutenticada($empresa)
    {
        return DB::connection('mysql2')->table('fabricantes')->where('diversos', "Sim")->where('empresa_id', $empresa['empresa']['id'])->first();
    }

    public function retornarUnidadeMedidaDefault()
    {
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        return DB::connection('mysql2')->table('unidade_medidas')->where('empresa_id', $empresa['empresa']['id'])->first();
    }

    public function storeCopiaOriginal(Request $request)
    {

        $regimeGeral = 1;
        $regimeTransitorio = 2;
        $regimeNaoSujeicao = 3;
        $canal_cliente = 2;

        $produto = new Produto();

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
            $regime_empresa_id = Empresa::where('referencia', $referencia)->where('status_id', 1)->first()->tipo_regime_id;
            $operador = null;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $regime_empresa_id = Empresa_Cliente::where('id', $empresa_id)->where('status_id', 1)->first()->tipo_regime_id;
            $operador = Auth::user()->id;
        }


        $this->validate($request, [
            'designacao' => ['required', 'min:3', 'max:255'],
            'preco_venda' => ['required', 'min:0'],
            'status_id' => ['required'],
            'stocavel' => ['required'],
        ]);

        $unidade_default = DB::connection('mysql2')->table('unidade_medidas')->where('empresa_id', NULL)->first();

        if ($regime_empresa_id == $regimeGeral) {
            if ($request->motivo_isencao_id || $request->codigo_taxa) {
                if ($request->motivo_isencao_id) {
                    $codigo_taxa = NULL;
                    $motivo_isencao = $request->motivo_isencao_id;
                } else if ($request->codigo_taxa) {
                    $motivo_isencao = NULL;
                    $codigo_taxa = $request->codigo_taxa;
                }
            } else {
                return response()->json(['status' => 'Informe o motivo ou código da taxa']);
            }
        } else if (($regime_empresa_id == $regimeTransitorio) || ($regime_empresa_id == $regimeNaoSujeicao)) {
            if ($request->motivo_isencao_id) {
                $motivo_isencao = $request->motivo_isencao_id;
                $codigo_taxa = NULL;
            } else {
                return response()->json(['status' => 'Informe o motivo isenção']);
            }
        }

        if ($request->stocavel == 1) { //É estocavel
            $produtoEstocavel = "Sim";
            if (!$request->quantidade || $request->quantidade <= 0) {
                return response()->json(['status' => 'Informe a quantidade em estoque']);
            }
        } else {
            $produtoEstocavel = "Não";
        }

        if (!isset($request->armazens)) {
            return response()->json(['armazem' => ['Informe o armazém']]);
        }

        $produto->designacao = $request->designacao;
        $produto->referencia = $request->referencia;
        $produto->codigo_barra = $request->codigo_barra;
        $produto->fabricante_id = $request->fabricante_id;
        $produto->status_id = $request->status_id;
        $produto->descricao = $request->descricao;
        $produto->data_expiracao = $request->data_expiracao;
        $produto->quantidade_minima = $request->quantidade_minima;
        $produto->quantidade_critica = $request->quantidade_critica;
        $produto->preco_compra = $request->preco_compra;
        $produto->preco_venda = $request->preco_venda;
        $produto->stocavel = $produtoEstocavel;
        $produto->classe_id = $request->classe_id;
        $produto->unidade_medida_id = $request->unidade_medida_id ? $request->unidade_medida_id : $unidade_default->id;
        $produto->categoria_id = $request->categoria_id;
        $produto->marca_id = $request->marca_id;
        $produto->canal_id = $canal_cliente; //canal do cliente
        $produto->user_id = $operador;
        $produto->codigo_taxa = $codigo_taxa ? $codigo_taxa : 1;
        $produto->motivo_isencao_id = $motivo_isencao;
        $produto->empresa_id = $empresa_id;
        $produto->save();



        if ($request->stocavel == 1) { //é estocavel

            foreach ($request->armazens as $prod) {

                DB::connection('mysql2')->table('existencias_stocks')->insert([
                    'produto_id' => $produto->latest()->first()->id,
                    'armazem_id' => $prod["id"],
                    'tipo_stocagem_id' => $request->tipo_stocagem_id,
                    'quantidade' => $request->quantidade,
                    'canal_id' => $produto->latest()->first()->canal_id,
                    'user_id' => $operador,
                    'status_id' => $produto->latest()->first()->status_id,
                    'empresa_id' => $empresa_id,
                ]);
            }


            foreach ($request->armazens as $prod) {

                DB::connection('mysql2')->table('produtos_lojas')->insert([
                    'produto_id' => $produto->latest()->first()->id,
                    'armazem_id' => $prod["id"],
                    'preco_compra' => $request->preco_compra,
                    'preco_venda' => $request->preco_venda,
                    'quantidade_minima' => $request->quantidade_minima,
                    'quantidade_critica' => $request->quantidade_critica,
                    'canal_id' => $produto->latest()->first()->canal_id,
                    'user_id' => $operador,
                    'status_id' => $produto->latest()->first()->status_id,
                    'empresa_id' => $empresa_id,
                ]);
            }
        }

        if ($produto) {
            return response()->json($produto, 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /*
    public function storeCopia(Request $request)
    {

        $produto = new Produto();

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
            $regime_empresa_id = Empresa::where('referencia', $referencia)->where('status_id', 1)->first()->tipo_regime_id;
            $operador = null;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $regime_empresa_id = Empresa_Cliente::where('id', $empresa_id)->where('status_id', 1)->first()->tipo_regime_id;
            $operador = Auth::user()->id;
        }


        $this->validate($request, [
            'designacao' => ['required', 'min:1', 'max:255', new EmpresaUnique('produtos')],
            'preco_venda' => ['required', 'min:0'],
            'codigo_taxa' => ['required', 'min:0'],
            'stocavel' => ['required'],
        ]);

        if (($regime_empresa_id == 3 || $regime_empresa_id == 2) && ($request->codigo_taxa == 1)) {
            $this->validate($request, ['motivo_isencao_id' => ['required', 'min:0'],]);
        }

        if (($request->stocavel = "SIM")) {
            $this->validate($request, ['quantidade' => ['required'],]);
        }

        $unidade_default = DB::connection('mysql2')->table('unidade_medidas')->where('empresa_id', NULL)->first();

        try {
            //$data=json_decode($request->produto, true);//
            $produto->designacao = $request->designacao;
            $produto->referencia = $request->referencia;
            $produto->codigo_barra = $request->codigo_barra;
            $produto->fabricante_id = $request->fabricante_id;
            $produto->status_id = $request->status_id;
            $produto->descricao = $request->descricao;
            $produto->data_expiracao = $request->data_expiracao;
            $produto->quantidade_minima = $request->quantidade_minima;
            $produto->quantidade_critica = $request->quantidade_critica;
            $produto->preco_compra = $request->preco_compra;
            $produto->preco_venda = $request->preco_venda;
            $produto->stocavel = $request->stocavel;
            $produto->classe_id = $request->classe_id;
            $produto->unidade_medida_id = $request->unidade_medida_id ? $request->unidade_medida_id : $unidade_default->id;
            $produto->categoria_id = $request->categoria_id;
            $produto->marca_id = $request->marca_id;
            $produto->canal_id = 2; //canal do cliente
            $produto->user_id = $operador;
            $produto->empresa_id = $empresa_id;
            if (($regime_empresa_id == 3 || $regime_empresa_id == 2) || ($request->codigo_taxa == 1)) {
                $produto->codigo_taxa = 1;
                $produto->motivo_isencao_id = $request->motivo_isencao_id;
            } else {
                $produto->codigo_taxa = $request->codigo_taxa;
            }

            $produtos = $produto->save();

            if ($produtos) {

                if (($request->stocavel = "SIM") || ($produto->latest()->first()->stocavel = "SIM")) {

                    if (isset($request["armazens"])) {
                        foreach ($request->armazens as $prod) {

                            DB::connection('mysql2')->table('existencias_stocks')->insert([
                                'produto_id' => $produto->latest()->first()->id,
                                'armazem_id' => $prod["id"],
                                'tipo_stocagem_id' => $request->tipo_stocagem_id,
                                'quantidade' => $request->quantidade,
                                'canal_id' => $produto->latest()->first()->canal_id,
                                'user_id' => $operador,
                                'status_id' => $produto->latest()->first()->status_id,
                                'empresa_id' => $empresa_id,
                            ]);
                        }
                    }
                }
                if (isset($request["armazens"])) {

                    foreach ($request->armazens as $prod) {

                        $produto_loja = DB::connection('mysql2')->table('produtos_lojas')->insert([
                            'produto_id' => $produto->latest()->first()->id,
                            'armazem_id' => $prod["id"],
                            'preco_compra' => $request->preco_compra,
                            'preco_venda' => $request->preco_venda,
                            'quantidade_minima' => $request->quantidade_minima,
                            'quantidade_critica' => $request->quantidade_critica,
                            'canal_id' => $produto->latest()->first()->canal_id,
                            'user_id' => $operador,
                            'status_id' => $produto->latest()->first()->status_id,
                            'empresa_id' => $empresa_id,
                        ]);
                    }

                    if ($produto_loja) {
                        return response()->json('Operação efectuada com sucesso!', 200);
                    }
                }
            }

            // if ($produtos) {

            //     if (($request->stocavel = "Sim") || ($produto->latest()->first()->stocavel = "Sim")) {
            //         if (isset($request["armazem"])) {
            //             $tamanho = count($request["armaze,"]) - 1;
            //             for ($i = 0; $i <= $tamanho; $i++) {
            //                 DB::connection('mysql2')->table('existencias_stocks')->insert([
            //                     'produto_id' => $produto->latest()->first()->id,
            //                     'armazem_id' => $request["armazen_id"][$i],
            //                     'tipo_stocagem_id' => $request->tipo_stocagem_id,
            //                     'quantidade' => $request->quantidade,
            //                     'canal_id' => $produto->latest()->first()->canal_id,
            //                     'user_id' => $operador,
            //                     'status_id' => $produto->latest()->first()->status_id,
            //                     'empresa_id' => $empresa_id,
            //                 ]);
            //             }
            //         }
            //     }

            //     if (isset($request["armazen_id"])) {
            //         $tamanho = count($request["armazen_id"]) - 1;
            //         for ($i = 0; $i <= $tamanho; $i++) {
            //             $produto_loja = DB::connection('mysql2')->table('produtos_lojas')->insert([
            //                 'produto_id' => $produto->latest()->first()->id,
            //                 'armazem_id' => $request["armazen_id"][$i],
            //                 'preco_compra' => $request->preco_compra,
            //                 'preco_venda' => $request->preco_venda,
            //                 'quantidade_minima' => $request->quantidade_minima,
            //                 'quantidade_critica' => $request->quantidade_critica,
            //                 'canal_id' => $produto->latest()->first()->canal_id,
            //                 'user_id' => $operador,
            //                 'status_id' => $produto->latest()->first()->status_id,
            //                 'empresa_id' => $empresa_id,
            //             ]);
            //         }
            //         if ($produto_loja) {
            //             //return redirect('/empresa/produtos/adicionar')->withSuccess('Operação efectuada com sucesso!');
            //             return response()->json('Operação efectuada com sucesso!', 200);
            //         }
            //     }
            // }
        } catch (\Exception $e) {

            throw $e;
        }
    }*
    /

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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


        $REGIME_SIMPLIFICADO = 2;
        $REGIME_EXCLUSAO = 3;
        $REGIME_GERAL = 1;


        if ($empresa['empresa']['tiporegime']['id'] ==  $REGIME_SIMPLIFICADO) {

            $data['taxas'] = TipoTaxa::where('empresa_id', null)
                ->where('codigo', 1)
                ->get();

            $data['motivos'] = TipoMotivoIva::where('empresa_id', null)
                ->where('codigo', 9)
                ->orwhere('codigo', 8)
                ->get();
        }

        if ($empresa['empresa']['tiporegime']['id'] == $REGIME_EXCLUSAO) {
            $data['taxas'] = TipoTaxa::where('empresa_id', null)
                ->where('codigo', 1)->get();

            $data['motivos'] = TipoMotivoIva::where('codigo', 7)
                ->where('empresa_id', null)
                ->orwhere('codigo', 8)
                ->get();
        }

        if ($empresa['empresa']['tiporegime']['id'] ==  $REGIME_GERAL) {
            $data['taxas'] = TipoTaxa::where('empresa_id', null)
                ->get();


            $data['motivos'] = TipoMotivoIva::where('empresa_id', null)
                ->where('codigo', '!=', 7)
                ->where('codigo', '!=', 9)
                ->get();
        }


        $data['fabricantes'] = Fabricante::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['status'] = AdminStatu::get();
        $data['unidademedidas'] = UnidadeMedida::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['categorias'] = Categoria::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['marcas'] = Marca::where('empresa_id', $empresa['empresa']['id'])->get();
        // $data['armazens'] = Armazen::where('empresa_id', $empresa['empresa']['id'])->get();
        $data['empresa'] = Empresa_Cliente::with(['tiporegime'])->where('id', $empresa['empresa']['id'])->where('status_id', 1)->first();
        $data['produto'] = Produto::with(['existenciaEstock', 'existenciaEstock.armazens', 'fabricante', 'statuGeral', 'tipoTaxa', 'motivoIsencao', 'empresa'])->where('empresa_id', $empresa['empresa']['id'])->where('id', $id)->first();

        // dd($data['produto']['existenciaEstock']);
        //dd($data['produto']);
        // dd($data['produto']);
        return view('empresa.produtos.editar', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar($id)
    {
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


        $CANAL_CLIENTE = 2;
        $STATUS_ATIVO = 1;
        $REGIME_GERAL = 1;
        $REGIME_TRANSITORIO = 2;
        $REGIME_NAO_SUJEICAO = 3;


        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $message = [
            'designacao.required' => 'É obrigatório a indicação de um valor para o campo designação',
            'designacao.unique' => 'produto já cadastrado',
            'preco_venda.required' => 'É obrigatório a indicação de um valor para o campo preço venda',
            'status_id.required' => 'É obrigatório a indicação de um valor para o campo status',
            'stocavel.required' => 'É obrigatório a indicação de um valor para o campo Controlar Stock',
            'codigo_taxa.required' => 'É obrigatório a indicação de um valor para o campo Imposto/Taxas',
            'fabricante_id.required' => 'É obrigatório a indicação de um valor para o campo fabricante',
            // 'armazens.required' => 'É obrigatório a indicação de um valor para o campo armazens',

        ];
        $validator = Validator::make($request->all(), [
            'designacao' => ['required', 'min:3', 'max:255', new EmpresaUnique('produtos', 'mysql2', 'id', $id)],
            'preco_venda' => ['required', 'min:0'],
            'motivo_isencao_id' => [function ($atributo, $valor, $fail) use ($request) {
                if ($request->taxa <= 0 && $request->motivo_isencao_id == NULL) {
                    $fail('informe o motivo de isenção');
                }
            }],
            'codigo_taxa' => ['required'],
            'fabricante_id' => ['required'],
            'status_id' => ['required'],
            // 'armazens' => ['required']
        ], $message);


        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $regime_empresa_id = Empresa::where('referencia', $referencia)->where('status_id', 1)->first()->tipo_regime_id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $regime_empresa_id = Empresa_Cliente::where('id', $empresa_id)->where('status_id', 1)->first()->tipo_regime_id;
        }


        if ($regime_empresa_id == $REGIME_GERAL) {
            if ($request->taxa > 0) {
                $motivo_isencao = NULL;
            } else {
                $motivo_isencao = $request->motivo_isencao_id;
            }
            $codigo_taxa = $request->codigo_taxa;
        } else if (($regime_empresa_id == $REGIME_TRANSITORIO) || ($regime_empresa_id == $REGIME_NAO_SUJEICAO)) {
            if ($request->motivo_isencao_id) {
                $motivo_isencao = $request->motivo_isencao_id;
                $codigo_taxa = 1;
            }
        }
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $produto = Produto::with(['existenciaEstock'])->where('empresa_id', $empresa['empresa']['id'])->find($id);

        $data_expiracao = date_format(date_create($request->data_expiracao), 'Y-m-d');

        try {
            $produto->designacao = $request->designacao;
            $produto->codigo_barra = $request->codigo_barra;
            $produto->fabricante_id =  $request->fabricante_id ? $request->fabricante_id : $this->pegarFabricanteDefaultEmpresaAutenticada($empresa)->id;
            $produto->status_id = $request->status_id;
            $produto->descricao = $request->descricao;
            $produto->data_expiracao = $data_expiracao;
            $produto->quantidade_minima = $request->quantidade_minima ? $request->quantidade_minima : 0;
            $produto->quantidade_critica = $request->quantidade_critica ? $request->quantidade_critica : 0;
            $produto->preco_compra = $request->preco_compra;
            $produto->preco_venda = $request->preco_venda;
            $produto->stocavel = $request->stocavel;
            $produto->classe_id = $request->classe_id;
            $produto->unidade_medida_id = $request->unidade_medida_id ?  $request->unidade_medida_id : $this->retornarUnidadeMedidaDefault()->id;
            $produto->categoria_id = $request->categoria_id;
            $produto->marca_id = $request->marca_id;
            $produto->descricao = $request->descricao;
            $produto->canal_id = $request->canal_id ? $request->canal_id : $CANAL_CLIENTE;
            $produto->user_id = $empresa['operador'];
            $produto->codigo_taxa = $codigo_taxa;
            $produto->motivo_isencao_id = $motivo_isencao;
            $produto->empresa_id = $empresa['empresa']['id'];
            $produto->save();


            if ($request['stocavel'] == 2) { //não estocavel


                DB::connection('mysql2')->table("existencias_stocks")
                    ->where("empresa_id", $empresa['empresa']['id'])
                    ->where("produto_id", $id)
                    ->update(['quantidade' => 0]);


                // foreach ($existenciaStock as $key => $data) {

                //     $existenciaProduto = ExistenciaStock::where('armazem_id', $data['armazem_id'])
                //     ->where('produto_id', $id)->where('empresa_id', $empresa['empresa']['id'])->first();
                //     $existenciaProduto->quantidade = 0;
                //     $existenciaProduto->save();
                // }
            }
        } catch (\Exception $th) {
        }
        return response()->json($produto, 200);
    }
    public function updateApi(Request $request, $id)
    {


        $CANAL_CLIENTE = 2;
        $STATUS_ATIVO = 1;
        $REGIME_GERAL = 1;
        $REGIME_TRANSITORIO = 2;
        $REGIME_NAO_SUJEICAO = 3;


        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $message = [
            'designacao.required' => 'É obrigatório a indicação de um valor para o campo designação',
            'designacao.unique' => 'produto já cadastrado',
            'preco_venda.required' => 'É obrigatório a indicação de um valor para o campo preço venda',
            'status_id.required' => 'É obrigatório a indicação de um valor para o campo status',
            'stocavel.required' => 'É obrigatório a indicação de um valor para o campo Controlar Stock',
            'codigo_taxa.required' => 'É obrigatório a indicação de um valor para o campo Imposto/Taxas',
            'fabricante_id.required' => 'É obrigatório a indicação de um valor para o campo fabricante',
            // 'armazens.required' => 'É obrigatório a indicação de um valor para o campo armazens',

        ];
        $validator = Validator::make($request->all(), [
            'designacao' => ['required', 'min:3', 'max:255', new EmpresaUniqueApi('produtos', 'mysql2', 'id', $id)],
            'preco_venda' => ['required', 'min:0'],
            'motivo_isencao_id' => [function ($atributo, $valor, $fail) use ($request) {
                if ($request->taxa <= 0 && $request->motivo_isencao_id == NULL) {
                    $fail('informe o motivo de isenção');
                }
            }],
            'codigo_taxa' => ['required'],
            'fabricante_id' => ['required'],
            'status_id' => ['required'],
            // 'armazens' => ['required']
        ], $message);


        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
            $regime_empresa_id = Empresa_Cliente::where('id', $empresa_id)->where('status_id', 1)->first()->tipo_regime_id;
        }


        if ($regime_empresa_id == $REGIME_GERAL) {
            if ($request->taxa > 0) {
                $motivo_isencao = NULL;
            } else {
                $motivo_isencao = $request->motivo_isencao_id;
            }
            $codigo_taxa = $request->codigo_taxa;
        } else if (($regime_empresa_id == $REGIME_TRANSITORIO) || ($regime_empresa_id == $REGIME_NAO_SUJEICAO)) {

            if ($request->motivo_isencao_id) {
                $motivo_isencao = $request->motivo_isencao_id;
                $codigo_taxa = 1;
            } else {
                $motivo_isencao = NULL;
                $codigo_taxa = $request->codigo_taxa;
            }
        }
        //$empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $produto = Produto::with(['existenciaEstock'])->where('empresa_id', $empresa_id)->find($id);

        $data_expiracao = date_format(date_create($request->data_expiracao), 'Y-m-d');

        $unidadeId =  DB::connection('mysql2')->table('unidade_medidas')->where('empresa_id', $empresa_id)->first()->id;
        $fabricanteId =  DB::connection('mysql2')->table('fabricantes')->where('diversos', "Sim")->where('empresa_id', $empresa_id)->first()->id;

        try {
            $produto->designacao = $request->designacao;
            $produto->codigo_barra = $request->codigo_barra;
            $produto->fabricante_id =  $request->fabricante_id ? $request->fabricante_id : $fabricanteId;
            $produto->status_id = $request->status_id;
            $produto->descricao = $request->descricao;
            $produto->data_expiracao = $data_expiracao;
            $produto->quantidade_minima = $request->quantidade_minima ? $request->quantidade_minima : 0;
            $produto->quantidade_critica = $request->quantidade_critica ? $request->quantidade_critica : 0;
            $produto->preco_compra = $request->preco_compra;
            $produto->preco_venda = $request->preco_venda;
            $produto->stocavel = $request->stocavel;
            $produto->classe_id = $request->classe_id;
            $produto->unidade_medida_id = $request->unidade_medida_id ?  $request->unidade_medida_id : $unidadeId;
            $produto->categoria_id = $request->categoria_id;
            $produto->marca_id = $request->marca_id;
            $produto->descricao = $request->descricao;
            $produto->canal_id = $request->canal_id ? $request->canal_id : $CANAL_CLIENTE;
            $produto->user_id = auth('EmpresaApi')->user()->id;
            $produto->codigo_taxa = $codigo_taxa;
            $produto->motivo_isencao_id = $motivo_isencao;
            $produto->empresa_id = $empresa_id;
            $produto->save();

            if ($request['stocavel'] == 2) { //não estocavel
                DB::connection('mysql2')->table("existencias_stocks")
                    ->where("empresa_id", $empresa_id)
                    ->where("produto_id", $id)
                    ->update(['quantidade' => 0]);


                // foreach ($existenciaStock as $key => $data) {

                //     $existenciaProduto = ExistenciaStock::where('armazem_id', $data['armazem_id'])
                //     ->where('produto_id', $id)->where('empresa_id', $empresa['empresa']['id'])->first();
                //     $existenciaProduto->quantidade = 0;
                //     $existenciaProduto->save();
                // }
            }
        } catch (\Exception $th) {
        }
        return response()->json($produto, 200);
    }


    public function pegarDependencias()
    {

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            $regime_empresa_id = Empresa_Cliente::where('id', $empresa_id)->first()->tipo_regime_id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $regime_empresa_id = Empresa_Cliente::where('id', $empresa_id)->first()->tipo_regime_id;
        }

        if (($regime_empresa_id == 3 || $regime_empresa_id == 2)) {
            $data['tipotaxas'] = DB::connection('mysql2')->table('tipotaxa')->where('codigostatus', 1)->where('codigo', 1)->orderBy('codigo', 'ASC')->get();
            $data['motivos'] = DB::connection('mysql2')->table('motivo')->where('status_id', 1)->orderBy('codigo', 'ASC')->get();
        } else {
            $data['tipotaxas'] = DB::connection('mysql2')->table('tipotaxa')->where('codigostatus', 1)->whereIn('codigo', [2, 3])->get();
            $data['motivos'] = DB::connection('mysql2')->table('motivo')->where('status_id', 1)->where('codigo', '=', 0)->orderBy('codigo', 'ASC')->get();
        }

        $data['gestores'] = DB::connection('mysql2')->table('gestor_clientes')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('nome', 'ASC')->get();
        $data['fabricantes'] = DB::connection('mysql2')->table('fabricantes')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('designacao', 'ASC')->get();
        $data['status_gerais'] = DB::connection('mysql2')->table('status_gerais')->orderBy('designacao', 'ASC')->get();
        $data['tipos_stocagens'] = DB::connection('mysql2')->table('tipos_stocagens')->where('empresa_id', $empresa_id)->orderBy('designacao', 'ASC')->get();
        $data['armazens'] = DB::connection('mysql2')->table('armazens')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('designacao', 'ASC')->get();
        $data['classes'] = DB::connection('mysql2')->table('classes')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('designacao', 'ASC')->get();
        $data['categorias'] = DB::connection('mysql2')->table('categorias')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('designacao', 'ASC')->get();
        $data['marcas'] = DB::connection('mysql2')->table('marcas')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('designacao', 'ASC')->get();
        $data['unidade_medidas'] = DB::connection('mysql2')->table('unidade_medidas')->where('status_id', 1)->where('empresa_id', $empresa_id)->orderBy('designacao', 'ASC')->get();

        return Response()->json($data);
    }

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

        $produto = Produto::where('empresa_id', $empresa['empresa']['id'])->find($id);
        $produto->delete();

        if ($produto) {
            return response()->json($produto, 200);
        } else {
            return response()->json("Não é possível eliminar este Fornecedor, está a ser utilizado por uma entidade", 500);
        }
    }

    /**
     * Controller api
     */
    public function indexApi()
    {


        if (Auth::guard('WebApi')->check()) {
            if ((Auth::guard('WebApi')->user()->tipo_user_id) == 1) {
                return response()->json(['message' => 'Usuário não permitido']);
            }
        }


        if (Auth::guard('WebApi')->check()) {

            $referencia = Empresa::where('user_id', auth('WebApi')->user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
        }

        $data['produtos'] = Produto::with(
            [
                'marca', 'categoria', 'existenciaEstock.armazens',
                'statuGeral', 'tipoTaxa',
                'unidade', 'classe',
                'fabricante',
                'user', 'canal',
                'status', 'motivoIsencao',
                'empresa'

            ]
        )->where('empresa_id', $empresa_id)->where('status_id', 1)->get();

        return response()->json($data, 200);
    }
    public function listarProduto($produtoId)
    {


        if (Auth::guard('WebApi')->check()) {
            if ((Auth::guard('WebApi')->user()->tipo_user_id) == 1) {
                return response()->json(['message' => 'Usuário não permitido']);
            }
        }

        if (Auth::guard('WebApi')->check()) {

            $referencia = Empresa::where('user_id', auth('WebApi')->user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
        }


        $data['produto'] = Produto::with([
            'existenciaEstock',
            'existenciaEstock.armazens',
            'fabricante', 'statuGeral',
            'tipoTaxa', 'motivoIsencao', 'empresa'
        ])->where('empresa_id', $empresa_id)->where('id', $produtoId)->first();

        return response()->json($data, 200);
    }

    public function imprimirProdutos()
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;

        if ($status_id == 3) {
            $options = ["diretorio" => $caminho, "empresa_id" => $empresa['empresa']['id'], "status_id" => "%"]; //parametros where do report
        } else {
            $options = ["diretorio" => $caminho, "empresa_id" => $empresa['empresa']['id'], "status_id" => "%" . $status_id]; //parametros where do report
        }

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'produtos2',
                'report_jrxml' => 'produtos2.jrxml',
                'report_parameters' => $options

            ]
        );
    }

    public function storeApi(Request $request)
    {

        $CANAL_CLIENTE = 2;
        $STATUS_ATIVO = 1;
        $REGIME_GERAL = 1;
        $REGIME_TRANSITORIO = 2;
        $REGIME_NAO_SUJEICAO = 3;

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }
        $message = [
            'designacao.required' => 'É obrigatório a indicação de um valor para o campo designação',
            'designacao.unique' => 'produto já cadastrado',
            'preco_venda.required' => 'É obrigatório a indicação de um valor para o campo preço venda',
            'status_id.required' => 'É obrigatório a indicação de um valor para o campo status',
            'stocavel.required' => 'É obrigatório a indicação de um valor para o campo Controlar Stock',
            'fabricante_id.required' => 'É obrigatório a indicação de um valor para o campo fabricante',
            'armazens.required' => 'É obrigatório a indicação de um valor para o campo armazens',
        ];
        $validator = Validator::make($request->all(), [
            'designacao' => ['required', 'min:3', 'max:255', new EmpresaUniqueApi('produtos', 'mysql2')],
            'preco_venda' => ['required', 'min:0'],
            'status_id' => ['required'],
            'codigo_taxa' => ['required'],
            'fabricante_id' => ['required'],
            'motivo_isencao_id' => [function ($atributo, $valor, $fail) use ($request) {
                if ($request->taxa <= 0 && $request->motivo_isencao_id == NULL) {
                    $fail('informe o motivo de isenção');
                }
            }],
            'stocavel' => ['required', function ($attribute, $estocavel, $fail) use ($request) {
                if ($estocavel == 1 && ($request->all()['quantidade'] == NULL && $request->all()['quantidade'] != 0)) {
                    $fail('informe a quantidade em estoque');
                }
            }],
            'armazens' => ['required']
        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        $message = [
            'armazem_id.required' => 'É obrigatório a indicação de um valor para o campo armazém',
            'quantidade.required' => 'É obrigatório a quantidade'
        ];
        foreach ($request->all()['armazens'] as $data) {

            $validator = Validator::make($data, [
                'armazem_id' => ['required'],
                'quantidade' => ['required']
            ], $message);

            if ($validator->fails()) {
                return response()->json($validator->errors()->messages(), 400);
            }
        }

        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->where('status_id', 1)->first();
        }


        if ($empresa->tipo_regime_id == $REGIME_GERAL) {
            if ($request->taxa > 0) {
                $motivo_isencao = NULL;
            } else {
                $motivo_isencao = $request->motivo_isencao_id;
            }
            $codigo_taxa = $request->codigo_taxa;
        } else if (($empresa->tipo_regime_id == $REGIME_TRANSITORIO) || ($empresa->tipo_regime_id == $REGIME_NAO_SUJEICAO)) {
            if ($request->motivo_isencao_id) {
                $motivo_isencao = $request->motivo_isencao_id;
                $codigo_taxa = 1;
            }
        }
        $produto = new Produto();

        $data_expiracao = date_format(date_create($request->data_expiracao), 'Y-m-d');

        $unidadeMedidaId = DB::connection('mysql2')->table('unidade_medidas')->where('empresa_id', $empresa_id)->first()->id;
        $fornecedorId = DB::connection('mysql2')->table('fabricantes')->where('diversos', "Sim")->where('empresa_id', $empresa_id)->first()->id;


        //try {
        $produto->designacao = $request->designacao;
        $produto->referencia = $request->referencia;
        $produto->codigo_barra = $request->codigo_barra;
        $produto->fabricante_id =  $request->fabricante_id ? $request->fabricante_id : $fornecedorId;
        $produto->status_id = $request->status_id;
        $produto->descricao = $request->descricao;
        $produto->data_expiracao = $data_expiracao;
        $produto->quantidade_minima = $request->quantidade_minima ? $request->quantidade_minima : 0;
        $produto->quantidade_critica = $request->quantidade_critica ? $request->quantidade_critica : 0;
        $produto->preco_compra = $request->preco_compra;
        $produto->preco_venda = $request->preco_venda;
        $produto->stocavel = $request->stocavel;
        $produto->classe_id = $request->classe_id;
        $produto->unidade_medida_id = $request->unidade_medida_id ?  $request->unidade_medida_id : $unidadeMedidaId;
        $produto->categoria_id = $request->categoria_id;
        $produto->marca_id = $request->marca_id;
        $produto->descricao = $request->descricao;
        $produto->canal_id = $request->canal_id ? $request->canal_id : $CANAL_CLIENTE;
        $produto->user_id = auth('EmpresaApi')->user()->id;
        $produto->codigo_taxa = $codigo_taxa;
        $produto->motivo_isencao_id = $motivo_isencao;
        $produto->empresa_id = $empresa_id;
        $produto->save();

        foreach ($request->all()['armazens'] as $armazem) {
            $existenciaEstoque = new ExistenciaStock();
            $existenciaEstoque->produto_id = $produto->id;
            $existenciaEstoque->armazem_id = $armazem['armazem_id'];
            if ($request->stocavel == "Não") {
                $existenciaEstoque->quantidade = 0;
            } else {
                $existenciaEstoque->quantidade = $armazem['quantidade'] ? (int) $armazem['quantidade'] : 0;
            }
            $existenciaEstoque->canal_id = $CANAL_CLIENTE;
            $existenciaEstoque->user_id = auth('EmpresaApi')->user()->id;
            $existenciaEstoque->status_id = $STATUS_ATIVO;
            $existenciaEstoque->empresa_id = $empresa_id;
            $existenciaEstoque->observacao = $request->descricao;
            $existenciaEstoque->save();

            if ($existenciaEstoque) {

                $actualizaStock = new AtualizacaoStocks();
                $actualizaStock->empresa_id = $empresa_id;
                $actualizaStock->produto_id = $produto->id;
                if ($request->stocavel == "Não") {
                    $actualizaStock->quantidade_antes = 0;
                    $actualizaStock->quantidade_nova = 0;
                } else {
                    $actualizaStock->quantidade_antes = $armazem['quantidade'] ? (int) $armazem['quantidade'] : 0;
                    $actualizaStock->quantidade_nova = $armazem['quantidade'] ? (int) $armazem['quantidade'] : 0;
                }
                $actualizaStock->user_id = auth('EmpresaApi')->user()->id;
                $actualizaStock->tipo_user_id = 2; //Empresa
                $actualizaStock->canal_id = $CANAL_CLIENTE;
                $actualizaStock->status_id = $STATUS_ATIVO;
                $actualizaStock->armazem_id = $armazem['armazem_id'];
                $actualizaStock->descricao = $request->descricao;
                $actualizaStock->save();
                return response()->json($produto, 200);
            }
        }
        //} catch (\Exception $th) {
        //      return response()->json('Erro ao cadastrar produtos', 422);
        //}
    }


public function listar_Quantidade_critica()
{
    $existenciaStock = ExistenciaStock::with(['produtos'])
    ->whereHas('produtos', function ($q) {
        $q->where('produtos.quantidade_critica', '!=', 0)
            ->where('produtos.empresa_id', auth()->user()->empresa_id)
            ->where('produtos.quantidade_critica', '>=', 'existencias_stocks.quantidade');
    })

    ->get();
    return view('empresa.produtos.listarProdutoQuantidadeCritica', compact('existenciaStock'));
       
}

}
