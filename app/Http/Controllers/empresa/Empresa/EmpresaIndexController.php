<?php

namespace App\Http\Controllers\empresa\Empresa;

use App\Models\admin\Pais;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Validator;


class EmpresaIndexController extends Component
{
    use WithFileUploads;


    public $empresa;

    public function boot()
    {
        $this->empresa['pais_id'] = 1;
    }

    public function render()
    {
        $data['tipoEmpresa'] = DB::table('tipos_clientes')->get();
        $data['tipoRegime'] = DB::table('tipos_regimes')->get();
        $data['paises'] = Pais::all();

        return view('empresa.empresas.index', $data)->extends('layouts.appCriarEmpresa');
    }

    public function cadastrarEmpresa()
    {
        $rules = [
            'empresa.email' => 'required',
            'empresa.nif' => 'required',
            'empresa.nome' => 'required',
            'empresa.cidade' => 'required',
        ];
        $messages = [
            'empresa.email.required' => 'Informe o email',
            'empresa.nif.required' => 'Informe o nif',
            'empresa.nome.required' => 'Informe o nome',
            'empresa.cidade.required' => 'Informe a cidade',
        ];

        $this->validate($rules, $messages);
    }

    public function validator()
    {

        $mensagem = [
            'email.required' => 'É obrigatória o contacto'
        ];

        return Validator::make($this->empresa, [
            'email' => ['required', 'email', 'max:145']
        ], $mensagem);
    }
}
