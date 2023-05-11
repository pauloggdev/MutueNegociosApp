<?php

namespace App\Http\Controllers\Portal;

use App\Models\Portal\CarrinhoProduto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\empresa\Produto;

// use Illuminate\Support\Facades\Sanctum;

class CarrinhoProdutoControllerCopia extends Controller
{
    public function index()
    {
        return "PRODUTOS DE UM CLIENTE NO CARRINHO";
    }

    public function getCarrinhoProdutos()
    {
        return CarrinhoProduto::with('produto')->where('cliente_id', auth()->user()->id)->get();
    }

    public function getProduto($uuid)
    {
        return Produto::where('uuid', $uuid)->first();
    }

    public function addProdutoNoCarrinho(Request $request)
    {
        $produto = $this->getProduto($request->uuid);
        $produto = CarrinhoProduto::query()->where('produto_id', $produto->id)->first();
        if ($produto) {
            $produto->quantidade = $produto->quantidade + 1;
            $produto->save();
            return response()->json([
                'data' => $produto,
                'message' => "Mais uma Unidade adicionado ao carrinho com sucesso"
            ]);
        } else {
            $produto = new CarrinhoProduto();
            $produto->cliente_id = auth()->user()->id;
            $produto->produto_id = $produto->id;
            $produto->quantidade += 1;
            $produto->save();
            return response()->json([
                'data' => $produto,
                'message' => "Produto adicionado ao carrinho com sucesso!"
            ]);
        }
    }

    // public function encreaseCarrinhoQtyProduto($id)
    // {
    //     $produto_id = base64_decode(base64_decode(base64_decode($id)));

    //     $produto = CarrinhoProduto::with('produto')->where('produto_id', $produto_id)->first();
    //     $produto->quantidade = $produto->quantidade + 1;
    //     $produto->save();
    //     $produtosNoCarrinho = CarrinhoProduto::with('produto')->get();
    //     return response()->json($produtosNoCarrinho);
    // }

    public function decreaseCarrinhoQtyProduto(Request $request)
    {
        $produto = $this->getProduto($request->uuid);
        $produto = CarrinhoProduto::with('produto')->where('produto_id', $produto->id)->first();
        if ($produto && $produto->quantidade > 0) {
            $produto->quantidade = $produto->quantidade - 1;
            $produto->save();
        } else {
            CarrinhoProduto::where('produto_id', $produto->id)->delete();
        }
        $produtosNoCarrinho = CarrinhoProduto::with('produto')->get();
        return response()->json($produtosNoCarrinho);
    }
}
