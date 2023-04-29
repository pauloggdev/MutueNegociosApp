<?php

namespace App\Http\Controllers\Api\Fabricantes;
use App\Http\Controllers\Controller;
use App\Repositories\Empresa\FabricanteRepository;

class FabricanteIndexController extends Controller
{

    private $fabricanteRepository;

    public function __construct(FabricanteRepository $fabricanteRepository)
    {
        $this->fabricanteRepository = $fabricanteRepository;
    }
    public function quantidadeFabricantes(){
        return $this->fabricanteRepository->quantidadeFabricantes();
    }

    public function listarFabricantes($search = null){
        return $this->fabricanteRepository->getFabricantes($search);
    }
}
