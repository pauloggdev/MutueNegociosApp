<?php

namespace App\Models\Traits;

use App\Models\empresa\Permission;
use App\Models\empresa\PermissionRole;
use App\Models\empresa\Role;
use App\Models\empresa\UserPerfil;
use App\Models\empresa\UserPermissions;

trait UserACLTrait
{

    public function permissoes()
    {
        $userPerfilPermissions = $this->userPerfilPermissions();

        $userPermissions = $this->userPermissions();

        foreach ($userPerfilPermissions as $userPerfilPermission) {
            if (!in_array($userPerfilPermission, $userPermissions)) {
                array_push($userPermissions, $userPerfilPermission);
            }
        }
        return $userPermissions;
    }

    public function userPerfilPermissions()
    {
        $array = [];
        $perfils = auth()->user()->perfils()->get();
        foreach ($perfils as $perfil) {
            $permissoes = PermissionRole::where('role_id', 11)->get();
            foreach ($permissoes as $p) {
                $permissao = Permission::where('id', $p->permission_id)->first();
                if (!in_array($permissao->name, $array)) {
                    array_push($array, $permissao->name);
                }
            }
        }
        return $array;
    }
    public function userPermissions()
    {
        $array = [];
        $permissions = UserPermissions::where('model_id', auth()->user()->id)->get();
        foreach ($permissions as $p) {
            $permissao = Permission::where('id', $p->permission_id)->first();
            if (!in_array($permissao->name, $array)) {
                array_push($array, $permissao->name);
            }
        }
        return $array;
    }
    public function perfils()
    {
        return $this->belongsToMany(Role::class, 'user_perfil', 'user_id', 'perfil_id');
    }
    public function hasPermission(string $permissionName): bool
    {
        return in_array($permissionName, $this->permissoes()) || $this->isSuperAdmin();
    }

    public function isSuperAdmin()
    {
        $user = UserPerfil::where('perfil_id', 1)->where('user_id', auth()->user()->id)->first();
        return $user;
    }
}
