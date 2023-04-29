<?php

namespace App\Repositories\Empresa;
use App\Models\admin\TiposRegime;
use App\Models\empresa\TiposCliente;

class TipoClienteRepository
{

    protected $tipoCliente;

    public function __construct(TiposCliente $tipoCliente)
    {
        $this->tipoCliente = $tipoCliente;
    }

    public function getTiposCliente()
    {
        return $this->tipoCliente->get();
    }
}
