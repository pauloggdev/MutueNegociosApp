<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\empresa\Produto;
use App\Models\Portal\CarrinhoProduto;
use Illuminate\Http\Request;

class CarrinhoProdutoController extends Controller
{

    public function getCarrinhoProdutos($message = null)
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
        $array['subtotalGeral'] = $subtotal;
        $array['totalIva'] = $subtotal + $subtotalIva;
        $array['totalCouponDesconto'] = $totalCouponDesconto;
        $array['totalPagar'] = $subtotal - $totalCouponDesconto + $totalIva + $totalEnvio;
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
            return response()->json([
                'data' => $carrinho,
                'message' => "Mais uma Unidade adicionado ao carrinho com sucesso"
            ]);
        } else {
            $carrinho = new CarrinhoProduto();
            $carrinho->cliente_id = auth()->user()->id;
            $carrinho->produto_id = $produto->id;
            $carrinho->quantidade += 1;
            $carrinho->save();

            $carrinho = CarrinhoProduto::with('produto')->where('produto_id', $produto->id)
                ->where('cliente_id', auth()->user()->id)
                ->first();

            return response()->json([
                'data' => $carrinho,
                'message' => "Produto adicionado ao carrinho com sucesso!"
            ]);
        }
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
    public function removerCarrinho($id)
    {
        CarrinhoProduto::where('id', $id)->delete();
        $produtosNoCarrinho = CarrinhoProduto::with('produto')->get();
        return response()->json([
            'data' => $produtosNoCarrinho,
            'message' => "Produto removido com sucesso!"
        ]);
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


        if ($carrinho && ($carrinho->quantidade - 1 > 0)) {
            $carrinho->quantidade = $carrinho->quantidade - 1;
            $carrinho->save();
            $message = "Mais uma unidade reduzida com sucesso!";
        } else {
            CarrinhoProduto::where('id', $carrinho->id)->delete();
            $message = "Produto removido com sucesso!";
        }
        $produtosNoCarrinho = CarrinhoProduto::with('produto')
            ->where('cliente_id', auth()->user()->id)
            ->where('produto_id', $produto->id)
            ->first();
        return response()->json([
            'data' => $produtosNoCarrinho,
            'message' => $message
        ]);
    }
}
