<?php

namespace App\Http\Controllers\Api\Bancos;

use App\Http\Controllers\Controller;
use App\Repositories\Empresa\BancoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class BancoUpdateController extends Controller
{

    private $bancoRepository;

    public function __construct(BancoRepository $bancoRepository)
    {
        $this->bancoRepository = $bancoRepository;
    }

    public function update(Request $request, $bancoId)
    {

        $messages = [
            'designacao.required' => 'Informe o nome',
            'sigla.required' => 'Informe a sigla',
            'num_conta.required' => 'Informe o número da conta',
            'iban.required' => 'Informe o iban',
            'canal_id.required' => 'Informe o iban',
            'status_id.required' => 'Informe o status',
        ];
        $validator = Validator::make($request->all(), [
            'designacao' => ["required", function ($attr, $value, $fail) use ($bancoId) {
                $banco =  DB::table('bancos')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('designacao', $value)
                    ->first();

                if ($banco && $banco->id != $bancoId) {
                    $fail("Banco já cadastrado");
                }
            }],
            'iban' => ["required", function ($attr, $value, $fail) use ($bancoId) {
                $banco =  DB::table('bancos')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('iban', $value)
                    ->first();

                if ($banco && $banco->id != $bancoId) {
                    $fail("Iban já cadastrado");
                }
            }],
            'status_id' => "required",
            'sigla' => "required",
            'num_conta' => "required",
            'canal_id' => "required",
        ], $messages);


        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        return $this->bancoRepository->update($request, $bancoId);
    }
}
