<?php

namespace App\Http\Controllers;

use App\Models\empresa\CentroCusto;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RelatorioController extends Component
{

    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use VerificaSeEmpresaTipoAdmin;

    private $uuid;
    public $venda;
    public $mensagem = "teste";

    public function mount($uuid)
    {
        $this->uuid = $uuid;
    }


    public function render()
    {

        $centroCusto =  CentroCusto::where('uuid', $this->uuid)->where('empresa_id', auth()->user()->empresa_id)->first();
        if (!$centroCusto) {
            return redirect()->back();
        }

        return view('empresa.relatorios.index', [
            'centroCusto' => $centroCusto
        ]);
    }
/**

    public function printRelatorioExistenciaStock($uuid)
    {
        $empresa = auth()->user()->empresa;
        $logotipo = public_path() . "/upload//" . auth()->user()->empresa->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'existenciaStock',
                'report_jrxml' => 'existenciaStock.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'nomeEmpresa' => $empresa->nome,
                    'enderecoEmpresa' => $empresa->endereco,
                    'telefoneEmpresa' => $empresa->pessoal_Contacto,
                    'nifEmpresa' => $empresa->nif,
                    'emailEmpresa' => $empresa->email,
                    'logotipo' => $logotipo
                ]
            ]
        );
    }
    public function printRelatorioStock(Request $request, $uuid)
    {

        $message = [
            'dataInicio.required' => 'Informe as datas',
            'dataFim.required' => 'Informe as datas',
        ];
        $this->validate($request, [
            'dataInicio' => ['required'],
            'dataFim' => ['required']
        ], $message);

        $dataInicio = str_replace("T", " ", $request->dataInicio);
        $dataFim = str_replace("T", " ", $request->dataFim);
        $dataInicioFormat = date_format(date_create($dataInicio), 'd/m/Y H:i');
        $dataFinalFormat = date_format(date_create($dataFim), 'd/m/Y H:i');
        $logotipo = public_path() . "/upload//" . auth()->user()->empresa->logotipo;

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => 'relatoriosDeStock',
                'report_jrxml' => 'relatoriosDeStock.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'data_inicio' => $dataInicio,
                    'data_fim' => $dataFim,
                    'dataInicioFormat' => $dataInicioFormat,
                    'dataFinalFormat' => $dataFinalFormat,
                    'logotipo' => $logotipo
                ]
            ]
        );
    }
 
 */



    public function printRelatorioVenda()
    {

        dd('teste');
        $message = [
            'dataInicio.required' => 'Informe as datas',
            'dataFim.required' => 'Informe as datas',
        ];
        $this->validate($request, [
            'dataInicio' => ['required', function ($attribute, $value, $fail) use ($request) {
                if ($request['dataInicio'] > $request['dataFim']) {
                    $fail('data inicial é maior que a final');
                    return;
                }
            }],
            'dataFim' => ['required']
        ], $message);

        $dataInicio = str_replace("T", " ", $request->dataInicio);
        $dataFim = str_replace("T", " ", $request->dataFim);
        $dataInicioFormat = date_format(date_create($dataInicio), 'd/m/Y H:i');
        $dataFinalFormat = date_format(date_create($dataFim), 'd/m/Y H:i');

        if ($request->user_id) {
            $operador =  DB::table('users_cliente')
                ->where('empresa_id', auth()->user()->empresa_id)
                ->where('id', $request->user_id)
                ->first()->name;
        } else {
            $operador = "Todos operadores";
        }
        // $filename = $request->formato == 'pdf' ? 'relatoriosDeVenda' : 'relatoriosDeVendaXls';
        $filename = 'relatoriosDeVenda';
        $logotipo = public_path() . "/upload//" . auth()->user()->empresa->logotipo;
        //156
        //2022-08-26 06:00
        //2022-08-26 12:09
        //26/08/2022 06:00
        //26/08/2022 12:09
        //NULL
        //Todos operadores
        //C:\laragon\www\appmutuenegociosv1\public/upload//utilizadores/cliente/avatarEmpresa.png
        // dd($logotipo);

        $reportController = new ReportsController();
        return $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'data_inicio' => $dataInicio,
                    'data_fim' => $dataFim,
                    'dataInicioFormat' => $dataInicioFormat,
                    'dataFinalFormat' => $dataFinalFormat,
                    'user_id' => $request->user_id,
                    'operador' => $operador,
                    'logotipo' => $logotipo
                ]
            ]
        );
    }
}
