<?php

namespace App\Repositories\Admin;
use App\Models\admin\CoordenadaBancaria;

class CoordernadaBancariaRepository
{

    protected $entity;

    public function __construct(CoordenadaBancaria $entity)
    {
        $this->entity = $entity;
    }

    public function listarCoordenadaBancarias()
    {
        return $this->entity::get();
    }
}
