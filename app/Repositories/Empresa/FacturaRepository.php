<?php

namespace App\Repositories\Empresa;

use App\Http\Controllers\empresa\VerificadorDocumento;
use App\Http\Controllers\TypeInvoice;
use App\Models\empresa\Factura;
use App\Models\empresa\Recibos;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Repositories\Empresa\TraitSerieDocumento;
use App\Repositories\Empresa\TraitChavesEmpresa;
use phpseclib\Crypt\RSA;
use phpseclib\Crypt\RSA as Crypt_RSA;
use Illuminate\Support\Str;

class FacturaRepository
{

    use LivewireAlert;
    use TraitSerieDocumento;
    use TraitChavesEmpresa;




    public function listarPrimeiraFacturaPeloCliente($clienteId)
    {
        $facturas = Factura::where('cliente_id', $clienteId)
            ->where('empresa_id', auth()->user()->empresa_id)->first();
        return $facturas;
    }
    public function quantidadesVendas()
    {
        return DB::connection('mysql2')->table('facturas')
            ->where('anulado', 1)
            ->where('empresa_id', auth()->user()->empresa_id)->where(function ($query) {
                $query->where('tipo_documento', 1)
                    ->orwhere('tipo_documento', 2);
            })->count();
    }
    public function totalVendas()
    {
        return DB::connection('mysql2')->table('facturas')
            ->where('anulado', 1)
            ->where('empresa_id', auth()->user()->empresa_id)->where(function ($query) {
                $query->where('tipo_documento', 1)
                    ->orwhere('tipo_documento', 2);
            })->sum('valor_a_pagar');
    }
    public function listarGraficoVendasMensal()
    {

        $currentYear = now()->year;
        return DB::connection('mysql2')->table('facturas')
            ->select(DB::raw('SUM(valor_a_pagar) as total_factura, MONTH(created_at) AS mes'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            // ->where(DB::raw('YEAR(created_at)=2021'))
            ->whereRaw("YEAR(created_at) = {$currentYear}")
            ->where('anulado', 1)
            ->where('empresa_id', auth()->user()->empresa_id)
            ->get();
    }
    public function verificarSeExisteFacturaPeloClienteEIntervaloData($dataInico, $dataFim, $clienteId)
    {

        $factura = Factura::where('cliente_id', $clienteId)
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('created_at', '>=', $dataInico)
            ->where('created_at', '<=', $dataFim)
            ->first();
        return $factura;
    }

    public function listarFactura($facturaId)
    {
        $facturas = Factura::with(['facturas_items'])
            ->where('id', $facturaId)
            ->where('empresa_id', auth()->user()->empresa_id)->first();
        return $facturas;
    }
    public function listarfacturas($search = NULL)
    {

        $facturas = Factura::latest()->with('status', 'tipoDocumento')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->search(trim($search))->paginate(10);
        return $facturas;
    }
    public function listarFacturasProformas($search = null)
    {

        $facturas = Factura::with(['facturas_items', 'cliente'])
            ->where('tipo_documento', 3)
            ->where('empresa_id', auth()->user()->empresa_id)
            ->search(trim($search))->paginate();

        return $facturas;
    }
    public function listarFacturasParaEmitirReciboPelaNumeracaoFactura($search = null)
    {
        $facturas = Factura::with(['cliente'])
            ->where('anulado', 1) //Não anulado
            ->where('tipo_documento', 2) //factura
            ->where('statusFactura', 1) //divida
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('numeracaoFactura', 'like', '%' . $search . '%')->first();

        return $facturas;
    }
    public function listarFacturasParaEmitirReciboPeloIdCliente($clienteId = null)
    {
        $facturas = Factura::with(['cliente'])
            ->where('anulado', 1) //Não anulado
            ->where('tipo_documento', 2) //factura
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('cliente_id', $clienteId)->get();
        return $facturas;
    }
    public function buscarFacturaNaoRetificadoPelaNumeracao($facturaSearch = null)
    {
        $factura = Factura::with(['cliente', 'facturas_items', 'facturas_items.produto'])
            ->where('anulado', 1)
            ->where('retificado', 'Não')
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('numeracaoFactura', 'like', '%' . $facturaSearch . '%')->first();
        return $factura;
    }
    public function buscarFacturaPelaNumeracao($facturaSearch = null)
    {
        $factura = Factura::with(['cliente', 'facturas_items', 'facturas_items.produto'])
            ->where('anulado', 1)
            ->where('empresa_id', auth()->user()->empresa_id)
            ->where('numeracaoFactura', 'like', '%' . $facturaSearch . '%')->first();
        return $factura;
    }
    public function atualizarStatusFacturaParaAnulado($facturaId)
    {
        Factura::where('id', $facturaId)
            ->where('empresa_id', auth()->user()->empresa_id)->update([
                'anulado' =>  2 //status anulado
            ]);
    }
    public function verificarSeFacturaFoiRetificadoOuAnulado($facturaId)
    {
        return Factura::where('empresa_id', auth()->user()->empresa_id)
            ->where('id', $facturaId)
            ->where('anulado', 1)
            ->where('retificado', 'Sim')
            ->first();
    }
    public function verificarSeFoiAlteradoItemFactura($facturaId, $facturaAtual)
    {

        $facturasAnteriores = Factura::with(['facturas_items'])->where('anulado', 1)
            ->where('id', $facturaId)
            ->where('empresa_id', auth()->user()->empresa_id)->first();

        foreach ($facturasAnteriores['facturas_items'] as $key => $facturaAnterior) {
            if ($facturaAnterior['quantidade_produto'] != $facturaAtual['facturas_items'][$key]['qty_atual']) {
                return false;
            }
        }
        return true;
    }
    public function verificarSeRectificouFacturaNaTotalidade($facturaAtual)
    {
        $numeroItens = count($facturaAtual['facturas_items']);
        $count = 0;
        for ($i = 0; $i < $numeroItens; $i++) {
            if ($facturaAtual['facturas_items'][$i]['qty_atual'] <= 0) {
                $count++;
                if ($count == $numeroItens) {
                    return true;
                }
            }
        }
    }

    public function verificarFacturaContemRecibo($facturaId)
    {
        return Recibos::where('empresa_id', auth()->user()->empresa_id)->where('anulado', 1)->where('factura_id', $facturaId)->first();
    }
    public function salvarFacturaOriginal($facturaId)
    {
        $factura = Factura::with(['facturas_items'])->where('empresa_id', auth()->user()->empresa_id)->where('id', $facturaId)->first();

        try {
            DB::beginTransaction();
            DB::connection('mysql2')->table('facturas_original')->insert([
                'id' => $factura['id'],
                'total_preco_factura' => $factura['total_preco_factura'],
                'valor_a_pagar' => $factura['valor_a_pagar'],
                'valor_entregue' => $factura['valor_entregue'],
                'troco' => $factura['troco'],
                'valor_extenso' => $factura['valor_extenso'],
                'codigo_moeda' => $factura['codigo_moeda'],
                'desconto' => $factura['desconto'],
                'total_iva' => $factura['total_iva'],
                'total_incidencia' => $factura['total_incidencia'],
                'tipo_user_id' => $factura['tipo_user_id'],
                'multa' => $factura['multa'],
                'statusFactura' => $factura['statusFactura'],
                'anulado' => $factura['anulado'],
                'nome_do_cliente' => $factura['nome_do_cliente'],
                'telefone_cliente' => $factura['telefone_cliente'],
                'nif_cliente' => $factura['nif_cliente'],
                'email_cliente' => $factura['email_cliente'],
                'endereco_cliente' => $factura['endereco_cliente'],
                'conta_corrente_cliente' => $factura['conta_corrente_cliente'],
                'numeroItems' => $factura['numeroItems'],
                'tipo_documento' => $factura['tipo_documento'],
                'tipoFolha' => $factura['tipoFolha'],
                'retencao' => $factura['retencao'],
                'nextFactura' => $factura['nextFactura'],
                'faturaReference' => $factura['faturaReference'],
                'numSequenciaFactura' => $factura['numSequenciaFactura'],
                'numeracaoFactura' => $factura['numeracaoFactura'],
                'hashValor' => $factura['hashValor'],
                'retificado' => $factura['retificado'],
                'formas_pagamento_id' => $factura['formas_pagamento_id'],
                'descricao' => $factura['descricao'],
                'observacao' => $factura['observacao'],
                'armazen_id' => $factura['armazen_id'],
                'cliente_id' => $factura['cliente_id'],
                'empresa_id' => $factura['empresa_id'],
                'canal_id' => $factura['canal_id'],
                'status_id' => $factura['status_id'],
                'user_id' => $factura['user_id'],
                'created_at' => $factura['created_at'],
                'updated_at' => $factura['updated_at'],
                'data_vencimento' => $factura['data_vencimento'],
                'operador' => $factura['operador']
            ]);
            foreach ($factura['facturas_items'] as $facturaItem) {
                DB::connection('mysql2')->table('factura_items_original')->insert([
                    'descricao_produto' => $facturaItem['descricao_produto'],
                    'preco_compra_produto' => $facturaItem['preco_compra_produto'],
                    'preco_venda_produto' => $facturaItem['preco_venda_produto'],
                    'quantidade_produto' => $facturaItem['quantidade_produto'],
                    'desconto_produto' => $facturaItem['desconto_produto'],
                    'incidencia_produto' => $facturaItem['incidencia_produto'],
                    'retencao_produto' => $facturaItem['retencao_produto'],
                    'iva_produto' => $facturaItem['iva_produto'],
                    'total_preco_produto' => $facturaItem['total_preco_produto'],
                    'produto_id' => $facturaItem['produto_id'],
                    'factura_id' => $facturaItem['factura_id']
                ]);
            }

            DB::commit();
            return $factura;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
    public function retificarFactura($factura)
    {
        try {
            DB::beginTransaction();
            DB::table('facturas')->where('empresa_id', auth()->user()->empresa_id)
                ->where('id', $factura['id'])
                ->update([
                    "total_preco_factura" => $factura['total_preco_factura'],
                    "valor_a_pagar" => $factura['valor_a_pagar'],
                    "valor_entregue" => $factura['valor_entregue'],
                    "valor_multicaixa" => $factura['valor_multicaixa'],
                    "valor_cash" => $factura['valor_cash'],
                    "troco" => $factura['troco'],
                    "valor_extenso" => $factura['valor_extenso'],
                    "desconto" => $factura['desconto'],
                    "total_iva" => $factura['total_iva'],
                    "multa" => $factura['multa'],
                    "numeroItems" => $factura['numeroItems'],
                    "retencao" => $factura['retencao'],
                    'retificado' => 'Sim',
                    "total_incidencia" => $factura['total_incidencia'],
                    "descricao" => $factura['descricao'],
                    "observacao" => $factura['observacao'],
                    "user_id" => auth()->user()->id,
                    "operador" => auth()->user()->name,
                    'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
                    'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))
                ]);


            foreach ($factura['facturas_items'] as $facturaItem) {
                $facturaItem = (object) $facturaItem;
                $facturaAnterior = DB::table('factura_items')->where('id', $facturaItem->id)->first();
                $qty_anterior = $facturaAnterior->quantidade_produto;

                if ($facturaItem->qty_atual <= 0) {
                    //deletar item, caso a quantidade for 0;
                    DB::table('factura_items')->where('id', $facturaItem->id)->delete();
                } else {
                    DB::table('factura_items')->where('id', $facturaItem->id)
                        ->update([
                            'quantidade_produto' => $facturaItem->quantidade_produto,
                            'desconto_produto' => $facturaItem->desconto_produto,
                            'incidencia_produto' => $facturaItem->incidencia_produto,
                            'retencao_produto' => $facturaItem->retencao_produto,
                            'iva_produto' => $facturaItem->iva_produto,
                            'total_preco_produto' => $facturaItem->total_preco_produto,
                            'produto_id' => $facturaItem->produto_id,
                            'factura_id' => $factura['id']
                        ]);

                    DB::table('existencias_stocks')
                        ->where('produto_id', $facturaItem->produto_id)
                        ->where('armazem_id', $factura['armazen_id'])->increment('quantidade', ($qty_anterior - $facturaItem->qty_atual));
                }
            }
            DB::commit();
            return $factura;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function converterFacturaProforma($factura)
    {


        $verificadorDocumento = new VerificadorDocumento('facturas');
        if (!$verificadorDocumento->comparaDataDocumentoAnteriorComActual()) {

            $this->confirm('Existe um documento com data superior á data actual', [
                'showConfirmButton' => 'OK',
                'showCancelButton' => false,
                'icon' => 'warning',

            ]);
            return;
        }

        if ($factura['tipo_documento'] == TypeInvoice::FACTURA) {
            $facturas = $this->pegarUltimaFactura(TypeInvoice::FACTURA);
            $factura['statusFactura'] = TypeInvoice::STATUS_DIVIDA;
        }
        if ($factura['tipo_documento'] == TypeInvoice::FACTURA_RECIBO) {
            $facturas = $this->pegarUltimaFactura(TypeInvoice::FACTURA_RECIBO);
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

        $rsa = new Crypt_RSA(); //Algoritimo RSA

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



        $facturaId = DB::table('facturas')->insertGetId([
            'total_preco_factura' => $factura['total_preco_factura'],
            'valor_a_pagar' => $factura['valor_a_pagar'],
            'valor_entregue' => $factura['valor_entregue'],
            'valor_multicaixa' => $factura['valor_multicaixa'],
            'valor_cash' => $factura['valor_cash'],
            'data_vencimento' => $factura['data_vencimento'],
            'troco' => str_replace(',00', '', str_replace('.', '', $factura['troco'])),
            'valor_extenso' => $factura['valor_extenso'],
            'codigo_moeda' => $factura['codigo_moeda'],
            'desconto' => $factura['desconto'],
            'total_iva' => $factura['total_iva'],
            'multa' => $factura['multa'],
            'nome_do_cliente' => $factura['nome_do_cliente'],
            'telefone_cliente' => $factura['telefone_cliente'],
            'nif_cliente' => $factura['nif_cliente'],
            'email_cliente' => $factura['email_cliente'],
            'endereco_cliente' => $factura['endereco_cliente'],
            'conta_corrente_cliente' => $factura['conta_corrente_cliente'],
            'numeroItems' => $factura['numeroItems'],
            'tipo_documento' => $factura['tipo_documento'],
            'tipoFolha' => $factura['tipoFolha'],
            'retencao' => $factura['retencao'],
            'nextFactura' => $factura['nextFactura'],
            'faturaReference' => $factura['faturaReference'],
            'numSequenciaFactura' => $numSequenciaFactura,
            'numeracaoFactura' => $numeracaoFactura,
            'hashValor' => base64_encode($signaturePlaintext),
            'retificado' => $factura['retificado'],
            'formas_pagamento_id' => $factura['formas_pagamento_id'],
            'observacao' => $factura['observacao'],
            'descricao' => $factura['descricao'],
            'armazen_id' => $factura['armazen_id'],
            'cliente_id' => $factura['cliente_id'],
            'empresa_id' => auth()->user()->empresa_id,
            'canal_id' => $factura['canal_id'],
            'status_id' => $factura['status_id'],
            'user_id' => auth()->user()->id,
            'operador' => auth()->user()->name,
            'convertidoFactura' => TypeInvoice::CONVERTIDO,
            'numeracaoProforma' => $factura['numeracaoFactura'],
            'total_incidencia' => $factura['total_incidencia'],
            'tipo_user_id' => $factura['tipo_user_id'],
            'statusFactura' => $factura['statusFactura'],
            'anulado' => $factura['anulado'],
            'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s')),
            'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))
        ]);

        foreach ($factura['facturas_items'] as $item) {

            $produto = DB::table('produtos')->where('id', $item['produto_id'])->first();
            if ($produto->stocavel == 'Sim') {
                if ($factura['tipo_documento'] != 3) {
                    $existencia =  DB::connection('mysql2')->table('existencias_stocks')
                        ->where('empresa_id', auth()->user()->empresa_id)->where('produto_id', $item['produto_id'])
                        ->where('armazem_id', $factura['armazen_id'])->first();

                    $quantidade = $existencia->quantidade - $item['quantidade_produto'];

                    if ($quantidade > 0) {
                        DB::connection('mysql2')->table('existencias_stocks')
                        ->where('empresa_id', auth()->user()->empresa_id)->where('produto_id', $item['produto_id'])
                        ->where('armazem_id', $factura['armazen_id'])->decrement('quantidade', $item['quantidade_produto']);
                    }
                }
            }
            DB::connection('mysql2')->table('factura_items')->insert([
                'descricao_produto' => $item['descricao_produto'],
                'factura_id' => $facturaId,
                'produto_id' => $item['produto_id'],
                'preco_venda_produto' => $item['preco_venda_produto'],
                'preco_compra_produto' => $item['preco_compra_produto'],
                'desconto_produto' => $item['desconto_produto'],
                'quantidade_produto' => $item['quantidade_produto'],
                'total_preco_produto' => $item['total_preco_produto'],
                'retencao_produto' => $item['retencao_produto'],
                'incidencia_produto' => $item['incidencia_produto'],
                'iva_produto' => $item['iva_produto']
            ]);
        }

        return $facturaId;
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
    public function alterarStatuFacturaParaConvertido($factura)
    {
        return DB::table('facturas')->where('id', $factura['id'])
            ->where('empresa_id', auth()->user()->empresa_id)->update([
                'convertidoFactura' => 2
            ]);
    }
}
