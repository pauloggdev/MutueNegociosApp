<?php

namespace App\Http\Requests\Admin;

trait StoreTaxaRequest
{


    public function rules()
    {

        return [
            'taxaIva.taxa' => "required|unique:mysql.tipotaxa,taxa",
            'taxaIva.codigostatus' => 'required'
        ];
    }
    public function messages()
    {
        return  [
            'taxaIva.taxa.required' => 'Taxa é obrigatório',
            'taxaIva.taxa.unique' => 'taxaIva já cadastrado',
            'taxaIva.codigostatus.required' => 'Status é obrigatorio',
        ];
    }
}
