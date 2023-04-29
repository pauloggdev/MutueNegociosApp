<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;

trait UpdateFabricanteRequest
{

    public function rules()
    {
        return [
            'fabricante.designacao' => ["required", function($attr, $value, $fail){

                $fabricante = DB::table('fabricantes')->where('id','!=', $this->fabricante['id'])
                ->where('designacao', $this->fabricante['designacao'])
                ->where('empresa_id', auth()->user()->empresa_id)
                ->first();
                if($fabricante){
                    $fail("Fabricante já cadastrado");
                }
            }]

        ];
    }
    public function messages()
    {
        return [
            'fabricante.designacao.required' => 'Informe o nome do fabricante',
        ];
    }
}
