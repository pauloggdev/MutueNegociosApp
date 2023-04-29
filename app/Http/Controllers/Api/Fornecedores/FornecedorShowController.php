<?php

namespace App\Http\Controllers\Api\Fornecedores;
use App\Repositories\Empresa\FornecedorRepository;
use App\Http\Controllers\Controller;

class FornecedorShowController extends Controller
{

    private $fornecedorRepository;

    public function __construct(FornecedorRepository $fornecedorRepository)
    {
        $this->fornecedorRepository = $fornecedorRepository;
    }

    public function listarFornecedor($id){
        return $this->fornecedorRepository->getFornecedor($id);
    }
}
