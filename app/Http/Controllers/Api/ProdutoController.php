<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Empresa\contracts\ClienteRepositoryInterface;
use App\Repositories\Empresa\contracts\ProdutoRepositoryInterface;
use App\Repositories\Empresa\contracts\RelatorioRepositoryInterface;
use App\Traits\Empresa\TraitEmpresa;
use App\Traits\Empresa\TraitPathRelatorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    use TraitEmpresa;
    use TraitPathRelatorio;

    private $produtoRepository;

    public function __construct()
    {
        $this->produtoRepository = App::make(ProdutoRepositoryInterface::class);
        $this->relatorioRepository = App::make(RelatorioRepositoryInterface::class);
    }

    public function getProdutos()
    {
        return $this->produtoRepository->getProdutoPaginate();
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
    public function getProduto(int $produtoId)
    {
        return $this->produtoRepository->getProduto($produtoId);
    }
    public function imprimirProduto()
    {

        $pathLogoCompany = $this->getPathCompany();
        $pathRelatorio = $this->getPathRelatorio();

        $data =  $this->relatorioRepository->print('produtos', [
            'dirSubreportEmpresa' => $pathRelatorio,
            'diretorio' => $pathLogoCompany
        ]);
        return $data;
    }

    public function store(Request $request)
    {
        return $this->produtoRepository->store($request);
    }
    public function update(Request $request, $produtoId)
    {
        return $this->produtoRepository->update($request, $produtoId);
    }
}
