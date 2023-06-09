<?php

namespace App\Repositories\Empresa;
use App\Models\empresa\ProdutoDestaque;

class ProdutoDestaqueRepository
{

    protected $produtoDestaque;

    public function __construct(ProdutoDestaque $produtoDestaque)
    {
        $this->produtoDestaque = $produtoDestaque;
    }
    public function getProdutos($search)
    {
        $produtos = $this->produtoDestaque::with(['produto'])
            ->search(trim($search))
            ->paginate();
        return $produtos;
    }

}
