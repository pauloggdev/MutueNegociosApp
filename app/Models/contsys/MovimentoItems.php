<?php

namespace App\Models\contsys;

use Illuminate\Database\Eloquent\Model;

class MovimentoItems extends Model
{
    protected $connection = 'mysql3';
    protected $table ='movimentos_item';
    protected $primaryKey = 'Codigo';
    public $timestamps = false;
}
