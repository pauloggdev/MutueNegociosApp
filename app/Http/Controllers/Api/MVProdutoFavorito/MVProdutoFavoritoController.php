<?php

namespace App\Http\Controllers\Api\MVProdutoFavorito;

use App\Http\Controllers\Controller;
use App\Repositories\Empresa\ProdutoFavoritoRepository;
use Illuminate\Http\Request;

class MVProdutoFavoritoController extends Controller
{
    private $produtoFavoritoRepository;

    public function __construct(ProdutoFavoritoRepository $produtoFavoritoRepository)
    {
        $this->produtoFavoritoRepository = $produtoFavoritoRepository;
    }
    public function mv_listarProdutosFavoritos($search = null)
    {
        return $this->produtoFavoritoRepository->mv_listarProdutosFavoritos($search);
    }

    // public function idsProdutoPorUser()
    // {
    //     return ProdutoFavorito::where('user_id', auth()->user()->id)
    //         ->select('produto_id')
    //         ->get();
    // }
    public function checkFavorito(Request $request)
    {
        return $this->produtoFavoritoRepository->checkFavorito($request->produto_id);
    }
    public function isProdutoFavorito($produtoId)
    {
        return $this->produtoFavoritoRepository->isProdutoFavorito($produtoId);
    }
}
