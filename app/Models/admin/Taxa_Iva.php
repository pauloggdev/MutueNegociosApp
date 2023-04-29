<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;


class Taxa_Iva extends Model
{
    protected $connection = 'mysql';
    protected $table = 'tipotaxa';
    protected $primaryKey = 'codigo';


    protected $fillable = [
        'codigo',
        'taxa',
        'codigostatus',
        'descricao',
        'codigoMotivo',
        'empresa_id',
    ];

    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'codigostatus');
    }
    
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("descricao", "like", $term);
        });
    }
}
