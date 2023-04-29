<?php

namespace App\Http\Controllers\empresa\Licencas;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\CentroCustoRepository;
use App\Repositories\Empresa\LicencaRepository;
use Livewire\Component;


class MinhaLicencaController extends Component
{

    private $licencaRepository;
    public $search = null;


    public function boot(LicencaRepository $licencaRepository)
    {
        $this->licencaRepository = $licencaRepository;
    }

    public function render()
    {
        $data['licencas'] = $this->licencaRepository->listarLicencasEmpresaAuth($this->search);

        // dd($data['licencas']);
        return view("empresa.licencas.minhasLicencas_", $data);
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
