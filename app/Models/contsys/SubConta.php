<?php

namespace App\Models\contsys;

use Illuminate\Database\Eloquent\Model;

class SubConta extends Model
{

    protected $connection = 'mysql3';
    protected $table ='subcontas';
    protected $primaryKey = 'Codigo';
    public $timestamps = false;

    //
}
