<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\Produto;
use App\Models\empresa\ProdutoDestaque;
use Illuminate\Support\Str;

class ProdutoDestaqueRepository
{

    protected $produtoDestaque;
    protected $produto;

    public function __construct(ProdutoDestaque $produtoDestaque, Produto $produto)
    {
        $this->produtoDestaque = $produtoDestaque;
        $this->produto = $produto;
    }
    public function listarProdutoDestaqueAtualizar(){
        $produtos = $this->produto::where('venda_online', 'Y')
            ->where('empresa_id', auth()->user()->empresa_id)->get();
        return $produtos;
    }
    public function listarProdutoVendasOnline()
    {

        $produtoDestaqueIds = $this->produtoDestaque::pluck('produto_id')->toArray();
        $produtos = $this->produto::where('venda_online', 'Y')
            ->whereNotIn('id', $produtoDestaqueIds)
            ->where('empresa_id', auth()->user()->empresa_id)->get();
        return $produtos;
    }
    public function getProdutos($search)
    {
        $produtos = $this->produtoDestaque::with(['produto'])
            ->search(trim($search))
            ->paginate();
        return $produtos;
    }
    public function getDestaque($uuid){

        $destaque = $this->produtoDestaque::where('uuid', $uuid)->with(['produto'])->first();
        return $destaque;

    }
    public function adicionarProdutoDestaque($destaque)
    {

        return $this->produtoDestaque::create([
            'uuid' => (string) Str::uuid(),
            'produto_id' => $destaque['produtoId'],
            'designacao' => $destaque['designacao'],
            'descricao' => $destaque['descricao'],
            'empresa_id' => auth()->user()->empresa_id
        ]);
    }
    public function atualizarProdutoDestaque($destaque){

        return $this->produtoDestaque::where('uuid', $destaque['uuid'])->update([
            'designacao' => $destaque['designacao'],
            'descricao' => $destaque['descricao'],
        ]);
    }
    public function deletarProdutoDestaque($uuid){
        return $this->produtoDestaque::where('uuid', $uuid)->delete();
    }
}
