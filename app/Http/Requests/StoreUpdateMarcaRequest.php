<?php

namespace App\Http\Requests;

use Carbon\Carbon;

trait StoreUpdateMarcaRequest 
{

    public function rules()
    {
        return [

            'marca.designacao' =>'required',
            'marca.status_id' =>'',
            'marca.canal_id'=>'',
            
        ];
    }
    public function messages()
    {
        return [
           
            'marca.designacao.required' => 'Informe o nome da Marca',
            
            
        ];
    }
}
