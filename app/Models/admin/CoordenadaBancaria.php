<?php

namespace App\Models\admin;
use Illuminate\Database\Eloquent\Model;

class CoordenadaBancaria extends Model
{
    protected $connection = 'mysql';
    protected $table ='coordenadas_bancarias';

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

    public function banco()
    {
        return $this->belongsTo(Bancos::class);
    }
    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }

    
}
