<?php

namespace App\Http\Controllers\admin\PedidosLicenca;

use App\Http\Controllers\admin\ReportShowAdminController;
use App\Http\Controllers\admin\Traits\TraitEmpresa;
use App\Http\Controllers\admin\Traits\TraitPathRelatorio;
use App\Repositories\Admin\PedidosLicencaRepository;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class PedidosLicencaIndexController extends Component
{

    use WithPagination;
    use TraitEmpresa;
    use TraitPathRelatorio;


    public $search = null;
    public $byStatus = null;
    public $byLicencas = null;
    public $perpage = 10;

    private $pedidosLicencaRepository;

    public function boot(PedidosLicencaRepository $pedidosLicencaRepository)
    {
        $this->pedidosLicencaRepository = $pedidosLicencaRepository;
    }

    public function render()
    {
        $pedidosLicenca = $this->pedidosLicencaRepository->getPedidoLicencas($this->byStatus, $this->byLicencas, $this->search, $this->perpage);
        return view('admin.pedidosLicenca.index', [
            'pedidosLicenca' => $pedidosLicenca
        ])->layout('layouts.appAdmin');
    }
    public function imprimirPedidos()
    {

        $empresa = DB::connection('mysql')->table('empresas')->where('id', 1)->first();

        $logotipo = public_path() . '/upload//' . $empresa->logotipo;
        $caminho = public_path() . '/upload/documentos/admin/relatorios/';

        $filename = "pedidosLicencas";

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
