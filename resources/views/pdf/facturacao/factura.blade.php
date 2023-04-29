<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{$factura->tipo_documento}} | A4</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">

        <!-- Aqui é o estilo da tabela com bootstrap.min.css 3.3.7 -->
        {{-- <link rel="stylesheet" href="assets/css/factura_tabelas.css" media="all"  /> --}}
        <!-- Aqui é estilo geral da folha AdminLTE -->
        <!-- <link rel="stylesheet" href="assets/css/factura.css" media="all" /> -->
    </head>

    <!-- <body onload="window.print();"> -->
    <body>
        <div class="row" style="font-size: 9pt;">
            <div style="float: left; width: 100px; margin-right:30px;">
                <span class="" style="font-size: 12pt;">
                @if(!empty($factura->logotipo))
                    <img  alt="200x200" src="/upload/<?=$factura->logotipo?>" style="max-width: 100%; border-radius: 30px; height: 72px; width: 75px; left: 14px; position: relative" />
                @else
                    {{mb_strtoupper($factura->nome)}}
                @endif
                </span>
            </div>
            <div style="float: right;  width: 200px; margin-left:30px; margin-top: 20px;"><strong>Emitido: {{$factura->dataFactura ? date('d-m-Y H:i:s', strtotime($factura->dataFactura)) : ''}}</strong></div>
            <div style="clear: both;"></div>
        </div>

        <div class="row" style="font-size: 9pt;border-bottom: 0.3px solid #403e3eb0!important; padding:5px;"></div>

        <br>
        <div class="row" style="font-size: 9pt;">
            <div style="float: left; width: 200px; margin-right:30px;">
                <div id="notices" class="notice">
                    DE: <br>
                    <strong>{{mb_strtoupper($factura->nome)}}</strong><br>
                    Endereço: {{mb_strtoupper($factura->endereco)}}<br>
                    NIF: {{mb_strtoupper($factura->nif)}}<br>
                    Telefone: {{$factura->pessoal_Contacto}}|{{$factura->pessoal_Contacto}}<br>
                    Telemóvel: {{$factura->pessoal_Contacto}}<br>
                    Website: {{$factura->website}}<br>
                    Email: {{$factura->email}}
                </div>
                <br>
                <div id="noticias" class="noticia">
                    <b style="margin-top: 55px;">Luanda-Angola</b><br>
                    <b style="margin-top: 55px;">{{mb_strtoupper($factura->tipo_documento)}}</b> <br>
                    <b style="margin-top: 55px;">{{$viaImpressao == 1 ? "Original":"2ª via, em conformidade com a original"}}</b>
                </div>
            </div>

            <div style="float: right;  width: 200px; margin-left:30px;">
                <div id="notices" class="notice">
                    CLIENTE: <br>
                    <strong>{{mb_strtoupper($factura->nome_do_cliente)}}</strong><br>
                    Telefone: {{$factura->telefone_cliente}}<br>
                    E-Mail: {{$factura->email_cliente}}<br>
                    NIF: {{($factura->nif_cliente == '999999999' ? 'Consumidor final': $factura->nif_cliente)}}<br>
                    Endereço: {{mb_strtoupper($factura->endereco_cliente)}}<br>
                    Conta Corrente N.º: {{$factura->conta_corrente_cliente}}<br>
                </div>

                <br>
                <b style="margin-top: 55px;">REF: {{$factura->nextFactura}}</b><br>
                <div class="col-md-3 pull-right">
                    <br>
                    <span style="font-weight: bold;">Operador: {{$factura->operador}} </span> <br><br>
                    <b>____________________________</b>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <br><br>

       

        <div class="row">
            <div style="font-size: 8pt;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width:5%">Nº</th>
                            <th>Descrição</th>
                            <th style="text-align: right;">Preço Unit.</th>
                            <th style="width:5%;text-align: center;">Qtd</th>
                            <th style="width:5%;text-align: center;">Un.</th>
                            <th style="width:5%">Desc.</th>
                            <th style="width:10%;text-align: center;">Taxa</th>
                            <th style="width:5%">Retenção</th>
                            <th style="text-align: right;">Total</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse ($fatura_items as $key => $item)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{mb_strtoupper($item->descricao_produto)}}</td>
                        <td style="text-align: right;">{{number_format($item->preco_venda_produto,2,",",".")}}</td>
                        <td style="width:5%;text-align: center;">{{number_format($item->quantidade_produto,2,",",".")}}</td>
                        <td style="width:5%;text-align: center;">{{$item->unidade?$item->unidade:"Un" }}</td>
                        <td>{{number_format(($item->desconto_produto/$item->total_preco_produto)*100,1,",",".")}}%</td>
                        <td style="width:10%;text-align: center;">{{number_format($item->taxa,1,",",".")}}%</td>
                        <td style="text-align: center;">{{number_format(($item->retencao_produto/$item->total_preco_produto)*100,1,",",".")}}%</td>
                        <td style="text-align: right;">{{number_format($item->total_preco_produto,2,",",".")}}</td>
                    </tr>
                    @empty
                        <span>Lista de Items vazia</span>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="pull-left" style="font-size: 8pt; width:60%">
                <table class="table table-striped">
                  <thead>
                    <tr>
                        <th>Taxa/Valor</th>
                        <th style="text-align: right;">Incid./Qtd</th>
                        <th style="text-align: right;">Total</th>
                        <th>Motivo Isenção/código</th>
                    </tr>
                  </thead>
                  <tbody>
                   
                  </tbody>
                </table>
            </div>
      </div>

        @for($i=0; $i<=1.5; $i++)
        <br>
        @endfor
        <div class="row" style="font-size: 9pt;border: 1px solid black!important; padding:10px;"> 
            
            <div style="float: right;">
                <table class="table-striped" id="tabela2">
                    <tr>
                        <th>Total da Fatura</th>
                        <td style="text-align: right">{{number_format($factura->total_preco_factura,2,",",".")}}</td>
                    </tr>
                    <tr>
                        <th>Total IVA</th>
                        <td style="text-align: right">{{number_format($factura->total_iva,2,",",".")}}</td>
                    </tr>
                    <tr>
                        <th>Desconto</th>
                        <td style="text-align: right">{{number_format($factura->desconto,2,",",".")}}</td>
                    </tr>
                    <tr>
                        <th>Retenção na fonte(6.5%)</th>
                        <td style="text-align: right">{{number_format($factura->retencao,2,",",".")}}</td>
                    </tr>
                    @if(($factura->tipo_documento ==2) || ($factura->tipo_documento==3))
                    <tr>
                        <th>Total a Pagar</th>
                        <td style="font-weight: bold;text-align: right;">{{number_format($factura->valor_a_pagar,2,",",".")}}</td>
                    </tr>
                    @else
                    <tr>
                        <th>Total pago</th>
                        <td style="font-weight: bold;text-align: right;">{{number_format($factura->valor_a_pagar,2,",",".")}}</td>
                    </tr>
                    <tr>
                        <th>Valor Entregue</th>
                        <td style="text-align: right">{{number_format($factura->valor_entregue,2,",",".")}}</td>
                    </tr>
                    <tr>
                        <th>Troco</th>
                        <td style="text-align: right">{{number_format($factura->troco,2,",",".")}}</td>
                    </tr>
                    @endif
                </table>
            </div>

            <div style="float: left;margin-right:30px;">
                <table class="table-striped">
                    <tr>
                        <th>Coordenadas Bancária</th>
                    </tr>
                    @forelse ($coordenadas_bancaria as $key => $coordenada)
                    <tr>
                        <td><strong>{{mb_strtoupper($coordenada->sigla)}}: </strong>{{mb_strtoupper($coordenada->num_conta)}}-{{mb_strtoupper($coordenada->iban)}}</td>
                    </tr>
                    @empty
                        <span>Lista de Items vazia</span>
                    @endforelse
                </table>
            </div>  

            <div style="padding-left: 50px;">
                <ul>
                    <b style="">&nbsp; Observação</b>
                    <li style="list-style: none; text-indent: 6px;">{{$factura->observacao}}</b></li>
                </ul>
            </div>

            <div class="clear"></div>

            <br>
            <div class="row">
                <nav style="text-align: center; font-size: 11pt;">Total por extenso: <b>{{$factura->valor_extenso}}</b></nav>
            </div>
        </div>
        
        <br>
        
        <div class="row">
            <div class="pull-left">
                <ul>
                    <li >Os bens/serviços foram colocados à disposição do adquirente na data do documento</li>
                    <li style="font-weight: bolder;">{{ucfirst($factura->regime_empresa)}}</li>
                    <li style="font-weight: bolder;">{{mb_strtoupper(substr($factura->hashValor, 0, 4))}}-Processado por programa Certificado nº X/AGT/2019 (Mutue-Negócio)</li>
                </ul>
            </div>
        </div>
        
        <div class="row" style="font-size: 9pt;border-bottom: 1px solid black!important; padding:5px;"></div>
        <div class="row" style="font-size: 8pt;">
            <div style="text-align: center;"><i>Software de gestão comercial online, desenvolvido e Assistido pela Ramossoft-Fábrica de Softwares</i> </div>
        </div>
    
    </body>


    <style type="text/css">
        #tabela2 td{
            padding: 2px 18px;
            text-align: right;
        }
        
        .clear{
            clear: both;
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
</html>