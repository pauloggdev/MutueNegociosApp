<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\empresa\ReportsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RelatorioVendasController extends Controller
{
    public function imprimirVendaDiaria(Request $request)
    {
        $messages = [
            'filterDate.required' => 'Informe a data',
        ];
        $validator = Validator::make($request->all(), [
            'filterDate' => "required",
        ], $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        
        if ((isset($_GET['filterDate']) && !empty($_GET['filterDate']))) {
            $filterDate = $_GET['filterDate'];
        }
        $isDocumentCurrentDate = DB::table('facturas')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('tipo_documento', 1) //factura recibo
            ->where('created_at', 'like', $filterDate . '%')
            ->get();
        // dd(count($isDocumentCurrentDate));

        if (count($isDocumentCurrentDate) <= 0) {
            return response()->json(['isValid' => false, 'errors' => 'Nenhuma factura recibo efectuada no dia selecionado'], 422);
        }
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => auth()->user()->empresa_id]);
        $diretorio = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;
        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'relatorioDiarioTodoFuncionario',
                'report_jrxml' => 'relatorioDiarioTodoFuncionario.jrxml',
                'report_parameters' => [
                    "diretorio" =>  $diretorio,
                    "data" => $filterDate,
                    'empresa_id' => auth()->user()->empresa_id,
                ]
            ]
        );
    }

    public function imprimirVendaMensal(Request $request)
    {
        $messages = [
            'filterMonthYear.required' => 'Informe o Mês',
        ];
        $validator = Validator::make($request->all(), [
            'filterMonthYear' => "required",
        ], $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        if ((isset($_GET['filterMonthYear']) && !empty($_GET['filterMonthYear']))) {
            $filterMonthYear = explode("-", $_GET['filterMonthYear']);
            $ano = $filterMonthYear[0];
            $mes = $filterMonthYear[1];
        }


        $isDocumentCurrentDate = DB::table('facturas')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('tipo_documento', 1) //factura recibo
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $ano)
            ->get();

        if (count($isDocumentCurrentDate) <= 0) {
            return response()->json(['isValid' => false, 'errors' => 'Nenhuma factura recibo efectuada no mês selecionado'], 422);
        }
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => auth()->user()->empresa_id]);
        $diretorio = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        // dd($empresa['operador']);

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'relatorioMensalTodoFuncionario',
                'report_jrxml' => 'relatorioMensalTodoFuncionario.jrxml',
                'report_parameters' => [
                    "diretorio" =>  $diretorio,
                    'empresa_id' => auth()->user()->empresa_id,
                    "mes" => $mes,
                    "ano" => $ano
                ]
            ]
        );
    }

    public function imprimirVendaAnual(Request $request)
    {
        $messages = [
            'filterYear.required' => 'Informe o ano',
        ];
        $validator = Validator::make($request->all(), [
            'filterYear' => "required",
        ], $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }
        if ((isset($_GET['filterYear']) && !empty($_GET['filterYear']))) {
            $ano = $_GET['filterYear'];
        }



        $isDocumentCurrentDate = DB::table('facturas')
        ->where('empresa_id', auth()->user()->empresa_id)
            ->where('tipo_documento', 1) //factura recibo
            ->whereYear('created_at', $ano)
            ->get();

        if (count($isDocumentCurrentDate) <= 0) {
            return response()->json(['isValid' => false, 'errors' => 'Nenhuma factura recibo efectuada no mês selecionado'], 422);
        }
        //recupera o logotipo da empresa
        $empresaLogotipo = DB::connection("mysql2")->select('select logotipo from empresas where id = :id', ['id' => auth()->user()->empresa_id]);

        $diretorio = public_path() . "/upload//" . $empresaLogotipo[0]->logotipo;

        // dd($empresa['operador']);

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'relatorioAnualTodoFuncionario',
                'report_jrxml' => 'relatorioAnualTodoFuncionario.jrxml',
                'report_parameters' => [
                    "diretorio" =>  $diretorio,
                    'empresa_id' => auth()->user()->empresa_id,
                    "ano" => $ano
                ]
            ]
        );
    }
}
