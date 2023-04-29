<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
</head>

<body >

    <header>

        <div class="row">

            <div class="col-md-12">
                <ul>
                    <li><strong>ELOVERDE</strong></li> <br>
                    <li>Telefone: 923656044</li>
                    <li>NIF: 0148000999LA035</li>
                    <li>Email: paulojoao@unesc.net</li>
                    <li>Website: www.negocio.com.ao</li>
                </ul>
            </div>

        </div>

    </header>

    <section>
        <div class="cliente">
            <div class="factura">FACTURA RECIBO REF:103243984</div>
            <ul>
                <li>Emitido: 01-08-2020</li>
                <li>Cliente: PAULO JOÃO</li>
                <li>NIF: 0148000999LA035</li>
                <li>Telefone: 923656044</li>
            </ul>

        </div>

    </section>

    <table class="table">
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Qtd.</th>
                <th>Preço</th>
                <th style="width:10%">Taxa</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Computador hp</td>
                <td>2</td>
                <td>50.000,00</td>
                <td>0%</td>
                <td>100000,00</td>
            </tr>
            <tr>
                <td>Serviços Limpeza</td>
                <td>2</td>
                <td>50.000,00</td>
                <td>0%</td>
                <td>100000,00</td>
            </tr>


        </tbody>
    </table>

    <div class="col-md-3 pull-right">
        <table class="table-striped" id="tabela2" style="width: 100%;">
            <tr class="subtotal">
                <th>Total da Fatura</th>
                <td>200000</td>
            </tr>
            <tr class="subtotal">
                <th>Total IVA</th>
                <td>10000</td>
            </tr>
            <tr class="subtotal">
                <th>Desconto</th>
                <td>25000</td>
            </tr>
            <tr class="subtotal">
                <th>Retenção na fonte(6.5%)</th>
                <td>5000</td>
            </tr>
            <tr class="subtotal">
                 <th>Total Pagar</th>
                <td style="font-weight: bold;">50000</td>
            </tr>

        </table>
    </div>

    <footer>
        <div>
            <nav style="text-align: center;">QUATRO CENTOS MIL</nav>

        </div>
        <div class="col-md-3 pull-left">
            <br>
            <ul>
                <li>Os bens/serviços foram colocados à disposição do adquirente na data do documento</li>
                <li style="font-weight: bolder;">Regime de Não Sujeição (Lei n.º 7/19 de 24 de Abril)</li>
                <li style="font-weight: bolder;">KLC-Processado por programa Certificado nº 32/AGT/2019 (Mutue-Negócio)
                </li>
            </ul>
        </div><br><br><br>

        <div style="text-align: center;"> Software de gestão comercial online, desenvolvido e Assistido pela Ramossoft,
            <b>www.ramossoft.com</b>
        </div>

    </footer>
</body>

</html>

<style>
    * {
        font-family: "Lato", sans-serif;
    }

    body {
        margin: 0;
        font-size: 11px;
    }

    ul li {
        list-style: none;
    }

    ul {
        margin: 0;
        padding: 0;
    }

    .cliente {
        border: 1px solid #333;
        margin-bottom: 10px;
        margin-top: 10px;
        padding: 10px;
    }

    .factura {
        text-align: center;
        font-weight: 700;
        margin-bottom: 5px;

    }

    thead {
        text-align: left;
    }

    tbody {
        text-align: left;
    }

    .table>tbody>tr>td,
    .table>tbody>tr>th,
    .table>tfoot>tr>td,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>thead>tr>th {
        padding: 4px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }

  
    .subtotal{
        display: flex;
        justify-content: space-between;
    }
</style>