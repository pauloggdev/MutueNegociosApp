<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Aqui é o estilo da tabela com bootstrap.min.css 3.3.7 -->
        <link rel="stylesheet" href="assets/css/factura_tabelas.css" media="all"  />
        <!-- Aqui é estilo geral da folha AdminLTE -->
        <!-- <link rel="stylesheet" href="assets/css/factura.css" media="all" /> -->
        <title>Factura</title>
    </head>

    <body>
        <div class="row" style="font-size: 9pt;">
            <div style="float: left; width: 100px; margin-right:30px;">
                <span class="" style="font-size: 12pt;">
                @if(!empty($factura->logotipo))
                    <img  alt="200x200" src="storage/utilizadores/admin/<?=$factura->logotipo?>" style="max-width: 100%; border-radius: 30px; height: 72px; width: 75px; left: 14px; position: relative" />
                @else
                    {{mb_strtoupper($factura->nome)}}
                @endif
                </span>
            </div>
            <div style="float: right;  width: 200px; margin-left:30px; margin-top: 20px;"><strong>Emitido: {{$factura->dataFactura ? date('d-m-Y H:i:s', strtotime($factura->dataFactura)) : ''}}</strong></div>
        </div>

        <div class="row" style="font-size: 9pt;border: 0.3px solid #403e3eb0!important; padding:10px;"></div>
        
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
                    <!-- Website: {{$factura->Website}}<br> -->
                    Email: {{$factura->email}}
                </div>
                <br>
                <div id="noticias" class="noticia">
                    <b style="margin-top: 55px;">Luanda-Angola</b><br>
                    <b style="margin-top: 55px;">{{mb_strtoupper($factura->tipo_documento)}}</b>
                </div>
            </div>

            <div id="notices" class="notice" style="float: right;  width: 200px; margin-left:30px;">
                CLIENTE: <br>
                <strong>{{mb_strtoupper($factura->nome_do_cliente)}}</strong><br>
                Telefone: {{$factura->telefone_cliente}}<br>
                E-Mail: {{$factura->email_cliente}}<br>
                NIF: {{$factura->nif_cliente}}<br>
                Endereço: {{mb_strtoupper($factura->endereco_cliente)}}<br>
                <!-- Conta Corrente N.º: <br> -->
            </div>
            <div class="clear"></div>
        </div>

        <br><br>
        <div class="row">
            <div style="font-size: 9pt;">
                <table class="table table-striped" >
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
                        <th><b>REF: {{$factura->faturaReference}}</b><br></th>
                    </tr>
                    <tr>
                        <td></td><td></td>
                        <td></td><td></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div style="font-size: 8pt;">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width:5%">Nº</th>
                            <th>Descrição</th>
                            <th>Preço Unit.</th>
                            <th style="width:5%">Qtd</th>
                            <!-- <th>Un.</th> -->
                            <th style="width:5%">Desc.</th>
                            <th style="width:10%">Taxa</th>
                            <th style="width:5%">Retenção</th>
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
                        <td>{{number_format(($item->retencao_produto/$item->total_preco_produto)*100,1,",",".")}}%</td>
                        <td>{{number_format($item->total_preco_produto,2,",",".")}}</td>
                    </tr>
                    @empty
                        <span>Lista de Items vazia</span>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="pull-left" style="font-size: 8pt;">
                <table class="table table-striped">
                    <tr>
                        <th >Desconto</th>
                        <th >Retenção</th>
                        <th>Incid./Qtd</th>
                        <th>IVA</th>
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

        @for($i=0; $i<=4.5; $i++)
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
                    @if(($factura->tipo_documento =="FACTURA") || ($factura->tipo_documento=="FACTURA PROFORMA"))
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
                    <li style="font-weight: bolder;">{{mb_strtoupper(substr($factura->hashValor, 0, 4))}}-Processado por programa Certificado nº 32/AGT/2019 (Mutue-Negócio)</li>
                </ul>
            </div>
        </div>
        
        <div class="row" style="font-size: 9pt;border: 1px solid black!important; padding:10px;"></div>
        <div class="row" style="font-size: 8pt;">
            <div style="text-align: center;"><i>Software de gestão comercial online, desenvolvido e Assistido pela Ramossoft-Fábrica de Softwares, <b>www.ramossoft.com</b></i> </div>
        </div>
    </body>
</html>

<style>
    * {
		font-family: "Lato", sans-serif;
	}

	body {
		margin: 0;
    }
    .clear{
        clear: both;
    }
    #tabela2{
        text-align: left;
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