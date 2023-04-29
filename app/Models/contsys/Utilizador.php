<?php

namespace App\Models\contsys;

use Illuminate\Database\Eloquent\Model;

class Utilizador extends Model
{
    protected $connection = 'mysql3';
    protected $table = 'utilizadores';

    public $timestamps = false;

}
