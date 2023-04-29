<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Empresa\contracts\ArmazenRepositoryInterface;
use App\Repositories\Empresa\contracts\ClienteRepositoryInterface;
use App\Repositories\Empresa\contracts\FabricanteRepositoryInterface;
use App\Repositories\Empresa\contracts\FornecedorRepositoryInterface;
use App\Repositories\Empresa\contracts\RelatorioRepositoryInterface;
use App\Traits\Empresa\TraitEmpresa;
use App\Traits\Empresa\TraitPathRelatorio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class ArmazenController extends Controller
{
    use TraitEmpresa;
    use TraitPathRelatorio;

    private $ArmazenRepository;


    public function __construct()
    {
        $this->ArmazenRepository= App::make(ArmazenRepositoryInterface::class);
        
    }

    public function getArmazens()
    {
        return $this->ArmazenRepository->getArmazens();
    }
    public function getArmazen(int $armazenId)
    {
        return $this->ArmazenRepository->getArmazen($armazenId);
    }
    public function imprimirfabricante()
    {

        $pathLogoCompany = $this->getPathCompany();
        $pathRelatorio = $this->getPathRelatorio();

        $data =  $this->relatorioRepository->print('armazens', [
            'dirSubreportEmpresa' => $pathRelatorio,
            'diretorio' => $pathLogoCompany
        ]);
        return $data;
    }

    public function store(Request $request,$armazen)
    {
        return $this->ArmazenRepository->store($request, $armazen);       
    }

    public function update (Request $request, int $armazen){

        return $this->ArmazenRepository->update($request,$armazen);
    }
}
