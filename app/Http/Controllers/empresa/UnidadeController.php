<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use App\Models\empresa\UnidadeMedida;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\Statu;
use App\Rules\Empresa\EmpresaUnique;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use Illuminate\Support\Facades\DB;

class UnidadeController extends Controller
{
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;

    public function __construct()
    {
      //  $this->middleware('auth');
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

        $data['unidades'] = UnidadeMedida::with(['statuGeral', 'empresa'])->where('empresa_id', $empresa['empresa']['id'])->get();
        $data['status'] = Statu::all();

        return view('empresa.unidades.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {return view('admin.dashboard');}
        }

        return view('empresa.unidades.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {return view('admin.dashboard');}
        }

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            $operador = null;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $operador = Auth::user()->id;
        }

        $this->validate($request, [
            'designacao' => [
                'required',
                new EmpresaUnique('unidade_medidas')
            ],
            'status_id' => 'required'
        ]);

        $unidade = new UnidadeMedida();

        $unidade->designacao = $request->designacao;
        $unidade->status_id = $request->status_id;
        $unidade->canal_id = 2;
        $unidade->user_id = $operador;
        $unidade->empresa_id = $empresa_id;
        $unidade->save();

        if($unidade){
            return response()->json($unidade, 200);
        }else{
            return response()->json('Erro ao salvar a unidade', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {return view('admin.dashboard');}
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
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {return view('admin.dashboard');}
        }
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
        
        $this->validate($request, [
            'designacao' => [
                'required',
                new EmpresaUnique('unidade_medidas','mysql2', 'id',$id)
            ],
            'status_id' => 'required'
        ]);

        
        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            $operador = null;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $operador = Auth::user()->id;
        }

        $unidade = UnidadeMedida::where('id',$id)->where('empresa_id', $empresa_id)->first();
        $unidade->designacao = $request->designacao;
        $unidade->status_id = $request->status_id;
        $unidade->canal_id = 2;
        $unidade->user_id = $operador;
        $unidade->empresa_id = $empresa_id;
        $unidade->save();

        if($unidade){
            return response()->json($unidade, 200);
        }else{
            return response()->json('Erro ao salavar a unidade', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {return view('admin.dashboard');}
        }

        $unidade = UnidadeMedida::where("id", $id)->first();
        
        $unidade->delete();
        if ($unidade) {
            return response()->json($unidade, 200);
        }
    }
    public function imprimirUnidades(){
        
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" .$empresaLogotipo[0]->logotipo;

        $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;

        $todosStatus = 3;

        if ($status_id == 1 || $status_id == 2) {
            $marcaStatus = UnidadeMedida::where('empresa_id', $empresa['empresa']['id'])->where('status_id', $status_id)->get();

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
                  'report_file' => 'unidades',
                  'report_jrxml'=> 'unidades.jrxml',
                  'report_parameters' => $options
                    
              ]
          );
    }

    //API

    public function listarUnidadeMedidas(){
        
        $empresa_id = auth()->user()->empresa_id;
        $data['unidades'] = UnidadeMedida::with(['statuGeral', 'empresa'])->where('empresa_id', $empresa_id)->get();

        return response()->json($data, 200);
    }
}
