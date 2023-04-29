<?php

namespace App\Http\Controllers\Empresa;

use App\Http\Controllers\Controller;
use App\Models\Empresa\Factura;
use App\Models\Empresa\FacturaOriginal;
use App\Models\Empresa\NotaCredito;
use App\Models\Empresa\Produto;
use App\Models\empresa\Recibos;
use App\Traits\Empresa\TraitAtivacaoLicenca;
use Carbon\Carbon;
use DateTime;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response as FacadesResponse;

class GerarSaftController extends Controller
{

    use TraitAtivacaoLicenca;


    public function index()
    {


        // $infoNotificacao = $this->alertarActivacaoLicenca();

        // dd($infoNotificacao);
        // $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        // if ($infoNotificacao['diasRestantes'] != NULL && $infoNotificacao['diasRestantes'] <= 0) {
        //     return redirect("/home");
        // }
        $data = [];

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $data['guard'] = $empresa['guard'];


        // $user = auth()->user();
        // if (!$user->can('gerar_ficheiro_saft')) {
        //     return view('empresa.acessoNegado.index', $data);
        // }
        return view('empresa.gerarSaft.index', $data);
    }

    public function gerarSaft(Request $request)
    {

        $StartDate = date("Y-m-d", strtotime($request->dataInicio));
        $EndDate = date("Y-m-d", strtotime($request->dataFinal));


       

        // $StartDate = "2022-10-04 00:00";
        // $EndDate = "2022-10-04 20:00";

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $root = $dom->createElement('AuditFile');
        $root->setAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");
        $root->setAttribute('xsi:schemaLocation', "urn:OECD:StandardAuditFile-Tax:AO_1.01_01 SAFTAO1.01_01.xsd");
        $root->setAttribute('xmlns', "urn:OECD:StandardAuditFile-Tax:AO_1.01_01");
        $dom->appendChild($root);

        $header = $dom->createElement('Header');
        $header->appendChild($dom->createElement('AuditFileVersion', '1.01_01'));

        $empresa_software = DB::connection('mysql')->table('empresas')->where('id', 1)->first();

        $header->appendChild($dom->createElement('CompanyID', $empresa_software->nif));
        $header->appendChild($dom->createElement('TaxRegistrationNumber', $empresa_software->nif));
        $header->appendChild($dom->createElement('TaxAccountingBasis', 'F'));
        $header->appendChild($dom->createElement('CompanyName', $empresa_software->nome));
        $header->appendChild($dom->createElement('BusinessName', $empresa_software->nome));
        //create companyAddress
        $companyAddress = $dom->createElement('CompanyAddress');
        $companyAddress->appendChild($dom->createElement('AddressDetail', $empresa_software->endereco));
        $companyAddress->appendChild($dom->createElement('City', $empresa_software->cidade));
        $companyAddress->appendChild($dom->createElement('Country', 'AO'));
        $header->appendChild($companyAddress);
        $header->appendChild($dom->createElement('FiscalYear', Carbon::parse(Carbon::now())->format('Y')));
        $header->appendChild($dom->createElement('StartDate', date_format(date_create($StartDate), "Y-m-d")));
        $header->appendChild($dom->createElement('EndDate', date_format(date_create($EndDate), "Y-m-d")));
        $header->appendChild($dom->createElement('CurrencyCode', 'AOA'));

        $dateNow = date_format(new DateTime(Carbon::now()->addHour()->toDateTimeString()), 'Y-m-d');
        $header->appendChild($dom->createElement('DateCreated', $dateNow));
        $header->appendChild($dom->createElement('TaxEntity', 'Global'));
        $header->appendChild($dom->createElement('ProductCompanyTaxID', $empresa_software->nif));
        $header->appendChild($dom->createElement('SoftwareValidationNumber', '32/AGT/2019'));
        $header->appendChild($dom->createElement('ProductID', 'WinMarket Pro/OSVALDO MANUEL RAMOS-RAMOS SOFT P. DE SERVICOS'));
        $header->appendChild($dom->createElement('ProductVersion', '1.0.0'));
        $header->appendChild($dom->createElement('Telephone', $empresa_software->pessoal_Contacto));
        $header->appendChild($dom->createElement('Email', $empresa_software->email));
        $header->appendChild($dom->createElement('Website', $empresa_software->website));
        $root->appendChild($header);

        //MasterFiles
        $masterFiles = $dom->createElement('MasterFiles');

        $clientes = DB::table('clientes')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->orwhere('empresa_id', NULL)
            ->get();

        $consumidor_final = DB::connection('mysql2')->table('clientes')->where('empresa_id', auth()->user()->empresa_id)->first();


        foreach ($clientes as $key => $cliente) {
            if ($cliente->nif == '999999999') {
                $CustomerID = $consumidor_final->id;
                $AccountID = "Desconhecido";
                $CustomerTaxID = $consumidor_final->nif;
                $CompanyName = "Consumidor Final";
                $AddressDetail = "Desconhecido";
                $City = "Desconhecido";
                $PostalCode = "Desconhecido";
                $Country = "Desconhecido";
                ++$key;
                if ($key > 1) {
                    continue;
                }
            } else {
                $CustomerID = $cliente->id;
                $AccountID =  $cliente->conta_corrente;
                $CustomerTaxID = $cliente->nif;
                $CompanyName = $cliente->nome;
                $AddressDetail = $cliente->endereco;
                $City = $cliente->cidade;
                $PostalCode = "*";
                $Country = "AO";
            }

            $customer = $dom->createElement('Customer');
            $customer->appendChild($dom->createElement('CustomerID', $CustomerID));
            $customer->appendChild($dom->createElement('AccountID', $AccountID));
            $customer->appendChild($dom->createElement('CustomerTaxID', $CustomerTaxID));
            $customer->appendChild($dom->createElement('CompanyName', $CompanyName));
            //BillingAddress
            $billingAddress = $dom->createElement('BillingAddress');
            $billingAddress->appendChild($dom->createElement('AddressDetail', $AddressDetail));
            $billingAddress->appendChild($dom->createElement('City', $City));
            $billingAddress->appendChild($dom->createElement('PostalCode', $PostalCode));
            $billingAddress->appendChild($dom->createElement('Country', $Country));
            $customer->appendChild($billingAddress);
            $customer->appendChild($dom->createElement('SelfBillingIndicator', 0));
            $masterFiles->appendChild($customer);
        }
        $root->appendChild($masterFiles);

        $produtos = Produto::with(['tipoTaxa'])->where('empresa_id', auth()->user()->empresa_id)->get();

        foreach ($produtos as $key => $produto) {
            $product = $dom->createElement('Product');
            $product->appendChild($dom->createElement('ProductType', 'P'));
            $product->appendChild($dom->createElement('ProductCode', $produto->id));
            $product->appendChild($dom->createElement('ProductGroup', 'N/A'));
            $product->appendChild($dom->createElement('ProductDescription', $produto->designacao));
            $product->appendChild($dom->createElement('ProductNumberCode', $produto->id));
            $masterFiles->appendChild($product);
        }
        //listar taxas sem repetição dos produtos listado acima
        $taxas = $this->listarTaxas($produtos);

        $taxTable = $dom->createElement('TaxTable');

        foreach ($taxas as $key => $tipoTaxa) {

            $TaxType = $tipoTaxa->taxa ? "IVA" : "NS";
            $TaxCode = $tipoTaxa->taxa ? "NOR" : "ISE";
            $Description = $tipoTaxa->taxa ? "Taxa Normal" : "Isenta";
            $TaxPercentage = $tipoTaxa->taxa;

            $taxTableEntry = $dom->createElement('TaxTableEntry');
            $taxTableEntry->appendChild($dom->createElement('TaxType', $TaxType));
            $taxTableEntry->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
            $taxTableEntry->appendChild($dom->createElement('TaxCode', $TaxCode));
            $taxTableEntry->appendChild($dom->createElement('Description', $Description));
            $taxTableEntry->appendChild($dom->createElement('TaxPercentage', $TaxPercentage));
            $taxTable->appendChild($taxTableEntry);
        }
        $masterFiles->appendChild($taxTable);


        // QDT FT E FR (STARTDATE E ENDDATE)
        $quantFtFr = DB::connection('mysql2')->table('facturas')
            ->whereBetween(DB::raw('DATE(facturas.created_at)'), array($StartDate, $EndDate))
            ->where('empresa_id', Auth::user()->empresa_id)
            ->where(function ($query) {
                $query->where('facturas.tipo_documento', 1)
                    ->orWhere('facturas.tipo_documento', 2);
            })
            ->count();

        //OBS: adicionar aqui Qtds notas de creditos (facturas e facturas recibos anulados ou retificados)

        $TotalCredit = DB::table('facturas')->whereBetween(DB::raw('DATE(created_at)'), array($StartDate, $EndDate))
            ->where('empresa_id', Auth::user()->empresa_id)
            ->where('anulado', 2)
            ->where(function ($query) {
                $query->orwhere('facturas.tipo_documento', 1)
                    ->orWhere('facturas.tipo_documento', 2);
            })
            ->sum('total_incidencia');

        $sourceDocuments = $dom->createElement('SourceDocuments');
        $salesInvoices = $dom->createElement('SalesInvoices');


        //LISTAR FACTURAS E FACTURAS RECIBOS
        $facturas = Factura::with(['facturas_items', 'formaPagamento', 'facturas_items.produto', 'facturas_items.produto.unidade', 'facturas_items.produto.motivoIsencao', 'tipoDocumento'])
            ->whereBetween(DB::raw('DATE(created_at)'), array($StartDate, $EndDate))
            ->where('empresa_id', Auth::user()->empresa_id)
            ->where(function ($query) {
                $query->where('facturas.tipo_documento', 1)
                    ->orWhere('facturas.tipo_documento', 2);
            })->get();

        $clienteDiverso = DB::table('clientes')->where('empresa_id', auth()->user()->empresa_id)->first();

        $TotalCredit = 0;
        $notaCreditoIDs = [];

        $invoiceFTEFRs = [];

        foreach ($facturas as $key => $factura) {

            if ($factura->anulado == 2) {
                array_push($notaCreditoIDs, $factura->id);
            }
            if ($factura->retificado == 'Sim') {
                $factura = FacturaOriginal::with(['facturas_items', 'formaPagamento', 'facturas_items.produto', 'facturas_items.produto.unidade', 'facturas_items.produto.motivoIsencao', 'tipoDocumento'])
                    ->whereBetween(DB::raw('DATE(created_at)'), array($StartDate, $EndDate))
                    ->where('empresa_id', Auth::user()->empresa_id)
                    ->where('id', $factura->id)->first();
                array_push($notaCreditoIDs, $factura->id);
            }

            $InvoiceNo = $factura->numeracaoFactura;
            $InvoiceStatusDate = $factura->created_at;
            $SourceID = $factura->user_id;
            $Hash = $factura->hashValor;
            $InvoiceDate = Carbon::parse($factura->created_at)->format('Y-m-d');
            $InvoiceType = $factura->tipoDocumento->sigla;
            $SystemEntryDate = str_replace(' ', 'T', $factura->created_at);
            $CustomerID = $factura->nif_cliente == '999999999' ? $clienteDiverso->id : $factura->cliente_id;

            $invoice = $dom->createElement('Invoice');
            $invoice->appendChild($dom->createElement('InvoiceNo', $InvoiceNo));
            $documentStatus = $dom->createElement('DocumentStatus');
            $InvoiceStatus = $factura->anulado == 2 ? "A" : "N";
            $documentStatus->appendChild($dom->createElement('InvoiceStatus', $InvoiceStatus));
            $documentStatus->appendChild($dom->createElement('InvoiceStatusDate', (Carbon::parse($InvoiceStatusDate)->format('Y-m-d') . "T" . Carbon::parse($InvoiceStatusDate)->format("H:i:s"))));
            $documentStatus->appendChild($dom->createElement('SourceID', $SourceID));
            $documentStatus->appendChild($dom->createElement('SourceBilling', 'P'));
            $invoice->appendChild($documentStatus); //Add documentStatus no Invoice
            $invoice->appendChild($dom->createElement('Hash', $Hash));
            $invoice->appendChild($dom->createElement('HashControl', '1'));
            $invoice->appendChild($dom->createElement('Period', Carbon::parse($StartDate)->format('m')));
            $invoice->appendChild($dom->createElement('InvoiceDate', $InvoiceDate));
            $invoice->appendChild($dom->createElement('InvoiceType', $InvoiceType));
            $specialRegimes = $dom->createElement('SpecialRegimes');
            $specialRegimes->appendChild($dom->createElement('SelfBillingIndicator', 0));
            $specialRegimes->appendChild($dom->createElement('CashVATSchemeIndicator', 0));
            $specialRegimes->appendChild($dom->createElement('ThirdPartiesBillingIndicator', 0));
            $invoice->appendChild($specialRegimes); //add specialRegimes no Invoice
            $invoice->appendChild($dom->createElement('SourceID', $SourceID));
            $invoice->appendChild($dom->createElement('SystemEntryDate', $SystemEntryDate));
            $invoice->appendChild($dom->createElement('CustomerID', $CustomerID));
            //Criar Line de Invoice foreach
            foreach ($factura->facturas_items as $key => $Item) {


                $Item = (object) $Item;
                $line = $dom->createElement('Line');
                $line->appendChild($dom->createElement('LineNumber', $key + 1));
                $line->appendChild($dom->createElement('ProductCode', $Item->produto_id));
                $line->appendChild($dom->createElement('ProductDescription', $Item->descricao_produto));
                $line->appendChild($dom->createElement('Quantity', number_format($Item->quantidade_produto, 1, ".", "")));
                $line->appendChild($dom->createElement('UnitOfMeasure', ($Item->produto->unidade->designacao ? $Item->produto->unidade->designacao : "un")));
                $line->appendChild($dom->createElement('UnitPrice', number_format($Item->incidencia_produto / $Item->quantidade_produto, 2, ".", "")));
                $line->appendChild($dom->createElement('TaxPointDate', Carbon::parse($factura->created_at)->format('Y-m-d')));
                $Description = $factura->descricao ? $factura->descricao : 'FACTURA ' . $factura->numeracaoFactura;
                $line->appendChild($dom->createElement('Description', $Description));
                $line->appendChild($dom->createElement('CreditAmount', number_format($Item->incidencia_produto, 2, ".", "")));


                if ($Item->produto->tipoTaxa->taxa > 0) {
                    $TaxType = "IVA";
                    //se foi aplicado IVA seta vazio
                    $TaxExemptionReason = "#";
                    $TaxExemptionCode = "#";
                } else {
                    $TaxType = "NS";
                    //se não foi aplicado iva seta valores
                    $TaxExemptionReason = $Item->produto->motivoIsencao->descricao;
                    $TaxExemptionCode = $Item->produto->motivoIsencao->codigoMotivo;
                }
                $TaxCode = $Item->produto->tipoTaxa->taxa ? "NOR" : ($TaxType == "NS" ? "NS" : "ISE");
                $Description = $Item->produto->tipoTaxa->taxa ? "Taxa Normal" : "Isenta";
                $TaxPercentage = $Item->produto->tipoTaxa->taxa;

                //Criar Taixa e seus filhos
                $tax = $dom->createElement('Tax');
                $tax->appendChild($dom->createElement('TaxType', $TaxType));
                $tax->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
                $tax->appendChild($dom->createElement('TaxCode', $TaxCode));
                $tax->appendChild($dom->createElement('TaxPercentage', $TaxPercentage));
                $line->appendChild($tax); //Add Fax na Line
                $line->appendChild($dom->createElement('TaxExemptionReason', $TaxExemptionReason));
                $line->appendChild($dom->createElement('TaxExemptionCode', $TaxExemptionCode));
                $line->appendChild($dom->createElement('SettlementAmount', $Item->desconto_produto));
                $invoice->appendChild($line);
            }

            if ($factura->anulado == 1) {
                $TotalCredit += $factura->total_incidencia;
            }

            //criar  DocumentTotals e seus filhos
            $documentTotals = $dom->createElement('DocumentTotals');
            $documentTotals->appendChild($dom->createElement('TaxPayable', number_format($factura->total_iva, 2, ".", "")));
            $documentTotals->appendChild($dom->createElement('NetTotal', number_format($factura->total_incidencia, 2, ".", "")));

            $GrossTotal = $factura->valor_a_pagar + $factura->retencao;

            $documentTotals->appendChild($dom->createElement('GrossTotal', number_format($GrossTotal, 2, ".", "")));
            $invoice->appendChild($documentTotals);
            $payment = $dom->createElement('Payment');
            $PaymentMechanism = $factura->formaPagamento ? $factura->formaPagamento->sigla_tipo_pagamento : "OU";



            $payment->appendChild($dom->createElement('PaymentMechanism', $PaymentMechanism));
            $payment->appendChild($dom->createElement('PaymentAmount', number_format($factura->valor_a_pagar, 2, ".", "")));
            $payment->appendChild($dom->createElement('PaymentDate', Carbon::parse($factura->created_at)->format('Y-m-d')));
            $documentTotals->appendChild($payment);
            // $salesInvoices->appendChild($invoice);
            $invoiceFTEFRs[] = $invoice;
            // $salesInvoices->appendChild($invoice);
            //Fim foreach
        }

        //Notas de crédito
        $notaCreditos = NotaCredito::with([
            'notaCreditoItems',
            'factura', 'notaCreditoItems.produto',
            'notaCreditoItems.produto.unidade',
            'notaCreditoItems.produto.tipoTaxa',
            'notaCreditoItems.produto.motivoIsencao',
            'tipoDocumento'
        ])
            ->where('empresa_id', Auth::user()->empresa_id)
            ->whereIn('facturaId', $notaCreditoIDs)->get();


        $TotalDebit = 0;
        $TotalDebit = 0;

        if ($notaCreditos) {
            $invoiceNCs = [];
            $quantNotaCredito = 0;
            foreach ($notaCreditos as $key => $notaCredito) {

                $quantNotaCredito++;

                $InvoiceNo = $notaCredito->numeracaoDocumento;
                $InvoiceStatusDate = $notaCredito->created_at;
                $SourceID = $notaCredito->user_id;
                $Hash = $notaCredito->hash;
                $InvoiceDate = Carbon::parse($notaCredito->factura->created_at)->format('Y-m-d');
                $SystemEntryDate = str_replace(' ', 'T', $notaCredito->created_at);
                $CustomerID = $notaCredito->nif_cliente == '999999999' ? $clienteDiverso->id : $notaCredito->cliente_id;

                $invoice = $dom->createElement('Invoice');
                $invoice->appendChild($dom->createElement('InvoiceNo', $InvoiceNo));
                $documentStatus = $dom->createElement('DocumentStatus');
                $documentStatus->appendChild($dom->createElement('InvoiceStatus', "N"));
                $documentStatus->appendChild($dom->createElement('InvoiceStatusDate', (Carbon::parse($InvoiceStatusDate)->format('Y-m-d') . "T" . Carbon::parse($InvoiceStatusDate)->format("H:i:s"))));
                $documentStatus->appendChild($dom->createElement('SourceID', $SourceID));
                $documentStatus->appendChild($dom->createElement('SourceBilling', 'P'));
                $invoice->appendChild($documentStatus); //Add documentStatus no Invoice
                $invoice->appendChild($dom->createElement('Hash', $Hash));
                $invoice->appendChild($dom->createElement('HashControl', '1'));
                $invoice->appendChild($dom->createElement('Period', Carbon::parse($StartDate)->format('m')));
                $invoice->appendChild($dom->createElement('InvoiceDate', $InvoiceDate));
                $invoice->appendChild($dom->createElement('InvoiceType', 'NC'));
                $specialRegimes = $dom->createElement('SpecialRegimes');
                $specialRegimes->appendChild($dom->createElement('SelfBillingIndicator', 0));
                $specialRegimes->appendChild($dom->createElement('CashVATSchemeIndicator', 0));
                $specialRegimes->appendChild($dom->createElement('ThirdPartiesBillingIndicator', 0));
                $invoice->appendChild($specialRegimes); //add specialRegimes no Invoice
                $invoice->appendChild($dom->createElement('SourceID', $SourceID));
                $invoice->appendChild($dom->createElement('SystemEntryDate', $SystemEntryDate));
                $invoice->appendChild($dom->createElement('CustomerID', $CustomerID));
                //Criar Line de Invoice foreach

                foreach ($notaCredito->notaCreditoItems as $key => $Item) {

                    $Item = (object) $Item;
                    $line = $dom->createElement('Line');
                    $line->appendChild($dom->createElement('LineNumber', $key + 1));
                    $line->appendChild($dom->createElement('ProductCode', $Item->produto_id));
                    $line->appendChild($dom->createElement('ProductDescription', $Item->descricao_produto));
                    $line->appendChild($dom->createElement('Quantity', number_format($Item->quantidade_produto, 1, ".", "")));
                    $line->appendChild($dom->createElement('UnitOfMeasure', ($Item->produto->unidade ? $Item->produto->unidade->designacao : "un")));
                    $line->appendChild($dom->createElement('UnitPrice', number_format($Item->incidencia_produto / $Item->quantidade_produto, 2, ".", "")));
                    $line->appendChild($dom->createElement('TaxPointDate', Carbon::parse($notaCredito->created_at)->format('Y-m-d')));
                    $Description = $notaCredito->descricao ? $notaCredito->descricao : 'FACTURA ANULADA OU RETIFICADA ' . $notaCredito->factura->numeracaoFactura;
                    $References = $dom->createElement('References');
                    $References->appendChild($dom->createElement('Reference', $notaCredito->factura->numeracaoFactura));
                    $References->appendChild($dom->createElement('Reason', $Description));
                    $line->appendChild($References);
                    $line->appendChild($dom->createElement('Description', $Description));
                    $line->appendChild($dom->createElement('DebitAmount', number_format($Item->incidencia_produto, 2, ".", "")));



                    if ($Item->produto->tipoTaxa->taxa > 0) {
                        $TaxType = "IVA";
                        //se foi aplicado IVA seta vazio
                        $TaxExemptionReason = "#";
                        $TaxExemptionCode = "#";
                    } else {
                        $TaxType = "NS";
                        //se não foi aplicado iva seta valores
                        $TaxExemptionReason = $Item->produto->motivoIsencao->descricao;
                        $TaxExemptionCode = $Item->produto->motivoIsencao->codigo_motivo;
                    }
                    $TaxCode = $Item->produto->tipoTaxa->taxa ? "NOR" : ($TaxType == "NS" ? "NS" : "ISE");
                    $Description = $Item->produto->tipoTaxa->taxa ? "Taxa Normal" : "Isenta";
                    $TaxPercentage = $Item->produto->tipoTaxa->taxa;

                    $TaxExemptionCode = $TaxExemptionCode ?? 'M02';

                    //Criar Taixa e seus filhos
                    $tax = $dom->createElement('Tax');
                    $tax->appendChild($dom->createElement('TaxType', $TaxType));
                    $tax->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
                    $tax->appendChild($dom->createElement('TaxCode', $TaxCode));
                    $tax->appendChild($dom->createElement('TaxPercentage', number_format($TaxPercentage, 1, ".", "")));
                    $line->appendChild($tax); //Add Fax na Line
                    $line->appendChild($dom->createElement('TaxExemptionReason', $TaxExemptionReason));
                    $line->appendChild($dom->createElement('TaxExemptionCode', $TaxExemptionCode));
                    $line->appendChild($dom->createElement('SettlementAmount', $Item->desconto_produto));
                    $invoice->appendChild($line);
                }

                $TotalDebit += $notaCredito->total_incidencia;


                if ($notaCredito->anulado == 1) { //Não anulado
                    $TotalCredit += $notaCredito->total_incidencia;
                }


                //criar  DocumentTotals e seus filhos
                $documentTotals = $dom->createElement('DocumentTotals');
                $documentTotals->appendChild($dom->createElement('TaxPayable', number_format($notaCredito->total_iva, 2, ".", "")));
                $documentTotals->appendChild($dom->createElement('NetTotal', number_format($notaCredito->total_incidencia, 2, ".", "")));

                $GrossTotal = $notaCredito->valor_a_pagar + $notaCredito->retencao;

                $documentTotals->appendChild($dom->createElement('GrossTotal', number_format($GrossTotal, 2, ".", "")));
                $invoice->appendChild($documentTotals);
                $payment = $dom->createElement('Payment');
                $PaymentMechanism = $factura->formaPagamento ? $factura->formaPagamento->sigla_tipo_pagamento : "OU";

                $payment->appendChild($dom->createElement('PaymentMechanism', $PaymentMechanism));
                $payment->appendChild($dom->createElement('PaymentAmount', number_format($notaCredito->valor_a_pagar, 2, ".", "")));
                $payment->appendChild($dom->createElement('PaymentDate', Carbon::parse($notaCredito->created_at)->format('Y-m-d')));
                $documentTotals->appendChild($payment);

                // $salesInvoices->appendChild($invoice);

                $invoiceNCs[] = $invoice;
            }
        }

        $NumberOfEntries =  $quantFtFr + $quantNotaCredito;
        $salesInvoices->appendChild($dom->createElement('NumberOfEntries', $NumberOfEntries));
        $salesInvoices->appendChild($dom->createElement('TotalDebit', number_format($TotalDebit, 2, ".", "")));
        $salesInvoices->appendChild($dom->createElement('TotalCredit', number_format($TotalCredit, 2, ".", "")));
        $sourceDocuments->appendChild($salesInvoices);


        //faz o array para colocar os invoices enbaixo das NumberOfEntries
        foreach ($invoiceFTEFRs as $invoiceFTEFR) {
            $salesInvoices->appendChild($invoiceFTEFR);
        }
        foreach ($invoiceNCs as $invoiceNC) {
            $salesInvoices->appendChild($invoiceNC);
        }
        //MovementOfGoods
        $movementOfGoods = $dom->createElement('MovementOfGoods');
        $movementOfGoods->appendChild($dom->createElement('NumberOfMovementLines', 0));
        $movementOfGoods->appendChild($dom->createElement('TotalQuantityIssued', 0.00));
        $sourceDocuments->appendChild($movementOfGoods);
        //fim MovementOfGoods

        //Lista apenas facturas proformas
        $countFtProforma = Factura::where('empresa_id', auth()->user()->empresa_id)->where('tipo_documento', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), array($StartDate, $EndDate))
            ->count();

        $TotalDebit = 0;
        $TotalCredit = 0;

        $facturas_proforma = Factura::with(['facturas_items', 'formaPagamento', 'facturas_items.produto', 'facturas_items.produto.unidade', 'facturas_items.produto.motivoIsencao', 'tipoDocumento'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('tipo_documento', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), array($StartDate, $EndDate))
            ->get();

        $TotalCredit = Factura::with(['facturas_items', 'formaPagamento', 'facturas_items.produto', 'facturas_items.produto.unidade', 'facturas_items.produto.motivoIsencao', 'tipoDocumento'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('tipo_documento', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), array($StartDate, $EndDate))
            ->sum('total_incidencia');

        $workingDocuments = $dom->createElement('WorkingDocuments');

        $workingDocuments->appendChild($dom->createElement('NumberOfEntries', $countFtProforma));
        $workingDocuments->appendChild($dom->createElement('TotalDebit', $TotalDebit));
        $workingDocuments->appendChild($dom->createElement('TotalCredit', number_format($TotalCredit, 2, ".", "")));
        $sourceDocuments->appendChild($workingDocuments);

        foreach ($facturas_proforma as $key => $facturaProforma) {

            $WorkDocument = $dom->createElement('WorkDocument');
            $DocumentNumber = str_replace("FP", "PP", $facturaProforma->numeracaoFactura);
            $WorkDocument->appendChild($dom->createElement('DocumentNumber', $DocumentNumber));
            $DocumentStatus = $dom->createElement('DocumentStatus');

            $DocumentStatus->appendChild($dom->createElement('WorkStatus', 'N'));
            $DocumentStatus->appendChild($dom->createElement('WorkStatusDate', (Carbon::parse($facturaProforma->updated_at)->format('Y-m-d') . "T" . Carbon::parse($facturaProforma->updated_at)->format("H:i:s"))));
            $DocumentStatus->appendChild($dom->createElement('Reason', '#'));
            $DocumentStatus->appendChild($dom->createElement('SourceID', $facturaProforma->user_id));
            $DocumentStatus->appendChild($dom->createElement('SourceBilling', 'P'));
            $WorkDocument->appendChild($DocumentStatus);
            $WorkDocument->appendChild($dom->createElement('Hash', $facturaProforma->hashValor));
            $WorkDocument->appendChild($dom->createElement('HashControl', '1'));
            $WorkDocument->appendChild($dom->createElement('Period', Carbon::parse($StartDate)->format('m')));
            $WorkDocument->appendChild($dom->createElement('WorkDate', Carbon::parse($facturaProforma->created_at)->format('Y-m-d')));
            $WorkDocument->appendChild($dom->createElement('WorkType', 'PP'));
            $WorkDocument->appendChild($dom->createElement('SourceID', $facturaProforma->user_id));
            $WorkDocument->appendChild($dom->createElement('SystemEntryDate', (Carbon::parse($facturaProforma->created_at)->format('Y-m-d') . "T" . Carbon::parse($facturaProforma->created_at)->format("H:i:s"))));
            $WorkDocument->appendChild($dom->createElement('TransactionID', '#'));
            $WorkDocument->appendChild($dom->createElement('CustomerID', (string) ($facturaProforma->cliente->nif == '999999999' ? $clienteDiverso->id : $facturaProforma->cliente_id)));


            foreach ($facturaProforma->facturas_items as $key => $ftProformaItem) {

                $line = $dom->createElement('Line');
                $line->appendChild($dom->createElement('LineNumber', $key + 1));
                $line->appendChild($dom->createElement('ProductCode', $ftProformaItem->produto_id));
                $line->appendChild($dom->createElement('ProductDescription', $ftProformaItem->descricao_produto));
                $line->appendChild($dom->createElement('Quantity', number_format($ftProformaItem->quantidade_produto, 1, ".", "")));
                $line->appendChild($dom->createElement('UnitOfMeasure', ($ftProformaItem->produto->unidade->designacao ? $ftProformaItem->produto->unidade->designacao : "un")));
                $line->appendChild($dom->createElement('UnitPrice', number_format($ftProformaItem->incidencia_produto / $ftProformaItem->quantidade_produto, 2, ".", "")));
                $line->appendChild($dom->createElement('TaxPointDate', Carbon::parse($facturaProforma->created_at)->format('Y-m-d')));
                $line->appendChild($dom->createElement('Description', $facturaProforma->descricao ? $facturaProforma->descricao : 'FACTURA ' . $factura->numeracaoFactura));
                $line->appendChild($dom->createElement('CreditAmount', number_format($ftProformaItem->incidencia_produto, 2, ".", "")));

                if ($ftProformaItem->produto->tipoTaxa->taxa > 0) {
                    $TaxType = "IVA";
                    //se foi aplicado IVA seta vazio
                    $TaxExemptionReason = "#";
                    $TaxExemptionCode = "#";
                } else {
                    $TaxType = "NS";
                    //se não foi aplicado iva seta valores
                    $TaxExemptionReason = $ftProformaItem->produto->motivoIsencao->descricao;
                    $TaxExemptionCode = $ftProformaItem->produto->motivoIsencao->codigoMotivo;
                }
                $TaxCode = $ftProformaItem->produto->tipoTaxa->taxa ? "NOR" : ($TaxType == "NS" ? "NS" : "ISE");
                $Description = $ftProformaItem->produto->tipoTaxa->taxa ? "Taxa Normal" : "Isenta";
                $TaxPercentage = $ftProformaItem->produto->tipoTaxa->taxa;

                //Criar Taxa e seus filhos
                $tax = $dom->createElement('Tax');
                $tax->appendChild($dom->createElement('TaxType', $TaxType));
                $tax->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
                $tax->appendChild($dom->createElement('TaxCode', $TaxCode));
                $tax->appendChild($dom->createElement('TaxPercentage', $TaxPercentage));
                $line->appendChild($tax); //Add Fax na Line
                $line->appendChild($dom->createElement('TaxExemptionReason', $TaxExemptionReason));
                $line->appendChild($dom->createElement('TaxExemptionCode', $TaxExemptionCode));
                $line->appendChild($dom->createElement('SettlementAmount', $ftProformaItem->desconto_produto));
                $WorkDocument->appendChild($line);
            }
            $workingDocuments->appendChild($WorkDocument);

            //criar  DocumentTotals e seus filhos
            $documentTotals = $dom->createElement('DocumentTotals');
            $documentTotals->appendChild($dom->createElement('TaxPayable', number_format($facturaProforma->total_iva, 2, ".", "")));
            $documentTotals->appendChild($dom->createElement('NetTotal', number_format($facturaProforma->total_incidencia, 2, ".", "")));

            $GrossTotal = $facturaProforma->valor_a_pagar + $facturaProforma->retencao;

            $documentTotals->appendChild($dom->createElement('GrossTotal', number_format($GrossTotal, 2, ".", "")));
            $WorkDocument->appendChild($documentTotals);
        }
        /**
         * Preenche SourceDocuments->Payments
         */
        //Qtd de recibos(incluindo os anulados)
        $quantRecibos = DB::table('recibos')
            ->whereBetween(DB::raw('DATE(recibos.created_at)'), array($StartDate, $EndDate))
            ->where('empresa_id', auth()->user()->empresa_id)
            ->count();




        $TotalCredit = DB::table('recibos')
            ->where('anulado', 1) //recibo não anulado
            ->whereBetween(DB::raw('DATE(recibos.created_at)'), array($StartDate, $EndDate))
            ->where('empresa_id', auth()->user()->empresa_id)->sum('valor_total_entregue');




        $TotalDebit = 0;
        $TotalDebit = number_format($TotalDebit, 2, ".", "");
        $TotalCredit = number_format($TotalCredit, 2, ".", "");


        /**
         * Preenche SourceDocuments->Payments->Payment
         */
        $recibos = Recibos::with(['empresa', 'cliente', 'formaPagamento', 'factura'])->where('empresa_id', auth()->user()->empresa_id)
            ->whereBetween(DB::raw('DATE(created_at)'), array($StartDate, $EndDate))
            ->get();


        //Payments
        $payments = $dom->createElement('Payments');
        $payments->appendChild($dom->createElement('NumberOfEntries', $quantRecibos));
        $payments->appendChild($dom->createElement('TotalDebit', $TotalDebit));
        $payments->appendChild($dom->createElement('TotalCredit', $TotalCredit));
        $sourceDocuments->appendChild($payments);

        foreach ($recibos as $key => $recibo) {


            $Payment = $dom->createElement('Payment');
            $Payment->appendChild($dom->createElement('PaymentRefNo', $recibo->numeracao_recibo));
            $Payment->appendChild($dom->createElement('Period', Carbon::parse($StartDate)->format('m')));
            $Payment->appendChild($dom->createElement('TransactionDate', Carbon::parse($recibo->created_at)->format('Y-m-d')));
            $Payment->appendChild($dom->createElement('PaymentType', 'RG'));

            $Description = $recibo->observacao ? $recibo->observacao : 'Liquidação da factura ' . $recibo->factura->numeracaoFactura;

            $Payment->appendChild($dom->createElement('Description', $Description));
            $Payment->appendChild($dom->createElement('SystemID', $recibo->id));
            $payments->appendChild($Payment);

            /**
             * Preenche SourceDocuments->Payments->Payment->DocumentStatus
             */

            $PaymentStatus = $recibo->anulado == '1' ? "N" : "A";

            $DocumentStatus = $dom->createElement('DocumentStatus');
            $DocumentStatus->appendChild($dom->createElement('PaymentStatus', $PaymentStatus));
            $DocumentStatus->appendChild($dom->createElement('PaymentStatusDate', Carbon::parse($recibo->updated_at)->format('Y-m-d') . "T" . Carbon::parse($recibo->updated_at)->format("H:i:s")));
            $DocumentStatus->appendChild($dom->createElement('SourceID', $recibo->user_id));
            $DocumentStatus->appendChild($dom->createElement('SourcePayment', 'P'));
            $Payment->appendChild($DocumentStatus);

            /**
             * Preenche SourceDocuments->Payments->Payment->PaymentMethod
             */

            $PaymentMethod = $dom->createElement('PaymentMethod');
            $PaymentMethod->appendChild($dom->createElement('PaymentMechanism', $recibo->formaPagamento->sigla_tipo_pagamento));
            $PaymentMethod->appendChild($dom->createElement('PaymentAmount', $TotalDebit = number_format($recibo->valor_total_entregue, 2, ".", "")));
            $PaymentMethod->appendChild($dom->createElement('PaymentDate', Carbon::parse($recibo->created_at)->format('Y-m-d')));
            $Payment->appendChild($PaymentMethod);
            $Payment->appendChild($dom->createElement('SourceID', $recibo->user_id));
            $Payment->appendChild($dom->createElement('SystemEntryDate', Carbon::parse($recibo->created_at)->format('Y-m-d') . "T" . Carbon::parse($recibo->updated_at)->format("H:i:s")));

            if ($recibo->cliente->nif == '999999999') {
                $CustomerID = $clienteDiverso->id;
            } else {
                $CustomerID = $recibo->cliente_id;
            }

            $Payment->appendChild($dom->createElement('CustomerID', $CustomerID));
            $Line = $dom->createElement('Line');
            $Line->appendChild($dom->createElement('LineNumber', ++$key));
            $SourceDocumentID = $dom->createElement('SourceDocumentID');

            // dd();
            // $factura = DB::connection('mysql2')->table('facturas')
            //     ->where('id', $recibo->recibos_items[0]['factura_id'])
            //     ->where('empresa_id', auth()->user()->empresa_id)->first();


            $SourceDocumentID->appendChild($dom->createElement('OriginatingON', $recibo->factura->numeracaoFactura));
            $SourceDocumentID->appendChild($dom->createElement('InvoiceDate', Carbon::parse($recibo->factura->created_at)->format('Y-m-d')));
            $SourceDocumentID->appendChild($dom->createElement('Description', $Description));
            $Line->appendChild($SourceDocumentID);
            $Line->appendChild($dom->createElement('CreditAmount', number_format($recibo->valor_total_entregue, 2, ".", "")));
            $Payment->appendChild($Line);

            /**
             * Preenche SourceDocuments->Payments->Payment->DocumentTotals
             */
            $TaxPayable = 0;

            $DocumentTotals = $dom->createElement('DocumentTotals');
            $DocumentTotals->appendChild($dom->createElement('TaxPayable', number_format($TaxPayable, 2, ".", "")));
            $DocumentTotals->appendChild($dom->createElement('NetTotal', number_format($recibo->valor_total_entregue, 2, ".", "")));
            $DocumentTotals->appendChild($dom->createElement('GrossTotal', number_format($recibo->valor_total_entregue, 2, ".", "")));
            $Payment->appendChild($DocumentTotals);
        }



        // return '<xmp>' . $dom->saveXML() . '</xmp>';

        $purchaseInvoices = $dom->createElement('PurchaseInvoices');
        $purchaseInvoices->appendChild($dom->createElement('NumberOfEntries', 0));
        //add PurchaseInvoices em sourceDocuments
        $sourceDocuments->appendChild($purchaseInvoices);
        $root->appendChild($sourceDocuments);



        $dom = $dom->saveXML();
        $dom = str_replace("<TransactionID>#</TransactionID>", "", $dom);
        $dom = str_replace("<TaxExemptionReason>#</TaxExemptionReason>", "", $dom);
        $dom = str_replace("<TaxExemptionCode>#</TaxExemptionCode>", "", $dom);
        $dom = str_replace("<Reason>#</Reason>", "", $dom);

        // return '<xmp>' . $dom . '</xmp>';
        // return '<xmp>' . $dom->saveXML() . '</xmp>';

        return FacadesResponse::make($dom, 200)->header('Content-Type', 'application/xml');

        // $dom->save('agt/saftagt.xml') or die('XML Create Error');
    }

    public function listarTaxas($produtos)
    {
        $taxas = array();
        foreach ($produtos as $key => $produto) {
            array_push($taxas, $produto->tipoTaxa);
        }
        $collection = collect($taxas);
        $array = $collection->unique();
        return $array;
    }
}
