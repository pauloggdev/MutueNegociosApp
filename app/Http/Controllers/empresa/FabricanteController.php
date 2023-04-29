<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\admin\Empresa;
use App\Models\empresa\CanalComunicacao;
use App\Models\empresa\Empresa_Cliente;
use Illuminate\Http\Request;
use App\Models\empresa\Fabricante;
use Illuminate\Support\Facades\Validator;
use App\Models\empresa\Statu;
use App\Rules\Empresa\EmpresaUnique;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Illuminate\Support\Facades\Auth;

use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use Illuminate\Support\Facades\DB;

class FabricanteController extends Controller
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

        $data['fabricantes'] = Fabricante::with('statuGeral')->where('empresa_id', $empresa['empresa']['id'])->get();
        $data['status'] = Statu::all();

        return view('empresa.fabricantes.index', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $TIPO_USER_EMPRESA = 2;
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
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
                'required', 'min:3',
                new EmpresaUnique('fabricantes', 'mysql2')
            ],
            'status_id' => 'required'
        ]);


        $fabricante = new Fabricante();

        $fabricante->designacao = $request->designacao;
        $fabricante->empresa_id = $empresa_id;
        $fabricante->user_id = $operador;
        $fabricante->canal_id = 2; //canal do cliente
        $fabricante->status_id = $request->status_id;
        $fabricante->tipo_user_id = $TIPO_USER_EMPRESA;
        $fabricante->save();

        if ($fabricante) {
            return response()->json($fabricante, 200);
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
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
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


        $data['fabricante'] = Fabricante::where('empresa_id', $empresa_id)->find($id);
        $data['canalComunicacao'] = CanalComunicacao::all();
        $data['status'] = Statu::all();

        return view('empresa.fabricantes.edit', $data);
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

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
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
                'min:3',
                new EmpresaUnique('fabricantes', 'mysql2', 'id', $id)
            ],
            'status_id' => 'required'
        ]);

        $fabricante = Fabricante::where('id', $id)->where('empresa_id', $empresa_id)->first();
        $fabricante->designacao = $request->designacao;
        $fabricante->empresa_id = $empresa_id;
        $fabricante->user_id = $operador;
        $fabricante->canal_id = 2; //canal do cliente
        $fabricante->status_id = $request->status_id;
        $fabricante->save();

        if ($fabricante) {
            return response()->json($fabricante, 200);
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
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }
        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            $operador = null;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $operador = Auth::user()->id;
        }

        $fabricante = Fabricante::where('empresa_id', $empresa_id)->where("id", $id)->get()->first();
        $fabricante->delete();
        if ($fabricante) {
            return response()->json($fabricante, 200);
        }
    }
    public function imprimirFabricantes()
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;


        // $status_id = isset($_GET['status']) ? (int)$_GET['status'] : 3;

        // $todosStatus = 3;

        // if ($status_id == 1 || $status_id == 2) {
        //     $marcaStatus = Fabricante::where('empresa_id', $empresa['empresa']['id'])->where('status_id', $status_id)->get();

        //     if (count($marcaStatus) == 0) {
        //         $status_id = $todosStatus;
        //     }
        // }

        // if ($status_id == 3) {
        //     $options = ["diretorio" => $caminho, "empresa_id" => $empresa['empresa']['id']]; //parametros where do report
        // } else {
        //     $options = ["diretorio" => $caminho, "empresa_id" => $empresa['empresa']['id']]; //parametros where do report
        // }

        // dd($empresa['empresa']['id']);

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'fabricantes',
                'report_jrxml' => 'fabricantes.jrxml',
                'report_parameters' => [
                    'diretorio' => $caminho,
                    'empresa_id' => $empresa['empresa']['id'],
                ]

            ]
        );
    }

    //API
    public function listarFabricantes()
    {
        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
        }

        $data['fabricantes'] = Fabricante::with('statuGeral')->where('empresa_id', $empresa_id)->get();

        return response()->json($data, 200);
    }
}
