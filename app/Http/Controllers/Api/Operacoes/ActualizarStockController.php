<?php

namespace App\Http\Controllers\Api\Operacoes;

use App\Http\Controllers\Controller;
use App\Models\empresa\AtualizacaoStocks;
use App\Models\empresa\ExistenciaStock;
use App\Repositories\Empresa\AtualizacaoStockRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ActualizarStockController extends Controller
{

    private $atualizacaoStockRepository;


    public function __construct(AtualizacaoStockRepository $atualizacaoStockRepository)
    {
        $this->atualizacaoStockRepository = $atualizacaoStockRepository;
    }


    public function actualizarStock(Request $request)
    {

        $OPERACAO_DIMINUIR = 1;
        $OPERACAO_ADICIONAR = 2;
        
        $message = [
            'produto_id.required' => 'Informe o produto',
            'armazem_id.required' => 'Informe o armazém',
            'canal_id.required' => 'Informe o canal',
            'quantidade_nova.required' => 'Informe a nova quantidade',
            'operacao.required' => 'Informe a operação',
        ];

        $validator = Validator::make($request->all(), [
            'produto_id' => ['required'],
            'armazem_id' => ['required'],
            'canal_id' => ['required'],
            'quantidade_nova' => ['numeric', 'min:0', function ($attribute, $quantidade, $fail) use ($OPERACAO_ADICIONAR, $OPERACAO_DIMINUIR, $request) {
                if ($request->quantidade_nova != 0 && $request->quantidade_nova == null) {
                    return $fail('informe a quantidade em estoque');
                }
                $produto = DB::connection('mysql2')->table('existencias_stocks')
                    ->where('produto_id', $request->produto_id)
                    ->where('armazem_id', $request->armazem_id)->first();

                if ($produto) {
                    $quantidade_antes = $produto->quantidade;
                    $request['quantidade_antes'] = $produto->quantidade;
                } else {
                    return $fail('produto não existe para este armazém');
                }

                if ($quantidade_antes === $request->quantidade_nova) {
                    if ($OPERACAO_DIMINUIR != $request->operacao && $OPERACAO_ADICIONAR != $request->operacao) {
                        return $fail('Efectue alteração no estoque');
                    }
                }
                if ($OPERACAO_ADICIONAR == $request->operacao) {
                    if ($request->quantidade_nova === 0) {
                        return $fail('sem quantidade para aumentar');
                    }
                }
                if ($OPERACAO_DIMINUIR == $request->operacao) {

                    if ($request->quantidade_nova > $quantidade_antes) {
                        return  $fail('deve mininuir uma quantidade menor ou igual a quantidade antiga');
                    } else if ($request->quantidade_nova === 0) {
                        return  $fail('sem quantidade para reduzir');
                    }
                }
            }],

        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        $this->actualizarHistoricoStock($request);
        $atualizarStock = $this->atualizarExistenciaStock($request);
        return response()->json($atualizarStock, 200);
    }
    public function listarAtualizacaoStock()
    {
        $atualizacaoStock = $this->atualizacaoStockRepository->listarAtualizacaoStock();
        return response()->json($atualizacaoStock, 200);
    }

    public function actualizarHistoricoStock($request)
    {

        $OPERACAO_DIMINUIR = 1;
        $OPERACAO_ADICIONAR = 2;

        if ($OPERACAO_DIMINUIR == $request->operacao) {
            $descricao = "Reduzido " . $request->quantidade_nova . " produto(s) no estoque";
            $quantidadeNova = $request->quantidade_antes - $request->quantidade_nova;
        } else if ($OPERACAO_ADICIONAR == $request->operacao) {
            $quantidadeNova = $request->quantidade_antes + $request->quantidade_nova;
            $descricao = $request->descricao?? "Adicionado " . $request->quantidade_nova . " produto(s) no estoque";
        } else {
            $quantidadeNova = $request->quantidade_nova;
            $descricao =  $request->descricao?? "Actualizado o estoque com a quantidade " . $request->quantidade_nova;
        }
        $atualizacaoStocks = new AtualizacaoStocks();
        $atualizacaoStocks->empresa_id = auth()->user()->empresa_id;
        $atualizacaoStocks->produto_id = $request->produto_id;
        $atualizacaoStocks->quantidade_antes = $request->quantidade_antes;
        $atualizacaoStocks->quantidade_nova = $quantidadeNova;
        $atualizacaoStocks->user_id = auth()->user()->id;
        $atualizacaoStocks->canal_id = $request->canal_id ?? 2;
        $atualizacaoStocks->status_id = 1;
        $atualizacaoStocks->armazem_id = $request->armazem_id;
        $atualizacaoStocks->descricao = $request->descricao ? $request->descricao : $descricao;
        $atualizacaoStocks->save();
        return $atualizacaoStocks;
    }

    public function atualizarExistenciaStock($request)
    {
        $OPERACAO_DIMINUIR = 1;
        $OPERACAO_ADICIONAR = 2;

        $existenciaEstoque = ExistenciaStock::where('produto_id', $request->produto_id)
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('armazem_id', $request->armazem_id)->first();

        if ($OPERACAO_DIMINUIR == $request->operacao) {
            $existenciaEstoque->quantidade = $request->quantidade_antes - $request->quantidade_nova;
        } else if ($OPERACAO_ADICIONAR == $request->operacao) {
            $existenciaEstoque->quantidade = $request->quantidade_antes + $request->quantidade_nova;
        } 
        $existenciaEstoque->save();
        return $existenciaEstoque;
    }
}
