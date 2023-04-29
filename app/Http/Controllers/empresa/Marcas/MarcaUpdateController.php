<?php

namespace App\Http\Controllers\empresa\Marcas;

use App\Http\Requests\StoreUpdateClienteRequest;
use App\Http\Requests\StoreUpdateMarcaRequest;
use App\Models\empresa\Pais;
use App\Models\empresa\TiposCliente;
use App\Repositories\Empresa\FornecedorRepository;
use App\Repositories\Empresa\MarcaRepository;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MarcaUpdateController extends Component
{
    use LivewireAlert;
    use StoreUpdateMarcaRequest;
    public $marca;
    public $search = null;

    private $marcaRepository;


    public function boot(MarcaRepository $marcaRepository)
    {
        $this->marcaRepository = $marcaRepository;
        
    }

    public function mount($marcaId)
    {    
       
        $this->marca = $this->marcaRepository->getMarca($marcaId);
        $this->setarValorPadrao();
    }


    public function render()
    {

        return view('empresa.marcas.edit');
    }
    public function MarcasUpdate()
    {

        $this->validate($this->rules(), $this->messages());
        $this->marcaRepository->update($this->marca);
        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
    }

    public function setarValorPadrao()
    {
        // $this->marca['designacao'] = NULL;
        // $this->marca['status_id'] = 1;
         $this->marca['tipo_user_id'] = 2;
         $this->marca['canal_id'] = 2;
    }
}
