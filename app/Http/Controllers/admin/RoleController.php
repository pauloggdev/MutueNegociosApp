<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Role;

class RoleController extends Controller
{

    public function index()
    {

        $data['roles'] = Role::with('permissions')->get();
        return view('admin.permissoes.funcaoIndex', $data);
    }
    public function listarPermissoes($roleId)
    {
        $permissionRole = Role::with(['permissions'])->find($roleId);
        return response()->json($permissionRole, 200);
    }
}
