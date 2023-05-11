<?php
use Illuminate\Support\Str;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitação de licença</title>
</head>
<body>
    <p>Prezados..</p>
    <p>Gostaria informá-lo que a empresa <i>{{$nomeEmpresa}}</i> solicitou um pedido de ativação de licença, e aguarde a ativação da mesma</p>
    <p>Segue abaixo as informações necessárias para a ativação da licença:</p>
    <ul>
        <li>Empresa: {{ $nomeEmpresa}}</li>
        <li>Endereço: {{ $enderecoEmpresa}}</li>
        <li>E-mail: {{ $emailEmpresa}}</li>
        <li>Contato: {{ $contatoEmpresa}}</li>
        <li>Licença: {{mb_strtolower($nomeLicenca, 'UTF-8')}} de {{ number_format($valorLicença,2,',','.') }} AOA</li>
        <li>Banco: {{ $banco }}</li>
        <li>Nº operação bancária: {{$numOperacaoBancaria}}</li>
        <li>Conta movimentada: {{ $contaMovimentada }}</li>
    </ul>
</body>

</html>
