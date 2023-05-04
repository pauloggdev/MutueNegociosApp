<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\ProdutoFavorito;

class ProdutoFavoritoRepository
{

    public $entity;

    public function __construct(ProdutoFavorito $entity)
    {
        $this->entity = $entity;
    }
    public function mv_listarProdutosFavoritos($search)
    {
        return $this->entity::where('user_id', auth()->user()->id)->get();
    }
}
