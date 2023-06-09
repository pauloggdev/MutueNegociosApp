<?php

namespace App\Http\Controllers\empresa\CuponDesconto;

use App\Repositories\Empresa\CuponRepository;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Keygen\Keygen;
use Livewire\Component;

class CuponDescontoCreateController extends Component
{

    use LivewireAlert;

    public $cupon;
    public $search = null;
    private $cuponRepository;


    public function boot(CuponRepository $cuponRepository)
    {
        $this->cuponRepository = $cuponRepository;
        $this->setarValorPadrao();
    }

    public function render()

    {
        // $data['clientes'] = $this->clienteRepository->getClientes($this->search);

        return view('empresa.cupons.create');
    }
    public function gerarCodigoCupon()
    {
        $lastCoupon = $this->cuponRepository->lastCoupon();
        $lastIdCoupon = $lastCoupon ? ++$lastCoupon->id : 1;
        return mb_strtoupper(Keygen::alphanum(5)->generate()) . date("Y") . '/' . $lastIdCoupon;
    }
    public function gerarCuponDesconto()
    {
        $rules = [
            'cupon.codigo' => 'required',
            'cupon.percentagem' => ["required", function($attr, $desconto, $fail){
                if($desconto <=0){
                    $fail('Informe a percentagem');
                }
            }],
            'cupon.data_expiracao' => 'required'
        ];
        $messages = [
            'cupon.codigo.required' => 'Informe o código',
            'cupon.percentagem.required' => 'Informe a percentagem',
            'cupon.data_expiracao.required' => 'Informe a data de expiração',

        ];
        $this->validate($rules, $messages);
        $this->cuponRepository->gerarCuponDesconto($this->cupon);
        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
        $this->setarValorPadrao();
    }
    public function setarValorPadrao()
    {
        $this->cupon['codigo'] = $this->gerarCodigoCupon();
        $this->cupon['percentagem'] =  0;
        $this->cupon['data_expiracao'] =  null;
        $this->cupon['used'] =  'N';
    }
}
