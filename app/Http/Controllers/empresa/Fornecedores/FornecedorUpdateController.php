<?php

namespace App\Http\Controllers\empresa\Fornecedores;

use App\Http\Requests\StoreUpdateClienteRequest;
use App\Http\Requests\StoreUpdateFornecedorRequest;
use App\Models\empresa\Pais;
use App\Models\empresa\TiposCliente;
use App\Repositories\Empresa\ClienteRepository;
use App\Repositories\Empresa\FornecedorRepository;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class FornecedorUpdateController extends Component
{
    use LivewireAlert;
    use StoreUpdateFornecedorRequest;

    public $fornecedor;
    private $fornecedorRepository;

    public function boot(FornecedorRepository $fornecedorRepository)
    {
        $this->fornecedorRepository = $fornecedorRepository;
        $this->setarValorPadrao();
    }

    public function mount($fornecedorId)
    {

        $fornecedor = $this->fornecedorRepository->getFornecedor($fornecedorId);
        $this->setarFornecedor($fornecedor);



    }
    public function setarFornecedor($fornecedor){


        $newDate = date("Y-m-d", strtotime($fornecedor['created_at']));

        $this->fornecedor['id'] = $fornecedor['id'];
        $this->fornecedor['nome'] = $fornecedor['nome'];
        $this->fornecedor['telefone_empresa'] = $fornecedor['telefone_empresa'];
        $this->fornecedor['email_empresa'] = $fornecedor['email_empresa'];
        $this->fornecedor['nif'] = $fornecedor['nif'];
        $this->fornecedor['website'] = $fornecedor['website'];
        $this->fornecedor['pessoal_contacto'] = $fornecedor['pessoal_contacto'];
        $this->fornecedor['endereco'] = $fornecedor['endereco'];
        $this->fornecedor['telefone_contacto'] = $fornecedor['telefone_contacto'];
        $this->fornecedor['email_contacto'] = $fornecedor['email_contacto'];
        $this->fornecedor['conta_corrente'] = $fornecedor['conta_corrente'];
        $this->fornecedor['status_id'] = $fornecedor['status_id'];
        $this->fornecedor['data_contracto'] = $newDate;
        $this->fornecedor['pais_nacionalidade_id'] = $fornecedor['pais_nacionalidade_id'];

    }


    public function render()
    {

        $data['paises'] = Pais::all();

        return view('empresa.fornecedores.edit', $data);
    }
    public function Fornecedorupdate()
    {

        $this->validate($this->rules(), $this->messages());
        $this->fornecedorRepository->update($this->fornecedor);
        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
    }

    public function setarValorPadrao()
    {

    }
}
