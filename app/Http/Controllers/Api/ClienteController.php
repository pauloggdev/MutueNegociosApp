<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Empresa\ClienteRepository;
use App\Repositories\Empresa\contracts\ClienteRepositoryInterface;
use App\Repositories\Empresa\contracts\RelatorioRepositoryInterface;
use App\Traits\Empresa\TraitEmpresa;
use App\Traits\Empresa\TraitPathRelatorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClienteController extends Controller
{
    use TraitEmpresa;
    use TraitPathRelatorio;

    private $clienteRepository;

    public function __construct()
    {
        $this->clienteRepository = App::make(ClienteRepository::class);
        // $this->relatorioRepository = App::make(RelatorioRepositoryInterface::class);
    }

    public function getClientes()
    {
        return $this->clienteRepository->getClientesApi();
    }
    public function getCliente(int $clienteId)
    {
        return $this->clienteRepository->getCliente($clienteId);
    }
    public function imprimirClientes()
    {

        $pathLogoCompany = $this->getPathCompany();
        $pathRelatorio = $this->getPathRelatorio();

        $data =  $this->relatorioRepository->print('clientes', [
            'dirSubreportEmpresa' => $pathRelatorio,
            'diretorio' => $pathLogoCompany
        ]);
        return $data;
    }

    public function store(Request $request)
    {

        $messages = [
            'nome.required' => 'Informe o nome',
            'telefone_cliente.required' => 'Informe o telefone',
            'endereco.required' => 'Informe o endereço',
            'cidade.required' => 'Informe a cidade',
            'tipo_cliente_id.required' => 'Informe o tipo cliente',
            'data_contrato.required' => 'Informe o tipo cliente',
        ];
        $validator = Validator::make($request->all(), [
            'nif' => ["required", function ($attr, $value, $fail) {
                $cliente =  DB::table('clientes')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('nif', $value)
                    ->first();

                if ($cliente) {
                    $fail("Cliente já cadastrado");
                }
            }],
            'nome' => ["required", function ($attr, $value, $fail) {
                $cliente =  DB::table('clientes')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('nome', $value)
                    ->first();

                if ($cliente) {
                    $fail("Cliente já cadastrado");
                }
            }],
            'telefone_cliente' => "required",
            'endereco' => "required",
            'cidade' => "required",
            'tipo_cliente_id' => "required",
            'data_contrato' => "required",
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        return $this->clienteRepository->store($request);
    }
    public function update(Request $request, $clienteId)
    {
        $messages = [
            'nome.required' => 'Informe o nome',
            'telefone_cliente.required' => 'Informe o telefone',
            'endereco.required' => 'Informe o endereço',
            'cidade.required' => 'Informe a cidade',
            'tipo_cliente_id.required' => 'Informe o tipo cliente',
            'data_contrato.required' => 'Informe o tipo cliente',
        ];
        $validator = Validator::make($request->all(), [
            'nif' => ["required", function ($attr, $value, $fail) use($clienteId) {
                $cliente =  DB::table('clientes')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('nif', $value)
                    ->where('id','!=',$clienteId)
                    ->first();

                if ($cliente) {
                    $fail("Cliente já cadastrado");
                }
            }],
            'nome' => ["required", function ($attr, $value, $fail) use($clienteId) {
                $cliente =  DB::table('clientes')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('nome', $value)
                    ->where('id','!=',$clienteId)
                    ->first();

                if ($cliente) {
                    $fail("Cliente já cadastrado");
                }
            }],
            'telefone_cliente' => "required",
            'endereco' => "required",
            'cidade' => "required",
            'tipo_cliente_id' => "required",
            'data_contrato' => "required",
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        return $this->clienteRepository->update($request, $clienteId);
    }
}
