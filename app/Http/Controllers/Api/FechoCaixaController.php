<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Controllers\empresa\ReportsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\empresa\Factura;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class FechoCaixaController extends Controller
{

    public function imprimirFechoCaixa(Request $request)
    {

        $TIPO_A4 = 1;
        $TIPO_TICKET = 3;



        $messages = [
            'dataInicio.required' => 'Informe a data inicial',
            'dataFim.required' => 'Informe a data final',
        ];
        $validator = Validator::make($request->all(), [

            'dataInicio' => "required",
            'dataFim' => "required",
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        $dataFecho = date("Y-m-d H:i", strtotime($request->get('dataInicio')));
        $dataFechoFim = date("Y-m-d H:i", strtotime($request->get('dataFim')));


        $facturas = DB::connection('mysql2')->table('facturas')
            ->whereDate('created_at', '>=', $dataFecho)
            ->whereDate('created_at', '<=', $dataFechoFim)
            //->whereDate('created_at', '=', $dataFecho)
            ->where('user_id', '=', auth()->user()->id)
            ->where('empresa_id',)->get();
        if (!$facturas) {
            return response()->json(['isValid' => false, 'errors' => 'Não existe documento referente esta data'], 401);
        }
        $user_id = Auth::user()->id;
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' =>auth()->user()->empresa_id]);
        $caminho = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;
        $filename = "FechoCaixaNovo";
        //valor cash
        $valorDinheiro = Factura::where('empresa_id',auth()->user()->empresa_id)
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('tipo_documento', 1)
            ->where('formas_pagamento_id', 1) //pgt numerario
            ->where('anulado', 1)->where('user_id', $user_id)
            ->sum('valor_a_pagar');

        $valorTransferencia = Factura::where('empresa_id',auth()->user()->empresa_id)
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('formas_pagamento_id', 4) //pgt transferencia
            ->where('user_id', $user_id)
            ->sum('valor_a_pagar');

        $valorMulticaixa = Factura::where('empresa_id',auth()->user()->empresa_id)
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('tipo_documento', 1)
            ->where('anulado', 1)
            ->where('formas_pagamento_id', 3) //pgt multicaixa
            ->where('user_id', $user_id)
            ->sum('valor_a_pagar');

        $TotalDeposito = Factura::where('empresa_id',auth()->user()->empresa_id)
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
        $totalProforma = Factura::where('empresa_id',auth()->user()->empresa_id)
            ->whereBetween('created_at', [$dataFecho, $dataFechoFim])
            ->where('tipo_documento', 3)
            ->where('formas_pagamento_id', null) // proforma
            ->where('anulado', 1)->where('user_id', $user_id)->count();

        $facturaAnulado = Factura::where('empresa_id',auth()->user()->empresa_id)
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


        // $valorTotalFacturado = Factura::where('empresa_id',auth()->user()->empresa_id)
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
                    'operador' =>auth()->user()->name,
                    'user_id' => $user_id,
                    'data_inicio' => $dataFecho,
                    'data_fim' => $dataFechoFim,
                    'nomeEmpresa' => auth()->user()->empresa->nome,
                    'enderecoEmpresa' => auth()->user()->empresa->endereco,
                    'telefoneEmpresa' => auth()->user()->empresa->pessoa_de_contacto,
                    'nifEmpresa' => auth()->user()->empresa->nif,

                ]

            ]
        );
    }
}
