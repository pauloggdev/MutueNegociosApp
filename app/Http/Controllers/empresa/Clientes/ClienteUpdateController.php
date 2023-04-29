<?php

namespace App\Http\Controllers\empresa\Clientes;

use App\Http\Requests\StoreUpdateClienteRequest;
use App\Models\empresa\Pais;
use App\Models\empresa\TiposCliente;
use App\Repositories\Empresa\ClienteRepository;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ClienteUpdateController extends Component
{

    use LivewireAlert;
    use StoreUpdateClienteRequest;

    public $cliente;
    private $clienteRepository;

    public function boot(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
        $this->setarValorPadrao();
    }

    public function mount($clienteId)
    {
        $this->cliente = $this->clienteRepository->getCliente($clienteId);
    }


    public function render()
    {
        $data['paises'] = Pais::all();
        $data['tiposClientes'] = TiposCliente::all();
        return view('empresa.clientes.edit', $data);
    }
    public function updateCliente()
    {



        $this->validate($this->rules(), $this->messages());
        $this->clienteRepository->update($this->cliente, $this->cliente->id);
        $this->alert('success', 'Operação realizada com sucesso');
    }

    public function setarValorPadrao()
    {
        $this->cliente['nome'] = NULL;
        $this->cliente['email'] = NULL;
        $this->cliente['telefone_cliente'] = NULL;
        $this->cliente['website'] = NULL;
        $this->cliente['endereco'] = NULL;
        $this->cliente['cidade'] = NULL;
        $this->cliente['pais_id'] = 1;
        $this->cliente['nif'] = NULL;
        $this->cliente['tipo_cliente_id'] = "";
        $this->cliente['pessoa_contacto'] = NULL;
        $this->cliente['numero_contrato'] = NULL;
        $this->cliente['taxa_de_desconto'] = 0;
        $this->cliente['limite_de_credito'] = 0;
        $this->cliente['status_id'] = 1;
        $this->cliente['canal_id'] = 2;
        $this->cliente['tipo_conta_corrente'] = 'Nacional';
        $this->cliente['data_contrato'] = Carbon::now()->format('Y-m-d');
    }
}
