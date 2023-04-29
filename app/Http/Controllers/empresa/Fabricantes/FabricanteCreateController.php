<?php

namespace App\Http\Controllers\empresa\Fabricantes;

use App\Repositories\Empresa\FabricanteRepository;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FabricanteCreateController extends Component
{

    use LivewireAlert;

    public $fabricante;
    public $statuId;
    private $fabricanteRepository;

    protected $listeners = ['selected' => 'selected'];



    public function __construct()
    {
        $this->setarValorPadrao();
    }
    public function selected($name, $value){
        $this->$name = $value;
        $this->fabricante['status_id'] = $value;
        $this->dispatchBrowserEvent('loadSelect2');
    }

    public function boot(FabricanteRepository $fabricanteRepository)
    {
        $this->fabricanteRepository = $fabricanteRepository;
    }

    public function render()
    {
        return view('empresa.fabricantes.create');
    }
    public function salvarFabricante()
    {
        $rules = [
            'fabricante.designacao' => ["required", function ($attr, $value, $fail) {

                $fabricante =  DB::table('fabricantes')
                    ->where('empresa_id', auth()->user()->empresa_id)
                    ->where('designacao', $value)
                    ->first();

                if ($fabricante) {
                    $fail("Fabricante já cadastrado");
                }
            }]
        ];
        $messages = [
            'fabricante.designacao.required' => 'Informe o nome do fabricante'
        ];

        $this->validate($rules, $messages);
        $this->fabricanteRepository->store($this->fabricante);
        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success',
            $this->setarValorPadrao()
        ]);
    }

    public function setarValorPadrao()
    {
        $this->fabricante['designacao'] = NULL;
        $this->fabricante['canal_id'] = 2;
        $this->fabricante['status_id'] = 1;
        $this->fabricante['tipo_user_id'] = 2;
    }
}
