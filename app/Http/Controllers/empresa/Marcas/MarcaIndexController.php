<?php

namespace App\Http\Controllers\empresa\Marcas;

use App\Http\Controllers\empresa\ReportShowController;
use App\Models\empresa\Pais;
use App\Models\empresa\TiposCliente;
use App\Repositories\Empresa\FornecedorRepository;
use App\Repositories\Empresa\MarcaRepository;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MarcaIndexController extends Component
{
    use LivewireAlert;
    public $fornecedor;
    public $search = null;

    private $marcaRepository;


    public function boot(MarcaRepository $marcaRepository)
    {
        $this->marcaRepository = $marcaRepository;
    }

    public function render()
    {


         $data['marcas']= $this->marcaRepository->getMarcas($this->search);

        return view('empresa.marcas.index',$data);

    }

    public function imprimirMarca()
    {

        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        $filename = "marcas";

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
