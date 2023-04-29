<?php

namespace App\Repositories\Empresa\contracts;

use Illuminate\Http\Request;

interface FabricanteRepositoryInterface
{
    public function getFabricantes();
    public function getFabricante(int $id);
    public function store(Request $data);
    public function update(Request $data, int $armazenId);
}
