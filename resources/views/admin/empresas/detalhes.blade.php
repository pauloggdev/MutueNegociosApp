@extends('layout.appAdmin')
@section('title','Clientes - Detalhes')
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

                        <div class="second-row mb-10">

                            <div class="tabbable">
                                <ul class="nav nav-tabs padding-16">
                                   
                                    <li class="active">
                                        <a data-toggle="tab" href="#dados_empresa">
                                            <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                                            Dados da Empresa
                                        </a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#imgLogo">
                                            <i class="red ace-icon fa fa-paperclip bigger-125"></i>
                                            Logotipo
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content profile-edit-tab-content">
                                    <div id="dados_empresa" class="tab-pane in active">
                                        <table class="table table-bordered">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Nome</th>
                                                    <td>{{$empresa->nome}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <th scope="row">Referência</th>
                                                    <td>{{$empresa->referencia}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Tipo de empresa</th>
                                                    <td>
                                                        @if(!empty($empresa->tipo_cliente_id))
                                                        {{$empresa->tipocliente->designacao}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Regime da Empresa</th>
                                                    <td>
                                                        @if(!empty($empresa->tipo_regime_id))
                                                        {{$empresa->tiporegime->Designacao}}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">O Gestor</th>
                                                    <td>
                                                        {{$gestor}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">NIF</th>
                                                    <td>{{$empresa->nif}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Endereco</th>
                                                    <td>{{$empresa->endereco}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Email</th>
                                                    <td>{{$empresa->email}}</td>
                                                </tr>
                                                <tr id="website">
                                                    <th scope="row">Website</th>
                                                    <td>
                                                        <a href="{{$empresa->Website}}" target="new">{{$empresa->Website}}</a>
                                                    </td>
                                                </tr>
                                                
                                                <tr id="website">
                                                    <th scope="row">Saldo</th>
                                                    <td>
                                                        @if( (!empty($empresa->saldo)) && ($empresa->saldo > 0))
                                                            <span class="label label-sm label-success" style="border-radius: 20px;">{{$empresa->saldo}}</span>
                                                        @elseif((empty($empresa->saldo)) || ($empresa->saldo < 0))
                                                            <span class="label label-sm label-danger" style="border-radius: 20px;">{{$empresa->saldo}}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                
                                                <tr id="website">
                                                    <th scope="row">Situação</th>
                                                    <td>
                                                    @if(!empty($empresa->status_id))
                                                        @if($statusgerais == 'Activo')
                                                            <span class="label label-sm label-success" style="border-radius: 20px;">{{$empresa->statusgerais->designacao}}</span>
                                                        @elseif($statusgerais == 'Desactivo')
                                                            <span class="label label-sm label-danger" style="border-radius: 20px;">{{$empresa->statusgerais->designacao}}</span>
                                                        @endif
                                                    @endif
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <th scope="row">Data de Criação</th>
                                                    <td>{{$empresa->created_at}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <th scope="row">Logo Empresa</th>
                                                    <td>
                                                        <div>
                                                            <img class="nav-user-photo" src="{{url('storage/utilizadores/cliente/'.$empresa->logotipo)}}" height="70px" />
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div id="imgLogo" class="tab-pane">
                                        <table class="table table-bordered">
                                            <tbody>
                                          
                                                @if(!empty($empresa->logotipo))
                                                <li class="divider"></li>
                                                <ul class="list-unstyled  spaced" style="right:80%;">
                                                    <div class="" >
                                                        <ul class="ace-thumbnails clearfix" id="galeria">
                                                            <li class="ace-thumbnails clearfix">
                                                                <div>
                                                                    <img width="200" height="200" alt="200x200" src="{{url('storage/utilizadores/cliente/'.$empresa->logotipo)}}" />
                                                                    <div class="text">
                                                                        <div class="inner">
                                                                            <span>{!!$empresa->nome!!}</span>
        
                                                                            <br/><br/>
                                                                            <a href="{{url('storage/utilizadores/cliente/'.$empresa->logotipo)}}" data-rel="colorbox" title="Ampliar">
                                                                                <i class="ace-icon fa fa-search-plus bigger-150"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div><!-- PAGE CONTENT ENDS -->
                                                </ul>
                                                @endif

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
        .tab-content.profile-edit-tab-content{
            margin-bottom: 20px;
        }
        a:hover, a:focus{
            color: #23527c;
        }
    </style>
@endsection
