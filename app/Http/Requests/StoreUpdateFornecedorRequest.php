<?php

namespace App\Http\Requests;

use Carbon\Carbon;

trait StoreUpdateFornecedorRequest
{

    public function rules()
    {
        return [

            'fornecedor.nome' => 'required',
            'fornecedor.endereco' => 'required',
            'fornecedor.data_contracto' => 'required',
            'fornecedor.telefone_empresa'=> 'required',
            'fornecedor.nif'=> 'required'
        ];
    }
    public function messages()
    {
        return [
            'fornecedor.nome.required' => 'Informe o nome do fornecedor',
            'fornecedor.telefone_empresa.required' => 'Informe o telefone da empresa',
            'fornecedor.endereco.required' => 'Informe o endereço',
            'fornecedor.nif.required' => 'Informe o NIF',
            'fornecedor.data_contracto.required' => 'Informe a data de contrato',
        ];
    }
}
