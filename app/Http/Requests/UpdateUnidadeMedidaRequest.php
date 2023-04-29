<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;

trait UpdateUnidadeMedidaRequest
{
    public function rules()
    {
        return [
            'unidade.designacao' => ["required", function ($attr, $value, $fail) {

                $unidade = DB::table('unidade_medidas')->where('id', '!=', $this->unidade['id'])
                    ->where('designacao',"like", $this->unidade['designacao'])
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->first();
                if ($unidade) {
                    $fail("Unidade já cadastrado");
                }
            }],
            "unidade.status_id" => "required",

        ];
    }
    public function messages()
    {
        return [
            'unidade.designacao.required' => 'Informe a unidade',
            'unidade.status_id.required' => 'Informe o status',
        ];
    }
}
