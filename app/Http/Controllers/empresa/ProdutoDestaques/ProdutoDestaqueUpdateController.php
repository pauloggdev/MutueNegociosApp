<?php

namespace App\Http\Controllers\empresa\ProdutoDestaques;

use App\Http\Requests\UpdateProdutoDestaqueRequest;
use App\Repositories\Empresa\ProdutoDestaqueRepository;
use Illuminate\Http\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProdutoDestaqueUpdateController extends Component
{

    use LivewireAlert;
    use UpdateProdutoDestaqueRequest;

    private $produtoDestaqueRepository;
    public $produtos;
    public $destaque;
    public $uuid;

    public function mount($uuid)
    {
        $this->uuid = $uuid;
        $this->produtos = $this->produtoDestaqueRepository->listarProdutoDestaqueAtualizar();
        $destaque = $this->produtoDestaqueRepository->getDestaque($uuid);
        $this->destaque['produtoId'] = $destaque['produto_id'];
        $this->destaque['uuid'] = $uuid;
        $this->destaque['designacao'] = $destaque['designacao'];
        $this->destaque['descricao'] = $destaque['descricao'];
    }



    public function boot(ProdutoDestaqueRepository $produtoDestaqueRepository)
    {
        $this->produtoDestaqueRepository = $produtoDestaqueRepository;
    }

    public function render()
    {
        return view('empresa.produtosDestaque.update');
    }
    public function atualizarProdutoDestaque(){

        $this->validate($this->rules(), $this->messages());
        $this->produtoDestaqueRepository->atualizarProdutoDestaque($this->destaque);
        $this->confirm('Operação realizada com sucesso', ['showConfirmButton' => false, 'showCancelButton' => false, 'icon' => 'success']);
    }
}
