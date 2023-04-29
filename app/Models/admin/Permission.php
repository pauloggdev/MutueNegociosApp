<?php

namespace App\Models\admin;

use App\Models\empresa\Role;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $connection = 'mysql';

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
