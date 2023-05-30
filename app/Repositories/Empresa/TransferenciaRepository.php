<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\ExistenciaStock;
use App\Models\empresa\TransferenciaProduto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransferenciaRepository
{

    protected $entity;
    protected $existenciaStockRepository;

    public function __construct(TransferenciaProduto $entity, ExistenciaStockRepository $existenciaStockRepository)
    {
        $this->entity = $entity;
        $this->existenciaStockRepository = $existenciaStockRepository;
    }

    public function transferirProduto($transferir)
    {


        $ultimaTransferencia = $this->getUltimaTransferencia();

        if ($ultimaTransferencia) {
            $dataTransferencia = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaTransferencia->created_at);
        } else {
            $dataTransferencia = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }
        //Manipulação de datas: data da factura e data actual
        //$data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/
        if ($dataTransferencia->diffInYears($datactual) == 0) {
            if ($ultimaTransferencia) {
                $dataTransferencia = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaTransferencia->created_at);
                $numSequenciaTransferencia = intval($ultimaTransferencia->numSequenciaTransferencia) + 1;
            } else {
                $dataTransferencia = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaTransferencia = 1;
            }
        } else if ($dataTransferencia->diffInYears($datactual) > 0) {
            $numSequenciaTransferencia = 1;
        }

        $numeracaoTransferencia = 'TP ' . mb_strtoupper(substr(auth()->user()->empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaTransferencia; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);

        $transferenciaId = $this->entity::insertGetId([
            'user_id' => auth()->user()->id,
            'canal_id' => $transferir['canal_id'],
            'empresa_id' => auth()->user()->empresa_id,
            'numeracao_transferencia' => $numeracaoTransferencia,
            'numSequenciaTransferencia' => $numSequenciaTransferencia,
            'tipo_user_id' => 2,
            'descricao' => $transferir['descricao'] ?? NULL
        ]);

        foreach ($transferir['items'] as $item) {
            $nomeProduto = DB::connection("mysql2")->table('produtos')->where('id', $item['produto_id'])->where('empresa_id', auth()->user()->empresa_id)->first()->designacao;

            $armazemOrigem = DB::connection("mysql2")->table('armazens')->where('id', $item['armazem_origem_id'])->where('empresa_id', auth()->user()->empresa_id)->first()->designacao;
            $armazemDestino = DB::connection("mysql2")->table('armazens')->where('id', $item['armazem_destino_id'])->where('empresa_id', auth()->user()->empresa_id)->first()->designacao;

            DB::connection('mysql2')->table('transferencias_produto_items')->insertGetId([
                'produto_id' => $item['produto_id'],
                'produto_designacao' => $nomeProduto,
                'transferencia_produto_id' => $transferenciaId,
                'armazem_origem_id' => $item['armazem_origem_id'],
                'armazem_destino_id' => $item['armazem_destino_id'],
                'quantidade_transferida' => $item['quantidade_transferida'],
                'armazem_origem' => $armazemOrigem,
                'armazem_destino' => $armazemDestino
            ]);

            //verificar se o produto existe na tabela Existência para o armazem destino
            $existenciaStockDestino = ExistenciaStock::where('empresa_id', auth()->user()->empresa_id)
                ->where('produto_id', $item['produto_id'])
                ->where('armazem_id', $item['armazem_destino_id'])->first();


            $existenciaStockOrigem = ExistenciaStock::where('empresa_id', auth()->user()->empresa_id)
                ->where('produto_id', $item['produto_id'])
                ->where('armazem_id', $item['armazem_origem_id'])->first();


            if ($existenciaStockOrigem) {
                $existenciaStockOrigem->update([
                    'quantidade' => $existenciaStockOrigem->quantidade - $item['quantidade_transferida']
                ]);
            }

            if ($existenciaStockDestino) {
                DB::connection('mysql2')->table('existencias_stocks')->where('id', $existenciaStockDestino->id)->update([
                    'quantidade' => $existenciaStockDestino->quantidade + $item['quantidade_transferida']
                ]);
            } else {
                $existenciaStock = new ExistenciaStock();
                $existenciaStock->produto_id = $item['produto_id'];
                $existenciaStock->armazem_id = $item['armazem_destino_id'];
                $existenciaStock->quantidade = $item['quantidade_transferida'];
                $existenciaStock->canal_id = $transferir['canal_id'];
                $existenciaStock->user_id = auth()->user()->id;
                $existenciaStock->status_id = 1;
                $existenciaStock->empresa_id = auth()->user()->empresa_id;
                $existenciaStock->save();
            }
        }

        return $transferenciaId;
    }
    public function listarTransferencias()
    {
        return $this->entity::with(['transferenciaProdutoItems'])
            ->where('empresa_id', auth()->user()->empresa_id)->paginate();
    }

    public function getUltimaTransferencia()
    {
        return  $this->entity::where('empresa_id', auth()->user()->empresa_id)->orderBy('id', 'DESC')->limit(1)->first();
    }
}
