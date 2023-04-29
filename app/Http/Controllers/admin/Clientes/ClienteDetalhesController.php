<?php

namespace App\Http\Controllers\admin\Clientes;
use App\Repositories\Admin\ClienteRepository;
use Livewire\Component;

class ClienteDetalhesController extends Component
{

    private $clienteRepository;
    public $cliente;

    public function mount($id)
    {
        $this->cliente = $this->clienteRepository->getCliente($id);
    }

    public function boot(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function render()
    {
        return view('admin.clientes.detalhes')->layout('layouts.appAdmin');
    }
    // public function imprimirUtilizadores()
    // {

    //     // return redirect()->route('admin.home');
    //     $pathLogoCompany = $this->getPathCompany();
    //     $pathRelatorio = $this->getPathRelatorio();

    //     $data =  $this->relatorioRepository->print('utilizadores', [
    //         'dirSubreportEmpresa' => $pathRelatorio,
    //         'diretorio' => $pathLogoCompany
    //     ]);
    //     return $data;
    // }
}
