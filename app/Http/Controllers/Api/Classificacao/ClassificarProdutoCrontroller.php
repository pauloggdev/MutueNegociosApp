<?php

namespace App\Http\Controllers\Api\Classificacao;

use App\Http\Controllers\Controller;
use App\Repositories\Empresa\ClassificacaoRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClassificarProdutoCrontroller extends Controller
{
    private $classificacaoRepository;

    public function __construct(ClassificacaoRepository $classificacaoRepository)
    {
        $this->classificacaoRepository = $classificacaoRepository;
    }

    public function mv_classificarProduto(Request $request)
    {
        $messages = [
            'produto_id.required' => 'Informe o produto',
            'num_classificacao.required' => 'Informe o numero de classificação',
        ];
        $validator = Validator::make($request->all(), [
            'produto_id' => 'required',
            'num_classificacao' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        $classificacao =  $this->classificacaoRepository->store($request->all());
        if ($classificacao)
            return response()->json($classificacao, 200);
    }
}
