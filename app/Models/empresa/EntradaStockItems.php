<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class EntradaStockItems extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'entradas_stock_items';


    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
