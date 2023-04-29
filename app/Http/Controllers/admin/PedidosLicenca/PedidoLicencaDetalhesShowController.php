<?php

namespace App\Http\Controllers\admin\PedidosLicenca;

use App\Http\Controllers\admin\Traits\TraitEmpresa;
use App\Http\Controllers\admin\Traits\TraitPathRelatorio;
use App\Repositories\Admin\contracts\PedidoLicencaRepositoryInterface;
use App\Repositories\Admin\PedidosLicencaRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Livewire\Component;


class PedidoLicencaDetalhesShowController extends Component
{

    use TraitEmpresa;
    use TraitPathRelatorio;

    public $pedidoId;


    private $pedidosLicencaRepository;

    public function mount($pedidoId)
    {
        $this->pedidoId = $pedidoId;
    }


    public function boot(PedidosLicencaRepository $pedidosLicencaRepository)
    {
        $this->pedidosLicencaRepository = $pedidosLicencaRepository;
    }

    public function render()
    {
        $pedido = $this->pedidosLicencaRepository->getPedidosLicenca($this->pedidoId);
        return view('admin.pedidosLicenca.detalhes', compact('pedido'))->layout('layouts.appAdmin');
    }


    public function ativarPedidoLicenca(Request $request, $pedidoLicencaId)
    {
        dd('fdfd');
    }
}
