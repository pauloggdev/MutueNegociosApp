<?php

namespace App\Http\Controllers\empresa\EntradaProduto;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\ArmazemRepository;
use App\Repositories\Empresa\EntradaProdutoRepository;
use App\Repositories\Empresa\FormaPagamentoRepository;
use App\Repositories\Empresa\FornecedorRepository;
use App\Repositories\Empresa\ProdutoRepository;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use PhpParser\Node\Expr\Cast\Double;

class EntradaProdutoCreateController extends Component
{
    use LivewireAlert;


    private $fornecedorRepository;
    private $armazemRepository;
    private $formaPagamentoRepository;
    private $produtoRepository;
    private $entradaProdutoRepository;

    public $formaPagamentos;
    public $fornecedores;
    public $armazens;
    public $produtos;
    public $precoVenda = 0;
    protected $listeners = ['refresh' => '$refresh']; /*Note: activating the refresh*/
    public $search = NULL;

    public $entrada = [
        'num_factura_fornecedor' => '',
        'data_factura_fornecedor' => '',
        'fornecedor_id' => '',
        'forma_pagamento_id' => '',
        'descricao' => '',
        'total_compras' => 0,
        'total_retencao' => 0,
        'totalLucro' => 0,
        'total_iva' => 0,
        'total_venda' => 0,
        'totalSemImposto' => 0,
        'total_desconto' => 0,
        'preco_compra' => 0,
        'armazem_id' => '',
        'created_at' => '',
        'produto_id' => '',
        'descontoPerc' => 0,
        'quantidade' => 1,
        'items' => []
    ];
    public $keyCart = 0;

    public function boot(
        FornecedorRepository $fornecedorRepository,
        ArmazemRepository $armazemRepository,
        FormaPagamentoRepository $formaPagamentoRepository,
        ProdutoRepository $produtoRepository,
        EntradaProdutoRepository $entradaProdutoRepository
    ) {
        $this->fornecedorRepository = $fornecedorRepository;
        $this->armazemRepository = $armazemRepository;
        $this->formaPagamentoRepository = $formaPagamentoRepository;
        $this->produtoRepository = $produtoRepository;
        $this->entradaProdutoRepository = $entradaProdutoRepository;
    }
    public function setarValoresInicial()
    {
        return  [
            'num_factura_fornecedor' => 'FT AGT2023/1',
            'data_factura_fornecedor' => '',
            'fornecedor_id' => '',
            'forma_pagamento_id' => '',
            'descricao' => '',
            'total_compras' => 0,
            'total_retencao' => 0,
            'totalLucro' => 0,
            'total_iva' => 0,
            'total_venda' => 0,
            'totalSemImposto' => 0,
            'total_desconto' => 0,
            'preco_compra' => 0,
            'armazem_id' => '',
            'created_at' => '',
            'produto_id' => '',
            'descontoPerc' => 0,
            'quantidade' => 1,
            'items' => []
        ];
    }
    public function mount()
    {
        $this->fornecedores = $this->fornecedorRepository->getFornecedoresSemPaginacao();
        $this->formaPagamentos  = $this->formaPagamentoRepository->listarFormaPagamentosSemPagamentoDuplo();
        $this->armazens = $this->armazemRepository->getArmazensSemPaginacao();
        $this->entrada['fornecedor_id'] = $this->fornecedores[0]['id'];
        $this->entrada['armazem_id'] = $this->armazens[0]['id'];
        $this->entrada['created_at'] = date("Y-m-d");
        $this->entrada['forma_pagamento_id'] = $this->formaPagamentos[0]['id'];
        $armazemId = $this->armazens[0]['id'];
        $this->produtos  = $this->produtoRepository->getProdutosSemPaginacao($armazemId);
    }
    public function updatedEntradaArmazemId($armazemId)
    {
        $this->produtos  = $this->produtoRepository->getProdutosSemPaginacao($armazemId);
    }

    public function render()
    {
        return view('empresa.EntradaProdutos.create');
    }

    public function addCarrinho()
    {

        $rules = [
            'entrada.num_factura_fornecedor' => 'required',
            'entrada.data_factura_fornecedor' => 'required',
            'entrada.created_at' => 'required',
            'entrada.produto_id' => 'required',
            'entrada.preco_compra' => ['required', function ($attr, $precoCompra, $fail) {
                if ($precoCompra < 0) {
                    $fail("Preço está negativo");
                }
            }],
            'entrada.descontoPerc' => ['required', function ($attr, $descontoPerc, $fail) {
                if ($descontoPerc < 0) {
                    $fail("O desconto está negativo");
                }
            }],
            'entrada.quantidade' => ['required', function ($attr, $quantidade, $fail) {
                if ($quantidade <= 0) {
                    $fail("Informe a quantidade");
                }
            }],
        ];
        $messages = [
            'entrada.num_factura_fornecedor.required' => 'Informe nº da factura',
            'entrada.data_factura_fornecedor.required' => 'Informe a data factura',
            'entrada.created_at.required' => 'Informe a data de entrada',
            'entrada.produto_id.required' => 'Informe o produto',
            'entrada.preco_compra.required' => 'Informe o preço de compra',
            'entrada.descontoPerc.required' => 'Informe o desconto',
            'entrada.quantidade.required' => 'Informe o desconto'
        ];

        $this->validate($rules, $messages);
        $this->addCart($this->entrada);
    }
    public function getProduto($produtoId)
    {
        return collect($this->produtos)->firstWhere('id', $produtoId);
    }
    public function calcularDesconto($entrada)
    {
        return ($entrada['preco_compra'] * $entrada['quantidade'] * $entrada['descontoPerc']) / 100;
    }
    public function calcularPrecoCompra($entrada)
    {
        return $entrada['preco_compra'] * $entrada['quantidade']  - $this->calcularDesconto($entrada);
    }
    public function calcularPrecoVenda($precoVenda, $entrada)
    {
        return $precoVenda * $entrada['quantidade'];
    }
    public function calcularLucroUnitario($precoVenda, $entrada)
    {
        return $this->calcularPrecoVenda($precoVenda, $entrada) - $this->calcularPrecoCompra($entrada);
    }
    public function updatedEntradaProdutoId($produtoId)
    {
        $produto = $this->getProduto($produtoId);
        $this->precoVenda = number_format($produto['preco_venda'], 2, ',', '.');
    }
    public function addCart($entrada)
    {
        $produto = $this->getProduto($entrada['produto_id']);
        $precoVenda = $produto['preco_venda'];
        $produtoId = $entrada['produto_id'];

        $isCart = $this->isCart($produtoId);
        if ($isCart) {
            $this->confirm('Item já adicionado', ['showConfirmButton' => false, 'showCancelButton' => false, 'icon' => 'warning']);
            return;
        } else {
            $this->entrada['items'][] = [
                'produtoDesignacao' => $produto['designacao'],
                'produto_id' => $produtoId,
                'preco' => $produto['preco_venda'],
                'preco_compra_unitario' => $entrada['preco_compra'],
                'preco_venda_unitario' => $precoVenda,
                'preco_compra' => $this->calcularPrecoCompra($entrada),
                'preco_venda' => $this->calcularPrecoVenda($precoVenda, $entrada),
                'descontoPerc' => $entrada['descontoPerc'],
                'descontoValor' => $this->calcularDesconto($entrada),
                'quantidade' => $entrada['quantidade'],
                'lucroUnitario' => $this->calcularLucroUnitario($precoVenda, $entrada)
            ];
        }
        $this->calcularTotal($this->entrada['items']);
    }
    public function calcularTotal($entradaItems)
    {
        $this->entrada['total_compras'] = 0;
        $this->entrada['total_venda'] = 0;
        $this->entrada['total_desconto'] = 0;
        $this->entrada['totalSemImposto'] = 0;
        $this->entrada['totalLucro'] = 0;

        foreach ($entradaItems as $entrada) {
            $this->entrada['total_compras'] += $entrada['preco_compra'];
            $this->entrada['total_venda'] += $entrada['preco_venda'];
            $this->entrada['totalLucro'] += $entrada['lucroUnitario'];
            $this->entrada['totalSemImposto'] += $entrada['preco_compra_unitario'] * $entrada['quantidade'];
        }
    }
    public function isCart($produtoId)
    {
        $cart = collect($this->entrada['items']);
        $cart = $cart->firstWhere('produto_id', $produtoId);
        return $cart;
    }

    public function delItemCar($key)
    {
        unset($this->entrada['items'][$key]);
    }

    public function cadastrarEntradaProduto()
    {

        $valorCorrespondenteTotalCompra = $this->calcularValorCorrespondePrecoCompra();

        if ($valorCorrespondenteTotalCompra !== (float)$this->entrada['total_compras']) {
            $this->confirm('Os valores informados não correspondem com o Total da Compra', ['showConfirmButton' => false, 'showCancelButton' => false, 'icon' => 'warning']);
            return;
        }
        $entradaProdutoId = $this->entradaProdutoRepository->store($this->entrada);
        if ($entradaProdutoId) {
            $this->confirm('Operação realizada com sucesso', ['showConfirmButton' => false, 'showCancelButton' => false, 'icon' => 'success']);
            $this->precoVenda = 0;
            $this->entrada = $this->setarValoresInicial();
            $this->printEntrada($entradaProdutoId);
            return;
        }
    }
    public function calcularValorCorrespondePrecoCompra()
    {
        $totalSemImposto = (float) $this->entrada['totalSemImposto'] ?? 0;
        $total_desconto = (float) $this->entrada['total_desconto'] ?? 0;
        $total_retencao = (float) $this->entrada['total_retencao'] ?? 0;
        $total_iva = (float) $this->entrada['total_iva'] ?? 0;
        return $totalSemImposto - $total_desconto - $total_retencao + $total_iva;
    }
    public function printEntrada($entradaId){


        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $filename = "entradaProdutos";
        $reportController = new ReportShowController();
        $report = $reportController->show([
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'diretorio' => $logotipo,
                    'entradaId' => $entradaId
                ]
        ]
        );
        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();

    }
}
