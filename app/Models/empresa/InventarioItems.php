<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class InventarioItems extends Model
{
    protected $connection = 'mysql2';
    protected $table ='inventario_itens';

    public function produto(){
        return $this->belongsTo(Produto::class,'produto_id');
    }
}
