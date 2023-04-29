<?php

namespace App\Http\Controllers\empresa\Clientes;

use App\Http\Controllers\empresa\ReportShowController;
use App\Models\empresa\Pais;
use App\Models\empresa\TiposCliente;
use App\Repositories\Empresa\ClienteRepository;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ClienteIndexController extends Component
{

    use LivewireAlert;

    public $cliente;
    public $search = null;
    private $clienteRepository;



    public function boot(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function render()

    {
        $data['clientes'] = $this->clienteRepository->getClientes($this->search);

        return view('empresa.clientes.index', $data);
    }
    public function imprimirClientes(){


        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        $filename = "clientes";

        // dd($logotipo);

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'diretorio' => $logotipo,
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();

    }

}
