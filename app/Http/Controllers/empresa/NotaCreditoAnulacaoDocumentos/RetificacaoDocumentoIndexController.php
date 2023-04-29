<?php

namespace App\Http\Controllers\empresa\NotaCreditoAnulacaoDocumentos;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\NotaCreditoAnulacaoDocumentoRepository;
use App\Repositories\Empresa\NotaCreditoRetificacaoDocumentoRepository;
use App\Repositories\Empresa\NotaCreditoSaldoClienteRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class RetificacaoDocumentoIndexController extends Component
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use WithFileUploads;
    use WithPagination;


    public $notaCredito;
    public $search;

    private $notaCreditoRetificacaoDocumentoRepository;

    public function boot(NotaCreditoRetificacaoDocumentoRepository $notaCreditoRetificacaoDocumentoRepository)
    {
        $this->notaCreditoRetificacaoDocumentoRepository = $notaCreditoRetificacaoDocumentoRepository;
    }

    public function render()
    {
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }
        $data['notaCreditos'] = $this->notaCreditoRetificacaoDocumentoRepository->listarNotaCreditoRetificacaoDocumento($this->search);
        return view('empresa.NotaCreditoRetificacaoDocumento.index', $data);
    }
    public function printNotaCredito($notaCredito)
    {

        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $caminho = public_path() . '/upload/documentos/empresa/relatorios/';

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => 'documento_retificadoFacturas',
                'report_jrxml' => 'documento_retificadoFacturas.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 2,
                    'empresa_id' => auth()->user()->empresa_id,
                    'facturaId' => $notaCredito['facturaId'],
                    'docAnuladoId' => $notaCredito['id'],
                    'logotipo' => $logotipo,
                    'DIR_SUBREPORT' => $caminho,
                    'dirSubreportBanco' => $caminho,
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
}
