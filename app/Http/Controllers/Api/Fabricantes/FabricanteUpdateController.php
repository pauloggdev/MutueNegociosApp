<?php

namespace App\Http\Controllers\Api\Fabricantes;

use App\Http\Controllers\Controller;
use App\Repositories\Empresa\FabricanteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class FabricanteUpdateController extends Controller
{

    private $fabricanteRepository;


    public function __construct(FabricanteRepository $fabricanteRepository)
    {
        $this->fabricanteRepository = $fabricanteRepository;
    }

    public function update(Request $request, $fabricanteId)
    {

        $messages = [
            'designacao.required' => 'Informe o nome',
            'status_id.required' => 'Informe o status',
        ];
        $validator = Validator::make($request->all(), [
            'designacao' => ["required", function ($attr, $value, $fail) use ($fabricanteId) {
                $fabricante =  DB::table('fabricantes')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('designacao', $value)
                    ->where('id', '!=', $fabricanteId)
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

        return $this->fabricanteRepository->update($request, $fabricanteId);
    }
}
