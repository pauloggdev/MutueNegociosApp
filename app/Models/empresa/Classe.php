<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    protected $connection = 'mysql2';
    protected $table ='classes';
    protected $primarykey = 'id';
    protected $guard = 'id';

    public function empresa(){
        return $this->belongsTo(Empresa_Cliente::class, 'empresa_id');
    }

    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
}
