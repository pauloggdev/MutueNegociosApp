<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\admin\Empresa;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\Factura;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use Illuminate\Support\Facades\DB;

class FechoCaixaController extends Controller
{
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        $data['guard'] = $empresa['guard'];



        $valorCash = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->whereDate('created_at', '=', '2021-02-10')
            ->where('tipo_documento', 1)->where('anulado', 1)->where('user_id', 178)->sum('valor_a_pagar');

        //factura proforma
        $facturaProforma = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->whereDate('created_at', '=', '2021-02-10')
            ->where('tipo_documento', 3)->where('anulado', 1)->where('user_id', 178)
            ->groupBy('created_at')->sum('valor_a_pagar');

        $facturaAnulado = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->whereDate('created_at', '=', '2021-02-10')
            ->where('anulado', 2)->where('user_id', 178)
            ->groupBy('created_at')->sum('valor_a_pagar');

        // $valorCash = Factura::where('empresa_id', $empresa_id)
        // ->whereDate('created_at', '=', '2021-02-10')
        // ->where('tipo_documento', 1)->where('user_id', 178)
        // ->groupBy('created_at')->sum('valor_a_pagar');


        DB::select('
        SELECT (SELECT SUM(F_C.valor_a_pagar) FROM facturas F_C WHERE F_C.anulado = 1 AND F_C.user_id = 178) AS valor_pagar
        FROM
            facturas F_P WHERE F_P.user_id = 178
        GROUP BY
        DATE (created_at) order by DATE (created_at) DESC
        ');


        // $facturas = DB::select('(SELECT SUM(valor_a_pagar) from facturas) FROM facturas WHERE empresa_id = "' . $empresa_id . '"
        //     AND (facturas.tipo_documento = 1
        //     OR facturas.tipo_documento = 2)
        //     GROUP BY DATE (created_at) order by DATE (created_at) DESC');




        //$facturas = Factura::select('SUM(valor_a_pagar)')->where('empresa_id', $empresa_id)->get();

        //dd($facturas);

        return view("empresa.fechoCaixa.fechoCaixaIndex", $data);
        //
    }

    public function imprimirFechoCaixa(Request $request)
    {

        $TIPO_A4 = 1;
        $TIPO_TICKET = 3;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $dataFecho = date("Y-m-d H:i", strtotime($request->get('dataFecho')));
        $dataFechoFim = date("Y-m-d H:i", strtotime($request->get('dataFechoFim')));
        $tipoDoc = $request->get('tipoDoc');


        $facturas = DB::connection('mysql2')->table('facturas')
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            //->whereDate('created_at', '=', $dataFecho)
            ->where('user_id', '=', $empresa['guard']['id'])
            ->where('empresa_id', $empresa['empresa']['id'])->get();

        if (!$facturas) {
            return response()->json(['isValid' => false, 'errors' => 'Não existe documento referente esta data'], 401);
        }
        $user_id = Auth::user()->id;
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        if ($tipoDoc == $TIPO_TICKET) {
            $filename = "FechoCaixaNovo"; //filename
        } else if ($tipoDoc == $TIPO_A4) {
            $filename = "FechoCaixaNovo"; //filename
        }

        //valor cash
        $valorDinheiro = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('tipo_documento', 1)
            ->where('formas_pagamento_id', 1) //pgt numerario
            ->where('anulado', 1)->where('user_id', $user_id)
            ->sum('valor_a_pagar');

        $valorTransferencia = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('formas_pagamento_id', 4) //pgt transferencia
            ->where('user_id', $user_id)
            ->sum('valor_a_pagar');

        $valorMulticaixa = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('formas_pagamento_id', 3) //pgt multicaixa
            ->where('user_id', $user_id)
            ->sum('valor_a_pagar');

        $TotalDeposito = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('formas_pagamento_id', 5) //pgt deposito
            ->where('user_id', $user_id)
            ->sum('valor_a_pagar');


        $totalFacturaCredito = DB::table('facturas')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('user_id', $user_id)
            ->where('tipo_documento', 2) //Factura crédito
            ->where('anulado', 1) //Não anulado
            ->count();

        //factura proforma
        $totalProforma = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('tipo_documento', 3)
            ->where('formas_pagamento_id', null) // proforma
            ->where('anulado', 1)->where('user_id', $user_id)->count();

        $facturaAnulado = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('anulado', 2)->where('user_id', $user_id)->count();

        $troco = DB::table('facturas')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('user_id', $user_id)
            ->where('tipo_documento', 1)
            ->where('anulado', 1) //Não anulado
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where(function ($query) {
                $query->where('formas_pagamento_id', 1) //Pagamento Numerario
                    ->orwhere('formas_pagamento_id', 5) //Pagamento deposito
                    ->orwhere('formas_pagamento_id', 4) //Pagamento transferencia
                    ->orwhere('formas_pagamento_id', 3); //Pagamento multicaixa
            })->sum('troco');

        $FATURA_RECIBO = DB::table('facturas')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('user_id', $user_id)
            ->where('anulado', 1) //Não anulado
            ->where('tipo_documento', 1) //Factura recibo
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->count();

        $RECIBO = DB::table('recibos')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('user_id', $user_id)
            ->where('anulado', 1) //Não anulado
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->count();


        $totalDocumento = $totalFacturaCredito + $totalProforma + $FATURA_RECIBO + $RECIBO;

        $valorFacturado  = $valorDinheiro + $valorTransferencia + $valorMulticaixa + $TotalDeposito;


        // $valorTotalFacturado = Factura::where('empresa_id', $empresa['empresa']['id'])
        //     ->whereDate('created_at', '>=', $dataFecho)
        //     ->whereDate('created_at', '<=', $dataFechoFim)
        //     ->where('tipo_documento', 1)
        //     ->where('anulado', 1)
        //     ->where('user_id', $user_id)
        //     ->where(function ($query) {
        //         $query->where('formas_pagamento_id', 1) //pgt numerario
        //             ->orwhere('formas_pagamento_id', 4) //pgt tranferencia
        //             ->orwhere('formas_pagamento_id', 5) //pgt deposito
        //             ->orwhere('formas_pagamento_id', 3); //pgt multicaixa
        //     })->sum('valor_a_pagar');



        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'valorDinheiro' => $valorDinheiro,
                    'valorTransferencia' => $valorTransferencia,
                    'valorMulticaixa' => $valorMulticaixa,
                    'TotalDeposito' => $TotalDeposito,
                    'subtotal' => $valorFacturado,
                    'totalFacturaCredito' => $totalFacturaCredito,
                    'totalProforma' => $totalProforma,
                    'FATURA_RECIBO' => $FATURA_RECIBO,
                    'RECIBO' => $RECIBO,
                    'logotipo' => $caminho,
                    'valorFacturado' => $valorFacturado,
                    'troco' => $troco,
                    'totalFactura' => $totalDocumento,
                    'operador' => $empresa['guard']['name'],
                    'user_id' => $user_id,
                    'data_inicio' => $dataFecho,
                    'data_fim' => $dataFechoFim,
                    'nomeEmpresa' => $empresa['empresa']['nome'],
                    'enderecoEmpresa' => $empresa['empresa']['endereco'],
                    'telefoneEmpresa' => $empresa['empresa']['pessoa_de_contacto'],
                    'nifEmpresa' => $empresa['empresa']['nif'],
                    'logotipo' => $caminho
                ]

            ]
        );
    }
    public function imprimirFechoCaixaVenda(Request $request)
    {

        $dataFecho = str_replace("T", " ", $request->dataInicial) . ":00";
        $dataFechoFim = str_replace("T", " ", $request->dataFinal) . ":59";

        $user_id = $request->user_id ? $request->user_id : auth()->user()->id;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa['empresa']['id']]);

        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;





        //valor cash
        $valorDinheiro = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->where('tipo_documento', 1)
            ->where('formas_pagamento_id', 1) //pgt numerario
            ->where('anulado', 1)->where('user_id', $user_id)
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->sum('valor_a_pagar');




        $valorTransferencia = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('formas_pagamento_id', 4) //pgt transferencia
            ->where('user_id', $user_id)
            ->sum('valor_a_pagar');




        $valorMulticaixa = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('formas_pagamento_id', 3) //pgt multicaixa
            ->where('user_id', $user_id)
            ->sum('valor_a_pagar');





        $TotalDeposito = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('formas_pagamento_id', 5) //pgt deposito
            ->where('user_id', $user_id)
            ->sum('valor_a_pagar');

        $totalFacturaCredito = DB::table('facturas')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('user_id', $user_id)
            ->where('tipo_documento', 2) //Factura crédito
            ->where('anulado', 1) //Não anulado
            ->count();




        //factura proforma
        $totalProforma = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('tipo_documento', 3)
            ->where('formas_pagamento_id', null) // proforma
            ->where('anulado', 1)->where('user_id', $user_id)->count();

        $facturaAnulado = Factura::where('empresa_id', $empresa['empresa']['id'])
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('anulado', 2)->where('user_id', $user_id)->count();





        $troco = DB::table('facturas')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('user_id', $user_id)
            ->where('tipo_documento', 1)
            ->where('anulado', 1) //Não anulado
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where(function ($query) {
                $query->where('formas_pagamento_id', 1) //Pagamento Numerario
                    ->orwhere('formas_pagamento_id', 5) //Pagamento deposito
                    ->orwhere('formas_pagamento_id', 4) //Pagamento transferencia
                    ->orwhere('formas_pagamento_id', 3); //Pagamento multicaixa
            })->sum('troco');

        $FATURA_RECIBO = DB::table('facturas')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('user_id', $user_id)
            ->where('anulado', 1) //Não anulado
            ->where('tipo_documento', 1) //Factura recibo
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->count();


        $RECIBO = DB::table('recibos')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('user_id', $user_id)
            ->where('anulado', 1) //Não anulado
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->count();

        $totalDocumento = $totalFacturaCredito + $totalProforma + $FATURA_RECIBO + $RECIBO;

        $valorFacturado  = $valorDinheiro + $valorTransferencia + $valorMulticaixa + $TotalDeposito;


        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'FechoCaixaNovo',
                'report_jrxml' => 'FechoCaixaNovo.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'valorDinheiro' => $valorDinheiro,
                    'valorTransferencia' => $valorTransferencia,
                    'valorMulticaixa' => $valorMulticaixa,
                    'TotalDeposito' => $TotalDeposito,
                    'subtotal' => $valorFacturado,
                    'totalFacturaCredito' => $totalFacturaCredito,
                    'totalProforma' => $totalProforma,
                    'FATURA_RECIBO' => $FATURA_RECIBO,
                    'RECIBO' => $RECIBO,
                    'logotipo' => $caminho,
                    'valorFacturado' => $valorFacturado,
                    'troco' => $troco,
                    'totalFactura' => $totalDocumento,
                    'operador' => $empresa['guard']['name'],
                    'user_id' => $user_id,
                    'data_inicio' => $dataFecho,
                    'data_fim' => $dataFechoFim,
                    'nomeEmpresa' => $empresa['empresa']['nome'],
                    'enderecoEmpresa' => $empresa['empresa']['endereco'],
                    'telefoneEmpresa' => $empresa['empresa']['pessoa_de_contacto'],
                    'nifEmpresa' => $empresa['empresa']['nif'],
                    'logotipo' => $caminho
                ]

            ]
        );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

    public function imprimirFechoCaixaApi(Request $request)
    {

        $TIPO_A4 = 1;
        $TIPO_TICKET = 3;

        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
        }

        $user_id = auth('EmpresaApi')->user()->id;

        $dataFecho = date("Y-m-d", strtotime($request->get('dataFecho')));
        $dataFechoFim = date("Y-m-d", strtotime($request->get('dataFechoFim')));
        $tipoDoc = $request->get('tipoDoc');


        $facturas = DB::connection('mysql2')->table('facturas')
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            //->whereDate('created_at', '=', $dataFecho)
            ->where('user_id', '=', $user_id)
            ->where('empresa_id', $empresa_id)->get();

        if (!$facturas) {
            return response()->json(['isValid' => false, 'errors' => 'Não existe documento referente esta data'], 401);
        }


        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => $empresa_id]);


        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;


        if ($tipoDoc == $TIPO_TICKET) {
            $filename = "FechoCaixaTicket"; //filename
        } else if ($tipoDoc == $TIPO_A4) {
            $filename = "fechoDeCaixa"; //filename
        }

        //valor cash
        $valorCash = Factura::where('empresa_id', $empresa_id)
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            ->where('tipo_documento', 1)
            ->where('formas_pagamento_id', 1) //pgt numerario
            ->where('anulado', 1)->where('user_id', $user_id)
            ->sum('valor_a_pagar');




        $valorTransferencia = Factura::where('empresa_id', $empresa_id)
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('formas_pagamento_id', 4) //pgt transferencia
            ->where('user_id', $user_id)
            ->sum('valor_a_pagar');

        $valorDeposito = Factura::where('empresa_id', $empresa_id)
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('formas_pagamento_id', 5) //pgt deposito
            ->where('user_id', $user_id)
            ->sum('valor_a_pagar');

        $valorMulticaixa = Factura::where('empresa_id', $empresa_id)
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('formas_pagamento_id', 3) //pgt multicaixa
            ->where('user_id', $user_id)
            ->sum('valor_a_pagar');


        //factura proforma
        $facturaProforma = Factura::where('empresa_id', $empresa_id)
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            ->where('tipo_documento', 3)
            ->where('formas_pagamento_id', null) // proforma
            ->where('anulado', 1)->where('user_id', $user_id)->count();

        $facturaAnulado = Factura::where('empresa_id', $empresa_id)
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            ->where('anulado', 2)->where('user_id', $user_id)->count();


        $valorTotalFacturado = Factura::where('empresa_id', $empresa_id)
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('user_id', $user_id)
            ->where(function ($query) {
                $query->where('formas_pagamento_id', 1) //pgt numerario
                    ->orwhere('formas_pagamento_id', 4) //pgt tranferencia
                    ->orwhere('formas_pagamento_id', 5) //pgt deposito
                    ->orwhere('formas_pagamento_id', 3); //pgt multicaixa
            })->sum('valor_a_pagar');


        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    "empresa_id" => $empresa_id,
                    "logotipo" => $caminho,
                    "operador" => auth('EmpresaApi')->user()->name,
                    "data_fecho" => $dataFecho,
                    "valorCash" => $valorCash,
                    "valorTransferencia" => $valorTransferencia,
                    "valorDeposito" => $valorDeposito,
                    "valorMulticaixa" => $valorMulticaixa,
                    "facturaProforma" => $facturaProforma,
                    "facturaAnulado" => $facturaAnulado,
                    "valorTotalFacturado" => $valorTotalFacturado
                ]

            ]
        );
    }
}
