<?php

namespace App\Repositories\Empresa\contracts;


interface RelatorioRepositoryInterface
{
    public function print(string $filename, array $parameters = []);
}
