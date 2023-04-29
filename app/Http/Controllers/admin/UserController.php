<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\admin\User;
use App\Models\admin\Empresa;
use App\Models\empresa\Empresa_Cliente;
use App\Notifications\admin\EnviarCredenciasUsuario;
use App\Rules\Empresa\EmpresaUnique;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function __construct()
    {

        //$this->middleware('auth');
        // $this->middleware(['role_or_permission:Admin|Docente','auth'])->except('getProvaDoCandidato','guardarProvaDoCandidato');
    }

    public function index(Request $request)
    {
	
           
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        // $data['users'] = User::with(['statuGeral'])->get();


        $data['users'] = User::with(['statuGeral', 'roles'])->where('tipo_user_id', 1)->get();
	        return view('admin.usuarios.index', $data);
    }

    public function pesquisar(Request $request)
    {
        $users = User::where('id', $request->get('palavra_chave'))
            ->orWhere('telefone', 'LIKE', '%' . $request->get('palavra_chave') . '%')
            ->orWhere('name', 'LIKE', '%' . $request->get('palavra_chave') . '%')
            ->orWhere('email', 'LIKE', '%' . $request->get('palavra_chave') . '%')
            ->orderBy('name')
            ->paginate();

        return Response()->json($users);
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

        $PORTAL_ADMIN = 3;
        $STATUS_ATIVO = 1;
        $USER_TIPO_ADMIN = 1;
        $SENHA_VULNERAVEL = 1;

        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        $data = json_decode($request->utilizador, true);

        $validate = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'canal_id' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', new EmpresaUnique('users_admin', 'mysql')],
            'username' => ['required', 'string', 'max:30'],
            'telefone' => ['required', 'digits:9', new EmpresaUnique('users_admin', 'mysql')],
            'foto' => ['file', 'mimes:jpeg,png,jpg', 'max:300']
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        if (isset($request->foto) && !empty($request->foto)) {
            $photoName = $request->foto->store('/admin');
        } else {
            $photoName = "admin/avatarEmpresa.jpg";
        }

        try {

            $utilizador = new User();
            $utilizador->name = $data['name'];
            $utilizador->telefone = $data['telefone'];
            $utilizador->email = $data['email'];
            $utilizador->password = Hash::make('mutue123');
            $utilizador->canal_id = $data['canal_id'];
            $utilizador->tipo_user_id = $USER_TIPO_ADMIN;
            $utilizador->status_id = $STATUS_ATIVO;
            $utilizador->status_senha_id = $SENHA_VULNERAVEL;
            $utilizador->username = $data['username'];
            $utilizador->foto = $photoName;
            $utilizador->save();

            if ($utilizador) {
                $dataEmail = array(
                    'email' => $data['email'],
                    'senha' => 'mutue123',
                    'linkLogin' => getenv('APP_URL')
                );
                //add função do utilizador
                foreach ($data['roles'] as $key => $role) {
                    if ($role != null) {
                        DB::connection('mysql')->table('role_user')->insertGetId([
                            'user_id' => $utilizador->id,
                            'role_id' => $role,
                        ]);
                    }
                }
                $utilizador->notify(new EnviarCredenciasUsuario($dataEmail));
                return response()->json($utilizador, 200);
            }
        } catch (\Throwable $th) {
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

        $data['user'] = User::findOrfail($id);
        $data['statusgerais'] = (DB::table('status_gerais')->where('id', $data['user']->status_id)->first()->designacao) ? (DB::table('status_gerais')->where('id', $data['user']->status_id)->first()->designacao) : '';
        // $data['roles'] = Role::with('permissions')->where('guard_name', 'web')->get();
        // $data['permissions'] = Permission::with('roles')->where('guard_name', 'web')->get();

        // $permissaoId = [];
        // $funcaoId = [];
        // $i = 0;
        // foreach ($data['user']->permissions as $permissao) {
        //     $permissaoId[$i] = $permissao->id;
        //     $i++;
        // }
        // foreach ($data['user']->roles as $funcao) {
        //     $funcaoId[$i] = $funcao->id;
        //     $i++;
        // }
        // $data['permissao_id'] = $permissaoId;
        // $data['funcao_id'] = $funcaoId;

        return view('admin.permissoes.permissao', $data);
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
        $data = json_decode($request->utilizador, true);

        $STATUS_ATIVO = 1;
        $USER_TIPO_ADMIN = 1;
        $SENHA_VULNERAVEL = 1;

        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        $data = json_decode($request->utilizador, true);

        $validate = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'canal_id' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', new EmpresaUnique('users_admin', 'mysql')],
            'username' => ['required', 'string', 'max:30'],
            'telefone' => ['required', 'digits:9', new EmpresaUnique('users_admin', 'mysql')]
        ]);
        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $userFotoAnterior = $this->verificarExisteFoto($data['id']); //Pega foto anterior


        if (isset($request->foto) && !empty($request->foto)) {

            if ($userFotoAnterior && $userFotoAnterior->foto != "admin/avatarEmpresa.jpg") {
                unlink(public_path() . "\.." . "\\storage\\app\\public\\" . $data['foto']);
            }
            $photoName = $request->foto->store('/admin');
        } else {

            if ($userFotoAnterior) {
                $photoName = $userFotoAnterior->foto;
            } else {
                $photoName = "admin/avatarEmpresa.jpg";
            }
        }

        try {
            $utilizador = User::find($id);
            $utilizador->name = $data['name'];
            $utilizador->telefone = $data['telefone'];
            $utilizador->email = $data['email'];
            $utilizador->password = Hash::make('mutue123');
            $utilizador->canal_id = $data['canal_id'];
            $utilizador->tipo_user_id = $USER_TIPO_ADMIN;
            $utilizador->status_id = $STATUS_ATIVO;
            $utilizador->status_senha_id = $SENHA_VULNERAVEL;
            $utilizador->username = $data['username'];
            $utilizador->foto = $photoName;
            $utilizador->save();

            if ($utilizador) {
                //add função do utilizador
                DB::connection('mysql')->table('role_user')->where('user_id', $id)->delete();
                foreach ($data['roles'] as $key => $role) {
                    if ($role != null) {
                        DB::connection('mysql')->table('role_user')->insertGetId([
                            'user_id' => $utilizador->id,
                            'role_id' => $role,
                        ]);
                    }
                }
            }
            return response()->json($utilizador, 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
    public function verificarExisteFoto($userId)
    {
        return DB::connection('mysql')->table('users_admin')->where('id', $userId)->first();
    }

    public function update_senha(Request $request, $id)
    {
        //$user = auth()->user(); //recuperar user logado
        if ((auth()->user()->id == $id || auth()->user()->hasRole('Admin')) || (auth()->user()->id == $id || auth()->user()->hasRole('Super-Admin')) || (auth()->user()->id == $id || auth()->user()->hasRole('Empresa'))) {
            $user = User::findOrfail($id);

            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->updated_at = Carbon::now();
                $user->status_senha_id = 2;
                $user->remember_token = $request->_token;
                $user->assignRole('Empresa');
                $user->save();
                return redirect()->route('perfil')->withSuccess(' Senha Alterada com Sucesso!');
            } else {
                $user->removeRole('Empresa');
                return redirect()->back()->withErrors('A senha antiga não corresponde com a deste utilizador!');
            }
        } else {
            $user->removeRole('Empresa');
            return redirect()->back()->withErrors('Sem permissão para efectuar esta operação!');
        }
    }


    //Aqui requer que o utilizador altere sua senha obrigatoriamente
    public function alterarPassword(Request $request, $id)
    {
        //$user = auth()->user(); //recuperar user logado
        if ((auth()->user()->id == $id || auth()->user()->hasRole('Admin')) || (auth()->user()->id == $id || auth()->user()->hasRole('Super-Admin')) || (auth()->user()->id == $id || auth()->user()->hasRole('Empresa'))) {
            $user = User::findOrfail($id);

            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->updated_at = Carbon::now();
                $user->status_senha_id = 2;
                $user->assignRole('Empresa');
                $user->save();
                return response()->json($user, 200);
            } else {
                $user->removeRole('Empresa');
                return response()->json(['msg' => 'A senha antiga não corresponde com a deste utilizador!'], 403);
            }
        } else {
            $user->removeRole('Empresa');
            return response()->json(['msg2' => 'Sem permissão para efectuar esta operação!'], 403);
        }
    }


    public function update_logomarca(Request $request, $id)
    {



        if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
            return view('admin.dashboard');
        }

        $user = auth()->user(); //recuperar user logado

        if (($user->id == $id && $user->hasRole('Empresa')) && (Auth::guard('web')->check())) {

            $empresas_adm = Empresa::where('user_id', $id)->first();
            $empresas_cli = Empresa_Cliente::where('referencia', $empresas_adm->referencia)->first();

            $users = User::findOrfail($id);
            $empresa_adm = Empresa::findOrfail($empresas_adm->id);
            $empresa_cl = Empresa_Cliente::findOrfail($empresas_cli->id);



            if (isset($request->logotipo) && !empty($request->logotipo)) {

                //remove foto anterior
                if ($users->foto && $users->foto != "utilizadores/cliente/avatarEmpresa.png") {
                    try {
                        unlink(public_path() . "\.." . "\\storage\\app\\public\\" . $users->foto);
                    } catch (\ErrorException $th) {
                        $photoName = $request->logotipo->store('/utilizadores/cliente');
                    }
                }

                $this->validate($request, [
                    'logotipo' => ['file', 'mimes:jpeg,png,jpg', 'max:300'],
                ]);


                $photoName = $request->logotipo->store('/utilizadores/cliente');



                // dd($file);
                // $photoName = env('APP_URL').'/upload/'.$file;

                // $photoName = $empresa_adm->referencia . time() . '.' . $request->logotipo->getClientOriginalExtension();
                // $destinationPath = public_path('/upload/utilizadores/cliente');
                // $request->logotipo->move($destinationPath, $photoName);
                $users->foto = $photoName ? $photoName : "utilizadores/cliente/avatarUser.png";
                $empresa_adm->logotipo = $photoName;
                $empresa_cl->logotipo = $photoName;
            }

            $users->save();
            $empresa_adm->save();
            $empresa_cl->save();

            return redirect()->route('home')->withSuccess(' Logomarca Alterada com Sucesso!');
        } else {
            return redirect()->back()->withErrors('Não Foi Possível Actualizar');
        }
    }

    public function alterarFoto(Request $request)
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }


        //Guardar a foto do utilizador
        $user_id = auth()->user();
        $user = User::findOrfail($user_id);
        $fotoname = time() . '.' . $request->foto->getClientOriginalExtension();

        if ($fotoname) {
            $request->foto->storeAs('utilizadores/admin', $fotoname);
            $user->foto = $fotoname;
        }

        $user->save();

        return response()->json('Foto alterada com sucesso.');
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

            DB::connection('mysql')->table('role_user')
                ->where('user_id', $id)->delete();

            DB::connection('mysql')->table('users_admin')->where('id', $id)->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Sem Permissão para eliminar o utilizador'], 422);
        }
    }
    public function perfilUtilizador()
    {

        $data['usuario'] = Auth::user();
        return view('admin.usuarios.perfil', $data);
    }
    public function updateSenha(Request $request, $id)
    {

        DB::beginTransaction();

        try {

            $user = User::find($id);

            if (Hash::check($request->old_password, $user->password)) {

                DB::connection('mysql')->table('users_admin')->update([
                    'password' => Hash::make($request->password),
                    'updated_at' => Carbon::now(),
                ]);

                DB::commit();
                return redirect('/admin/usuario/perfil')->withSuccess('Operação efectuada com Sucesso!');
            } else {
                DB::rollBack();
                return redirect('/admin/usuario/perfil')->withErrors('A senha antiga não corresponde com a deste utilizador!');
            }
            //code...
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function imprimirUtilizador()
    {

        $empresaLogotipo = DB::connection("mysql")->select('select logotipo from empresas where id = :id', ['id' => 1]);
        $diretorio = public_path() . '\\upload\\' . $empresaLogotipo[0]->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'utilizadores',
                'report_jrxml' => 'utilizadores.jrxml',
                'report_parameters' => [
                    "dirSubreportEmpresa" => public_path() . '/upload/admin/relatorios/',
                    "diretorio" =>  $diretorio,
                ]
            ]
        );
    }
}
