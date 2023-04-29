<?php

namespace App\Http\Controllers\empresa;
use App\Models\admin\Empresa;
use App\Models\empresa\Empresa_Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VerificaClienteDocumento
{
    private $clienteId;

    public function __construct($clienteId)
    {
        $this->clienteId = $clienteId;
    }

    public function pegarIdEmpresaAuth()
    {

        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresaId = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresaId = Auth::user()->empresa_id;
        }

        return $empresaId;
    }

    public function verificaClienteEfectuoFactura($attribute)
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }


        $empresaId = $this->pegarIdEmpresaAuth();
        //Clientes com Facturas,facturas recibos, proforma 
        $clientes =  DB::connection('mysql2')->table('facturas')
        ->where('empresa_id', $empresaId)
        //->where('nif_cliente', $this->pegarDadosCliente()->nif)
        // ->where('nif_cliente','!=', '999999999')
        ->where('cliente_id', $this->clienteId)->get();
        
    
        if (count($clientes) > 0) {
            return true;
        }
        return false;
    }
    public function verificarClienteEfectuoRecibo($attribute)
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }
        $empresaId = $this->pegarIdEmpresaAuth();

        $recibos =  DB::connection('mysql2')->table('recibos')
        ->where('empresa_id', $empresaId)
        ->where('cliente_id', $this->clienteId)
        //->where('nif_cliente', $this->pegarDadosCliente()->nif)
        // ->where('nif_cliente','!=', '999999999')
        ->get();

        if (count($recibos) > 0) {
            return true;
        }
        return false;
    }

    public function verificaClienteEfectuoNotaCredito($attribute)
    {

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }
        $empresaId = $this->pegarIdEmpresaAuth();


        $notaCredito = DB::connection('mysql2')->table('notas_credito')
        ->where('empresa_id', $empresaId)
        ->where('cliente_id', $this->clienteId)
        //->where('nif_cliente', $this->pegarDadosCliente()->nif)
        // ->where('nif_cliente','!=', '999999999')
        ->get();

        if (count($notaCredito) > 0) {
            return true;
        }
        return false;
    }

    public function pegarDadosCliente(){

        if (Auth::guard('web')->check()) {
            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }
        $empresaId = $this->pegarIdEmpresaAuth();


        $cliente = DB::connection('mysql2')->table('clientes')->where('empresa_id', $empresaId)->where('id', $this->clienteId)->first();
        return $cliente;

    }

    public function temDocumento($attribute)
    {

        if ($this->verificaClienteEfectuoFactura($attribute) || $this->verificarClienteEfectuoRecibo($attribute) || $this->verificaClienteEfectuoNotaCredito($attribute)) {
            return true;
        }
        return false;
    }
}
