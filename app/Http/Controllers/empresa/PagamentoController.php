<?php

namespace App\Http\Controllers\empresa;

use App\Models\empresa\Factura;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\empresa\Empresa_Cliente;
use App\Models\admin\Empresa;
use App\Models\empresa\FormaPagamentos;
use Illuminate\Support\Facades\DB;


class PagamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ListarFacturaPagamentos()
    {
        
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        
        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $data['facturas'] = Factura::with(['status','cliente'])->where('empresa_id', $empresa['empresa']['id'])->where('tipo_documento', 'FACTURA')->get();


        return view('empresa.facturas.facturasPagamentoindex', $data);
    }
    public function listarTipoFormaPagamentos(){

        if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
            return view('admin.dashboard');
        }
        $TipoFormaPagamento = DB::table('tipo_pagamento')->get();

        return response()->json($TipoFormaPagamento, 200);
        
    }
    public function listarFormasPagamentosGeral(){
        
        $data['formasPagamento'] = DB::connection('mysql2')->table('formas_pagamentos_geral')->get();
        return response()->json($data, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
