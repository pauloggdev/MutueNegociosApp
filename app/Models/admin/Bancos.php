<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bancos extends Model
{
    use SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'bancos';
    protected $keyType = 'string';


    protected $fillable = [
        'designacao',
        'sigla',
        'uuid',
        'status_id',
        'canal_id',
        'user_id',
        'status_id',
        'status_id',
    ];

    public function statuGeral()
    {
        return $this->belongsTo(Statu::class, 'status_id');
    }
    public function coordernadaBancaria()
    {
        return $this->hasOne(CoordenadaBancaria::class, 'banco_id');
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("designacao", "like", $term)
                ->orwhere("sigla", "like", $term);
        });
    }
}
