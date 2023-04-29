<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;

class LogAcesso extends Model
{
    protected $connection = 'mysql';
    protected $table="logs_acessos";
    protected $guarded = ['id'];
}
