<?php

namespace App\Http\Controllers\empresa\ModeloDocumentos;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\ModeloDocRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ModeloDocumentoController extends Component
{
    use TraitEmpresaAutenticada;
    use LivewireAlert;

    public $search;
    private $modeloDocRepository;

    public function boot(ModeloDocRepository $modeloDocRepository)
    {
        $this->modeloDocRepository = $modeloDocRepository;
    }
    public function render()
    {
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }

        $data['modeloDocumentos'] = $this->modeloDocRepository->getModeloDocumentos($this->search);

        // dd($data['modeloDocumentos']);
       
        
        return view('empresa.modeloDocumento.index', $data);
    }
    public function visualizarDocumento($modelo){

        $caminho = env('APP_URL') . $modelo['name_pdf'];
        $this->dispatchBrowserEvent('printLink', ['data' => $caminho]);
    }
    public function selecionarModelo($modelo){
        $this->modeloDocRepository->checkedModeloDocumento($modelo);
        return redirect()->back();
        

    }
}


