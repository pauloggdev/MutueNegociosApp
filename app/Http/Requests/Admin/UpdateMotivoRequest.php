<?php

namespace App\Http\Requests\Admin;

trait UpdateMotivoRequest
{


    public function rules()
    {

        return [
            'motivo.codigoMotivo' => "required|unique:mysql.motivo,codigoMotivo,{$this->motivoId},codigo",
            'motivo.codigoStatus' => 'required',
            'motivo.descricao' => 'required',
        ];
    }
    public function messages()
    {
        return  [
            'motivo.codigoMotivo.required' => 'Código é obrigatório',
            'motivo.codigoStatus.required' => 'Status é obrigatorio',
            'motivo.codigoMotivo.unique' => 'motivo já cadastrado',
            'motivo.descricao.required' => 'Descrição é obrigatorio',
        ];
    }
}
