<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\admin\AtivacaoLicenca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\empresa\User;
use Carbon\Carbon;
use App\Models\admin\Empresa;
use App\Models\contsys\Utilizador;
use App\Models\empresa\Empresa_Cliente;
use App\Notifications\EnviarCredenciasUsuario;
use App\Rules\Empresa\EmpresaUnique;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use VerificaSeEmpresaTipoAdmin;
    use TraitEmpresaAutenticada;
    use VerificaSeUsuarioAlterouSenha;



    public function __construct()
    {
        //$this->middleware('auth');
        // $this->middleware(['role_or_permission:Admin|Docente','auth'])->except('getProvaDoCandidato','guardarProvaDoCandidato');
    }

    public function checkedPermission(Request $request)
    {

        $isPermission = DB::connection('mysql2')->table('model_has_permissions')
            ->where('permission_id', $request->permissionId)
            ->where('model_id', $request->userId)->first();

        $countPermission = DB::connection('mysql2')->table('model_has_permissions')
            ->where('model_id', $request->userId)->count();
        if ($isPermission) {
            if ($countPermission <= 1) {
                return response()->json(['message' => 'Não permitido eliminar todas permissões'], 422);
            }
            DB::connection('mysql2')->table('model_has_permissions')
                ->where('permission_id', $request->permissionId)
                ->where('model_id', $request->userId)->delete();
        } else {
            DB::connection('mysql2')->table('model_has_permissions')->insert([
                'permission_id' => $request->permissionId,
                'model_id' => $request->userId,
                'model_type' => 'App\Models\empresa\User',
            ]);
        }
    }

    public function checkedRole(Request $request)
    {

        $isRoles = DB::connection('mysql2')->table('model_has_roles')
            ->where('role_id', $request->roleId)
            ->where('model_id', $request->userId)->first();

        $countRoles = DB::connection('mysql2')->table('model_has_roles')
            ->where('model_id', $request->userId)->count();
        if ($isRoles) {
            if ($countRoles <= 1) {
                return response()->json(['message' => 'Não permitido eliminar todas as funções'], 422);
            }
            DB::connection('mysql2')->table('model_has_roles')
                ->where('role_id', $request->roleId)
                ->where('model_id', $request->userId)->delete();
        } else {
            DB::connection('mysql2')->table('model_has_roles')->insert([
                'role_id' => $request->roleId,
                'model_id' => $request->userId,
                'model_type' => 'App\Models\empresa\User',
            ]);
        }
    }

    public function index(Request $request)
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

        $data['roles'] = DB::connection('mysql2')->table('roles')->get();
        $data['permissions'] = DB::connection('mysql2')->table('permissions')->get();

        $data['users'] = User::with(['statuGeral', 'roles'])->where('empresa_id', $empresa['empresa']['id'])->get();
        return view('empresa.usuarios.index', $data);

        //return response()->json($users);
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
    public function perfilUtilizador()
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

        $data['usuario'] = Auth::user();

        //dd(auth('empresa')->user());

        return view('empresa.usuarios.usuarioPerfil', $data);
    }
    public function visualizarFichaCadastro()
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml('
        <h4 style="text-align:center">FICHA DE CADASTRAMENTO</h4>
        <strong>Link de acesso: </strong> <a href="">' . env('APP_URL') . 'login</a><br>
        <strong>Email: </strong>' . Auth::user()->email . '<br>
        <strong>Telefone: </strong> ' . Auth::user()->telefone . '<br>
        <strong>Senha:</strong> mutue123<br><br>
        <span style="color:red;">OBS:</span><br>
        <span style="color:red;">Caso a palavra passe for diferente de <strong>mutue123</strong> é necessário que o utilizador acesse a tela de login para recuperar a sua senha</span>
        ');
        // (Optional) Setup the paper size and orientation
        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('FICHA_CADASTRAMENTO');
    }
    public function updateSenha(Request $request, $id)
    {

        $TIPO_EMPRESA = 2;
        $TIPO_ADMIN = 1;
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        DB::beginTransaction();

        try {

            $user = User::where('empresa_id', $empresa['empresa']['id'])->find($id);

            if (Hash::check($request->old_password, $user->password)) {

                DB::connection('mysql2')->table('users_cliente')
                    ->where('id', $user->id)
                    ->where('empresa_id', $empresa['empresa']['id'])->update([
                        'password' => Hash::make($request->password),
                        'updated_at' => Carbon::now(),
                        'status_senha_id' => 2
                    ]);

                DB::connection('mysql3')->table('utilizadores')->where('empresa_id', $empresa['empresa']['id'])->update([
                    'Password' => Hash::make($request->password),
                ]);

                DB::commit();
                return redirect('/empresa/usuario/perfil')->withSuccess('Operação efectuada com Sucesso!');
            } else {
                DB::rollBack();
                return redirect('/empresa/usuario/perfil')->withErrors('A senha antiga não corresponde com a deste utilizador!');
            }
            //code...
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }
    }

    /**
     * Store a newly created resource in upload.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $STATUS_ATIVO = 1;
        $CANAL_CLIENTE = 2;


        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }
        $data = json_decode($request->utilizador, true);

        if ($this->verificarNumeroUtilizadorPorLicenca()) {
            return response()->json(['error' => 'Atingiu o limite máximo de usuário para esta licença'], 400);
        }
        $message = [
            'name.required' => 'É obrigatório a indicação de um valor para o campo nome',
            'username.required' => 'É obrigatório a indicação de um valor para o campo username',
            'telefone.required' => 'É obrigatório a indicação de um valor para o campo telefone',
            'email.required' => 'É obrigatório a indicação de um valor para o campo email',
        ];

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'username' => ['required', 'string', 'max:30', 'min:3'],
            'telefone' => ['required', 'digits:9', new EmpresaUnique('users_cliente', 'mysql2', 'id')],
            'email' => ['required', 'string', 'email', 'max:255', new EmpresaUnique('users_cliente', 'mysql2', 'id')],
            'foto' => ['file', 'mimes:jpeg,png,jpg', 'max:300'],
        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 422);
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador()['empresa'];
        // $empresaContsys = DB::connection('mysql3')->table('empresas')->where('referenciaEmpresa', $empresa['referencia'])->get()[0];

        // try {
        $utilizador = new User();

        if (isset($request->foto) && !empty($request['foto']) && $request->foto != 'undefined') {
            $photoName = $request->foto->store('/utilizadores/cliente');
        } else {
            $photoName = "utilizadores/cliente/avatarEmpresa.png";
        }

        // dd($data);
        $utilizador->password = Hash::make('mutue123');
        $utilizador->name = $data['name'];
        $utilizador->username = $data['username'];
        $utilizador->tipo_user_id = 2; //tipo Empresa
        $utilizador->status_senha_id = 1; //senha vulneravel
        $utilizador->status_id = $STATUS_ATIVO;
        $utilizador->telefone = $data['telefone'];
        $utilizador->email = $data['email'];
        $utilizador->canal_id = $CANAL_CLIENTE;
        $utilizador->foto = $photoName;
        $utilizador->empresa_id = $empresa['id'];
        $utilizador->save();
        if ($utilizador) {
            $dataEmail = array(
                'email' => $data['email'],
                'senha' => 'mutue123',
                'linkLogin' => getenv('APP_URL')
            );

            //add função do utilizador

            DB::connection('mysql2')->table('model_has_roles')->insert([
                'role_id' => $data['role_id'],
                'model_id' => $utilizador->id,
                'model_type' => 'App\Models\empresa\User',
            ]);

            $utilizador->notify(new EnviarCredenciasUsuario($dataEmail));
            $this->cadastrarUtilizadorContsys($data, $utilizador, $empresa->id);
            return response()->json($utilizador, 200);


            //return redirect('empresa/usuarios')->withSuccess('Utilizador Registado com Sucesso!');
        }
    }

    public function verificarNumeroUtilizadorPorLicenca()
    {



        $empresaCliente = $this->pegarEmpresaAutenticadaGuardOperador()['empresa'];

        $empresaAdmin = DB::connection('mysql')->table('empresas')->where('referencia', $empresaCliente['referencia'])->first();
        $activacaoLicenca = AtivacaoLicenca::with(['licenca'])->where('empresa_id', $empresaAdmin->id)->where('status_licenca_id', 1)->get();
        $datactual = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));


        $limite_usuario = 0;
        foreach ($activacaoLicenca as $key => $activacao) {
            if ($activacao->licenca->id === 4) { //definitivo
                $limite_usuario += $activacao->licenca->limite_usuario;
                return;
            } else {
                $data_fim = Carbon::createFromFormat('Y-m-d', $activacao->data_fim);
                if ($data_fim >= $datactual) {
                    $limite_usuario += $activacao->licenca->limite_usuario;
                }
            }
        }
        $totalUsers = DB::connection('mysql2')->table('users_cliente')->where('empresa_id', $empresaCliente->id)->count();

        if ($totalUsers >= $limite_usuario) {
            return true;
        }
        return false;
    }

    public function cadastrarUtilizadorContsys($data, $usuario, $empresaId)
    {
        $STATUS_ATIVO = 1;
        $utilizador = new Utilizador();
        $utilizador->Nome = $data['name'];
        $utilizador->Username = $data['username'];
        $utilizador->Password = Hash::make('mutue123');
        $utilizador->CodStatus = $STATUS_ATIVO;
        $utilizador->CodTipoUser = 2;
        $utilizador->empresa_id = $empresaId;
        $utilizador->email = $data['email'];
        $utilizador->UserId = $usuario->id;
        $utilizador->save();
        return $utilizador->Codigo;
    }

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

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $data['user'] = User::findOrfail($id);
        $data['statusgerais'] = (DB::connection('mysql2')->table('status_gerais')->where('id', $data['user']->status_id)->first()->designacao) ? (DB::connection('mysql2')->table('status_gerais')->where('id', $data['user']->status_id)->first()->designacao) : '';
        // $data['roles'] = Role::with('permissions')->where('guard_name', 'empresa')->get();
        // $data['permissions'] = Permission::with('roles')->where('guard_name', 'empresa')->get();

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

        return view('empresa.permissoes.permissao', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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


        $data['user'] = User::where('empresa_id', $empresa['empresa']['id'])->findOrfail($id);

        return view('empresa.usuarios.edit', $data);
    }

    /**
     * Update the specified resource in upload.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $STATUS_ATIVO = 1;
        $CANAL_CLIENTE = 2;

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }
        $data = json_decode($request->utilizador, true);


        if (count($data['roles']) <= 0) {
            return response()->json(['error' => 'Informe uma função para o utilizador'], 400);
        }

        $message = [
            'name.required' => 'É obrigatório a indicação de um valor para o campo nome',
            'username.required' => 'É obrigatório a indicação de um valor para o campo username',
            'telefone.required' => 'É obrigatório a indicação de um valor para o campo telefone',
            'email.required' => 'É obrigatório a indicação de um valor para o campo email',
        ];

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:3'],
            'username' => ['required', 'string', 'max:30', 'min:3'],
            'telefone' => ['required', 'digits:9', new EmpresaUnique('users_cliente', 'mysql2', 'id', $id)],
            'email' => ['required', 'string', 'email', 'max:255', new EmpresaUnique('users_cliente', 'mysql2', 'id', $id)],
            'foto' => ['file', 'mimes:jpeg,png,jpg', 'max:300'],
        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 422);
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador()['empresa'];

        try {
            $utilizador = User::where('empresa_id', $empresa['id'])->where('id', $data['id'])->first();

            if (isset($request->foto) && !empty($request['foto']) && $request->foto != 'undefined') {
                $photoName = $request->foto->store('/utilizadores/cliente');
            } else {
                if (!$utilizador->foto) {
                    $photoName = "utilizadores/cliente/avatarEmpresa.png";
                } else {
                    $photoName = $utilizador->foto;
                }
            }

            // dd($data);
            $utilizador->name = $data['name'];
            $utilizador->username = $data['username'];
            $utilizador->tipo_user_id = 2; //tipo Empresa
            $utilizador->status_senha_id = 2; //senha vulneravel
            $utilizador->status_id = $STATUS_ATIVO;
            $utilizador->telefone = $data['telefone'];
            $utilizador->email = $data['email'];
            $utilizador->canal_id = $CANAL_CLIENTE;
            $utilizador->foto = $photoName;
            $utilizador->empresa_id = $empresa['id'];
            $utilizador->save();
            if ($utilizador) {

                //add função do utilizador
                // DB::connection('mysql2')->table('role_user')->where('user_id', $id)->delete();
                // foreach ($data['roles'] as $key => $role) {
                //     if ($role != null) {
                //         DB::connection('mysql2')->table('role_user')->insertGetId([
                //             'user_id' => $utilizador->id,
                //             'role_id' => $role,
                //         ]);
                //     }
                // }
                $this->actualizarUtilizadorContsys($data, $id);
                return response()->json($utilizador, 200);
                //return redirect('empresa/usuarios')->withSuccess('Utilizador Registado com Sucesso!');
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        // $data['password'] = Hash::make('mutue123');
        // $data['tipo_user_id = $request->tipo_user_id;
        // $status_senha_id = 1; //senha vulneravel
        // $status_id = $STATUS_ATIVO;
        // $telefone = $request->telefone;
        // $email = $request->email;
        // $canal_id = $CANAL_CLIENTE;
        // $empresa_id = $empresa['id'];

        // if (isset($request->foto) && !empty($request['foto'])) {
        //     $data['foto'] = $request->foto->store('/utilizadores/cliente');
        // } else {
        //     $data['foto'] = "utilizadores/cliente/avatarEmpresa.png";
        // }
        // $user = User::create($data);

        // if ($user) {
        //     $data = array(
        //         'email' => $request->email,
        //         'senha' => 'mutue123',
        //         'linkLogin' => getenv('APP_URL')
        //     );
        //     $user->notify(new EnviarCredenciasUsuario($data));
        //     $this->cadastrarUtilizadorContsys($request, $user, $empresaContsys->Codigo);
        //     return redirect('empresa/usuarios')->withSuccess('Utilizador Registado com Sucesso!');
        // }
    }

    // public function update(Request $request, $id, UserRepositorio $userRepositorio)
    // {


    //     if ($this->isAdmin()) {
    //         return view('admin.dashboard');
    //     }

    //     $this->validate($request, [
    //         'name' => ['required', 'string', 'max:255', 'min:3'],
    //         'username' => ['required', 'string', 'max:30', 'min:3'],
    //         'telefone' => ['required', 'digits:9', new EmpresaUnique('users_cliente', 'mysql2', 'id', $id)],
    //         'email' => ['required', 'string', 'email', 'max:255', new EmpresaUnique('users_cliente', 'mysql2', 'id', $id)],
    //         'logotipo' => ['file', 'mimes:jpeg,png,jpg', 'max:300'],
    //     ]);

    //     $userUpdate = $userRepositorio->update($request, $id);

    //     if ($userUpdate) {
    //         $this->actualizarUtilizadorContsys($request, $id);
    //         return redirect('empresa/usuarios')->withSuccess('Operação efectuada com Sucesso!');
    //     }
    // }

    public function actualizarUtilizadorContsys($data, $userId)
    {

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->where('status_id', 1)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->where('status_id', 1)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }
        $utilizadorId = DB::connection('mysql3')->table('utilizadores')->where('empresa_id', $empresa_id)->where('UserId', $userId)->update([
            'Nome' => $data['name'],
            'Username' => $data['username'],
        ]);
        return $utilizadorId;
    }


    public function update_senha(Request $request, $id)
    {


        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }


        $user = User::findOrfail($id);

        if ((auth()->user()->id == $id || auth()->user()->hasRole('Admin')) || (auth()->user()->id == $id || auth()->user()->hasRole('Super-Admin')) || (auth()->user()->id == $id || auth()->user()->hasRole('Empresa'))) {

            if (Hash::check($request->old_password, $user->password)) {
                $user->password = Hash::make($request->password);
                $user->updated_at = Carbon::now();
                $user->status_senha_id = 2;
                $user->remember_token = $request->_token;
                $user->assignRole('Funcionario');
                $user->save();
                return redirect('empresa/perfil')->withSuccess('Operação efectuada com Sucesso!');
            } else {
                $user->removeRole('Funcionario');
                return redirect('empresa/perfil')->withSuccess('Operação efectuada com Sucesso!');
            }
        } else {
            $user->removeRole('Funcionario');
            return redirect('empresa/perfil')->withSuccess('Operação efectuada com Sucesso!');
        }
    }
    //Aqui requer que o utilizador altere sua senha obrigatoriamente
    public function alterarPassword(Request $request, $id)
    {

        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;


        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        DB::beginTransaction();

        try {

            $user = User::where('empresa_id', $empresa['empresa']['id'])->find($id);

            if (Hash::check($request->old_password, $user->password)) {

                DB::connection('mysql2')->table('users_cliente')
                    ->where('id', $user->id)
                    ->where('empresa_id', $empresa['empresa']['id'])->update([
                        'password' => Hash::make($request->password),
                        'updated_at' => Carbon::now(),
                        'status_senha_id' => 2
                    ]);

                DB::connection('mysql3')->table('utilizadores')->where('empresa_id', $empresa['empresa']['id'])->update([
                    'Password' => Hash::make($request->password),
                ]);

                DB::commit();
                return response()->json($user, 200);
            } else {
                DB::rollBack();
                return response()->json(['msg' => 'A senha antiga não corresponde com a deste utilizador!'], 403);
            }
            //code...
        } catch (\Throwable $th) {
            DB::rollBack();
        }


        // if ($empresa['tipo_user_id'] === $TIPO_EMPRESA) {
        //     $user = User::where('empresa_id', $empresa['empresa']['id'])->find($empresa['guard']['id']);
        // } else if ($empresa['tipo_user_id'] === $TIPO_ADMIN) {
        //     $user = AdminUser::where('id', $empresa['guard']['id'])->find($id);
        // }
        // if (Hash::check($request->old_password, $user->password)) {
        //     $user->password = Hash::make($request->password);
        //     $user->updated_at = Carbon::now();
        //     $user->status_senha_id = 2;
        //     $user->save();
        //     return response()->json($user, 200);
        // } else {
        //     return response()->json(['msg' => 'A senha antiga não corresponde com a deste utilizador!'], 403);
        // }
    }


    public function alterarFoto(Request $request)
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
            return view('admin.dashboard');
        }

        //Guardar a foto do utilizador
        $user = auth()->user();
        $fotoname = time() . '.' . $request->foto->getClientOriginalExtension();
        if ($fotoname) {
            $request->foto->storeAs('utilizadores/fotos', $fotoname);
            $user->foto = $fotoname;
        }

        $user->save();

        return response()->json('Foto alterada com sucesso.');
    }

    /**
     * Remove the specified resource from upload.
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

        $empresaId = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];
        DB::beginTransaction();

        try {

            DB::connection('mysql2')->table('role_user')
                ->where('user_id', $id)->delete();

            DB::connection('mysql2')->table('users_cliente')
                ->where('empresa_id', $empresaId)->where('id', $id)->delete();


            DB::connection('mysql3')->table('utilizadores')
                ->where('UserId', $id)
                ->where('empresa_id', $empresaId)
                ->delete();

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Sem Permissão para eliminar o utilizador'], 422);
        }
    }

    public function deletarUtilizadorContsys($empresaId, $userId)
    {
        $utilizadorId = DB::connection('mysql3')->table('utilizadores')->where('empresa_id', $empresaId)->where('UserId', $userId)->delete();
        return $utilizadorId;
    }

    public function alterarSenhaApi(Request $request, $id)
    {

        $TIPO_EMPRESA = 2;
        $TIPO_ADMIN = 1;

        $message = [
            'password.required' => 'É obrigatório a indicação de campo password nova',
            'old_password.required' => 'É obrigatório a indicação de campo password antiga',
        ];

        $validator = Validator::make($request->all(), [
            'password' => ['required'],
            'old_password' => ['required'],
        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
            $user = User::where('empresa_id', $empresa_id)->find($id);
        }
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->updated_at = Carbon::now();
            $user->status_senha_id = 2;
            $user->save();
            $user->refresh();
            return response()->json($user, 200);
        } else {
            return response()->json('A senha antiga não corresponde com a deste utilizador!', 500);
        }
    }
}
