<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use App\Models\empresa\Armazen;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\ExistenciaStock;
use Illuminate\Support\Facades\Validator;
use App\Models\empresa\Statu;
use App\Rules\Empresa\EmpresaUnique;
use App\Rules\Empresa\MultEmpresaUnique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;

class ArmazenController extends Controller
{
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;


    public function __construct()
    {
        // $this->middleware('auth');
        //ghghgh
        //hhhhhhh
        // $this->middleware(['role_or_permission:Admin|Docente','auth'])->except('getProvaDoCandidato','guardarProvaDoCandidato');
    }
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        $data['armazens'] = Armazen::with('statuGeral')->where('empresa_id', $empresa['empresa']['id'])->get();
        $data['status'] = Statu::all();
        $data['guard'] = $empresa['guard'];
        $data['auth'] = Auth::guard('web')->check();
        return view('empresa.armazens.index', $data);
    }
    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
            $operador = null;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $operador = Auth::user()->id;
        }

        $this->validate($request, [
            'designacao' => ['required', 'min:3', new EmpresaUnique('armazens', 'mysql2')],
            'codigo' => [new MultEmpresaUnique('armazens', 'mysql2')],
            'localizacao' => 'required',
            'status_id' => 'required'
        ]);

        try {
            $armazen = new Armazen();

            $armazen->designacao = $request->designacao;
            $armazen->sigla = $request->sigla;
            $armazen->localizacao = $request->localizacao;
            $armazen->status_id = $request->status_id;
            $armazen->user_id = $operador;
            $armazen->empresa_id = $empresa_id;
            $armazen->save();

            $this->adicionarProdutoExistenciaEstoque($armazen);

            if ($armazen) {
                return response()->json($armazen, 200);
            }
        } catch (\Exception $th) {
            return response()->json("Erro! Não possível cadastrar", 500);
        }
    }

    public function adicionarProdutoExistenciaEstoque($armazen)
    {

        $QUANT_INICIAL = 0;
        $CANAL_PORTAL_EMPRESA = 2;
        $STATUS_ATIVO = 1;

        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];
        $produtos = DB::connection('mysql2')->table('produtos')->where('empresa_id', $empresa_id)->get();


        foreach ($produtos as $key => $produto) {
            $existenciaStock = new ExistenciaStock();
            $existenciaStock->produto_id = $produto->id;
            $existenciaStock->armazem_id = $armazen->id;
            $existenciaStock->quantidade = $QUANT_INICIAL;
            $existenciaStock->canal_id = $CANAL_PORTAL_EMPRESA;
            $existenciaStock->status_id = $STATUS_ATIVO;
            $existenciaStock->empresa_id = $empresa_id;
            $existenciaStock->save();
        }
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
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $data['armazen'] = Armazen::where('id', $id)->where('empresa_id', $empresa_id)->first();
        $data['status'] = Statu::all();

        return view('empresa.armazens.edit', $data);
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

        // dd($request->all());
        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
            $operador = null;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $operador = Auth::user()->id;
        }

        $this->validate($request, [
            'designacao' => ['required', 'min:3', new EmpresaUnique('armazens', 'mysql2', 'id', $id)],
            'codigo' => [new EmpresaUnique('armazens', 'mysql2', 'id', $id)],
            'localizacao' => 'required',
            'status_id' => 'required'
        ]);

        // try{
        $armazen = Armazen::where('id', $id)->first();

        $armazen->designacao = $request->designacao;
        $armazen->sigla = $request->sigla;
        $armazen->localizacao = $request->localizacao;
        $armazen->status_id = $request->status_id;
        $armazen->user_id = $operador;
        $armazen->empresa_id = $empresa_id;
        $armazen->save();

        if ($armazen) {
            return response()->json($armazen, 200);
        }
        // }catch (\Exception $th) {
        //     return response()->json($th->getMessage(), 500);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {


        $empresa = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']; //empresa cliente

        try {
            $armazen = Armazen::where("id", $id)
                ->where('empresa_id', $empresa['id'])
                ->first();
            $armazen->delete();
            if ($armazen) {
                return response()->json($armazen, 200);
            }
        } catch (\Exception $th) {
            return response()->json("Erro! Não possível Eliminar", 500);
        }
    }

    public function pegarDependencias()
    {

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $data['status_gerais'] = DB::connection('mysql2')->table('status_gerais')->orderBy('designacao', 'ASC')->get();

        return Response()->json($data);
    }
    public function imprimirArmazens()
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;

        $todosStatus = 3;

        if ($status_id == 1 || $status_id == 2) {
            $marcaStatus = Armazen::where('empresa_id', $empresa['empresa']['id'])->where('status_id', $status_id)->get();

            if (count($marcaStatus) == 0) {
                $status_id = $todosStatus;
            }
        }

        if ($status_id == 3) {
            $options = ["diretorio" => $caminho, "empresa_id" => $empresa['empresa']['id'], "status_id" => "%"]; //parametros where do report
        } else {
            $options = ["diretorio" => $caminho, "empresa_id" => $empresa['empresa']['id'], "status_id" => "%" . $status_id]; //parametros where do report
        }

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'armazens',
                'report_jrxml' => 'armazens.jrxml',
                'report_parameters' => $options

            ]
        );
    }
    //API
    public function listarArmazens()
    {
        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
        }

        $data['armazens'] = Armazen::with('statuGeral')->where('empresa_id', $empresa_id)->get();
        return response()->json($data, 200);
    }
    public function storeApi(Request $request)
    {

        $QUANT_INICIAL = 0;
        $CANAL_PORTAL_EMPRESA = 2;
        $STATUS_ATIVO = 1;

        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
        }

        $this->validate($request, [
            'designacao' => ['required', 'min:3', new MultEmpresaUnique('armazens', 'mysql2')],
            'codigo' => [new MultEmpresaUnique('armazens', 'mysql2')],
            'localizacao' => 'required',
            'status_id' => 'required'
        ]);

        DB::beginTransaction();

        try {

            $armazenId = DB::connection('mysql2')->table('armazens')->insertGetId([

                'designacao' => $request->designacao,
                'sigla' => $request->sigla,
                'localizacao' => $request->localizacao,
                'status_id' => $request->status_id,
                'user_id' => auth('EmpresaApi')->user()->id,
                'empresa_id' => $empresa_id
            ]);
            $produtos = DB::connection('mysql2')->table('produtos')->where('empresa_id', $empresa_id)->get();

            foreach ($produtos as $key => $produto) {
                DB::connection('mysql2')->table('existencias_stocks')->insertGetId([
                    'produto_id' => $produto->id,
                    'armazem_id' => $armazenId,
                    'quantidade' => $QUANT_INICIAL,
                    'canal_id' => $CANAL_PORTAL_EMPRESA,
                    'status_id' => $STATUS_ATIVO,
                    'empresa_id' => $empresa_id
                ]);
            }
            if ($armazenId) {
               DB::commit();
                return response()->json($armazenId, 200);
            }
        } catch (\Exception $th) {
            DB::rollBack();
           return response()->json("Erro! Não possível cadastrar", 500);
        }
    }
}
