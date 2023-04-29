<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\Factura;
use App\Models\empresa\Recibos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use phpseclib\Crypt\RSA;

class ReciboRepository
{


    private $recibo;
    private $factura;

    use TraitSerieDocumento;
    use TraitChavesEmpresa;

    public function __construct(Recibos $recibo, Factura $factura)
    {
        $this->recibo = $recibo;
        $this->factura = $factura;
    }

    public function listarRecibo($reciboId)
    {
        $recibo = $this->recibo::latest()->with(['cliente', 'formaPagamento', 'factura'])
            ->where('empresa_id', auth()->user()->empresa_id)->where('id', $reciboId)->first();
        return $recibo;
    }


    public function listarRecibos($search = null)
    {
        $recibos = $this->recibo::latest()->with(['cliente', 'formaPagamento', 'factura'])
            ->where('empresa_id', auth()->user()->empresa_id)
            ->search(trim($search))->paginate();
        return $recibos;
    }
    public function buscarReciboPelaNumeracao($reciboSearch = null)
    {

        $recibo = $this->recibo::latest()->with(['cliente', 'formaPagamento', 'factura'])
            ->where('anulado', 1)
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('numeracao_recibo', 'like', '%' . $reciboSearch . '%')->first();

        return $recibo;
    }
    public function pegarUltimoRecibo()
    {
        $yearNow = Carbon::parse(Carbon::now())->format('Y');

        return $this->recibo::where('empresa_id', auth()->user()->empresa_id)
            ->where('created_at', 'like', '%' . $yearNow . '%')
            ->where('numeracao_recibo', 'like', '%' . $this->mostrarSerieDocumento() . '%')
            ->orderBy('id', 'DESC')->limit(1)->first();
    }
    public function salvarRecibo(array $data)
    {

        $ultimoRecibo = $this->pegarUltimoRecibo();

        /**
         * hashAnterior inicia vazio
         */
        $hashAnterior = "";
        if ($ultimoRecibo) {

            $dataRecibo = Carbon::createFromFormat('Y-m-d H:i:s', $ultimoRecibo->created_at);
            $hashAnterior = $ultimoRecibo->hash;
        } else {
            $dataRecibo = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }
        //Manipulação de datas: data actual
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/

        if ($dataRecibo->diffInYears($datactual) == 0) {

            if ($ultimoRecibo) {
                $dataRecibo = Carbon::createFromFormat('Y-m-d H:i:s', $ultimoRecibo->created_at);
                $numSequenciaRecibo = intval($ultimoRecibo->numSequenciaRecibo) + 1;
            } else {
                $dataRecibo = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaRecibo = 1;
            }
        } else if ($dataRecibo->diffInYears($datactual) > 0) {
            $numSequenciaRecibo = 1;
        }

        $numeracaoRecibo = 'RG ' . $this->mostrarSerieDocumento() . '' . date('Y') . '/' . $numSequenciaRecibo; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);


        $rsa = new RSA(); //Algoritimo RSA

        $privatekey = $this->pegarChavePrivada();
        $publickey = $this->pegarChavePublica();


        // Lendo a private key
        $rsa->loadKey($privatekey);

        /*Texto que deverá ser assinado com a assinatura RSA::SIGNATURE_PKCS1, e o Texto estará mais ou menos assim após as
        Concatenações com os dados preliminares da factura: 2020-09-14;2020-09-14T20:34:09;FP PAT2020/1;457411.2238438; */

        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoRecibo . ';' . number_format($data['valor_total_entregue'], 2, ".", "") . ';' . $hashAnterior;

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);

        $recibo = new Recibos();
        $recibo->empresa_id = auth()->user()->empresa_id;
        $recibo->numeracao_recibo = $numeracaoRecibo;
        $recibo->cliente_id = $data['cliente_id'];
        $recibo->factura_id = $data['factura_id'];
        $recibo->anulado = 1; //não anulado
        $recibo->created_at = Carbon::now()->addHour(1);
        $recibo->valor_extenso = $data['valor_extenso'];
        $recibo->updated_at = Carbon::now()->addHour(1);
        $recibo->valor_total_entregue = $data['valor_total_entregue'];
        $recibo->user_id = auth()->user()->id;
        $recibo->forma_pagamento_id = $data['forma_pagamento_id'];
        $recibo->observacao = $data['observacao'] ? $data['observacao'] : "Liquidação da factura " . $data['numeracaoFactura'];
        $recibo->total_retencao = 0;
        $recibo->numSequenciaRecibo = $numSequenciaRecibo;
        $recibo->hash = base64_encode($signaturePlaintext);
        $recibo->nome_do_cliente = $data['nome_do_cliente'];
        $recibo->telefone_cliente = $data['telefone_cliente'];
        $recibo->nif_cliente = $data['nif_cliente'];
        $recibo->email_cliente = $data['email_cliente'];
        $recibo->endereco_cliente = $data['endereco_cliente'];
        $recibo->conta_corrente_cliente = $data['conta_corrente_cliente'];
        $recibo->save();


        $valorDebito = (float) str_replace(".", "", $data['total_debito']);
        $valorApagar = (float) str_replace(".", "", $data['valor_a_pagar']);
        $valorTotalEntregue = (float) str_replace(".", "", $data['valor_total_entregue']);
        $valorFaltante = $valorApagar - $valorTotalEntregue;

        if ($valorDebito === $valorFaltante) {
            $this->factura::where('empresa_id', auth()->user()->empresa_id)
                ->where('id', $data['factura_id'])
                ->where('tipo_documento', 2) //documento tipo factura
                ->update(['statusFactura' => 2]); //status pago
        }

        return $recibo;
    }
    public function atualizarStatusReciboParaAnulado($reciboId)
    {
        Recibos::where('id', $reciboId)
            ->where('empresa_id', auth()->user()->empresa_id)->update([
                'anulado' =>  2 //status anulado
            ]);
    }
}
