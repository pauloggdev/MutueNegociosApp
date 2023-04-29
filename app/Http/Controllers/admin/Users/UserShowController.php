<?php

namespace App\Http\Controllers\admin\Users;
use Livewire\Component;

class UserShowController extends Component
{
    public $usuario;
    public function render()
    {

        $this->usuario = auth()->user();
        return view('admin.usuarios.perfil')->layout('layouts.appAdmin');
    }
  
}
