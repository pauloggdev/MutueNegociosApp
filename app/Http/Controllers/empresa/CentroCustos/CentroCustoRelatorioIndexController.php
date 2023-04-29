<?php

namespace App\Http\Controllers\empresa\CentroCustos;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\CentroCustoRepository;
use Livewire\Component;


class CentroCustoRelatorioIndexController extends Component
{


    private $centroCustoRepository;
    public $search = null;


    public function boot(CentroCustoRepository $centroCustoRepository)
    {
        $this->centroCustoRepository = $centroCustoRepository;
    }

    public function render()
    {
        $data['centrosCusto'] = $this->centroCustoRepository->listarCentrosCusto($this->search);
        return view("empresa.centroCustos.relatorioIndex", $data);
    }
    public function mostrarRelatorios($centroCusto){
       return redirect()->route('relatorio.index', $centroCusto['uuid']);
    }

}
