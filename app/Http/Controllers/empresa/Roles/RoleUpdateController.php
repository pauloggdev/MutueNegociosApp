<?php

namespace App\Http\Controllers\empresa\Roles;

use App\Http\Requests\UpdateRoleRequest;
use App\Repositories\Empresa\RoleRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class RoleUpdateController extends Component
{

    use TraitEmpresaAutenticada;
    use UpdateRoleRequest;
    use LivewireAlert;


    public $search;
    public $role;
    public $roleId;
    private $roleRepository;


    public function mount($id)
    {
        $perfil = $this->roleRepository->getPerfil($id);

        if (!$perfil) {
            return redirect()->route('roles.index');
        }
        $this->role = $perfil;
    }

    public function boot(RoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function render()
    {
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }

        return view('empresa.roles.edit');
    }
    public function atualizarPerfil()
    {
        $this->validate($this->rules(), $this->messages());
        $this->roleRepository->update($this->role);

        $this->confirm('Operação Realizada com Sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success',
        ]);
    }
    
}
