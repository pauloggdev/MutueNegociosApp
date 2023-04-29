<?php

namespace App\Http\Controllers\admin\MotivoIsencao;

use App\Http\Requests\Admin\StoreMotivoRequest;
use App\Repositories\Admin\MotivoIsencaoRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MotivoIsencaoCreateController extends Component
{

    use LivewireAlert;
    use StoreMotivoRequest;

    private $motivoIsencaoRepository;
    public $motivo;

    public function __construct()
    {
        $this->motivo['codigoStatus'] = 1;
    }


    public function boot(MotivoIsencaoRepository $motivoIsencaoRepository)
    {
        $this->motivoIsencaoRepository = $motivoIsencaoRepository;
    }

    public function render()
    {
        return view('admin.motivoIsencao.create')->layout('layouts.appAdmin');
    }
    public function salvarMotivo()
    {
        $this->validate($this->rules(), $this->messages());
        $this->motivoIsencaoRepository->createMotivoIsencao($this->motivo);
        $this->alert('success', 'Operação realizada com sucesso');
        $this->setarValorInicial();
    }
    public function setarValorInicial()
    {
        $this->motivo['codigoStatus'] = 1;
        $this->motivo['codigoMotivo'] = NULL;
        $this->motivo['descricao'] = NULL;
    }
}
