<?php

namespace App\Http\Controllers\Portal;

use App\Models\Portal\CarrinhoProduto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Sanctum;

class CarrinhoProdutoController extends Controller
{
    public function index()
    {
        return "PRODUTOS DE UM CLIENTE NO CARRINHO";
    }

    public function getCarrinhoProdutos()
    {
        // return "PRODUTOS DE UM CLIENTE NO CARRINHO";
        $clienteId = auth()->user()->id;
        return CarrinhoProduto::with('produto')->where('cliente_id',$clienteId)->get();
    }

    public function addProdutoNoCarrinho($id)
    {
        // return $id;
        // $produto_id = base64_decode(base64_decode(base64_decode($id)));
        $produto = CarrinhoProduto::query()->where('produto_id',$id)->first();
        // $user = Sanctum::user();
        // return $produto;
        if ($produto)
        {
            $produto->quantidade = $produto->quantidade+1;
            $produto->save();
            return response()->json("Mais uma Unidade adicionado ao carrinho com sucesso");
        }
        else
        {
            $produto = new CarrinhoProduto();
            $produto->cliente_id = 668;
            $produto->produto_id = $id;
            $produto->quantidade += 1 ;
            $produto->save();
            return response()->json("Produto adicionado ao carrinho com Sucesso!");
        }
    }

    public function encreaseCarrinhoQtyProduto($id)
    {
        $produto_id = base64_decode(base64_decode(base64_decode($id)));

        $produto = CarrinhoProduto::with('produto')->where('produto_id',$produto_id)->first();
        $produto->quantidade = $produto->quantidade+1;
        $produto->save();
        $produtosNoCarrinho = CarrinhoProduto::with('produto')->get();
        return response()->json($produtosNoCarrinho);
    }

    public function decreaseCarrinhoQtyProduto($id)
    {
        $produto_id = base64_decode(base64_decode(base64_decode($id)));
        $produto = CarrinhoProduto::with('produto')->where('produto_id',$produto_id)->first();

        if ($produto->quantidade!=1){
            $produto->quantidade = $produto->quantidade-1;
            $produto->save();
        }
        else
        {
            CarrinhoProduto::where('produto_id',$produto_id)->delete();
        }
        $produtosNoCarrinho = CarrinhoProduto::with('produto')->get();
        return response()->json($produtosNoCarrinho);
    }

    public function store(Request $request)
    {
        //
    }


    public function show(CarrinhoProduto $carrinhoProduto)
    {
        //
    }

    public function edit(CarrinhoProduto $carrinhoProduto)
    {
        //
    }

    public function update(Request $request, CarrinhoProduto $carrinhoProduto)
    {
        //
    }

    public function destroy(CarrinhoProduto $carrinhoProduto)
    {
        //
    }
}
