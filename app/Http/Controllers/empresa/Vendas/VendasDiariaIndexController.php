<?php

namespace App\Http\Controllers\empresa\Vendas;

use App\Http\Controllers\empresa\ReportShowController;
use App\Models\empresa\Factura;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;


class VendasDiariaIndexController extends Component
{
    use LivewireAlert;

    public $dataInicio = null;
    public $dataFinal = null;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function boot()
    { }

    public function render()
    {
        $data['vendas'] = $this->filtrarVendaDiariaPorData($this->dataInicio, $this->dataFinal);
        return view("empresa.vendas.indexVendasDiaria_", $data);
    }

    public function printVendaDiaria($venda)
    {

        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        $filename = "vendaDiaria";

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'logotipo' => $logotipo,
                    'data_atual' => $venda['data_criada']
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }


    public function filtrarVendaDiariaPorData($dataInicio = null, $dataFinal = null)
    {
        return DB::connection('mysql2')->table('facturas')
            ->select(
                DB::raw('SUM(total_preco_factura) as total_factura'),
                DB::raw('SUM(total_iva) as total_iva'),
                DB::raw('SUM(desconto) as total_desconto'),
                DB::raw('SUM(troco) as total_troco'),
                DB::raw('DATE(created_at) as data_criada'),
                DB::raw('SUM(valor_entregue) as total_entregue'),
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
            ->orderBy('data_criada', 'DESC')
            ->groupByRaw('data_criada')
            ->paginate();

        // return DB::select('
        // SELECT
        // SUM(total_preco_factura) AS total_factura,
        // SUM(total_iva) AS total_iva,
        // SUM(desconto) AS total_desconto,
        // SUM(troco) AS total_troco,
        // DATE(created_at) AS data_criada,
        // SUM(valor_entregue) AS total_entregue
        //     FROM facturas WHERE facturas.anulado=1 AND empresa_id = "' . auth()->user()->empresa_id . '"
        //     AND (facturas.tipo_documento = 1
        //     OR facturas.tipo_documento = 2)
        //     GROUP BY DATE (created_at) order by DATE (created_at) DESC');
    }
}
