<?php

namespace App\Models\contsys;

use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    protected $connection = 'mysql3';
    protected $table ='movimentos';
    protected $primaryKey = 'Codigo';
    public $timestamps = false;
}
