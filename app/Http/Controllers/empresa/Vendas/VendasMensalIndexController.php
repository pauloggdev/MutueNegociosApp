<?php

namespace App\Http\Controllers\empresa\Vendas;

use App\Http\Controllers\empresa\ReportShowController;
use App\Models\empresa\Factura;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;


class VendasMensalIndexController extends Component
{
    use LivewireAlert;

    public $dataInicio = null;
    public $dataFinal = null;


    public function boot()
    { }

    public function render()
    {
        // dd($this->dataInicio);
        $data['vendas'] = $this->filtrarVendaMensalPorData($this->dataInicio, $this->dataFinal);
        return view("empresa.vendas.indexVendasMensal_", $data);
    }

    public function printVendaMensal($venda)
    {

        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $filename = "vendaMensal";

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'logotipo' => $logotipo,
                    'mes' => $venda['mes'],
                    'ano' => $venda['ano']
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }


    public function filtrarVendaMensalPorData($dataInicio = null, $dataFinal = null)
    {
        return DB::connection('mysql2')->table('facturas')
            ->select(
                DB::raw('SUM(total_preco_factura) as total_factura'),
                DB::raw('SUM(total_iva) as total_iva'),
                DB::raw('SUM(desconto) as total_desconto'),
                DB::raw('SUM(troco) as total_troco'),
                DB::raw('DATE(created_at) as data_criada'),
                DB::raw('SUM(valor_entregue) as total_entregue'),
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('YEAR(created_at) as ano')
            )
            ->where('anulado', 1)
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where(function($query) use($dataInicio, $dataFinal){
                $query->where('id','>', 0);
                if($dataInicio && $dataFinal){
                    $query->whereDate('created_at','>=',$dataInicio)->whereDate('created_at', '<=', $dataFinal);
                }
            })
            ->where(function($query){
                $query->where("tipo_documento", 1)
                ->orwhere("tipo_documento", 2);
            })
            ->orderByRaw('YEAR(created_at)', 'DESC')
            ->orderByRaw('MONTH(created_at)', 'DESC')
            ->groupByRaw('MONTH(created_at)')
            ->groupByRaw('YEAR(created_at)')
            ->paginate();
    }
}
