<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'bancos';

    
    protected $fillable = [
        'designacao', 
        'sigla', 
        'num_conta', 
        'uuid', 
        'iban', 
        'status_id',
        'empresa_id', 
        'user_id',
        'canal_id',
        'tipo_user_id'
    ];



    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }

    // public function coordenada() 
    // {
    //     return $this->hasOne(CoordenadasBancaria::class, 'banco_id'); 
    // }  

    
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("designacao", "like", $term)
            ->orwhere('sigla', "like", $term);
        });
    }

}
