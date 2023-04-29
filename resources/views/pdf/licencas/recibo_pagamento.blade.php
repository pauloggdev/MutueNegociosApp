<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Aqui é o estilo da tabela com bootstrap.min.css 3.3.7 -->
        <link rel="stylesheet" href="assets/css/factura_tabelas.css" media="all" />
        <!-- Aqui é estilo geral da folha AdminLTE -->
        <!-- <link rel="stylesheet" href="assets/css/factura.css" media="all" /> -->
        <title>Recibo de Pagamento</title>
    </head>

    <!-- <body onload="window.print();"> -->

    <body onload="window.print();">
        <div class="row" style="font-size: 9pt;">
            <div style="float: left; width: 100px; margin-right:30px;">
                <span class="" style="font-size: 12pt;">
                    @if(!empty($recibo->logotipo))
                    <img alt="200x200" src="/upload/<?= $recibo->logotipo ?>" style="max-width: 100%; border-radius: 30px; height: 72px; width: 75px; left: 14px; position: relative" />
                    @else
                    {{mb_strtoupper($recibo->nome)}}
                    @endif
                </span>
            </div>
            <div style="float: right;  width: 200px; margin-left:30px; margin-top: 20px;"><strong>Emitido: {{$recibo->dataPagamento ? date('d-m-Y H:i:s', strtotime($recibo->dataPagamento)) : ''}}</strong></div>
            <div style="clear: both;"></div>
        </div>

        <div class="row" style="font-size: 9pt;border-bottom: 0.3px solid #403e3eb0!important; padding:5px;"></div>

        <br>
        <div class="row" style="font-size: 9pt;">
            <div style="float: left; width: 200px; margin-right:30px;">
                <div id="notices" class="notice">
                    DE: <br>
                    <strong>{{mb_strtoupper($recibo->nome)}}</strong><br>
                    Endereço: {{mb_strtoupper($recibo->endereco)}}<br>
                    NIF: {{mb_strtoupper($recibo->nif)}}<br>
                    Telefone: {{$recibo->pessoal_Contacto}}|{{$recibo->pessoal_Contacto}}<br>
                    Telemóvel: {{$recibo->pessoal_Contacto}}<br>
                    <!-- Website: {{$recibo->Website}}<br> -->
                    Email: {{$recibo->email}}
                </div>
                <br>
                <div id="noticias" class="noticia">
                    <b style="margin-top: 55px;">Luanda-Angola</b><br>
                    <b style="margin-top: 55px;">{{mb_strtoupper("Recibo de Pagamento")}}</b><br>
                    <b style="margin-top: 55px;">{{"Este Documento não serve de Factura"}}</b>
                </div>
            </div>

            <div id="notices" class="notice" style="float: right;  width: 200px; margin-left:30px;">
                CLIENTE: <br>
                <strong>{{mb_strtoupper($recibo->nome_do_cliente)}}</strong><br>
                Telefone: {{$recibo->telefone_cliente}}<br>
                E-Mail: {{$recibo->email_cliente}}<br>
                NIF: {{$recibo->nif_cliente}}<br>
                Endereço: {{mb_strtoupper($recibo->endereco_cliente)}}<br>
                <!-- Conta Corrente N.º: <br> -->
            </div>
            <div class="clear"></div>
        </div>

        <br><br>
        <table class="table table-striped" style="font-size: 9.5pt;">
            <tr>
                <th>RC <?= date("Y") ?>/{{$recibo->pagamento_id}}</th>
                <th>Moeda: {{mb_strtoupper($recibo->moeda)}}</th>
                <th>Forma de Pagamento: {{mb_strtoupper($recibo->forma_pagamento)}}</th>
                <th><b style="margin-top: 55px;">REF: {{$recibo->faturaReference}}</b><br></th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <!-- Table row -->
        <div class="row" style="font-size: 9.5pt;">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Data da Opreração</th>
                            <th>Descrição</th>
                            <th>Desconto</th>
                            <th style="width:10%">Taxa</th>
                            <th>Retenção</th>
                            <th>Valor</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>{{$recibo->dataPagamento ? date('d-m-Y', strtotime($recibo->dataPagamento)) : ''}}</td>
                            <td>{{"Liquidação da Factura de REF:".$recibo->faturaReference}}</td>
                            <td>{{number_format(($recibo->desconto/$recibo->totalPago)*100,1,",",".")}}%</td>
                            <td>{{number_format($recibo->total_iva,2,",",".")}}%</td>
                            <td style="text-align: center;">{{number_format(($recibo->retencao/$recibo->totalPago)*100,1,",",".")}}%</td>
                            <td>{{number_format($recibo->totalPago,2,",",".")}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        @for($i=0; $i<=10; $i++)
        <br>
        @endfor
        <div class="row" style="font-size: 9pt;border: 1px solid black!important; padding:10px;"> 
            
            <div style="float: right;">
                <table class="table-striped" id="tabela2">
                    <tr>
                        <th>Total</th>
                        <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <td style="text-align: right">{{number_format($recibo->totalPago,2,",",".")}}</td>
                    </tr>
                </table>
            </div>

            <div style="float: left;margin-right:30px;">
                <table class="table-striped">
                    <tr>
                        <th>Observação</th>
                    </tr>
                    <tr>
                        <td>{{mb_strtoupper($recibo->obs)}}</td>
                    </tr>
                </table>
            </div>  

            <div class="clear"></div>
            
            <br>
            <div class="row">
                <nav style="text-align: center; font-size: 11pt;">Total por extenso: <b>{{$recibo->valor_extenso}}</b></nav>
            </div>
        </div>
        
        <br>
        
        <div class="row">
            <div class="pull-left">
                <ul>
                    <li >Os bens/serviços foram colocados à disposição do adquirente na data do documento</li>
                    <li style="font-weight: bolder;">{{ucfirst($recibo->regime_empresa)}}</li>
                    <li style="font-weight: bolder;">{{mb_strtoupper(substr($recibo->hashValor, 0, 4))}}-Processado por programa Certificado nº 32/AGT/2019 (Mutue-Negócio)</li>
                </ul>
            </div>
        </div>
        
        <div class="row" style="font-size: 9pt;border-bottom: 1px solid black!important; padding:5px;"></div>
        <div class="row" style="font-size: 8pt;">
            <div style="text-align: center;"><i>Software de gestão comercial online, desenvolvido e Assistido pela Ramossoft-Fábrica de Softwares, <b>www.ramossoft.com</b></i> </div>
        </div>
    </body>
    <style>
        * {
            font-family: "Lato", sans-serif;
        }

        body {
            margin: 0;
        }

        .clear {
            clear: both;
        }

        #tabela2 {
            text-align: left;
        }

        #notices {
            padding-left: 9px;
            border-left: 6px solid red;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        #noticias {
            padding-left: 9px;
            border-left: 6px solid rgb(62, 9, 209);
        }

        #noticias .noticia {
            font-size: 1.2em;
        }
    </style>
</html>