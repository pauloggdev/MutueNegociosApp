<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\saft\AuditFile;
use App\Http\Controllers\saft\Customer;
use App\Http\Controllers\saft\Invoice;
use App\Http\Controllers\saft\Line;
use App\Http\Controllers\saft\LineNotaCredito\Line as LineNotaCredito;
use App\Http\Controllers\saft\Product;
use App\Http\Controllers\saft\TaxTableEntry;
use App\Http\Controllers\saft\WorkDocuments\Line as WorkDocumentsLine;
use App\Http\Controllers\saft\WorkDocuments\WorkDocument;
use App\Http\Controllers\saft\Payments\Payment;
use App\Http\Controllers\saft\Payments\Line as PaymentLine;
use App\Models\admin\Empresa;
use App\Models\admin\User;
use App\Models\empresa\AnulacaoDocumento;
use App\Models\empresa\Cliente;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\Factura;
use App\Models\empresa\FacturaOriginal;
use App\Models\empresa\NotaCredito;
use App\Models\empresa\Produto;
use App\Models\empresa\RecibosItem;
use Illuminate\Support\Facades\Validator;
use App\Models\empresa\Recibos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\ArrayToXml\ArrayToXml;
use Illuminate\Support\Facades\DB;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeUsuarioAlterouSenha;
use DOMDocument;
use Exception;
use Illuminate\Support\Str;



class GerarSaftController extends Controller
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;



    public function index()
    {
        $TIPO_FUNCIONARIO = 3;
        $TIPO_ADMIN = 2;
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        if ($this->verificarSeAlterouSenha() || $infoNotificacao['diasRestantes'] === 0) {
            return redirect(getenv('APP_URL') . 'home');
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        if ($empresa['tipo_user_id'] === $TIPO_FUNCIONARIO) {
            $data['router'] = "/empresa/funcionario";
        } else if ($empresa['tipo_user_id'] === $TIPO_ADMIN) {
            $data['router'] = "/empresa";
        }
        $data['guard'] = $empresa['guard'];

        return view('empresa.gerarSaft.index', $data);
    }

    public function xmlSaft1(Request $request)
    {

        $dataInicio = date("Y-m-d", strtotime($request->get('dataInicio')));
        $dataFinal = date("Y-m-d", strtotime($request->get('dataFinal')));

        $mensagem = [
            "dataInicio.required" => "É obrigatório a indicação de um valor para o campo data Inicio",
            "dataFinal.required" => "É obrigatório a indicação de um valor para o campo data Final",
        ];

        $this->validate($request, [
            'dataInicio' => ['required', function ($attribute, $value, $fail) use ($dataInicio, $dataFinal) {
                if ($dataInicio > $dataFinal) {
                    $fail('A data inicial não deve ser maior que data final');
                }
            }],
            'dataFinal' => ['required', function ($attribute, $value, $fail) use ($dataFinal) {
                $dataAtual = date('Y-m-d', date("Y-m-d H:i:s"));
                if ($dataFinal > $dataAtual) {
                    $fail('A data final não deve ser maior que data actual');
                }
            }]
        ], $mensagem);


        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        //Criar ficheiro xml
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $root = $dom->createElement('AuditFile');
        $root->setAttribute('xmlns', "urn:OECD:StandardAuditFile-Tax:AO_1.01_01");
        $root->setAttribute('xsi:schemaLocation', "urn:OECD:StandardAuditFile-Tax:AO_1.01_01 SAFTAO1.01_01.xsd");
        $root->setAttribute('xmlns:xsi', "http://www.w3.org/2001/XMLSchema-instance");
        $dom->appendChild($root);

        //filhos de root
        //1º Filho - header
        $header = $dom->createElement('Header');
        $root->appendChild($header);
        //1.1. Filhos de Header
        /*
         EMPRESA ADMIN - CRIADOR DO SOFTWARE
        */
        $empresa_ramos = Empresa::where('id', 1)->first();

        $header->appendChild($dom->createElement('AuditFileVersion', '1.01_01'));
        $header->appendChild($dom->createElement('CompanyID', $empresa_ramos->nif));
        $header->appendChild($dom->createElement('TaxRegistrationNumber', $empresa_ramos->nif));
        $header->appendChild($dom->createElement('TaxAccountingBasis', 'F'));

        $header->appendChild($dom->createElement('CompanyName', 'RamosSoft'));
        $header->appendChild($dom->createElement('BusinessName', 'RamosSoft'));
        //Criar node companyAddress
        $companyAddress = $dom->createElement('CompanyAddress');
        //Adicionar filhos de companyAddress
        $companyAddress->appendChild($dom->createElement('AddressDetail', $empresa_ramos->endereco));
        $companyAddress->appendChild($dom->createElement('City', $empresa_ramos->cidade));
        $companyAddress->appendChild($dom->createElement('Country', 'AO'));
        $header->appendChild($companyAddress);

        $header->appendChild($dom->createElement('FiscalYear', Carbon::parse(Carbon::now())->format('Y')));
        $header->appendChild($dom->createElement('StartDate', $dataInicio));
        $header->appendChild($dom->createElement('EndDate', $dataFinal));
        $header->appendChild($dom->createElement('CurrencyCode', 'AOA'));
        $header->appendChild($dom->createElement('DateCreated', Carbon::parse(Carbon::now())->format('Y-m-d')));
        $header->appendChild($dom->createElement('TaxEntity', 'Global'));
        $header->appendChild($dom->createElement('ProductCompanyTaxID', 'AO503140600'));
        $header->appendChild($dom->createElement('SoftwareValidationNumber', '32/AGT/2019'));
        $header->appendChild($dom->createElement('ProductID', 'WinMarket Pro/OSVALDO MANUEL RAMOS-RAMOS SOFT P. DE SERVICOS'));
        $header->appendChild($dom->createElement('ProductVersion', '10.5.19'));
        $header->appendChild($dom->createElement('Telephone', $empresa_ramos->pessoal_Contacto));
        $header->appendChild($dom->createElement('Fax', '948100'));
        $header->appendChild($dom->createElement('Email', $empresa_ramos->email));
        $header->appendChild($dom->createElement('Website', $empresa_ramos->website));
        //fim header

        //2º Filho  de AuditFile (MasterFiles)
        $masterFiles = $dom->createElement('MasterFiles');
        $root->appendChild($masterFiles);
        //2.1 Filhos de MasterFiles


        //Circulo for para os varios customer(clientes)
        /*
        TODOS CLIENTES DA EMPRESA
        */
        $arrayIdsClientes = $this->clienteDocumentosIDs($dataInicio, $dataFinal);
        $clientes_empresa = Cliente::whereIn('id', $arrayIdsClientes)->where('empresa_id', $empresa['empresa']['id'])->get();
        /**
         * CLIENTE DIVERSOS
         */
        $clienteDiverso = Cliente::with('empresa')->where('empresa_id', $empresa['empresa']['id'])->where('diversos', 'sim')->first();


        /*
        TODOS OS PRODUTOS
        */
        $arrayIdsProdutos = $this->produtosDocumentosIDs($dataInicio, $dataFinal);
        $produtos = Produto::with('tipoTaxa')->whereIn('id', $arrayIdsProdutos)->where('empresa_id', $empresa['empresa']['id'])->get();

        foreach ($clientes_empresa as $key => $cliente) {
            $customer = $dom->createElement('Customer');
            if ($cliente->nif == '999999999') {
                $CustomerID = $clienteDiverso->id;
                $AccountID = "Desconhecido";
                $CustomerTaxID = $clienteDiverso->nif;
                $CompanyName = "DIVERSOS";
                $AddressDetail = "Av. Deolinda Rodrigues, 123";
                $City = "Luanda";
                $PostalCode = "*";
                $Country = "AO";
            } else {
                $CustomerID = $cliente->id;
                $AccountID =  $cliente->conta_corrente;
                $CustomerTaxID = $cliente->nif;
                $CompanyName = $cliente->nome;
                $AddressDetail = $cliente['endereco'];
                $City = $cliente['cidade'];
                $PostalCode = "*";
                $Country = "AO";
            }
            //Filhos do customer
            //adicionar customer no MasterFiles
            $customer->appendChild($dom->createElement('CustomerID', $CustomerID));
            $customer->appendChild($dom->createElement('AccountID', $AccountID));
            $customer->appendChild($dom->createElement('CustomerTaxID', $CustomerTaxID));
            $customer->appendChild($dom->createElement('CompanyName', $CompanyName));
            //Criar BillingAddress e seus filhos
            $billingAddress = $dom->createElement('BillingAddress');
            $billingAddress->appendChild($dom->createElement('AddressDetail', $AddressDetail));
            $billingAddress->appendChild($dom->createElement('City', $City));
            $billingAddress->appendChild($dom->createElement('PostalCode', $PostalCode));
            $billingAddress->appendChild($dom->createElement('Country', $Country));
            //Adicionar billingAddress no custumer
            $customer->appendChild($billingAddress);
            $customer->appendChild($dom->createElement('SelfBillingIndicator', 0));
            $masterFiles->appendChild($customer);
            //Fim custumer
        }

        // 2 filho de MasterFiles
        foreach ($produtos as $key => $produto) {
            $product = $dom->createElement('Product');
            //criar e add filhos de product 
            $product->appendChild($dom->createElement('ProductType', 'P'));
            $product->appendChild($dom->createElement('ProductCode', $produto->id));
            $product->appendChild($dom->createElement('ProductGroup', 'N/A'));
            $product->appendChild($dom->createElement('ProductDescription', $produto->designacao));
            $product->appendChild($dom->createElement('ProductNumberCode', $produto->id));
            $masterFiles->appendChild($product);
            //Fim criar produtos
        }

        /**
         * return todos code taxa e motivos de todos produtos item de factura,factura recibo e nota de credito
         */
        $taxaMotivos =  $this->TaxasMotivos($produtos); //codigo taxa dos produtos sem repetição

        //Criar TaxTable
        // 3 filho de MasterFiles
        foreach ($taxaMotivos as $key => $taxas) {

            $TaxType = $taxas->taxa ? "IVA" : "NS";
            $TaxCode = $taxas->taxa ? "NOR" : "NS";
            $Description = $taxas->taxa ? "Taxa Normal" : "Isenta";
            $TaxPercentage = $taxas->taxa;

            $taxTable = $dom->createElement('TaxTable');
            $taxTableEntry = $dom->createElement('TaxTableEntry');
            //Filhos de TaxTableEntry
            $taxTableEntry->appendChild($dom->createElement('TaxType', $TaxType));
            $taxTableEntry->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
            $taxTableEntry->appendChild($dom->createElement('TaxCode', $TaxCode));
            $taxTableEntry->appendChild($dom->createElement('Description', $Description));
            $taxTableEntry->appendChild($dom->createElement('TaxPercentage', number_format($TaxPercentage, 2, ".", "")));
            $taxTable->appendChild($taxTableEntry);
            //Fim taxTable e taxTableEntry fim for
            $masterFiles->appendChild($taxTable);
        }

        /**
         * QUANTIDADE DE FACTURAS, FACTURA RECIBOS NO INTERVALO DE DATA (INICIAL E FINAL)
         */
        $quantFacturas = DB::connection('mysql2')->table('facturas')
            ->whereBetween(DB::raw('DATE(facturas.created_at)'), array($dataInicio, $dataFinal))
            ->where('empresa_id', $empresa['empresa']['id'])
            ->where('status_id', 1)
            ->where(function ($query) {
                $query->where('facturas.tipo_documento', 1)
                    ->orWhere('facturas.tipo_documento', 2);
            })
            ->count();
        //QTD notas de creditos (facturas e facturas recibos anulados ou retificados)
        $quantNotaCredito = NotaCredito::with(['factura', 'factura.facturas_items', 'factura.formaPagamento'])->whereNotNull('facturaId')
            ->whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))->where('empresa_id', $empresa['empresa']['id'])
            ->count();



        $NumberOfEntries = $quantFacturas + $quantNotaCredito;

        $TotalCredit = Factura::whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))
            ->where('empresa_id', $empresa['empresa']['id'])
            ->where('status_id', 1)
            ->where('anulado', 1)
            ->where(function ($query) {
                $query->where('facturas.tipo_documento', 1)
                    ->orWhere('facturas.tipo_documento', 2);
            })
            ->sum('total_incidencia');


        // AuditFile->SourceDocuments
        //3º Filho de AuditFile
        $sourceDocuments = $dom->createElement('SourceDocuments');
        //AuditFile->SourceDocuments->SalesInvoices
        $salesInvoices = $dom->createElement('SalesInvoices');
        $salesInvoices->appendChild($dom->createElement('NumberOfEntries', $NumberOfEntries));
        $salesInvoices->appendChild($dom->createElement('TotalDebit', '0.00'));
        $salesInvoices->appendChild($dom->createElement('TotalCredit', number_format($TotalCredit, 2, ".", "")));

        //Ciclo de Invoices

        /**
         * Preenche SourceDocuments->SalesInvoices->Invoice
         * Todas facturas, e facturas recibo
         */

        $facturas = Factura::with(['facturas_items.produto.unidadeMedida', 'cliente', 'facturas_items.produto.tipoTaxa.motivo', 'facturas_items.produto.tipoTaxa', 'formaPagamento', 'tipoDocumento'])
            ->whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))
            ->where('empresa_id', $empresa['empresa']['id'])
            ->where('status_id', 1)
            ->where(function ($query) {
                $query->where('facturas.tipo_documento', 1)
                    ->orWhere('facturas.tipo_documento', 2);
            })
            ->get();

        // AuditFile->SourceDocuments->SalesInvoices->Invoice
        foreach ($facturas as $key => $factura) {

            if ($factura->retificado == "Sim") {
                $factura = FacturaOriginal::with(['facturas_items.produto.unidadeMedida', 'cliente', 'facturas_items.produto.tipoTaxa.motivo', 'facturas_items.produto.tipoTaxa', 'formaPagamento', 'tipoDocumento'])
                    ->where('numeracaoFactura', $factura->numeracaoFactura)
                    ->where('empresa_id', $empresa['empresa']['id'])
                    ->where(function ($query) {
                        $query->where('facturas_original.tipo_documento', 1)
                            ->orWhere('facturas_original.tipo_documento', 2);
                    })
                    ->first();
            } else {
                $factura = $factura;
            }
            $invoice = $dom->createElement('Invoice');
            //filhos de Invoice
            $invoice->appendChild($dom->createElement('InvoiceNo', $factura['numeracaoFactura']));
            $documentStatus = $dom->createElement('DocumentStatus');
            //filhos de documentStatus
            $InvoiceStatus = $factura['anulado'] === 2 ? "A" : "N";

            $documentStatus->appendChild($dom->createElement('InvoiceStatus', $InvoiceStatus));
            $documentStatus->appendChild($dom->createElement('InvoiceStatusDate', str_replace(' ', 'T', $factura->created_at)));
            $documentStatus->appendChild($dom->createElement('SourceID', 1));
            $documentStatus->appendChild($dom->createElement('SourceBilling', 'P'));
            $invoice->appendChild($documentStatus); //Add documentStatus no Invoice
            $invoice->appendChild($dom->createElement('Hash', $factura->hashValor)); //Add Hash no Invoice
            $invoice->appendChild($dom->createElement('HashControl', 1));
            $invoice->appendChild($dom->createElement('Period', Carbon::parse($dataInicio)->format('m')));
            $invoice->appendChild($dom->createElement('InvoiceDate', Carbon::parse($factura['created_at'])->format('Y-m-d')));
            $invoice->appendChild($dom->createElement('InvoiceType', $factura['tipoDocumento']['sigla']));
            //Criar filhos de SpecialRegimes
            $specialRegimes = $dom->createElement('SpecialRegimes');
            $specialRegimes->appendChild($dom->createElement('SelfBillingIndicator', 0));
            $specialRegimes->appendChild($dom->createElement('CashVATSchemeIndicator', 0));
            $specialRegimes->appendChild($dom->createElement('ThirdPartiesBillingIndicator', 0));
            $invoice->appendChild($specialRegimes); //add specialRegimes no Invoice
            $invoice->appendChild($dom->createElement('SourceID', $factura['user_id']));
            $invoice->appendChild($dom->createElement('SystemEntryDate', str_replace(' ', 'T', $factura->created_at)));
            $invoice->appendChild($dom->createElement('CustomerID', ($factura['cliente']['nif'] == '999999999' ? $clienteDiverso->id : $factura['cliente_id'])));

            //Criar Line de Invoice foreach
            foreach ($factura->facturas_items as $key => $ftItem) {
                $line = $dom->createElement('Line');
                //filhos de Line
                $line->appendChild($dom->createElement('LineNumber', $key + 1));
                $line->appendChild($dom->createElement('ProductCode', $ftItem->produto_id));
                $line->appendChild($dom->createElement('ProductDescription', $ftItem->descricao_produto));
                $line->appendChild($dom->createElement('Quantity', number_format($ftItem->quantidade_produto, 2, ".", "")));
                $line->appendChild($dom->createElement('UnitOfMeasure', ($ftItem->produto->unidadeMedida['designacao'] ? $ftItem->produto->unidadeMedida['designacao'] : "un")));
                $line->appendChild($dom->createElement('UnitPrice', number_format($ftItem->incidencia_produto / $ftItem->quantidade_produto, 2, ".", "")));
                $line->appendChild($dom->createElement('TaxPointDate', Carbon::parse($factura->created_at)->format('Y-m-d')));
                $line->appendChild($dom->createElement('Description', 'bom'));
                $line->appendChild($dom->createElement('CreditAmount', number_format($ftItem->incidencia_produto, 2, ".", "")));

                /**
                 * Preenche SourceDocuments->SalesInvoices->Invoice->Line->Tax
                 */

                if ($ftItem->produto->tipoTaxa->taxa > 0 || $ftItem->produto->motivoIsencao->codigo >= 10) { //se foi setado um dos artigos
                    $TaxType = "IVA";
                    if ($ftItem->produto->tipoTaxa->taxa == 0) {
                        //se não foi aplicado iva seta valores
                        $TaxExemptionReason = $ftItem->produto->motivoIsencao->descricao;
                        $TaxExemptionCode = $ftItem->produto->motivoIsencao->codigoMotivo;
                    } else {
                        //se foi aplicado IVA seta vazio
                        $TaxExemptionReason = "";
                        $TaxExemptionCode = "";
                    }
                } else {
                    $TaxType = "NS";
                    //se não foi aplicado iva seta valores
                    $TaxExemptionReason = $ftItem->produto->motivoIsencao->descricao;
                    $TaxExemptionCode = $ftItem->produto->motivoIsencao->codigoMotivo;
                }

                $TaxCode = $ftItem->produto->tipoTaxa->taxa ? "NOR" : ($TaxType == "NS" ? "NS" : "ISE");
                $Description = $ftItem->produto->tipoTaxa->taxa ? "Taxa Normal" : "Isenta";
                $TaxPercentage = $ftItem->produto->tipoTaxa->taxa;
                //Criar Taixa e seus filhos
                $tax = $dom->createElement('Tax');
                $tax->appendChild($dom->createElement('TaxType', $TaxType));
                $tax->appendChild($dom->createElement('TaxCountryRegion', 'AO'));
                $tax->appendChild($dom->createElement('TaxCode', $TaxCode));
                $tax->appendChild($dom->createElement('TaxPercentage', $TaxPercentage));
                $line->appendChild($tax); //Add Fax na Line
                $line->appendChild($dom->createElement('TaxExemptionReason', $TaxExemptionReason));
                $line->appendChild($dom->createElement('TaxExemptionCode', $TaxExemptionCode));
                $line->appendChild($dom->createElement('SettlementAmount', $ftItem->desconto_produto));
                $invoice->appendChild($line);
            }


            //criar  DocumentTotals e seus filhos
            // AuditFile->SourceDocuments->SalesInvoices->Invoice->DocumentTotals
            $documentTotals = $dom->createElement('DocumentTotals');
            $documentTotals->appendChild($dom->createElement('TaxPayable', number_format($factura->total_iva, 2, ".", "")));
            $documentTotals->appendChild($dom->createElement('NetTotal', number_format($factura->total_incidencia, 2, ".", "")));

            $GrossTotal = $factura->valor_a_pagar + $factura->retencao;
            $documentTotals->appendChild($dom->createElement('GrossTotal', number_format($GrossTotal, 2, ".", "")));

            /**
             * Preenche SourceDocuments->SalesInvoices->Invoice->DocumentTotals->Payment
             */
            //criar Payments
            $payment = $dom->createElement('Payment');
            $PaymentMechanism = $factura->formaPagamento ? $factura->formaPagamento->sigla_tipo_pagamento : "CC";
            $payment->appendChild($dom->createElement('PaymentMechanism', $PaymentMechanism));
            $payment->appendChild($dom->createElement('PaymentAmount', number_format($factura->valor_a_pagar, 2, ".", "")));
            $payment->appendChild($dom->createElement('PaymentDate', Carbon::parse($factura->created_at)->format('Y-m-d')));
            $documentTotals->appendChild($payment); //add payment em documentTotals          
            $invoice->appendChild($documentTotals); //add $documentTotals no Invoice
            //Add invoice em SalesInvoices
            $salesInvoices->appendChild($invoice);
            //Fim foreach
        }


        //Todas notas de creditos (facturas e facturas recibos anulados)
        $notaCreditos = NotaCredito::with(['cliente', 'factura', 'notaCreditoItems', 'notaCreditoItems.produto', 'notaCreditoItems.produto.unidadeMedida'])
            ->whereNotNull('facturaId')
            ->whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))->where('empresa_id', $empresa_id)
            ->get();

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
        $payments->appendChild($dom->createElement('NumberOfEntries', 0));
        $payments->appendChild($dom->createElement('TotalDebit', 0.00));
        $payments->appendChild($dom->createElement('TotalCredit', 0.00));
        //add payment em sourceDocuments
        $sourceDocuments->appendChild($payments);

        //Criar PurchaseInvoices e seus filhos
        $purchaseInvoices = $dom->createElement('PurchaseInvoices');
        $purchaseInvoices->appendChild($dom->createElement('NumberOfEntries', 0));
        //add PurchaseInvoices em sourceDocuments
        $sourceDocuments->appendChild($purchaseInvoices);



        $root->appendChild($sourceDocuments);






        //echo '<xmp>'. $dom->saveXML() .'</xmp>';
        //$dom->save('iva/saft.xml') or die('XML Create Error');


        return $dom->saveXML();
    }




    public function xmlSaft(Request $request)
    {

        $dataInicio = date("Y-m-d", strtotime($request->get('dataInicio')));
        $dataFinal = date("Y-m-d", strtotime($request->get('dataFinal')));

        $mensagem = [
            "dataInicio.required" => "É obrigatório a indicação de um valor para o campo data Inicio",
            "dataFinal.required" => "É obrigatório a indicação de um valor para o campo data Final",
        ];

        $validator = Validator::make($request->all(), [
            'dataInicio' => ['required'],
            'dataFinal' => ['required']
        ], $mensagem);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $facturaCount = Factura::whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))->where('empresa_id', $empresa['empresa']['id'])->count();

        $dataAtual = date("Y-m-d");
        if ($dataFinal > $dataAtual) {
            return response()->json(['isValid' => false, 'errors' => 'NA data final não deve ser maior que data actual'], 400);
        }
        if ($dataInicio > $dataFinal) {
        return response()->json(['isValid' => false, 'errors' => 'A data inicial não deve ser maior que data final'], 402);
        }
        if ($facturaCount <= 0) {
             return response()->json(['isValid' => false, 'errors' => 'Não foram efectuados nenhum documento nestes periodos'], 500);
        }


        $AuditFile = new AuditFile(); //instancia a classe principal

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];


        /*
        EMPRESA ADMIN - CRIADOR DO SOFTWARE
        */
        $empresa_ramos = Empresa::where('id', 1)->first();

        /*
        EMPRESA  - CLIENTES RAMOS 
        */
        $empresa = Empresa_Cliente::with('pais')->where('id', $empresa_id)->first();


        /*
        TODOS CLIENTES DA EMPRESA
        */
        $arrayIdsClientes = $this->clienteDocumentosIDs($dataInicio, $dataFinal);
        $clientes_empresa = Cliente::whereIn('id', $arrayIdsClientes)->where('empresa_id', $empresa_id)->get();

        /*
        TODOS OS PRODUTOS
        */
        $arrayIdsProdutos = $this->produtosDocumentosIDs($dataInicio, $dataFinal);

        $produtos = Produto::with('tipoTaxa')->whereIn('id', $arrayIdsProdutos)->where('empresa_id', $empresa_id)->get();



        /**
         * ID CLIENTE DIVERSOS
         */
        $clienteDiverso = Cliente::with('empresa')->where('empresa_id', $empresa_id)->where('diversos', 'sim')->first();


        /*
        PREENCHER O HEADER
        */
        $AuditFile->getHeader()->setCompanyID($empresa['nif']);
        $AuditFile->getHeader()->setTaxRegistrationNumber($empresa['nif']);
        $AuditFile->getHeader()->setTaxAccountingBasis("F");
        $AuditFile->getHeader()->setCompanyName($empresa['nome']);
        $AuditFile->getHeader()->setBusinessName($empresa['nome']);

        //Header->CompanyAddress
        $AuditFile->getHeader()->getCompanyAddress()->setAddressDetail($empresa['endereco']);
        $AuditFile->getHeader()->getCompanyAddress()->setCity($empresa['cidade']);
        $AuditFile->getHeader()->getCompanyAddress()->setCountry((string)$empresa['pais']['code']);
        //Fim Header->CompanyAddress


        $AuditFile->getHeader()->setFiscalYear((string)Carbon::parse(Carbon::now())->format('Y'));
        $AuditFile->getHeader()->setStartDate((string)$dataInicio);
        $AuditFile->getHeader()->setEndDate((string)$dataFinal);
        $AuditFile->getHeader()->setCurrencyCode("AOA");
        $AuditFile->getHeader()->setDateCreated((string)Carbon::parse(Carbon::now())->format('Y-m-d'));
        $AuditFile->getHeader()->setTaxEntity("Global");
        $AuditFile->getHeader()->setProductCompanyTaxID($empresa_ramos['nif']); //nif da empresa que desenvolveu software
        $AuditFile->getHeader()->setSoftwareValidationNumber("32/AGT/2019"); //depois a AGT vai disponibilizar este numero
        $AuditFile->getHeader()->setProductID("WinMarket Pro/OSVALDO MANUEL RAMOS-RAMOS SOFT P. DE SERVICOS"); //depois a AGT vai disponibilizar o productID
        $AuditFile->getHeader()->setProductVersion("10.5.19");
        $AuditFile->getHeader()->setTelephone($empresa['pessoal_Contacto']);
        $AuditFile->getHeader()->setEmail($empresa['email']);

        /*
        Preenche MasterFiles->Customer
        */
        $Customer = array();
        foreach ($clientes_empresa as $key => $value) {

            array_push($Customer, new Customer());
            $AuditFile->getMasterFiles()->setCustomer($Customer);

            if ($value->nif == '999999999') {

                $CustomerID = $clienteDiverso->id;
                $AccountID = "Desconhecido";
                $CustomerTaxID = $clienteDiverso->nif;
                $CompanyName = "Consumidor final";
                $AddressDetail = "Consumidor final";
                $City = "Desconhecido";
                $PostalCode = "Desconhecido";
                $Country = "AO";
            } else {

                $CustomerID = $value->id;
                $AccountID =  $value->conta_corrente;
                $CustomerTaxID = $value->nif;
                $CompanyName = $value->nome;
                $AddressDetail = $value['endereco'];
                $City = $value['cidade'];
                $PostalCode = "*";
                $Country = "AO";
            }
            $AuditFile->getMasterFiles()->getCustomer()[$key]->setCustomerID((string)$CustomerID);
            $AuditFile->getMasterFiles()->getCustomer()[$key]->setAccountID((string)$AccountID);
            $AuditFile->getMasterFiles()->getCustomer()[$key]->setCustomerTaxID((string)$CustomerTaxID);
            $AuditFile->getMasterFiles()->getCustomer()[$key]->setCompanyName((string)$CompanyName);

            //MasterFiles->Customer->BillingAddress
            $AuditFile->getMasterFiles()->getCustomer()[$key]->getBillingAddress()->setAddressDetail((string)$AddressDetail);
            $AuditFile->getMasterFiles()->getCustomer()[$key]->getBillingAddress()->setCity((string)$City);
            $AuditFile->getMasterFiles()->getCustomer()[$key]->getBillingAddress()->setPostalCode((string)$PostalCode);
            $AuditFile->getMasterFiles()->getCustomer()[$key]->getBillingAddress()->setCountry((string)$Country);
        }

        //Elimina customer repetidos;
        $collection = collect($Customer);
        $Customer = $collection->unique('CustomerTaxID');
        $AuditFile->getMasterFiles()->setCustomer($Customer);

        /**
         * Preenche MasterFiles->Product
         */
        $Product = array();

        foreach ($produtos as $key => $value) {
            array_push($Product, new Product());
            $AuditFile->getMasterFiles()->setProduct($Product);
            $AuditFile->getMasterFiles()->getProduct()[$key]->setProductType("P");
            $AuditFile->getMasterFiles()->getProduct()[$key]->setProductCode((string)$value->id);
            $AuditFile->getMasterFiles()->getProduct()[$key]->setProductDescription($value->designacao);
            $AuditFile->getMasterFiles()->getProduct()[$key]->setProductNumberCode((string) ($value->codigo_barra ? $value->codigo_barra : $value->id));
        }

        /**
         * return todos code taxa e motivos de todos produtos item de factura,factura recibo e nota de credito
         */
        $taxaMotivos =  $this->TaxasMotivos($produtos); //codigo taxa dos produtos sem repetição

        /**
         * Preenche MasterFiles->TaxTable->TaxTableEntry
         */

        $TaxTableEntry = array();
        $cont = 0;
        foreach ($taxaMotivos as $key => $taxas) {


            array_push($TaxTableEntry, new TaxTableEntry());
            // array_unshift(array_push($TaxTableEntry, new TaxTableEntry()));
            $AuditFile->getMasterFiles()->getTaxTable()->setTaxTableEntry($TaxTableEntry);

            if ($taxas->taxa) { //Se existe uma taxa
                $TaxType = "IVA";
            } else { //não existe uma taxa
                if ($taxas->codigoMotivo && $taxas->codigoMotivo >= 10) { //se foi setado um dos artigos
                    $TaxType = "IVA";
                } else {
                    $TaxType = "NS";
                }
            }
            $TaxCode = $taxas->taxa ? "NOR" : ($taxas->codigoMotivo >= 10 ? "ISE" : "NS");
            $Description = $taxas->taxa ? "Taxa Normal" : "Isenta";
            $TaxPercentage = $taxas->taxa;

            $AuditFile->getMasterFiles()->getTaxTable()->getTaxTableEntry()[$cont]->setTaxType($TaxType);
            $AuditFile->getMasterFiles()->getTaxTable()->getTaxTableEntry()[$cont]->setTaxCode($TaxCode);
            $AuditFile->getMasterFiles()->getTaxTable()->getTaxTableEntry()[$cont]->setDescription($Description);
            $AuditFile->getMasterFiles()->getTaxTable()->getTaxTableEntry()[$cont]->setTaxPercentage((string)$TaxPercentage);
            $cont++;
        }


        /**
         * Adicionar TaxTableEntry estatico
         */
        $this->adicionarNovoMotivoStatic($cont, $AuditFile, $TaxTableEntry);


        /**
         * QUANTIDADE DE FACTURAS, FACTURA RECIBOS NO INTERVALO DE DATA (INICIAL E FINAL)
         */
        $quantFacturas = DB::connection('mysql2')->table('facturas')
            ->whereBetween(DB::raw('DATE(facturas.created_at)'), array($dataInicio, $dataFinal))
            ->where('empresa_id', $empresa_id)
            ->where('status_id', 1)
            ->where(function ($query) {
                $query->where('facturas.tipo_documento', 1)
                    ->orWhere('facturas.tipo_documento', 2);
            })
            ->count();


        //QTD notas de creditos (facturas e facturas recibos anulados ou retificados)
        $quantNotaCredito = NotaCredito::with(['factura', 'factura.facturas_items', 'factura.formaPagamento'])->whereNotNull('facturaId')
            ->whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))->where('empresa_id', $empresa_id)
            ->count();



        $NumberOfEntries = $quantFacturas + $quantNotaCredito;

        /**
         * Todas as facturas anuladas onde o tipo documento é factura e factura recibo
         */
        $array_doc_anulados = NotaCredito::whereNotNull('facturaId')->where('anulado', 2)
            ->whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))->where('empresa_id', $empresa_id)
            ->get();

        $idsDocAnulados = [];
        foreach ($array_doc_anulados as $key => $docAnulado) {
            array_push($idsDocAnulados, $docAnulado->factura_id);
        }

        $TotalDebit = 0;
        $TotalCredit = 0;
        /**
         * Preenche SourceDocuments->SalesInvoices->Invoice
         * Todas facturas, e facturas recibo
         */

        $facturas = Factura::with(['facturas_items.produto.unidadeMedida', 'cliente', 'facturas_items.produto.tipoTaxa.motivo', 'facturas_items.produto.tipoTaxa', 'formaPagamento', 'tipoDocumento'])
            ->whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))
            ->where('empresa_id', $empresa_id)
            ->where('status_id', 1)
            ->where(function ($query) {
                $query->where('facturas.tipo_documento', 1)
                    ->orWhere('facturas.tipo_documento', 2);
            })
            ->get();



        $Invoice = array();
        //Todas as facturas
        foreach ($facturas as $key => $factura) {

            array_push($Invoice, new Invoice());

            if ($factura->retificado == "Sim") {
                $factura = FacturaOriginal::with(['facturas_items.produto.unidadeMedida', 'cliente', 'facturas_items.produto.tipoTaxa.motivo', 'facturas_items.produto.tipoTaxa', 'formaPagamento', 'tipoDocumento'])
                    ->where('numeracaoFactura', $factura->numeracaoFactura)
                    ->where('empresa_id', $empresa_id)
                    ->where(function ($query) {
                        $query->where('facturas_original.tipo_documento', 1)
                            ->orWhere('facturas_original.tipo_documento', 2);
                    })
                    ->first();
            } else {

                $factura = $factura;
            }

            $AuditFile->getSourceDocuments()->getSalesInvoices()->setInvoice($Invoice);
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->setInvoiceNo($factura['numeracaoFactura']);

            /**
             * Preenche SourceDocuments->SalesInvoices->Invoice->DocumentStatus
             */


            $InvoiceStatus = $factura['anulado'] === 2 ? "A" : "N";

            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getDocumentStatus()->setInvoiceStatus((string)$InvoiceStatus);
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getDocumentStatus()->setInvoiceStatusDate((string)(Carbon::parse($factura['updated_at'])->format('Y-m-d') . "T" . Carbon::parse($factura['updated_at'])->format("H:i:s")));
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getDocumentStatus()->setSourceID((string)Auth::user()->id);
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getDocumentStatus()->setSourceBilling("P");


            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->setHash($factura['hashValor']);
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->setPeriod((string)Carbon::parse($dataInicio)->format('m'));
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->setInvoiceDate((string)Carbon::parse($factura['created_at'])->format('Y-m-d'));


            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->setInvoiceType($factura['tipoDocumento']['sigla']);
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->setSourceID((string)$factura['user_id']);
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->setSystemEntryDate((string)(Carbon::parse($factura['created_at'])->format('Y-m-d') . "T" . Carbon::parse($factura['created_at'])->format("H:i:s")));

            /**
             * ID CLIENTE DIVERSOS
             * caso a factura o nif for 999999999 CustomerId será id do cliente diverso
             */
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->setCustomerID((string)($factura['cliente']['nif'] == '999999999' ? $clienteDiverso->id : $factura['cliente_id']));


            /**
             * Preenche SourceDocuments->SalesInvoices->Invoice->Line
             */
            $Line = array();
            $cont = 0;


            foreach ($factura->facturas_items as $keyFtItem => $ftItem) {
                array_push($Line, new Line());
                $cont++;


                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->setLine($Line);
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->setLineNumber((string)$cont);
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->setProductCode((string)$ftItem->produto_id);
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->setProductDescription((string)$ftItem->descricao_produto);
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->setQuantity((string)number_format($ftItem->quantidade_produto, 2, ".", ""));
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->setUnitOfMeasure((string)($ftItem->produto->unidadeMedida['designacao'] ? $ftItem->produto->unidadeMedida['designacao'] : "un"));
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->setUnitPrice((string)(number_format($ftItem->incidencia_produto / $ftItem->quantidade_produto, 2, ".", "")));

                //verificar depois essa TaxPointDate, estou em duvida
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->setTaxPointDate((string)(Carbon::parse($factura->created_at)->format('Y-m-d')));
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->setCreditAmount((string)number_format($ftItem->incidencia_produto, 2, ".", ""));
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->setDebitAmount("#");

                /**
                 * Preenche SourceDocuments->SalesInvoices->Invoice->Line->Tax
                 */

                if ($ftItem->produto->tipoTaxa->taxa > 0 || $ftItem->produto->motivoIsencao->codigo >= 10) { //se foi setado um dos artigos
                    $TaxType = "IVA";

                    if ($ftItem->produto->tipoTaxa->taxa == 0) {
                        //se não foi aplicado iva seta valores
                        $TaxExemptionReason = $ftItem->produto->motivoIsencao->descricao;
                        $TaxExemptionCode = $ftItem->produto->motivoIsencao->codigoMotivo;
                    } else {
                        //se foi aplicado IVA seta vazio
                        $TaxExemptionReason = "";
                        $TaxExemptionCode = "";
                    }
                } else {
                    $TaxType = "NS";
                    //se não foi aplicado iva seta valores
                    $TaxExemptionReason = $ftItem->produto->motivoIsencao->descricao;
                    $TaxExemptionCode = $ftItem->produto->motivoIsencao->codigoMotivo;
                }

                $TaxCode = $ftItem->produto->tipoTaxa->taxa ? "NOR" : ($TaxType == "NS" ? "NS" : "ISE");
                $Description = $ftItem->produto->tipoTaxa->taxa ? "Taxa Normal" : "Isenta";
                $TaxPercentage = $ftItem->produto->tipoTaxa->taxa;

                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->getTax()->setTaxType((string)$TaxType);
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->getTax()->setTaxCountryRegion("AO");
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->getTax()->setTaxCode((string)$TaxCode);
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->getTax()->setTaxPercentage((string)$TaxPercentage);
                /**
                 * fim SourceDocuments->SalesInvoices->Invoice->Line->Tax
                 */

                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->setTaxExemptionReason($TaxExemptionReason ? (string)$TaxExemptionReason : "#");
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->setTaxExemptionCode($TaxExemptionCode ? (string)$TaxExemptionCode : "#");
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getLine()[$keyFtItem]->setSettlementAmount((string)$ftItem->desconto_produto);
            }
            /**
             * Preenche SourceDocuments->SalesInvoices->Invoice->SpecialRegimes
             */
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getSpecialRegimes()->setSelfBillingIndicator("0");
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getSpecialRegimes()->setCashVATSchemeIndicator("0");
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getSpecialRegimes()->setThirdPartiesBillingIndicator("0");

            /**
             * Preenche SourceDocuments->SalesInvoices->Invoice->DocumentTotals
             */
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getDocumentTotals()->setTaxPayable(number_format($factura->total_iva, 2, ".", ""));
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getDocumentTotals()->setNetTotal(number_format($factura->total_incidencia, 2, ".", ""));

            /**
             * calculo Total Credito
             */

            if ($factura->anulado == 1) { // soma facturas não anuladas
                $TotalCredit += $factura->total_incidencia;
            }

            $GrossTotal = $factura->valor_a_pagar + $factura->retencao;
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getDocumentTotals()->setGrossTotal(number_format($GrossTotal, 2, ".", ""));

            /**
             * Preenche SourceDocuments->SalesInvoices->Invoice->DocumentTotals->Payment
             */

            $PaymentMechanism = $factura->formaPagamento ? $factura->formaPagamento->sigla_tipo_pagamento : "CC";
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getDocumentTotals()->getPayment()->setPaymentMechanism($PaymentMechanism);
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getDocumentTotals()->getPayment()->setPaymentAmount(number_format($factura->valor_a_pagar, 2, ".", ""));
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$key]->getDocumentTotals()->getPayment()->setPaymentDate((string)(Carbon::parse($factura->created_at)->format('Y-m-d')));
        }

        $AuditFile->getSourceDocuments()->getSalesInvoices()->setNumberOfEntries((string)$NumberOfEntries);
        $AuditFile->getSourceDocuments()->getSalesInvoices()->setTotalCredit(number_format($TotalCredit, 2, ".", ""));

        //Todas notas de creditos (facturas e facturas recibos anulados)
        $notaCreditos = NotaCredito::with(['cliente', 'factura', 'notaCreditoItems', 'notaCreditoItems.produto', 'notaCreditoItems.produto.unidadeMedida'])
            ->whereNotNull('facturaId')
            ->whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))->where('empresa_id', $empresa_id)
            ->get();

        //Todas as facturas
        foreach ($notaCreditos as $key => $nc) {

            $cont = count($Invoice);

            array_push($Invoice, new Invoice());
            $AuditFile->getSourceDocuments()->getSalesInvoices()->setInvoice($Invoice);
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->setInvoiceNo($nc->numeracaoDocumento);


            /**
             * Preenche SourceDocuments->SalesInvoices->Invoice->DocumentStatus
             */

            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getDocumentStatus()->setInvoiceStatus("N");
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getDocumentStatus()->setInvoiceStatusDate((string)(Carbon::parse($nc->updated_at)->format('Y-m-d') . "T" . Carbon::parse($nc->updated_at)->format("H:i:s")));
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getDocumentStatus()->setSourceID((string)$nc->user_id);
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getDocumentStatus()->setSourceBilling("P");
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->setHash($nc->hash);
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->setPeriod((string)Carbon::parse($dataInicio)->format('m'));
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->setInvoiceDate((string)Carbon::parse($nc->created_at)->format('Y-m-d'));
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->setInvoiceType("NC");
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->setSourceID((string)($nc->user_id));
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->setSystemEntryDate((string)(Carbon::parse($nc->created_at)->format('Y-m-d') . "T" . Carbon::parse($nc->created_at)->format("H:i:s")));
            /**
             * ID CLIENTE DIVERSOS
             * caso a nota credito do cliente o nif for 999999999 CustomerId será id do cliente diverso
             */
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->setCustomerID((string)($nc->cliente->nif == '999999999' ? $clienteDiverso->id : $nc->cliente_id));

            /**
             * Preenche SourceDocuments->SalesInvoices->Invoice->Line
             */
            $Line = array();
            $contLine = 0;
            foreach ($nc->notaCreditoItems as $key => $nfItem) {

                $contLine++;
                array_push($Line, new LineNotaCredito());
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->setLine($Line);
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->setLineNumber((string)$contLine);
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->setProductCode((string)$nfItem->produto_id);
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->setProductDescription((string)$nfItem->descricao_produto);
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->setQuantity((string)number_format(($nfItem->quantidade_produto), 2, ".", ""));
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->setUnitOfMeasure((string)($nfItem->produto->unidadeMedida['designacao'] ? $nfItem->produto->unidadeMedida['designacao'] : "un"));
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->setUnitPrice((string)number_format(($nfItem->incidencia_produto / $nfItem->quantidade_produto), 2, ".", ""));
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->setTaxPointDate((string)(Carbon::parse($nfItem->created_at)->format('Y-m-d')));

                /**
                 * Preenche SourceDocuments->SalesInvoices->Invoice->Line->References
                 */
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->getReferences()->setReference((string)$nc->factura->numeracaoFactura);
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->getReferences()->setReason($nc->descricao);


                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->setCreditAmount("#");
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->setDebitAmount((string)number_format(($nfItem->incidencia_produto), 2, ".", ""));


                /**
                 * Preenche SourceDocuments->SalesInvoices->Invoice->Line->Tax
                 */
                if ($nfItem->produto->tipoTaxa->taxa > 0 || $nfItem->produto->motivoIsencao->codigo >= 10) { //se foi setado um dos artigos
                    $TaxType = "IVA";

                    if ($nfItem->produto->tipoTaxa->taxa == 0) {
                        //se não foi aplicado iva seta valores
                        $TaxExemptionReason = $nfItem->produto->motivoIsencao->descricao;
                        $TaxExemptionCode = $nfItem->produto->motivoIsencao->codigoMotivo;
                    } else {
                        //se foi aplicado IVA seta vazio
                        $TaxExemptionReason = "";
                        $TaxExemptionCode = "";
                    }
                } else {
                    $TaxType = "NS";
                    //se não foi aplicado iva seta valores
                    $TaxExemptionReason = $nfItem->produto->motivoIsencao->descricao;
                    $TaxExemptionCode = $nfItem->produto->motivoIsencao->codigoMotivo;
                }

                $TaxCode = $nfItem->produto->tipoTaxa->taxa ? "NOR" : ($TaxType == "NS" ? "NS" : "ISE");
                $Description = $nfItem->produto->tipoTaxa->taxa ? "Taxa Normal" : "Isenta";
                $TaxPercentage = $nfItem->produto->tipoTaxa->taxa;


                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->getTax()->setTaxType((string)$TaxType);
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->getTax()->setTaxCountryRegion("AO");
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->getTax()->setTaxCode((string)$TaxCode);
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->getTax()->setTaxPercentage((string)$TaxPercentage);
                /**
                 * fim SourceDocuments->SalesInvoices->Invoice->Line->Tax
                 */
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->setTaxExemptionReason($TaxExemptionReason ? (string)$TaxExemptionReason : "#");
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->setTaxExemptionCode($TaxExemptionCode ? (string)$TaxExemptionCode : "#");
                $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getLine()[$key]->setSettlementAmount((string)$nfItem->desconto_produto);
            }
            /**
             * Preenche SourceDocuments->SalesInvoices->Invoice->SpecialRegimes
             */
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getSpecialRegimes()->setSelfBillingIndicator("0");
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getSpecialRegimes()->setCashVATSchemeIndicator("0");
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getSpecialRegimes()->setThirdPartiesBillingIndicator("0");

            /**
             * Preenche SourceDocuments->SalesInvoices->Invoice->DocumentTotals
             */

            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getDocumentTotals()->setTaxPayable(number_format($nc->total_iva, 2, ".", ""));
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getDocumentTotals()->setNetTotal(number_format($nc->total_incidencia, 2, ".", ""));

            $TotalDebit += $nc->total_incidencia;
            /**
             *verificar depois com o henriques o valor  setGrossTotal 
             */
            $GrossTotal = $nc->valor_a_pagar + $nc->retencao;
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getDocumentTotals()->setGrossTotal(number_format($GrossTotal, 2, ".", ""));

            /**
             * Preenche SourceDocuments->SalesInvoices->Invoice->DocumentTotals->Payment
             */
            $PaymentMechanism = "OU";
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getDocumentTotals()->getPayment()->setPaymentMechanism($PaymentMechanism);
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getDocumentTotals()->getPayment()->setPaymentAmount(number_format($nc->valor_a_pagar, 2, ".", ""));
            $AuditFile->getSourceDocuments()->getSalesInvoices()->getInvoice()[$cont]->getDocumentTotals()->getPayment()->setPaymentDate((string)(Carbon::parse($nc->created_at)->format('Y-m-d')));

            $cont++;
        }

        $AuditFile->getSourceDocuments()->getSalesInvoices()->setTotalDebit(number_format($TotalDebit, 2, ".", ""));

        /**
         * Preenche SourceDocuments->MovementOfGoods
         */
        $AuditFile->getSourceDocuments()->getMovementOfGoods()->setNumberOfMovementLines("0");
        $AuditFile->getSourceDocuments()->getMovementOfGoods()->setTotalQuantityIssued("0.00");

        /**
         * Preenche SourceDocuments->SalesInvoices->WorkingDocuments
         */
        //Lista apenas facturas proformas
        $countFtProforma = Factura::where('empresa_id', $empresa_id)->where('tipo_documento', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))
            ->count();



        $TotalDebit = 0;
        $TotalCredit = 0;

        $facturas_proforma = Factura::with(['facturas_items.produto.unidadeMedida', 'tipoDocumento', 'facturas_items', 'facturas_items.produto.tipoTaxa.motivo', 'facturas_items.produto.tipoTaxa', 'formaPagamento'])
            ->where('empresa_id', $empresa_id)
            ->where('tipo_documento', 3)
            ->whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))
            ->get();

        $AuditFile->getSourceDocuments()->getWorkingDocuments()->setNumberOfEntries((string)$countFtProforma);

        /**
         * Preenche SourceDocuments->WorkingDocuments->WorkDocument
         */
        if (!$facturas_proforma) {
            dd($facturas_proforma . " SEM FACTURA PROFORMA");
        }
        $WorkDocument = array();
        foreach ($facturas_proforma as $key => $ftProforma) {


            array_push($WorkDocument, new WorkDocument());
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->setWorkDocument($WorkDocument);
            $DocumentNumber = str_replace("FP", "PP", $ftProforma->numeracaoFactura);
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->setDocumentNumber($DocumentNumber);


            /**
             * Preenche SourceDocuments->WorkingDocuments->WorkDocument->DocumentStatus
             */

            $WorkStatus = $ftProforma->anulado === 2 ? "A" : "N";

            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getDocumentStatus()->setWorkStatus($WorkStatus);
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getDocumentStatus()->setWorkStatusDate((string)(Carbon::parse($ftProforma->updated_at)->format('Y-m-d') . "T" . Carbon::parse($ftProforma->updated_at)->format("H:i:s")));

            //Reason não é obrigatorio arranjar forma de remover o set
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getDocumentStatus()->setReason("");
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getDocumentStatus()->setSourceID((string)$ftProforma->user_id);
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getDocumentStatus()->setSourceBilling("P");

            //fim SourceDocuments->WorkingDocuments->WorkDocument->DocumentStatus

            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->setHash($ftProforma->hashValor);

            /**
             * Verificar setHashControl com henriques
             */
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->setHashControl("1");
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->setPeriod((string)Carbon::parse($dataInicio)->format('m'));
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->setWorkDate((string)Carbon::parse($ftProforma->created_at)->format('Y-m-d'));
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->setWorkType("PP");
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->setSourceID((string)$ftProforma->user_id);

            /**
             * valor TransactionID verificar com o henriques
             */
            //$AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->setTransactionID("");

            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->setSystemEntryDate((string)(Carbon::parse($ftProforma->created_at)->format('Y-m-d') . "T" . Carbon::parse($ftProforma->created_at)->format("H:i:s")));
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->setCustomerID((string)($ftProforma->cliente->nif == '999999999' ? $clienteDiverso->id : $ftProforma->cliente_id));

            /**
             * Preenche SourceDocuments->WorkingDocuments->WorkDocument->Line
             */

            $Line = array();
            $cont = 0;
            foreach ($ftProforma->facturas_items as $keyFtPItem => $ftPItem) {
                array_push($Line, new WorkDocumentsLine());
                $cont++;
                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->setLine($Line);

                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->setLineNumber((string)$cont);
                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->setProductCode((string)$ftPItem->produto_id);
                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->setProductDescription((string)$ftPItem->descricao_produto);
                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->setQuantity((string)$ftPItem->quantidade_produto);
                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->setUnitOfMeasure((string)($ftPItem->produto->unidadeMedida['designacao'] ? $ftPItem->produto->unidadeMedida['designacao'] : "un"));
                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->setUnitPrice((string)(number_format(($ftPItem->incidencia_produto / $ftPItem->quantidade_produto), 2, ".", "")));

                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->setTaxPointDate((string)(Carbon::parse($ftPItem->created_at)->format('Y-m-d')));
                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->setCreditAmount((string)(number_format($ftPItem->incidencia_produto, 2, ".", "")));

                /**
                 * Preenche SourceDocuments->getWorkingDocuments->getWorkDocument->Line->Tax
                 */
                if ($ftPItem->produto->tipoTaxa->taxa > 0 || $ftPItem->produto->motivoIsencao->codigo >= 10) { //se foi setado um dos artigos
                    $TaxType = "IVA";

                    if ($ftPItem->produto->tipoTaxa->taxa == 0) {
                        //se não foi aplicado iva seta valores
                        $TaxExemptionReason = $ftPItem->produto->motivoIsencao->descricao;
                        $TaxExemptionCode = $ftPItem->produto->motivoIsencao->codigoMotivo;
                    } else {
                        //se foi aplicado IVA seta vazio
                        $TaxExemptionReason = "";
                        $TaxExemptionCode = "";
                    }
                } else {
                    $TaxType = "NS";
                    //se não foi aplicado iva seta valores
                    $TaxExemptionReason = $ftPItem->produto->motivoIsencao->descricao;
                    $TaxExemptionCode = $ftPItem->produto->motivoIsencao->codigoMotivo;
                }

                $TaxCode = $ftPItem->produto->tipoTaxa->taxa ? "NOR" : ($TaxType == "NS" ? "NS" : "ISE");
                $Description = $ftPItem->produto->tipoTaxa->taxa ? "Taxa Normal" : "Isenta";
                $TaxPercentage = $ftPItem->produto->tipoTaxa->taxa;

                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->getTax()->setTaxType((string)$TaxType);
                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->getTax()->setTaxCountryRegion("AO");
                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->getTax()->setTaxCode((string)$TaxCode);
                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->getTax()->setTaxPercentage((string)$TaxPercentage);

                // dd($TaxExemptionReason);
                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->setTaxExemptionReason($TaxExemptionReason ? (string) $TaxExemptionReason : "#");
                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->setTaxExemptionCode($TaxExemptionCode ? (string)$TaxExemptionCode : "#");

                $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getLine()[$keyFtPItem]->setSettlementAmount((string)$ftPItem->desconto_produto);
            }

            /**
             * Preenche SourceDocuments->WorkingDocuments->WorkDocument->DocumentTotals
             */

            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getDocumentTotals()->setTaxPayable(number_format($ftProforma->total_iva, 2, ".", ""));
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getDocumentTotals()->setNetTotal(number_format($ftProforma->total_incidencia, 2, ".", ""));

            /**
             * Calculo do GrossTotal
             */
            $GrossTotal = $ftProforma->valor_a_pagar + $ftProforma->retencao;
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->getWorkDocument()[$key]->getDocumentTotals()->setGrossTotal(number_format($GrossTotal, 2, ".", ""));


            $TotalCredit += $ftProforma->total_incidencia;
        }

        /**
         * calculo Total Credito
         */

        //dd(count($facturas_proforma));
        if (count($facturas_proforma) > 0) {

            $TotalCredit = $TotalCredit;

            $AuditFile->getSourceDocuments()->getWorkingDocuments()->setTotalDebit((string)$TotalDebit); //sempre será 0
            $AuditFile->getSourceDocuments()->getWorkingDocuments()->setTotalCredit((string)$TotalCredit);
        }


        /**
         * Preenche SourceDocuments->Payments
         */
        //Qtd de recibos(incluindo os anulados)
        $quantRecibos = DB::connection('mysql2')->table('recibos')
            ->whereBetween(DB::raw('DATE(recibos.created_at)'), array($dataInicio, $dataFinal))
            ->where('empresa_id', $empresa_id)
            ->count();


        /**
         * Verificar depois o valor totalCredit com o henriques
         */
        $TotalCredit = DB::connection('mysql2')->table('recibos')
            ->where('anulado', 1) //recibo não anulado
            ->whereBetween(DB::raw('DATE(recibos.created_at)'), array($dataInicio, $dataFinal))
            ->where('empresa_id', $empresa_id)->sum('valor_total_entregue');


        $TotalDebit = 0;
        $TotalDebit = number_format($TotalDebit, 2, ".", "");
        $TotalCredit = number_format($TotalCredit, 2, ".", "");

        $AuditFile->getSourceDocuments()->getPayments()->setNumberOfEntries((string)$quantRecibos);
        $AuditFile->getSourceDocuments()->getPayments()->setTotalDebit((string)$TotalDebit); //sempre será 0
        $AuditFile->getSourceDocuments()->getPayments()->setTotalCredit((string)$TotalCredit);

        /**
         * Preenche SourceDocuments->Payments->Payment
         */
        $recibos = Recibos::with(['formaPagamento', 'recibos_items.factura', 'recibos_items', 'cliente'])->where('empresa_id', $empresa_id)
            ->whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))
            ->get();

        $Payment = array();
        foreach ($recibos as $key => $recibo) {

            array_push($Payment, new Payment());


            $AuditFile->getSourceDocuments()->getPayments()->setPayment($Payment);
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->setPaymentRefNo((string)$recibo->numeracao_recibo);
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->setPeriod((string)Carbon::parse($dataInicio)->format('m'));
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->setTransactionDate((string)(Carbon::parse($recibo->created_at)->format('Y-m-d')));
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->setPaymentType("RC");

            $Description = $recibo->observacao ? $recibo->observacao : "Emitir Recibo";
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->setDescription((string)$Description);
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->setSystemID((string)$recibo->id);

            /**
             * Preenche SourceDocuments->Payments->Payment->DocumentStatus
             */

            $PaymentStatus = $recibo->anulado === 1 ? "N" : "A";

            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getDocumentStatus()->setPaymentStatus((string)$PaymentStatus);
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getDocumentStatus()->setPaymentStatusDate((string)(Carbon::parse($recibo->updated_at)->format('Y-m-d') . "T" . Carbon::parse($recibo->updated_at)->format("H:i:s")));
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getDocumentStatus()->setSourceID((string)$recibo->user_id);
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getDocumentStatus()->setSourcePayment("P");

            /**
             * Preenche SourceDocuments->Payments->Payment->PaymentMethod
             */

            // dd($recibo->formaPagamento);

            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getPaymentMethod()->setPaymentMechanism((string)$recibo->formaPagamento->sigla_tipo_pagamento);
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getPaymentMethod()->setPaymentAmount((string)($TotalDebit = number_format($recibo->valor_total_entregue, 2, ".", "")));
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getPaymentMethod()->setPaymentDate((string)(Carbon::parse($recibo->created_at)->format('Y-m-d')));

            if ($recibo->cliente->nif == '999999999') {
                $CustomerID = $clienteDiverso->id;
            } else {
                $CustomerID = $recibo->cliente_id;
            }
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->setSourceID((string)Auth::user()->id);
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->setSystemEntryDate((string)(Carbon::parse($recibo->created_at)->format('Y-m-d') . "T" . Carbon::parse($recibo->updated_at)->format("H:i:s")));
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->setCustomerID((string)$CustomerID);

            /**
             * Preenche SourceDocuments->Payments->Payment->Line
             */

            // dd($recibo);
            $Line = array();
            $cont = 0;
            foreach ($recibo->recibos_items as $keyItem => $reciboItem) {

                // dd($reciboItem);

                array_push($Line, new PaymentLine());
                $cont++;
                $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->setLine($Line);
                $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getLine()[$keyItem]->setLineNumber((string)$cont);

                /**
                 * Preenche SourceDocuments->Payments->Payment->Line->SourceDocumentID
                 */
                $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getLine()[$keyItem]->getSourceDocumentID()->setOriginatingON((string)$reciboItem->factura->numeracaoFactura);
                $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getLine()[$keyItem]->getSourceDocumentID()->setInvoiceDate((string)(Carbon::parse($reciboItem->factura->created_at)->format('Y-m-d')));
                $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getLine()[$keyItem]->getSourceDocumentID()->setDescription((string)$reciboItem->descricao);

                //fim SourceDocuments->Payments->Payment->Line->SourceDocumentID
                $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getLine()[$keyItem]->setCreditAmount((string)(number_format($reciboItem->valor_entregue, 2, ".", "")));
            }
            /**
             * Preenche SourceDocuments->Payments->Payment->DocumentTotals
             */
            $TaxPayable = 0;
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getDocumentTotals()->setTaxPayable((string)(number_format($TaxPayable, 2, ".", "")));
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getDocumentTotals()->setNetTotal((string)(number_format($recibo->valor_total_entregue, 2, ".", "")));
            $AuditFile->getSourceDocuments()->getPayments()->getPayment()[$key]->getDocumentTotals()->setGrossTotal((string)(number_format($recibo->valor_total_entregue, 2, ".", "")));
            //fim SourceDocuments->Payments->Payment->DocumentTotals

        }



        // $array = get_object_vars($AuditFile);
        // echo '<pre>';
        // print_r($AuditFile);
        // echo '</pre>';

        $array = json_decode(json_encode($AuditFile), true); //converte class para array
        $response = ArrayToXml::convert($array, [
            'rootElementName' => 'AuditFile',
            '_attributes' => [
                'xmlns:xsi' => 'http://www.w3.org/2001/XMLSchema-instance',
                'xsi:schemaLocation' => 'urn:OECD:StandardAuditFile-Tax:AO_1.01_01 SAFTAO1.01_01.xsd',
                'xmlns' => 'urn:OECD:StandardAuditFile-Tax:AO_1.01_01'
            ],
        ], true, 'UTF-8');



        //Replace para tag não usados
        $response = str_replace("<DebitAmount>#</DebitAmount>", "", $response);
        $response = str_replace("<CreditAmount>#</CreditAmount>", "", $response);



        $response = str_replace("<Reason/>", "", $response);


        $response = str_replace("<TaxExemptionReason>#</TaxExemptionReason>", "", $response);
        $response = str_replace("<TaxExemptionCode>#</TaxExemptionCode>", "", $response);


        //$response = str_replace("<TransactionID/>", "<TransactionID><TransactionID/>", $response);

        //sem factura proforma retira a tag <WorkDocument/>
        if (!count($facturas_proforma)) {
            $response  =  str_replace("<WorkDocument/>", "", $response);
        }

        //sem facturas e facturas recibos
        if (!count($facturas)) {
            $response  =  str_replace("<Invoice/>", "", $response);
            $response = str_replace("<SalesInvoices><NumberOfEntries>0</NumberOfEntries><TotalDebit>0.00</TotalDebit><TotalCredit>0.00</TotalCredit></SalesInvoices>", "", $response);
        }

        //sem recibo retira a tag <Payment/>
        if (!count($recibos)) {
            $response  =  str_replace("<Payment/>", "", $response);
        }

        return $response;
    }

    /**
     * Listar todos ids de clientes que tem documentos
     * Retorna array de ids de clientes sem repetição
     */
    public function clienteDocumentosIDs($dataInicio, $dataFinal)
    {
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];


        //Clientes com Facturas, facturas recibos
        $clientesIDsFactura =  DB::connection('mysql2')->table('facturas')->distinct('cliente_id')->where('empresa_id', $empresa_id)->select('cliente_id')->where('status_id', 1)
            ->whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))
            ->where(function ($query) {
                $query->where('tipo_documento', 1)
                    ->orWhere('tipo_documento', 2)
                    ->orWhere('tipo_documento', 3);
            })
            ->get();


        //Clientes com recibos
        $clienteIDsRecibos =  DB::connection('mysql2')->table('recibos')->distinct('cliente_id')
            ->whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))
            ->where('empresa_id', $empresa_id)->select('cliente_id')->get();


        //clientes com documentos anulados
        $clienteIDsNotaCredioAnulacaoRetificados = DB::connection('mysql2')->table('notas_credito')->distinct('cliente_id')
            ->whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))
            ->where('empresa_id', $empresa_id)->select('cliente_id')->get();

        $arrayIds = array();

        foreach ($clientesIDsFactura as $key => $ft) {
            array_push($arrayIds, $ft->cliente_id);
        }
        foreach ($clienteIDsRecibos as $key => $rc) {
            array_push($arrayIds, $rc->cliente_id);
        }
        foreach ($clienteIDsNotaCredioAnulacaoRetificados as $key => $nc) {
            array_push($arrayIds, $nc->cliente_id);
        }

        $collection = collect($arrayIds);
        $array = $collection->unique();

        return $array;
    }

    /**
     * response_produtos
     * return todos os ids dos produtos que foram feito faturas, factura recibo, recibos, 
     * e depois será feita as facturas rectificadas
     */
    public function produtosDocumentosIDs($dataInicio, $dataFinal)
    {

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa_id = $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'];

        /***
         * return todos os idProdutos de facturas, facturas recibo
         */
        $idFactura_FacturaRecibo_ftProforma =  $this->produtosIDsFactura_FacturaRecibo_ftProforma($dataInicio, $dataFinal, $empresa_id);


        /***
         * return todos os idProdutos de facturas e facturas recibos anulados
         */
        $idprodutosIdsFacturasAnuladas = $this->produtosIDsFacturasAnuladas($dataInicio, $dataFinal, $empresa_id);
        /***
         * return todos os idProdutos recibos anulados
         */
        $idProdutoRecibosAnulados = $this->produtosIdsRecibosAnulados($dataInicio, $dataFinal, $empresa_id);

        $array_union = array_merge($idFactura_FacturaRecibo_ftProforma, $idprodutosIdsFacturasAnuladas, $idProdutoRecibosAnulados);

        $collection = collect($array_union);

        $array = $collection->unique();

        return $array;
    }

    //Todos os produtos de facturas anuladas
    public function produtosIDsFacturasAnuladas($dataInicio, $dataFinal, $empresa_id)
    {

        $produtosIDsFacturasAnuladas = NotaCredito::with('factura', 'factura.facturas_items')->where('anulado', 2)->whereNotNull('facturaId')
            ->whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))->where('empresa_id', $empresa_id)
            ->select('notas_credito.facturaId')
            ->get();


        $arrayIds = array();
        foreach ($produtosIDsFacturasAnuladas as $key => $ftAnulado) {
            foreach ($ftAnulado->factura->facturas_items as $ft_items) {
                array_push($arrayIds, $ft_items->produto_id);
            }
        }

        return $arrayIds;
    }

    //retorna todos os id de facturas, facturas recibos e proforma
    public function produtosIDsFactura_FacturaRecibo_ftProforma($dataInicio, $dataFinal, $empresa_id)
    {

        $produtosIDsFactura_FacturaRecibo_ftProforma =  DB::connection('mysql2')->table('facturas')
            ->join('factura_items', 'facturas.id', '=', 'factura_items.factura_id')
            ->distinct('produto_id')->where('facturas.empresa_id', $empresa_id)
            ->whereBetween(DB::raw('DATE(facturas.created_at)'), array($dataInicio, $dataFinal))
            ->select('factura_items.produto_id')
            ->where(function ($query) {
                $query->where('facturas.tipo_documento', 1)
                    ->orWhere('facturas.tipo_documento', 2)
                    ->orWhere('facturas.tipo_documento', 3);
            })
            ->get();



        $arrayIds = array();
        foreach ($produtosIDsFactura_FacturaRecibo_ftProforma as $key => $ft) {
            array_push($arrayIds, $ft->produto_id);
        }

        return $arrayIds;
    }

    //Todos ids produtos de recibos anulados
    public function produtosIdsRecibosAnulados($dataInicio, $dataFinal, $empresa_id)
    {

        $arrayRecibosAnulados = Recibos::whereBetween(DB::raw('DATE(created_at)'), array($dataInicio, $dataFinal))->where('anulado', 2)->where('empresa_id', $empresa_id)
            ->select('id')
            ->get();


        //armazena todos ids recibos anulados
        $idsArrayRecibosAnulados = array();
        foreach ($arrayRecibosAnulados as $array) {
            array_push($idsArrayRecibosAnulados, $array->id);
        }

        //seleciona todas id factura dos recibos anulados
        $array_facturaId = RecibosItem::whereIn('recibo_id', $idsArrayRecibosAnulados)->where('empresa_id', $empresa_id)
            ->select('factura_id')
            ->get();

        $idsArrayFacturasAnuladas = array(); //armazena todos ids facturas anuladas
        foreach ($array_facturaId as $array) {
            array_push($idsArrayFacturasAnuladas, $array->factura_id);
        }
        //Pega todas as facturas anuladas para posterior pegar os seus produtos
        $facturasAnuladas = Factura::with('facturas_items')->whereIn('id', $idsArrayFacturasAnuladas)->where('empresa_id', $empresa_id)
            ->get();

        $arrayIds = array();
        foreach ($facturasAnuladas as $key => $ft_anuladas) {
            foreach ($ft_anuladas->facturas_items as $key => $ft_items) {
                array_push($arrayIds, $ft_items->produto_id);
            }
        }
        return $arrayIds;
    }
    //retorna todas as taxas sem repetição dos produtos com documentos
    public function TaxasMotivos($produtos)
    {
        $taxaMotivos = array();
        foreach ($produtos as $key => $value) {
            array_push($taxaMotivos, $value->tipoTaxa);
        }

        $collection = collect($taxaMotivos);

        $array = $collection->unique();

        return $array;
    }

    public function adicionarNovoMotivoStatic($cont, $AuditFile, $TaxTableEntry)
    {

        array_push($TaxTableEntry, new TaxTableEntry());
        // array_unshift(array_push($TaxTableEntry, new TaxTableEntry()));
        $AuditFile->getMasterFiles()->getTaxTable()->setTaxTableEntry($TaxTableEntry);

        $TaxType = "NS";
        $TaxCode = "NS";
        $Description = "Isenta";
        $TaxPercentage = 0;

        $AuditFile->getMasterFiles()->getTaxTable()->getTaxTableEntry()[$cont]->setTaxType($TaxType);
        $AuditFile->getMasterFiles()->getTaxTable()->getTaxTableEntry()[$cont]->setTaxCode($TaxCode);
        $AuditFile->getMasterFiles()->getTaxTable()->getTaxTableEntry()[$cont]->setDescription($Description);
        $AuditFile->getMasterFiles()->getTaxTable()->getTaxTableEntry()[$cont]->setTaxPercentage((string)$TaxPercentage);
    }
}
