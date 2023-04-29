<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DOMDocument;

use App\DadosInstituicao;
use App\Fatura;
use App\Pagamento;
use App\NotaCreditoFactura;
use App\FacturaItens;
use App\Servico;
use App\Taxa;

use Carbon\Carbon;
use DB;


class SaftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */




    public function gerarSaft(Request $request)
    {

        // dd($request->all());
        // $configuracoes=Configuracao::get();

        //Criar ficheiro xml

        // $dataInicio =  date("Y-m-d", strtotime("2021-02-09"));
        // $dataFinal =  date("Y-m-d", strtotime("2021-02-26"));
        //dd($request->all(), $dataInicio, $dataFinal);
        $regras = [
            'data_init' => 'required',
            'data_fim' => 'required',
        ];
        $msg = [
            'data_init.required' => 'Selecione a data de ínicio',
            'data_fim.required' => 'Selecione a data de fim',

        ];
        // $request->validate($regras, $msg);

        $dataInicio = date("Y-m-d H:i:s", strtotime($request->data_init . ' 00:00:00'));
        $dataFinal =  date("Y-m-d H:i:s", strtotime($request->data_fim . ' 23:59:59'));
        $anoInicioSaft = Carbon::parse($dataInicio)->format('Y');
        $anoFimSaft = Carbon::parse($dataFinal)->format('Y');
        //dd($anoInicioSaft,$anoFimSaft);
        $instituicao = DadosInstituicao::first();
        $pre_inscricoes = [];





        //$factura= Fatura::with('matricula')->whereBetween('DataFactura',[$dataInicio,$dataFinal])distinct()->-take(17)->(['codigoMatricula']);

        $custumers_facturas = DB::table('factura')
            ->select(DB::raw('count(*) as user_count, CodigoMatricula,Codigo,nome_aluno,morada_aluno,nif_aluno'))
            ->whereBetween('DataFactura', [$dataInicio, $dataFinal])
            //->where('CodigoMatricula',30198)
            ->groupBy('CodigoMatricula', 'Codigo', 'nome_aluno', 'morada_aluno', 'nif_aluno')


            ->get();
        $custumers_pagamentos = DB::table('tb_pagamentos')
            ->join('factura', 'factura.Codigo', 'tb_pagamentos.codigo_factura')
            ->select(DB::raw('count(*) as user_count,CodigoMatricula,tb_pagamentos.nome_aluno,tb_pagamentos.morada_aluno,tb_pagamentos.nif_aluno'))
            ->whereBetween('DataRegisto', [$dataInicio, $dataFinal])
            //->where('CodigoMatricula',30198)
            ->groupBy('CodigoMatricula', 'tb_pagamentos.nome_aluno', 'tb_pagamentos.morada_aluno', 'tb_pagamentos.nif_aluno')
            //->whereIn('CodigoMatricula',$custumers_facturas)

            ->get();


        $custumers_nota_credito_facturas = DB::table('tb_nota_credito_fatura as credito_fat')
            ->select(DB::raw('count(*) as user_count, credito_fat.CodigoMatricula,credito_fat.nome_aluno,credito_fat.morada_aluno,credito_fat.nif_aluno'))
            ->whereBetween('DataFactura', [$dataInicio, $dataFinal])
            //->where('CodigoMatricula',30198)
            ->groupBy('credito_fat.CodigoMatricula', 'credito_fat.nome_aluno', 'credito_fat.morada_aluno', 'credito_fat.nif_aluno')

            ->get();

        $custumers_tb_notas_credito_pagamentos = DB::table('tb_notas_credito_pagamentos as credito_paga')
            ->join('factura', 'factura.Codigo', 'credito_paga.codigo_factura')
            ->select(DB::raw('count(*) as user_count, credito_paga.codigo_pagamento,credito_paga.nome_aluno,credito_paga.morada_aluno,credito_paga.nif_aluno'))
            ->whereBetween('DataRegisto', [$dataInicio, $dataFinal])
            //->where('CodigoMatricula',30198)
            ->groupBy('credito_paga.codigo_pagamento', 'credito_paga.nome_aluno', 'credito_paga.morada_aluno', 'credito_paga.nif_aluno')

            ->get();

        $customersAux = $custumers_facturas->merge($custumers_pagamentos, $custumers_tb_notas_credito_pagamentos, $custumers_nota_credito_facturas); //array_merge($custumers_facturas->toArray(),$custumers_pagamentos->toArray());

        $customers = $customersAux->unique('CodigoMatricula');













        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $root = $dom->createElement('AuditFile');
        $root->setAttribute('xmlns', "urn:OECD:StandardAuditFile-Tax:AO_1.01_01");
        $root->setAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");
        $root->setAttribute('xsi:schemaLocation', "urn:OECD:StandardAuditFile-Tax:AO_1.01_01 SAFTAO1.01_01.xsd");
        $dom->appendChild($root);

        //filhos de root
        //1º Filho - header
        $header = $dom->createElement('Header');
        $root->appendChild($header);
        //1.1. Filhos de Header
        //$header->setAttribute('id', 1);
        $header->appendChild($dom->createElement('AuditFileVersion', '1.01_01'));
        $header->appendChild($dom->createElement('CompanyID', $instituicao->NIF));
        $header->appendChild($dom->createElement('TaxRegistrationNumber', $instituicao->NIF));
        $header->appendChild($dom->createElement('TaxAccountingBasis', 'F'));

        $header->appendChild($dom->createElement('CompanyName', $instituicao->Nome));
        $header->appendChild($dom->createElement('BusinessName', $instituicao->Nome));
        //Criar node companyAddress
        $companyAddress = $dom->createElement('CompanyAddress');
        //Adicionar filhos de companyAddress
        $companyAddress->appendChild($dom->createElement('AddressDetail',  $instituicao->Localidade));
        $companyAddress->appendChild($dom->createElement('City', 'Luanda'));
        $companyAddress->appendChild($dom->createElement('Country', 'AO'));
        $header->appendChild($companyAddress);
        //dd($anoInicioSaft);
        $header->appendChild($dom->createElement('FiscalYear', $anoInicioSaft));
        $header->appendChild($dom->createElement('StartDate', Carbon::parse($dataInicio)->format('Y-m-d')));
        $header->appendChild($dom->createElement('EndDate', Carbon::parse($dataFinal)->format('Y-m-d')));
        $header->appendChild($dom->createElement('CurrencyCode', 'AOA'));
        $header->appendChild($dom->createElement('DateCreated', Carbon::parse($dataFinal)->format('Y-m-d')));
        $header->appendChild($dom->createElement('TaxEntity', 'Global'));
        $header->appendChild($dom->createElement('ProductCompanyTaxID', 'AO503140600'));
        $header->appendChild($dom->createElement('SoftwareValidationNumber', '32/AGT/2019'));
        $header->appendChild($dom->createElement('ProductID', 'WinMarket Pro/OSVALDO MANUEL RAMOS-RAMOS SOFT P. DE SERVICOS'));
        $header->appendChild($dom->createElement('ProductVersion', '10.5.19'));
        $header->appendChild($dom->createElement('Telephone', $instituicao->Telefone_Movel));
        $header->appendChild($dom->createElement('Fax', $instituicao->Telefone_Fixo));
        $header->appendChild($dom->createElement('Email', $instituicao->Email));
        $header->appendChild($dom->createElement('Website', $instituicao->Site));

        //2º Filho - MasterFiles
        $masterFiles = $dom->createElement('MasterFiles');
        $root->appendChild($masterFiles);
        //2.1 Filhos de MasterFiles
        //Circulo for para os varios costumer(estudantes)
        foreach ($customers as $key => $aluno) {

            $costumer = $dom->createElement('Customer');
            //Filhos do costumer
            $costumer->appendChild($dom->createElement('CustomerID', $aluno->CodigoMatricula));
            $costumer->appendChild($dom->createElement('AccountID', 'Desconhecido')); //estatico
            $costumer->appendChild($dom->createElement('CustomerTaxID', $aluno->nif_aluno));
            $costumer->appendChild($dom->createElement('CompanyName', 'Consumidor final'));
            //Criar BillingAddress e seus filhos
            $billingAddress = $dom->createElement('BillingAddress');
            $billingAddress->appendChild($dom->createElement('AddressDetail', $aluno->morada_aluno));
            $billingAddress->appendChild($dom->createElement('City', 'Luanda'));
            $billingAddress->appendChild($dom->createElement('PostalCode', '*'));
            $billingAddress->appendChild($dom->createElement('Country', 'AO'));
            $costumer->appendChild($billingAddress); //Adicionar billingAddress no costumer
            $costumer->appendChild($dom->createElement('SelfBillingIndicator', 0));
            $masterFiles->appendChild($costumer); //adicionar costumer no MasterFiles

        }

        //Fim costumer


        $products_facturas = DB::table('factura')
            ->join('factura_items', 'factura_items.CodigoFactura', 'factura.Codigo')
            ->select(DB::raw('count(*) as user_count, CodigoProduto'))
            ->whereBetween('DataFactura', [$dataInicio, $dataFinal])
            //->where('CodigoMatricula',30198)
            ->groupBy('CodigoProduto')


            ->get();

        $products_credito_fatura = DB::table('tb_nota_credito_fatura')
            ->join('factura_items', 'factura_items.CodigoFactura', 'tb_nota_credito_fatura.codigo_fatura')
            ->select(DB::raw('count(*) as user_count, CodigoProduto'))
            ->whereBetween('DataFactura', [$dataInicio, $dataFinal])
            //->where('CodigoMatricula',30198)
            ->groupBy('CodigoProduto')
            ->get();

        //dd($custumers_tb_notas_credito_pagamentos);//40018
        $products_aux = $products_facturas->merge($products_credito_fatura);
        // dd($custumers->unique('CodigoMatricula'));
        $products_all = $products_aux->unique('CodigoProduto');
        //dd( $teste->where('CodigoMatricula',40018));

        //dd($products);
        foreach ($products_all as $key => $value) {
            $servico = Servico::find($value->CodigoProduto);
            //dd($servico->Codigo);
            //Criar Products ou serviços vendidos - ciclo for
            $Products = $dom->createElement('Product');
            //criar e add filhos de Product 
            $Products->appendChild($dom->createElement('ProductType', 'S'));
            $Products->appendChild($dom->createElement('ProductCode', $servico->Codigo));
            $Products->appendChild($dom->createElement('ProductGroup', 'N/A'));
            $Products->appendChild($dom->createElement('ProductDescription', $servico->Descricao));
            $Products->appendChild($dom->createElement('ProductNumberCode', $servico->Codigo));
            $masterFiles->appendChild($Products); //adicionar costumer no MasterFiles
            //Fim criar Products

        }


        //Criar TaxTable
        $taxTable = $dom->createElement('TaxTable');
        //Cria e add fiflhos de TaxTable
        $taxTableEntry = $dom->createElement('TaxTableEntry');
        //Filhos de TaxTableEntry
        $taxTableEntry->appendChild($dom->createElement('TaxType', 'NS'));
        $taxTableEntry->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
        $taxTableEntry->appendChild($dom->createElement('TaxCode', 'NS'));
        $taxTableEntry->appendChild($dom->createElement('Description', 'Isenta'));
        $taxTableEntry->appendChild($dom->createElement('TaxPercentage', '0.00'));
        $taxTable->appendChild($taxTableEntry);

        $taxTableEntry = $dom->createElement('TaxTableEntry');
        $taxTableEntry->appendChild($dom->createElement('TaxType', 'IVA'));
        $taxTableEntry->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
        $taxTableEntry->appendChild($dom->createElement('TaxCode', 'ISE'));
        $taxTableEntry->appendChild($dom->createElement('Description', 'Isenta'));
        $taxTableEntry->appendChild($dom->createElement('TaxPercentage', '0.00'));
        $taxTable->appendChild($taxTableEntry);

        $taxas = Taxa::where('taxa', '>', 0)->get();

        foreach ($taxas as $key => $value) {
            //dd($value);
            $taxTableEntry = $dom->createElement('TaxTableEntry');
            $taxTableEntry->appendChild($dom->createElement('TaxType', 'IVA'));
            $taxTableEntry->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
            $taxTableEntry->appendChild($dom->createElement('TaxCode', 'NOR'));
            $taxTableEntry->appendChild($dom->createElement('Description', 'Taxa Normal'));
            $taxTableEntry->appendChild($dom->createElement('TaxPercentage', $value->taxa));
            $taxTable->appendChild($taxTableEntry);
            //Fim taxTable e taxTableEntry fim for
            $masterFiles->appendChild($taxTable); //adicionar costumer no MasterFiles

        }
        //3º Filho - SourceDocuments
        $sourceDocuments = $dom->createElement('SourceDocuments');
        //Add filhos de salesInvoices

        $salesInvoices = $dom->createElement('SalesInvoices');
        $salesInvoices->appendChild($dom->createElement('NumberOfEntries', NotaCreditoFactura::whereBetween('DataFactura', [$dataInicio, $dataFinal])->count('TotalPreco') + Fatura::whereBetween('DataFactura', [$dataInicio, $dataFinal])->count('TotalPreco')));
        $salesInvoices->appendChild($dom->createElement('TotalDebit', NotaCreditoFactura::whereBetween('DataFactura', [$dataInicio, $dataFinal])->sum('TotalPreco')));
        $salesInvoices->appendChild($dom->createElement('TotalCredit', Fatura::whereBetween('DataFactura', [$dataInicio, $dataFinal])->where('estado_anulacao', '0')->sum('TotalPreco')));


        $faturas = Fatura::with('factura_itens.servico')->whereBetween('DataFactura', [$dataInicio, $dataFinal])->get();
        foreach ($faturas as $key => $fatura) {
            //dd($value->factura_itens);
            //Ciclo de Invoices
            $invoice = $dom->createElement('Invoice');
            //filhos de Invoice
            $invoice->appendChild($dom->createElement('InvoiceNo', $fatura->NextFactura));
            $documentStatus = $dom->createElement('DocumentStatus');
            //filhos de documentStatus

            $documentStatus->appendChild($dom->createElement('InvoiceStatus', $fatura->estado_anulacao == 0 ? 'N' : 'A'));
            $documentStatus->appendChild($dom->createElement('InvoiceStatusDate', str_replace(' ', 'T', $fatura->DataFactura)));
            $documentStatus->appendChild($dom->createElement('SourceID', $fatura->CodigoMatricula));
            $documentStatus->appendChild($dom->createElement('SourceBilling', 'P'));
            $invoice->appendChild($documentStatus); //Add documentStatus no Invoice
            $invoice->appendChild($dom->createElement('Hash', $fatura->hash)); //Add Hash no Invoice
            $invoice->appendChild($dom->createElement('HashControl', 1));
            $invoice->appendChild($dom->createElement('Period', (int)explode('-', $dataInicio)[1]));
            $invoice->appendChild($dom->createElement('InvoiceDate', explode(' ', $fatura->DataFactura)[0]));
            $invoice->appendChild($dom->createElement('InvoiceType', 'FT'));
            //Criar filhos de SpecialRegimes
            $specialRegimes = $dom->createElement('SpecialRegimes');
            $specialRegimes->appendChild($dom->createElement('SelfBillingIndicator', 0));
            $specialRegimes->appendChild($dom->createElement('CashVATSchemeIndicator', 0));
            $specialRegimes->appendChild($dom->createElement('ThirdPartiesBillingIndicator', 0));
            $invoice->appendChild($specialRegimes); //add specialRegimes no Invoice
            $invoice->appendChild($dom->createElement('SourceID', $fatura->CodigoMatricula));
            $invoice->appendChild($dom->createElement('SystemEntryDate', str_replace(' ', 'T', $fatura->DataFactura)));
            $invoice->appendChild($dom->createElement('CustomerID', $fatura->CodigoMatricula));
            //Criar Line de Invoice foreach

            foreach ($fatura->factura_itens as $key => $item_fact) {
                //dd();
                $line = $dom->createElement('Line');
                //filhos de Line
                $line->appendChild($dom->createElement('LineNumber', $key + 1));
                $line->appendChild($dom->createElement('ProductCode', $item_fact->CodigoProduto));
                $line->appendChild($dom->createElement('ProductDescription', $item_fact->servico->Descricao));
                $line->appendChild($dom->createElement('Quantity', $item_fact->Quantidade));
                $line->appendChild($dom->createElement('UnitOfMeasure', 'Un'));
                $line->appendChild($dom->createElement('UnitPrice', number_format($item_fact->Total / $item_fact->Quantidade, 2, '.', 3)));
                $line->appendChild($dom->createElement('TaxPointDate', explode(' ', $fatura->DataFactura)[0]));
                $line->appendChild($dom->createElement('Description', 'bom'));
                $line->appendChild($dom->createElement('CreditAmount', number_format($item_fact->Total, 2, '.', 3)));
                //Criar Taxa e seus filhos
                $tax = $dom->createElement('Tax');
                if ($item_fact->TotalIva > 0) {
                    $tax->appendChild($dom->createElement('TaxType', 'IVA'));
                    $tax->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
                    $tax->appendChild($dom->createElement('TaxCode', 'NOR'));
                    $tax->appendChild($dom->createElement('TaxPercentage', ($item_fact->TotalIva / $item_fact->Total) * 100));
                    $line->appendChild($tax); //Add Fax na Line
                    $line->appendChild($dom->createElement('SettlementAmount', number_format($item_fact->descontoProduto, 2, '.', 3)));
                } elseif (str_contains(strtolower($item_fact->motivo_isencao), 'do artigo')) {
                    $tax->appendChild($dom->createElement('TaxType', 'IVA'));
                    $tax->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
                    $tax->appendChild($dom->createElement('TaxCode', 'ISE'));
                    $tax->appendChild($dom->createElement('TaxPercentage', 0));
                    $line->appendChild($tax); //Add Fax na Line
                    $line->appendChild($dom->createElement('TaxExemptionReason', $item_fact->motivo_isencao));
                    $line->appendChild($dom->createElement('TaxExemptionCode', $item_fact->codigo_motivo));
                    $line->appendChild($dom->createElement('SettlementAmount', $item_fact->descontoProduto));
                } else {

                    $tax->appendChild($dom->createElement('TaxType', 'NS'));
                    $tax->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
                    $tax->appendChild($dom->createElement('TaxCode', 'NS'));
                    $tax->appendChild($dom->createElement('TaxPercentage', 0));
                    $line->appendChild($tax); //Add Fax na Line
                    $line->appendChild($dom->createElement('TaxExemptionReason', $item_fact->motivo_isencao));
                    $line->appendChild($dom->createElement('TaxExemptionCode', $item_fact->codigo_motivo));
                    $line->appendChild($dom->createElement('SettlementAmount', $item_fact->descontoProduto));
                }

                $invoice->appendChild($line);
            }
            //criar  DocumentTotals e seus filhos
            $documentTotals = $dom->createElement('DocumentTotals');
            $documentTotals->appendChild($dom->createElement('TaxPayable', number_format($fatura->totalIVA, 2, '.', 3)));
            $documentTotals->appendChild($dom->createElement('NetTotal', number_format($fatura->TotalPreco, 2, '.', 3)));
            $documentTotals->appendChild($dom->createElement('GrossTotal', number_format($fatura->ValorAPagar, 2, '.', 3)));
            //criar Payments
            $payment = $dom->createElement('Payment');
            $payment->appendChild($dom->createElement('PaymentMechanism', 'OU'));
            $payment->appendChild($dom->createElement('PaymentAmount', number_format($fatura->ValorAPagar, 2, '.', 3)));
            $payment->appendChild($dom->createElement('PaymentDate', explode(' ', $fatura->DataFactura)[0]));
            $documentTotals->appendChild($payment); //add payment em documentTotals          
            $invoice->appendChild($documentTotals); //add $documentTotals no Invoice
            //Add invoice em SalesInvoices
            $salesInvoices->appendChild($invoice);
        }

        //Fim foreach factura

        //Inico foreach nota credito
        $nota_creditos = NotaCreditoFactura::with('facturaNotaCredito.factura_itens.servico')->whereBetween('DataFactura', [$dataInicio, $dataFinal])->get();
        foreach ($nota_creditos as $key => $nota) {
            //dd($value->factura_itens);
            //Ciclo de Invoices
            $invoice = $dom->createElement('Invoice');
            //filhos de Invoice
            $invoice->appendChild($dom->createElement('InvoiceNo', $nota->NextNotaCreditoFactura));
            $documentStatus = $dom->createElement('DocumentStatus');
            //filhos de documentStatus

            $documentStatus->appendChild($dom->createElement('InvoiceStatus', 'N'));
            $documentStatus->appendChild($dom->createElement('InvoiceStatusDate', str_replace(' ', 'T', $nota->DataFactura)));
            $documentStatus->appendChild($dom->createElement('SourceID', $nota->CodigoMatricula));
            $documentStatus->appendChild($dom->createElement('SourceBilling', 'P'));
            $invoice->appendChild($documentStatus); //Add documentStatus no Invoice
            $invoice->appendChild($dom->createElement('Hash', $nota->hash)); //Add Hash no Invoice
            $invoice->appendChild($dom->createElement('HashControl', 1));
            $invoice->appendChild($dom->createElement('Period', (int)explode('-', $dataInicio)[1]));
            $invoice->appendChild($dom->createElement('InvoiceDate', explode(' ', $nota->DataFactura)[0]));
            $invoice->appendChild($dom->createElement('InvoiceType', 'NC'));
            //Criar filhos de SpecialRegimes
            $specialRegimes = $dom->createElement('SpecialRegimes');
            $specialRegimes->appendChild($dom->createElement('SelfBillingIndicator', 0));
            $specialRegimes->appendChild($dom->createElement('CashVATSchemeIndicator', 0));
            //$specialRegimes->apgitpendChild($dom->createElement('ThirdPartiesBillingIndicator',0));
            $invoice->appendChild($specialRegimes); //add specialRegimes no Invoice
            $invoice->appendChild($dom->createElement('SourceID', $nota->CodigoMatricula));
            $invoice->appendChild($dom->createElement('SystemEntryDate', str_replace(' ', 'T', $nota->DataFactura)));
            $invoice->appendChild($dom->createElement('CustomerID', $nota->CodigoMatricula));
            //Criar Line de Invoice foreach

            foreach ($nota->facturaNotaCredito->factura_itens as $key => $item_fact) {
                //dd();
                $line = $dom->createElement('Line');
                //filhos de Line
                $line->appendChild($dom->createElement('LineNumber', $key + 1));
                $line->appendChild($dom->createElement('ProductCode', $item_fact->CodigoProduto));
                $line->appendChild($dom->createElement('ProductDescription', $item_fact->servico->Descricao));
                $line->appendChild($dom->createElement('Quantity', $item_fact->Quantidade));
                $line->appendChild($dom->createElement('UnitOfMeasure', 'Un'));
                $line->appendChild($dom->createElement('UnitPrice', $item_fact->Total / $item_fact->Quantidade));
                $line->appendChild($dom->createElement('TaxPointDate', explode(' ', $nota->DataFactura)[0]));
                //Criar tag references
                $references = $dom->createElement('References');
                //Filhos de references

                $references->appendChild($dom->createElement('Reference', $nota->facturaNotaCredito->NextFactura));
                $references->appendChild($dom->createElement('Reason', $nota->motivo_anulacao));
                $line->appendChild($references); //adicionar childreanm


                $line->appendChild($dom->createElement('Description', 'bom'));
                $line->appendChild($dom->createElement('DebitAmount', $item_fact->Total));
                //Criar Taxa e seus filhos
                $tax = $dom->createElement('Tax');
                if ($item_fact->TotalIva > 0) {
                    $tax->appendChild($dom->createElement('TaxType', 'IVA'));
                    $tax->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
                    $tax->appendChild($dom->createElement('TaxCode', 'NOR'));
                    $tax->appendChild($dom->createElement('TaxPercentage', ($item_fact->TotalIva / $item_fact->Total) * 100));
                    $line->appendChild($tax); //Add Fax na Line
                    $line->appendChild($dom->createElement('SettlementAmount', $item_fact->descontoProduto));
                } elseif (str_contains(strtolower($item_fact->motivo_isencao), 'do artigo')) {
                    $tax->appendChild($dom->createElement('TaxType', 'IVA'));
                    $tax->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
                    $tax->appendChild($dom->createElement('TaxCode', 'ISE'));
                    $tax->appendChild($dom->createElement('TaxPercentage', 0));
                    $line->appendChild($tax); //Add Fax na Line
                    $line->appendChild($dom->createElement('TaxExemptionReason', $item_fact->motivo_isencao));
                    $line->appendChild($dom->createElement('TaxExemptionCode', $item_fact->codigo_motivo));
                    $line->appendChild($dom->createElement('SettlementAmount', $item_fact->descontoProduto));
                } else {

                    $tax->appendChild($dom->createElement('TaxType', 'NS'));
                    $tax->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
                    $tax->appendChild($dom->createElement('TaxCode', 'NS'));
                    $tax->appendChild($dom->createElement('TaxPercentage', 0));
                    $line->appendChild($tax); //Add Fax na Line
                    $line->appendChild($dom->createElement('TaxExemptionReason', $item_fact->motivo_isencao));
                    $line->appendChild($dom->createElement('TaxExemptionCode', $item_fact->codigo_motivo));
                    $line->appendChild($dom->createElement('SettlementAmount', $item_fact->descontoProduto));
                }

                $invoice->appendChild($line);
            }
            //criar  DocumentTotals e seus filhos
            $documentTotals = $dom->createElement('DocumentTotals');
            $documentTotals->appendChild($dom->createElement('TaxPayable', $nota->totalIVA));
            $documentTotals->appendChild($dom->createElement('NetTotal', $nota->TotalPreco));
            $documentTotals->appendChild($dom->createElement('GrossTotal', $nota->ValorAPagar));
            //criar Payments
            $payment = $dom->createElement('Payment');
            $payment->appendChild($dom->createElement('PaymentMechanism', 'OU'));
            $payment->appendChild($dom->createElement('PaymentAmount', $nota->ValorAPagar));
            $payment->appendChild($dom->createElement('PaymentDate', explode(' ', $nota->DataFactura)[0]));
            $documentTotals->appendChild($payment); //add payment em documentTotals          
            $invoice->appendChild($documentTotals); //add $documentTotals no Invoice
            //Add invoice em SalesInvoices
            $salesInvoices->appendChild($invoice);
        }

        //Fim foreach nota credito


        //Add salesInvoices em sourceDocuments      
        $sourceDocuments->appendChild($salesInvoices);

        //Criar MovementOfGoods e seus filhos
        $movementOfGoods = $dom->createElement('MovementOfGoods');
        $movementOfGoods->appendChild($dom->createElement('NumberOfMovementLines', 0));
        $movementOfGoods->appendChild($dom->createElement('TotalQuantityIssued', 0.00));
        $sourceDocuments->appendChild($movementOfGoods);
        //Criar WorkingDocuments
        $workingDocuments = $dom->createElement('WorkingDocuments');
        $workingDocuments->appendChild($dom->createElement('NumberOfEntries', 1));
        $workingDocuments->appendChild($dom->createElement('TotalDebit', 0.00));
        $workingDocuments->appendChild($dom->createElement('TotalCredit', 422.00));
        //Criar WorkDocument
        $workDocument = $dom->createElement('WorkDocument');
        //desenvolver
        //Add $workDocuments no SourceDocuments



        //Criar Payments e seus filhos
        $payments = $dom->createElement('Payments');
        $payments->appendChild($dom->createElement('NumberOfEntries', Pagamento::where('estado_anulacao', '0')->whereBetween('created_at', [$dataInicio, $dataFinal])->count()));
        $payments->appendChild($dom->createElement('TotalDebit', 0.00));
        $payments->appendChild($dom->createElement('TotalCredit', Pagamento::where('estado_anulacao', '0')->whereBetween('created_at', [$dataInicio, $dataFinal])->sum('valor_depositado')));

        $pagamentos = Pagamento::with('factura')->where('estado_anulacao', '0')->whereBetween('created_at', [$dataInicio, $dataFinal])->get();
        //Filhos de payments - foreach
        foreach ($pagamentos as $key => $pagamento) {

            $payment = $dom->createElement('Payment');
            $payment->appendChild($dom->createElement('PaymentRefNo', $pagamento->NextPagamento));
            $payment->appendChild($dom->createElement('Period', (int)explode('-', $dataInicio)[1]));
            $payment->appendChild($dom->createElement('TransactionDate', explode(' ', $pagamento->created_at)[0]));
            $payment->appendChild($dom->createElement('PaymentType', 'RC'));
            $payment->appendChild($dom->createElement('Description', $pagamento->Observacao));
            $payment->appendChild($dom->createElement('SystemID', $pagamento->Codigo));
            //Criar DocumentStatus
            $documentStatus = $dom->createElement('DocumentStatus');
            $documentStatus->appendChild($dom->createElement('PaymentStatus', 'N'));
            $documentStatus->appendChild($dom->createElement('PaymentStatusDate', str_replace(' ', 'T', $pagamento->created_at)));
            $documentStatus->appendChild($dom->createElement('SourceID', $pagamento->factura->CodigoMatricula));
            $documentStatus->appendChild($dom->createElement('SourcePayment', 'P'));
            $payment->appendChild($documentStatus); //Add documentStatus no payment

            //Criar  paymentMethod e filhos
            $paymentMethod = $dom->createElement('PaymentMethod');
            $paymentMethod->appendChild($dom->createElement('PaymentMechanism', 'OU'));
            $paymentMethod->appendChild($dom->createElement('PaymentAmount', number_format($pagamento->valor_depositado, 2, '.', 3)));
            $paymentMethod->appendChild($dom->createElement('PaymentDate', explode(' ', $pagamento->created_at)[0]));
            $payment->appendChild($paymentMethod); //Add paymentMethod em payment

            $payment->appendChild($dom->createElement('SourceID', 1));
            $payment->appendChild($dom->createElement('SystemEntryDate', str_replace(' ', 'T', $pagamento->created_at)));
            $payment->appendChild($dom->createElement('CustomerID', $pagamento->factura->CodigoMatricula));

            //Criar Line
            $line = $dom->createElement('Line');
            $line->appendChild($dom->createElement('LineNumber', 1));
            //criar SourceDocumentID
            $sourceDocumentID = $dom->createElement('SourceDocumentID');
            $sourceDocumentID->appendChild($dom->createElement('OriginatingON', $pagamento->factura->NextFactura));
            $sourceDocumentID->appendChild($dom->createElement('InvoiceDate', explode(' ', $pagamento->created_at)[0]));
            $sourceDocumentID->appendChild($dom->createElement('Description', strlen($pagamento->Observacao) == 0 ? 'Nenhum' : $pagamento->Observacao));
            $line->appendChild($sourceDocumentID); //add $sourceDocumentID in line

            $line->appendChild($dom->createElement('CreditAmount', number_format($pagamento->valor_depositado, 2, '.', 3)));
            $payment->appendChild($line); //Add line em payment
            //criar DocumentTotals  e filhos
            $documentTotals = $dom->createElement('DocumentTotals');
            $documentTotals->appendChild($dom->createElement('TaxPayable', 0.00));
            $documentTotals->appendChild($dom->createElement('NetTotal', number_format($pagamento->valor_depositado, 2, '.', 3)));
            $documentTotals->appendChild($dom->createElement('GrossTotal', number_format($pagamento->valor_depositado, 2, '.', 3)));


            $payment->appendChild($documentTotals); //Add documentTotals em payment



            //add payment em payments
            $payments->appendChild($payment);
        }


        //add payment em sourceDocuments

        $sourceDocuments->appendChild($payments);

        //Criar PurchaseInvoices e seus filhos
        // $purchaseInvoices=$dom->createElement('PurchaseInvoices');
        // $purchaseInvoices->appendChild($dom->createElement('NumberOfEntries',0));
        //add PurchaseInvoices em sourceDocuments
        //$sourceDocuments->appendChild($purchaseInvoices);



        $root->appendChild($sourceDocuments);



        //echo '<xmp>'. $dom->saveXML() .'</xmp>';
        $dom->save('storage/iva/saft.xml') or die('Erro ao Criar o XML');
        return \Storage::download('iva/saft.xml');


        //return redirect()->back();
    }

    public function somarTaxa($dataInicio, $dataFim)
    {
        $taxa = taxa::get();
        $facturaItens = facturaItens::with()->has()->first();
        dd($facturaItens);
    }
    public function ler_xml()
    {
        //
        $xmlDataString = file_get_contents(public_path('iva/saft.xml'));
        $xmlObject = simplexml_load_string($xmlDataString);

        $json = json_encode($xmlObject);
        $phpDataArray = json_decode($json, true);
        //echo "<pre>";
        //print_r($phpDataArray);
        dd($phpDataArray);
    }
}
