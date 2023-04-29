@extends('layout.appEmpresa')
@section('title','Fornecedor - Detalhes')
@section('content')

<section class="content">
    <div class="row">



        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                CLIENTES
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Detalhes
                </small>
            </h1>
        </div><!-- /.page-header -->


        <div class="modal-body">
            <div class="row" style="left: 0%; position: relative;">
                <div class="col-md-12">

                        <div class="second-row">

                            <div class="tabbable">
                                <ul class="nav nav-tabs padding-16">
                                    <li class="active">
                                        <a data-toggle="tab" href="#dados_user">
                                            <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                                            Dados do Cliente
                                        </a>
                                    </li>

                                    <li>
                                        <a data-toggle="tab" href="#foto_user">
                                            <i class="red ace-icon fa fa-phone bigger-125"></i>
                                           Contatos
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content profile-edit-tab-content">
                                    <div id="dados_user" class="tab-pane in active">
                                        <table class="table table-bordered">
                                            <tbody>
                                              <tr>
                                                <th scope="row">Nome</th>
                                                <td>{{$cliente->nome}}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Email</th>
                                                <td>{{$cliente->email}}</td>
                                              </tr>
                                              <tr>
                                                  <th scope="row">NIF</th>
                                                  <td>{{$cliente->nif}}</td>
                                              </tr>
                                              <tr>
                                                  <th scope="row">Tipo cliente</th>
                                                  <td>{{$cliente->tipocliente->designacao}}</td>
                                              </tr>
                                              <tr>
                                                  <th scope="row">Status</th>
                                                  <td>{{$cliente->statuGeral->designacao}}</td>
                                              </tr>
                                              <tr>
                                                  <th scope="row">País</th>
                                                  <td>{{$cliente->pais->designacao}}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">web site</th>
                                                <td>{{$cliente->website}}</td>
                                              </tr>
                                              <tr>
                                                  <th scope="row">Saldo</th>
                                                  <td>{{$cliente->saldo}}</td>
                                              </tr>

                                            </tbody>
                                          </table>

                                    </div>

                                    <div id="foto_user" class="tab-pane">
                                        <table class="table table-bordered">
                                            <tbody>
                                              <tr>
                                                <th scope="row">Contato</th>
                                                <td>{{$cliente->pessoa_contacto}}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Endereço</th>
                                                <td>{{$cliente->endereco}}</td>
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


    </div><!-- /.row -->
</section>


<style type="text/css">
     #botoes{
        left: 0%;
        border-radius: 15px;
        margin-top: 0.1%;
        padding: 6px 12px 6px 12px;
        position: relative;
        text-transform: uppercase
    }
    table th{
        width: 20%;
    }
</style>
@endsection
