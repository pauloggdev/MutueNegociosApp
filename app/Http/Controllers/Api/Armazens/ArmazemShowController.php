<?php

namespace App\Http\Controllers\Api\Armazens;
use App\Repositories\Empresa\ArmazemRepository;
use App\Http\Controllers\Controller;

class ArmazemShowController extends Controller
{

    private $armazemRepository;

    public function __construct(ArmazemRepository $armazemRepository)
    {
        $this->armazemRepository = $armazemRepository;
    }

    public function listarArmazem($id){
        return $this->armazemRepository->getArmazen($id);
    }
}
