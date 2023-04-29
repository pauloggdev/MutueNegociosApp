<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class RecibosItem extends Model
{
    
    protected $table = 'recibos_items';
    protected $connection = 'mysql2';


    public function factura(){

        return $this->belongsTo(Factura::class, 'factura_id');

    }

}
