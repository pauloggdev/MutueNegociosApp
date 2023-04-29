
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de venda mensal</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body onload="window.print();" style="font-size: 10px;">

    <header class="clearfix">

        @if ($facturas[0]['empresa']['logotipo'])
            <div id="logo">
                <img src="{{ asset('storage/'.$facturas[0]['empresa']['logotipo'])}}" width="70">
            </div>
        @endif
        
        <div id="noticias" class="noticia">
            <div id="company">
                <h2 class="name">{{$facturas[0]['empresa']['nome']}}</h2>
                <div>{{$facturas[0]['empresa']['endereco']}}</div>
                <div>Contactos: {{$facturas[0]['empresa']['pessoal_Contacto']}}</div>
                @if ($facturas[0]['empresa']['website'])
                <div>WebSite: <a>{{$facturas[0]['empresa']['website']}}</a></div>
                @endif
            </div>
        </div>
    </header>
    <main>
        <h2 style="text-align:center">Lista de Vendas diaria</h2>
        <span style="text-align: left;">Venda efectuada no mês/ano: {{date_format($facturas[0]['created_at'], 'm-Y')}}</span>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Produto</th>
                    <th scope="col" style="text-align: right;">Preço</th>
                    <th scope="col" style="text-align: center;">Quant</th>
                    <th scope="col" style="text-align: center;">Desc</th>
                    <th scope="col" style="text-align: right;">Retenção</th>
                    <th scope="col" style="text-align: right;">V.Entregue </th>
                    <th scope="col" style="text-align: right;">IVA</th>
                    <th scope="col" style="text-align: right;">Troco</th>
                    <th scope="col" style="text-align: right;">Total Sem IVA</th>
                    <th scope="col" style="text-align: right;">Total Com IVA</th>
                    <th scope="col" style="text-align: right;">Pagamento</th>
                    <th scope="col" style="text-align: right;">Operador</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $totalQtdFactura = 0;
                $totalDesconto = 0;
                $totalRetencao = 0;
                $totalValorEntregue = 0;
                $totalIva = 0;
                $totalTroco = 0;
                $totalSemIVA = 0;
                $totalComIVA = 0;
                ?>

                @foreach ($facturas as $factura)

                <tr>
                    <td colspan="3">{{$factura->numeracaoFactura}}/4</td>
                    <td colspan="1">Emitido:</td>
                    <td colspan="3">{{date_format($factura->created_at,'d-m-Y H:i:s')}}</td>
                </tr>

                @foreach ($factura->facturas_items as $factItem)
                    <tr>
                        <th>{{$factItem['descricao_produto']}}</th>
                        <td align="right">{{number_format($factItem['preco_venda_produto'],2,",",".")}}</td>
                        <td align="center">{{$factItem['quantidade_produto']}}</td>
                        <td align="center">{{number_format($factItem['desconto_produto'],2,",",".")}}</td>
                        <td align="center">{{number_format($factItem['retencao_produto'],2,",",".")}}</td>
                        <td align="right"></td>
                        <td align="right">{{number_format($factItem['iva_produto'],2,",",".")}}</td>
                        <td align="right"></td>
                        <td align="right">{{number_format(($factItem['total_preco_produto'] - $factItem['retencao_produto']),2,",",".")}}</td>
                        <td align="right">{{number_format(($factItem['total_preco_produto'] + $factItem['iva_produto'] - $factItem['retencao_produto']),2,",",".")}}</td>
                        <td align="right"></td>
                        <td align="right"></td>
                    </tr>
                @endforeach
                
                <tr>
                    <td colspan="2">TOTAL FACTURA</td>
                    <td align="center">{{$factura['numeroItems']}}</td>
                    <td align="center">{{number_format($factura['desconto'],2,",",".")}}</td>
                    <td align="center">{{number_format($factura['retencao'],2,",",".")}}</td>
                    <td style="text-align: right;">{{number_format($factura['valor_entregue'],2,",",".")}}</td>
                    <td align="right">{{number_format($factura['total_iva'],2,",",".")}}</td>
                    <td align="right">{{number_format($factura['troco'],2,",",".")}}</td>
                    <td align="right">{{number_format($factura['total_preco_factura'] - $factura['retencao'],2,",",".")}}</td>
                    <td align="right">{{number_format($factura['valor_a_pagar'],2,",",".")}}</td>
                    <td align="right">{{$factura['formaPagamento']?$factura['formaPagamento']['designacao']:"Venda a crédito"}}</td>
                    <td align="right">{{$factura['operador']?$factura['operador']:""}}</td>
                </tr>

                <?php
                $totalQtdFactura += $factura['numeroItems'];
                $totalDesconto += $factura['desconto'];
                $totalRetencao += $factura['retencao'];
                $totalValorEntregue += $factura['valor_entregue'];
                $totalIva += $factura['total_iva'];
                $totalTroco += $factura['troco'];
                $totalSemIVA += $factura['total_preco_factura'] - $factura['retencao'];
                $totalComIVA += $factura['valor_a_pagar'];
                ?>
                @endforeach
                <tr>
                    <td colspan="2"></td>
                    <td align="center">{{$totalQtdFactura}}</td>
                    <td align="center">{{number_format($totalDesconto,2,",",".")}}</td>
                    <td align="center">{{number_format($totalRetencao,2,",",".")}}</td>
                    <td style="text-align: right;">{{number_format($totalValorEntregue,2,",",".")}}</td>
                    <td align="right">{{number_format($totalIva,2,",",".")}}</td>
                    <td align="right">{{number_format($totalTroco,2,",",".")}}</td>
                    <td align="right">{{number_format($totalSemIVA,2,",",".")}}</td>
                    <td align="right">{{number_format($totalComIVA,2,",",".")}}</td>
                    <td colspan="3"></td>
                </tr>
            </tbody>
        </table>
</body>

</html>

<style>
    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>thead>tr>th {
        padding: 0 !important;
    }
</style>