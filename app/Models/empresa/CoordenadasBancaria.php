<?php

namespace App\Models\empresa;

use App\Models\empresa\CanalComunicacao;
use Illuminate\Database\Eloquent\Model;

class CoordenadasBancaria extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'coordenadas_bancarias';

    protected $fillable = [
        'num_conta', 
        'iban', 
        'banco_id',
        'status_id', 
        'canal_id', 
        'user_id', 
        'status_id', 
        'status_id', 
    ];

    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
}
