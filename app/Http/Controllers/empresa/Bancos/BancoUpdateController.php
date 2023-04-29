<?php

namespace App\Http\Controllers\empresa\Bancos;
use App\Http\Requests\UpdateBancoRequest;
use App\Repositories\Empresa\BancoRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class BancoUpdateController extends Component
{

    use LivewireAlert;
    use UpdateBancoRequest;

    public $banco;
    private $bancoRepository;

    public function boot(BancoRepository $bancoRepository)
    {
        $this->bancoRepository = $bancoRepository;
    }

    public function mount($bancoId)
    {
        $this->banco = $this->bancoRepository->getBanco($bancoId);
        if (!$this->banco) return redirect()->back();
    }

    public function render()
    {
        return view('empresa.bancos.edit');
    }
    public function atualizarBanco()
    {
        $this->validate($this->rules(), $this->messages());
        $this->bancoRepository->update($this->banco);
        
        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
    }
}
