<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\admin\Factura;
use App\Models\admin\Empresa;

class Pagamento extends Model
{
    protected $connection = 'mysql';
    protected $table ='pagamentos';
    const ATIVO = 1;


    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id');
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamento::class, 'forma_pagamento_id');
    }
    public function contaMovimento()
    {
        return $this->belongsTo(Bancos::class, 'conta_movimentada_id');
    }

}
