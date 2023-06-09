<?php

namespace App\Models\empresa;
use Illuminate\Database\Eloquent\Model;
class ProdutoDestaque extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'produtos_destaque';

    protected $fillable = [
        'id',
        'produto_id',
        'designacao',
        'descricao',
        'empresa_id',
        'created_at',
        'updated_at',
    ];

    public function produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";

        $query->where(function ($query) use ($term) {
            $query->where("designacao", "like", $term)
                ->orwhere("descricao", "like", $term);
        });
    }
}
