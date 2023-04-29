<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class FacturaItemsOriginal extends Model
{
    protected $connection = 'mysql2';
    protected $table ='factura_items_original';

    public function produto(){
        return $this->belongsTo(Produto::class,'produto_id');
    }
    public function factura(){
        return $this->belongsTo(Factura::class,'factura_id');
    }
}
