<?php

use Illuminate\Support\Str;

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>
    <!-- <link rel="stylesheet" href="{{ asset ('assets/cupom.css') }}" type="text/css" /> -->
    <style>
        @media print {
            #noprint {
                display: none;
            }
        }
    </style>
</head>

<body style="margin-top: 0px;
	margin-left: 0px;
">
    <div id="app" class="cupom" style="width: 250px;
	padding: 5px 35px 5px 15px;
	overflow: hidden;
	position:relative;
	border: 1px solid #999;
	text-transform:uppercase;
	margin: 5px 0px 0px 5px;
	font: bold 15px 'Courier New';">

<img src="<?= 'upload/' . $factura->empresa->logotipo ?>" width="100px" />


        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="titulo-cupom" style="line-height: 10px;font-weight:bold;
	margin-bottom: 0px;"><?php echo $factura->empresa->designacao; ?><br><br></td>
            </tr>
            <tr>
                <td class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;"><?php echo $factura->empresa->endereco; ?></td>
            </tr>
            <tr>
                <td class="descricao" style="text-align: left;font-weight:bold;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;"><?php echo $factura->empresa->website; ?></td>
            </tr>
            <tr>
                <td class="descricao" style="font-weight:bold;text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">TEL: <?php echo $factura->empresa->telefone_empresa; ?></td>
            </tr>
            <tr>
                <td class="descricao" style="font-weight:bold;text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">NIF: <?php echo $factura->empresa->nif; ?></td>

            </tr>
        </table>
        <hr style="border-width: 1px;
	border-style: dashed;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">

            <tr>
                <td class="titulo-cupom" style="font-weight:bold;line-height: 15px;font-size:14px; margin-bottom: 0px;"><?php echo $factura->nome_do_cliente; ?></td>
            </tr>

            <tr>
                <td class="descricao" style="font-size:15px; line-height:14px;text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;"><?php echo $factura->endereco_cliente; ?></td>
            </tr>
            <tr>
                <td class="descricao" style="font-size:15px; line-height:14px;text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">TEL: <?php echo $factura->telefone_cliente; ?></td>
            </tr>
            <!-- <tr>
        <td class="descricao" style="font-weight:bold;text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">Observações:</td>
      </tr> -->
            <tr>
                <td class="descricao" style="font-weight:bold;text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;" style="font-size:15px; line-height:14px;"><?php echo $factura->descricao; ?></td>
            </tr>
        </table>
        <hr style="border-width: 1px;
	border-style: dashed;">
        <div class="titulo-cupom" style="text-align: left;line-height: 15px;
	text-align: center;
	margin-bottom: 0px;"><?php echo $factura->numeracaoFactura ?></div>

        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <?php if ($factura->formas_pagamento_id) { ?>
                <tr width="100%" class="descricao-produto" style="font: bold 8px 'Courier New';
	line-height: 10px;">
                    <td colspan=4>FORMA PAGAMENTO: <?php echo $factura->formaPagamento->descricao; ?></td>

                </tr>
            <?php } ?>
            <tr class="descricao-produto" style="font: bold 8px 'Courier New';
	line-height: 10px;">
                <td style="font-weight:bold;" colspan=2>DESC.</td>
                <td style="font-weight:bold;">QTD.</td>
                <td style="text-align: right;font-weight:bold;">P.UNIT. </td>
                <td style="text-align: right;font-weight:bold;">SUBTOTAL</td>
            </tr>

            <?php foreach ($factura->facturas_items as $row) { ?>

                <tr class="descricao" style="text-align: left;
line-height: 10px;
margin-bottom: 0px;
padding-right: 12px;
font-size:10px;">
                    <td colspan=2 style="width: 200px;font-weight:bold;"> <?php echo trim(substr($row->descricao_produto, 0, 50)) ?></td>
                    <td style="font-weight:bold;"><?php echo number_format(($row->quantidade_produto), 1, ',', '.'); ?>&nbsp;</td>
                    <td style="text-align:right;font-weight:bold;"><?php echo number_format($row->preco_venda_produto, 2, ',', '.'); ?>&nbsp;</td>
                    <td style="text-align:right;font-weight:bold;"><?php echo number_format(($row->quantidade_produto * $row->preco_venda_produto), 2, ',', '.'); ?></td>
                </tr>
            <?php }; ?>
        </table>
        <br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="descricao" style="font-weight:bold;text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">Observação: <br> <?php echo $factura->descricao; ?></td>
            </tr>

        </table>
        <br>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">
                <td style="font-weight:bold;">TOTAL:</td>
                <td align="right" style="font-weight:bold;"><?php echo number_format(($factura->total_preco_factura), 2, ',', '.'); ?></td>
            </tr>
            <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">
                <td style="font-weight:bold;">IVA:</td>
                <td align="right" style="font-weight:bold;"><?php echo number_format(($factura->total_iva), 2, ',', '.'); ?></td>
            </tr>
            <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">
                <td style="font-weight:bold;">DESCONTO:</td>
                <td align="right" style="font-weight:bold;"><?php echo number_format(($factura->desconto), 2, ',', '.'); ?></td>
            </tr>
            <?php

            if ($factura->tipo_documento == 1) {

            ?>
                <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">
                    <td style="font-weight:bold;">TOTAL À PAGAR:</td>
                    <td align="right" style="font-weight: bold;"><?php echo number_format(($factura->valor_a_pagar), 2, ',', '.'); ?></td>
                </tr>
                <?php if ($factura->formas_pagamento_id == 6) { ?>

                    <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">
                        <td style="font-weight:bold;">VALOR CASH:</td>
                        <td style="font-weight:bold;" align="right" style="font-weight: bold;"><?php echo number_format(($factura->valor_cash), 2, ',', '.'); ?></td>
                    </tr>
                    <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">
                        <td style="font-weight:bold;">VALOR MULTICAIXA:</td>
                        <td style="font-weight:bold;" align="right" style="font-weight: bold;"><?php echo number_format(($factura->valor_multicaixa), 2, ',', '.'); ?></td>
                    </tr>


                <?php
                } else { ?>

                    <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">
                        <td style="font-weight:bold;">VALOR PAGO:</td>
                        <td style="font-weight:bold;" align="right" style="font-weight: bold;"><?php echo number_format(($factura->valor_entregue), 2, ',', '.'); ?></td>
                    </tr>
                <?php
                }
                ?>


                <tr class="descricao" style="text-align: left;
      line-height: 10px;
      margin-bottom: 0px;
      padding-right: 12px;
      font-size:10px;">
                    <td style="font-weight:bold;">TROCO:</td>
                    <td align="right" style="font-weight: bold;"><?php echo number_format(($factura->troco), 2, ',', '.'); ?></td>
                </tr>

            <?php

            } else {
            ?>
                <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">
                    <td style="font-weight:bold;">TOTAL À PAGAR:</td>
                    <td align="right" style="font-weight: bold;"><?php echo number_format(($factura->valor_a_pagar), 2, ',', '.'); ?></td>
                </tr>

            <?php
            }


            ?>

        </table>
        <br>


        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="descricao" style="font-weight:bold;text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">Operador: <?php echo $factura->user->name; ?></td>
            </tr>
            <tr class="descricao" style="
	font-size:8px;">
                <td width="100%"><?php echo $factura->valor_cash ? Str::substr($factura->valor_cash, 0, 3) . ' -' : ''; ?> Programa Certificado nº 384/AGT/2022</td>
            </tr>
            <tr class="descricao" style="
	font-size:8px;">
                <td width="100%"><?php echo $factura->empresa->tiporegime->designacao ?></td>
            </tr>
            <tr class="descricao" style="text-align: left;
	margin-bottom: 0px;
	padding-right: 12px;
	font-size:10px;">
                <td width="50%" align="left" style="font-weight:bold;font-size:8px;">Data: <?php echo date_format($factura->created_at, 'd/m/Y') . ' ' . date_format($factura->created_at, ' H:i:s'); ?></td>
            </tr>
        </table>
        <div class="titulo-cupom" style="line-height: 15px;
	text-align: center;
	margin-bottom: 0px;font-size:8px; text-transform: lowercase;">Software de gestão comercial</div>
    </div>
</body>
<script src="{{ asset ('plugins/jquery/jquery.min.js') }}"></script>


<script>
        $(document).ready(function() {
            var cont = 0;
            printInvoice(cont);
        });

        function printInvoice(cont) {
            window.print();
            setTimeout(() => {
                if (cont <= 0) {
                    cont++;
                    printInvoice(cont)
                } else {
                    window.location.href = "/empresa/facturas"
                }
            }, 500);
        }
    </script>


</html>