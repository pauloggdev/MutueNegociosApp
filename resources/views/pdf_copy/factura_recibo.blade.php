<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Factura | Factura-Recibo</title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

      <!-- Aqui é o estilo da tabela com bootstrap.min.css 3.3.7 -->
        <link rel="stylesheet" href="{{asset('assets/css/factura_tabelas.css')}}" />
      <!-- Aqui é estilo geral da folha AdminLTE -->
        <link rel="stylesheet" href="{{asset('assets/css/factura.css')}}" />
    </head>

    <!-- <body onload="window.print();"> -->
    <body onload="window.print();">
        <div class="wrapper">
          <!-- Main content -->
            <section class="invoice">
                <!-- title row -->
                <div class="row">
                    <div class="col-xs-12">
                        <h2 class="page-header">
                            <i class="fa fa-globe"></i> Ramossoft, Inc.
                            <small class="pull-right"><strong>Data da Factura: 25/06/2020 05:58:35</strong></small>
                        </h2>
                    </div>
                <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-xs-12">
                        <div class="col-sm-7 invoice-col">
                            DE:
                            <address>
                                <strong>RAMOSSOFT TECNOLOGIAS LDA</strong><br>
                                Endereço: RUA DO G.SHOPPING, POR TRÁS DA CASA DOS FRESCOS<br>
                                NIF: 5000467766<br>
                                Telefone: 923 292 970|222 014 194<br>
                                Telemóvel: 924 484 343<br>
                                Website: www.ramossoft.com<br>
                                Email: info@ramossoft.com<br>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 pull-right">
                            PARA:
                            <address>
                                <strong>A LAVADEIRA, LDA</strong><br>
                                Telefone: 923 402 626<br>
                                E-Mail: amateus@live.com.pt<br>
                                NIF: Consumidor final<br>
                                Endereço: Kilamba, de fronte a Pumangol<br>
                                Conta Corrente N.º: 31.1.2.1.1134<br>
                            </address>
                            <!-- Referência da factura -->
                            <b style="margin-top: 55px;">REF 007612</b>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
               
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>FR AGT<?=date("Y")?>/4</th>
                            <th>Moeda: AKZ</th>
                            <th>Câmbio: 1,00</th>
                            <th>Forma de Pagamento: NUMERÁRIO</th>
                        </tr>
                    </thead>
                </table>

                <!-- Table row -->
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Producto</th>
                                    <th>Preço Unit.</th>
                                    <th>Qtd</th>
                                    <th>Un.</th>
                                    <th>Desc.</th>
                                    <th style="width:10%">Taxa</th>
                                    <th>Retenção</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>LICENCA DEFINITIVA GSCHOOL_SOFT 10PCS</td>
                                    <td>750.000,00</td>
                                    <td>2</td>
                                    <td>KG.</td>
                                    <td>0,0 %</td>
                                    <td>0,0 %</td>
                                    <td>0,0 %</td>
                                    <td>1.500.000,00</td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td>PENDRIVER VERBATIN 32GB</td>
                                    <td>16.000,00</td>
                                    <td>2</td>
                                    <td>KG.</td>
                                    <td>0,0 %</td>
                                    <td>0,0 %</td>
                                    <td>0,0 %</td>
                                    <td>32.000,00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <!-- /.col -->

                    <div class="col-md-3 pull-left">
                        <br>
                        <span style="font-weight: bold;">Operador: RAMOSSOFT </span> <br>
                        <b>____________________________</b>
                    </div>

                    <div class="col-md-4 pull-right">
                        <!-- <p class="lead">Taxas</p> -->
                        <div class="table-responsive">
                            <table class="table" id="tabela1">
                                <tr>
                                    <th style="width:50%">Taxa/Valor:</th>
                                    <td>IVA-Isento(0%)</td>
                                </tr>
                                <tr>
                                    <th>Incid./Qtd</th>
                                    <td>{{number_format(1500000,2,",",".")}}</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td>{{number_format(0,2,",",".")}}</td>
                                </tr>
                                <tr>
                                    <th>Motivo de isenção:</th>
                                    <td>IVA-Regime de não Sujeição</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>

                <br>
                <footer style="border: 1px solid black!important;height:300px;">
                    <div class="row"> 
                        <div class="col-md-3 pull-left">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Coordenadas Bancária</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for($i=1; $i<=3; $i++)
                                    <div>
                                        <tr>
                                            <td><strong>BFA: </strong>211664350/30/01-AO06.0006.0000.11664350301.55</td>
                                        </tr>
                                    </div>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    
                        <div class="col-md-3 pull-right">
                            <table class="table-striped" id="tabela2">
                                <tr>
                                    <th>Total da Fatura</th>
                                    <td>{{number_format(1500000,2,",",".")}}</td>
                                </tr>
                                <tr>
                                    <th>IVA</th>
                                    <td>{{number_format(0,2,",",".")}}</td>
                                </tr>
                                <tr>
                                    <th>Desconto</th>
                                    <td>{{number_format(0,2,",",".")}}</td>
                                </tr>
                                <tr>
                                    <th>Retenção na fonte(6.5%)</th>
                                    <td>{{number_format(0,2,",",".")}}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td style="font-weight: bold;">{{number_format(1500000,2,",",".")}}</td>
                                </tr>
                                <tr>
                                    <th>Total pago</th>
                                    <td>{{number_format(500000,2,",",".")}}</td>
                                </tr>
                                <tr>
                                    <th>Troco</th>
                                    <td>{{number_format(300000,2,",",".")}}</td>
                                </tr>
                            </table>
                        </div>

                        <div>
                            <ul>
                            <b style="">&nbsp; Observação</b>
                                <li style="list-style: none;">Este produto vale no mínimo</b></li>
                            </ul>
                        </div>

                        <div class="col-md-3 pull-left">
                            <ul>
                                <li >Os bens/serviços foram colocados à disposição do adquirente na data do</li>
                                <li style="font-weight: bolder;">Regime de Não Sujeição (Lei n.º 7/19 de 24 de Abril)</li>
                                <li style="font-weight: bolder;">KVEO-Processado por programa Certificado nº 32/AGT/2019 (Mutue-Negoócio)</li>
                            </ul>
                        </div>
                        <!-- <div style="">
                            <div id="">
                                <img width="95px"  height="95px" src="img/qrcode_fatura.png" alt="">
                            </div>
                        </div> -->
                    </div>
                    <nav style="text-align: center;">Total por extenso: <b>São um milhão e quinhentos mil de Kwanzas</b></nav>
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
            text-align: right;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
            padding: 4px;
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }
    </style>
</html>