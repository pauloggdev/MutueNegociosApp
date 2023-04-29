<?php

namespace App\Http\Controllers\empresa;

use App\Models\admin\Empresa;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\Gestor_Clientes;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\admin\Statu;
use App\Models\admin\User;
use App\Models\empresa\Statu as EmpresaStatu;
use App\Models\empresa\User as EmpresaUser;
use App\Rules\Empresa\EmpresaUnique;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;

class GestorController extends Controller
{

    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;

    public function __construct()
    {
        $this->middleware('auth');
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

        $data['gestores'] = Gestor_Clientes::with(['statuGeral', 'user', 'empresa'])->where('empresa_id', $empresa['empresa']['id'])->get();
        $data['status'] = EmpresaStatu::all();
        
        return view('empresa.gestores.index', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'min:3', new EmpresaUnique('users_admin', 'mysql2')],
            'email' => ['required', 'min:3', new EmpresaUnique('users_admin')],
            'status_id' => 'required'
        ]);

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

        $gestor = new Gestor_Clientes();





        try {

            $data = $request->except('email_verified_at');
            $data['password'] = Hash::make('mutue123');
            $data['canal_id'] = 2;
            $data['tipo_user_id'] = 2;
            $data['status_id'] = 1;
            $data['empresa_id'] = $empresa_id;
            $data['username'] = $data['name'];
            $data['remember_token'] = Session::token();


            if (isset($request->foto) || !empty($data['foto'])) {
                $photoName = rand(0, 10) . time() . '.' . $request->foto->getClientOriginalExtension();
                $destinationPath = public_path('/upload/utilizadores/cliente');
                $request->foto->move($destinationPath, $photoName);
                $data['foto'] = $photoName;
            }

            $user = EmpresaUser::create($data);

            if ($user) {
                $user->assignRole('Funcionario');
                $user->assignRole('Gestor_Cliente');

                $gestor->nome = $user->name;
                $gestor->user_id = $user->id;
                $gestor->canal_id = 3;
                $gestor->status_id = $user->status_id;
                $gestor->empresa_id = $empresa_id;
                $gestor->save();
            }

            return response()->json($gestor, 200);
        } catch (\Exception $th) {
            return response()->json("Erro! Não possível cadastrar, talvez hajam dados duplicados, verifique o email e o telefone", 500);
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


        $this->validate($request, [
            // 'nome' => ['required','min:3',new EmpresaUnique('gestor_clientes','mysql2', 'id',$id)],
            'email' => ['required', 'min:3', new EmpresaUnique('users_admin', 'mysql2', 'id', $request['user']['id'])],
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

        $gestor = Gestor_Clientes::where('id', $id)->where('empresa_id', $empresa_id)->first();
        //$user = EmpresaUser::where('id', $gestor->user_id)->where('empresa_id', $empresa_id)->first();


        $data = $request->except('email_verified_at');
        $data['password'] = Hash::make('mutue123');
        $data['canal_id'] = 2;
        $data['tipo_user_id'] = 2;
        $data['status_id'] = 1;
        $data['empresa_id'] = $empresa_id;
        $data['username'] = $data['name'];
        $data['remember_token'] = Session::token();


        // try {

        if (isset($request->foto) || !empty($data['foto'])) {
            $photoName = rand(0, 10) . time() . '.' . $request->foto->getClientOriginalExtension();
            $destinationPath = public_path('/upload/utilizadores/cliente');
            $request->foto->move($destinationPath, $photoName);
            $data['foto'] = $photoName;
        }

        if ((auth()->user()->hasRole('Empresa')) && (Auth::guard('web')->check())) {
            $users = User::where('id', $gestor->user_id)->update($request->except('email_verified_at'));
        } else {
            return response()->json('Sem permissão para efectuar esta operação!', 422);
        }

        // $user->update($data);

        if ($users) {
            $users->assignRole('Funcionario');
            $users->assignRole('Gestor_Cliente');

            $gestor->nome = $users->name;
            $gestor->user_id = $users->id;
            $gestor->canal_id = 3;
            $gestor->status_id = $users->status_id;
            $gestor->empresa_id = $empresa_id;
            $gestor->save();
        }

        return response()->json($gestor, 200);

        // } catch (\Exception $th) {
        //     return response()->json("Erro! Não possível cadastrar, talvez hajam dados duplicados, verifique o email e o telefone", 500);
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
        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            $operador = null;
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $operador = Auth::user()->id;
        }

        $gestor = Gestor_Clientes::where('id', $id)->where('empresa_id', $empresa_id)->first();
        $user = EmpresaUser::where('id', $gestor->user_id)->where('empresa_id', $empresa_id)->first();
        $gestor->delete();
        $user->delete();

        if ($user) {
            return response()->json($user, 200);
        }
    }
}
