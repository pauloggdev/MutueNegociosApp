<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title></title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

      <!-- Aqui é o estilo da tabela com bootstrap.min.css 3.3.7 -->
        <link rel="stylesheet" href="{{url('assets/css/factura_tabelas.css')}}" />
      <!-- Aqui é estilo geral da folha AdminLTE -->
        <link rel="stylesheet" href="{{url('assets/css/factura.css')}}" />
    </head>

    <!-- <body onload="window.print();"> -->
    <body onload="window.print();">
        <div class="wrapper">
          <!-- Main content -->
            <section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="">
                        <h2 class="page-header">
                            <span class="" style="font-size: 12pt;">
                            @if(!empty($recibo->logotipo))
                                <img style="bottom: 25px; position: relative;" width="150" height="100" alt="200x200" src="{{url('storage/utilizadores/admin/'.$recibo->logotipo)}}" />
                            @else
                            {{mb_strtoupper($recibo->nome)}}
                            @endif
                            </span>
                            <small class="col-sm-5 pull-right"><strong>Data do Recibo: {{$recibo->dataPagamento ? date('d-m-Y H:i:s', strtotime($recibo->dataPagamento)) : ''}}</strong></small>
                        </h2>
                    </div>
                <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info" style="font-size: 9.5pt;">
                    <div >
                        <div class="col-sm-6 invoice-col pull-left" >
                            DE:
                            <address id="notices" class="notice">
                                <strong>{{mb_strtoupper($recibo->nome)}}</strong><br>
                                Endereço: {{mb_strtoupper($recibo->endereco)}}<br>
                                NIF: {{mb_strtoupper($recibo->nif)}}<br>
                                Telefone: {{$recibo->pessoal_Contacto}}|{{$recibo->pessoal_Contacto}}<br>
                                Telemóvel: {{$recibo->pessoal_Contacto}}<br>
                                Email: {{$recibo->email}}<br>
                            </address>
                            <div id="noticias" class="noticia">
                                <b style="margin-top: 55px;">Luanda-Angola</b><br>
                                <b style="margin-top: 55px;">{{mb_strtoupper("Recibo de Pagamento")}}</b><br>
                                <b style="margin-top: 55px;">{{"Este Documento não serve de Factura"}}</b>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6 pull-right">
                            CLIENTE:
                            <address id="notices" class="notice">
                                <strong>{{mb_strtoupper($recibo->nome_do_cliente)}}</strong><br>
                                Telefone: {{$recibo->telefone_cliente}}<br>
                                E-Mail: {{$recibo->email_cliente}}<br>
                                NIF: {{$recibo->nif_cliente}}<br>
                                Endereço: {{mb_strtoupper($recibo->endereco_cliente)}}<br>
                                <!-- Conta Corrente N.º: <br> -->
                            </address>
                            <!-- Referência da factura -->
                            <!-- <b style="margin-top: 55px;">REF: {{$recibo->faturaReference}}</b><br> -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <br>
                <table class="table table-striped" style="font-size: 9.5pt;">
                    <tr>
                        <th>RC <?=date("Y")?>/{{$recibo->pagamento_id}}</th>
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
                @for($i=0;$i<=2;$i++)
                    <br>
                @endfor
                <footer style="border: 1px solid black!important; font-size: 9.5pt;">
                    <div class="row" style="margin-top: 5px;"> 
                        <div class="col-md-3 pull-left">
                            <table class="table-striped">
                                <tr><th style="padding: 1px 10px;">Obervação</th></tr>
                                <tr>
                                    <td style="padding: 1px 10px;">
                                        <ul>
                                            <li style="list-style: none; text-indent: 6px;">{{$recibo->obs}}</b></li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    
                        <div class="col-md-3 pull-right">
                            <table class="table-striped" id="tabela2">
                                <tr>
                                    <th>Total</th>
                                    <td>{{number_format($recibo->totalPago,2,",",".")}}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-3 pull-left">
                            <br>
                            <ul>
                                <li >Os bens/serviços foram colocados à disposição do adquirente na data do documento</li>
                                <li style="font-weight: bolder;">{{ucfirst($recibo->regime_empresa)}}</li>
                                <li style="font-weight: bolder;">{{mb_strtoupper(substr($recibo->hashValor, 0, 4))}}-Processado por programa Certificado nº 32/AGT/2019 (Mutue-Negócio)</li>
                            </ul>
                        </div>
                        <!-- <div style="">
                            <div id="">
                                <img width="95px"  height="95px" src="img/qrcode_fatura.png" alt="">
                            </div>
                        </div> -->
                    </div>
                    <nav style="text-align: center;">Total por extenso: <b>{{$recibo->valor_extenso}}</b></nav>
                </footer>
                <center style="text-align: center;"> Software de gestão comercial online, desenvolvido e Assistido pela Ramossoft, <b>www.ramossoft.com</b></center>
                <!-- /.footer -->
            </section>
            <!-- /.content -->
        </div>
        <!-- ./wrapper -->
    </body>

    <style type="text/css">
        #tabela2 td{
            padding: 2px 18px;
            text-align: right;
        }

        #tabela1 td{
            text-align: left;
        }
        
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 4px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }
    </style>
</html>