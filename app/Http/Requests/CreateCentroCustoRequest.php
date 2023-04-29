<?php

namespace App\Http\Requests;
use App\Rules\Empresa\EmpresaUnique;

use Illuminate\Support\Facades\DB;

trait CreateCentroCustoRequest
{

    public function rules()
    {
        return [
            'centroCusto.nome' => ['required',  function ($attribute, $value, $fail) {
                $empresa = DB::connection('mysql2')->table('centro_custos')
                    ->where('nome', $value)->first();
                if ($empresa && $empresa->id != auth()->user()->empresa->id) {
                    $fail('O ' . $attribute . ' já se encontra cadastrado');
                }
            }],
            'centroCusto.nif' => ['required'],
            'centroCusto.cidade' => ['required'],
            'centroCusto.status_id' => ['required'],
            'centroCusto.endereco' => ['required'],
            'centroCusto.email' => ['required'],
            'centroCusto.telefone' => ['required'],
            'centroCusto.website'=> '',
            'centroCusto.pessoa_de_contacto' => ''
        ];
    }
    public function messages()
    {
        return [
            'centroCusto.nome.required' => 'Nome é obrigatório',
            'centroCusto.nome.unique' => 'Nome já cadastrado',
            'centroCusto.cidade.required' => 'Cidade é obrigatório',
            'centroCusto.endereco.required' => 'Endereço é obrigatório',
            'centroCusto.email.required' => 'E-mail é obrigatório',
            'centroCusto.nif.required' => 'NIF é obrigatório',
            'centroCusto.telefone.required' => 'Telefone é obrigatório',

        ];
    }
}
