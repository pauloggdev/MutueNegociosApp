<?php

namespace App\Http\Controllers\Api\Armazens;
use App\Repositories\Empresa\ArmazemRepository;
use App\Http\Controllers\Controller;

class ArmazemIndexController extends Controller
{

    private $armazemRepository;

    public function __construct(ArmazemRepository $armazemRepository)
    {
        $this->armazemRepository = $armazemRepository;
    }
    public function quantidadeArmazens()
    {
        return $this->armazemRepository->quantidadeArmazens();
    }

    public function listarArmazens($search = null){
        return $this->armazemRepository->getArmazens($search);
    }
}
