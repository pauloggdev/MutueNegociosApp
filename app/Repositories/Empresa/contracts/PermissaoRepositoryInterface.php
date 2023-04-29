<?php

namespace App\Repositories\Empresa\contracts;

use Illuminate\Http\Request;

interface PermissaoRepositoryInterface
{
    public function getPermissaoes();
    public function getPermissao(int $id);
    public function store(Request $data);
    public function update(Request $data, int $permissaoId);
}
