<?php

namespace App\Http\Controllers\Api\Bancos;
use App\Http\Controllers\Controller;
use App\Repositories\Empresa\BancoRepository;

class BancoShowController extends Controller
{

    private $bancoRepository;

    public function __construct(BancoRepository $bancoRepository)
    {
        $this->bancoRepository = $bancoRepository;
    }

    public function listarBanco($id){
        return $this->bancoRepository->getBanco($id);
    }
}
