<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\ExistenciaStock;

class ExistenciaStockRepository
{

    protected $entity;

    public function __construct(ExistenciaStock $entity)
    {
        $this->entity = $entity;
    }

    public function listarExistenciaStock($produtoId, $armazemId)
    {
        $existenciaStock = $this->entity::with(['produtos', 'armazens'])->where('armazem_id', $armazemId)
            ->where('produto_id', $produtoId)->first();
        return $existenciaStock;
    }
}
