<?php

namespace App\Repositories\Empresa;
use App\Models\empresa\TipoTaxa;

class TaxaRepository
{

    protected $entity;

    public function __construct(TipoTaxa $entity)
    {
        $this->entity = $entity;
    }

    public function listarTaxas()
    {
        return $this->entity::get();
    }
}
