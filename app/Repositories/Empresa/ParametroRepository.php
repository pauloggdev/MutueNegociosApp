<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\Parametro;

class ParametroRepository
{


    protected $entity;

    public function __construct(Parametro $parametro)
    {
        $this->entity = $parametro;
    }

    public function numeroViasImpressao()
    {

        $viaImpressao = $this->entity::where('empresa_id', auth()->user()->empresa_id)
            ->where('label', 'n_vias_de_impressao')
            ->first();

        return $viaImpressao ? (int) $viaImpressao->valor : 1;
    }
}
