<?php

namespace App\Http\Controllers\empresa;

use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Empresa;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\Factura;
use App\Models\empresa\NotaCredito;
use App\Models\empresa\NotaCreditoItems;
use App\Models\empresa\RecibosItem;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Empresa\FacturaRepositorio;
use App\Traits\VerificaSeEmpresaTipoAdmin;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use phpseclib\Crypt\RSA;
use phpseclib\Crypt\RSA as Crypt_RSA;
use App\Http\Controllers\contsys\FacturacaoController as ContsysFacturacaoController;
use App\Models\admin\Factura as AdminFactura;
use App\Models\admin\Pagamento;
use App\Models\empresa\ExistenciaStock;
use App\Models\empresa\Recibos;
use App\Traits\Empresa\TraitEmpresaAutenticada;
use App\Traits\VerificaSeUsuarioAlterouSenha;


class FacturaController extends Controller
{

    use VerificaSeEmpresaTipoAdmin;
    use VerificaSeUsuarioAlterouSenha;
    use TraitEmpresaAutenticada;


    public function searchFacturas()
    {
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $facturas = [];
        if ($search =  \Request::get('q')) {

            $facturas = Factura::with(['facturas_items', 'facturas_items.produto'])->where(function ($query) use ($search) {
                $query->where('numeracaoFactura', 'LIKE', "%$search%")
                    ->orWhere('faturaReference', 'LIKE', "%$search%");
            })->where('empresa_id', $empresa['empresa']['id'])
                ->where('anulado', 1)
                ->where('tipo_documento', '!=', 3)
                ->first();
        }
        return response()->json($facturas, 200);
    }
    public function searchRecibos()
    {
        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();
        $recibos = [];
        if ($search =  \Request::get('q')) {
            $recibos = Recibos::where(function ($query) use ($search) {
                $query->where('numeracao_recibo', 'LIKE', "%$search%");
            })->where('empresa_id', $empresa['empresa']['id'])
                ->where('anulado', 1)->first();
        }
        return response()->json($recibos, 200);
    }


    public function listarFacturasPorCliente($clienteId)
    {

        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $data = Factura::with(['cliente'])->where('tipo_documento', 2)->where('statusFactura', 1)->where('anulado', 1)->where('empresa_id', $empresa['empresa']['id'])->where('cliente_id', $clienteId)->get();

        return response()->json($data);
    }
    public function salvarFacturasRecitificadas(Request $request, FacturaRepositorio $facturaRepositorio)
    {
        if (isset($_GET['retornarStock']) && !empty($_GET['retornarStock'])) {
            $retornarStock =  $_GET['retornarStock'] == "true" ? true : false;
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $resultadoEmpresaGuardOperador = $facturaRepositorio->pegarEmpresaAutenticadaGuardOperador();
        $operador = $resultadoEmpresaGuardOperador['operador'];
        $tipo_user_id = $resultadoEmpresaGuardOperador['tipo_user_id'];

        /**
         * hashAnterior inicia vazio
         */
        $hashAnterior = "";
        //Pega o ultimo documento anulado

        $ultimaNotaCredito = DB::connection('mysql2')->table('notas_credito')->where('empresa_id', $resultadoEmpresaGuardOperador['empresa']['id'])
            ->where(function ($query) {
                $query->Where('facturaId', '!=', null)
                    ->orWhere('reciboId', '!=', null);
            })
            ->orderBy('id', 'DESC')->limit(1)->first();

        if ($ultimaNotaCredito) {
            $hashAnterior = $ultimaNotaCredito->hash;
            $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaNotaCredito->created_at);
        } else {
            $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
        }

        // //Manipulação de datas: data actual
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        // /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        // E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/

        if ($data_notaCredito->diffInYears($datactual) == 0) {

            if ($ultimaNotaCredito) {
                $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', $ultimaNotaCredito->created_at);
                $numSequenciaNotaCredito = intval($ultimaNotaCredito->numSequenciaNotaCredito) + 1;
            } else {
                $data_notaCredito = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
                $numSequenciaNotaCredito = 1;
            }
        } else if ($data_notaCredito->diffInYears($datactual) > 0) {
            $numSequenciaNotaCredito = 1;
        }

        $numeracaoDocumento = 'NC ' . mb_strtoupper(substr($resultadoEmpresaGuardOperador['empresa']['nome'], 0, 3) . '' . date('Y')) . '/' . $numSequenciaNotaCredito;

        if ($facturaRepositorio->verificarFacturaContemRecibo($request->all()['factura']['id'])) {
            return response()->json(['isValid' => false, 'errors' => 'Sem permissão para rectificar, documento contém recibo'], 500);
            // return response()->json(['errors'=>"Sem permissão para anular, documento contém recibo"], 500);
        }

        $rsa = new Crypt_RSA(); //Algoritimo RSA

        $privatekey = $facturaRepositorio->pegarChavePrivada();

        $publickey = $facturaRepositorio->pegarChavePublica();

        // Lendo a private key
        $rsa->loadKey($privatekey);

        /*Texto que deverá ser assinado com a assinatura RSA::SIGNATURE_PKCS1, e o Texto estará mais ou menos assim após as
        Concatenações com os dados preliminares da factura: 2020-09-14;2020-09-14T20:34:09;FP PAT2020/1;457411.2238438; */
        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoDocumento . ';' . number_format($request->all()['facturaRectificada']['valor_a_pagar'] + $request['facturaRectificada']['total_retencao'], 2, ".", "") . ';' . $hashAnterior;


        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);

        $TIPO_RECTIFICACAO = 3;
        $notaCredito = new NotaCredito();

        if (empty($request->all()['factura']) && empty($request->all()['facturas_items'])) {
            return response()->json(['isValid' => false, 'errors' => 'Preencha todos os campos obrigatorio'], 500);
        }
        if ($this->verificarZeradoTodaQuantidadeDosItem($request)) {
            return response()->json(['isValid' => false, 'errors' => 'Sem permissão para zerar todos items. Anula a factura'], 500);
        }
        if ($this->verificarSeFacturaFoiRetificada($request)) {
            return response()->json(['isValid' => false, 'errors' => 'Não foi rectificado nenhum item'], 500);
        }


        $notaCredito->empresa_id = $resultadoEmpresaGuardOperador['empresa']['id'];
        $notaCredito->tipoNotaCredito = $TIPO_RECTIFICACAO;
        $notaCredito->cliente_id = $request['facturaRectificada']['cliente_id'];
        $notaCredito->descricao = $request['facturaRectificada']['descricao'];
        $notaCredito->numSequenciaNotaCredito = $numSequenciaNotaCredito;
        $notaCredito->valor_extenso = $request['facturaRectificada']['valor_extenso'];
        $notaCredito->nome_do_cliente = $request['facturaRectificada']['nome_do_cliente'];
        $notaCredito->user_id = $request['facturaRectificada']['user_id'];
        $notaCredito->tipo_user_id = $request['facturaRectificada']['tipo_user_id'];
        $notaCredito->tipo_documento = $request['facturaRectificada']['tipo_documento'];
        $notaCredito->hash = base64_encode($signaturePlaintext);
        $notaCredito->statusFactura = $request['facturaRectificada']['statusFactura'];
        $notaCredito->retificado = $request['facturaRectificada']['retificado'];
        $notaCredito->tipoFolha = $request['facturaRectificada']['tipoFolha'];
        $notaCredito->telefone_cliente = $request['facturaRectificada']['telefone_cliente'];
        $notaCredito->nif_cliente = $request['facturaRectificada']['nif_cliente'];
        $notaCredito->email_cliente = $request['facturaRectificada']['email_cliente'];
        $notaCredito->endereco_cliente = $request['facturaRectificada']['endereco_cliente'];
        $notaCredito->conta_corrente_cliente = $request['facturaRectificada']['conta_corrente_cliente'];
        $notaCredito->nextFactura = $request['facturaRectificada']['nextFactura'];
        $notaCredito->faturaReference = $request['facturaRectificada']['faturaReference'];
        $notaCredito->total_incidencia = $request['facturaRectificada']['total_incidencia'];
        $notaCredito->desconto = $request['facturaRectificada']['desconto'];
        $notaCredito->total_preco_factura = $request['facturaRectificada']['total_preco_factura'];
        $notaCredito->valor_a_pagar = $request['facturaRectificada']['valor_a_pagar'];
        $notaCredito->numeroItems = $request['facturaRectificada']['numeroItems'];
        $notaCredito->formas_pagamento_id = $request['facturaRectificada']['formas_pagamento_id'];
        $notaCredito->anulado = $request['facturaRectificada']['anulado'];
        $notaCredito->armazen_id = $request['facturaRectificada']['armazen_id'];
        $notaCredito->retencao = $request['facturaRectificada']['total_retencao'];
        $notaCredito->multa = $request['facturaRectificada']['multa'];
        $notaCredito->valor_entregue = $request['facturaRectificada']['valor_entregue'];
        $notaCredito->total_iva = $request['facturaRectificada']['total_iva'];
        $notaCredito->troco = $request['facturaRectificada']['troco'];
        $notaCredito->numeracaoDocumento = $numeracaoDocumento;
        $notaCredito->data_vencimento = $request['facturaRectificada']['data_vencimento'];
        $notaCredito->codigo_moeda = $request['facturaRectificada']['codigo_moeda'];
        $notaCredito->facturaId = $request['facturaRectificada']['id'];
        $notaCredito->save();

        foreach ($request['facturaRectificada']['facturas_items']  as $key => $facturaItems) {

            $notaCreditoItems = new NotaCreditoItems();
            $quantFactura = $request->all()['factura']['facturas_items'][$key]['quantidade_produto'];
            if ($quantFactura != 0) {

                $notaCreditoItems->descricao_produto = $facturaItems['descricao_produto'];
                $notaCreditoItems->preco_compra_produto = $facturaItems['preco_compra_produto'];
                $notaCreditoItems->preco_venda_produto = $facturaItems['preco_venda_produto'];
                $notaCreditoItems->quantidade_produto = $facturaItems['quantidade_produto'];
                $notaCreditoItems->desconto_produto = $facturaItems['desconto_produto'];
                $notaCreditoItems->incidencia_produto = $facturaItems['incidencia_produto'];
                $notaCreditoItems->retencao_produto = $facturaItems['retencao_produto'];
                $notaCreditoItems->iva_produto = $facturaItems['iva_produto'];
                $notaCreditoItems->total_preco_produto = $facturaItems['total_preco_produto'];
                $notaCreditoItems->produto_id = $facturaItems['produto_id'];
                $notaCreditoItems->factura_id = $facturaItems['factura_id'];
                $notaCreditoItems->codigoNotaCredito = $notaCredito->id;
                $notaCreditoItems->save();
            }
        }
        if ($retornarStock) {
            $this->voltarQtProdutoEstoque($request);
        }
        $facturaRepositorio = $facturaRepositorio->salvarFacturasRecificadas($request);

        if ($facturaRepositorio == null) {
            return response()->json(['isValid' => false, 'errors' => 'Erro ao retificar documento'], 500);
        }

        return response()->json($notaCredito, 200);
    }

    public function voltarQtProdutoEstoque($request)
    {

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        foreach ($request['facturaRectificada']['facturas_items']  as $key => $ft) {

            if ($ft['produto']['stocavel'] == "Sim") {
                ExistenciaStock::where('produto_id', $ft['produto_id'])
                    ->where('armazem_id', $request['factura']['armazen_id'])->where('empresa_id', $empresa['empresa']['id'])
                    ->increment('quantidade', $ft['quantidade_produto']);
            }
        }
    }



    public function verificarZeradoTodaQuantidadeDosItem($request)
    {

        $totalItem = count($request->all()['factura']['facturas_items']);
        $count = 0;
        foreach ($request->all()['factura']['facturas_items'] as $key => $item) {
            if ($item['quantidade_produto'] == 0) {
                $count++;
            }
        }

        if ($count == $totalItem) {
            return true;
        }
        return false;
    }

    public function verificarSeFacturaFoiRetificada($request)
    {

        $factura = DB::table('facturas')->where('id', $request->all()['factura']['id'])->where('empresa_id', $request->all()['factura']['empresa_id'])->first();

        if ($request->all()['factura']['numeroItems'] == $factura->numeroItems) {
            return true;
        }
        return false;
    }

    public function facturasContemRecibo($idFactura)
    {

        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        if (Auth::guard('web')->check()) {

            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
        } else {
            $empresa_id = Auth::user()->empresa_id;
        }

        $recibosItems = RecibosItem::where('empresa_id', $empresa_id)->where('factura_id', $idFactura)->first();

        return response()->json($recibosItems, 200);
    }
    public function listarFacturaProformas()
    {
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;


        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();


        $data['guard'] = $empresa['guard'];

        $data['proformas'] = Factura::with(['cliente', 'facturas_items', 'facturas_items.produto'])->where('tipo_documento', 3)->where('empresa_id', $empresa['empresa']['id'])->orderBy('id', 'DESC')->get();
        $data['formapagamentos'] = DB::connection('mysql2')->table('formas_pagamentos_geral')->get();

        return view("empresa.facturas.facturaProformasIndex", $data);
    }
    public function converterFacturaProforma(Request $request)
    {

        $mensagem = [
            "id.required" => "É obrigatório a indicação de um valor para o campo id da factura",
            "total_preco_factura.required" => "É obrigatório a indicação de um valor para o campo total da factura",
            "valor_entregue.required" => "É obrigatório a indicação de um valor para o campo valor entregue",
            "valor_a_pagar.required" => "É obrigatório a indicação de um valor para o campo valor a pagar",
            "troco.required" => "É obrigatório a indicação de um valor para o campo valor troco",
        ];

        $this->validate($request, [
            'id' => ['required'],
            'total_preco_factura' => ['required'],
            'valor_entregue' => ['required'],
            'valor_a_pagar' => ['required'],
            'troco' => ['required']
        ], $mensagem);

        $TIPO_DOC_FATURA_RECIBO = 1;
        $TIPO_DOC_FATURA = 2;
        // $TIPO_DOC_FATURA_PROFORMA = 3;

        if (Auth::guard('web')->check()) {

            if ((Auth::guard('web')->user()->tipo_user_id) == 1) {
                return view('admin.dashboard');
            }
        }

        if (Auth::guard('web')->check()) {
            $empresa = Empresa::where('user_id', Auth::user()->id)->first();
            $empresa_id = Empresa_Cliente::where('referencia', $empresa->referencia)->first()->id;
            $operador = Auth::user()->id;
            $nome_operador =  Auth::user()->name;
            $tipo_user_id = 2; //tipo empresa
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
            $operador = Auth::user()->id;
            $nome_operador = Auth::user()->name;
            $tipo_user_id = 3; //tipo funcionario
        }


        $verificadorDocumento = new VerificadorDocumento('facturas');
        if (!$verificadorDocumento->comparaDataDocumentoAnteriorComActual()) {
            return [
                "errors" => "A data deste documento é inferior a anterior", "status" => 401
            ];
        }

        $resultadoEstoque = $this->verificarProdutoExisteEstoque($request->all());


        if ($resultadoEstoque) {
            return response()->json(['isValid' => false, 'errors' => 'o produto ' . $resultadoEstoque['descricao_produto'] . ' está com estoque menor'], 401);
        }

        //Recupera informações da tabela parametros para o campo data_vencimento da factura
        $paramentro = DB::connection('mysql2')->table('parametros')->where('id', 20)->first();


        //Recupera informações da última factura cadastrada no banco de dados desta empresa

        if ($request->tipo_documento === $TIPO_DOC_FATURA) {
            $facturas = DB::connection('mysql2')->table('facturas')->where('empresa_id', $empresa_id)->where('tipo_documento', $TIPO_DOC_FATURA)->orderBy('id', 'DESC')->limit(1)->first();
        }
        if ($request->tipo_documento == $TIPO_DOC_FATURA_RECIBO) {
            $facturas = DB::connection('mysql2')->table('facturas')->where('empresa_id', $empresa_id)->where('tipo_documento', $TIPO_DOC_FATURA_RECIBO)->orderBy('id', 'DESC')->limit(1)->first();
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

        //Manipulação de datas: data da factura e data actual
        //$data_factura = Carbon::createFromFormat('Y-m-d H:i:s', $facturas->created_at);
        $datactual = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));

        /*Recupera a sequência numérica da última factura cadastrada no banco de dados e adiona sempre 1 na sequência caso o ano da afctura seja igual ao ano actual;
        E reinicia a sequência numérica caso se constate que o ano da factura é inferior ao ano actual.*/
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



        /*Cria uma série de numerção para cada factura, variando de acordo o tipo de factura, a o ano actual e numero sequencial da factura */
        if ($request->tipo_documento == $TIPO_DOC_FATURA) {

            $numeracaoFactura = 'FT ' . mb_strtoupper(substr($empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
        }
        if ($request->tipo_documento == $TIPO_DOC_FATURA_RECIBO) {
            $numeracaoFactura = 'FR ' . mb_strtoupper(substr($empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
        }
        // if ($request->tipo_documento == $TIPO_DOC_FATURA_PROFORMA) {
        //     $numeracaoFactura = 'PP ' . mb_strtoupper(substr($empresa->nome, 0, 3) . '' . date('Y')) . '/' . $numSequenciaFactura; //retirar somente 3 primeiros caracteres na facturaSerie da factura: substr('abcdef', 0, 3);
        // }



        $factura = new Factura();

        $rsa = new Crypt_RSA(); //Algoritimo RSA

        $privatekey = "MIICXAIBAAKBgQCqJsIyoKXnIyhFSwNZFE1lyGcsqn+6alTls2kzK8AsxIT21vD3
        ct0M8DlAUiPaeODU+wFmVpcGkSVRysDzXF6XvtBrZMk9qWbYrjuiXwAcMupXcR7d
        UWbc4QQbVqVYjE+MaOaR8YircAbq8bwHPpF+TYdQD5VdoAgE5YR240R4FQIDAQAB
        AoGAZq6pN2BXfltrLBYO2S01YB1Gll/2YQtWXKCe9fCLMvkNvOEN3mcFG4/FHRn0
        5R1ZoW4w9A+BaMcjHG8dbj/qHPD/9G3qvXmNN1J3d4vIe5QMqNEl8/OrdGGtxVlt
        QxDXjnsWr2vtayRZb7puxkxOBlLTyxfLlMVI3kefnv9U/+kCQQDdqzXNZsQiUIaP
        9GBaKE4/0rANYIINhf291u7XgyjuCdo+q3xuOyK0MNcJ/+ei0jLkXx9ao35mRggC
        nrJwWvnHAkEAxID4wrgWkb/7DEdf0xsMW2gk7Lq2L0/GziK1A3kMTUfCOfBy+fhY
        Suuu+1tw0oSlklYYlCzPT1CI+xf0HxofQwJAUxjzumRj8lktmJmL5UBm1RYuWVVs
        a5VnYdtI/hF1LocTAZtXshsJD3OfqWf9ddRGr8XZAyl3IO/v4MuNKQFx0QJATq7d
        7QpNbzsSSU5jHmLcRdWjw27X+IXXMz9Of/9+X4t2SEDxqQo6QHWy8U8iFAmtSrVS
        zjJLKJU05GYpCDMrhQJBAL6uhphR3SQgypTLlRB+XezzrDsjYBTPWjbGHekmT69k
        YODqjiQlUizmtxgJ3cZLU/hOFyJJ41qF+o2+SmwYy5s=";

        $publickey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCqJsIyoKXnIyhFSwNZFE1lyGcs
        qn+6alTls2kzK8AsxIT21vD3ct0M8DlAUiPaeODU+wFmVpcGkSVRysDzXF6XvtBr
        ZMk9qWbYrjuiXwAcMupXcR7dUWbc4QQbVqVYjE+MaOaR8YircAbq8bwHPpF+TYdQ
        D5VdoAgE5YR240R4FQIDAQAB";

        // Lendo a private key
        $rsa->loadKey($privatekey);

        /*Texto que deverá ser assinado com a assinatura RSA::SIGNATURE_PKCS1, e o Texto estará mais ou menos assim após as
        Concatenações com os dados preliminares da factura: 2020-09-14;2020-09-14T20:34:09;FP PAT2020/1;457411.2238438; */

        $total_preco_factura = $request->total_preco_factura - $request->desconto;
        $totalRetencao  = $total_preco_factura * $request->retencao;

        $plaintext = str_replace(date(' H:i:s'), '', $datactual) . ';' . str_replace(' ', 'T', $datactual) . ';' . $numeracaoFactura . ';' . number_format($request->valor_a_pagar + $totalRetencao, 2, ".", "") . ';' . $hashAnterior;

        // HASH
        $hash = 'sha1'; // Tipo de Hash
        $rsa->setHash(strtolower($hash)); // Configurando para o tipo Hash especificado em cima

        //ASSINATURA
        $rsa->setSignatureMode(RSA::SIGNATURE_PKCS1); //Tipo de assinatura
        $signaturePlaintext = $rsa->sign($plaintext); //Assinando o texto $plaintext(resultado das concatenações)

        // Lendo a public key
        $rsa->loadKey($publickey);

        $factura->total_preco_factura = $request->total_preco_factura;
        $factura->valor_entregue = $request->valor_entregue;
        $factura->valor_a_pagar = $request->valor_a_pagar;
        $factura->troco = $request->troco;
        $factura->valor_extenso = $request->valor_extenso;
        $factura->codigo_moeda = $request->codigo_moeda; //ver este
        $factura->desconto = $request->desconto;
        $factura->total_iva = $request->total_iva;
        $factura->multa = $request->multa;

        $factura->nome_do_cliente = $request->cliente != null && $request->cliente['nome']  ? $request->cliente['nome'] : "Consumidor final";
        $factura->telefone_cliente = $request->cliente != null && isset($request->cliente['telefone_cliente']) ? $request->cliente['telefone_cliente'] : "";
        $factura->nif_cliente = $request->cliente != null && isset($request->cliente['nif']) ? $request->cliente['nif'] : "999999999";
        $factura->email_cliente = $request->cliente != null && isset($request->cliente['email']) ? $request->cliente['email'] : NULL;
        $factura->conta_corrente_cliente = $request->cliente != null && isset($request->cliente['conta_corrente']) ? $request->cliente['conta_corrente'] : NULL;
        $factura->endereco_cliente = $request->cliente != null && isset($request->cliente['endereco']) ? $request->cliente['endereco'] : NULL;


        if (!empty($request->cliente['id'])) {
            $factura->cliente_id = $request->cliente['id'];
        }

        $factura->tipoFolha = "A4";


        //se for uma factura o statusFactura será igual a divida;
        if ($request->tipo_documento == 2) {
            $factura->statusFactura = 1;
        }

        $facturaPago = 2;
        $facturaDivida = 1;

        $factura->tipo_documento = $request->tipo_documento;
        $factura->numeroItems = $request->numeroItems;
        $factura->observacao =  $request->observacao;
        $factura->retencao = $request->retencao;
        $factura->retificado = $request->retificado;
        $factura->formas_pagamento_id = $request->formas_pagamento_id;
        $factura->descricao = $request->descricao;
        $factura->armazen_id = $request->armazen_id; //ver este
        $factura->canal_id = $request->canal_id;
        $factura->status_id = $request->status_id;
        $factura->empresa_id = $empresa_id;
        $factura->user_id = $operador;
        $factura->statusFactura = $request->tipo_documento == $TIPO_DOC_FATURA_RECIBO ? $facturaPago : $facturaDivida;
        $factura->operador = $nome_operador;
        $factura->tipo_user_id = $tipo_user_id;
        $factura->data_vencimento = Carbon::now()->addDays($paramentro->vida);
        $factura->numSequenciaFactura = $numSequenciaFactura;
        $factura->numeracaoFactura = $numeracaoFactura;
        $factura->save();

        $facturaResponse = Factura::where('id', $factura->id)->limit(1)->update(['hashValor' => base64_encode($signaturePlaintext)]); //Actualiza sempre o Hash da última factura


        if ($facturaResponse) {

            $total_incidencia = 0;
            $total_retencao = 0;

            if (isset($request->facturas_items) && !empty($request->facturas_items)) {

                foreach ($request->facturas_items as $prod) {
                    if ($prod['produto']['stocavel'] == "Sim") {
                        //Verifica se for diferente de factura proforma
                        if ($factura['tipo_documento'] != 3) {

                            //dd($prod['quantidade_produto']);
                            DB::connection('mysql2')->table('existencias_stocks')
                                ->where('empresa_id', $empresa_id)->where('produto_id', $prod['produto_id'])
                                ->where('armazem_id', $request->armazen_id)->decrement('quantidade', $prod['quantidade_produto']);
                        }
                    }

                    $total_incidencia += $prod['incidencia_produto'];
                    $total_retencao += $prod['retencao_produto'];

                    DB::connection('mysql2')->table('factura_items')->insert([
                        'descricao_produto' => $prod['descricao_produto'],
                        'factura_id' => $factura->id,
                        'produto_id' => $prod['produto_id'],
                        'preco_venda_produto' => $prod['preco_venda_produto'],
                        'preco_compra_produto' => $prod['preco_compra_produto'],
                        'desconto_produto' => $prod['desconto_produto'],
                        'quantidade_produto' => $prod['quantidade_produto'],
                        'total_preco_produto' => $prod['total_preco_produto'],
                        'retencao_produto' => $prod['retencao_produto'],
                        'incidencia_produto' => $prod['incidencia_produto'],
                        'iva_produto' => $prod['iva_produto']
                    ]);
                }


                //actualiza dados da factura atual
                Factura::where('id', $factura->id)->where('empresa_id', $empresa_id)
                    ->update(['total_incidencia' => $total_incidencia, 'retencao' => $total_retencao]);

                $statusConvertido = 2;

                if ($request->tipo_documento == 1) {
                    $statusFactura = 2;
                } else {
                    $statusFactura = 1;
                }

                Factura::where('id', $request->all()['id'])->where('empresa_id', $request->all()['empresa_id'])
                    ->update(['convertidoFactura' => $statusConvertido, 'statusFactura' => $statusFactura]);
            }
            //Cadastrar Movimentos e Movimentos items tabela contsys
            //Verifica se for diferente de factura proforma
            if ($factura['tipo_documento'] != 3) {
                $contsys = new ContsysFacturacaoController();
                $movimentos = $contsys->cadastrarMovimentos($factura);
                $contsys->cadastrarMovimentosItems1($factura->cliente_id, $factura, $movimentos);
                $contsys->cadastrarMovimentosItems2($factura, $movimentos);
            }


            return response()->json($factura, 200);
        }
    }

    public function verificarProdutoExisteEstoque($factura)
    {
        foreach ($factura['facturas_items'] as $key => $ft_item) {
            $existencia = DB::connection('mysql2')->table('existencias_stocks')
                ->where('empresa_id', $factura['empresa_id'])
                ->where('armazem_id', $factura['armazen_id'])->where('produto_id', $ft_item['produto_id'])->first();
            if ($ft_item['quantidade_produto'] > $existencia->quantidade && $ft_item['produto']['stocavel'] == "Sim") {
                return $ft_item;
            }
            return false;
        }
    }

    /**
     * Controller Api
     *
     */
    public function listarFacturas()
    {

        if (Auth::guard('WebApi')->check()) {
            return response()->json(['status' => 'Usuário não permitido']);
        } else {
            $empresa_id = auth()->user()->empresa_id;
        }
        $data['facturas'] = Factura::with(
            [
                'tipoUser', 'tipoDocumento', 'facturas_items',
                'formaPagamento', 'armazem',
                'cliente', 'empresa', 'canal',
                'status', 'user'
            ]
        )->where('empresa_id', $empresa_id)->paginate(15);

        return response()->json($data, 200);
    }
    public function facturasLicencasIndex()
    {

        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $adminEmpresa = DB::connection('mysql')->table('empresas')->where('referencia', $empresa['empresa']['referencia'])->first();

        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $data['facturas'] = AdminFactura::where('empresa_id', $adminEmpresa->id)->get();
        //  dd($data['facturas']);
        return view('empresa.facturas.facturasLicencasIndex', $data);
    }
    public function reciboFacturaLincencaIndex()
    {


        $STATUS_ATIVO = 1;
        $infoNotificacao = $this->alertarActivacaoLicenca();
        $data['alertaAtivacaoLicenca'] = $infoNotificacao;

        $empresa = $this->pegarEmpresaAutenticadaGuardOperador();

        $adminEmpresa = DB::connection('mysql')->table('empresas')->where('referencia', $empresa['empresa']['referencia'])->first();

        $data['guard'] = $empresa['guard'];

        if ($infoNotificacao['diasRestantes'] === 0) {
            return redirect("empresa/home");
        }
        if ($this->isAdmin()) {
            return view('admin.dashboard');
        }

        $data['recibos'] = Pagamento::with(['formaPagamento', 'contaMovimento', 'coordernadaBancaria'])
            ->where('empresa_id', $adminEmpresa->id)
            ->where('status_id', $STATUS_ATIVO)
            ->get();
        return view('empresa.facturas.recibosFacturasLicencaIndex', $data);
    }
    public function imprimirReciboLicenca($reciboFacturaLicencaId, $viaImpressao = 1)
    {

        $reportController = new ReportController();
        if (isset($_GET['viaImpressao']) && !empty($_GET['viaImpressao'])) {
            $viaImpressao = $_GET['viaImpressao'];
        }
        return $reportController->imprimirReciboLicenca($reciboFacturaLicencaId, $viaImpressao);
    }
    public function imprimirFacturaPdv1(Request $request)
    {
        $data['factura'] = Factura::with(['facturas_items', 'empresa', 'empresa.tiporegime', 'user', 'formaPagamento', 'cliente'])
            ->where('empresa_id', Auth::user()->empresa_id)
            ->where('id', $request->facturaId)->first();
        return view('empresa.pdv.imprimirFacturaPdv1', $data);
    }
    public function imprimirFactura(Request $request)
    {
        $data['factura'] = Factura::with(['facturas_items', 'empresa', 'empresa.tiporegime', 'user', 'formaPagamento', 'cliente'])
            ->where('empresa_id', Auth::user()->empresa_id)
            ->where('id', $request->facturaId)->first();

        return view('empresa.pdv.imprimirFactura', $data);
    }
    public function reimprimirFactura(Request $request)
    {

        $data['factura'] = Factura::with(['facturas_items', 'empresa', 'empresa.tiporegime', 'user', 'formaPagamento', 'cliente'])
            ->where('empresa_id', Auth::user()->empresa_id)
            ->where('id', $request->facturaId)->first();

        return view('empresa.pdv.reimprimirFactura', $data);
    }
    public function imprimirFacturaTicket(Request $request)
    {

        $data['factura'] = Factura::with(['facturas_items', 'empresa', 'empresa.tiporegime', 'user', 'formaPagamento', 'cliente'])
            ->where('empresa_id', Auth::user()->empresa_id)
            ->where('id', $request->facturaId)->first();

        return view('empresa.pdv.imprimirFacturaTicket', $data);
    }
}
