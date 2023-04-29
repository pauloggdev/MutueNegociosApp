<?php

namespace App\Http\Controllers\empresa\Armazens;

use App\Repositories\Empresa\ArmazemRepository;
use App\Repositories\Empresa\FabricanteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ArmazemCreateController extends Component
{

    use LivewireAlert;

    public $armazem;
    public $statuId;
    private $armazemRepository;

    protected $listeners = ['selected' => 'selected'];

    public function selected($name, $value){
        $this->$name = $value;
        $this->armazem['status_id'] = $value;
        $this->dispatchBrowserEvent('loadSelect2');
    }

    public function __construct()
    {
        $this->setarValorPadrao();
    }

    public function boot(ArmazemRepository $armazemRepository)
    {
        $this->armazemRepository = $armazemRepository;
    }

    public function render()
    {
        return view('empresa.armazens.create');
    }
    public function salvarArmazem(Request $request)
    {

        $rules = [
            'armazem.designacao' => [
                "required", function ($attr, $value, $fail) {
                    $armazem =  DB::table('armazens')
                        ->where('empresa_id', auth()->user()->empresa_id)
                        ->where('designacao', $value)
                        ->first();

                    if ($armazem) {
                        $fail("Armazem já cadastrado");
                    }
                }
            ],
            'armazem.localizacao' => "required"
        ];
        $messages = [
            'armazem.localizacao.required' => 'Informe o endereço',
            'armazem.designacao.required' => 'Informe o nome do armazém',
        ];

        $this->validate($rules, $messages);
        $this->armazemRepository->store($this->armazem);
        $this->setarValorPadrao();
        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
    }

    public function setarValorPadrao()
    {
        $this->armazem['designacao'] = NULL;
        $this->armazem['sigla'] = NULL;
        $this->armazem['localizacao'] = NULL;
        $this->armazem['codigo'] = NULL;
        $this->armazem['status_id'] = 1;
    }
}
