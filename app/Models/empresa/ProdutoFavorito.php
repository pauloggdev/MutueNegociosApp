<?php

namespace App\Models\empresa;

use Illuminate\Database\Eloquent\Model;

class ProdutoFavorito extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'produtos_favoritos';
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
        return $this->hasMany(Produto::class, 'id', 'produto_id');
    }
}
