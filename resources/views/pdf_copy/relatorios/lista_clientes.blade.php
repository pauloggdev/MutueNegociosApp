
<!DOCTYPE html>
<html lang="pt">
  <head>
    <meta charset="utf-8">
    <title>RELAÇÃO NOMINAL</title>
    
    <link rel="stylesheet" href="{{ asset('assets/css/estilo_relatorios.css')}}" media="all"/>
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
  </head>
 
  <body onload="window.print();">
    <header class="clearfix">
        <div id="logo">
            <img src="{{ asset('assets/images/ramososofware.png')}}">
        </div>
        <div id="noticias" class="noticia">
            <div id="company">
                <h2 class="name">Ramossoft Tecnologias Lda</h2>
                <div>Rua do G.Shoping,Por trás da casa dos Frescos<br>
                    <br>Bairro Luanda Sul, Luanda.</div>
                <div>+244 923292970/+244 222014194</div>
                <div><a href="www.ramossoft.com"> www.ramossoft.com</a></div>
            </div>
        </div>
    </header>
    <main>
    <h2 style="text-align:center">LISTA DE CLIENTES - ANO {{date('y-mm-d')}}</h2>
    <br><br>
      <div >
        <div id="client">
          <div class="to"><h3>País: </h3></div>
          <h2 class="name">{{"Angola"}}</h2>
          <div class="to"><h3>Tipo de Cliente: </h3></div>
          <h2 class="name">{{"Sociedade Anónima"}}</h2>
          <div class="to"><h3>Data de Contrato: </h3></div>
          <h2 class="name">{{date('y-mm-d')}}</h2>
          <div class="to">Total:</div>
          <h2 class="name">{{50}}</h2>
        </div>
     
        <!--  <div id="invoice">
          <h1>FICHA Nº: 3-2-1</h1>
          <div class="date">Data da Candidatura:</div>
          <div class="date">Data da ultima actualização:</div>
        </div>-->
      </div>

        <table border="0" cellspacing="0" cellpadding="0" style="font-size: 10pt;">
            <thead>
                <tr>
                    <th class="no" >Nº</th>
                    <th class="unit" style="font-weight: bolder; text-align: center; color: black">CÓDIGO</th>
                    <th class="unit assign" style="font-weight: bolder; text-align: left; color: black">NOME</th>
                    <th class="unit assign" style="font-weight: bolder; text-align: left; color: black">CONTA CORRENTE</th>
                    <th class="unit assign" style="font-weight: bolder; text-align: left; color: black">NIF</th>
                    <th class="unit assign" style="font-weight: bolder; text-align: center; color: black">TELEFONE</th>
                    <th class="unit assign" style="font-weight: bolder; text-align: center; color: black">EMAIL</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="no" style="text-align:center!important">{{1}}</td>
                    <td class="desc" style="text-align:center!important">{{39}}</td>
                    <td class="desc" style="text-align:center!important">{{"Paulo João"}}</td>
                    <td class="desc" style="text-align: left"><router-link to="/">{{"2.3.4.31.01"}}</router-link></td>
                    <td class="desc" style="text-align: left">{{"12345678"}}</td> 
                    <td class="desc" style="text-align: center">{"921504961"}}</td>
                    <td class="desc" style="text-align: center">{{"paulounesc.ao.co"}}</td>
                </tr>
            </tbody>
        </table>
       
        <br>
        <!--<div id="thanks">Obrigado!</div>-->
        <div id="notices">
          <div>NOTA:</div>
          <div class="notice">Caso falte um cliente na lista, o utilizador deverá solicitar o suporte técnico</div>
        </div>
        <div id="app" style="text-align: center;">
            <br>
               <h3>A Assinatura</h3>
               <h3>___________________________________________</h3>
        <!-- <img width="120px"  height="120px" src="img/qrcode.png" alt="">-->
        </div>
    </main>
    
    <footer>
        <div class="page-break">
             <p style="padding-top: 125% ;text-align: center;">Documento Processado Pelo Software Mutue - Negócios, Desenvolvido pela Ramossoft-Fábrica de Softwares.</p> 
        </div>
    </footer> 
  </body>
</html>