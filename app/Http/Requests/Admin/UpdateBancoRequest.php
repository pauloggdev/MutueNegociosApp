<?php

namespace App\Http\Requests\Admin;

trait StoreBancoRequest
{


    public function rules()
    {

        return [
            'banco.designacao' => "required|unique:mysql.bancos,designacao,{$this->uuid},uuid",
            'banco.sigla' => 'required',
            'banco.iban' => 'required',
            'banco.num_conta' => 'required',
            'banco.status_id' => 'required'
        ];
    }
    public function messages()
    {
        return  [
            'banco.designacao.required' => 'Nome é obrigatorio',
            'banco.status_id.required' => 'Status é obrigatorio',
            'banco.sigla.required' => 'Sigla é obrigatorio',
            'banco.iban.required' => 'Iban é obrigatorio',
            'banco.num_conta.required' => 'Nº da conta é obrigatorio',
            'banco.designacao.unique' => 'banco já cadastrado',
        ];
    }
}
