<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class Fabricante extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'fabricantes';

    protected $fillable = [
        'designacao', 
        'empresa_id',
        'user_id',
        'canal_id',
        'status_id',
        'diversos',
        'tipo_user_id',
    ];


    public function statuGeral()
    {

        return $this->belongsTo(Statu::class, 'status_id');
    }
    public function statuLicenca()
    {

        return $this->belongsTo(CanalComunicacao::class, 'canal_id');
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where("designacao", "like", $term);
        });
    }
}
