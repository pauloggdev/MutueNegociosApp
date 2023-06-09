<?php

namespace App\Http\Controllers\empresa\Categorias;
use App\Repositories\Empresa\CategoriaRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class CategoriaCreateController extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $categoria;
    private $categoriaRepository;

    public function __construct()
    {
        $this->setarValorPadrao();
    }

    public function boot(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function render()
    {
        $data['categorias']= $this->categoriaRepository->getCategorias();
        return view('empresa.categorias.create', $data);
    }

    public function salvarCategoria()
    {
        $rules = [
            'categoria.designacao' => 'required',
            'categoria.status_id' => 'required',
        ];
        $messages = [
            'categoria.designacao.required' => 'Informe a designacao',
            'categoria.status_id.required' => 'Informe o status',
        ];

        $this->validate($rules, $messages);
        $this->categoriaRepository->store($this->categoria);
        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
        $this->setarValorPadrao();
    }

    public function setarValorPadrao()
    {
        $this->categoria['designacao'] = NULL;
        $this->categoria['sub_categoria_id'] = NULL;
        $this->categoria['imagem'] = NULL;
        $this->categoria['status_id'] = 1;
        $this->categoria['user_id'] = 2;
        $this->categoria['canal_id'] = 2;


    }




}
