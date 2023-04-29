<?php

namespace App\Models\empresa;
use Illuminate\Database\Eloquent\Model;

class EntradaStock extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'entradas_stocks';
    //


    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }
    public function formaPagamento()
    {
        return $this->belongsTo(FormaPagamentoGeral::class);
    }
    public function armazem()
    {
        return $this->belongsTo(Armazen::class);
    }
    public function entradaStockItems()
    {
        return $this->hasMany(EntradaStockItems::class, 'entrada_stock_id');
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("descricao", "like", $term);
        });
    }
}
