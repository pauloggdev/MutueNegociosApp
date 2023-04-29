<?php

namespace App\Http\Controllers\Api\Bancos;
use App\Http\Controllers\Controller;
use App\Repositories\Empresa\BancoRepository;
use App\Repositories\Empresa\FabricanteRepository;

class BancoIndexController extends Controller
{

    private $bancoRepository;

    public function __construct(BancoRepository $bancoRepository)
    {
        $this->bancoRepository = $bancoRepository;
    }
    public function quantidadeBancos(){
        return $this->bancoRepository->quantidadeBancos();
    }

    public function listarBancos($search = null){
        return $this->bancoRepository->getBancos($search);
    }
}
