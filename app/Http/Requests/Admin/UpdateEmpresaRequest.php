<?php

namespace App\Http\Requests\Admin;

trait UpdateEmpresaRequest
{


    public function rules()
    {
        return [
            'empresa.nome' => 'required',
            'empresa.email' => 'required',
            'empresa.pessoal_Contacto' => 'required',
            'empresa.endereco' => 'required',
            'empresa.nif' => 'required',
            'empresa.website' => '',
            'empresa.cidade' => 'required',
            'empresa.tipo_regime_id' => 'required',
            'empresa.tipo_cliente_id' => 'required',
            'empresa.pessoa_de_contacto' => '',
        ];
    }
    public function messages()
    {
        return  [

            'empresa.nome.required' => 'Nome é obrigatorio',
            'empresa.email.required' => 'E-mail é obrigatorio',
            'empresa.pessoal_Contacto.required' => 'Telefone é obrigatorio',
            'empresa.endereco.required' => 'Endereço é obrigatorio',
            'empresa.nif.required' => 'NIF é obrigatorio',
            'empresa.cidade.required' => 'Cidade é obrigatorio',
            'empresa.tipo_regime_id.required' => 'Regime da empresa é obrigatorio',
        ];
    }
}
