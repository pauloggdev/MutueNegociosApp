<?php

namespace App\Http\Controllers\Api\Facturas;
use App\Http\Controllers\Controller;
use App\Repositories\Empresa\FacturaRepository;

class FacturaIndexController extends Controller
{

    private $facturaRepository;

    public function __construct(FacturaRepository $facturaRepository)
    {
        $this->facturaRepository = $facturaRepository;
    }

    public function quantidadesVendas(){
        return $this->facturaRepository->quantidadesVendas();
    }
    public function totalVendas(){
        return $this->facturaRepository->totalVendas();
    }
    public function listarGraficoVendasMensal(){
        return $this->facturaRepository->listarGraficoVendasMensal();
    }


}
