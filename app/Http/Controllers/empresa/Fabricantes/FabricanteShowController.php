<?php

namespace App\Http\Controllers\empresa\Fabricantes;

use App\Repositories\Empresa\ClienteRepository;
use Livewire\Component;

class FabricanteShowController extends Component
{


    protected $clienteRepository;
    public $cliente;
    public $saldoCliente;


    public function boot(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }
    public function mount($clienteId)
    {
        $this->cliente = $this->clienteRepository->getCliente($clienteId);
        $this->saldoCliente = $this->clienteRepository->mostrarSaldoAtualDoCliente($clienteId);

    }


    public function render()
    {
        return view('empresa.clientes.show');
    }
}
