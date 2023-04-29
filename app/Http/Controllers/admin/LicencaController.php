<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\CanalComunicacao;
use App\Models\admin\Empresa;
use Illuminate\Http\Request;
use App\Models\admin\Licenca;
use App\Models\admin\StatuGerais;
use App\Models\admin\StatuLicencas;
use App\Models\admin\TipoLicencas;
use App\Rules\Empresa\EmpresaUnique;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LicencaController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware(['role_or_permission:Admin|Docente','auth'])->except('getProvaDoCandidato','guardarProvaDoCandidato');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        $data['licencas'] = Licenca::with(['tipoLicenca', 'statuGeral'])->get();

        $data['tipolicencas'] = TipoLicencas::get();
        $data['status'] = StatuGerais::get();

        return view('admin.licencas.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        $message = [
            'designacao.required' => 'É obrigatório a indicação de um valor para o campo designação',
            'tipo_licenca_id.required' => 'É obrigatório a indicação de um valor para o campo tipo de licença',
            'limite_usuario.required' => 'É obrigatório a indicação de um valor para o campo limite usuário',
            'canal_id.required' => 'É obrigatório a indicação de um valor para o campo canal de comunicação',
        ];


        $this->validate($request, [

            'designacao' => ['required', new EmpresaUnique('licencas', 'mysql', $column = 'id', null, "status_licenca_id")],
            'status_licenca_id' => ['required', 'numeric'],
            'tipo_licenca_id' => ['required'],
            'valor' => ['required', 'numeric'],
            'canal_id' => ['required', 'numeric'],
            'limite_usuario' => ['required', 'numeric'],
        ], $message);

        try {
            $licenca = new Licenca();
            $licenca->tipo_licenca_id = $request->tipo_licenca_id;
            $licenca->designacao = $request->designacao;
            $licenca->status_licenca_id = $request->status_licenca_id;
            $licenca->canal_id = $request->canal_id;
            $licenca->user_id = Auth::user()->id;
            $licenca->descricao = $request->descricao;
            $licenca->valor = $request->valor;
            $licenca->tipo_taxa_id = 1; //taxa 0%
            $licenca->limite_usuario = $request->limite_usuario;
            $licenca->save();

            return response()->json($licenca, 200);
        } catch (\Exception $th) {
            return response()->json('Erro, ao cadastrar licenças', 400);
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
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
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
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        $data['licenca']  = Licenca::findOrfail($id);
        $data['canais_comunicacao'] = CanalComunicacao::all();
        $data['statuLicencas'] = StatuLicencas::whereBetween('id', [4, 5])
            ->get();

        $data['tipoLicencas'] = TipoLicencas::all();


        return view('admin.licencas.edit', $data);
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

        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }
        $message = [
            'designacao.required' => 'É obrigatório a indicação de um valor para o campo designação',
            'tipo_licenca_id.required' => 'É obrigatório a indicação de um valor para o campo tipo de licença',
            'limite_usuario.required' => 'É obrigatório a indicação de um valor para o campo limite usuário',
            'canal_id.required' => 'É obrigatório a indicação de um valor para o campo canal de comunicação',
        ];

        $this->validate($request, [

            'designacao' => ['required', new EmpresaUnique('licencas', 'mysql', $column = 'id', $id, "status_licenca_id")],
            'status_licenca_id' => ['required', 'numeric'],
            'tipo_licenca_id' => ['required'],
            'valor' => ['required', 'numeric'],
            'canal_id' => ['required', 'numeric'],
            'limite_usuario' => ['required', 'numeric'],
        ], $message);

        try {
            $licenca  = Licenca::find($id);
            $licenca->tipo_licenca_id = $request->tipo_licenca_id;
            $licenca->designacao = $request->designacao;
            $licenca->status_licenca_id = $request->status_licenca_id;
            $licenca->canal_id = $request->canal_id;
            $licenca->user_id = Auth::user()->id;
            $licenca->descricao = $request->descricao;
            $licenca->valor = $request->valor;
            $licenca->tipo_taxa_id = 1; //taxa 0%
            $licenca->limite_usuario = $request->limite_usuario;
            $licenca->save();

            return response()->json($licenca, 200);
        } catch (\Exception $th) {
            return response()->json('Erro, ao cadastrar licenças', 400);
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
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }
        try {
            $licenca  = Licenca::find($id);
            $licenca->delete();

            return response()->json($licenca, 200);
        } catch (\Throwable $th) {
            return response()->json('Erro, ao cadastrar licenças', 400);
        }
    }

    public function detalhes($id)
    {

        $id = base64_decode($id);

        $data['licenca'] = Licenca::find($id);
        $data['data_criada'] = $data['licenca']['created_at'] ? date('d-m-Y', strtotime($data['licenca']['created_at'])) : '';
        return view('admin.licencas.detalhes', $data);
    }


    public function imprimirLicencas()
    {


        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql")->select('select logotipo from empresas where id = :id', ['id' => 1]);
        $diretorio = public_path() . '\\upload\\' . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'Licencas',
                'report_jrxml' => 'Licencas.jrxml',
                'report_parameters' => [
                    "dirSubreportEmpresa" => public_path() . '/upload/admin/relatorios/',
                    "diretorio" =>  $diretorio,
                ]
            ]
        );
    }
    public function actualizarValorLicenca(Request $request)
    {
        DB::beginTransaction();
        try {

            $licenca =  DB::connection('mysql')->table('licenca_empresa')->where('empresa_id', $request->empresa_id)
                ->where('licenca_id', $request->licenca_id)->update([
                    'valor' => $request->valor
                ]);
            DB::commit();
            return response()->json($licenca, 200);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
    public function atribuirValorDefaultLicenca(){

        $empresas = DB::connection('mysql')->table('empresas')->get();

        // dd($empresas);

       foreach ($empresas as $key => $empresa) {
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

    }
    public function licencaPorEmpresaIndex()
    {
        $this->atribuirValorDefaultLicenca();

        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        $data['empresas'] = Empresa::with(['licencas', 'statusgerais', 'licencas.licenca'])->where('id', '!=', 1)->get();
        return view('admin.licencas.indexLicencaEmpresa', $data);
    }
}
