<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Nota de crédito</title>
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
                @if (!empty($notaCredito->empresa->logotipo))
                    <img alt="200x200" src="/upload/<?= $notaCredito->empresa->logotipo ?>" style="max-width: 100%; border-radius: 30px; height: 72px; width: 75px; left: 14px; position: relative" />
            @else
                    {{ mb_strtoupper($notaCredito->empresa->nome) }}
                @endif
                </span>
            </div>
            <div style="float: right;  width: 200px; margin-left:30px; margin-top: 20px;"><strong>Emitido: {{ $notaCredito->created_at ? date('d-m-Y H:i:s', strtotime($notaCredito->created_at)) : '' }}</strong></div>
            <div style="clear: both;"></div>
        </div>

        <div class="row" style="font-size: 9pt;border-bottom: 0.3px solid #403e3eb0!important; padding:5px;"></div>

        <br>
        <div class="row" style="font-size: 9pt;">
            <div style="float: left; width: 200px; margin-right:30px;">
                <div id="notices" class="notice">
                    DE: <br>
                    <strong>{{ mb_strtoupper($notaCredito->empresa->nome) }}</strong><br>
                    Endereço: {{ mb_strtoupper($notaCredito->empresa->endereco) }}<br>
                    NIF: {{ mb_strtoupper($notaCredito->empresa->nif) }}<br>
                    Telefone: {{ $notaCredito->empresa->pessoal_Contacto }}|{{ $notaCredito->empresa->pessoal_Contacto }}<br>
                    Telemóvel: {{ $notaCredito->empresa->pessoal_Contacto }}<br>
                    Website: {{ $notaCredito->empresa->website }}<br>
                    Email: {{ $notaCredito->empresa->email }}
                </div>
                <br>
                <div id="noticias" class="noticia">
                    <b style="margin-top: 55px;">Luanda-Angola</b><br>
                    <b style="margin-top: 55px;">Nota de Crédito</b> <br>
                    <b style="margin-top: 55px;">{{ $viaImpressao? "Original":"2ª via, em conformidade com a original"}}</b> <br>

                </div>
            </div>

            <div style="float: right;  width: 200px; margin-left:30px;">
                <div id="notices" class="notice">
                    CLIENTE: <br>
                    <strong>{{ mb_strtoupper($notaCredito->cliente->nome) }}</strong><br>
                    Telefone: {{ $notaCredito->cliente->telefone_cliente }}<br>
                    E-Mail: {{ $notaCredito->cliente->email }}<br>
                    NIF: {{ $notaCredito->cliente->nif }}<br>
                    Endereço: {{ mb_strtoupper($notaCredito->cliente->endereco) }}<br>
                    Conta Corrente N.º: {{ $notaCredito->cliente->conta_corrente }}<br>
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
                        <th colspan="3" style="text-align: right">{{ $notaCredito->numeracaoNotaCredito }}</th>
                    </tr>
                    <tr>
                        <th scope="col">Data da Operação</th>
                        <th style="text-align: left;">Descrição</th>
                        <th style="text-align: right;">Valor</th>
                    </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>{{ date('d/m/Y H:i', strtotime($notaCredito->created_at)) }}</td>
                        <td style="text-align: left;">{{ $notaCredito->descricao }}</td>
                        <td style="text-align: right;">{{ number_format($notaCredito->valor_credito, 2, ',', '.') }}</td>
                    </tr>                            
                  </tbody>
                </table>
            </div>
      </div>

      @for($i=0; $i<=20; $i++)
        <br>
      @endfor

      <div class="row" style="font-size: 9pt;border: 1px solid black!important; padding:10px;"> 
            
        <div style="float: right;">
            <table class="table-striped" id="tabela2">
                <tr>
                    <th>Total</th>
                    <td style="text-align: right">{{number_format($notaCredito->valor_credito,2,",",".")}}</td>
                </tr>
            </table>
        </div>
        <div style="float: left;margin-right:30px;">
            <table class="table-striped">
                <tr>
                    <td><strong>Operador: </strong>{{($notaCredito->tipoUser->designacao == "Empresa" ? "Administrador": $notaCredito->tipoUser->designacao )}}</td>
                </tr>
            </table>
        </div>  
        <div class="clear"></div>

        <br>
        <div class="row">
            <nav style="text-align: center; font-size: 11pt;"> <i>Total por extenso: {{$notaCredito->valor_extenso}}</i></nav>
        </div>
    </div>

  


    <div class="row">
        <div class="pull-left">
            <ul>
                <li style="font-weight: bolder;">{{mb_strtoupper(substr($notaCredito->hash, 0, 4))}}-Processado por programa Certificado nº X/AGT/2020 (Mutue-Negócio)</li>
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
