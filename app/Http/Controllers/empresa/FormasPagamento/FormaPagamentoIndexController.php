<?php

namespace App\Http\Controllers\empresa\FormasPagamento;
use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\FormaPagamentoRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FormaPagamentoIndexController extends Component
{

    use LivewireAlert;

    public $search = null;
    private $formaPagamentoRepository;




    public function boot(FormaPagamentoRepository $formaPagamentoRepository)
    {
        $this->formaPagamentoRepository = $formaPagamentoRepository;
    }

    public function render()
    {
        $data['formasPagamento'] = $this->formaPagamentoRepository->getFormasPagamento($this->search);
        return view('empresa.formapagamento.index', $data);
    }
  
    public function imprimirBancos()
    {

        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $filename = "bancos";

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'logotipo' => $logotipo,
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
}
