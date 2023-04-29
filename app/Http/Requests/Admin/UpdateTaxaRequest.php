<?php

namespace App\Http\Requests\Admin;

trait UpdateTaxaRequest
{


    public function rules()
    {
        return [
            'taxaIva.taxa' => "required|unique:mysql.tipotaxa,taxa,{$this->taxaId},codigo",
            'taxaIva.codigostatus' => 'required'
        ];
    }
    public function messages()
    {
        return  [
            'taxaIva.taxa.required' => 'Taxa é obrigatório',
            'taxaIva.taxa.unique' => 'taxaIva já cadastrado',
            'taxaIva.codigostatus.required' => 'Status é obrigatório',
        ];
    }
}
