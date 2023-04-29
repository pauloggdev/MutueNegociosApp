<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Empresa\contracts\ClienteRepositoryInterface;
use App\Repositories\Empresa\contracts\FornecedorRepositoryInterface;
use App\Repositories\Empresa\contracts\RelatorioRepositoryInterface;
use App\Traits\Empresa\TraitEmpresa;
use App\Traits\Empresa\TraitPathRelatorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FornecedorController extends Controller
{
    use TraitEmpresa;
    use TraitPathRelatorio;

    private $fornecedorRepository;


    public function __construct()
    {
        $this->fornecedorRepository = App::make(FornecedorRepositoryInterface::class);
    }

    public function getFornecedores()
    {
        return $this->fornecedorRepository->getFornecedores();
    }
    public function getfornecedor(int $fornecedorId)
    {
        return $this->fornecedorRepository->getfornecedor($fornecedorId);
    }
    public function imprimirFornecedor()
    {

        $pathLogoCompany = $this->getPathCompany();
        $pathRelatorio = $this->getPathRelatorio();

        $data =  $this->relatorioRepository->print('fornecedores', [
            'dirSubreportEmpresa' => $pathRelatorio,
            'diretorio' => $pathLogoCompany
        ]);
        return $data;
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

    public function update(Request $request, int $fornecedorId)
    {

        $messages = [
            'nome.required' => 'Informe o nome',
            'telefone_empresa.required' => 'Informe o telefone',
            'endereco.required' => 'Informe o endereço',
            'pais_nacionalidade_id.required' => 'Informe a nacionalidade',
            'nif.required' => 'Informe o nif',
            'data_contracto.required' => 'Informe a data de contrato',
            'status_id.required' => 'Informe o status',
        ];
        $validator = Validator::make($request->all(), [
            'nome' => ["required", function ($attr, $value, $fail) use($fornecedorId) {
                $fornecedor =  DB::table('fornecedores')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('nome', $value)
                    ->where('id', '!=', $fornecedorId)
                    ->first();

                if ($fornecedor) {
                    $fail("Fornecedor já cadastrado");
                }
            }],
            'nif' => ["required", function ($attr, $value, $fail) use($fornecedorId){
                $fornecedor =  DB::table('fornecedores')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('nif', $value)
                    ->where('id', '!=', $fornecedorId)
                    ->first();

                if ($fornecedor) {
                    $fail("Fornecedor já cadastrado");
                }
            }],
            'telefone_empresa' => "required",
            'endereco' => "required",
            'pais_nacionalidade_id' => "required",
            'data_contracto' => "required",
            'status_id' => "required",
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        return $this->fornecedorRepository->update($request, $fornecedorId);
    }
}
