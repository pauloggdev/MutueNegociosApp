<?php

namespace App\Http\Controllers\admin\Bancos;

use App\Http\Requests\Admin\StoreBancoRequest;
use App\Repositories\Admin\BancoRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class BancoCreateController extends Component
{

    use LivewireAlert;
    use StoreBancoRequest;

    private $bancoRepository;
    public $banco;

    public function __construct()
    {
        $this->banco['status_id'] = 1;
    }
    public function boot(BancoRepository $bancoRepository)
    {
        $this->bancoRepository = $bancoRepository;
    }

    public function render()
    {
        return view('admin.bancos.create')->layout('layouts.appAdmin');
    }
    public function salvarBanco()
    {
        $this->validate($this->rules(), $this->messages());
        $this->bancoRepository->createBanco($this->banco);
        $this->alert('success', 'Operação realizada com sucesso');
        $this->setarValorInicial();
    }
    public function setarValorInicial()
    {

        $this->banco['status_id'] = 1;
        $this->banco['designacao'] = NULL;
        $this->banco['sigla'] = NULL;
        $this->banco['num_conta'] = NULL;
        $this->banco['iban'] = NULL;
    }
}
