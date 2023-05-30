<?php

namespace App\Http\Controllers\Api\Facturas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\empresa\ReportShowApiController;
use App\Http\Controllers\empresa\ReportShowController;
use App\Http\Controllers\empresa\VerificadorDocumento;
use App\Http\Controllers\TypeInvoice;
use App\Repositories\Empresa\FacturaRepository;
use App\Repositories\Empresa\TraitChavesEmpresa;
use App\Repositories\Empresa\TraitSerieDocumento;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Keygen\Keygen;
use phpseclib\Crypt\RSA;
use NumberFormatter;
use Illuminate\Support\Facades\Validator;

class FacturaCreateController extends Controller
{
    use TraitSerieDocumento;
    use TraitChavesEmpresa;
    private $facturaRepository;


    public function __construct(FacturaRepository $facturaRepository)
    {

        $this->facturaRepository = $facturaRepository;
    }

    public function store(Request $factura)
    {

        $messages = [
            'total_preco_factura.required' => 'Informe o total da fatura',
            'valor_a_pagar.required' => 'Informe o valor a pagar',
            'cliente_id.required' => 'Informe o cliente',
            'facturas_items.*.id.required' => 'Informe um item da fatura',
        ];
        $validator = Validator::make($factura->all(), [
            'total_preco_factura' => "required",
            'valor_a_pagar' => "required",
            'cliente_id' => "required",
            'facturas_items' => "required",
            'valor_entregue' => [function ($attr, $valorEntregue, $fail) use ($factura) {
                if ($factura->formas_pagamento_id != 2 && $valorEntregue <= 0) {
                    $fail('Informe o valor entregue');
                }
            }]
        ], $messages);

        if ($validator->fails()) {
            return response()->json($validator->errors()->messages(), 400);
        }

        $verificadorDocumento = new VerificadorDocumento('facturas');

        if (!$verificadorDocumento->comparaDataDocumentoAnteriorComActual()) {
            return [
                "errors" => "A data deste documento ao inferior a anterior", "status" => 401
            ];
        }

        if ($factura['tipo_documento'] == TypeInvoice::FACTURA) {
            $facturas = $this->pegarUltimaFactura(TypeInvoice::FACTURA);
            $factura['statusFactura'] = TypeInvoice::STATUS_DIVIDA;
        }
        if ($factura['tipo_documento'] == TypeInvoice::FACTURA_RECIBO) {
            $facturas = $this->pegarUltimaFactura(TypeInvoice::FACTURA_RECIBO);
            $factura['statusFactura'] = TypeInvoice::STATUS_PAGO;
        }
        if ($factura['tipo_documento'] == TypeInvoice::FACTURA_PROFORMA) {
            $facturas = $this->pegarUltimaFactura(TypeInvoice::FACTURA_PROFORMA);
            $factura['statusFactura'] = TypeInvoice::STATUS_PAGO;
        }

        /**
         * hashAnterior inicia vazio
         */
        $hashAnterior = "";
        if ($facturas) {
            $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
            $hashAnterior = $facturas->hashValor;
        } else {
            $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        //ManipulaÃ§Ã£o de datas: data da factura e data actual
        //$data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        /*Recupera a sequÃªncia numÃ©rica da Ãºltima factura cadastrada no banco de dados e adiona sempre 1 na sequÃªncia caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequÃªncia numÃ©rica caso se constate que o ano da factura Ã© inferior ao ano actual.*/
        if ($data_factura->diffInYears($datactual) == 0) {
            if ($facturas) {
                $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
                $numSequenciaFactura = intval($facturas->numSequenciaFactura) + 1;
            } else {
                $data_factura = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaFactura = 1;
            }
        } else if ($data_factura->diffInYears($datactual) > 0) {
            $numSequenciaFactura = 1;
        }

        /*Cria uma sÃ©rie de numerÃ§Ã£o para cada factura, variando de acordo o tipo de factura, a o ano actual e numero sequencial da factura */
        if ($factura['tipo_documento'] == TypeInvoice::FACTURA) {
            $diasVencimentoFactura = $this->diasVencimentoFactura();
            $numeracaoFactura = 'FT ' . $this->mostrarSerieDocumento() . date('Y') . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
            // dd(Carbon::now()->addDays($diasVencimentoFactura));
            $factura['data_vencimento'] = Carbon::now()->addDays($diasVencimentoFactura);
        }
        if ($factura['tipo_documento'] == TypeInvoice::FACTURA_RECIBO) {
            $factura['data_vencimento'] = NULL;
            $numeracaoFactura = 'FR ' . $this->mostrarSerieDocumento() . date('Y') . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
        }

        $rsa = new RSA(); //Algoritimo RSA

        $privatekey = $this->pegarChavePrivada();
        $publickey = $this->pegarChavePublica();

        // Lendo a private key
        $rsa->loadKey($privatekey);

        /*Texto que deverÃ¡ ser assinado com a assinatura RSA::SIGNATURE_PKCS1, e o Texto estarÃ¡ mais ou menos assim apÃ³s as
        ConcatenaÃ§Ãµes com os dados preliminares da factura: 2020-09-14;2020-09-14T20:34:09;FP PAT2020/1;457411.2238438; */

        //dd($request->total_retencao);
        // $total_preco_factura = $request->total_preco_factura - $request->desconto;
        // $totalRetencao  = $total_preco_factura * $request->retencao;

        $totalRetencao = $factura['retencao'];

        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoFactura . ';' . number_format($factura['valor_a_pagar'] + $totalRetencao, 2, ".", "") . ';' . $hashAnterior;

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenaÃ§Ãµes)

        // Lendo a public key
        $rsa->loadKey($publickey);

        $f = new NumberFormatter("pt", NumberFormatter::SPELLOUT);

        $cliente = DB::table('clientes')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('id', $factura['cliente_id'])
            ->first();

        if (!$cliente) {
            $cliente = DB::table('clientes')
                ->where('diversos', 'Sim')
                ->where('empresa_id', auth()->user()->empresa_id)
                ->where('id', $factura['cliente_id'])
                ->first();
        }

        try {

            DB::beginTransaction();

            $facturaId = DB::table('facturas')->insertGetId([
                'total_preco_factura' => $factura['total_preco_factura'],
                'valor_a_pagar' => $factura['tipo_documento'] == TypeInvoice::FACTURA ? 0 : $factura['valor_a_pagar'] ?? 0,
                'valor_entregue' => $factura['valor_entregue'] ?? 0,
                'valor_multicaixa' => $factura['formas_pagamento_id'] == 3 ? $factura['valor_a_pagar'] : 0,
                'valor_cash' => $factura['tipo_documento'] == TypeInvoice::FACTURA ? 0 : $factura['valor_a_pagar'] ?? 0,
                'data_vencimento' => $factura['tipo_documento'] == TypeInvoice::FACTURA_PROFORMA || $factura['tipo_documento'] == TypeInvoice::FACTURA ? $factura['data_vencimento'] : NULL,
                'troco' => $factura['tipo_documento'] == TypeInvoice::FACTURA ||  $factura['tipo_documento'] == TypeInvoice::FACTURA_PROFORMA  ? 0 : (($factura['valor_entregue'] ?? 0) - ($factura['valor_a_pagar'] ?? 0)) ?? 0,
                'valor_extenso' => $f->format($factura['valor_a_pagar'] ?? 0),
                'codigo_moeda' => $factura['codigo_moeda'] ?? 1,
                'desconto' => $factura['desconto'] ?? 0,
                'total_iva' => $factura['total_iva'] ?? 0,
                'multa' => $factura['multa'] ?? 0,
                'nome_do_cliente' => $cliente->nome ?? 'Consumidor final',
                'telefone_cliente' => $cliente->telefone_cliente ?? NULL,
                'nif_cliente' => $cliente->nif ?? '999999999',
                'email_cliente' => $cliente->email ?? NULL,
                'endereco_cliente' => $cliente->endereco ?? NULL,
                'conta_corrente_cliente' => $cliente->conta_corrente,
                'numeroItems' => $factura['numeroItems'] ?? 1,
                'tipo_documento' => $factura['tipo_documento'],
                'tipoFolha' => $factura['tipoFolha'] ?? 'TICKET',
                'retencao' => $factura['retencao'] ?? 0,
                'texto_hash' => $plaintext,
                'nextFactura' => mb_strtoupper(Keygen::numeric(9)->generate()),
                'faturaReference' => mb_strtoupper(Keygen::numeric(9)->generate()),
                'numSequenciaFactura' => $numSequenciaFactura,
                'numeracaoFactura' => $numeracaoFactura,
                'hashValor' => base64_encode($signaturePlaintext),
                'retificado' => $factura['retificado'] ?? 'Não',
                'formas_pagamento_id' => $factura['formas_pagamento_id'],
                'observacao' => $factura['observacao'] ?? NULL,
                'descricao' => $factura['descricao'] ?? NULL,
                'armazen_id' => $factura['armazen_id'],
                'cliente_id' => $cliente->id,
                'empresa_id' => auth()->user()->empresa_id,
                'canal_id' => $factura['canal_id'] ?? 4,
                'status_id' => $factura['status_id'] ?? 1,
                'user_id' => auth()->user()->id,
                'operador' => auth()->user()->name,
                'convertidoFactura' => TypeInvoice::CONVERTIDO,
                'numeracaoProforma' => $factura['numeracaoFactura'] ?? NULL,
                'total_incidencia' => $factura['total_incidencia'],
                'tipo_user_id' => $factura['tipo_user_id'] ?? 2,
                'statusFactura' => $factura['tipo_documento'] == TypeInvoice::FACTURA ? TypeInvoice::STATUS_DIVIDA : TypeInvoice::STATUS_PAGO,
                'anulado' => $factura['anulado'] ?? 1,
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))
            ]);



            foreach ($factura['facturas_items'] as $item) {
                $produto = DB::table('produtos')->where('id', $item['produto_id'])->first();
                if ($produto->stocavel == 'Sim') {
                    if ($factura['tipo_documento'] != TypeInvoice::FACTURA_PROFORMA) {
                        DB::connection('mysql2')->table('existencias_stocks')
                            ->where('empresa_id', auth()->user()->empresa_id)
                            ->where('id', $item['existencia_stock_id'])->decrement('quantidade', $item['quantidade_produto']);
                    }
                }
                DB::connection('mysql2')->table('factura_items')->insert([
                    'descricao_produto' => $item['descricao_produto'],
                    'preco_compra_produto' => $item['preco_compra_produto'],
                    'preco_venda_produto' => $item['preco_venda_produto'],
                    'quantidade_produto' => $item['quantidade_produto'],
                    'quantidade_anterior' => $item['quantidade_anterior'],
                    'desconto_produto' => $item['desconto_produto'],
                    'incidencia_produto' => $item['incidencia_produto'],
                    'retencao_produto' => $item['retencao_produto'],
                    'iva_produto' => $item['iva_produto'],
                    'total_preco_produto' => $item['total_preco_produto'],
                    'produto_id' => $item['produto_id'],
                    'factura_id' => $facturaId,
                ]);
            }
            DB::commit();

            return response()->json([
                'data' => [
                    'numeracaoFactura' => $numeracaoFactura,
                    'url' => env('APP_URL') . 'api/empresa/imprimir/factura/' . $facturaId,
                ],
                'message' => "Fatura salva $numeracaoFactura"
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
        }
    }
    public function diasVencimentoFactura()
    {

        //Dias de vencimentos de facturas
        $DiasVencimentoFactura = DB::connection('mysql2')->table('parametros')->Where('label', 'n_dias_vencimento_factura')
            ->where("empresa_id", auth()->user()->empresa_id)->first();
        if ($DiasVencimentoFactura) {
            $vencimentofactura = $DiasVencimentoFactura->vida;
        } else {
            $DiasVencimentoFactura =  DB::connection('mysql2')->table('parametros')
                ->Where('label', 'n_dias_vencimento_factura')
                ->where("empresa_id", NULL)->first();
            $vencimentofactura = $DiasVencimentoFactura->vida;
        }
        return $vencimentofactura;
    }
    public function pegarUltimaFactura($tipoDocumento)
    {
        $yearNow = Carbon::parse(Carbon::now())->format('Y');

        return  DB::connection('mysql2')->table('facturas')->where('empresa_id', auth()->user()->empresa_id)
            ->where('created_at', 'like', '%' . $yearNow . '%')
            ->where('tipo_documento', $tipoDocumento)
            ->where('numeracaoFactura', 'like', '%' . $this->mostrarSerieDocumento() . '%')
            ->orderBy('id', 'DESC')->limit(1)->first();
    }
    public function imprimirFactura($facturaId)
    {

        $factura = $this->facturaRepository->listarFactura($facturaId);

        $filename = "Winmarket";

        if ($factura['anulado'] == 2) {


            $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
            $DIR_SUBREPORT = "/upload/documentos/empresa/modelosFacturas/a4/";
            $DIR = public_path() . "/upload/documentos/empresa/modelosFacturas/a4/";



            $reportController = new ReportShowApiController('pdf', $DIR_SUBREPORT);
            return $reportController->show(
                [
                    'report_file' => 'WinmarketAnulado',
                    'report_jrxml' => 'WinmarketAnulado.jrxml',
                    'report_parameters' => [
                        "empresa_id" => auth()->user()->empresa_id,
                        "logotipo" => $logotipo,
                        "facturaId" => $facturaId,
                        "viaImpressao" => 2,
                        "dirSubreportBanco" => $DIR,
                        "dirSubreportTaxa" => $DIR,
                        "CaminhomarcaAgua" => $DIR,
                        "tipo_regime" => auth()->user()->empresa->tipo_regime_id
                    ]

                ]
            );
        } else if ($factura['retificado'] == 'Sim') {

            $filename = "WinmarketFacturaRetificada";

            $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
            $DIR_SUBREPORT = "/upload/documentos/empresa/modelosFacturas/a4/";
            $DIR = public_path() . "/upload/documentos/empresa/modelosFacturas/a4/";



            $reportController = new ReportShowApiController('pdf', $DIR_SUBREPORT);
            return $reportController->show(
                [
                    'report_file' => $filename,
                    'report_jrxml' => $filename . '.jrxml',
                    'report_parameters' => [
                        "empresa_id" => auth()->user()->empresa_id,
                        "logotipo" => $logotipo,
                        "facturaId" => $facturaId,
                        "viaImpressao" => 2,
                        "dirSubreportBanco" => $DIR,
                        "dirSubreportTaxa" => $DIR,
                        "tipo_regime" => auth()->user()->empresa->tipo_regime_id
                    ]

                ]
            );
        } else {


            $logotipo = public_path() . '/upload//' . auth()->user()->empresa->logotipo;
            $DIR_SUBREPORT = "/upload/documentos/empresa/modelosFacturas/a4/";

            $DIR = public_path() . "/upload/documentos/empresa/modelosFacturas/a4/";


            $reportController = new ReportShowApiController('pdf', $DIR_SUBREPORT);


            return $reportController->show(
                [
                    'report_file' => $filename,
                    'report_jrxml' => $filename . '.jrxml',
                    'report_parameters' => [
                        "empresa_id" => auth()->user()->empresa_id,
                        "logotipo" => $logotipo,
                        "facturaId" => $facturaId,
                        "viaImpressao" => 2,
                        "dirSubreportBanco" => $DIR,
                        "dirSubreportTaxa" => $DIR,
                        "tipo_regime" => auth()->user()->empresa->tipo_regime_id
                    ]

                ],
                "pdf",
                $DIR_SUBREPORT
            );
        }
    }
}
