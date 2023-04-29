<?php

namespace App\Http\Controllers\empresa\CentroCustos;

use App\Http\Requests\UpdateCentroCustoRequest;
use App\Repositories\Empresa\CentroCustoRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;


class CentroCustoUpdateController extends Component
{
    use WithFileUploads;
    use UpdateCentroCustoRequest;
    use LivewireAlert;


    public $centroCusto;
    public $centroCustoId;
    private $centroCustoRepository;
    public $newNIF;
    public $newAlvara;
    public $newLogotipo;
    protected $listeners = ['refreshComponent' => '$refresh'];


    public function mount($uuid)
    {
        $this->centroCustoId = $uuid;
        $this->centroCusto =  $this->centroCustoRepository->getCentroCusto($uuid);
        if (!$this->centroCusto) {
            return redirect()->route('centroCusto.index');
        }
    }

    public function boot(
        CentroCustoRepository $centroCustoRepository
    ) {
        $this->centroCustoRepository = $centroCustoRepository;
    }

    public function render()
    {
        return view("empresa.centroCustos.update");
    }
    public function update()
    {

        $this->centroCusto['newNIF'] = $this->newNIF;
        $this->centroCusto['newAlvara'] = $this->newAlvara;
        $this->centroCusto['newLogotipo'] = $this->newLogotipo;

        $this->validate($this->rules($this->centroCustoId), $this->messages());
        $this->centroCustoRepository->update($this->centroCusto);
        $this->confirm('Operação realizada com sucesso', ['showConfirmButton' => false, 'showCancelButton' => false, 'icon' => 'success']);
        // $this->reset();
        return $this->emit('refreshComponent');
    }
}
