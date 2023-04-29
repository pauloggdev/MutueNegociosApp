<?php

namespace App\Http\Controllers\empresa\Usuarios;

use App\Http\Requests\UpdateUserRequest;
use App\Repositories\Empresa\RoleRepository;
use App\Repositories\Empresa\UserRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UsuarioUpdateController extends Component
{

    use LivewireAlert;
    use UpdateUserRequest;

    public $user;
    public $userId;
    public $selectedPerfils = [];
    private $userRepository;
    private $roleRepository;

    public function boot(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    public function mount($uuid)
    {
        $this->userId = $uuid;
        $this->user = $this->userRepository->getUser($uuid);
        $this->selectedPerfils = [];
        foreach ($this->user['perfis'] as $perfil) {
            array_push($this->selectedPerfils, $perfil['id']);
        }
        if (!$this->user) return redirect()->back();
    }


    public function render()
    {
        $data['roles'] = $this->roleRepository->listarPerfis();
        return view('empresa.usuarios.edit', $data);
    }
    public function atualizarUsuario()
    {

        if (count($this->selectedPerfils) <= 0) {
            $this->confirm('Informe pelo menos uma função', [
                'showConfirmButton' => false,
                'showCancelButton' => false,
                'icon' => 'warning'
            ]);
            return;
        }

        $this->validate($this->rules(), $this->messages());
        $this->userRepository->updateUser($this->user, $this->selectedPerfils);

        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
    }
}
