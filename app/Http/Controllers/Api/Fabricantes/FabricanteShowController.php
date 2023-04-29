<?php

namespace App\Http\Controllers\Api\Fabricantes;
use App\Http\Controllers\Controller;
use App\Repositories\Empresa\FabricanteRepository;

class FabricanteShowController extends Controller
{

    private $fabricanteRepository;

    public function __construct(FabricanteRepository $fabricanteRepository)
    {
        $this->fabricanteRepository = $fabricanteRepository;
    }

    public function listarFabricante($id){
        return $this->fabricanteRepository->getFabricante($id);
    }
}
