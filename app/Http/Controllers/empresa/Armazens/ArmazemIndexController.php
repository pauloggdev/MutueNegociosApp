<?php

namespace App\Http\Controllers\empresa\Armazens;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\ArmazemRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ArmazemIndexController extends Component
{

    use LivewireAlert;

    public $armazem;
    public $search = null;
    public $armazemId;
    private $armazemRepository;
    protected $listeners = ['deletarArmazem'];




    public function boot(ArmazemRepository $armazemRepository)
    {
        $this->armazemRepository = $armazemRepository;
    }

    public function render()
    {
        $data['armazens'] = $this->armazemRepository->getArmazens($this->search);
        return view('empresa.armazens.index', $data);
    }
    public function modalDel($armazemId)
    {
        $this->armazemId = $armazemId;
        $this->confirm('Deseja apagar o item', [
            'onConfirmed' => 'deletarArmazem',
            'cancelButtonText' => 'Não',
            'confirmButtonText' => 'Sim',
        ]);
    }
    public function deletarArmazem($data)
    {

        if ($data['value']) {
            try {
                $this->armazemRepository->deletarArmazem($this->armazemId);
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
    public function imprimirFabricantes()
    {


        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        $filename = "armazens";

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
