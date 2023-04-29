<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'mysql';


    public function permissions(){

        return $this->belongsToMany(Permission::class);
    }
}
