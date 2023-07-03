<?php

namespace App\Http\Controllers\empresa\ProdutoDestaques;
use App\Repositories\Empresa\ProdutoDestaqueRepository;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProdutoDestaqueCreateController extends Component
{

    use LivewireAlert;


    public $destaque;
    public $produtos;
    public $search = null;
    private $produtoDestaqueRepository;

    public function __construct()
    {
        $this->setarValorPadrao();

    }



    public function boot(ProdutoDestaqueRepository $produtoDestaqueRepository)
    {
        $this->produtoDestaqueRepository = $produtoDestaqueRepository;
    }

    public function render()
    {
        $this->produtos = $this->produtoDestaqueRepository->listarProdutoVendasOnline();
        return view('empresa.produtosDestaque.create');
    }
    public function salvarProdutoDestaque(){

        $rules = [
            'destaque.produtoId' => 'required',
            'destaque.designacao' => 'required',
            'destaque.descricao' => 'required',

        ];
        $messages = [
            'destaque.produtoId.required' => 'Informe o produto',
            'destaque.designacao.required' => 'Informe a designação',
            'destaque.descricao.required' => 'Informe a descrição',
        ];

        $this->validate($rules, $messages);
        $this->produtoDestaqueRepository->adicionarProdutoDestaque($this->destaque);
        $this->confirm('Operação realizada com sucesso', ['showConfirmButton' => false, 'showCancelButton' => false, 'icon' => 'success']);
        $this->setarValorPadrao();
        $this->render();

    }
    public function setarValorPadrao(){
        $this->destaque['produtoId'] = null;
        $this->destaque['designacao'] = null;
        $this->destaque['descricao'] = null;
    }
}
