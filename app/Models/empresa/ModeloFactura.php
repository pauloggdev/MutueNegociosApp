<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class ModeloFactura extends Model
{
    protected $table = 'modelo_facturas';
    protected $connection = 'mysql2';


    public function modeloDocumentoAtivo()
    {
        return $this->belongsTo(ModeloDocumentoAtivo::class,'id', 'modelo_id');
    }
    
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("designacao", "like", $term);
        });
    }

}
