<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\NotaCredito;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use phpseclib\Crypt\RSA;

class NotaCreditoRetificacaoDocumentoRepository
{
    use TraitSerieDocumento;
    use TraitChavesEmpresa;
    use TraitUltimaNotaCredito;

    private $notaCredito;
    private $facturaRepository;
    private $reciboRepository;

    public function __construct(NotaCredito $notaCredito, FacturaRepository $facturaRepository, ReciboRepository $reciboRepository)
    {
        $this->notaCredito = $notaCredito;
        $this->facturaRepository = $facturaRepository;
        $this->reciboRepository = $reciboRepository;
    }

    public function salvarNotaCreditoRetificacaoFactura($factura, $observacao)
    {

        $ultimaNotaCredito = $this->pegarUltimoNotaCredito();

        /**
         * hashAnterior inicia vazio
         */
        $hashAnterior = "";
        if ($ultimaNotaCredito) {

            $dataNotaCredito = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaNotaCredito->created_at);
            $hashAnterior = $ultimaNotaCredito->hash;
        } else {
            $dataNotaCredito = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }
        //Manipulação de datas: data actual
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/
        if ($dataNotaCredito->diffInYears($datactual) == 0) {

            if ($ultimaNotaCredito) {
                $dataNotaCredito = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaNotaCredito->created_at);
                $numSequencia = intval($ultimaNotaCredito->numSequenciaNotaCredito) + 1;
            } else {
                $dataNotaCredito = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequencia = 1;
            }
        } else if ($dataNotaCredito->diffInYears($datactual) > 0) {
            $numSequencia = 1;
        }

        $numeracaoNotaCredito = 'NC ' . $this->mostrarSerieDocumento() . '' . date('Y') . '/' . $numSequencia; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);

        $rsa = new RSA(); //Algoritimo RSA

        $privatekey = $this->pegarChavePrivada();
        $publickey = $this->pegarChavePublica();


        // Lendo a private key
        $rsa->loadKey($privatekey);

        /*Texto que deverá ser assinado com a assinatura RSA::SIGNATURE_PKCS1, e o Texto estará mais ou menos assim após as
        Concatenações com os dados preliminares da factura: 2020-09-14;2020-09-14T20:34:09;FP PAT2020/1;457411.2238438; */

        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoNotaCredito . ';' . number_format($factura['valor_a_pagar'] + $factura['retencao'], 2, ".", "") . ';' . $hashAnterior;


        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);
        $hash = base64_encode($signaturePlaintext);

        try {
            DB::beginTransaction();

            $notaCreditoId =  DB::table('notas_credito')->insertGetId([
                "empresa_id" => auth()->user()->empresa_id,
                "tipoNotaCredito" => 3, // Tipo retificação
                "cliente_id" => $factura['cliente_id'],
                "total_preco_factura" => $factura['total_preco_factura'],
                "descricao" => $observacao,
                "texto_hash" => $plaintext,
                "numSequenciaNotaCredito" => $numSequencia,
                "valor_extenso" => $factura['valor_extenso'],
                "nome_do_cliente" => $factura['nome_do_cliente'],
                "user_id" => auth()->user()->id,
                "created_at" => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
                "updated_at" => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
                "tipo_user_id" => 2, // Tipo empresa
                "tipo_documento" => 2, // Tipo factura
                "hash" => $hash,
                "statusFactura" => $factura['statusFactura'],
                "retificado" => "Sim",
                "tipoFolha" => $factura['tipoFolha'],
                "telefone_cliente" => $factura['telefone_cliente'],
                "nif_cliente" => $factura['nif_cliente'],
                "email_cliente" => $factura['email_cliente'],
                "endereco_cliente" => $factura['endereco_cliente'],
                "conta_corrente_cliente" => $factura['conta_corrente_cliente'],
                "nextFactura" => $factura['nextFactura'],
                "faturaReference" => $factura['faturaReference'],
                "total_incidencia" => $factura['total_incidencia'],
                "desconto" => $factura['desconto'],
                "valor_a_pagar" => $factura['valor_a_pagar'],
                "numeroItems" => $factura['numeroItems'],
                "formas_pagamento_id" => $factura['formas_pagamento_id'],
                "anulado" => $factura['anulado'],
                "armazen_id" => $factura['armazen_id'],
                "retencao" => $factura['retencao'],
                "multa" => $factura['multa'],
                "valor_entregue" => $factura['valor_entregue'],
                "total_iva" => $factura['total_iva'],
                "troco" => $factura['troco'],
                "numeracaoDocumento" => $numeracaoNotaCredito,
                "data_vencimento" => $factura['data_vencimento'],
                "codigo_moeda" => $factura['codigo_moeda'],
                "facturaId" => $factura['id'],
                "retornaStock" => "Sim"
            ]);


            foreach ($factura['facturas_items'] as $key => $facturaItem) {
                $facturaItem = (object) $facturaItem;
                // $facturaAnterior = $this->facturaRepository->listarFactura($facturaItem->factura_id);
                // $quantidade = ($facturaAnterior['facturas_items'][$key]['quantidade_produto'] - $facturaItem->quantidade_produto);
                if ($facturaItem->qty_atual > 0) {
                    DB::table('nota_credito_items')->insert([
                        'descricao_produto' => $facturaItem->descricao_produto,
                        'preco_compra_produto' => $facturaItem->preco_compra_produto,
                        'preco_venda_produto' => $facturaItem->preco_venda_produto,
                        'quantidade_produto' => $facturaItem->qty_atual,
                        'desconto_produto' => $facturaItem->desconto_produto,
                        'incidencia_produto' => $facturaItem->incidencia_produto,
                        'retencao_produto' => $facturaItem->retencao_produto,
                        'iva_produto' => $facturaItem->iva_produto,
                        'total_preco_produto' => $facturaItem->total_preco_produto,
                        'produto_id' => $facturaItem->produto_id,
                        'factura_id' => $facturaItem->factura_id,
                        'codigoNotaCredito' => $notaCreditoId
                    ]);
                }
            }
            DB::commit();
            return $notaCreditoId;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }


    public function listarNotaCreditoRetificacaoDocumento($search = null)
    {
        $documentosAnulados = $this->notaCredito::latest()->with(['cliente', 'tipoDocumento', 'factura', 'recibo'])
            ->where('tipoNotaCredito', 3)
            ->where('empresa_id', auth()->user()->empresa_id)->search(trim($search))->paginate();

        return $documentosAnulados;
    }
}
