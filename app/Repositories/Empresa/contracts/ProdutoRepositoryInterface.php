<?php

namespace App\Repositories\Empresa\contracts;

use Illuminate\Http\Request;

interface ProdutoRepositoryInterface
{
    public function getProdutos();
    public function getProduto(int $id);
    public function store(Request $data);
    public function update(Request $data, int $produtoId);
    public function listarProdutosPeloIdArmazem($armazemId);
}
