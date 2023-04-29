<?php

namespace App\Repositories\Empresa\contracts;

use Illuminate\Http\Request;

interface CategoriaRepositoryInterface
{
    public function getCategorias();
    public function getCategoria(int $id);
    public function store(Request $data);
    public function update(Request $data, int $categoriaId);
}
