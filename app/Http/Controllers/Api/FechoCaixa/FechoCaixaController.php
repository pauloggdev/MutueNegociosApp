<?php

namespace App\Http\Controllers\Api\FechoCaixa;

use App\Http\Controllers\Controller;
use App\Http\Controllers\empresa\ReportsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FechoCaixaController extends Controller
{

    public function imprimirFechoCaixa(Request $request)
    {

        // dd('teste');
        $dataInicio = $request->dataInicio." 00:00";
        $dataFim = $request->dataFim. " 23:59";





        $formatoPeriodo = date('d/m/Y', strtotime($request->dataInicio)). " à ". date('d/m/Y', strtotime($request->dataFim));

        $messages = [
            'dataInicio.required' => 'Informe data inicio',
            'dataFim.required' => 'Informe data final'
        ];
        $validator = Validator::make($request->all(), [
            'dataInicio' => ["required", function ($attr, $value, $fail) use($dataInicio, $dataFim) {
                $countFactura =  DB::table('facturas')->where('empresa_id', auth()->user()->empresa_id)
                ->where('created_at', '>=', $dataInicio)
                ->where('created_at', '<=', $dataFim)
                ->get();
            if (count($countFactura) <= 0) {
                $fail("Não existe vendas neste intervalo");
            }
             }],
            'dataFim' => ["required"]
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }



        $filename = 'fechoCaixaPorDataDefinidasTodosOperadores_';

        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $DIR = public_path() . '/upload/documentos/empresa/relatorios/';

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'nomeEmpresa' => auth()->user()->empresa->nome,
                    'enderecoEmpresa' => auth()->user()->empresa->endereco,
                    'telefoneEmpresa' => auth()->user()->empresa->pessoal_Contacto,
                    'nifEmpresa' => auth()->user()->empresa->nif,
                    'empresa_id' => auth()->user()->empresa_id,
                    'data_inicio' => $dataInicio,
                    'data_fim' => $dataFim,
                    'logotipo' => $logotipo,
                    'formatoPeriodo' => $formatoPeriodo,
                    'DIR' => $DIR

                ]

            ]
        );
    }
}
