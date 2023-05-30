<?php

namespace App\Http\Controllers\Api\Operacoes;

use App\Http\Controllers\Controller;
use App\Repositories\Empresa\ExistenciaStockRepository;
use App\Repositories\Empresa\TransferenciaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransferenciaProdutoController extends Controller
{

    private $transferenciaRepository;
    private $existenciaStockRepository;

    public function __construct(TransferenciaRepository $transferenciaRepository, ExistenciaStockRepository $existenciaStockRepository)
    {
        $this->transferenciaRepository = $transferenciaRepository;
        $this->existenciaStockRepository = $existenciaStockRepository;
    }


    public function store(Request $request)
    {
        $message = [
            'canal_id.required' => 'Informe o canal',
        ];
        $validator = Validator::make($request->all(), [
            'canal_id' => ['required'],
            'items.*.produto_id' => ['required', function ($attr, $produto_id, $fail) use ($request) {
                foreach ($request->items as $item) {
                    $produto = DB::connection()->table('produtos')->where('id', $item['produto_id'])
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->first();
                    if (!$produto) {
                        $fail('produto não existe');
                        return;
                    }
                }
            }],
            'items.*.armazem_origem_id' => ['required'],
            'items.*.armazem_destino_id' => ['required'],
            'items.*.quantidade_transferida' => ['required', function ($attr, $quantidadeTransferir, $fail) use ($request) {
                foreach ($request->items as $item) {
                    $existenciaStock = $this->existenciaStockRepository->listarExistenciaStock($item['produto_id'], $item['armazem_origem_id']);
                    $quantidadeArmazemOrigem = $existenciaStock->quantidade;
                    if ($quantidadeTransferir > $quantidadeArmazemOrigem) {
                        $fail("A quantidade a transferir é maior a quantidade existente no armazém de origem");
                    }
                    if ($item['armazem_origem_id'] == $item['armazem_destino_id']) {
                        $fail('o armazém origem deve ser diferente do armazém destino');
                        return;
                    }
                }
            }],

        ], $message);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        $transferenciaProduto = $this->transferenciaRepository->transferirProduto($request->all());
        return response()->json($transferenciaProduto, 200);
    }
    public function listarTransferencias()
    {
        $transferenciaProduto = $this->transferenciaRepository->listarTransferencias();
        return response()->json($transferenciaProduto, 200);
    }
}
