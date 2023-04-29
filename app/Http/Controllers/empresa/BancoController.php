<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateBancoFormRequest;
use App\Models\admin\Empresa;
use App\Models\empresa\Banco;
use App\Models\empresa\CanalComunicacao;
use App\Models\empresa\CoordenadasBancaria;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\Statu;
use App\Rules\Empresa\BancoEmpresaUnique;
use App\Rules\Empresa\EmpresaUnique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;


class BancoController extends Controller
{
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;

    public function __construct()
    {
        //$this->middleware('auth');
        // $this->middleware(['role_or_permission:Admin|Docente','auth'])->except('getProvaDoCandidato','guardarProvaDoCandidato');
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
        $data['bancos'] = Banco::with(['statuGeral'])->where('empresa_id', $empresa['empresa']['id'])->get();
        $data['status'] = Statu::all();
        return view('empresa.bancos.index', $data);
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
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $this->validate($request, [
            'designacao' => ['required', 'min:3', new EmpresaUnique('bancos', 'mysql2')],
            'num_conta' => ['required', new EmpresaUnique('bancos', 'mysql2')],
            'iban' => ['required', new EmpresaUnique('bancos', 'mysql2')],
            'sigla' => ['required', new EmpresaUnique('bancos', 'mysql2')],
            'status_id' => 'required'
        ]);

        $banco = new Banco();
        //   $coordenada = new CoordenadasBancaria();

        $banco->designacao = mb_strtoupper($request->designacao);
        $banco->sigla = mb_strtoupper($request->sigla);
        $banco->canal_id = 2; //canal do cliente
        $banco->status_id = $request->status_id;
        $banco->iban = $request->iban;
        $banco->num_conta = $request->num_conta;
        $banco->user_id = $empresa['operador'];
        $banco->tipo_user_id = $empresa['tipo_user_id'];
        $banco->empresa_id = $empresa['empresa']['id'];
        $banco->save();

        if ($banco) {
            return response()->json($banco, 200);
        } else {
            return response()->json('Erro ao salavar o banco', 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /* public function edit($id)
    {

        $id = base64_decode($id);

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }


        $data['banco'] = Banco::where('id', $id)->where('empresa_id', $empresa_id)->first();
        $data['canalComunicacao'] = CanalComunicacao::all();
        $data['status'] = Statu::all();

        return view('empresa.bancos.edit', $data);
    }*/

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

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $this->validate($request, [
            'designacao' => ['required', 'min:3', new EmpresaUnique('bancos', 'mysql2', 'id', $id)],
            'num_conta' => ['required', new EmpresaUnique('bancos', 'mysql2', 'id', $id)],
            'iban' => ['required', new EmpresaUnique('bancos', 'mysql2', 'id', $id)],
            'sigla' => ['required', new EmpresaUnique('bancos', 'mysql2', 'id', $id)],
            'status_id' => 'required'
        ]);


        $banco = Banco::where('id', $id)->where('empresa_id', $empresa['empresa']['id'])->first();

        $banco->designacao = mb_strtoupper($request->designacao);
        $banco->sigla = mb_strtoupper($request->sigla);
        $banco->canal_id = 2; //canal do cliente
        $banco->status_id = $request->status_id;
        $banco->iban = $request->iban;
        $banco->num_conta = $request->num_conta;
        $banco->user_id = $empresa['operador'];
        $banco->tipo_user_id = $empresa['tipo_user_id'];
        $banco->empresa_id = $empresa['empresa']['id'];
        $banco->save();

        if ($banco) {
            return response()->json($banco, 200);
        } else {
            return response()->json('Erro ao salvar o banco', 500);
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
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        // DB::beginTransaction();

        try {

            $bancos = Banco::where('empresa_id', $empresa['empresa']['id'])->get();

            //Se existe mais de um banco pode remover
            if (count($bancos) > 1) {

                DB::connection('mysql2')->table('bancos')->where('id', $id)->delete();
                DB::commit();
            } else {
                return response()->json(['isValid' => false, 'errors' => 'NÃ£o permitido eliminar todos bancos'], 403);
            }
        } catch (\Exception $th) {
            DB::rollBack();
        }
    }
    public function imprimirBancos()
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'bancos',
                'report_jrxml' => 'bancos.jrxml',
                'report_parameters' => [
                    "empresa_id" =>  $empresa['empresa']['id'],
                    "logotipo" => $caminho
                ]
            ]
        );
    }
}
