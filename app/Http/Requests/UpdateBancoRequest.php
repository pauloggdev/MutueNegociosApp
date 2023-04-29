<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;

trait UpdateBancoRequest
{

    public function rules()
    {
        return [
            'banco.designacao' => ["required", function ($attr, $value, $fail) {

                $banco = DB::table('bancos')->where('id', '!=', $this->banco['id'])
                    ->where('designacao',"like", $this->banco['designacao'])
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->first();
                if ($banco) {
                    $fail("Banco já cadastrado");
                }
            }],
            "banco.sigla" => "required",
            "banco.num_conta" => "required",
            "banco.iban" => "required",
            "banco.status_id" => "required",

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
