<?php

namespace App\Http\Controllers\empresa\Bancos;

use App\Repositories\Empresa\BancoRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BancoCreateController extends Component
{

    use LivewireAlert;

    public $banco;
    private $bancoRepository;


    public function __construct()
    {
        $this->setarValorPadrao();
    }

    public function boot(BancoRepository $bancoRepository)
    {
        $this->bancoRepository = $bancoRepository;
    }

    public function render()
    {
        return view('empresa.bancos.create');
    }
    public function salvarBanco()
    {
        $rules = [
            'banco.designacao' => [
                "required", function ($attr, $value, $fail) {
                    $banco =  DB::table('bancos')
                        ->where('empresa_id', auth()->user()->empresa_id)
                        ->where('designacao', "like", $value)
                        ->first();

                    if ($banco) {
                        $fail("Banco já cadastrado");
                    }
                }
            ],
            'banco.sigla' => "required",
            'banco.num_conta' => "required",
            'banco.iban' => "required",
            'banco.status_id' => "required",
        ];
        $messages = [
            'banco.designacao.required' => 'Informe o nome do banco',
            'banco.sigla.required' => 'Informe a sigla',
            'banco.num_conta.required' => 'Informe o número da conta',
            'banco.iban.required' => 'Informe o iban',
            'banco.status_id.required' => 'Informe o status',
        ];

        $this->validate($rules, $messages);
        $this->bancoRepository->store($this->banco);
        $this->setarValorPadrao();
        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
    }

    public function setarValorPadrao()
    {
        $this->banco['designacao'] = NULL;
        $this->banco['sigla'] = NULL;
        $this->banco['num_conta'] = NULL;
        $this->banco['iban'] = NULL;
        $this->banco['canal_id'] = 2;
        $this->banco['status_id'] = 1;
        $this->banco['tipo_user_id'] = 2;
    }
}
