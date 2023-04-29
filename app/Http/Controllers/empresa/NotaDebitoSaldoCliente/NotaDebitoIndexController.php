<?php

namespace App\Http\Controllers\empresa\NotaDebitoSaldoCliente;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\NotaDebitoSaldoClienteRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class NotaDebitoIndexController extends Component
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use WithFileUploads;
    use WithPagination;


    public $notaDebito;
    public $search;

    private $notaDebitoSaldoClienteRepository;

    public function boot(NotaDebitoSaldoClienteRepository $notaDebitoSaldoClienteRepository)
    {
        $this->notaDebitoSaldoClienteRepository = $notaDebitoSaldoClienteRepository;
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
        $data['notaDebitos'] = $this->notaDebitoSaldoClienteRepository->listarNotaDebitoSaldoClientes($this->search);

        return view('empresa.notaDebitoSaldoCliente.index', $data);
    }
    public function printNotaDebito($notaDebito)
    {
        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => 'notaDebito',
                'report_jrxml' => 'notaDebito.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 2,
                    'empresa_id' => auth()->user()->empresa_id,
                    'notaDebitoId' => $notaDebito['id'],
                    'logotipo' => $logotipo
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
}
