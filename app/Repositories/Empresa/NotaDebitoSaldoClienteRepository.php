<?php

namespace App\Repositories\Empresa;
use App\Models\empresa\NotaDebito;
use Carbon\Carbon;
use phpseclib\Crypt\RSA;

class NotaDebitoSaldoClienteRepository
{
    use TraitSerieDocumento;
    use TraitChavesEmpresa;

    private $notaDebito;

    public function __construct(NotaDebito $notaDebito)
    {
        $this->notaDebito = $notaDebito;
    }


    public function listarNotaDebitoSaldoClientes($search = null)
    {
        $dataNotaDebito = $this->notaDebito::latest()->with('cliente')->where('empresa_id', auth()->user()->empresa_id)->search(trim($search))->paginate();
        return $dataNotaDebito;
    }

    public function salvarNotaDebitoSaldoCliente(array $data)
    {
        $ultimaNotaDebito = $this->pegarUltimoNotaDebito();

        /**
         * hashAnterior inicia vazio
         */
        $hashAnterior = "";
        if ($ultimaNotaDebito) {

            $dataNotaDebito = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaNotaDebito->created_at);
            $hashAnterior = $ultimaNotaDebito->hash;
        } else {
            $dataNotaDebito = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }
        //Manipulação de datas: data actual
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/
        if ($dataNotaDebito->diffInYears($datactual) == 0) {

            if ($ultimaNotaDebito) {
                $dataNotaDebito = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaNotaDebito->created_at);
                $numSequencia = intval($ultimaNotaDebito->numSequenciaNotaDebito) + 1;
            } else {
                $dataNotaDebito = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequencia = 1;
            }
        } else if ($dataNotaDebito->diffInYears($datactual) > 0) {
            $numSequencia = 1;
        }

        $numeracaoNotaDebito = 'ND ' . $this->mostrarSerieDocumento() . '' . date('Y') . '/' . $numSequencia; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);

        $rsa = new RSA(); //Algoritimo RSA

        $privatekey = $this->pegarChavePrivada();
        $publickey = $this->pegarChavePublica();


        // Lendo a private key
        $rsa->loadKey($privatekey);

        /*Texto que deverá ser assinado com a assinatura RSA::SIGNATURE_PKCS1, e o Texto estará mais ou menos assim após as
        Concatenações com os dados preliminares da factura: 2020-09-14;2020-09-14T20:34:09;FP PAT2020/1;457411.2238438; */

        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoNotaDebito . ';' . number_format($data['valor_credito'], 2, ".", "") . ';' . $hashAnterior;

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);

        $notaDebito = new NotaDebito();
        $notaDebito->cliente_id = $data['cliente_id'];
        $notaDebito->empresa_id = auth()->user()->empresa_id;
        $notaDebito->numeracaoNotaDebito = $numeracaoNotaDebito;
        $notaDebito->valor_debito = $data['valor_debito'];
        $notaDebito->descricao = $data['descricao'];
        $notaDebito->numSequenciaNotaDebito = $numSequencia;
        $notaDebito->user_id = auth()->user()->id;
        $notaDebito->valor_extenso = $data['valor_extenso'];
        $notaDebito->tipo_user_id = 2;  //Tipo empresa
        $notaDebito->hash = base64_encode($signaturePlaintext);
        $notaDebito->nome_do_cliente = $data['cliente_nome'];
        $notaDebito->telefone_cliente = $data['telefone_cliente'];
        $notaDebito->nif_cliente = $data['nif_cliente'];
        $notaDebito->email_cliente = $data['email_cliente'];
        $notaDebito->endereco_cliente = $data['endereco'];
        $notaDebito->conta_corrente_cliente = $data['cliente_conta_corrente'];
        $notaDebito->save();
        return $notaDebito;
    }
    private function pegarUltimoNotaDebito()
    {
        return $this->notaDebito::where('empresa_id', auth()->user()->empresa_id)
            ->where('numeracaoNotaDebito', 'like', '%' . $this->mostrarSerieDocumento() . '%')
            ->orderBy('id', 'DESC')->limit(1)->first();
    }
}
