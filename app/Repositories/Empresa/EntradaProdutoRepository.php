<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\EntradaStock;
use App\Models\empresa\EntradaStockItems;
use Illuminate\Support\Facades\DB;

class EntradaProdutoRepository
{

    protected $entradaStock;
    protected $entradaStockItems;

    public function __construct(EntradaStock $entradaStock, EntradaStockItems $entradaStockItems)
    {
        $this->entradaStock = $entradaStock;
        $this->entradaStockItems = $entradaStockItems;
    }

    public function listarEntradasProduto($search)
    {
        return  $this->entradaStock::with(['entradaStockItems', 'entradaStockItems.produto', 'armazem', 'fornecedor', 'formaPagamento'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->search(trim($search))
            ->paginate();
    }
    public function store($entrada)
    {
        $CREDITO = 2;
        $NAOPAGO = 2;
        $PAGO = 1;

        $entradaId = DB::connection('mysql2')->table('entradas_stocks')->insertGetId([
            'data_factura_fornecedor' => $entrada['data_factura_fornecedor'],
            'fornecedor_id' => $entrada['fornecedor_id'],
            'empresa_id' => auth()->user()->empresa_id,
            'forma_pagamento_id' => $entrada['forma_pagamento_id'],
            'forma_pagamento_id' => $entrada['forma_pagamento_id'],
            'tipo_user_id' => 2,
            'num_factura_fornecedor' => $entrada['num_factura_fornecedor'],
            'descricao' => $entrada['descricao'],
            'total_compras' => $entrada['total_compras'],
            'totalSemImposto' => $entrada['totalSemImposto'],
            'total_retencao' => $entrada['total_retencao'],
            'total_iva' => $entrada['total_iva'],
            'total_venda' => $entrada['total_venda'],
            'total_desconto' => $entrada['total_desconto'],
            'user_id' => auth()->user()->id,
            'canal_id' => 2,
            'status_id' => 1,
            'statusPagamento' => $entrada['forma_pagamento_id'] == $CREDITO ? $NAOPAGO : $PAGO,
            'created_at' => $entrada['created_at'],
            'armazem_id' => $entrada['armazem_id'],
            'totalLucro' => $entrada['totalLucro'],
            'operador' => auth()->user()->name
        ]);

        foreach ($entrada['items'] as $key => $item) {
            DB::connection('mysql2')->table('entradas_stock_items')->insertGetId([
                'entrada_stock_id' => $entradaId,
                'produto_id' => $item['produto_id'],
                'preco_compra' => $item['preco_compra_unitario'],
                'preco_venda' => $item['preco_venda_unitario'],
                'descontoPerc' => $item['descontoPerc'],
                'descontoValor' => $item['descontoValor'],
                'quantidade' => $item['quantidade'],
                'lucroUnitario' => $item['lucroUnitario'],
            ]);
            DB::connection('mysql2')->table('existencias_stocks')
                ->where('produto_id', $item['produto_id'])
                ->where('armazem_id', $entrada['armazem_id'])
                ->increment('quantidade', $item['quantidade']);
        }
        return $entradaId;
    }
}
