<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>

    <div class="header-email">
        <div class="content">
            <h1>
                Olá {{$nome}}
            </h1>
            <h3>Seja bem-vindo ao Mutue-Negócio</h3>
                Gostariamos informá-lo que tens {{$dias_restante}} dias para uso gratuito do mutue-negocio <br>
            <p>
                Logo, deves activar sua licença até ao prazo desses {{$dias_restante}} dias úteis, pois, se passar desse prazo perderás algumas funcionalidades no sistema
            </p>
            <div>
                <b>
                    URL de acesso:
                </b>
                <a href="{{url('http://localhost:8000/empresa-login')}}" target="_blank">http://localhost:8000/empresa-login</a> <br>
            </div>

            <div>
                <b>
                    Email: 
                </b>
                <a href="mailto:{{$email}}" target="_blank">{{$email}}</a>
            </div>
            <div>
                <b>
                    Telefone: 
                </b>
                <span>{{$pessoal_Contacto}}</span>
            </div>
        </div>
    </div>
    
</body>

<style>
    body{
        font-family: "Gill Sans Extrabold", Helvetica, sans-serif;
    }
    .header-email{
        display: flex;
        flex-direction: column;
    }
    
   .content div{
       margin-bottom: 10px;
    }
   
    

</style>
</html>

