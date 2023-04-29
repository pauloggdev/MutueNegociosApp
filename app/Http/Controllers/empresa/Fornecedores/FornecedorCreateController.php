<?php

namespace App\Http\Controllers\empresa\Fornecedores;

use App\Models\empresa\Fornecedor;
use App\Models\empresa\Pais;
use App\Models\empresa\TiposCliente;
use App\Repositories\Empresa\FornecedorRepository;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class FornecedorCreateController extends Component
{

    use LivewireAlert;
    public $fornecedor;
    public $nacionalidadeId = 1;
    private $fornecedorRepository;
    public function __construct()
    {
        $this->setarValorPadrao();
    }


    public function boot(FornecedorRepository $fornecedorRepository)
    {

        $this->fornecedorRepository = $fornecedorRepository;

    }
    public function render()
    {
        $data['paises'] = Pais::all();
        return view('empresa.fornecedores.create',$data);

    }


    public function salvarFornecedor()
    {

        $rules = [
            'fornecedor.nome' => 'required',
            'fornecedor.endereco' => 'required',
            'fornecedor.data_contracto' => 'required',
            'fornecedor.telefone_empresa'=> 'required',
            'fornecedor.nif'=> 'required'
        ];
        $messages = [
            'fornecedor.nome.required' => 'Informe o nome do fornecedor',
            'fornecedor.telefone_empresa.required' => 'Informe o telefone da empresa',
            'fornecedor.endereco.required' => 'Informe o endereço',
            'fornecedor.nif.required' => 'Informe o NIF',
            'fornecedor.data_contracto.required' => 'Informe a data de contrato',
        ];

        $this->validate($rules, $messages);
        $this->fornecedorRepository->store($this->fornecedor);
        $this->confirm('Operação realizada com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'
        ]);
         $this->setarValorPadrao();
    }

    public function setarValorPadrao()
    {
        $this->fornecedor['nome'] = NULL;
        $this->fornecedor['email_contacto'] = NULL;
        $this->fornecedor['email_empresa'] = NULL;
        $this->fornecedor['telefone_contacto'] = NULL;
        $this->fornecedor['telefone_empresa'] = NULL;
        $this->fornecedor['website'] = NULL;
        $this->fornecedor['endereco'] = NULL;
        $this->fornecedor['cidade'] = NULL;
        $this->fornecedor['pais_nacionalidade_id'] = 1;
        $this->fornecedor['nif'] = NULL;
        $this->fornecedor['pessoal_contacto'] = NULL;
        $this->fornecedor['status_id'] = 1;
        $this->fornecedor['tipo_user_id'] = 2;
        $this->fornecedor['canal_id'] = 2;
        $this->fornecedor['tipo_conta_corrente'] = 'Nacional';
        $this->fornecedor['data_contracto'] = Carbon::now()->format('Y-m-d');
    }
}



