<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\Permission;
use App\Models\empresa\PermissionRole;
use App\Models\empresa\UserPermissions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;


class PermissaoRepository
{
    protected $entity;
    protected $permissionRole;
    protected $userPermissions;

    public function __construct(Permission $permissao, PermissionRole $permissionRole, UserPermissions $userPermissions)
    {
        $this->entity = $permissao;
        $this->permissionRole = $permissionRole;
        $this->userPermissions = $userPermissions;
    }

    public function checkPermissaoPorRole($permissaoId, $roleId)
    {
        $permissao = $this->permissionRole::where('role_id', $roleId)
            ->where('permission_id', $permissaoId)
            ->first();


        if ($permissao) {
            return DB::table('role_has_permissions')->where('role_id', $roleId)
                ->where('permission_id', $permissaoId)->delete();
        } else {
            return DB::table('role_has_permissions')->insert([
                'permission_id' => $permissaoId,
                'role_id' => $roleId
            ]);
        }
    }
    public function checkPermissaoPorUsuario($permissaoId, $userId)
    {
        $permissao = $this->userPermissions::where('model_id', $userId)
            ->where('permission_id', $permissaoId)
            ->first();


        if ($permissao) {
            return DB::table('model_has_permissions')->where('model_id', $userId)
                ->where('permission_id', $permissaoId)->delete();
        } else {
            return DB::table('model_has_permissions')->insert([
                'permission_id' => $permissaoId,
                'model_type' => 'App\Models\empresa\User',
                'model_id' => $userId
            ]);
        }
    }


    public function getPermissoes($search)
    {
        $permissoes = $this->entity::search(trim($search))->get();
        return $permissoes;
    }
    public function getPermissoesComPaginacao($search)
    {
        $permissoes = $this->entity::search(trim($search))->paginate();
        return $permissoes;
    }
    public function getPermissoesPorRole($roleId)
    {
        $permissoes = $this->permissionRole::where('role_id', $roleId)->get();
        return $permissoes;
    }
    public function getPermissoesPorUsuario($userId)
    {
        $permissoes = $this->userPermissions::where('model_id', $userId)->get();
        return $permissoes;
    }

    // public function getMarca(int $id)
    // {
    //     $marca = $this->entity::where('empresa_id', auth()->user()->empresa_id)
    //     ->where('id', $id)
    //     ->first();
    //     return $marca;

    // }

    // public function store($data)
    // {
    //     $marcas = $this->entity::create([
    //         'designacao' => $data['designacao'],
    //         'user_id' => auth()->user()->id,
    //         'empresa_id' => auth()->user()->empresa_id,
    //         'status_id' => $data['status_id'],
    //         'canal_id' => $data['canal_id'] ? $data['canal_id'] : 2,

    //     ]);

    //     return $marcas;
    // }

    // public function update($data)
    // {

    //     $marca = $this->entity::where('empresa_id', auth()->user()->empresa_id)
    //         ->where('id', $data['id'])
    //         ->update([

    //         'user_id' => auth()->user()->id,
    //         'empresa_id' => auth()->user()->empresa_id,
    //         'status_id' => $data['status_id'],
    //         'designacao' => $data['designacao'],
    //         'canal_id' => $data['canal_id'] ? $data['canal_id'] : 2,

    //     ]);

    //     return $marca;
    // }
}
