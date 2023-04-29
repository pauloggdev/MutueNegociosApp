<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Keygen\Keygen;

class Factura extends Model
{
    protected $connection = 'mysql';
    protected $table ='facturas';


    const STATUDIVIDA = 1;
    const STATUPAGO = 2;


    public static function boot(){
        
        parent::boot();
        
        self::creating(function($model){
            $model->faturaReference = mb_strtoupper(Keygen::numeric(9)->generate());
            $model->nextFactura = $model->faturaReference;
        });
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
