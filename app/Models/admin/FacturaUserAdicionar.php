<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Keygen\Keygen;

class FacturaUserAdicionar extends Model
{
    protected $connection = 'mysql';
    protected $table ='facturas_users_adicionais';    
}
