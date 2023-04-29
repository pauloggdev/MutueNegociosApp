<?php

namespace App\Http\Controllers\empresa\NotaCreditoSaldoCliente;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\NotaCreditoSaldoClienteRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class NotaCreditoIndexController extends Component
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use WithFileUploads;
    use WithPagination;


    public $notaCredito;
    public $search;

    private $notaCreditoSaldoClienteRepository;

    public function boot(NotaCreditoSaldoClienteRepository $notaCreditoSaldoClienteRepository)
    {
        $this->notaCreditoSaldoClienteRepository = $notaCreditoSaldoClienteRepository;
    }

    public function render()
    {
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ( $infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }
        $data['notaCreditos'] = $this->notaCreditoSaldoClienteRepository->listarNotaCreditoSaldoClientes($this->search);


        return view('empresa.notaCreditoSaldoCliente.index', $data);
    }
    public function printNotaCredito($notaCredito)
    {
        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => 'notaCredito',
                'report_jrxml' => 'notaCredito.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 2,
                    'empresa_id' => auth()->user()->empresa_id,
                    'notaCreditoId' => $notaCredito['id'],
                    'logotipo' => $logotipo
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
}
