<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;

trait UpdateArmazemRequest
{

    public function rules()
    {
        return [
            'armazem.designacao' => ["required", function ($attr, $value, $fail) {

                $armazem = DB::table('armazens')->where('id', '!=', $this->armazem['id'])
                    ->where('designacao', $this->armazem['designacao'])
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->first();
                if ($armazem) {
                    $fail("Armazem já cadastrado");
                }
            }],
            "armazem.localizacao" => "required",
            "armazem.sigla" => '',
            "armazem.status_id" => "required",

        ];
    }
    public function messages()
    {
        return [
            'armazem.designacao.required' => 'Informe o nome do armazém',
            'armazem.localizacao.required' => 'Informe o endereço',
        ];
    }
}
