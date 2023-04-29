<?php

namespace App\Http\Controllers\empresa\Produtos;

use App\Http\Controllers\empresa\ReportShowController;
use Livewire\Component;
use App\Models\empresa\Statu;
use App\Repositories\Empresa\ProdutoRepository;

class ProdutoIndexController extends Component
{

    private $produtoRepository;
    public $search = NULL;
    public $vendaOnline = 'N';


    public function boot(ProdutoRepository $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    public function render()
    {
        $data['status'] = Statu::all();
        $data['produtos'] = $this->produtoRepository->getProdutos($this->search, $this->vendaOnline);
        return view('empresa.produtos.index', $data);
    }
    public function imprimirProdutos()
    {


        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        $filename = "produtos2";

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
