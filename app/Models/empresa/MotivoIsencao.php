<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class MotivoIsencao extends Model
{
    protected $table = 'motivo';
    protected $connection = 'mysql2';
    protected $primaryKey = 'codigo';

}
