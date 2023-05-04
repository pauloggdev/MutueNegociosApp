<?php

namespace App\Http\Controllers\Api\MVProdutoFavorito;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProdutoResource;
use App\Repositories\Empresa\ProdutoFavoritoRepository;

class MVProdutoFavoritoController extends Controller
{
    private $produtoFavoritoRepository;

    public function __construct(ProdutoFavoritoRepository $produtoFavoritoRepository)
    {
        $this->produtoFavoritoRepository = $produtoFavoritoRepository;
    }
    public function mv_listarProdutosFavoritos($search = null)
    {
        $produtos = $this->produtoFavoritoRepository->mv_listarProdutosFavoritos($search);
        return ProdutoResource::collection($produtos);
    }
}
