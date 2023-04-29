<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class LogAcesso extends Model
{
    protected $connection = 'mysql2';
    protected $table="log_acessos";
    protected $guarded = ['id'];
}
