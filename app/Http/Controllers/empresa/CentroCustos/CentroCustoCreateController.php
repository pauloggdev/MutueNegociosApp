<?php

namespace App\Http\Controllers\empresa\CentroCustos;

use App\Http\Requests\Admin\UpdateEmpresaRequest;
use App\Http\Requests\CreateCentroCustoRequest;
use App\Repositories\Empresa\CentroCustoRepository;
use App\Repositories\Empresa\RegimeRepository;
use App\Repositories\Empresa\TipoClienteRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;


class CentroCustoCreateController extends Component
{
    use WithFileUploads;
    use CreateCentroCustoRequest;
    use LivewireAlert;


    public $centroCusto;
    private $centroCustoRepository;
    public $newNIF;
    public $newAlvara;
    public $newLogotipo;

    protected $listeners = ['refresh-me' => '$refresh'];

    public function boot(
        CentroCustoRepository $centroCustoRepository
    ) {
        $this->centroCustoRepository = $centroCustoRepository;
        $this->centroCusto['logotipo'] = null;
        $this->centroCusto['status_id'] = 1;
    }

    public function render()
    {
        return view("empresa.centroCustos.create");
    }
    public function store(){

        $this->centroCusto['newNIF'] = $this->newNIF;
        $this->centroCusto['newAlvara'] = $this->newAlvara;
        $this->centroCusto['newLogotipo'] = $this->newLogotipo;

        $this->validate($this->rules(), $this->messages());
        $this->centroCustoRepository->store($this->centroCusto);
        $this->confirm('Operação realizada com sucesso', ['showConfirmButton' => false, 'showCancelButton' => false, 'icon' => 'success']);
        $this->reset();
    }

}
