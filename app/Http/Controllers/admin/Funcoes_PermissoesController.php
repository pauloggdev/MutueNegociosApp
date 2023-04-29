<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Models\admin\User;

class Funcoes_PermissoesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        $data = [];

        //$data['roles'] = Role::with('permissions')->where('guard_name', 'web')->get();
       // $data['permissions'] = Permission::with('roles')->where('guard_name', 'web')->get();

        return Response()->json($data);
    }

    public function funcao_permissao()
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        $data = [];

        // $data['roles'] = Role::with('permissions')->where('guard_name', 'web')->get();
        // $data['permissions'] = Permission::with('roles')->where('guard_name', 'web')->get();

        return view('admin.permissoes.funcao_vs_permissao', $data);
    }


    //assinar permissoes a user

    public function  concederPermissoes(Request $request, $user_id)
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        $user = User::find($user_id);
        $user->syncPermissions($request->except('_token'));

        return redirect('admin/usuarios/' . $user_id)->withSuccess('Permissões sincronizadas com sucesso!...');
    }

    //remover permissao a um user
    public function  removerPermissao(Request $request, $user_id)
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        $user = User::find($user_id);
        $user->revokePermissionTo($request->get('permissao'));

        return response()->json('Permissões removida com sucesso!...');
    }
    //conceder papel ou função ao user

    public function concederFuncoes(Request $request, $user_id)
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        $user = User::find($user_id);

        $user->syncRoles($request->except('_token'));

        return redirect('admin/usuarios/' . $user_id)->withSuccess('Funções sincronizadas com sucesso!...');
    }

    //remover função ou papel
    public function  removerFuncao(Request $request, $user_id)
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        $user = User::find($user_id);
        $user->removeRole($request->get('role'));

        return Response()->json('Função removida com sucesso!...');
    }


    public function funcoes()
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }
    }

    public function permissoes()
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if ((Auth::guard('web')->user()->tipo_user_id) == 2) {
            return view('empresa.dashboard');
        }

        // $id = $request->role_id;
        // if ($id) {
        //     $role = Role::find($id);
        //     $role->syncPermissions($request->get('permissions'));
        //     //$permission->syncRoles($roles);
        // }

        return redirect('admin/funcoes-permissoes')->withSuccess('Função associada com sucesso!...');
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
    }
}
