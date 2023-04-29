<?php

namespace App\Http\Controllers\empresa\NotaCreditoAnulacaoDocumentos;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\NotaCreditoAnulacaoDocumentoRepository;
use App\Repositories\Empresa\NotaCreditoSaldoClienteRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class AnulacaoDocumentoIndexController extends Component
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use WithFileUploads;
    use WithPagination;


    public $notaCredito;
    public $search;

    private $notaCreditoAnulacaoDocumentoRepository;

    public function boot(NotaCreditoAnulacaoDocumentoRepository $notaCreditoAnulacaoDocumentoRepository)
    {
        $this->notaCreditoAnulacaoDocumentoRepository = $notaCreditoAnulacaoDocumentoRepository;
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
        $data['notaCreditos'] = $this->notaCreditoAnulacaoDocumentoRepository->listarNotaCreditoAnulacaoDocumento($this->search);

        return view('empresa.NotaCreditoAnulacaoDocumento.index', $data);
    }
    public function printNotaCredito($notaCredito)
    {
        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $DIR = public_path() . '/upload/documentos/empresa/modelosFacturas/a4/';

        if ($notaCredito['facturaId']) {
            $filename = "FacturaAnuladoCredito";
            $params = [
                'viaImpressao' => 2,
                'empresa_id' => auth()->user()->empresa_id,
                'logotipo' => $logotipo,
                'facturaId' => $notaCredito['facturaId'],
                'docAnuladoId' => $notaCredito['id'],
                'dirSubreportBanco' => $DIR,
                'dirSubreportTaxa' => $DIR,
                'tipo_regime' => auth()->user()->empresa->tipo_regime_id

            ];
        } else {
            $filename = "ReciboAnuladoCredito";
            $params = [
                'viaImpressao' => 2,
                'empresa_id' => auth()->user()->empresa_id,
                'logotipo' => $logotipo,
                'docAnuladoId' => $notaCredito['id'],
                'factura_id' => $notaCredito['recibo']['factura']['id']
            ];
        }

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => $params

            ]
        );
        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
}
