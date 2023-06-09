<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\empresa\Produto;
use App\Models\Portal\CarrinhoProduto;
use App\Repositories\Empresa\CouponDescontoRepository;
use Illuminate\Http\Request;

class CarrinhoProdutoController extends Controller
{

    private $couponDescontoRepository;

    public function __construct(CouponDescontoRepository $couponDescontoRepository)
    {
        $this->couponDescontoRepository = $couponDescontoRepository;
    }

    public function getCarrinhoProdutos($message = null, Request $request)
    {
        $produtos = CarrinhoProduto::with(['produto', 'produto.tipoTaxa'])->select('produto_id', 'quantidade')->where('cliente_id', auth()->user()->id)->get();
        $array = [
            "subtotalGeral" => 0,
            "totalCouponDesconto" => 0,
            "totalIva" => 0,
            "totalPagar" => 0,
            "totalEnvio" => 0,
            "produtos" => []
        ];

        $subtotal = 0;
        $totalCouponDesconto = 0;
        $totalPagar = 0;
        $totalIva = 0;
        $totalEnvio = 0;
        $subtotalIva = 0;
        foreach ($produtos as $key => $prod) {

            $subtotal += $prod['quantidade'] * $prod['produto']['preco_venda'];
            $totalPagar += $prod['quantidade'] * $prod['produto']['preco_venda'];
            $totalEnvio = 0;

            array_push($array['produtos'], [
                'id' => $prod['produto']['id'],
                'uuid' => $prod['produto']['uuid'],
                'designacao' => $prod['produto']['designacao'],
                'quantidade' => $prod['quantidade'],
                'preco_venda' => $prod['produto']['preco_venda'],
                'imagem_produto' => $prod['produto']['imagem_produto'],
                'subtotal' => $prod['quantidade'] * $prod['produto']['preco_venda'],
                'subtotalIva' => $this->calcularTotalIva($prod)
            ]);

            $totalIva += $array['produtos'][$key]['subtotalIva'];
        }

        $codigoDesconto = null;
        if (isset($request['codigoDesconto']) && $request['codigoDesconto']) {
            $codigoDesconto = $request['codigoDesconto'];
        }
        if ($codigoDesconto) {
            $coupon = $this->couponDescontoRepository->getCoupon($codigoDesconto);
            $isExpired = $this->couponDescontoRepository->isExpired($codigoDesconto);
            if ($coupon && !$isExpired) {
                $totalCouponDesconto = ($subtotal *  $coupon['percentagem']) / 100;
            }
        }
        $totalPagar = $subtotal - $totalCouponDesconto + $totalIva + $totalEnvio;

        $array['subtotalGeral'] = $subtotal;
        $array['totalIva'] = $subtotal + $subtotalIva;
        $array['totalCouponDesconto'] = $totalCouponDesconto;
        $array['totalPagar'] = $totalPagar;
        $array['totalIva'] = $totalIva;
        $array['totalEnvio'] = $totalEnvio;

        return response()->json([
            'data' => $array,
            'message' => $message ?? 'listar carrinho de compras'
        ]);
    }
    public function calcularTotalIva($prod)
    {
        $taxa = $prod['produto']['tipoTaxa']['taxa'];
        $precoVenda = $prod['produto']['preco_venda'];
        $quantidade = $prod['quantidade'];

        return ($precoVenda * $taxa * $quantidade) / 100;
    }
    public function getProduto($uuid)
    {
        return Produto::where('uuid', $uuid)->first();
    }
    public function addProdutoNoCarrinho(Request $request)
    {
        $produto = $this->getProduto($request->uuid);
        if (!$produto) {
            return response()->json([
                'error' => "Produto não encontrado"
            ]);
        }
        $carrinho = CarrinhoProduto::with('produto')->where('produto_id', $produto->id)
            ->where('cliente_id', auth()->user()->id)
            ->first();

        if ($carrinho) {
            $carrinho->quantidade = $carrinho->quantidade + 1;
            $carrinho->save();
            $message = "Mais uma Unidade adicionado ao carrinho com sucesso";
        } else {
            $carrinho = new CarrinhoProduto();
            $carrinho->cliente_id = auth()->user()->id;
            $carrinho->produto_id = $produto->id;
            $carrinho->quantidade += 1;
            $carrinho->save();

            $carrinho = CarrinhoProduto::with('produto')->where('produto_id', $produto->id)
                ->where('cliente_id', auth()->user()->id)
                ->first();
            $message = "Produto adicionado ao carrinho com sucesso!";
        }
        return $this->getCarrinhoProdutos($message, $request);
    }
    public function getCarrinhoProduto(Request $request)
    {

        $produto = $this->getProduto($request->uuid);
        if (!$produto) {
            return response()->json([
                'error' => "Produto não encontrado"
            ]);
        }
        $carrinho = CarrinhoProduto::with('produto')->where('produto_id', $produto->id)
            ->where('cliente_id', auth()->user()->id)
            ->first();
        if (!$carrinho) {
            return response()->json([
                'data' => null,
                'message' => "Produto não encontrado no carrinho"
            ]);
        }
        return response()->json([
            'data' => $carrinho,
            'message' => 'Produto encontrado no carrinho'
        ]);
    }
    public function removerCarrinho(Request $request)
    {
        CarrinhoProduto::where('produto_id', $request->id)
            ->where('cliente_id', auth()->user()->id)
            ->delete();
        $message = "Produto removido com sucesso!";
        return $this->getCarrinhoProdutos($message, $request);
    }
    public function decreaseCarrinhoQtyProduto(Request $request)
    {
        $message = "";
        $produto = $this->getProduto($request->uuid);
        if (!$produto) {
            return response()->json([
                'error' => "Produto não encontrado"
            ]);
        }
        $carrinho = CarrinhoProduto::with('produto')->where('produto_id', $produto->id)
            ->where('cliente_id', auth()->user()->id)
            ->first();

        if (!$carrinho) {
            return response()->json([
                'data' => null,
                'message' => "Produto não encontrado no carrinho"
            ]);
        }

        if (isset($request['codigoDesconto']) && $request['codigoDesconto']) {
            $codigoDesconto = $request['codigoDesconto'];
        } else {
            $codigoDesconto = null;
        }

        if ($carrinho && ($carrinho->quantidade - 1 > 0)) {
            $carrinho->quantidade = $carrinho->quantidade - 1;
            $carrinho->save();
            $message = "Mais uma unidade reduzida com sucesso!";
        } else {
            CarrinhoProduto::where('id', $carrinho->id)->delete();
            $message = "Produto removido com sucesso!";
        }
        return $this->getCarrinhoProdutos($message, $request);
    }
    public function addCouponDesconto(Request $request)
    {
        $coupon = $this->couponDescontoRepository->getCoupon($request->codigoDesconto);
        if (!$coupon) {
            return response()->json([
                'data' => null,
                'message' => 'Coupon de desconto não existe'
            ]);
        }
        $couponExpirado = $this->couponDescontoRepository->isExpired($request->codigoDesconto);
        if ($couponExpirado) {
            return response()->json([
                'data' => null,
                'message' => 'Coupon de desconto expirado'
            ]);
        }

        $message = "cupon desconto aplicado";
        return $this->getCarrinhoProdutos($message, $request);

        // $totalDesconto = $this->couponDescontoRepository->calcularCoupon($request->totalSemDesconto, $coupon->percentagem);
        // $totalPagar = $request->totalSemDesconto - $totalDesconto;
        // return response()->json([
        //     'data' =>[
        //         'totalCouponDesconto' => $totalDesconto,
        //         'totalPagar'=> $totalPagar
        //     ],
        //     'message'=>'Operação realizada com sucesso!'
        // ], 200);
    }
    public function encreaseCarrinhoQtyProduto(Request $request)
    {
        $message = "";
        $produto = $this->getProduto($request->uuid);
        if (!$produto) {
            return response()->json([
                'error' => "Produto não encontrado"
            ]);
        }
        $carrinho = CarrinhoProduto::with('produto')->where('produto_id', $produto->id)
            ->where('cliente_id', auth()->user()->id)
            ->first();

        if (!$carrinho) {
            return response()->json([
                'data' => null,
                'message' => "Produto não encontrado no carrinho"
            ]);
        }

        if (isset($request['codigoDesconto']) && $request['codigoDesconto']) {
            $codigoDesconto = $request['codigoDesconto'];
        } else {
            $codigoDesconto = null;
        }

        if ($carrinho) {
            $carrinho->quantidade = $carrinho->quantidade + 1;
            $carrinho->save();
            $message = "Mais uma unidade reduzida com sucesso!";
        } else {
            CarrinhoProduto::where('id', $carrinho->id)->delete();
            $message = "Produto removido com sucesso!";
        }
        return $this->getCarrinhoProdutos($message, $request);
    }
}
