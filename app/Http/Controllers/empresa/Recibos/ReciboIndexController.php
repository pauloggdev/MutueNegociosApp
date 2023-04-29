<?php

namespace App\Http\Controllers\empresa\Recibos;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\ReciboRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;



class ReciboIndexController extends Component
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use WithFileUploads;
    use WithPagination;


    public $recibo;
    public $search;

    private $reciboRepository;

    public function boot(ReciboRepository $reciboRepository)
    {
        $this->reciboRepository = $reciboRepository;
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

        $data['recibos'] = $this->reciboRepository->listarRecibos($this->search);
        return view('empresa.recibos.index', $data);
    }
    public function printRecibo($reciboId)
    {
        $recibo = $this->reciboRepository->listarRecibo($reciboId);

        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $caminho = public_path() . '/upload/documentos/empresa/relatorios/';

        $filename = "recibos";
        if ($recibo['anulado'] == 2) { //Tipo anulado
            $filename = 'recibosAnulados';
        }

        $reportController = new ReportShowController();

        $report = $reportController->show([
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 2,
                    'empresa_id' => auth()->user()->empresa_id,
                    'recibo_id' => $recibo['id'],
                    'factura_id' => $recibo['factura_id'],
                    'logotipo' => $logotipo,
                    'marcaAgua' => $caminho
                ]
        ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();

    }
}
