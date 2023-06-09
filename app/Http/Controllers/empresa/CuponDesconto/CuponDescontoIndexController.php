<?php

namespace App\Http\Controllers\empresa\CuponDesconto;

use App\Http\Controllers\empresa\ReportShowController;
use App\Models\empresa\Pais;
use App\Models\empresa\TiposCliente;
use App\Repositories\Empresa\ClienteRepository;
use App\Repositories\Empresa\CuponRepository;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CuponDescontoIndexController extends Component
{

    use LivewireAlert;

    public $cliente;
    public $search = null;
    private $cuponRepository;



    public function boot(CuponRepository $cuponRepository)
    {
        $this->cuponRepository = $cuponRepository;
    }

    public function render()

    {
        $data['cupons'] = $this->cuponRepository->getCupons($this->search);
        return view('empresa.cupons.index',$data);
    }
}
