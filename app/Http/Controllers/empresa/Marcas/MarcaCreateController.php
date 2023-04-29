<?php

namespace App\Http\Controllers\empresa\Marcas;

use App\Models\empresa\Pais;
use App\Models\empresa\TiposCliente;
use App\Repositories\Empresa\FornecedorRepository;
use App\Repositories\Empresa\MarcaRepository;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MarcaCreateController extends Component
{
    use LivewireAlert;
    public $marca;
    private $marcaRepository;

    public function __construct()
    {
        $this->setarValorPadrao();
    }

    public function boot(MarcaRepository $marcaRepository)
    {
        $this->marcaRepository = $marcaRepository;
    }
    
    public function render()
    {   
          
         $data['marcas']= $this->marcaRepository->getMarcas();
        
        return view('empresa.marcas.create',$data);
       
    } 
    
    public function salvarMarca()
    {
  
        $rules = [
          
            'marca.designacao' => 'required',
            
        ];
        $messages = [
            'marca.designacao.required' => 'Informe o nome da marca',
           
        ];

        $this->validate($rules, $messages);
        $this->marcaRepository->store($this->marca);
        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
        $this->setarValorPadrao();
    }

    public function setarValorPadrao()
    {
        $this->marca['designacao'] = NULL;
        $this->marca['status_id'] = 1;
        $this->marca['user_id'] = 2;
        $this->marca['canal_id'] = 2;
      
        
    }



    
}
