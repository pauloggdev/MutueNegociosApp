<?php
namespace App\Infra\Repository;
use App\Models\Portal\CarrinhoProduto as CarrinhoCompraDatabase;

class CarrinhoRepository
{
    public function getCarrinhos()
    {
        return CarrinhoCompraDatabase::with(['produto', 'produto.tipoTaxa','user', 'user.cliente'])
            ->where('users_id',auth()->user()->id??668)->get();
    }

}
