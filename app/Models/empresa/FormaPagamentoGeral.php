<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class FormaPagamentoGeral extends Model
{
    protected $connection = 'mysql2';
    protected $table ='formas_pagamentos_geral';

    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
   
}
