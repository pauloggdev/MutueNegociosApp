<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\ExistenciaStock;
use App\Models\empresa\NotaCredito;
use App\Models\empresa\NotaCreditoItems;
use Carbon\Carbon;
use phpseclib\Crypt\RSA;

class NotaCreditoAnulacaoDocumentoRepository
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


    public function listarNotaCreditoAnulacaoDocumento($search = null)
    {
        $documentosAnulados = $this->notaCredito::latest()->with(['cliente', 'tipoDocumento', 'factura', 'recibo', 'recibo.factura'])
            ->where('tipoNotaCredito', 2)
            ->where('empresa_id', auth()->user()->empresa_id)->search(trim($search))->paginate();

        return $documentosAnulados;
    }
    public function salvarNotaCreditoAnularRecibo(array $data)
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

        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoNotaCredito . ';' . number_format($data['recibo']['valor_total_entregue'] + $data['recibo']['total_retencao'], 2, ".", "") . ';' . $hashAnterior;

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);

        $notaCredito = new NotaCredito();
        $notaCredito->empresa_id = auth()->user()->empresa_id;
        $notaCredito->tipoNotaCredito = 2; // tipo anulação
        $notaCredito->cliente_id = $data['recibo']['cliente_id'];
        $notaCredito->descricao = $data['descricao'];
        $notaCredito->numSequenciaNotaCredito = $numSequencia;
        $notaCredito->valor_extenso = $data['recibo']['valor_extenso'];
        $notaCredito->nome_do_cliente = $data['recibo']['nome_do_cliente'];
        $notaCredito->user_id = auth()->user()->id;
        $notaCredito->tipo_user_id = 2; // utilizador tipo empresa
        $notaCredito->tipo_documento = 6; //recibo
        $notaCredito->hash = base64_encode($signaturePlaintext);
        $notaCredito->telefone_cliente = $data['recibo']['telefone_cliente'];
        $notaCredito->nif_cliente = $data['recibo']['nif_cliente'];
        $notaCredito->email_cliente = $data['recibo']['email_cliente'];
        $notaCredito->endereco_cliente = $data['recibo']['endereco_cliente'];
        $notaCredito->conta_corrente_cliente = $data['recibo']['conta_corrente_cliente'];
        $notaCredito->anulado = 2; // status anulado
        $notaCredito->valor_entregue = $data['recibo']['valor_total_entregue'];
        $notaCredito->numeracaoDocumento = $numeracaoNotaCredito;
        $notaCredito->reciboId = $data['recibo']['id'];
        $notaCredito->created_at = $datactual;
        $notaCredito->updated_at = $datactual;
        $notaCredito->save();

        $this->reciboRepository->atualizarStatusReciboParaAnulado($data['recibo']['id']);

        return $notaCredito;
    }

    public function salvarNotaCreditoAnularFactura(array $data)
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

        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoNotaCredito . ';' . number_format($data['factura']['valor_a_pagar'] + $data['factura']['retencao'], 2, ".", "") . ';' . $hashAnterior;

        // dd($plaintext);
        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);

        $notaCredito = new NotaCredito();
        $notaCredito->empresa_id = auth()->user()->empresa_id;
        // $notaCredito->texto_hash = $plaintext;
        $notaCredito->tipoNotaCredito = 2; // tipo anulação
        $notaCredito->cliente_id = $data['factura']['cliente_id'];
        $notaCredito->total_preco_factura = $data['factura']['total_preco_factura'];
        $notaCredito->descricao = $data['descricao'];
        $notaCredito->numSequenciaNotaCredito = $numSequencia;
        $notaCredito->valor_extenso = $data['factura']['valor_extenso'];
        $notaCredito->nome_do_cliente = $data['factura']['nome_do_cliente'];
        $notaCredito->user_id = auth()->user()->id;
        $notaCredito->tipo_user_id = 2; // utilizador tipo empresa
        $notaCredito->tipo_documento = $data['factura']['tipo_documento'];
        $notaCredito->hash = base64_encode($signaturePlaintext);
        $notaCredito->statusFactura = $data['factura']['statusFactura'];
        $notaCredito->retificado = $data['factura']['retificado'];
        $notaCredito->tipoFolha = $data['factura']['tipoFolha'];
        $notaCredito->telefone_cliente = $data['factura']['telefone_cliente'];
        $notaCredito->nif_cliente = $data['factura']['nif_cliente'];
        $notaCredito->email_cliente = $data['factura']['email_cliente'];
        $notaCredito->endereco_cliente = $data['factura']['endereco_cliente'];
        $notaCredito->conta_corrente_cliente = $data['factura']['conta_corrente_cliente'];
        $notaCredito->nextFactura = $data['factura']['nextFactura'];
        $notaCredito->faturaReference = $data['factura']['faturaReference'];
        $notaCredito->total_incidencia = $data['factura']['total_incidencia'];
        $notaCredito->desconto = $data['factura']['desconto'];
        $notaCredito->valor_a_pagar = $data['factura']['valor_a_pagar'];
        $notaCredito->numeroItems = $data['factura']['numeroItems'];
        $notaCredito->formas_pagamento_id = $data['factura']['formas_pagamento_id'];
        $notaCredito->anulado = 2; // status anulado
        $notaCredito->armazen_id = $data['factura']['armazen_id'];
        $notaCredito->retencao = $data['factura']['retencao'];
        $notaCredito->multa = $data['factura']['multa'];
        $notaCredito->valor_entregue = $data['factura']['valor_entregue'];
        $notaCredito->total_iva = $data['factura']['total_iva'];
        $notaCredito->troco = $data['factura']['troco'];
        $notaCredito->numeracaoDocumento = $numeracaoNotaCredito;
        $notaCredito->data_vencimento = $data['factura']['data_vencimento'];
        $notaCredito->codigo_moeda = $data['factura']['codigo_moeda'];
        $notaCredito->retornaStock = $data['retornarStock'] ? "Sim" : "Não";
        $notaCredito->facturaId = $data['factura']['id'];
        $notaCredito->created_at = $datactual;
        $notaCredito->updated_at = $datactual;
        $notaCredito->save();


        foreach ($data['factura']['facturas_items'] as $key => $facturaItem) {
            $notaCreditoItem = new NotaCreditoItems();
            $notaCreditoItem->descricao_produto = $facturaItem['descricao_produto'];
            $notaCreditoItem->preco_compra_produto = $facturaItem['preco_compra_produto'];
            $notaCreditoItem->preco_venda_produto = $facturaItem['preco_venda_produto'];
            $notaCreditoItem->quantidade_produto = $facturaItem['quantidade_produto'];
            $notaCreditoItem->desconto_produto = $facturaItem['desconto_produto'];
            $notaCreditoItem->incidencia_produto = $facturaItem['incidencia_produto'];
            $notaCreditoItem->retencao_produto = $facturaItem['retencao_produto'];
            $notaCreditoItem->iva_produto = $facturaItem['iva_produto'];
            $notaCreditoItem->total_preco_produto = $facturaItem['total_preco_produto'];
            $notaCreditoItem->produto_id = $facturaItem['produto_id'];
            $notaCreditoItem->factura_id = $facturaItem['factura_id'];
            $notaCreditoItem->codigoNotaCredito = $notaCredito->id;
            $notaCreditoItem->save();

            if ($data['retornarStock'] && $facturaItem['produto']['stocavel'] == "Sim") {
                $this->retornarProdutoEstoque($data['factura'], $facturaItem);
            }
        }
        $this->facturaRepository->atualizarStatusFacturaParaAnulado($data['factura']['id']);

        return $notaCredito;
    }
    public function retornarProdutoEstoque($factura, $facturaItem)
    {
        ExistenciaStock::where('produto_id', $facturaItem['produto_id'])
            ->where('armazem_id', $factura['armazen_id'])->where('empresa_id', auth()->user()->empresa_id)
            ->increment('quantidade', $facturaItem['quantidade_produto']);
    }
}
