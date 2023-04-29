<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>lista_de_bancos</title>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <header>
        <div class="areaimg">
            ...
        </div>
        <div class="infoempresa">
            ...
        </div>
    </header>

    <div><?= $data ?>
    </div>
    <table class="table" border="0" cellspacing="0" cellpadding="0" style="font-size: 10pt;">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
            </tr>
            <tr>
                <th scope="row">3</th>
                <td>Larry the Bird</td>
                <td>@twitter</td>
                <td>@twitter</td>
            </tr>
        </tbody>
    </table>

    <div id="assinatura" >

        <h2 style='margin:auto'>Assinatura</h2>
        <div class="linha">

        </div>

    </div>
</body>

</html>

<style lang="css">
    *{
        font-family: Arial, Helvetica, sans-serif;
    }
    header {
        display: flex;
    }

    .assinatura {
        display: flex;
        justify-content: center;
        align-items: center;

    }

    h2 {
        font-size: 14px;
        margin: auto;
    }
</style>