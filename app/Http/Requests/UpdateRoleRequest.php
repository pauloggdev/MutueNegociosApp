<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;

trait UpdateRoleRequest
{

    public function rules()
    {
        return [
            'role.designacao' => ["required", function ($attr, $value, $fail) {

                $role = DB::table('perfils')
                    ->where('designacao', $value)
                    ->where('id', $this->roleId)
                    ->where(function ($query) {
                        $query->orwhere('empresa_id', auth()->user()->empresa_id)
                            ->orwhere('empresa_id', NULL);
                    })
                    ->first();
                if ($role) {
                    $fail("Função já cadastrado");
                }
            }],
            "role.status_id" => "required"

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
