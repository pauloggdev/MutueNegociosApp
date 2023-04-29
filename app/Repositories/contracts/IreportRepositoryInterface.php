<?php

namespace App\Repositories\contracts;


interface IreportRepositoryInterface
{
    public function getDatabaseConfig();
    public function show(array $params);
}
