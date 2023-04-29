<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'perfils';

    
    protected $fillable = [
        'designacao', 
        'status_id',
        'empresa_id',
        'uuid'
    ];



    public function permissions(){

        return $this->belongsToMany(Permission::class);
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
