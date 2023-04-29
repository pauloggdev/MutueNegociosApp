<?php

namespace App\Http\Controllers\admin\Licencas;

use App\Http\Controllers\admin\ReportShowAdminController;
use App\Http\Controllers\admin\Traits\TraitEmpresa;
use App\Http\Controllers\admin\Traits\TraitPathRelatorio;
use App\Repositories\Admin\BancoRepository;
use App\Repositories\Admin\LicencaRepository;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class LicencaIndexController extends Component
{




    private $licencaRepository;
    public $search;

    public function boot(LicencaRepository $licencaRepository)
    {
        $this->licencaRepository = $licencaRepository;
    }

    public function render()
    {
        $licencas = $this->licencaRepository->getLicencas($this->search);
        return view('admin.licencas.index', [
            'licencas' => $licencas
        ])->layout('layouts.appAdmin');
    }
    public function imprimirLicencas()
    {

        $empresa = DB::connection('mysql')->table('empresas')->where('id', 1)->first();

        $logotipo = public_path() . '/upload//' . $empresa->logotipo;
        $caminho = public_path() . '/upload/documentos/admin/relatorios/';

        $filename = "licencas";

        $reportController = new ReportShowAdminController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'logotipo' => $logotipo,
                    'diretorio' => $caminho
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
}
