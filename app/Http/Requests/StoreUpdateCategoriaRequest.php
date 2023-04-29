<?php

namespace App\Http\Requests;

use Carbon\Carbon;

trait StoreUpdateCategoriaRequest
{

    public function rules()
    {
        return [

            'categoria.designacao' =>'required',
            'categoria.status_id' =>'',
            'categoria.canal_id'=>'',
            'categoria.newImagem'=>'',
            'categoria.imagem'=>'',

        ];
    }
    public function messages()
    {
        return [

            'categoria.designacao.required' => 'Informe o nome da Categoria',


        ];
    }
}
