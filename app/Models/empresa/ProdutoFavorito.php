<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class ProdutoFavorito extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'produtos_favoritos';
    public $timestamps = false;

    protected $fillable = [
        'produto_id',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function produtos()
    {
        return $this->belongsToMany(Produto::class, ProdutoFavorito::class, 'user_id', 'produto_id');
    }
}
