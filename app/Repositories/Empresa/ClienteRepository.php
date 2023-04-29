<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\Cliente;
use App\Models\empresa\Factura;
use App\Models\empresa\NotaCredito;
use App\Models\empresa\NotaDebito;
use App\Models\empresa\Recibos;
use Hamcrest\Type\IsNumeric;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class ClienteRepository
{

    protected $cliente;
    protected $recibo;

    public function __construct(Cliente $cliente, Recibos $recibo)
    {
        $this->cliente = $cliente;
        $this->recibo = $recibo;
    }
    public function listarClienteSemConsumidorFinal()
    {
        $clientes = $this->cliente::with(['tipocliente', 'statuGeral', 'pais', 'empresa'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('diversos', '!=', 'Sim')
            ->get();
        return $clientes;
    }
    public function quantidadeClientes(){

        return $this->cliente::where('empresa_id', auth()->user()->empresa_id)->count();
    }

    public function listarClienteComFacturasApagar()
    {
        $clientes = $this->cliente::with(['tipocliente', 'statuGeral', 'pais', 'empresa'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('diversos', '!=', 'Sim')
            ->get();
        return $clientes;
    }
    public function mostrarValorFaltanteApagarNaFaturaDoCliente($factura)
    {
        $valorEntregue = $this->recibo::where('empresa_id', auth()->user()->empresa_id)
            ->where('factura_id', $factura->id)
            ->sum('valor_total_entregue');
        return number_format($valorEntregue, 2, ',', '.');
    }
    public function mostrarSaldoAtualDoCliente($clienteId)
    {
        $totalNotaCredito  = NotaCredito::where('cliente_id', $clienteId)->where('empresa_id', auth()->user()->empresa_id)->sum('valor_credito');
        $totalNotaDebito  = NotaDebito::where('cliente_id', $clienteId)->where('empresa_id', auth()->user()->empresa_id)->sum('valor_debito');
        $totalRecibos  = Recibos::where('cliente_id', $clienteId)->where('empresa_id', auth()->user()->empresa_id)->where('anulado', 1)->sum('valor_total_entregue');
        $totalFacturas  = Factura::where('cliente_id', $clienteId)->where('tipo_documento', 2)->where('anulado', 1)->where('empresa_id', auth()->user()->empresa_id)->sum('valor_a_pagar');
        $saldoCliente = (($totalNotaCredito + $totalRecibos) - ($totalNotaDebito + $totalFacturas));
        return number_format($saldoCliente, 2, ',', '.');
    }

    public function getClientes($search = NULL)
    {
        $clientes = $this->cliente::with(['tipocliente', 'statuGeral', 'pais', 'empresa'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->search(trim($search))
            ->paginate();
        return $clientes;
    }
    public function getClientesApi($search = NULL)
    {
        $clientes = $this->cliente::with(['tipocliente', 'statuGeral', 'pais', 'empresa'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->search(trim($search))->get();
        return $clientes;
    }
    public function getClientePeloNifStore($cliente)
    {
        $cliente = $this->cliente::where('empresa_id', auth()->user()->empresa_id)
            ->where('nif', $cliente['nif'])->where('nif', '!=', '999999999')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->first();
        return $cliente;
    }

    public function getClientePeloNif($cliente)
    {
        $cliente = $this->cliente::where('empresa_id', auth()->user()->empresa_id)
            ->where('nif', $cliente['nif'])->where('nif', '!=', '999999999')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('id', '!=', $cliente['id'])
            ->first();
        return $cliente;
    }

    public function getCliente($id)
    {
        $cliente = $this->cliente::with(['tipocliente', 'statuGeral', 'pais', 'empresa'])->where('empresa_id', auth()->user()->empresa_id)
            ->where('id', $id)
            ->first();
        return $cliente;
    }
    public function getClientePeloUuid($uuid)
    {
        $cliente = $this->cliente::with(['statuGeral'])->where('empresa_id', auth()->user()->empresa_id)
            ->where('uuid', $uuid)
            ->first();
        return $cliente;
    }
    public function store($data)
    {


        $cliente = $this->cliente::create([
            'uuid' => Str::uuid(),
            'nome' => $data['nome'],
            'pessoa_contacto' => $data['pessoa_contacto']??NULL,
            'email' => $data['email']??NULL,
            'website' => $data['website']??NULL,
            'numero_contrato' => $data['numero_contrato']??NULL,
            'data_contrato' => $data['data_contrato'] ?? NULL,
            'telefone_cliente' => $data['telefone_cliente'],
            'taxa_de_desconto' => is_numeric($data['taxa_de_desconto']) ? $data['taxa_de_desconto'] : 0,
            'limite_de_credito' => is_numeric($data['limite_de_credito']) ? $data['limite_de_credito'] : 0,
            'endereco' => $data['endereco'],
            'canal_id' => $data['canal_id'] ?? 2,
            'status_id' => $data['status_id'] ?? 1,
            'nif' => $data['nif'] ? $data['nif'] : "999999999",
            'operador' => auth()->user()->name,
            'tipo_cliente_id' => $data['tipo_cliente_id'],
            'user_id' => auth()->user()->id,
            'empresa_id' => auth()->user()->empresa_id,
            'pais_id' => $data['pais_id'] ?? 1,
            'cidade' => $data['cidade'] ?? 'Luanda',
            'tipo_conta_corrente' => $data['tipo_conta_corrente'],
            'conta_corrente' => $this->contaCorrente()
        ]);

        return $cliente;
    }

    private function contaCorrente()
    {
        $resultado =  DB::connection('mysql2')->table('clientes')->orderBy('id', 'DESC')
            ->where('empresa_id', auth()->user()->empresa_id)->limit(1)->first();

        if ($resultado) {
            $array = explode('.', $resultado->conta_corrente);
            $ultimoElemento = (int) end($array);
            array_pop($array);
            $ultimoElemento++;
            array_push($array, (string) $ultimoElemento);
            $contaCorrente = implode(".", $array);
        } else {
            $contaCorrente = "31.1.2.1.1";
        }

        return $contaCorrente;
    }
    public function update($data, $clienteId)
    {

        $cliente = $this->cliente::where('empresa_id', auth()->user()->empresa_id)
            ->where('id', $clienteId)
            ->update([
                'nome' => $data['nome'],
                'pessoa_contacto' => $data['pessoa_contacto'],
                'email' => $data['email'],
                'website' => $data['website'],
                'numero_contrato' => $data['numero_contrato'],
                'data_contrato' => $data['data_contrato'] ?? NULL,
                'telefone_cliente' => $data['telefone_cliente'],
                'taxa_de_desconto' => is_numeric($data['taxa_de_desconto']) ? $data['taxa_de_desconto'] : 0,
                'limite_de_credito' => is_numeric($data['limite_de_credito']) ? $data['limite_de_credito'] : 0,
                'endereco' => $data['endereco'],
                'status_id' => $data['status_id'],
                'nif' => $data['nif'] ? $data['nif'] : "999999999",
                'operador' => auth()->user()->name,
                'tipo_cliente_id' => $data['tipo_cliente_id'],
                'user_id' => auth()->user()->id,
                'empresa_id' => auth()->user()->empresa_id,
                'canal_id' => $data['canal_id'] ? $data['canal_id'] : 2,
                'pais_id' => $data['pais_id'],
                'cidade' => $data['cidade'],
            ]);

        return $cliente;
    }
}
