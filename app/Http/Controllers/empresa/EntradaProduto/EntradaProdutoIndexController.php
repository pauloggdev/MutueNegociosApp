<?php

namespace App\Http\Controllers\empresa\EntradaProduto;

use App\Http\Controllers\empresa\ReportShowController;
use Livewire\Component;
use App\Repositories\Empresa\EntradaProdutoRepository;

class EntradaProdutoIndexController extends Component
{

    private $entradaProdutoRepository;
    public $search = NULL;

    public function boot(EntradaProdutoRepository $entradaProdutoRepository)
    {

        $this->entradaProdutoRepository = $entradaProdutoRepository;
    }



    public function render()
    {
        $data['entradasProdutos'] = $this->entradaProdutoRepository->listarEntradasProduto($this->search);
        return view('empresa.EntradaProdutos.index', $data);
    }
    public function printEntrada($entradaId){


        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        // $caminho = public_path() . '/upload/documentos/empresa/relatorios/';

        $filename = "entradaProdutos";


        $reportController = new ReportShowController();

        $report = $reportController->show([
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'diretorio' => $logotipo,
                    'entradaId' => $entradaId
                ]
        ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();

    }
}
