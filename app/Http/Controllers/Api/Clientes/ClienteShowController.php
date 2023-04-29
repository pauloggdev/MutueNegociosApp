<?php

namespace App\Http\Controllers\Api\Clientes;
use App\Http\Controllers\Controller;
use App\Repositories\Empresa\ClienteRepository;

class ClienteShowController extends Controller
{

    private $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function listarCliente($id){
        return $this->clienteRepository->getCliente($id);
    }
}
