<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Keygen\Keygen;

class ComprovativoFactura extends Model
{
    protected $connection = 'mysql';
    protected $table ='comprovativos_facturas';


    public function factura(){
        return $this->belongsTo(FacturaUserAdicionar::class,'factura_id');
    }


    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where("nome_do_cliente", "like", $term)
            ->orwhere("nif_cliente", "like", $term)
            ->orwhere("numeracaoFactura", "like", $term);
        });
    }
}
