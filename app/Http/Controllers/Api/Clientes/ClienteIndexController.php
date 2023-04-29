<?php

namespace App\Http\Controllers\Api\Clientes;

use App\Http\Controllers\Controller;
use App\Http\Controllers\empresa\ReportsController;
use App\Repositories\Empresa\ClienteRepository;

class ClienteIndexController extends Controller
{

    private $clienteRepository;

    public function __construct(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function listarClientes($search = null)
    {
        return $this->clienteRepository->getClientes($search);
    }
    public function quantidadeClientes()
    {
        return $this->clienteRepository->quantidadeClientes();
    }

    public function imprimirClientes()
    {
        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $filename = "clientes";

        $reportController = new ReportsController();
        $doc = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'diretorio' => $logotipo,
                ]
            ]
        );
        return $doc;
    }
}
