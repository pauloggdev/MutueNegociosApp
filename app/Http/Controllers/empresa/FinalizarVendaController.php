<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\Controller;
use App\Models\empresa\Factura;
use App\Models\empresa\Produto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpseclib\Crypt\RSA;
use DateTime;
use Exception;
use Keygen\Keygen;



class FinalizarVendaController extends Controller
{

    public function store(Request $data)
    {


        $info = $this->gerarHashNumSequenciaNumeracao($data['tipo_documento_id'], $data['valor_a_pagar'], $data['retencao']);
        DB::beginTransaction();

        try {




            $valor_multicaixa = $data['valor_multicaixa'] ?? 0;
            $valor_cash = $data['valor_cash'] ?? 0;
            $valor_a_pagar  = $data['valor_a_pagar'];
            $troco = ($valor_multicaixa + $valor_cash) - $valor_a_pagar;

            if ($data['tipo_documento_id'] ==  Factura::FACTURARECIBO) {
                $statuFactura = 2;
            } elseif ($data['tipo_documento_id'] ==  Factura::FACTURA) {
                $statuFactura = 1;
            } else {
                $statuFactura = NULL;
            }
            $facturaId =  DB::table('facturas')->insertGetId([

                "total_preco_factura" => $data['total_preco_factura'],
                "valor_a_pagar" => $valor_a_pagar,
                "valor_entregue" => $data['valor_entregue'],
                "valor_multicaixa" => $valor_multicaixa,
                "valor_cash" => $valor_cash,
                "troco" => $troco,
                "valor_extenso" => $data['valor_extenso'],
                "codigo_moeda" => 1, //kz
                "desconto" => $data['desconto'],
                "total_iva" => $data['total_iva'],
                "multa" => isset($data['multa']) ? $data['multa'] : 0,
                "nome_do_cliente" => $data['nome_do_cliente'] ? $data['nome_do_cliente'] : 'Consumidor final',
                "telefone_cliente" => $data['telefone_cliente'],
                "nif_cliente" => $data['nif_cliente'] ? $data['nif_cliente'] : '999999999',
                "email_cliente" => $data['email_cliente'],
                "endereco_cliente" => $data['endereco_cliente'],
                "conta_corrente_cliente" => $data['conta_corrente_cliente'],
                "numeroItems" => $data['numeroItems'],
                "tipo_documento" => $data['tipo_documento_id'],
                'tipoFolha' => 'TICKET',
                "retencao" => $data['retencao'],
                "nextFactura" => mb_strtoupper(Keygen::numeric(9)->generate()),
                "faturaReference" => mb_strtoupper(Keygen::numeric(9)->generate()),
                "numSequenciaFactura" => $info['num_sequencia_factura'],
                "numeracaoFactura" => $info['numeracao_factura'],
                "hashValor" => $info['hash'],
                "retificado" => 'Não',
                "formas_pagamento_id" => $data['forma_pagamento_id'],
                "descricao" => $data['descricao'],
                "observacao" => $data['observacao'],
                "cliente_id" => $data['cliente_id'],
                "empresa_id" => Auth::user()->empresa_id,
                "canal_id" => 2,
                "status_id" => $data['statu_id'],
                "user_id" => Auth::user()->id,
                "operador" => Auth::user()->name,
                "convertidoFactura" => 1, // não convertido
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
                "data_vencimento" => $data['data_vencimento'],
                "total_incidencia" => $data['total_incidencia'],
                "tipo_user_id" => 2,
                "statusFactura" => $statuFactura,
                "anulado" => 1
            ]);

            foreach ($data['pedidoItems'] as $key => $ft) {
                //produto é estocavel e se quantidade a tirar é menor ou igual a quantidade existente
                $produto = Produto::with(['existenciaEstock'])
                    ->where('id', $ft['produto_id'])
                    ->where('stocavel', "Sim")
                    ->whereHas('existenciaEstock', function ($query) use ($data, $ft) {
                        $query->where('quantidade', '>=', $ft['quantidade_produto']);
                    });
                $produto = $produto->first();
                $existencia = DB::table('existencias_stocks')
                    ->where('produto_id', $ft['produto_id'])->first();

                DB::table('factura_items')->insert([
                    'descricao_produto' => $ft['descricao_produto'],
                    'preco_compra_produto' => $ft['preco_compra_produto'],
                    'preco_venda_produto' => $ft['preco_venda_produto'],
                    'quantidade_produto' => $ft['quantidade_produto'],
                    'desconto_produto' => $ft['desconto_produto'],
                    'incidencia_produto' => $ft['incidencia_produto'],
                    'retencao_produto' => $ft['retencao_produto'],
                    'iva_produto' => $ft['iva_produto'],
                    'total_preco_produto' => $ft['total_preco_produto'],
                    'quantidade_anterior' => $existencia->quantidade,
                    'produto_id' => $ft['produto_id'],
                    'factura_id' => $facturaId

                ]);
                //reduz no estock
                if ($produto) {
                    DB::table('existencias_stocks')->where('produto_id', $ft['produto_id'])
                        ->decrement('quantidade', $ft['quantidade_produto']);
                }
            }
            DB::commit();
            return  $facturaId;
        } catch (Exception $ex) {
            DB::rollback();
            return $ex->getMessage();
        }
    }

    public function gerarHashNumSequenciaNumeracao($tipoDocumento = 1, $valorPagar = 0, $totalRetencao = 0)
    {

        $tipo_documento = $tipoDocumento;
        $factura = $this->mostrarUltimafactura($tipo_documento);

        $hashAnterior = $factura ? $factura->hashValor : "";
        $dataFactura = $factura ? Carbon::createFromFormat('Y-m-d H:i:s', $factura->created_at) : Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))->addHour();
        $dataAtual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))->addHour();

        $numSequenciaFactura = 1;
        if ($dataFactura->diffInYears($dataAtual) == 0 && $factura) {
            $numSequenciaFactura = intval($factura->numSequenciaFactura) + 1;
        }
        $numeracaoFactura = $this->gerarNumeracaoFactura($numSequenciaFactura, $tipo_documento);


        $rsa = new RSA(); //Algoritimo RSA
        // Lendo a private key
        $rsa->loadKey($this->privatekey());

        $data = new DateTime($dataAtual);
        $plaintext = $data->format('Y-m-d') . ';' . str_replace(' ', 'T', $dataAtual) . ';' . $numeracaoFactura . ';' . number_format($valorPagar + $totalRetencao, 2, ".", "") . ';' . $hashAnterior;

        //var_dump($plaintext);
        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)
        $hash = base64_encode($signaturePlaintext);
        // Lendo a public key
        $rsa->loadKey($this->publickey());

        return [
            'hash' => $hash,
            'num_sequencia_factura' => $numSequenciaFactura,
            'numeracao_factura' => $numeracaoFactura
        ];
    }
    public function mostrarUltimafactura($tipoDocumento = 1)
    {
        if ($tipoDocumento == Factura::FACTURARECIBO) {
            return Factura::where('empresa_id', Auth::user()->empresa_id)
                ->where('tipo_documento', Factura::FACTURARECIBO)
                ->orderBy('id', 'DESC')->limit(1)->first();
        } else if ($tipoDocumento == Factura::FACTURA) {
            return Factura::where('empresa_id', Auth::user()->empresa_id)
                ->where('tipo_documento', Factura::FACTURA)
                ->orderBy('id', 'DESC')->limit(1)->first();
        } else if ($tipoDocumento == Factura::FACTURAPROFORMA) {
            return Factura::where('empresa_id', Auth::user()->empresa_id)
                ->where('tipo_documento', Factura::FACTURAPROFORMA)
                ->orderBy('id', 'DESC')->limit(1)->first();
        }
    }
    public function privatekey()
    {
        $privatekey = "MIICXQIBAAKBgQDLCBFpQtDzVaCRm6PR3QZRb+v5jVROVMsB79HeEjkEVFxOnKD2WBolwYMvKHsNh6xEMnyL8sLqTc1MX1gSx/7PTOy7Umq6pnn2N37JYRg6J2i7r65TUaHZ7QikB+smhaCtwKK7dgL31elWXK5yD1TwpHOqSpiacQbGy79CwMfP2QIDAQABAoGAFHV/q6e7/olGYOXaIC+xj0tD8CW5tRr+SfesokAb1r/ZfWJzJd/C4sMZQQtHOxnM1iJwQnn4AjxMz8Fb0qismHEltP7/85RrHkd0ObWXxbtZg63UrVAMPfvdrCbM1lCvf3ticPXp3qo3MHin1d0zTj9DlwJCBDQntXZikDBTkAECQQDp2E2QSUhp3U4zSbqCzojCrzlZmyFKnCn/s01GYMe4N++mHxs1Dt1hFWiWtJLvKKMrO0Sp/AsRiYkbGV2xd2dZAkEA3kRp2r+BQ1RzMnjtnZJJOpQF2bR9DBQvEfC0s9tsFAuL6ILWWuS68AbWrP/56RUQvxR9lvVQBn1VVSm/u+ccgQJAbmxQvBiO1EbHnZpsM0aZ9+zMVQ7XGqdBgdhGXjxnMwte4//+VgCt8yEr4TZlx/9VhZ2YH/i/tUlP7/b7ckjjCQJBAKX3H7OfW74SyRHfCk6mdNewv82X3+etCpiyy7uhFErDdGzhhX3JXWztLk9vtAQ/HooPmtelxWOTIqy8x9Ze9AECQQCQSlsCyczzoY18cyfCzteR4fUzvHAo/cmgZc/5XUGC9US5flMuq+lXE5e7V6d5Ed8Y22G8wWNZqx1WR9ri+vtY";
        return $privatekey;
    }
    public function publickey()
    {
        $publickey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDLCBFpQtDzVaCRm6PR3QZRb+v5jVROVMsB79HeEjkEVFxOnKD2WBolwYMvKHsNh6xEMnyL8sLqTc1MX1gSx/7PTOy7Umq6pnn2N37JYRg6J2i7r65TUaHZ7QikB+smhaCtwKK7dgL31elWXK5yD1TwpHOqSpiacQbGy79CwMfP2QIDAQAB";
        return $publickey;
    }
    public function gerarNumeracaoFactura($numSequenciaFactura = 1, $tipoDocumento = 1)
    {

        if ($tipoDocumento == Factura::FACTURARECIBO) {
            $numeracaoFactura = 'FR AGT' . date('Y') . '/' . $numSequenciaFactura;
        } else if ($tipoDocumento == Factura::FACTURA) {
            $numeracaoFactura = 'FT AGT' . date('Y') . '/' . $numSequenciaFactura;
        } else if ($tipoDocumento == Factura::FACTURAPROFORMA) {
            $numeracaoFactura = 'PP AGT' . date('Y') . '/' . $numSequenciaFactura;
        }
        return $numeracaoFactura;
    }
}
