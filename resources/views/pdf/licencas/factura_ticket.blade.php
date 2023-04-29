<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{$factura->tipo_documento}} | Ticket</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Aqui é o estilo da tabela com bootstrap.min.css 3.3.7 -->
        <link rel="stylesheet" href="assets/css/factura_tabelas.css" media="all"  />
        <!-- Aqui é estilo geral da folha AdminLTE -->
        <link rel="stylesheet" href="assets/css/factura.css" media="all" />
    </head>

    <body onload="window.print();">

        <header>
            <div id="notices" class="row notice">
                <div class="col-md-12">
                    <ul>
                        <li><strong>{{mb_strtoupper($factura->nome)}}</strong></li> <br>
                        <li>NIF: {{mb_strtoupper($factura->nif)}}</li>
                        <li>Telefone: {{$factura->pessoal_Contacto}}</li>
                        <li>Email: {{$factura->email}}</li>
                        <li>Website: {{$factura->Website}}</li>
                    </ul>
                </div>
            </div>
        </header>

        <section>
            <div class="cliente">
                <div class="factura">{{$factura->tipo_documento}} REF:103243984</div>
                <ul id="notices" class="notice">
                    @if($factura->tipo_documento =="FACTURA")
                    <th>FT {{$factura->numeracaoFactura}}/{{$factura->numSequenciaFactura}}</th>
                    @elseif($factura->tipo_documento=="FACTURA PROFORMA")
                    <th>FP {{$factura->numeracaoFactura}}/{{$factura->numSequenciaFactura}}</th>
                    @elseif($factura->tipo_documento=="FACTURA RECIBO")
                    <th>FR {{$factura->numeracaoFactura}}/{{$factura->numSequenciaFactura}}</th>
                    @endif
                    <li>Emitido: {{$factura->dataFactura ? date('d-m-Y H:i:s', strtotime($factura->dataFactura)) : ''}}</li>
                    <li>Cliente: {{mb_strtoupper($factura->nome_do_cliente)}}</li>
                    <li>NIF: {{$factura->nif_cliente}}</li>
                    <li>Telefone: {{$factura->telefone_cliente}}</li>
                    <li>E-Mail: {{$factura->email_cliente}}</li>
                    <!-- <li>Conta Nº: {{$factura->telefone_cliente}}</li> -->
                </ul>
            </div>
        </section>

        <table class="table">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Qtd.</th>
                    <th>Preço</th>
                    <th style="width:10%">Taxa</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($fatura_items as $key => $item)
                <tr>
                    <td>{{($item->descricao_produto)}}</td>
                    <td>{{$item->quantidade_produto }}</td>
                    <td>{{number_format($item->preco_produto,2,",",".")}}</td>
                    <td>{{$item->descricao_taxa}}</td>
                    <td>{{number_format($item->total_preco_produto,2,",",".")}}</td>
                </tr>
                @empty
                    <span>Lista de Items vazia</span>
                @endforelse
            </tbody>
        </table>

        <div class="col-md-3 pull-right">
            <table class="table-striped" id="tabela2" style="width: 100%;">
                <tr>
                    <th>Total da Fatura</th>
                    <td style="text-align: right;">{{number_format($factura->total_preco_factura,2,",",".")}}</td>
                </tr>
                <tr>
                    <th>Total IVA</th>
                    <td style="text-align: right;">{{number_format($factura->total_iva,2,",",".")}}</td>
                </tr>
                <tr>
                    <th>Desconto</th>
                    <td style="text-align: right;">{{number_format($factura->desconto,2,",",".")}}</td>
                </tr>
                <tr>
                    <th>Retenção na fonte(6.5%)</th>
                    <td style="text-align: right;">{{number_format($factura->retencao,2,",",".")}}</td>
                </tr>
                @if(($factura->tipo_documento =="FACTURA") || ($factura->tipo_documento=="FACTURA PROFORMA"))
                <tr>
                    <th>Total a Pagar</th>
                    <td style="font-weight: bold; text-align: right;">{{number_format($factura->valor_a_pagar,2,",",".")}}</td>
                </tr>
                @else
                <tr >
                    <th>Total pago</th>
                    <td style="font-weight: bold; text-align: right;">{{number_format($factura->valor_a_pagar,2,",",".")}}</td>
                </tr>
                <tr >
                    <th>Valor Entregue</th>
                    <td style="font-weight: bold; text-align: right;">{{number_format($factura->valor_entregue,2,",",".")}}</td>
                </tr>
                <tr>
                    <th>Troco</th>
                    <td class="" style="font-weight: bold; text-align: right;">{{number_format($factura->troco,2,",",".")}}</td>
                </tr>
                @endif
            </table>
        </div>

        <footer>
            <div>
                <nav style="text-align: center;">{{mb_strtoupper($factura->valor_extenso)}}</nav>
            </div>
            <div class="col-md-3 pull-left">
                <br>
                <ul>
                    <li>Os bens/serviços foram colocados à disposição do adquirente na data do documento</li>
                    <li style="font-weight: bolder;">{{ucfirst($factura->regime_empresa)}}</li>
                    <li style="font-weight: bolder;">{{mb_strtoupper(substr($factura->hashValor, 0, 4))}}-Processado por programa Certificado nº 32/AGT/2019 (Mutue-Negócios)
                    </li>
                </ul>
            </div><br><br><br>

            <div style="text-align: center;"> Software de gestão comercial online, desenvolvido e Assistido pela Ramossoft-Fábrica de Softwares,
                <b>www.ramossoft.com</b>
            </div>
        </footer>
    </body>
</html>

<style>
    * {
        font-family: "Lato", sans-serif;
    }

    body {
        margin: 0;
        font-size: 11px;
    }

    ul li {
        list-style: none;
    }

    ul {
        margin: 0;
        padding: 0;
    }

    .cliente {
        border: 1px solid #333;
        margin-bottom: 10px;
        margin-top: 10px;
        padding: 10px;
    }

    .factura {
        text-align: center;
        font-weight: 700;
        margin-bottom: 5px;

    }

    thead {
        text-align: left;
    }

    tbody {
        text-align: left;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        padding: 4px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }

    .subtotal{
        display: flex;
        justify-content: space-between;
    }

    #notices{
        padding-left: 9px;
        border-left: 6px solid red;  
    }
    
    #notices .notice {
        font-size: 1.2em;
    }

    #noticias{
        padding-left: 9px;
        border-left: 6px solid rgb(62, 9, 209);  
    }
    
    #noticias .noticia {
        font-size: 1.2em;
    }
</style>