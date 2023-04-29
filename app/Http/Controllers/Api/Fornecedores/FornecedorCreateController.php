<?php

namespace App\Http\Controllers\Api\Fornecedores;

use App\Http\Controllers\Controller;
use App\Repositories\Empresa\FornecedorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class FornecedorCreateController extends Controller
{

    private $fornecedorRepository;


    public function __construct(FornecedorRepository $fornecedorRepository)
    {
        $this->fornecedorRepository = $fornecedorRepository;
    }

    public function store(Request $request)
    {

        $messages = [
            'nome.required' => 'Informe o nome',
            'telefone_empresa.required' => 'Informe o telefone',
            'endereco.required' => 'Informe o endereço',
            'pais_nacionalidade_id.required' => 'Informe a nacionalidade',
            'nif.required' => 'Informe o nif',
            'data_contracto.required' => 'Informe a data de contrato',
            'status_id.required' => 'Informe o status'
        ];
        $validator = Validator::make($request->all(), [
            'nome' => ["required", function ($attr, $value, $fail) {
                $fornecedor =  DB::table('fornecedores')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('nome', $value)
                    ->first();

                if ($fornecedor) {
                    $fail("Fornecedor já cadastrado");
                }
            }],
            'nif' => ["required", function ($attr, $value, $fail) {
                $fornecedor =  DB::table('fornecedores')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('nif', $value)
                    ->where('nif','!=', '999999999')
                    ->first();

                if ($fornecedor) {
                    $fail("Fornecedor já cadastrado");
                }
            }],
            'telefone_empresa' => "required",
            'endereco' => "required",
            'pais_nacionalidade_id' => "required",
            'data_contracto' => "required",
            'status_id' => "required"
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        return $this->fornecedorRepository->store($request);
    }
}
