<?php

namespace App\Http\Controllers\empresa\Recibos;

use App\Http\Controllers\empresa\ReportShowController;
use App\Repositories\Empresa\ClienteRepository;
use App\Repositories\Empresa\FacturaRepository;
use App\Repositories\Empresa\FormaPagamentoRepository;
use App\Repositories\Empresa\ReciboRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use NumberFormatter;
use Illuminate\Support\Facades\Storage;


class ReciboCreateController extends Component
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use WithFileUploads;
    use LivewireAlert;


    public $numeracaoFactura = null;
    public $factura= [];
    public $formaPagamentoId = 1;

    private $reciboRepository;
    private $clienteRepository;
    private $facturaRepository;
    private $formaPagamentoRepository;

    protected $listeners = ['selected' => 'selected'];


    public function boot(
        ReciboRepository $reciboRepository,
        ClienteRepository $clienteRepository,
        FacturaRepository $facturaRepository,
        FormaPagamentoRepository $formaPagamentoRepository
    ) {
        $this->reciboRepository = $reciboRepository;
        $this->clienteRepository = $clienteRepository;
        $this->facturaRepository = $facturaRepository;
        $this->formaPagamentoRepository = $formaPagamentoRepository;
    }
    public function updated(){
        $this->dispatchBrowserEvent('loadSelect2');
        $this->factura['forma_pagamento_id'] = $this->formaPagamentoId;
    }

    public function mount()
    {
        $this->setarValorPadrao();
    }
    public function selected($name, $value){
        $this->$name = $value;
        $this->factura['forma_pagamento_id'] = $value;
        $this->dispatchBrowserEvent('loadSelect2');
    }
    public function render()
    {

        $data['formaPagamentos'] = $this->formaPagamentoRepository->listarFormaPagamentos();
        return view('empresa.recibos.create', $data);
    }
    public function updatedNumeracaoFactura(){

        if($this->numeracaoFactura && strlen(rtrim($this->numeracaoFactura)) > 10){
            $numeracaoFactura = preg_replace('/\s+/', '', $this->numeracaoFactura);
            $numeracaoFactura = preg_replace('/^(\w{2})/', '$1 ', $numeracaoFactura);
            $factura = $this->facturaRepository->listarFacturasParaEmitirReciboPelaNumeracaoFactura($numeracaoFactura);
            if(!$factura){
                $this->confirm('Factura não encontrada', ['showConfirmButton' => false, 'showCancelButton' => false, 'icon' => 'warning']);
                $this->setarValorPadrao();
                return;
            }
            $this->factura['nome_do_cliente'] = $factura->nome_do_cliente;
            $this->factura['telefone_cliente'] = $factura->telefone_cliente;
            $this->factura['nif_cliente'] = $factura->nif_cliente;
            $this->factura['email_cliente'] = $factura->email_cliente;
            $this->factura['endereco_cliente'] = $factura->endereco_cliente;
            $this->factura['conta_corrente_cliente'] = $factura->conta_corrente_cliente;
            $this->factura['numeracaoFactura'] = $factura->numeracaoFactura;
            $this->factura['factura_id'] = $factura->id;
            $this->factura['cliente_id'] = $factura->cliente_id;
            $this->factura['valor_a_pagar'] = $factura->valor_a_pagar;
            $this->factura['cliente_saldo'] = $this->clienteRepository->mostrarSaldoAtualDoCliente($factura->cliente_id);
            $this->factura['total_debito'] = $this->clienteRepository->mostrarValorFaltanteApagarNaFaturaDoCliente($factura);

            $valorPagar = str_replace(".", "", $this->factura['valor_a_pagar']);
            $totalDebito =  str_replace(".", "", $this->factura['total_debito']);
            $valorPagar = str_replace(",", ".", $valorPagar);
            $totalDebito =  str_replace(",", ".", $totalDebito);

            $faltante = $valorPagar - $totalDebito;
            $this->factura['faltante'] = number_format($faltante, 2, ',', '.');
        }
    }

    public function emitirRecibo()
    {

        $rules = [
            'numeracaoFactura' => 'required',
            'factura.valor_total_entregue' => ["required", function ($attr, $valorEntregue, $fail) {
                $valorPagar = str_replace(".", "", $this->factura['valor_a_pagar']);
                $totalDebito =  str_replace(".", "", $this->factura['total_debito']);
                $valorPagar = str_replace(",", ".", $valorPagar);
                $totalDebito =  str_replace(",", ".", $totalDebito);

                $total = $valorPagar - $totalDebito;
                $total = round($total, 2);

                if ($valorEntregue > $total) {
                    $fail('Valor entregue maior que a debitar');
                } else if ($valorEntregue <= 0) {
                    $fail('Informe o valor entregue');
                }
            }],
            'formaPagamentoId' => 'required',
        ];
        $messages = [
            'numeracaoFactura.required' => 'Informe a factura',
            'factura.valor_total_entregue.required' => 'Informe o valor entregue',
            'formaPagamentoId.required' => 'Informe a forma de pagamento',
        ];

        $this->validate($rules, $messages);

        $f = new NumberFormatter("pt", NumberFormatter::SPELLOUT);
        $this->factura['valor_extenso'] = $f->format($this->factura['valor_total_entregue']);

        //Faltando verificar se já foi emitido documento com datas anterior
        $recibo = $this->reciboRepository->salvarRecibo($this->factura);
        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;

        // $this->emit('refresh-me');
        $this->confirm('Operação realizada com sucesso', ['showConfirmButton' => false, 'showCancelButton' => false, 'icon' => 'success']);
        $this->setarValorPadrao();
        $this->numeracaoFactura = null;
        $this->formaPagamentoId = 1;

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => 'recibos',
                'report_jrxml' => 'recibos.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 1,
                    'empresa_id' => auth()->user()->empresa_id,
                    'recibo_id' => $recibo->id,
                    'factura_id' => $recibo->factura_id,
                    'logotipo' => $logotipo
                ]
            ]
        );
        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
    public function setarValorPadrao()
    {
        $this->factura['nome_do_cliente'] = NULL;
        $this->factura['conta_corrente_cliente'] = NULL;
        $this->factura['numeracaoFactura'] = NULL;
        $this->factura['cliente_saldo'] = NULL;
        $this->factura['valor_a_pagar'] = NULL;
        $this->factura['total_debito'] = NULL;
        $this->factura['faltante'] = 0;
        $this->factura['observacao'] = NULL;
        $this->factura['valor_total_entregue'] = NULL;
        // $this->factura['forma_pagamento_id'] = $this->formaPagamentoId;
    }
}
