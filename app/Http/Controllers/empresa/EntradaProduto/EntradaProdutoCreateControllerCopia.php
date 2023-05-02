<?php

namespace App\Http\Controllers\empresa\EntradaProduto;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Admin\FormaPagamentoRepository;
use App\Repositories\Empresa\ArmazemRepository;
use App\Repositories\Empresa\EntradaProdutoRepository;
use App\Repositories\Empresa\FormaPagamentoRepository as EmpresaFormaPagamentoRepository;
use App\Repositories\Empresa\FornecedorRepository;
use App\Repositories\Empresa\ProdutoRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EntradaProdutoCreateController extends Component
{
    use LivewireAlert;


    private $fornecedorRepository;
    public $fornecedores;




    // private $entradaProdutoRepository;
    // private $formaPagamentoRepository;
    // private $empresaFormaPagamentoRepository;
    // private $produtoRepository;
    // private $armazemRepository;


    // public $produtos;



    public $search = NULL;
    // public $formaPagamentoId;
    // public $produto;
    // public $fornecedorId;
    // public $armazemId;
    // public $dataFacturaFornecedor;
    // public $dataEntrada;
    // public $numFacturaFornecedor;
    // public $totalSemImpostoSemDesconto;


    // public $precoCompra = 0;
    // public $desconto = 0;
    // public $quantidade = 1;
    public $entrada = [
        'num_factura_fornecedor' => '',
        'fornecedor_id' => ''
        // 'data_factura_fornecedor' => null,
        // 'dataEntrada' => null,
        // 'fornecedor_id' => null,
        // 'forma_pagamento_id' => null,
        // 'num_factura_fornecedor' => null,
        // 'descricao' => null,
        // 'total_compras' => null,
        // 'total_venda' => null,
        // 'total_iva' => null,
        // 'total_desconto' => null,
        // 'total_retencao' => null,
        // 'totalLucro' => null,
        // 'itens' => []
    ];
    public $keyCart = 0;

     public function boot(
             FornecedorRepository $fornecedorRepository
    //     EntradaProdutoRepository $entradaProdutoRepository,
    //     FormaPagamentoRepository $formaPagamentoRepository,
    //     EmpresaFormaPagamentoRepository $empresaFormaPagamentoRepository,
    //     ProdutoRepository $produtoRepository,
    //     ArmazemRepository $armazemRepository
    ) {
            $this->fornecedorRepository = $fornecedorRepository;
    //     $this->entradaProdutoRepository = $entradaProdutoRepository;
    //     $this->formaPagamentoRepository = $formaPagamentoRepository;
    //     $this->produtoRepository = $produtoRepository;
    //     $this->armazemRepository = $armazemRepository;
    //     $this->empresaFormaPagamentoRepository = $empresaFormaPagamentoRepository;
    // }
     public function mount(){
    //     $this->produtos  = $this->produtoRepository->getProdutos();
    //     $this->formaPagamentos  = $this->empresaFormaPagamentoRepository->listarFormaPagamentosSemPagamentoDuplo();
        $this->fornecedores = $this->fornecedorRepository->getFornecedoresSemPaginacao();
    //     $this->armazens = $this->armazemRepository->getArmazensSemPaginacao();
    }



    public function render()
    {
        return view('empresa.EntradaProdutos.create');
    }

    public function addCarrinho()
    {

        $rules = [
            'dataFacturaFornecedor' => 'required',
            'fornecedorId' => 'required',
            'armazemId' => 'required',
            'dataEntrada' => 'required',
            'formaPagamentoId' => 'required',
            // 'produto' => 'required',
            'precoCompra' => ['required', function ($attr, $precoCompra, $fail) {
                if ($precoCompra < 0) {
                    $fail("Preço está negativo");
                }
            }],
            'quantidade' => ['required', function ($attr, $quantidade, $fail) {
                if ($quantidade < 1) {
                    $fail("Quantidade não aceite");
                }
            }],
            'desconto' => ['required', function ($attr, $desconto, $fail) {
                if ($desconto < 0) {
                    $fail("Desconto está negativo");
                }
            }],
        ];
        $messages = [
            'dataFacturaFornecedor.required' => 'Informe a data factura',
            'dataEntrada.required' => 'Informe a data entrada',
            'fornecedorId.required' => 'Informe o fornecedor',
            'formaPagamentoId.required' => 'Informe a forma de pagamento',
            'armazemId.required' => 'Informe o armazém',
            // 'produto.required' => 'Informe o produto',
            'precoCompra.required' => 'Informe o preço de compra',
            'quantidade.required' => 'Informe a quantidade',
            'desconto.required' => 'Informe o desconto',
        ];

        $this->validate($rules, $messages);

        $produto = json_decode($this->produto);

        $this->entrada['data_factura_fornecedor'] = $this->dataFacturaFornecedor;
        $this->entrada['data_factura_fornecedor'] = $this->dataFacturaFornecedor;


        $totalCompras = $this->totalCompras($this->precoCompra, $this->quantidade);
        $totalVendas = $this->totalVendas($produto->preco_venda, $this->quantidade);
        $totalLucros = $this->totalLucro($totalVendas, $totalCompras);

        $item = [
            'produto_id' => $produto->id,
            'produto_designacao' => $produto->designacao,
            'preco_compra' => (float) $this->precoCompra,
            'preco_venda' => $produto->preco_venda,
            'quantidade' => $this->quantidade,
            'total_compras' => $totalCompras,
            'total_vendas' => $totalVendas,
            'total_lucro' => $totalLucros,
            'desconto' => $this->desconto,
            'lucroUnitario' => $produto->preco_venda - (float) $this->precoCompra
        ];

        $key = $this->isCart($produto->id);
        if ($key) {
            $this->confirm('Produto já adicionado', [
                'showConfirmButton' => false,
                'showCancelButton' => false,
                'icon' => 'warning'
            ]);
            return;
        } else {
            $this->entrada['itens'][++$this->keyCart] = $item;
        }
    }
    public function TotalFinalCompras()
    {
        $total = 0;
        foreach ($this->entrada['itens'] as $key => $item) {
            $total += $item['total_compras'];
        }
        return $total;
    }
    public function TotalFinalVendas()
    {
        $total = 0;
        foreach ($this->entrada['itens'] as $key => $item) {
            $total += $item['total_vendas'];
        }
        return $total;
    }
    public function TotalFinalLucros()
    {
        $total = 0;
        foreach ($this->entrada['itens'] as $key => $item) {
            $total += $item['total_lucro'];
        }
        return $total;
    }
    public function removeItemCart($key)
    {
        unset($this->entrada['itens'][$key]);
    }
    private function isCart($produtoId)
    {
        foreach ($this->entrada['itens'] as $key => $item) {
            if ($item['produto_id'] == $produtoId) {
                return $key;
            }
        }
        return false;
    }
    private function totalCompras($precoCompra, $quantidade)
    {
        return $precoCompra * $quantidade;
    }
    private function totalVendas($precoVenda, $quantidade)
    {
        return $precoVenda * $quantidade;
    }
    private function totalLucro($totalVendas, $totalCompras)
    {

        return $totalVendas - $totalCompras;
    }
    // private function isCart($item)
    // {

    //     $this->entrada['itens'][] = [
    //         'produto_id' => 1
    //     ];
    //     $this->entrada['itens'][] = [
    //         'produto_id' => 2
    //     ];

    //     // dd($this->entrada);

    //     $cart = collect($this->entrada);
    //     $cart = $cart->firstWhere('produto_id', $item['produto_id']);
    //     return $cart;
    // }
    public function salvarEntrada()
    {
        dd($this->entrada);
    }
}
