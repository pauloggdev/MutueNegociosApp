<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;

trait UpdateEmpresaRequest
{

    public function rules()
    {
        return [
            'nome' => ['required'],
            'nif' => ['required'],
            'pais_id' => ['required'],
            'cidade' => ['required'],
            'tipo_cliente_id' => ['required'],
            'tipo_regime_id' => ['required'],
            'endereco' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', function ($attribute, $value, $fail) {
                $empresa = DB::connection('mysql2')->table('empresas')
                    ->where('email', $value)->first();
                if ($empresa && $empresa->id != auth()->user()->empresa->id) {
                    $fail('O ' . $attribute . ' já se encontra cadastrado');
                }
            }],
            'pessoal_Contacto' => [
                'required', 'digits:9', function ($attribute, $value, $fail) {
                    $empresa = DB::connection('mysql2')->table('empresas')
                        ->where('pessoal_Contacto', $value)->first();
                    if ($empresa && $empresa->id != auth()->user()->empresa->id) {
                        $fail('O contacto telefone já se encontra cadastrado');
                    }
                }
            ],
            'logotipo' => ['file', 'mimes:jpeg,png,jpg', 'max:300'],
        ];
    }
    public function messages()
    {
        return [
            'nome.required' => 'É obrigatório a indicação de um valor para o campo nome',
            'nif.required' => 'É obrigatório a indicação de um valor para o campo nif',
            'pais_id.required' => 'É obrigatório a indicação de um valor para o campo país',
            'cidade.required' => 'É obrigatório a indicação de um valor para o campo cidade',
            'tipo_cliente_id.required' => 'É obrigatório a indicação de um valor para o campo tipo de cliente',
            'tipo_regime_id.required' => 'É obrigatório a indicação de um valor para o campo tipo de regime',
            'email.required' => 'É obrigatório a indicação de um valor para o campo email',
            'pessoal_Contacto.required' => 'É obrigatório a indicação de um valor para o campo contacto telefonico',
            'endereco.required' => 'É obrigatório a indicação de um valor para o campo endereço',
        ];
    }
}
