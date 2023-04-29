<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class CentroCusto extends Model
{
    protected $connection = 'mysql2';
    protected $table ='centro_custos';


    public function empresa(){
        return $this->belongsTo(Empresa_Cliente::class, 'empresa_id');
    }

    public function statu()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where("nome", "like", $term)
                ->orwhere("nif", "like", $term)
                ->orwhere("telefone", "like", $term);
        });
    }
}
