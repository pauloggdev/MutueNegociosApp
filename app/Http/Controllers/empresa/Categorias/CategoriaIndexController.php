<?php

namespace App\Http\Controllers\empresa\Categorias;

use App\Http\Controllers\empresa\ReportShowController;
use App\Models\empresa\Pais;
use App\Models\empresa\TiposCliente;
use App\Repositories\Empresa\CategoriaRepository;
use App\Repositories\Empresa\FornecedorRepository;
use App\Repositories\Empresa\MarcaRepository;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CategoriaIndexController extends Component
{
    use LivewireAlert;
    public $categoria;
    public $search = null;
    public $categoriaId;
    private $categoriaRepository;
    protected $listeners = ['deletarCategoria'];



    public function boot(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function render()
    {
        $data['categorias']= $this->categoriaRepository->getCategorias($this->search);
        return view('empresa.categorias.index',$data);
    }

    public function imprimirCategoria()
    {
        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        $filename = "categorias";

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
    public function modalDel($categoriaId)
    {
        $this->categoriaId = $categoriaId;
        $this->confirm('Deseja apagar o item', [
            'onConfirmed' => 'deletarCategoria',
            'cancelButtonText' => 'Não',
            'confirmButtonText' => 'Sim',
        ]);
    }
    public function deletarCategoria($data)
    {

        if ($data['value']) {
            try {
                $this->categoriaRepository->deletarCategoria($this->categoriaId);
                $this->confirm('Operação realizada com sucesso', [
                    'showConfirmButton' => false,
                    'showCancelButton' => false,
                    'icon' => 'success'
                ]);
            } catch (\Throwable $th) {
                $this->confirm('Não permitido eliminar', [
                    'showConfirmButton' => false,
                    'showCancelButton' => false,
                    'icon' => 'warning'
                ]);
            }
        }
    }

}
