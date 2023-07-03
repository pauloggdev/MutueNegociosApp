<?php

namespace App\Http\Controllers\empresa\Categorias;

use App\Http\Requests\StoreUpdateCategoriaRequest;
use App\Repositories\Empresa\CategoriaRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class CategoriaUpdateSubCategoriaController extends Component
{
    use StoreUpdateCategoriaRequest;
    use LivewireAlert;
    use WithFileUploads;

    public $categoria;
    public $search = null;
    public $subCategorias;
    private $categoriaRepository;
    protected $listeners = ['refresh' => '$refresh']; /*Note: activating the refresh*/



    public function boot(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function mount($categoriaId)
    {

        $categoria = $this->categoriaRepository->getCategoria($categoriaId)->toArray();
        $this->subCategorias = [
            [
                'designacao' => '',
                'imagem' => '',
            ]
        ];
        $this->categoria['designacao'] = $categoria['designacao'];
        $this->categoria['id'] = $categoria['id'];
    }
    public function addSubCategoria(){

        array_push($this->subCategorias,  [
            'designacao' => '',
            'imagem' => '',
        ]);
    }
    public function removerSubCategoria($key){

        if(count($this->subCategorias) <= 1){
            $this->confirm('Não é permitido remover todos', [
                'showConfirmButton' => false,
                'showCancelButton' => false,
                'icon' => 'warning'
            ]);
            return;
        }
        unset($this->subCategorias[$key]); // removes the element at index 2 (value 3)
    }


    public function render()
    {
        $data['categorias'] = $this->categoriaRepository->getCategorias();
        return view('empresa.categorias.addSub', $data);
    }
    public function CategoriaUpdate()
    {
        $rules = [
            'subCategorias.*.designacao' => 'required',
            'subCategorias.*.imagem' => 'required',
        ];
        $messages = [
            'subCategorias.*.designacao.required' => 'Informe o nome da categoria',
            'subCategorias.*.imagem.required' => 'Informe a imagem da categoria',
        ];

        $this->validate($rules, $messages);
        $this->categoriaRepository->addSubCategoria($this->categoria['id'], $this->subCategorias);
        $this->mount($this->categoria['id']);
        $this->alert('success', 'Operação realizada com sucesso');
    }
}
