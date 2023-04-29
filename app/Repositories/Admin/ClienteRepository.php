<?php

namespace App\Repositories\Admin;

use App\Models\admin\Empresa;


class ClienteRepository
{

    protected $cliente;
    protected $coordenadaBancaria;

    public function __construct(Empresa $cliente)
    {
        $this->cliente = $cliente;
    }


    public function getClientes($byStatus, $search, $perpage)
    {
        $clientes = $this->cliente::with(['tipocliente', 'tiporegime'])->when($byStatus, function ($query) use ($byStatus) {
            $query->where('status_id', $byStatus);
        })
            ->where('id', '!=', 1)
            ->search(trim($search))->paginate($perpage);

        return $clientes;
    }
    public function getCliente($id)
    {
        $cliente = $this->cliente::with(['tipocliente', 'tiporegime'])->where('id', $id)->first();
        return $cliente;
    }
}
