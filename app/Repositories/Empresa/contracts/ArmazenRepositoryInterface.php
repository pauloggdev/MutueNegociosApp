<?php

namespace App\Repositories\Empresa\contracts;

use Illuminate\Http\Request;

interface ArmazenRepositoryInterface
{
    public function getArmazens();
    public function getArmazen(int $id);
    public function store(Request $data);
    public function update(Request $data, int $armazenId);
}
