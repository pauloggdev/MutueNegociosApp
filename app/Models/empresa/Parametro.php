<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class Parametro extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'parametros';

    protected $fillable = [
        'designacao',
        'valor', 
        'vida', 
        'empresa_id',
        'label'
    ];
}
