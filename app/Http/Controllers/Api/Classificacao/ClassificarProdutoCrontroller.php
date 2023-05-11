<?php

namespace App\Http\Controllers\Api\Classificacao;

use App\Http\Controllers\Controller;
use App\Repositories\Empresa\ClassificacaoRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'comentario.required' => "Informe o comentário"
        ];
        $validator = Validator::make($request->all(), [
            'produto_id' => ["required", function ($attr, $produtoId, $fail) {
                $produto = DB::connection('mysql2')->table('produtos')->where('id', $produtoId)->first();
                if (!$produto) {
                    $fail("Produto não encontrado");
                    return;
                }
            }],
            'num_classificacao' => 'required',
            'comentario' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        $classificacao =  $this->classificacaoRepository->store($request->all());

        $created_at = Carbon::parse($classificacao->created_at);
        $updated_at = Carbon::parse($classificacao->updated_at);

        $message = "";
        if ($created_at->equalTo($updated_at)) {
            $message = "Comentário adicionado com sucesso!";
        } else {
            $message = "Comentário alterado com sucesso!";
        }
        if ($classificacao)
            return response()->json([
                'data' => $classificacao,
                'message' => $message,
            ], 200);
    }
    public function buscarDadosTeste($id)
    {
        return DB::table('users_cliente')->where('id', $id)->get();
    }
}
