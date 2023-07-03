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
    public $uuid;
    private $produtoDestaqueRepository;
    protected $listeners = ['deletarProdutoDestaque'];




    public function boot(ProdutoDestaqueRepository $produtoDestaqueRepository)
    {
        $this->produtoDestaqueRepository = $produtoDestaqueRepository;
    }
    public function render()
    {
        $data['destaques'] = $this->produtoDestaqueRepository->getProdutos($this->search);
        return view('empresa.produtosDestaque.index',$data);
    }
    public function modalDel($uuid)
    {
        $this->uuid = $uuid;
        $this->confirm('Deseja apagar o item', [
            'onConfirmed' => 'deletarProdutoDestaque',
            'cancelButtonText' => 'Não',
            'confirmButtonText' => 'Sim',
        ]);
    }
    public function deletarProdutoDestaque($data)
    {

        if ($data['value']) {
            try {
                $this->produtoDestaqueRepository->deletarProdutoDestaque($this->uuid);
                $this->confirm('Operação realizada com sucesso', [
                    'showConfirmButton' => false,
                    'showCancelButton' => false,
                    'icon' => 'success'
                ]);
            } catch (\Throwable $th) {
                $this->alert('warning', 'Não permitido eliminar, altera o status como desativo');
            }
        }
    }


}
