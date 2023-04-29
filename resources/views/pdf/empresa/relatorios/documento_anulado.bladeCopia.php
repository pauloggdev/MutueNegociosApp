<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Documento anulado</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Aqui é o estilo da tabela com bootstrap.min.css 3.3.7 -->
    {{--
    <link rel="stylesheet" href="assets/css/factura_tabelas.css" media="all" /> --}}
    <!-- Aqui é estilo geral da folha AdminLTE -->
    {{--
    <link rel="stylesheet" href="assets/css/factura.css" media="all" /> --}}
</head>

<!-- <body onload="window.print();"> -->

<body>
    <div class="row" style="font-size: 9pt;">
        <div style="float: left; width: 100px; margin-right:30px;">
            <span class="" style="font-size: 12pt;">
                @if (!empty($documentoAnulado->empresa->logotipo))
                    <img alt="200x200" src="/storage/<?= $documentoAnulado->empresa->logotipo ?>" style="max-width: 100%; border-radius: 30px; height: 72px; width: 75px; left: 14px; position: relative" />
@else
                    {{ mb_strtoupper($documentoAnulado->empresa->nome) }}
                @endif
                </span>
            </div>
            <div style="float: right;  width: 200px; margin-left:30px; margin-top: 20px;"><strong>Emitido: {{ $documentoAnulado->created_at ? date('d-m-Y H:i:s', strtotime($documentoAnulado->created_at)) : '' }}</strong></div>
            <div style="clear: both;"></div>
        </div>

        <div class="row" style="font-size: 9pt;border-bottom: 0.3px solid #403e3eb0!important; padding:5px;"></div>

        <br>
        <div class="row" style="font-size: 9pt;">
            <div style="float: left; width: 200px; margin-right:30px;">
                <div id="notices" class="notice">
                    DE: <br>
                    <strong>{{ mb_strtoupper($documentoAnulado->empresa->nome) }}</strong><br>
                    Endereço: {{ mb_strtoupper($documentoAnulado->empresa->endereco) }}<br>
                    NIF: {{ mb_strtoupper($documentoAnulado->empresa->nif) }}<br>
                    Telefone: {{ $documentoAnulado->empresa->pessoal_Contacto }}|{{ $documentoAnulado->empresa->pessoal_Contacto }}<br>
                    Telemóvel: {{ $documentoAnulado->empresa->pessoal_Contacto }}<br>
                    Website: {{ $documentoAnulado->empresa->website }}<br>
                    Email: {{ $documentoAnulado->empresa->email }}
                </div>
                <br>
                <div id="noticias" class="noticia">
                    <b style="margin-top: 55px;">Luanda-Angola</b><br>
                    <b style="margin-top: 55px;">Anulação de documento</b> <br>
                    <b style="margin-top: 55px;">{{$viaImpressao == 1 ? "Original":"2ª via, em conformidade com a original"}}</b>
                </div>
            </div>

            <div style="float: right;  width: 200px; margin-left:30px;">
                <div id="notices" class="notice">
                    CLIENTE: <br>
                    <strong>{{ mb_strtoupper($documentoAnulado->cliente->nome) }}</strong><br>
                    Telefone: {{ $documentoAnulado->cliente->telefone_cliente }}<br>
                    E-Mail: {{ $documentoAnulado->cliente->email }}<br>
                    NIF: {{ $documentoAnulado->cliente->nif }}<br>
                    Endereço: {{ mb_strtoupper($documentoAnulado->cliente->endereco) }}<br>
                    Conta Corrente N.º: {{ $documentoAnulado->cliente->conta_corrente }}<br>
                </div>

                <br>
            </div>
            <div class="clear"></div>
        </div>

        <br><br>

        <div class="row">
            <div style="font-size: 8pt;">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      @if ($documentoAnulado->recibo_id)
                        <th colspan="8" >NOTA DE CRÉDITO - ANULAÇÃO REFERENTE À {{ $documentoAnulado->recibo->numeracao_recibo }}</th>
                      @else
                        <th colspan="8" >NOTA DE CRÉDITO - ANULAÇÃO REFERENTE À {{ $documentoAnulado->factura->numeracaoFactura }}</th>
                      @endif
                      <th style="text-align: right">{{ $documentoAnulado->numeracaoNotaCredito }}</th>
                    </tr>
      
                    
                    <tr>
                      <th style="width:5%">Nº</th>
                      <th>Descrição</th>
                      <th style="text-align: right;">Preço Unit.</th>
                      <th style="text-align: center;">Qtd</th>
                      <th style="text-align: center;">Un.</th>
                      <th style="width:5%">Desc.</th>
                      <th  style="width:10%;text-align: center;">Taxa</th>
                      <th style="width:5%">Retenção</th>
                      <th style="text-align: right;">Total</th>
                  </tr>
                    {{-- <tr>
                      <th scope="col">Data da Operação</th>
                      <th scope="col">Descrição</th>
                      <th scope="col">Valor</th>
                    </tr> --}}
                  </thead>
                  <tbody>
      
                     
                      @foreach ($documentoAnulado->factura->facturas_items as $key=>$item)
                      <tr>
                          <td>{{++$key}}</td>
                          <td>{{mb_strtoupper($item->descricao_produto)}}</td>
                          <td style="text-align: right;">{{number_format($item->preco_venda_produto,2,",",".")}}</td>
                          <td style="text-align: center;">{{number_format($item->quantidade_produto,2,",",".")}}</td>
                          <td style="text-align: center;">{{$item->unidade ? $item->unidade:"Un" }}</td>
                          <td>{{number_format(($item->desconto_produto/$item->total_preco_produto)*100,1,",",".")}}%</td>
                          <td style="text-align: center;">{{number_format($item->produto->tipoTaxa->taxa,1,",",".")}}%</td>
                          <td style="text-align: center;">{{number_format(($item->retencao_produto/$item->total_preco_produto)*100,1,",",".")}}%</td>
                          <td style="text-align: right;">{{number_format($item->total_preco_produto,2,",",".")}}</td>
                      </tr>
                          
                      @endforeach
                      
      
                                  
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
                        <th>Incid./Qtd</th>
                        <th>Total</th>
                        <th>Motivo Isenção/código</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($docAnuladoItem as $item)
                      <tr>
                          <td>{{$item->taxa}}</td>
                          <td>{{number_format($item->total_incidencia,2,",",".")}}</td>
                      </tr>
                    @endforeach
                
                  </tbody>
                </table>
            </div>
      </div>

      <div class="row" style="font-size: 9pt;border: 1px solid black!important; padding:10px;"> 
            
        <div style="float: right;">
            <table class="table-striped" id="tabela2">
                <tr>
                    <th>Sub Total</th>
                    <td style="text-align: right">{{number_format($documentoAnulado->factura->total_incidencia,2,",",".")}}</td>
                </tr>
                <tr>
                    <th>Desconto</th>
                    <td style="text-align: right">{{number_format($documentoAnulado->factura->desconto,2,",",".")}}</td>
                </tr>
                <tr>
                    <th>IVA</th>
                    <td style="text-align: right">{{number_format($documentoAnulado->factura->total_iva,2,",",".")}}</td>
                </tr>
                <tr>
                    <th>Retenção na fonte(6.5%)</th>
                    <td style="text-align: right">{{number_format($documentoAnulado->factura->retencao,2,",",".")}}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td style="font-weight: bold;text-align: right;">{{number_format($documentoAnulado->factura->valor_a_pagar,2,",",".")}}</td>
                </tr>
            </table>
        </div>
        <div style="float: left;margin-right:30px;">
            <table class="table-striped">
                <tr>
                    <td><strong>Operador: </strong>{{($documentoAnulado->factura->tipoUser->designacao == "Empresa" ? "Administrador": $documentoAnulado->factura->tipoUser->designacao )}}</td>
                </tr>
            </table>
        </div>  
        
    

        

        <div class="clear"></div>

        <br>
        <div class="row">
            <nav style="text-align: center; font-size: 11pt;">Total por extenso: <b>{{$documentoAnulado->factura->valor_extenso}}</b></nav>
        </div>
    </div>

    <div class="row">
        <div class="pull-left">
            <ul>
                <li style="font-weight: bolder;">{{mb_strtoupper(substr($documentoAnulado->hash, 0, 4))}}-Processado por programa Certificado nº X/AGT/2020 (Mutue-Negócio)</li>
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
