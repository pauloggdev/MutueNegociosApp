<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Permission;
use App\Models\admin\PermissionRole;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{


    public function index()
    {

        //$data['permissions'] = Permission::with('roles')->get();
        //return view('admin.permissoes.permissaoIndex', $data);
    }

    public function listarRole($permissionId)
    {

      //  $roles = Permission::with(['roles'])->find($permissionId);
       // return response()->json($roles, 200);
    }

    public function destroy($permissionId)
    {
        DB::beginTransaction();
        
        try {
            DB::connection('mysql')->table('permission_role')
                ->where('permission_id', $permissionId)->delete();

            DB::connection('mysql')->table('permissions')
                ->where('id', $permissionId)->delete();

            DB::commit();
            return response()->json('Permissões eliminado com sucesso', 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['error' => 'Erro ao eliminar permissões'], 422);
        }
    }
}
