<?php

namespace App\Http\Controllers\empresa\UnidadeMedidas;

use App\Http\Requests\UpdateUnidadeMedidaRequest;
use App\Repositories\Empresa\UnidadeMedidaRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UnidadeMedidaUpdateController extends Component
{

    use LivewireAlert;
    use UpdateUnidadeMedidaRequest;

    public $unidade;
    private $unidadeMedidaRepository;

    public function boot(UnidadeMedidaRepository $unidadeMedidaRepository)
    {
        $this->unidadeMedidaRepository = $unidadeMedidaRepository;
    }

    public function mount($unidadeMedidaId)
    {
        $this->unidade = $this->unidadeMedidaRepository->getUnidadeMedida($unidadeMedidaId);
        if (!$this->unidade) return redirect()->back();
    }

    public function render()
    {
        return view('empresa.unidadeMedidas.edit');
    }
    public function atualizarUnidadeMedidas()
    {
        $this->validate($this->rules(), $this->messages());
        $this->unidadeMedidaRepository->update($this->unidade);

        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
    }
}
