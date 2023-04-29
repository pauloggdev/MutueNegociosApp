<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'role_has_permissions';
    public $timestamps = false;

    protected $fillable = [
        'permission_id', 
        'role_id'
    ];

    // public function perfil(){
    //     return $this->belongsToMany(Role::class,'role_has_permissions','role_id', 'permission_id');
    // }
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, PermissionRole::class, 'permission_id', 'role_id');
    }
    public function perfis()
    {
        return $this->belongsToMany(Role::class, UserPerfil::class, 'user_id', 'perfil_id');

    }
   
}
