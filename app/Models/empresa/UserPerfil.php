<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class UserPerfil extends Model
{

    public $timestamps = false;

    protected $table = "user_perfil";

    protected $fillable = [
        'user_id',
        'perfil_id'

    ];
}
