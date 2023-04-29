@section('title','Detalhes cliente')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            DETALHES CLIENTES
        </h1>
    </div>
    <div class="modal-body">
        <div class="row" style="left: 0%; position: relative;">
            <div class="col-md-12">

                <div class="tabbable">
                    <ul class="nav nav-tabs padding-16">
                        <li class="active">
                            <a data-toggle="tab" href="#dados_user">
                                <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                                Dados do Cliente
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#dadoLicenca">
                                <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                                Contacto
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#dadosDocumento">
                                <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                                Documentos
                            </a>
                        </li>

                    </ul>

                    <div class="tab-content profile-edit-tab-content">
                        <div id="dados_user" class="tab-pane in active">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope="row">Nome do cliente</th>
                                        <td>{{Str::upper( $cliente->nome )}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Endereço</th>
                                        <td>{{$cliente->endereco}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">NIF</th>
                                        <td>{{$cliente->nif}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Tipo de Cliente</th>
                                        <td>{{$cliente->tipocliente->designacao}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Regime</th>
                                        <td>{{$cliente->tiporegime->Designacao}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Logotipo</th>
                                        <td>
                                            <img style="width:150px;" src="<?= '/upload/' . $cliente->logotipo ?>" class="img-fluid" alt="">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="dadoLicenca" class="tab-pane">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope="row">Telefone</th>
                                        <td>{{$cliente->pessoal_Contacto}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Email</th>
                                        <td>{{$cliente->email}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Website</th>
                                        <a href="<?= $cliente->Website ?>" target="_blank" rel="noopener noreferrer">{{$cliente->Website}}</a>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="dadosDocumento" class="tab-pane">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th scope="row">NIF</th>
                                        <td>
                                            <a style="color:#337ab7;" target="blank" href="<?= file_exists($cliente->file_nif) ? '/upload/' . $cliente->file_nif : '' ?>">{{file_exists($cliente->file_nif)?'Baixar NIF':'Sem documento nif'}}</a>
                                        </td>

                                    </tr>
                                    <tr>
                                        <th scope="row">Alvará</th>
                                        <td>
                                        <a style="color:#337ab7;" target="blank" href="<?= file_exists($cliente->file_alvara) ? '/upload/' . $cliente->file_alvara : '' ?>">{{ file_exists($cliente->file_alvara)?'Baixar NIF':'Sem documento alvará'}}</a>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>