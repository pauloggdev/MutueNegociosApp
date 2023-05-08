<?php

namespace App\Http\Controllers\empresa\Categorias;

use App\Http\Requests\StoreUpdateCategoriaRequest;
use App\Repositories\Empresa\CategoriaRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class CategoriaUpdateController extends Component
{
    use StoreUpdateCategoriaRequest;
    use LivewireAlert;
    use WithFileUploads;

    public $categoria;
    public $search = null;
    private $categoriaRepository;
    protected $listeners = ['refresh' => '$refresh']; /*Note: activating the refresh*/



    public function boot(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function mount($categoriaId)
    {
        $categoria = $this->categoriaRepository->getCategoria($categoriaId)->toArray();
        $this->categoria['id'] = $categoria['id'];
        $this->categoria['designacao'] = $categoria['designacao'];
        $this->categoria['status_id'] = $categoria['status_id'];
        $this->categoria['imagem'] = $categoria['imagem'];
        $this->categoria['newImagem'] = NULL;

        // dd($this->categoria);
    }


    public function render()
    {
        $data['categorias'] = $this->categoriaRepository->getCategorias();
        return view('empresa.categorias.edit', $data);
    }
    public function CategoriaUpdate()
    {

        $rules = [

            'categoria.designacao' => 'required',
            'categoria.status_id' => '',
            'categoria.canal_id' => ''

        ];
        $messages = [
            'categoria.designacao.required' => 'Informe o nome da Categoria',
        ];

        $this->validate($rules, $messages);
        $this->categoriaRepository->update($this->categoria);
        $this->mount($this->categoria['id']);
        $this->alert('success', 'Operação realizada com sucesso');
    }


}
