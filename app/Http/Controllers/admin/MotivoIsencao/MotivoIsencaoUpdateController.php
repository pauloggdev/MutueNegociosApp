<?php

namespace App\Http\Controllers\admin\MotivoIsencao;

use App\Http\Requests\Admin\UpdateMotivoRequest;
use App\Repositories\Admin\MotivoIsencaoRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MotivoIsencaoUpdateController extends Component
{

    use LivewireAlert;
    use UpdateMotivoRequest;


    private $motivoIsencaoRepository;
    public $motivo;
    public $motivoId;


    public function mount($id)
    {
        $this->motivoId = $id;
        $this->motivo = $this->motivoIsencaoRepository->getMotivoIsencao($id);
    }
    public function boot(MotivoIsencaoRepository $motivoIsencaoRepository)
    {
        $this->motivoIsencaoRepository = $motivoIsencaoRepository;
    }

    public function render()
    {
        return view('admin.motivoIsencao.edit')->layout('layouts.appAdmin');
    }
    public function salvarMotivo()
    {
        // dd($this->motivo);
        $this->validate($this->rules(), $this->messages());
        $this->motivoIsencaoRepository->updateMotivoIsencao($this->motivo);
        $this->alert('success', 'Operação realizada com sucesso');
    }
}
