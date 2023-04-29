<?php

namespace App\Http\Controllers\Api\Armazens;

use App\Repositories\Empresa\ArmazemRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ArmazemCreateController extends Controller
{

    private $armazemRepository;


    public function __construct(ArmazemRepository $armazemRepository)
    {
        $this->armazemRepository = $armazemRepository;
    }

    public function store(Request $request)
    {

        $messages = [
            'localizacao.required' => 'Informe o endereço',
            'designacao.required' => 'Informe o nome do armazém',
        ];
        $validator = Validator::make($request->all(), [
            'designacao' => ["required", function ($attr, $value, $fail) {
                $armazem =  DB::table('armazens')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('designacao', $value)
                    ->first();

                if ($armazem) {
                    $fail("Armazem já cadastrado");
                }
            }],
            'localizacao' => "required"
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        return $this->armazemRepository->store($request->all());
    }
}
