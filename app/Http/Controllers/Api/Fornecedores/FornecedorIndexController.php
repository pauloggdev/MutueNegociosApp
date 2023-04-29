<?php

namespace App\Http\Controllers\Api\Fornecedores;
use App\Http\Controllers\Controller;
use App\Repositories\Empresa\FornecedorRepository;

class FornecedorIndexController extends Controller
{

    private $fornecedorRepository;

    public function __construct(FornecedorRepository $fornecedorRepository)
    {
        $this->fornecedorRepository = $fornecedorRepository;
    }

    public function quantidadeFornecedores()
    {
        return $this->fornecedorRepository->quantidadeFornecedores();
    }

    public function listarFornecedores($search = null){
        return $this->fornecedorRepository->getFornecedores($search);
    }
}
