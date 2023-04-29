<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\AtualizacaoStocks;

class AtualizacaoStockRepository
{

    protected $entity;

    public function __construct(AtualizacaoStocks $entity)
    {
        $this->entity = $entity;
    }

    public function listarAtualizacaoStock()
    {
        $atualizacaoStock = $this->entity::with(['produtos', 'armazens'])->where('empresa_id', auth()->user()->empresa_id)->paginate();
        return $atualizacaoStock;
    }
}
