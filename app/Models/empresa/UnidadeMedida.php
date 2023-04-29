<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class UnidadeMedida extends Model
{
    protected $connection = 'mysql2';
    protected $table ='unidade_medidas';
    protected $primarykey = 'id';
    protected $guard = 'id';


    
    protected $fillable = [
        'designacao', 
        'status_id',
        'empresa_id', 
        'user_id',
        'canal_id',
        'diversos'
    ];

    public function empresa(){
        return $this->belongsTo(Empresa_Cliente::class, 'empresa_id');
    }

    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
    
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("designacao", "like", $term);
        });
    }

}
