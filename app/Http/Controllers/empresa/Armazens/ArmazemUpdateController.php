<?php

namespace App\Http\Controllers\empresa\Armazens;

use App\Http\Requests\UpdateArmazemRequest;
use App\Repositories\Empresa\ArmazemRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ArmazemUpdateController extends Component
{

    use LivewireAlert;
    use UpdateArmazemRequest;

    public $armazem;
    private $armazemRepository;

    public function boot(ArmazemRepository $armazemRepository)
    {
        $this->armazemRepository = $armazemRepository;
    }

    public function mount($armazemId)
    {
        $this->armazem = $this->armazemRepository->getArmazen($armazemId);
        if (!$this->armazem) return redirect()->back();
    }

    public function render()
    {
        return view('empresa.armazens.edit');
    }
    public function atualizarArmazem()
    {
        $this->validate($this->rules(), $this->messages());
        $this->armazemRepository->update($this->armazem);
        
        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
    }
}
