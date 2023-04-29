<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class NotaCreditoItems extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'nota_credito_items';



    const CREATED_AT = NULL;

    /**
     * The name of the "updated at" column.
     *
     * @var string|null
     */
    const UPDATED_AT = NULL;

    public function produto(){
        return $this->belongsTo(Produto::class,'produto_id');
    }
    public function factura(){
        return $this->belongsTo(Factura::class,'factura_id');
    }
    public function notaCredito(){
        return $this->belongsTo(NotaCredito::class,'id');
    }

}
