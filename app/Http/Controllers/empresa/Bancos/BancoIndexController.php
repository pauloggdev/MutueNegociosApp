<?php

namespace App\Http\Controllers\empresa\Bancos;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\ArmazemRepository;
use App\Repositories\Empresa\BancoRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class BancoIndexController extends Component
{

    use LivewireAlert;

    public $banco;
    public $search = null;
    public $bancoId;
    private $bancoRepository;
    protected $listeners = ['deletarBanco'];




    public function boot(BancoRepository $bancoRepository)
    {
        $this->bancoRepository = $bancoRepository;
    }

    public function render()
    {
        $data['bancos'] = $this->bancoRepository->getBancos($this->search);
        return view('empresa.bancos.index', $data);
    }
    public function modalDel($bancoId)
    {
        $this->bancoId = $bancoId;
        $this->confirm('Deseja apagar o item', [
            'onConfirmed' => 'deletarBanco',
            'cancelButtonText' => 'Não',
            'confirmButtonText' => 'Sim',
        ]);
    }
    public function deletarBanco($data)
    {

        if ($data['value']) {
            try {
                $this->bancoRepository->deletarBanco($this->bancoId);
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
