<?php

namespace App\Http\Controllers\admin\Users;

use App\Models\admin\User;
use App\Repositories\Admin\UserRepository;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UserUpdatePasswordController extends Component
{

    use LivewireAlert;
    public $user;
    private $userRepository;


    public function boot(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->setarValorInicial();
    }


    public function render()
    {
        $this->usuario = auth()->user();
        return view('admin.usuarios.perfil')->layout('layouts.appAdmin');
    }

    public function updatePassword()
    {

        $rules = [
            'user.old_password' => ["required", function ($attr, $value, $fail) {
                $user = User::find(auth()->user()->id);
                if (!Hash::check($this->user['old_password'], $user['password'])) {
                    $fail('A senha antiga não correspondem com atuals');
                }
            }],
            'user.password' => 'required|min:8|max:255'
        ];
        $messages = [
            'user.old_password.required' => 'Senha antiga é obrigatorio',
            'user.password.required' => 'Nova senha é obrigatorio',

        ];

        $this->validate($rules, $messages);
        $this->userRepository->updatePassword($this->user);
        $this->alert('success', 'Operação realizada com sucesso');
        $this->setarValorInicial();
    }
    public function setarValorInicial()
    {

        $this->user['old_password']  = NULL;
        $this->user['password']  = NULL;
    }
}
