<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class Gestor_Clientes extends Model
{
    protected $connection = 'mysql2';
    protected $table ='gestor_clientes';
    protected $primarykey = 'id';
    protected $guard = 'id';

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function empresa(){
        return $this->belongsTo(Empresa_Cliente::class, 'empresa_id');
    }

    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
}
