<?php

namespace App\Http\Controllers\empresa\UnidadeMedidas;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\BancoRepository;
use App\Repositories\Empresa\UnidadeMedidaRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UnidadeMedidaIndexController extends Component
{

    use LivewireAlert;

    public $unidadeMedida;
    public $search = null;
    public $unidadeMedidaId;
    private $unidadeMedidaRepository;
    protected $listeners = ['deletarUnidadeMedida'];




    public function boot(UnidadeMedidaRepository $unidadeMedidaRepository)
    {
        $this->unidadeMedidaRepository = $unidadeMedidaRepository;
    }

    public function render()
    {
        $data['unidadeMedidas'] = $this->unidadeMedidaRepository->getUnidadeMedidas($this->search);
        return view('empresa.unidadeMedidas.index', $data);
    }
    public function modalDel($unidadeMedidaId)
    {

        $this->unidadeMedidaId = $unidadeMedidaId;
        $this->confirm('Deseja apagar o item', [
            'onConfirmed' => 'deletarUnidadeMedida',
            'cancelButtonText' => 'Não',
            'confirmButtonText' => 'Sim',
        ]);
    }
    public function deletarUnidadeMedida($data)
    {

        if ($data['value']) {
            try {
                $this->unidadeMedidaRepository->deletarUnidadeMedida($this->unidadeMedidaId);
                $this->confirm('Operação realizada com sucesso', [
                    'showConfirmButton' => false,
                    'showCancelButton' => false,
                    'icon' => 'success'
                ]);
            } catch (\Throwable $th) {
                $this->alert('warning', 'Não permitido eliminar, altera o status como desativo');
            }
        }
    }
    public function imprimirUnidadeMedidas()
    {
        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $filename = "unidades";

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
