<?php

namespace App\Repositories\Admin;

use App\Models\admin\AtivacaoLicenca;
use App\Models\admin\Pagamento;
use App\Repositories\Empresa\TraitChavesEmpresa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use phpseclib\Crypt\RSA;
use NumberFormatter;
use Carbon\Carbon;

class PagamentoRepository
{

    use TraitChavesEmpresa;

    protected $pagamento;
    protected $licenca;

    public function __construct(Pagamento $pagamento, AtivacaoLicenca $licenca)
    {
        $this->pagamento = $pagamento;
        $this->licenca = $licenca;
    }

    public function getPagamentos()
    {
    }
    public function verificarFacturaPaga($faturaReference)
    {

        $pagamento = $this->pagamento::where('referenciaFactura', $faturaReference)->where('empresa_id', $this->getEmpresa()->id)->first();
        return $pagamento;
    }
    public function getPagamento(int $pagamentoId, int $empresaId)
    {
        $pagamento = $this->pagamento::where('id', $pagamentoId)->where('empresa_id', $empresaId)->first();
        return $pagamento;
    }
    public function alterarStatuPagamentoAtivo(int $pagamentoId, int $empresaId, $dataValicacao)
    {
        $pagamento = Pagamento::where('id', $pagamentoId)->where('empresa_id', $empresaId)->first();
        $pagamento->data_validacao = $dataValicacao;
        $pagamento->status_id = Pagamento::ATIVO;
        return $pagamento->save();
    }
    public function getEmpresa()
    {
        $empresa = DB::connection('mysql')->table('empresas')->where('referencia', auth()->user()->empresa->referencia)->first();
        return $empresa;
    }
    public function pegarUltimoRecibo()
    {
        $yearNow = Carbon::parse(Carbon::now())->format('Y');

        return $this->pagamento::where('empresa_id', $this->getEmpresa()->id)
            ->where('created_at', 'like', '%' . $yearNow . '%')
            ->where('numeracao_recibo', 'like', '%' . $this->mostrarSerieDocumento() . '%')
            ->orderBy('id', 'DESC')->limit(1)->first();
    }
    public function mostrarSerieDocumento()
    {
        return mb_strtoupper(substr(Str::slug($this->getEmpresa()->nome), 0, 3));
    }

    public function salvarPagamento($pagamento)
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

        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoRecibo . ';' . number_format($pagamento['valor_a_pagar'], 2, ".", "") . ';' . $hashAnterior;

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);

        $f = new NumberFormatter("pt", NumberFormatter::SPELLOUT);

        try {

            DB::beginTransaction();
            $pagamentoId = $this->pagamento::insertGetId([
                'valor_depositado' => $pagamento['valor_a_pagar'],
                'quantidade' => 1,
                'totalPago' => $pagamento['valor_a_pagar'],
                'data_pago_banco' => $pagamento['dataPagamentoBanco'],
                'numero_operacao_bancaria' => $pagamento['numero_operacao_bancaria'],
                'forma_pagamento_id' => $pagamento['forma_pagamento_id'],
                'conta_movimentada_id' => $pagamento['conta_movimentada_id'],
                'referenciaFactura' => $pagamento['faturaReference'],
                'comprovativo_bancario' => $pagamento['comprovativo_bancario'] ? $pagamento['comprovativo_bancario']->store("/admin/licenca") : NULL,
                'observacao' => $pagamento['observacao'],
                'factura_id' => $pagamento['id'],
                'empresa_id' => $pagamento['empresa_id'],
                'canal_id' => $pagamento['canal_id'],
                'hash' => base64_encode($signaturePlaintext),
                'texto_hash' => $plaintext,
                'valor_extenso' => $f->format($pagamento['valor_a_pagar']),
                'numSequenciaRecibo' => $numSequenciaRecibo,
                'numeracao_recibo' => $numeracaoRecibo,
                'user_id' => auth()->user()->id,
                'status_id' => 1,
                'data_validacao' => NULL,
                'data_rejeitacao' => NULL,
                'descricao' => 'Liquidação da factura ' . $pagamento['numeracaoFactura'],
                'nFactura' => $pagamento['numeracaoFactura'],
            ]);

            $this->licenca::insertGetId([

                'licenca_id' => $pagamento['licenca_id'],
                'empresa_id' => $pagamento['empresa_id'],
                'pagamento_id' => $pagamentoId,
                'data_inicio' => NULL,
                'data_fim' => NULL,
                'data_activacao' => NULL,
                'user_id' => NULL,
                'canal_id' => $pagamento['canal_id'],
                'status_licenca_id' => 3, // Pendente
                'data_rejeicao' => NULL,
                'data_notificaticao' => NULL,
                'notificacaoFimLicenca' => NULL
            ]);
            DB::commit();
            return $pagamentoId;
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
        }
    }
}
