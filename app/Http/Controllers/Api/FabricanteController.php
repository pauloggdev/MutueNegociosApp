<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Empresa\contracts\ClienteRepositoryInterface;
use App\Repositories\Empresa\contracts\FabricanteRepositoryInterface;
use App\Repositories\Empresa\contracts\FornecedorRepositoryInterface;
use App\Repositories\Empresa\contracts\RelatorioRepositoryInterface;
use App\Traits\Empresa\TraitEmpresa;
use App\Traits\Empresa\TraitPathRelatorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FabricanteController extends Controller
{
    use TraitEmpresa;
    use TraitPathRelatorio;

    private $FabricanteRepository;


    public function __construct()
    {
        $this->FabricanteRepository= App::make(FabricanteRepositoryInterface::class);
        
    }

    public function getFabricantes()
    {
        return $this->FabricanteRepository->getFabricantes();
    }
    public function getFabricante(int $fabricanteId)
    {
        return $this->FabricanteRepository->getFabricante($fabricanteId);
    }
    public function imprimirfabricante()
    {

        $pathLogoCompany = $this->getPathCompany();
        $pathRelatorio = $this->getPathRelatorio();

        $data =  $this->relatorioRepository->print('fabricantes', [
            'dirSubreportEmpresa' => $pathRelatorio,
            'diretorio' => $pathLogoCompany
        ]);
        return $data;
    }

    public function store(Request $request)
    {
        $messages = [
            'designacao.required' => 'Informe o nome',
            'status_id.required' => 'Informe o status',
        ];
        $validator = Validator::make($request->all(), [
            'designacao' => ["required", function ($attr, $value, $fail) {
                $fabricante =  DB::table('fabricantes')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('designacao', $value)
                    ->first();

                if ($fabricante) {
                    $fail("Fabricante já cadastrado");
                }
            }],
            'status_id' => "required",
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        return $this->FabricanteRepository->store($request);       
    }

    public function update (Request $request, int $fabricante){


        $messages = [
            'designacao.required' => 'Informe o nome',
            'status_id.required' => 'Informe o status',
        ];
        $validator = Validator::make($request->all(), [
            'designacao' => ["required", function ($attr, $value, $fail) use($fabricante) {
                $fabricante =  DB::table('fabricantes')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('designacao', $value)
                    ->where('id','!=', $fabricante)
                    ->first();

                if ($fabricante) {
                    $fail("Fabricante já cadastrado");
                }
            }],
            'status_id' => "required",
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        return $this->FabricanteRepository->update($request,$fabricante);
    }
}
