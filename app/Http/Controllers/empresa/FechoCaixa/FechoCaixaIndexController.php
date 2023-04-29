<?php

namespace App\Http\Controllers\empresa\FechoCaixa;

use App\Http\Controllers\empresa\ReportShowController;
use Illuminate\Support\Facades\DB;
use Livewire\Component;



class FechoCaixaIndexController extends Component
{

    public $data;
    // public function boot(ReciboRepository $reciboRepository)
    // {
    //     $this->reciboRepository = $reciboRepository;
    // }

    public function render()
    {
        return view('empresa.fechoCaixa.index');
    }
    public function imprimirFechoCaixa()
    {

        $dataInicio = $this->data . " 07:30";
        $dataFim = $this->data . " 22:00";

        $formatoPeriodo = "07:30 à 22:00";



        $rules = [
            'data' => ["required", function ($attr, $value, $fail) use ($dataInicio, $dataFim) {
                $countFactura =  DB::table('facturas')->where('empresa_id', auth()->user()->empresa_id)
                    ->where('created_at', '>=', $dataInicio)
                    ->where('created_at', '<=', $dataFim)
                    ->get();

                if (count($countFactura) <= 0) {
                    $fail("Não existe vendas neste intervalo");
                }
            }],
        ];
        $messages = [
            'data.required' => 'Informe a data'
        ];

        $this->validate($rules, $messages);

        $filename = 'fechoCaixaPorDataDefinidasTodosOperadores';

        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $DIR = public_path() . '/upload/documentos/empresa/relatorios/';


        // dd(auth()->user()->empresa_id);


        // empresaId = 158
        // data inicio = 2022-02-21 08:00
        // data fim = 2022-02-23 21:00
        // logotipo = C:\laragon\www\mutue-negocios\public/upload//utilizadores/cliente/laAJKtYOSjaLBTSjPlhDFfwmincv6pGBxAtuCThh.png
        // formatoPeriodo = 22-02-2022 08:00 as 21:00
        // DIR = C:\laragon\www\mutue-negocios\public/upload/documentos/empresa/relatorios//


        $reportController = new ReportShowController();
        $report = $reportController->show(
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
        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
}
