<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;

trait UpdateProdutoDestaqueRequest
{

    public function rules()
    {
        return [
            'destaque.produtoId' => ["required"],
            'destaque.designacao' => ["required"],
            'destaque.descricao' => ["required"],
        ];
    }
    public function messages()
    {
        return [
            'destaque.produtoId.required' => 'Informe o produto',
            'destaque.designacao.required' => 'Informe a designação',
            'destaque.descricao.required' => 'Informe a descrição',
        ];
    }
}
