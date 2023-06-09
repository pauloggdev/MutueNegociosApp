<?php

namespace App\Http\Controllers\empresa\ProdutoDestaques;
use App\Repositories\Empresa\ProdutoDestaqueRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProdutoDestaqueCreateController extends Component
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
        return view('empresa.produtosDestaque.create');
    }
}
