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
                            @if(!empty($factura->logotipo))
                                <img style="bottom: 25px; position: relative;" width="150" height="100" alt="200x200" src="{{url('storage/utilizadores/admin/'.$factura->logotipo)}}" />
                            @else
                            {{mb_strtoupper($factura->nome)}}
                            @endif
                            </span>
                            <small class="col-sm-5 pull-right"><strong>Data Facturação: {{$factura->dataFactura}}</strong></small>
                        </h2>
                    </div>
                <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info" style="font-size: 9.5pt;">
                    <div class="">
                        <div class="col-sm-6 invoice-col pull-left" >
                            DE:
                            <address id="notices" class="notice">
                                <strong>{{mb_strtoupper($factura->nome)}}</strong><br>
                                Endereço: {{mb_strtoupper($factura->endereco)}}<br>
                                NIF: {{mb_strtoupper($factura->nif)}}<br>
                                Telefone: {{$factura->pessoal_Contacto}}|{{$factura->pessoal_Contacto}}<br>
                                Telemóvel: {{$factura->pessoal_Contacto}}<br>
                                Email: {{$factura->email}}<br>
                            </address>
                            <div id="noticias" class="noticia">
                                <b style="margin-top: 55px;">Luanda-Angola</b><br>
                                <b style="margin-top: 55px;">{{mb_strtoupper($factura->tipo_documento)}}</b>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6 pull-right">
                            CLIENTE:
                            <address id="notices" class="notice">
                                <strong>{{mb_strtoupper($factura->nome_do_cliente)}}</strong><br>
                                Telefone: {{$factura->telefone_cliente}}<br>
                                E-Mail: {{$factura->email_cliente}}<br>
                                NIF: {{$factura->nif_cliente}}<br>
                                Endereço: {{mb_strtoupper($factura->endereco_cliente)}}<br>
                                <!-- Conta Corrente N.º: <br> -->
                            </address>
                            <!-- Referência da factura -->
                            <!-- <b style="margin-top: 55px;">REF: {{$factura->faturaReference}}</b><br> -->
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <br>
                <table class="table table-striped" style="font-size: 9.5pt;">
                    <tr>
                        @if($factura->tipo_documento =="FACTURA")
                        <th>FT <?=date("Y")?>/{{$factura->factura_id}}</th>
                        @elseif($factura->tipo_documento=="FACTURA PROFORMA")
                        <th>FP <?=date("Y")?>/{{$factura->factura_id}}</th>
                        @elseif($factura->tipo_documento=="FACTURA RECIBO")
                        <th>FR <?=date("Y")?>/{{$factura->factura_id}}</th>
                        @endif
                        <th>Moeda: {{mb_strtoupper($factura->moeda)}}</th>
                        <th>Câmbio: {{number_format($factura->cambio,2,",",".")}}</td></th>
                        <th><b style="margin-top: 55px;">REF: {{$factura->faturaReference}}</b><br></th>
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
                                    <th>Nº</th>
                                    <th>Producto</th>
                                    <th>Preço Unit.</th>
                                    <th>Qtd</th>
                                    <!-- <th>Un.</th> -->
                                    <th>Desc.</th>
                                    <th style="width:10%">Taxa</th>
                                    <th>Retenção</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>
                            @forelse ($fatura_items as $key => $item)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{mb_strtoupper($item->descricao_produto)}}</td>
                                <td>{{number_format($item->preco_produto,2,",",".")}}</td>
                                <td>{{$item->quantidade_produto }}</td>
                                <!-- <td>{{--$item->unidade --}}</td> -->
                                <td>{{number_format(($item->desconto_produto/$item->total_preco_produto)*100,1,",",".")}}%</td>
                                <td>{{$item->descricao_taxa}}</td>
                                <td style="text-align: center;">{{number_format(($item->retencao_produto/$item->total_preco_produto)*100,1,",",".")}}%</td>
                                <td>{{number_format($item->total_preco_produto,2,",",".")}}</td>
                            </tr>
                            @empty
                                <span>Lista de Items vazia</span>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-md-4 pull-left" style="font-size: 9.5pt;">
                        <!-- <p class="lead">Taxas</p> -->
                        <div class="table-responsive">
                            <table class="table" id="tabela1">
                                <tr>
                                    <th >Desconto</th>
                                    <th >Retenção</th>
                                    <th>Incid./Qtd</th>
                                    <th style="text-align: center;">IVA</th>
                                    <th>Motivo de isenção:</th>
                                </tr>
                                @forelse ($fatura_items as $key => $item)
                                <tr>
                                    <td>{{number_format($item->desconto_produto,2,",",".")}}</td>
                                    <td>{{number_format($item->retencao_produto,2,",",".")}}</td>
                                    <td>{{number_format($item->incidencia_produto,2,",",".")}}</td>
                                    <td>{{number_format($item->iva_produto,2,",",".")}}</td>
                                    <td>IVA-Regime de não Sujeição</td>
                                </tr>
                                @empty
                                    <span>Lista de Items vazia</span>
                                @endforelse
                            </table>
                        </div>
                    </div>

                    <!-- <div class="col-md-3 pull-right">
                        <br>
                        <span style="font-weight: bold;">Operador: RAMOSSOFT </span> <br>
                        <b>____________________________</b>
                    </div> -->
                    <!-- /.col -->
                </div>

                <br><br><br>
                <footer style="border: 1px solid black!important; font-size: 9.5pt;">
                    <div class="row" style="margin-top: 5px;"> 
                        <div class="col-md-3 pull-left">
                            <table class="table-striped">
                                <tr>
                                    <th style="padding: 1px 10px;">Coordenadas Bancária</th>
                                </tr>
                                @forelse ($coordenadas_bancaria as $key => $coordenada)
                                <tr>
                                    <td style="padding: 1px 10px;"><strong>{{mb_strtoupper($coordenada->sigla)}}: </strong>{{mb_strtoupper($coordenada->num_conta)}}-{{mb_strtoupper($coordenada->iban)}}</td>
                                </tr>
                                @empty
                                    <span>Lista de Items vazia</span>
                                @endforelse
                            </table>
                        </div>
                    
                        <div class="col-md-3 pull-right">
                            <table class="table-striped" id="tabela2">
                                <tr>
                                    <th>Total da Fatura</th>
                                    <td>{{number_format($factura->total_preco_factura,2,",",".")}}</td>
                                </tr>
                                <tr>
                                    <th>Total IVA</th>
                                    <td>{{number_format($factura->total_iva,2,",",".")}}</td>
                                </tr>
                                <tr>
                                    <th>Desconto</th>
                                    <td>{{number_format($factura->desconto,2,",",".")}}</td>
                                </tr>
                                <tr>
                                    <th>Retenção na fonte(6.5%)</th>
                                    <td>{{number_format($factura->retencao,2,",",".")}}</td>
                                </tr>
                                @if(($factura->tipo_documento =="FACTURA") || ($factura->tipo_documento=="FACTURA PROFORMA"))
                                <tr>
                                    <th>Total a Pagar</th>
                                    <td style="font-weight: bold;">{{number_format($factura->valor_a_pagar,2,",",".")}}</td>
                                </tr>
                                @else
                                <tr>
                                    <th>Total pago</th>
                                    <td style="font-weight: bold;">{{number_format($factura->valor_a_pagar,2,",",".")}}</td>
                                </tr>
                                <tr>
                                    <th>Valor Entregue</th>
                                    <td>{{number_format($factura->valor_entregue,2,",",".")}}</td>
                                </tr>
                                <tr>
                                    <th>Troco</th>
                                    <td>{{number_format($factura->troco,2,",",".")}}</td>
                                </tr>
                                @endif
                            </table>
                        </div>

                        <!-- <div>
                            <ul>
                            <b style="">&nbsp; Observação</b>
                                <li style="list-style: none; text-indent: 6px;">{{$factura->observacao}}</b></li>
                            </ul>
                        </div> -->
                        
                        <div class="col-md-3 pull-left">
                            <br>
                            <ul>
                                <li >Os bens/serviços foram colocados à disposição do adquirente na data do documento</li>
                                <li style="font-weight: bolder;">{{ucfirst($factura->regime_empresa)}}</li>
                                <li style="font-weight: bolder;">{{mb_strtoupper(substr($factura->hashValor, 0, 4))}}-Processado por programa Certificado nº 32/AGT/2019 (Mutue-Negócio)</li>
                            </ul>
                        </div>
                        <!-- <div style="">
                            <div id="">
                                <img width="95px"  height="95px" src="img/qrcode_fatura.png" alt=""> substr('abcdef', 0, 4)
                            </div>
                        </div> -->
                    </div>
                    <nav style="text-align: center;">Total por extenso: <b>{{$factura->valor_extenso}}</b></nav>
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