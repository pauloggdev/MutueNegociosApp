<?php

namespace App\Http\Controllers\empresa\NotaCreditoAnulacaoDocumentos;

use App\Http\Controllers\empresa\ReportShowController;
use App\Http\Controllers\empresa\VerificadorDocumento;
use App\Repositories\Empresa\ClienteRepository;
use App\Repositories\Empresa\FacturaRepository;
use App\Repositories\Empresa\NotaCreditoRetificacaoDocumentoRepository;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use Livewire\Component;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use NumberFormatter;

class RetificacaoDocumentoCreateController extends Component
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;
    use WithFileUploads;
    use LivewireAlert;

    public $notaCredito;
    public $facturaSearch;
    public $saldoCliente;
    public $facturaAlterada;
    private $notaCreditoRetificacaoDocumentoRepository;
    private $clienteRepository;
    private $facturaRepository;
    public $factura;


    public function boot(
        NotaCreditoRetificacaoDocumentoRepository $notaCreditoRetificacaoDocumentoRepository,
        ClienteRepository $clienteRepository,
        FacturaRepository $facturaRepository
    ) {
        $this->notaCreditoRetificacaoDocumentoRepository = $notaCreditoRetificacaoDocumentoRepository;
        $this->clienteRepository = $clienteRepository;
        $this->facturaRepository = $facturaRepository;
    }

    public function render()
    {
        return view('empresa.NotaCreditoRetificacaoDocumento.create');
    }
    public function buscarFactura()
    {
        $data['factura'] = array();
        if (strlen($this->facturaSearch) > 5) {
            $this->facturaSearch = trim(strtoupper($this->facturaSearch));
            $this->factura = $this->facturaRepository->buscarFacturaNaoRetificadoPelaNumeracao($this->facturaSearch);
            if ($this->factura) {
                $this->notaCredito['factura'] = $this->factura;
                $this->saldoCliente = $this->clienteRepository->mostrarSaldoAtualDoCliente($this->factura['cliente_id']);
            } else {
                $this->confirm('Factura não encontrada', [
                    'showConfirmButton' => "Ok",
                    'showCancelButton' => false,
                    'icon' => 'warning'

                ]);
                return;
            }
        }
    }
    public function calcularDesconto($precoVenda, $descontoPercentagem, $qty = 0)
    {
        $qty = $qty ? $qty : 0;
        if ($qty <= 0) {
            return 0;
        }
        return ($precoVenda * $qty * $descontoPercentagem) / 100;
    }
    public function calcularIvaProduto($incidencia, $ivaPercentagem)
    {

        return ($ivaPercentagem / 100) * $incidencia;
    }

    public function calcularValorRetencao($valorIncidencia, $retencaoPercentagem)
    {
        return $valorIncidencia * $retencaoPercentagem;
    }
    public function descontoPercentagem($precoVenda, $valorDescontoAnterior, $qty_anterior)
    {
        $qty = $qty_anterior ? $qty_anterior : 0;
        if ($qty <= 0) return 0;
        return (($valorDescontoAnterior * 100) / ($precoVenda * $qty));
    }
    public function calcularIvaPercentagem($precoVenda, $descontoPercentagem, $valorIvaAnterior, $qty_anterior)
    {
        $incidencia = $this->calcularValorIncidencia($precoVenda, $descontoPercentagem, $qty_anterior);
        if ($incidencia <= 0) return 0;
        return ($valorIvaAnterior * 100) / $incidencia;
    }


    public function retencaoPercentagem($precoVenda, $descontoPercentagem, $retencaoAnterior, $qty_anterior)
    {
        $incidencia = $this->calcularValorIncidencia($precoVenda, $descontoPercentagem, $qty_anterior);
        if ($incidencia <= 0) return 0;
        return $retencaoAnterior / $incidencia;
    }
    public function calcularValorIncidencia($precoVenda, $descontoPercentagem, $qty = 0)
    {
        $qty = $qty ? $qty : 0;
        return ($precoVenda * $qty) - $this->calcularDesconto($precoVenda, $descontoPercentagem, $qty);
    }

    public function totalPrecoProduto($precoVenda, $qty = 0)
    {
        $qty = $qty ? $qty : 0;
        return $precoVenda * $qty;
    }
    public function alterarQuantidadeItem($key, $qty)
    {



        $factura = $this->facturaRepository->buscarFacturaNaoRetificadoPelaNumeracao($this->facturaSearch);

        $precoVenda = $factura->facturas_items[$key]['preco_venda_produto'];
        $valorDescontoAnterior = $factura->facturas_items[$key]['desconto_produto'];
        $valorRetencaoAnterior = $factura->facturas_items[$key]['retencao_produto'];
        $valorIvaAnterior = $factura->facturas_items[$key]['iva_produto'];
        $qty_anterior = $factura->facturas_items[$key]['quantidade_produto'];


        $descontoPercentagem =  $this->descontoPercentagem($precoVenda, $valorDescontoAnterior, $qty_anterior);
        $valorDesconto = $this->calcularDesconto($precoVenda, $descontoPercentagem, $qty);
        $valorIncidencia = $this->calcularValorIncidencia($precoVenda, $descontoPercentagem, $qty);
        $retencaoPercentagem = $this->retencaoPercentagem($precoVenda, $descontoPercentagem, $valorRetencaoAnterior, $qty_anterior);
        $valorRetencao = $this->calcularValorRetencao($valorIncidencia, $retencaoPercentagem);
        $ivaPercentagem = $this->calcularIvaPercentagem($precoVenda, $descontoPercentagem, $valorIvaAnterior, $qty_anterior);
        $valorIvaProduto = $this->calcularIvaProduto($valorIncidencia, $ivaPercentagem);
        $totalPrecoProduto = $this->totalPrecoProduto($precoVenda, $qty);

        $this->notaCredito['factura']['facturas_items'][$key]['desconto_produto'] = $valorDesconto;
        $this->notaCredito['factura']['facturas_items'][$key]['qty_atual'] = (int) $qty;
        $this->notaCredito['factura']['facturas_items'][$key]['incidencia_produto'] = $valorIncidencia;
        $this->notaCredito['factura']['facturas_items'][$key]['retencao_produto'] = $valorRetencao;
        $this->notaCredito['factura']['facturas_items'][$key]['iva_produto'] = $valorIvaProduto;
        $this->notaCredito['factura']['facturas_items'][$key]['total_preco_produto'] = $totalPrecoProduto;

        $this->recalcularTotalFactura($qty);

        $this->facturaAlterada = $this->notaCredito['factura'];
    }

    public function recalcularTotalFactura($qty)
    {

        $facturaItems =  $this->notaCredito['factura']['facturas_items'];

        $this->notaCredito['factura']['retencao'] = 0;
        $this->notaCredito['factura']['total_iva'] = 0;
        $this->notaCredito['factura']['desconto'] = 0;
        $this->notaCredito['factura']['total_incidencia'] = 0;
        $this->notaCredito['factura']['numeroItems'] = 0;
        $this->notaCredito['factura']['total_preco_factura'] = 0;
        $this->notaCredito['factura']['troco'] = 0;

        $numeroItens = 0;

        foreach ($facturaItems as $key => $factura) {

            if (isset($factura['qty_atual']) && $factura['qty_atual'] > 0) {
                $numeroItens++;
                $this->notaCredito['factura']['numeroItems'] = $numeroItens;
            }
            $this->notaCredito['factura']['retencao'] += $factura['retencao_produto'];
            $this->notaCredito['factura']['total_iva'] += $factura['iva_produto'];
            $this->notaCredito['factura']['desconto'] += $factura['desconto_produto'];
            $this->notaCredito['factura']['total_incidencia'] += $factura['incidencia_produto'];

            if (!isset($factura['qty_atual'])) {
                $this->notaCredito['factura']['facturas_items'][$key]['qty_atual'] = $factura['quantidade_produto'];
            }
            $this->notaCredito['factura']['total_preco_factura'] += $factura['total_preco_produto'];
        }
        $totalPrecoFactura = $this->notaCredito['factura']['total_preco_factura'];
        $totalIva = $this->notaCredito['factura']['total_iva'];
        $totalDesconto = $this->notaCredito['factura']['desconto'];
        $totalRetencao = $this->notaCredito['factura']['retencao'];
        $valorEntregue = $this->notaCredito['factura']['valor_entregue'];

        $valorPagar = $totalPrecoFactura + $totalIva - ($totalDesconto + $totalRetencao);

        $this->notaCredito['factura']['valor_a_pagar'] = $valorPagar;


        if ($valorEntregue) {
            $this->notaCredito['factura']['troco'] = $valorEntregue -  $this->notaCredito['factura']['valor_a_pagar'];
        } else {
            $this->notaCredito['factura']['troco'] = 0;
        }

        $f = new NumberFormatter("pt", NumberFormatter::SPELLOUT);
        $this->notaCredito['factura']['valor_extenso'] = $f->format($this->notaCredito['factura']['valor_a_pagar']);
    }


    public function emitirNotaCreditoRetificacaoFactura()
    {

        $facturaId = $this->notaCredito['factura']['id'];
        $factura = $this->facturaAlterada;

        if (!$factura) {
            $this->confirm('Não foi retificado nenhum item da factura', [
                'showConfirmButton' => 'ok',
                'showCancelButton' => false,
                'icon' => 'warning'
            ]);
            return;
        }


        $rules = [
            'notaCredito.descricao' => 'required',
            'facturaSearch' => [function ($attr, $facturaSearch, $fail) use ($facturaId, $factura) {
                if ($this->facturaRepository->verificarSeFacturaFoiRetificadoOuAnulado($facturaId)) {
                    $this->confirm('factura já foi retificado ou anulado', [
                        'showConfirmButton' => 'ok',
                        'showCancelButton' => false,
                        'icon' => 'warning'
                    ]);
                    return;
                } else if ($this->facturaRepository->verificarSeRectificouFacturaNaTotalidade($factura)) {
                    $this->confirm('Não é permitido zero todos item, anula a factura', [
                        'showConfirmButton' => 'ok',
                        'showCancelButton' => false,
                        'icon' => 'warning'
                    ]);
                    return;
                } else if ($this->facturaRepository->verificarSeFoiAlteradoItemFactura($facturaId, $factura)) {
                    $this->confirm('Não foi alterado nenhum item da factura', [
                        'showConfirmButton' => 'ok',
                        'showCancelButton' => false,
                        'icon' => 'warning'
                    ]);
                    return;
                } else if (!$this->notaCredito['factura'] or !$this->facturaSearch) {
                    $this->confirm('Factura não encontrada', [
                        'showConfirmButton' => 'ok',
                        'showCancelButton' => false,
                        'icon' => 'warning'
                    ]);
                    return;
                } else if ($this->facturaRepository->verificarFacturaContemRecibo($this->notaCredito['factura']['id'])) {
                    $this->confirm('Está factura contém recibo, deves anular o recibo', [
                        'showConfirmButton' => 'ok',
                        'showCancelButton' => false,
                        'icon' => 'warning'
                    ]);
                    return;
                }
            }]
        ];
        $messages = [
            'notaCredito.descricao.required' => 'Informe uma observação'
        ];

        $this->validate($rules, $messages);

        $factura['valor_cash'] = $factura['formas_pagamento_id'] == 1 ? $factura['valor_a_pagar'] : 0;



        $verificadorDocumento = new VerificadorDocumento('facturas');
        if (!$verificadorDocumento->comparaDataDocumentoAnteriorComActual()) {
            return [
                $this->confirm('Existe um documento com data superior á data actual', [
                    'showConfirmButton' => 'OK',
                    'showCancelButton' => false

                ])
            ];
        }

        //Faltando verificar se já foi emitido documento com datas anterior
        $this->facturaRepository->salvarFacturaOriginal($facturaId);
        $this->facturaRepository->retificarFactura($factura);
        $notaCredito = $this->notaCreditoRetificacaoDocumentoRepository->salvarNotaCreditoRetificacaoFactura($factura, $this->notaCredito['descricao']);

                // dd($notaCredito);
        $this->setarValorInicial();
        $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
        $caminho = public_path() . '/upload/documentos/empresa/relatorios/';
        $this->confirm('Operação Realizado com sucesso', [
            'showConfirmButton' => false,
            'showCancelButton' => false,
            'icon' => 'success'

        ]);

        $reportController = new ReportShowController();
        $report = $reportController->show(
            [
                'report_file' => 'documento_retificadoFacturas',
                'report_jrxml' => 'documento_retificadoFacturas.jrxml',
                'report_parameters' => [
                    'viaImpressao' => 2,
                    'empresa_id' => auth()->user()->empresa_id,
                    'facturaId' => $facturaId,
                    'docAnuladoId' => $notaCredito,
                    'logotipo' => $logotipo,
                    'DIR_SUBREPORT' => $caminho,
                    'dirSubreportBanco' => $caminho,
                ]

            ]
        );

        $this->dispatchBrowserEvent('printPdf', ['data' => base64_encode($report['response']->getContent())]);
        unlink($report['filename']);
        flush();
    }
    public function setarValorInicial()
    {

        $this->facturaSearch = NULL;
        $this->saldoCliente = 0;
        $this->notaCredito['descricao'] = NULL;
        $this->notaCredito['factura']['nome_do_cliente'] = NULL;
        $this->notaCredito['factura']['nif_cliente'] = NULL;
        $this->notaCredito['factura']['conta_corrente_cliente'] = NULL;
        $this->notaCredito['factura']['factura']['numeracaoFactura'] = NULL;
        $this->notaCredito['factura']['valor_total_entregue'] = NULL;
        $this->factura['created_at'] = NULL;
        $this->notaCredito['factura']['total_preco_factura'] = NULL;
        $this->notaCredito['factura']['desconto'] = NULL;
        $this->notaCredito['factura']['retencao'] = NULL;
        $this->notaCredito['factura']['total_iva'] = NULL;
        $this->notaCredito['factura']['valor_a_pagar'] = NULL;
        $this->notaCredito['factura']['valor_entregue'] = NULL;
        $this->notaCredito['factura']['troco'] = NULL;
        $this->notaCredito['descricao'] = NULL;
        $this->notaCredito['factura']['facturas_items'] = [];
    }
}
