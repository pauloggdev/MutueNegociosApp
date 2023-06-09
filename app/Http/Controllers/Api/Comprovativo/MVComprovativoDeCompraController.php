<?php

namespace App\Http\Controllers\Api\Comprovativo;
use App\Http\Controllers\Controller;
use App\Repositories\Admin\BancoRepository;
use Illuminate\Http\Request;

class MVComprovativoDeCompraController extends Controller
{

    private $bancoRepository;

    public function __construct(BancoRepository $bancoRepository)
    {
        $this->bancoRepository = $bancoRepository;
    }

    public function enviarComprovativoDeCompra(Request $request){
        dd($request->all());
    }

}
