<?php

namespace App\Http\Controllers\admin\Users;

use App\Http\Requests\Admin\UpdateUserRequest;
use App\Repositories\Admin\UserRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserUpdateController extends Component
{

    use WithFileUploads;
    use LivewireAlert;
    use UpdateUserRequest;

    private $userRepository;
    public $utilizador;
    public $fotoAnterior;
    public $fotoAtual;

    public $utilizadorId;


    public function mount($utilizadorId)
    {
        $this->utilizadorId = $utilizadorId;
        $this->utilizador = $this->userRepository->getUser($this->utilizadorId);
        $this->fotoAnterior = $this->utilizador['foto'];
    }
    public function boot(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function render()
    {
        return view('admin.usuarios.edit')->layout('layouts.appAdmin');
    }
    public function atualizarUtilizador()
    {
        $this->utilizador['foto_atual'] = NULL;
        if ($this->fotoAtual) {
            $this->utilizador['foto_atual'] = $this->fotoAtual;
        }
        $this->validate($this->rules(), $this->messages());
        $this->userRepository->updateUser($this->utilizador);
        $this->alert('success', 'Operação realizada com sucesso');


    }
}
