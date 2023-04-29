<?php

namespace App\Http\Controllers\admin\Bancos;

use App\Http\Requests\Admin\StoreBancoRequest;
use App\Http\Requests\UpdateBancoRequest;
use App\Repositories\Admin\BancoRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class BancoUpdateController extends Component
{

    use LivewireAlert;
    use UpdateBancoRequest
    ;


    private $bancoRepository;
    public $banco;
    public $uuid;


    public function mount($uuid)
    {
        $this->uuid = $uuid;
        $this->banco = $this->bancoRepository->getBancoUuid($this->uuid);
        $this->banco['num_conta'] = $this->banco->coordernadaBancaria->num_conta;
        $this->banco['iban'] = $this->banco->coordernadaBancaria->iban;
    }
    public function boot(BancoRepository $bancoRepository)
    {
        $this->bancoRepository = $bancoRepository;
    }

    public function render()
    {
        return view('admin.bancos.edit')->layout('layouts.appAdmin');
    }
    public function updateBanco()
    {
        $this->validate($this->rules(), $this->messages());
        $this->bancoRepository->updateBanco($this->banco);
        $this->alert('success', 'Operação realizada com sucesso');
    }
}
