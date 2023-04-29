<?php

namespace App\Http\Controllers\empresa\Facturas;

use App\Http\Controllers\empresa\ReportFacturaController;
use App\Http\Controllers\empresa\ReportShowController;
use App\Http\Controllers\TypeInvoice;
use App\Repositories\Empresa\FacturaRepository;
use App\Repositories\Empresa\FormaPagamentoRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;



class FacturaProformaIndexController extends Component
{

    use TraitEmpresaAutenticada;
    use WithPagination;
    use LivewireAlert;



    public $search;

    public $factura = [];
    private $facturaRepository;
    private $formaPagamentoRepository;
    public $totalPrecoFactura = 0;
    public $valorPagar = 0;

    public function __construct()
    {
        $this->factura['formas_pagamento_id'] = 1;
        $this->factura['troco'] = 0;
        $this->factura['valor_entregue'] = 0;
    }

    public function boot(FacturaRepository $facturaRepository, FormaPagamentoRepository $formaPagamentoRepository)
    {
        $this->facturaRepository = $facturaRepository;
        $this->formaPagamentoRepository = $formaPagamentoRepository;
    }

    public function render()
    {
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }

        $data['formaPagamentos'] = $this->formaPagamentoRepository->listarFormaPagamentosSemPagamentoDuplo();

        $data['facturas'] = $this->facturaRepository->listarFacturasProformas($this->search);
        return view('empresa.facturas.facturaProformasIndex', $data);
    }

    public function mostrarModalConverterFactura($factura)
    {

        $this->factura = $factura;
        $this->totalPrecoFactura = $factura['total_preco_factura'];
        $this->valorPagar = $factura['valor_a_pagar'];
        $this->factura['tipo_documento'] = 1;
        $this->factura['formas_pagamento_id'] = 1;
    }
    public function converterFactura()
    {


        if (($this->factura['valor_entregue'] < $this->factura['valor_a_pagar']) && $this->factura['formas_pagamento_id'] != TypeInvoice::CONVERTIDO) {

            $this->confirm('O valor entregue é menor ao valor a pagar', [
                'showConfirmButton' => 'OK',
                'showCancelButton' => false,
                'icon' => 'warning',

            ]);
            return;
        }
        if ($this->factura['convertidoFactura'] == TypeInvoice::CONVERTIDO) {

            $this->confirm('A factura proforma já foi convertido', [
                'showConfirmButton' => 'OK',
                'showCancelButton' => false,
                'icon' => 'warning',

            ]);
            return;
        }


        $facturaId = $this->facturaRepository->converterFacturaProforma($this->factura);
        $this->facturaRepository->alterarStatuFacturaParaConvertido($this->factura);
        $this->dispatchBrowserEvent('closeModal');
        return $this->ImprimirFactura($facturaId);


    }
    public function ImprimirFactura($facturaId)
    {


        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $DIR_SUBREPORT = "/upload/documentos/empresa/modelosFacturas/a4/";
        $DIR = public_path() . "/upload/documentos/empresa/modelosFacturas/a4/";



        $reportController = new ReportShowController('pdf', $DIR_SUBREPORT);
        $report = $reportController->show(
            [
                'report_file' => 'Winmarket',
                'report_jrxml' =>  'Winmarket.jrxml',
                'report_parameters' => [
                    "dirSubreportBanco" => $DIR,
                    "dirSubreportTaxa" => $DIR,
                    "empresa_id" => auth()->user()->empresa_id,
                    "facturaId" => $facturaId,
                    "viaImpressao" => 1,
                    "logotipo" => $logotipo,
                    "tipo_regime" => auth()->user()->empresa->tipo_regime_id
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
    public function updateValorEntregue()
    {
        if ($this->factura['formas_pagamento_id'] == 2) {
            $this->factura['valor_entregue'] = 0;
            $this->confirm('Alterar a forma de pagamento', [
                'showConfirmButton' => 'OK',
                'showCancelButton' => false,
                'icon' => 'warning',

            ]);
            return;
        }
        $valorEntregue = $this->factura['valor_entregue'] ? $this->factura['valor_entregue'] : 0;
        $this->factura['troco'] = number_format($valorEntregue == 0 ? 0 : ($valorEntregue - $this->factura['valor_a_pagar']), 2, ',', '.');
    }
    public function updatedFacturaFormasPagamentoId($formaPagamentoId)
    {

        if ($formaPagamentoId == 2) {
            $this->factura['valor_entregue'] = 0;
            $this->factura['troco'] = 0;
            $this->factura['tipo_documento'] = TypeInvoice::FACTURA;
        } else {
            $this->factura['tipo_documento'] = TypeInvoice::FACTURA_RECIBO;
        }
    }
}
