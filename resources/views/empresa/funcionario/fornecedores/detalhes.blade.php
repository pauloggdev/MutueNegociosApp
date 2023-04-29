@extends('layout.appEmpresa')
@section('title','Fornecedor - Detalhes')
@section('content')

<section class="content">
    <div class="row">

        
        
        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Fornecedor   
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
                                            Dados do Fornecedor
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
                                                <td>{{$fornecedor->nome}}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">NIF</th>
                                                <td>{{$fornecedor->nif}}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Email fornecedor</th>
                                                <td>{{$fornecedor->email_empresa}}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">web site</th>
                                                <td>
                                                  <a href="" target="_blank">{{$fornecedor->website}}</a>
                                                </td>
                                              </tr>
                                              <tr>
                                                <th scope="row">País</th>
                                                <td>{{$fornecedor->pais->designacao}}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Data Contracto</th>
                                                <td>{{$fornecedor->data_contracto}}</td>
                                              </tr>
                                            </tbody>
                                          </table>
                      
                                    </div>

                                    <div id="foto_user" class="tab-pane">
                                        <table class="table table-bordered">
                                            <tbody>                                              
                                              <tr>
                                                <th scope="row">Telefone Fornecedor</th>
                                                <td>{{$fornecedor->telefone_empresa}}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Telefone</th>
                                                <td>{{$fornecedor->telefone_contacto}}</td>
                                              </tr>
                                              <tr>
                                                <th scope="row">Email</th>
                                                <td>{{$fornecedor->email_contacto}}</td>
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
    a:hover, a:focus{
            color: #23527c;
        }
</style>
@endsection
