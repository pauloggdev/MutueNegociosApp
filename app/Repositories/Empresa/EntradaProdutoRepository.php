<?php

namespace App\Repositories\Empresa;
use App\Models\empresa\EntradaStock;

class EntradaProdutoRepository
{

    protected $entity;

    public function __construct(EntradaStock $produto)
    {
        $this->entity = $produto;
    }

    public function listarEntradasProduto($search)
    {
        return  $this->entity::with(['entradaStockItems', 'entradaStockItems.produto', 'armazem', 'fornecedor', 'formaPagamento'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->search(trim($search))
            ->paginate();
    }
}
