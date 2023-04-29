<?php

namespace App\Http\Controllers\Api\Produtos;
use App\Http\Controllers\Controller;
use App\Models\empresa\Produto;
use App\Repositories\Empresa\ProdutoRepository;
use Illuminate\Support\Facades\DB;

class ProdutoIndexController extends Controller
{
    private $produtoRepository;

    public function __construct(ProdutoRepository $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }
    public function quantidadeProdutos(){
        return $this->produtoRepository->quantidadeProdutos();
    }
    public function listarSeisProdutosMaisVendidos(){
        return $this->produtoRepository->listarSeisProdutosMaisVendidos();
    }
    public function mv_listarProdutos($search = null){
        return $this->produtoRepository->mv_listarProdutos($search);
    }
    public function listarProdutos($search = null)
    {
        return $this->produtoRepository->getProdutoComPaginacao($search);
    }
    public function getproduto($id)
    {
        return $this->produtoRepository->getproduto($id);
    }
    public function listarProdutosPeloIdArmazem($armazemId)
    {

        $product_list = $this->produtoRepository->listarProdutosPeloIdArmazem($armazemId);
        foreach ($product_list as $produto) {
            foreach ($produto->existenciaEstock as $stock) {
                if ($stock->armazem_id == $armazemId) {
                    $produto->existenciaEstock = $stock;
                }
            }
        }

        return $product_list;
    }
}
