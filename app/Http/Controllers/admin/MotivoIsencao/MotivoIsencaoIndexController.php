<?php

namespace App\Http\Controllers\admin\MotivoIsencao;

use App\Http\Controllers\admin\Traits\TraitEmpresa;
use App\Http\Controllers\admin\Traits\TraitPathRelatorio;
use App\Repositories\Admin\MotivoIsencaoRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class MotivoIsencaoIndexController extends Component
{

    use WithPagination;
    use TraitEmpresa;
    use TraitPathRelatorio;
    use LivewireAlert;



    public $search = null;
    public $byStatus = null;
    public $perpage = 15;
    public $motivoIsencaoId;

    protected $listeners = ['deletarTaxa'];


    private $motivoIsencaoRepository;

    public function boot(MotivoIsencaoRepository $motivoIsencaoRepository)
    {
        $this->motivoIsencaoRepository = $motivoIsencaoRepository;
    }
    public function modalDel($taxaId)
    {
        $this->taxaId = $taxaId;
        $this->confirm('Deseja apagar o item', [
            'onConfirmed' => 'deletarTaxa',
            'cancelButtonText' => 'Não',
            'confirmButtonText' => 'Sim',
        ]);
    }

    public function deletarTaxa($data)
    {
        if ($data['value']) {
            try {
                $this->motivoIsencaoRepository->deletarTaxa($this->taxaId);
                $this->alert('success', 'Operação realizada com sucesso');
            } catch (\Throwable $th) {
                $this->alert('warning', 'Não permitido eliminar, altera o status como desativo');
            }
        }
    }

    public function render()
    {
        $motivos = $this->motivoIsencaoRepository->getMotivosIsencao($this->search);
        return view('admin.motivoIsencao.index', [
            'motivos' => $motivos
        ])->layout('layouts.appAdmin');
    }
}
