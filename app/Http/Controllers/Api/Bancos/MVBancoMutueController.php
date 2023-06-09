<?php

namespace App\Http\Controllers\Api\Bancos;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\BancoRepository;

class MVBancoMutueController extends Controller
{

    private $bancoRepository;

    public function __construct(BancoRepository $bancoRepository)
    {
        $this->bancoRepository = $bancoRepository;
    }

    public function listarBancos($search = null){
        return $this->bancoRepository->getBancos($search);
    }
}
