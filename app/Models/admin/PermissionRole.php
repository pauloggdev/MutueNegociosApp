<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $connection = 'mysql';
    protected $table = 'permission_role';


    public function roles(){
        return $this->belongsToMany(Role::class);
    }
    // public function permissions(){
    //     return $this->belongsToMany(Permission::class);
    // }
   
}
