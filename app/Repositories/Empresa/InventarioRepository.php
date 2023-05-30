<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\Inventario;

class InventarioRepository
{

    protected $inventario;

    public function __construct(Inventario $inventario)
    {
        $this->inventario = $inventario;
    }

}
