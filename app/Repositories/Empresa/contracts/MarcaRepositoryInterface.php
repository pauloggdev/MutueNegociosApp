<?php

namespace App\Repositories\Empresa\contracts;

use Illuminate\Http\Request;

interface MarcaRepositoryInterface
{
    public function getMarcas();
    public function getMarca(int $id);
    public function store(Request $data);
    public function update(Request $data, int $marcaId);
}
