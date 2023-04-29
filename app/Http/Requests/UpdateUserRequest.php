<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;

trait UpdateUserRequest
{

    public function rules()
    {
        return [
            'user.name' => 'required',
            'user.email' => [
                "required", function ($attr, $value, $fail) {
                    $user =  DB::table('users_cliente')
                        ->where('uuid', "!=", $this->userId)
                        ->where('empresa_id', auth()->user()->empresa_id)
                        ->where('email', $value)
                        ->first();

                    if ($user) {
                        $fail("E-mail já cadastrado");
                    }
                }
            ],
            'user.telefone' => "required",
            'user.status_id' => "required",
            'user.username' => "",

        ];
    }
    public function messages()
    {
        return [
            'user.name.required' => 'Informe o nome',
            'user.email.required' => 'Informe o email',
            'user.telefone.required' => 'Informe o número telefone',
            'user.status_id.required' => 'Informe o status',
        ];
    }
}
