<?php

namespace App\Http\Controllers\empresa\Usuarios;

use App\Repositories\Empresa\PermissaoRepository;
use App\Repositories\Empresa\RoleRepository;
use App\Repositories\Empresa\UserRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UsuarioPermissoesIndexontroller extends Component
{

    use TraitEmpresaAutenticada;
    use LivewireAlert;


    public $search;
    public $user;
    public $selectedPermissoes = [];
    private $userRepository;
    private $permissaoRepository;
    public $permissoes;



    public function mount($uuid)
    {
        $user = $this->userRepository->getUser($uuid);
        if (!$user) {
            return redirect()->route('usuarios.index');
        }
        $this->user = $user;


        $this->permissoes = $this->permissaoRepository->getPermissoes($this->search);
        $this->selectedPermissoes = [];
        $userPermissoes = $this->permissaoRepository->getPermissoesPorUsuario($this->user->id);
        foreach ($userPermissoes as $user) {
            array_push($this->selectedPermissoes, $user['permission_id']);
        }
    }

    public function boot(UserRepository $userRepository, PermissaoRepository $permissaoRepository)
    {
        $this->userRepository = $userRepository;
        $this->permissaoRepository = $permissaoRepository;
    }

    public function render()
    {


        return view('empresa.usuarios.permissoes');
    }
    public function checkPermissaoPorUsuario($permissaoId)
    {
        $this->permissaoRepository->checkPermissaoPorUsuario($permissaoId, $this->user->id);
        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success',
        ]);
    }
    // public function atualizarPerfil()
    // {
    //     $this->validate($this->rules(), $this->messages());
    //     $this->roleRepository->update($this->role);

    //     $this->confirm('Operação Realizada com Sucesso', [
    //         'showConfirmButton' => false,
    //         'showCancelButton' => false,
    //         'icon' => 'success',
    //     ]);
    // }
}
