<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=p, initial-scale=1.0">
    <title>Renovação de Licença</title>
</head>

<body>
    <p>
        ​Saudações {{$nomeEmpresa}}
    </p>
    <p>
        Gostariamos informá-lo que seu pedido de renovação de licença foi <strong>aceite</strong> na aplicação Mutue Negócios.
    </p>
    <p>
        Clica no link abaixo para acessar o sistema 👇
    </p>
    <p>
        <b>Link: </b>
        <a href="{{url($linkLogin)}}" target="_blank">{{$linkLogin}}</a> <br>
    </p>
    <p>
        <b>
            Data de acesso:
        </b>
        {{$data_final ? $data_inicio .' até '. $data_final:' Definitivo'}}
    </p>
    <p>
        <b>
            Licença:
        </b>
        {{$tipoLicenca}}
    </p>
    <p>
        Para toda e qualquer questão, sirva-se deste meio, ou do terminal telefónico abaixo disponibilizado.
    </p>
    <p>
        +244 923292970
    </p>
    <p>
        Atenciosamente
    </p>
</body>

</html>
