<?php

namespace App\Http\Requests\Admin;

trait StoreMotivoRequest
{


    public function rules()
    {

        return [
            'motivo.codigoMotivo' => "required|unique:mysql.motivo,codigoMotivo",
            'motivo.codigoStatus' => 'required',
            'motivo.descricao' => 'required',

        ];
    }
    public function messages()
    {
        return  [
            'motivo.codigoMotivo.required' => 'Código é obrigatório',
            'motivo.codigoMotivo.unique' => 'motivo já cadastrado',
            'motivo.codigoStatus.required' => 'Status é obrigatorio',
            'motivo.descricao.required' => 'Descrição é obrigatorio',
        ];
    }
}
