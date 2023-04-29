<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;
use Keygen\Keygen;

class Armazen extends Model
{
    protected $connection = 'mysql2';

    public static function boot()
    {

        parent::boot();

        self::creating(function ($model) {
            $model->codigo = mb_strtoupper(Keygen::numeric(9)->generate());
        });
    }



    protected $fillable = [
        'designacao', 'codigo', 'localizacao', 'status_id',
        'empresa_id', 'user_id'
    ];



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
