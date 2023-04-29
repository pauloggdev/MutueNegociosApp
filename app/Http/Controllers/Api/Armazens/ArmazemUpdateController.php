<?php

namespace App\Http\Controllers\Api\Armazens;

use App\Repositories\Empresa\ArmazemRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ArmazemUpdateController extends Controller
{

    private $armazemRepository;


    public function __construct(ArmazemRepository $armazemRepository)
    {
        $this->armazemRepository = $armazemRepository;
    }

    public function update(Request $request, $id)
    {
        $messages = [
            'localizacao.required' => 'Informe o endereço',
            'designacao.required' => 'Informe o nome do armazém',
        ];
        $validator = Validator::make($request->all(), [
            'designacao' => ["required", function ($attr, $value, $fail) use($id) {
                $armazem =  DB::table('armazens')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('designacao', $value)
                    ->where('id','!=', $id)
                    ->first();

                if ($armazem) {
                    $fail("Armazem já cadastrado");
                }
            }],
            'localizacao' => "required"
        ], $messages);

        $request['id'] = $id;
        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        return $this->armazemRepository->update($request->all());
    }
}
