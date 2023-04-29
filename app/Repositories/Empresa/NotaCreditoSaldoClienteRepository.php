<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\NotaCredito;
use Carbon\Carbon;
use phpseclib\Crypt\RSA;

class NotaCreditoSaldoClienteRepository
{
    use TraitSerieDocumento;
    use TraitChavesEmpresa;

    private $notaCredito;

    public function __construct(NotaCredito $notaCredito)
    {
        $this->notaCredito = $notaCredito;
    }


    public function listarNotaCreditoSaldoClientes($search = null)
    {

        $notaCredito = $this->notaCredito::latest()->with('cliente')
            ->where('tipoNotaCredito', 1)
            ->where('empresa_id', auth()->user()->empresa_id)->search(trim($search))->paginate();

        return $notaCredito;
    }

    public function salvarNotaCreditoSaldoCliente(array $data)
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

        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoNotaCredito . ';' . number_format($data['valor_credito'], 2, ".", "") . ';' . $hashAnterior;

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);

        $notaCredito = new NotaCredito();
        $notaCredito->cliente_id = $data['cliente_id'];
        $notaCredito->empresa_id = auth()->user()->empresa_id;
        $notaCredito->numeracaoDocumento = $numeracaoNotaCredito;
        $notaCredito->valor_credito = $data['valor_credito'];
        $notaCredito->descricao = $data['descricao'];
        $notaCredito->valor_extenso = $data['valor_extenso'];
        $notaCredito->numSequenciaNotaCredito = $numSequencia;
        $notaCredito->user_id = auth()->user()->id;
        $notaCredito->tipo_user_id = 2;  //Tipo empresa
        $notaCredito->tipoNotaCredito = 1;  // Tipo nota Credito dar saldo ao cliente
        $notaCredito->tipo_documento = 5;  // Tipo nota de Crédito
        $notaCredito->nome_do_cliente = $data['cliente_nome'];
        $notaCredito->telefone_cliente = $data['telefone_cliente'];
        $notaCredito->nif_cliente = $data['nif_cliente'];
        $notaCredito->email_cliente = $data['email_cliente'];
        $notaCredito->endereco_cliente = $data['endereco'];
        $notaCredito->conta_corrente_cliente = $data['cliente_conta_corrente'];
        $notaCredito->hash = base64_encode($signaturePlaintext);
        $notaCredito->save();

        return $notaCredito;
    }
    private function pegarUltimoNotaCredito()
    {
        return $this->notaCredito::where('empresa_id', auth()->user()->empresa_id)
            ->whereNull('facturaId')->whereNull('reciboId')
            ->where('numeracaoDocumento', 'like', '%' . $this->mostrarSerieDocumento() . '%')
            ->orderBy('id', 'DESC')->limit(1)->first();
    }
}
