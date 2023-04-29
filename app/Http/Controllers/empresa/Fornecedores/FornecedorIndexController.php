<?php

namespace App\Http\Controllers\empresa\Fornecedores;

use App\Http\Controllers\empresa\ReportShowController;
use App\Models\empresa\Pais;
use App\Models\empresa\TiposCliente;
use App\Repositories\Empresa\FornecedorRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FornecedorIndexController extends Component
{
    use LivewireAlert;
    use TraitEmpresaAutenticada;

    public $fornecedor;
    public $search = null;

    private $fornecedorRepository;


    public function boot(FornecedorRepository $fornecedorRepository)
    {
        $this->fornecedorRepository = $fornecedorRepository;
    }

    public function render()
    {

       
        $data['fornecedores'] = $this->fornecedorRepository->getFornecedores($this->search);
        return view('empresa.fornecedores.index', $data);
    }
    public function imprimirFornecedor()
    {
        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        $filename = "fornecedores";

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
