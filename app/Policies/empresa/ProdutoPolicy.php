<?php

namespace App\empresa\Policies;

use App\Models\admin\User;
use App\Models\empresa\Produto;
use App\Models\empresa\User as EmpresaUser;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProdutoPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }
    public function updateProduto(EmpresaUser $user, Produto $produto){

    }
}
