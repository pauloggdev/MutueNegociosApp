<?php

namespace App\Http\Controllers\empresa\UnidadeMedidas;
use App\Repositories\Empresa\UnidadeMedidaRepository;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class UnidadeMedidaCreateController extends Component
{

    use LivewireAlert;

    public $unidade;
    private $unidadeMedidaRepository;


    public function __construct()
    {
        $this->setarValorPadrao();
    }

    public function boot(UnidadeMedidaRepository $unidadeMedidaRepository)
    {
        $this->unidadeMedidaRepository = $unidadeMedidaRepository;
    }

    public function render()
    {
        return view('empresa.unidadeMedidas.create');
    }
    public function salvarUnidadeMedidas()
    {
        $rules = [
            'unidade.designacao' => [
                "required", function ($attr, $value, $fail) {
                    $banco =  DB::table('unidade_medidas')
                        ->where('empresa_id', auth()->user()->empresa_id)
                        ->where('designacao', "like", $value)
                        ->first();

                    if ($banco) {
                        $fail("Unidade medidas já cadastrado");
                    }
                }
            ],
            'unidade.status_id' => "required",
        ];
        $messages = [
            'unidade.designacao.required' => 'Informe a unidade',
            'banco.status_id.required' => 'Informe o status',
        ];


        
        $this->validate($rules, $messages);
        $this->unidadeMedidaRepository->store($this->unidade);
        $this->setarValorPadrao();
        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
    }

    public function setarValorPadrao()
    {
        $this->unidade['designacao'] = NULL;
        $this->unidade['canal_id'] = 2;
        $this->unidade['status_id'] = 1;
        $this->unidade['diversos'] = 2;
    }
}
