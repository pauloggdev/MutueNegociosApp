<?php

namespace App\Http\Controllers\empresa\Permissao;

use App\Http\Controllers\empresa\ReportShowController;
use App\Models\empresa\Pais;
use App\Models\empresa\TiposCliente;
use App\Repositories\Empresa\FornecedorRepository;
use App\Repositories\Empresa\MarcaRepository;
use App\Repositories\Empresa\PermissaoRepository;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class PermissaoIndexController extends Component
{
    use LivewireAlert;
    public $permissao;
    public $search = null;

    private $permissaoRepository;


    public function boot(PermissaoRepository $permissaoRepository)
    {
        $this->permissaoRepository = $permissaoRepository;
    }

    public function render()
    {

         $data['permissoes']= $this->permissaoRepository->getPermissoesComPaginacao($this->search);

         return view('empresa.permissoes.index',$data);


    }

    public function imprimirPermissao()
    {

        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $filename = "permissao";

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
