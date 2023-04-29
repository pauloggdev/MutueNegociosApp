<?php

namespace App\Repositories\Empresa\contracts;

use Illuminate\Http\Request;

interface FornecedorRepositoryInterface

{
    public function getFornecedores();
    public function getFornecedor(int $id);
    public function store(Request $data);
    public function update(Request $data, int $fornecedorId);
}
