<?php

namespace App\Models\admin;
use Illuminate\Database\Eloquent\Model;


class Motivo_Iva extends Model
{
    protected $connection = 'mysql';
    protected $table = 'motivo';
    protected $primaryKey = 'codigo';

    protected $fillable = [
        'codigo',
        'codigoMotivo',
        'descricao',
        'codigoStatus',
        'codigoMotivo',
        'empresa_id',
        'canal_id',
        'user_id',
        'status_id',
        'created_at',
        'updated_at',
    ];

    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
    
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("codigoMotivo", "like", $term)
            ->orwhere("descricao", "like", $term);
        });
    }
}