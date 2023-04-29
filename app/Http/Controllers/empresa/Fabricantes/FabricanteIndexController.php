<?php

namespace App\Http\Controllers\empresa\Fabricantes;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\FabricanteRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FabricanteIndexController extends Component
{

    use LivewireAlert;

    public $cliente;
    public $search = null;
    public $fabricanteId;
    private $fabricanteRepository;
    protected $listeners = ['deletarFabricante'];




    public function boot(FabricanteRepository $fabricanteRepository)
    {
        $this->fabricanteRepository = $fabricanteRepository;
    }

    public function render()
    {

        $data['fabricantes'] = $this->fabricanteRepository->getFabricantes($this->search);
        return view('empresa.fabricantes.index', $data);
    }
    public function modalDel($fabricanteId)
    {
        $this->fabricanteId = $fabricanteId;
        $this->confirm('Deseja apagar o item', [
            'onConfirmed' => 'deletarFabricante',
            'cancelButtonText' => 'Não',
            'confirmButtonText' => 'Sim',
        ]);
    }
    public function deletarFabricante($data)
    {

        if ($data['value']) {
            try {
                $this->fabricanteRepository->deletarFabricante($this->fabricanteId);
                $this->alert('success', 'Operação realizada com sucesso');
            } catch (\Throwable $th) {
                $this->alert('warning', 'Não permitido eliminar, altera o status como desativo');
            }
        }
    }
    public function imprimirFabricantes()
    {
        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;


        $filename = "fabricantes";

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
