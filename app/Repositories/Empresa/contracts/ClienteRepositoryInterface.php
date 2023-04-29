<?php

namespace App\Repositories\Empresa\contracts;

use Illuminate\Http\Request;

interface ClienteRepositoryInterface
{
    public function getClientes();
    public function getCliente(int $id);
    public function store(Request $data);
    public function update(Request $data, int $clienteId);
}
