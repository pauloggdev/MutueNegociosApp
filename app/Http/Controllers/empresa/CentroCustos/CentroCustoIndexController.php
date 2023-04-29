<?php

namespace App\Http\Controllers\empresa\CentroCustos;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\CentroCustoRepository;
use Livewire\Component;


class CentroCustoIndexController extends Component
{


    private $centroCustoRepository;
    public $search = null;


    public function boot(CentroCustoRepository $centroCustoRepository)
    {
        $this->centroCustoRepository = $centroCustoRepository;
    }

    public function render()
    {
        $data['centrosCusto'] = $this->centroCustoRepository->listarCentrosCusto($this->search);
        return view("empresa.centroCustos.index_", $data);
    }
    public function imprimirCentroCusto(){

        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        $filename = "centrosCusto";

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
