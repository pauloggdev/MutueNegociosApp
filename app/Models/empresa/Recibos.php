<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class Recibos extends Model
{
    protected $table = 'recibos';
    protected $connection = 'mysql2';


    // public function recibos_items()
    // {
    //     return $this->hasMany(RecibosItem::class, 'recibo_id', 'id');
    // }
    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function empresa()
    {
        return $this->belongsTo(Empresa_cliente::class, 'empresa_id');
    }
    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamentoGeral::class, 'forma_pagamento_id');
    }
    public function tipoUser()
    {
        return $this->belongsTo(TipoUser::class, 'tipo_user_id');
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where("nome_do_cliente", "like", $term)
            ->orwhere("numeracao_recibo", "like", $term)
            ->orwhereHas("factura", function($q) use($term){
                $q->where('numeracaoFactura', "like", $term);
            });
        });
    }
}
