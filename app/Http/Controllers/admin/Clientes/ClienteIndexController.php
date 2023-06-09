<?php

namespace App\Http\Controllers\admin\Clientes;

use App\Http\Controllers\admin\ReportShowAdminController;
use App\Http\Controllers\admin\Traits\TraitEmpresa;
use App\Http\Controllers\admin\Traits\TraitPathRelatorio;
use App\Repositories\Admin\BancoRepository;
use App\Repositories\Admin\ClienteRepository;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ClienteIndexController extends Component
{

    use WithPagination;
    use TraitEmpresa;
    use TraitPathRelatorio;
    use LivewireAlert;

    public $search = null;
    public $byStatus = null;
    public $perpage = 10;
    public $empresa;
    private $clienteRepository;
    protected $listeners = ['checkVendaOnline'];


    public function boot(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    public function render()
    {
        $clientes = $this->clienteRepository->getClientes($this->byStatus, $this->search, $this->perpage);
        return view('admin.clientes.index', [
            'clientes' => $clientes
        ])->layout('layouts.appAdmin');
    }
    public function imprimirClientes()
    {

        $empresa = DB::connection('mysql')->table('empresas')->where('id', 1)->first();

        $logotipo = public_path() . '/upload//' . $empresa->logotipo;
        $caminho = public_path() . '/upload/documentos/admin/relatorios/';

        $filename = "clientes";

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
    public function modalAtivarVendaOnline($empresa)
    {
        $this->empresa = $empresa;
        $this->confirm('Deseja habilitar venda online', [
            'onConfirmed' => 'checkVendaOnline',
            'cancelButtonText' => 'Não',
            'confirmButtonText' => 'Sim',
        ]);
    }
    public function modalDesactivarVendaOnline($empresa)
    {
        $this->empresa = $empresa;
        $this->confirm('Deseja desabilitar venda online', [
            'onConfirmed' => 'checkVendaOnline',
            'cancelButtonText' => 'Não',
            'confirmButtonText' => 'Sim',
        ]);
    }

    public function checkVendaOnline()
    {
        $vendaOnline = $this->empresa['venda_online'] === 'Y' ? 'N' : 'Y';
        DB::connection('mysql2')->table('empresas')->where('referencia', $this->empresa['referencia'])->update([
            'venda_online' => $vendaOnline
        ]);
        DB::connection('mysql')->table('empresas')->where('referencia', $this->empresa['referencia'])->update([
            'venda_online' => $vendaOnline
        ]);
    }
}
