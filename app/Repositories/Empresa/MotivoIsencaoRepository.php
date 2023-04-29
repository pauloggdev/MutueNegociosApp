<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\MotivoIsencao;

class MotivoIsencaoRepository
{

    protected $entity;

    public function __construct(MotivoIsencao $entity)
    {
        $this->entity = $entity;
    }

    public function listarMotivosPelaTaxa($taxaId)
    {
        if (($taxaId == 1)) {
            return $this->entity::where('codigo', '!=', 7)
                ->where('codigo', '!=', 9)
                ->get();
        } else {
            return [];
        }
    }
}
