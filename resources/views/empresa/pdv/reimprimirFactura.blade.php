<?php

use Illuminate\Support\Str;

?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title></title>
    <!-- <link rel="stylesheet" href="{{ asset('assets/cupom.css') }}" type="text/css" /> -->
    <style>
        @media print {
            #noprint {
                display: none;
            }
        }
    </style>
</head>

<body style="margin-top: 0px; margin-left: 0px;">
    <div id="app" class="cupom" style="width: 250px;
	padding: 5px 35px 5px 15px;
	overflow: hidden;
	position:relative;
	border: 1px solid #999;
	text-transform:uppercase;
	margin: 5px 0px 0px 5px;
    font-size: x-large;
	font: bold 10px 'Courier New';">

        <img src="<?= 'upload/' . $factura->empresa->logotipo ?>" width="80px" />
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="titulo-cupom" style="line-height: 5px; font-size: xx-small;
	margin-bottom: 0px;">
                    <?php echo $factura->empresa->designacao; ?><br><br></td>
            </tr>
            <tr>
                <td class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	">
                    <?php echo $factura->empresa->endereco; ?></td>
            </tr>
            <tr>
        </table>
        <hr style="border-width: 1px;
	border-style: dashed;">

        <div class="titulo-cupom" style="text-align: left;line-height: 15px;text-align: center;margin-bottom: 0px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	">
                    <td style="">TELEFONE:</td>
                    <td align="right" style=""><?php echo $factura->empresa->pessoal_Contacto; ?> </td>
                </tr>
                <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	">
                    <td style="">CONTRIBUINTE:</td>
                    <td align="right" style=""><?php echo $factura->empresa->nif; ?></td>
                </tr>



            </table>

        </div>

        <hr style="border-width: 1px;border-style: dashed;">

        <div class="titulo-cupom" style="text-align: left;line-height: 15px;text-align: center;margin-bottom: 0px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	">
                    <td style="">FAC/RECIBO Nº:</td>
                    <td align="right" style=""><?php echo $factura->numeracaoFactura; ?></td>
                </tr>
                <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	">
                    <td style="">Data de emissão:</td>
                    <td align="right" style=""><?php echo date('d-m-Y', strtotime($factura->created_at)); ?></td>
                </tr>
                <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	">
                    <td style="">Hora de emissão:</td>
                    <td align="right" style=""><?php echo date('H:m:s', strtotime($factura->created_at)); ?></td>
                </tr>


            </table>

        </div>


        <hr style="border-width: 1px;
           border-style: dashed;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>

                <td class="descricao" style="
                              line-height: 10px;
                              margin-bottom: 0px;
                              padding-right: 12px;

                              ">
                    <span style="text-align: left;">Cliente:</span> <span style="float: center"><?php echo $factura->nome_do_cliente; ?></span>
                </td>
            </tr>
            <div></div>
            <tr>

                <td class="descricao" style="
                              line-height: 10px;
                              margin-bottom: 0px;
                              padding-right: 12px;

                              ">
                    <span style="text-align: left;">Contribuinte:</span> <span style="float: center"><?php echo $factura->nif_cliente; ?></span>
                </td>

            </tr>
            <tr>

                <td class="descricao" style="
                               line-height: 10px;
                               margin-bottom: 0px;
                               padding-right: 12px;

                               ">
                    <span style="text-align: left;">Contacto:</span> <span style="float: center"><?php echo $factura->telefone_cliente; ?></span>
                </td>

            </tr>
        </table>

        <hr style="border-width: 1px;
           border-style: dashed;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>

                <td class="descricao" style="
                              line-height: 10px;
                              margin-bottom: 0px;
                              padding-right: 12px;

                              ">
                    <span style="text-align: left;">Operador:</span> <span style="float: center"><?php echo $factura->user->name; ?></span>
                </td>
            </tr>
        </table>

        <tr>

            <hr style="border-width: 1px; border-style: dashed;">
            <div class="titulo-cupom" style="text-align: left;line-height: 15px;text-align: center;margin-bottom: 0px;">

                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr class="descricao-produto" style="font: bold 10px 'Courier New';">
                        <td style="text-align:left; ">DESCR</td>
                        <td style="text-align: right;">QTD.</td>
                        <td style="text-align: right;">PREÇO/UNIT.</td>
                        <td style="text-align: center;">DESC(%)</td>
                        <td style="text-align: center">TAXA(%)</td>
                        <td style="text-align: right">valor</td>
                    </tr>
                    <?php foreach ($factura->facturas_items as $row) { ?>


                        <tr>
                            <td style="font-size:10px; text-align: left" colspan="6"><?php echo $row->descricao_produto; ?></td>
                        </tr>

                        <tr class="descricao">
                            <td></td>

                            <td style="text-align: right"><?php echo number_format($row->quantidade_produto, 1, ',', '.'); ?></td>
                            <td style="text-align:right;"><?php echo number_format($row->preco_venda_produto, 2, ',', '.'); ?></td>
                            <td style="text-align:center;"><?php echo number_format(($row->desconto_produto / $row->total_preco_produto) * 100, 2, ',', '.'); ?></td>
                            <td style="text-align:center;"><?php echo number_format($row->taxa, 2, ',', '.'); ?></td>
                            <td style="text-align:right;"><?php echo number_format($row->preco_venda_produto, 2, ',', '.'); ?></td>
                        </tr>
                        @if ($row->taxa <= 0) <tr>
                            <td style="font-size:6px; text-align: left;text-transform: lowercase;" colspan="6">
                                <?php echo $row->produto->motivoIsencao->descricao; ?></td>
        </tr>
        @endif
    <?php }; ?>
    </table>

    <hr style="border-width: 1px;border-style: dashed;">
    <div class="titulo-cupom" style="text-align: left;line-height: 15px;text-align: center;margin-bottom: 0px;">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	">
                <td>TOTAL liquido:</td>
                <td style="text-align: right"><?php echo number_format($factura->total_preco_factura, 2, ',', '.'); ?></td>
            </tr>
            <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	">
                <td>TOTAL IMPOSTO</td>
                <td style="text-align: right"><?php echo number_format($factura->total_iva, 2, ',', '.'); ?></td>
            </tr>
            <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	">
                <td> TOTAL DESCONTO:</td>
                <td style="text-align: right"><?php echo number_format($factura->desconto, 2, ',', '.'); ?></td>
            </tr>

            <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	">
                <td>RETENÇÃO:</td>
                <td style="text-align: right"><?php echo number_format($factura->retencao, 2, ',', '.'); ?></td>
            </tr>
            <?php

            ?>
        </table>
        <hr style="border-width: 1px;
        border-style: dashed;">
        <div class="titulo-cupom" style="text-align: left;line-height: 15px;
        text-align: center;
        margin-bottom: 0px;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	">
                    <td style="">TOTAL A PAGAR:</td>
                    <td align="right" style=""><?php echo number_format($factura->valor_a_pagar, 2, ',', '.'); ?></td>
                </tr>
                <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	">
                    <td style="">VALOR PAGO</td>
                    <td align="right" style=""><?php echo number_format($factura->valor_entregue, 2, ',', '.'); ?></td>
                </tr>
                <tr class="descricao" style="text-align: left;
	line-height: 10px;
	margin-bottom: 0px;
	padding-right: 12px;
	">
                    <td style="">TROCO:</td>
                    <td align="right" style=""><?php echo number_format($factura->troco, 2, ',', '.'); ?></td>
                </tr>
            </table>

            <hr style="border-width: 1px;
        border-style: dashed;">
            <div class="titulo-cupom" style="text-align: left;line-height: 15px;
        text-align: center;
        margin-bottom: 0px;">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr class="descricao" style="text-align: left">
                        <span style="text-align: left;">MEIO DE PAGAEMENTO:</span> <span style=" text-align:right;"><?php echo $factura->formaPagamento ? $factura->formaPagamento->descricao : ''; ?></span>
                    </tr><br>
                    <tr class="descricao" style="text-align: left; text-transform: uppercase">
                        <span style="text-align: left;">SÃO:</span> <span style=" text-align:right;"><?php echo $factura->valor_extenso; ?></span>
                    </tr>
                </table>

                <hr style="border-width: 1px;
                            border-style: dashed;">
                <div class="titulo-cupom" style="text-align: left;line-height: 6px;
                            text-align:left;
                            margin-bottom: 0px;">

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <span style="text-align: left;">Resumo de imposto</span>
                        <tr class="descricao-produto" style="font: bold 10px 'Courier New';">
                            <td style="text-align:left; ">Taxa</td>
                            <td style=" text-align: right">incidência</td>
                            <td style="text-align:right;">VALOR IMPOSTO</td>
                        </tr>
                        <?php foreach ($factura->facturas_items as $row) { ?>
                            <tr class="descricao" style="text-align: left;line-height: 10px;margin-bottom: 0px;padding-right: 12px;">
                                <td style=""><?php echo $row->taxa > 0 ? "IVA(" . number_format($row->taxa, 2, ',', '.') . "%)" : "ISENTO(" . number_format($row->taxa, 2, ',', '.') . "%)" ?>&nbsp;</td>
                                <td style=" text-align: right"><?php echo number_format($row->incidencia_produto, 2, ',', '.'); ?></td>
                                <td style="text-align:right;"><?php echo number_format($row->iva_produto, 2, ',', '.'); ?></td>

                            </tr>
                        <?php }; ?>
                    </table>

                    <hr style="border-width: 1px;
                    border-style: dashed;">
                    <div class="titulo-cupom" style="text-align: left;line-height: 6px;
                    text-align:left;
                    margin-bottom: 0px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">

                            <tr class="descricao" style="
	font-size:6px;">
                                <td width="100%"><?php echo $factura->hash ? Str::substr($factura->hash, 0, 3) . ' -' : ''; ?> Processado por programa Validado nº 384/AGT/2022 (MUTUE_NEGÓCIOS)</td>
                            </tr>
                        </table>



                        <hr style="border-width: 1px;
        border-style: dashed;">
                        <div class="titulo-cupom" style="text-align: left;line-height: 6px;
        text-align:left;
        margin-bottom: 0px;">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                <tr class="descricao" style="
font-size:6px; margin-bottom: 0px; text-transform: lowercase;">
                                    <td width="100%">Os bens/serviços foram colocados à disposição do
                                        adquirente na data e local do documento </td>
                                </tr>
                            </table>
                            <hr style="border-width: 1px;
border-style: dashed;">
                            <div class="titulo-cupom" style="text-align: left;line-height: 6px;
text-align:left;
margin-bottom: 0px;">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                    <tr class="descricao" style="
font-size:4px; margin-bottom: 0px; text-transform: lowercase;">
                                        <td width="100%"></td>
                                    </tr>
                                </table>
                                <div class="titulo-cupom" style="line-height: 15px;
	text-align: center;
	margin-bottom: 0px;font-size:8px; text-transform: lowercase;">
                                    OBRIGADO E VOLTE SEMPRE</div>
                            </div>
</body>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>


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
