<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarrinhoResource;
use App\Models\empresa\Produto;
use App\Models\Portal\CarrinhoProduto;
use Illuminate\Http\Request;

class CarrinhoProdutoController extends Controller
{

    public function getCarrinhoProdutos()
    {
        $carrinhos = CarrinhoProduto::with('produto')->where('cliente_id', auth()->user()->id)->get();
        $carrinhos = CarrinhoResource::collection($carrinhos);

        $total = $carrinhos->sum('subtotal');
        return  $carrinhos;
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

        if ($carrinho && ($carrinho->quantidade - 1 > 0)) {
            $carrinho->quantidade = $carrinho->quantidade - 1;
            $carrinho->save();
            $message = "Mais uma unidade reduzida com sucesso!";
        } else {
            CarrinhoProduto::where('id', $carrinho->id)->delete();
            $message = "Produto removido com sucesso!";
        }
        $produtosNoCarrinho = CarrinhoProduto::with('produto')->get();
        return response()->json([
            'data' => $produtosNoCarrinho,
            'message' => $message
        ]);
    }
}
