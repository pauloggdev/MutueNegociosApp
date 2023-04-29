<?php

namespace App\Http\Controllers\empresa\Clientes;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\ClienteRepository;
use App\Repositories\Empresa\FacturaRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ClienteExtratoController extends Component
{

    use LivewireAlert;



    protected $clienteRepository;
    protected $facturaRepository;
    public $cliente;
    public $saldoCliente;
    public $dataInicio;
    public $dataFim;
    public $checkTodoPeriodo = false;


    public function boot(ClienteRepository $clienteRepository, FacturaRepository $facturaRepository)
    {
        $this->clienteRepository = $clienteRepository;
        $this->facturaRepository = $facturaRepository;
    }
    public function mount($uuid)
    {
        $this->cliente = $this->clienteRepository->getClientePeloUuid($uuid);
        // $this->saldoCliente = $this->clienteRepository->mostrarSaldoAtualDoCliente($clienteId);

    }
    public function updatedCheckTodoPeriodo()
    {

        if ($this->checkTodoPeriodo) {
            $factura = $this->facturaRepository->listarPrimeiraFacturaPeloCliente($this->cliente->id);
            if ($factura) {
                $dataInicio = date('Y-m-d', strtotime($factura->created_at));
                $this->dataInicio = $dataInicio;
                $this->dataFim = Carbon::parse(Carbon::now())->format('Y-m-d');
            } else {
                $this->confirm('O cliente não emitiu nenhum documento', [
                    'showConfirmButton' => false,
                    'showCancelButton' => false,
                    'icon' => 'warning'
                ]);
                $this->dataInicio = null;
                $this->dataFim = null;
                return;
            }
        } else {
            $this->dataInicio = null;
            $this->dataFim = null;
            return;
        }
    }


    public function render()
    {
        return view('empresa.clientes.extrato');
    }
    public function imprimirExtratoCliente()
    {


        $rules = [
            'dataInicio' => [function ($attr, $dataInicio, $fail) {
                if (!$this->checkTodoPeriodo && !$dataInicio) {
                    $fail('Informe a data inicio');
                }
            }],
            'dataFim' => [function ($attr, $dataFim, $fail) {
                if (!$this->checkTodoPeriodo && !$dataFim) {
                    $fail('Informe a data final');
                }
            }],
        ];
        $messages = [
            'dataInicio.required' => 'Informe a data inicial',
            'dataFim.required' => 'Informe a data final',
        ];



        $this->validate($rules, $messages);

        // dd($this->checkTodoPeriodo);


        if($this->dataFim && $this->dataInicio){
            $factura = $this->facturaRepository->verificarSeExisteFacturaPeloClienteEIntervaloData($this->dataInicio, $this->dataFim, $this->cliente->id);
        }else{
            $factura = $this->facturaRepository->listarPrimeiraFacturaPeloCliente($this->cliente->id);
        }
        if (!$factura) {
            $this->confirm('O cliente não emitiu nenhum documento neste periodo', [
                'showConfirmButton' => false,
                'showCancelButton' => false,
                'icon' => 'warning'
            ]);
            return;
        }

        $dataInicio = $this->dataInicio . " 00:00";
        $dataFim = $this->dataFim . " 23:59";
        $formatoPeriodo = Carbon::parse($dataInicio)->format('d/m/Y') . " à " . Carbon::parse($dataFim)->format('d/m/Y');

        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $DIR = public_path() . "/upload/documentos/empresa/relatorios/";


        $filename = "extratoCliente";

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => $filename,
                'report_jrxml' => $filename . '.jrxml',
                'report_parameters' => [
                    'empresa_id' => auth()->user()->empresa_id,
                    'diretorio' => $logotipo,
                    'cliente_id' => $this->cliente->id,
                    'data_inicio' => $dataInicio,
                    'data_fim' => $dataFim,
                    'data_now' => Carbon::now(),
                    'DIR' => $DIR,
                    'formatoPeriodo' => $formatoPeriodo
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
}
