<?php

namespace App\Http\Controllers\empresa\ProdutoDestaques;

use App\Repositories\Empresa\ProdutoDestaqueRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProdutoDestaqueIndexController extends Component
{

    use LivewireAlert;

    public $cliente;
    public $search = null;
    private $produtoDestaqueRepository;



    public function boot(ProdutoDestaqueRepository $produtoDestaqueRepository)
    {
        $this->produtoDestaqueRepository = $produtoDestaqueRepository;
    }

    public function render()
    {
        $data['produtos'] = $this->produtoDestaqueRepository->getProdutos($this->search);
        return view('empresa.produtosDestaque.index',$data);
    }
}
