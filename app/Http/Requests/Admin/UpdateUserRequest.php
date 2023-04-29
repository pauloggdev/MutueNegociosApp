<?php

namespace App\Http\Requests\Admin;

trait UpdateUserRequest
{


    public function rules()
    {
        return [
            'utilizador.name' => 'required|min:3|max:255',
            'utilizador.username' => 'required|min:3|max:255',
            // 'email' => 'required|exists:mysql.mutue_negocios_admin.users_admin,email',
            'utilizador.email' => "required|unique:mysql.users_admin,email,{$this->utilizadorId},id|email|min:3",
            'utilizador.telefone' => "required|unique:mysql.users_admin,telefone,{$this->utilizadorId},id",
            // 'utilizador.foto' => 'image|max:1024',
            'utilizador.status_id'=> ''
        ];
    }
    public function messages()
    {
        return  [

            'utilizador.name.required' => 'Nome é obrigatorio',
            'utilizador.username.required' => 'Username é obrigatorio',
            'utilizador.email.required' => 'E-mail é obrigatorio',
            'utilizador.email.unique' => 'E-mail já cadastrado',
            'utilizador.telefone.required' => 'Telefone é obrigatorio',
            'utilizador.telefone.unique' => 'Telefone já cadastrado',
        ];
    }
}
