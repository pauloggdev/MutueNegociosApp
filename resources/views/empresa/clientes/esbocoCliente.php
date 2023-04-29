
@extends('layout.appEmpresa')
@section('title','Listar Cliente')
@section('content')

    <section class="content">
        <div class="row">

            <div class="space-6"></div>
            <div class="page-header" style="left: 0.5%; position: relative">
                <h1>
                    Clientes
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Listagem
                    </small>
                </h1>
            </div><!-- /.page-header -->

            @if (Session::has('success'))
                <div class="alert alert-success alert-success col-xs-12" style="left: 0%;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fa fa-check-square-o bigger-150"></i>{{ Session::get('success') }}</h5>
                </div>
            @endif

            @if (Session::has('errors'))
                <div class="alert alert-danger alert-danger col-xs-12" style="left: 0%;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-exclamation-triangle bigger-150"> Ups!!</i><br/>
                    <h5>
                        @foreach($errors->all() as $erro)
                            <span style="left: 2.5%; position: relative">{{$erro}}<br/></span>
                        @endforeach
                    </h5>
                </div>
            @endif

            <div class="col-xs-12">

                <div class="nav-search minimized col-xs-12" style="left: 0%">
                    <form class="form-search" method="get" action='{!!url("admin/usuarios")!!}'>
                        <div class="row">
                            <div class="">
                                <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-search"></i>
                                </span>

                                    <input type="text" name="query"  autocomplete="on" class="form-control search-query" placeholder="Buscar Por cliente..."/>
                                    <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary btn-lg upload">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-130"></span>
                                    </button>
                                </span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @for($i=1; $i<=5; $i++)<div class="space-6"><p><br/></p></div>@endfor


                <div class="">
                    <div class="row" >
                        <form id="adimitirCandidatos" method = 'POST' action =''>
                            <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>

                            <div class="col-xs-12 widget-box widget-color-green"  style="left: 0%;">
                                <div class="clearfix">
                                    <a href='#criar_cliente' data-toggle="modal" title="Adicionar novo cliente" class = 'btn btn-success widget-box widget-color-blue' id="botoes"><i class="fa fa-cliente-plus"></i> Novo cliente</a>
                                    <div class="pull-right tableTools-container"></div>
                                </div>

                                <div class="table-header widget-header">
                                    Todos cliente do Sistema
                                </div>

                                <!-- div.dataTables_borderWrap -->
                                <div>
                                    <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">

                                        <thead>
                                        <tr>
                                            <th class="center">
                                                <label class="pos-rel">
                                                    <input type="checkbox" class="ace" />
                                                    <span class="lbl"></span>
                                                </label>
                                            </th>
                                            <th>Nome do cliente</th>
                                            <th>Email</th>
                                            <th>Tipo Cliente</th>
                                            <th>País</th>
                                            <th>status</th>
                                            <th>Opções</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($clientes as $cliente)
                                            <tr>
                                                <td class="center">
                                                    <label class="pos-rel ">
                                                        <input type="checkbox" class="ace " />
                                                        <span class="lbl"></span>
                                                    </label>
                                                </td>

                                                <td>{{$cliente->nome}}</td>
                                                <td>{{$cliente->email}}</td>
                                                <td>{{($cliente->tipo_cliente_id) ?($cliente->tipocliente->designacao):''}}</td>
                                                <td>{{$cliente->pais->designacao}}</td>
                                                <td class="hidden-480" style="text-align: center">
                                                    @if($cliente->statuGeral->id == 1)
                                                        <span class="label label-sm label-success" style="border-radius: 20px;">{{$cliente->statuGeral->designacao}}</span>
                                                    @else
                                                        <span class="label label-sm label-warning" style="border-radius: 20px;">{{$cliente->statuGeral->designacao}}</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="hidden-sm hidden-xs action-buttons">
                                                        <a class="" href='{{ url('empresa/clientes/detalhes/')}}/{{base64_encode($cliente->id)}}' class="pink" title="Ver mais informações">
                                                            <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                        </a>
                                                        <a class="" href='{{ url('empresa/clientes/editar/')}}/{{base64_encode($cliente->id)}}' class="pink" title="Editar este registo">
                                                            <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                        </a>
                                                        <a class=" " data-toggle="modal" href="" data-target=".eliminar{{base64_encode($cliente->id)}}" title="Eliminar este Registro">
                                                            <i class="ace-icon fa fa-trash-o bigger-150 bolder danger red"></i>
                                                        </a>
                                                    </div>

                                                </td>
                                            </tr>

                                            <!-- Moda eliminar -->
                                            <div class="modal fade width-100 eliminar{{$cliente->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-default">
                                                    <div class="modal-content">
                                                        <div class="widget-header modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="text-danger">×</span></button>
                                                            <h4 class="smaller"><i class="ace-icon fa fa-exclamation-triangle red"></i> Eliminar cliente</h4>
                                                        </div>
                                                        <div class="modal-body alert alert-danger bigger-110" >
                                                            <p class="bigger-110 center grey" style="color: orange;">
                                                                <i class="ace-icon fa fa-exclamation-triangle red bigger-110"></i>
                                                                <?php echo "Tem certeza que quer eliminar este registro? "?>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class=" btn btn-inverse btn-flat widget-color-blue1" data-dismiss="modal" style="border-radius: 10px">Cancelar</button>
                                                            <a href="{{url('empresa/clientes/deletar/')}}/{{$cliente->id}}" class="bigger-10 btn btn-danger btn-flat widget-color-blue1" style="border-radius: 10px"> Eliminar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- MODAIS DE COMFIRMAÇÃO PARA ELIMINAR-->
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{$clientes->render()}}
                                </div>
                            </div><!-- /.col-xs-12 -->
                        </form>
                    </div>
                </div>

                <!-- MODAL DE CRIAR clientes -->
                <div id="criar_cliente" class="modal fade criar_cliente">
                    <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                                <h4 class="smaller"><i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar cliente</h4>
                            </div>
                            <div class="modal-body">
                                <div class="row" style="left: 0%; position: relative;">
                                    <div class="col-md-12">
                                        <div class="search-form-text">
                                            <div class="search-text">
                                                <i class="fa fa-pencil"></i>
                                                Dados do cliente
                                            </div>
                                            <div class="home-text">
                                                <i class="fa fa-photo"></i>
                                                Foto do Cliente
                                            </div>
                                        </div>

                                        <form method = 'POST' action='{!!url("/empresa/clientes/adicionar")!!}' enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                            {{ csrf_field() }}
                                            <input type = 'hidden' name = 'remember_token' value = '{{Session::token()}}'>

                                            <div class="second-row">

                                                <div class="tabbable">
                                                    <ul class="nav nav-tabs padding-16">
                                                        <li class="active">
                                                            <a data-toggle="tab" href="#dados_cliente">
                                                                <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                                Dados do cliente
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a data-toggle="tab" href="#foto_user">
                                                                <i class="red ace-icon fa fa-photo bigger-125"></i>
                                                                Foto do Cliente
                                                            </a>
                                                        </li>
                                                    </ul>

                                                    <div class="tab-content profile-edit-tab-content">
                                                        <div id="dados_cliente" class="tab-pane in active" style="left: 12%; position: relative">
                                                            <div class="form-group has-info">
                                                                <div class="col-md-5">
                                                                    <label class="control-label" for="nome">Nome<b class="red">*</b></label>
                                                                    <div class="">
                                                                        <input type="text" name="nome" value="{{ old('nome')}}" id="nome" class="col-md-12 col-xs-12  col-sm-4"  />
                                                                        @if ($errors->has('nome'))
                                                                        <span class="help-block" style="color: red; font-weight: ">
                                                                            <strong>{{ $errors->first('nome') }}</strong>
                                                                        </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label class="control-label" for="email">Email<b class="red">*</b></label>
                                                                    <div class="">
                                                                        <input type="email" name="email" value="{{ old('email')}}" id="email" class="col-md-12 col-xs-12  col-sm-4"  />
                                                                        @if ($errors->has('email'))
                                                                        <span class="help-block" style="color: red; font-weight: ">
                                                                            <strong>{{ $errors->first('email') }}</strong>
                                                                        </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group has-info">
                                                                <div class="col-md-5">
                                                                    <label class="control-label" for="pessoa_contacto">Pessoa Contato</label>
                                                                    <div class="">
                                                                        <input type="text" name="pessoa_contacto" value="{{ old('pessoa_contacto')}}" id="pessoa_contacto" class="col-md-12 col-xs-12  col-sm-4"  />
                                                                        @if ($errors->has('pessoa_contacto'))
                                                                        <span class="help-block" style="color: red; font-weight: ">
                                                                            <strong>{{ $errors->first('pessoa_contacto') }}</strong>
                                                                        </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label class="control-label" for="endereco">Endereco<b class="red">*</b></label>
                                                                    <div class="">
                                                                        <input type="text" name="endereco" value="{{ old('endereco')}}" id="endereco" class="col-md-12 col-xs-12  col-sm-4" />
                                                                        @if ($errors->has('endereco'))
                                                                        <span class="help-block" style="color: red; font-weight: ">
                                                                            <strong>{{ $errors->first('endereco') }}</strong>
                                                                        </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group has-info">
                                                                <div class="col-md-5">
                                                                    <label class="control-label" for="website">Web Site<b class="red">*</b></label>
                                                                    <div class="">
                                                                        <input type="text" name="website" value="{{ old('website')}}" id="website" class="col-md-12 col-xs-12  col-sm-4" />
                                                                        @if ($errors->has('website'))
                                                                        <span class="help-block" style="color: red; font-weight: ">
                                                                            <strong>{{ $errors->first('website') }}</strong>
                                                                        </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label class="control-label" for="pais_id">País</label>
                                                                    <div class="">
                                                                        <select id="pais_id" name="pais_id" class="col-md-12 col-xs-12 col-sm-4 select2" data-placeholder="Selecione o país" required="true"  style="height: 34px">
                                                                            <option value=""></option>
                                                                            @foreach($paises as $pais)
                                                                                <option value="{{$pais->id}}" {{(old('pais_id')==$pais->id)? 'selected':''}}>{{$pais->designacao}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @if ($errors->has('pais_id'))
                                                                        <span class="help-block" style="color: red; font-weight: ">
                                                                            <strong>{{ $errors->first('pais_id') }}</strong>
                                                                        </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group has-info">
                                                                <div class="col-md-5">
                                                                    <label class="control-label" for="nome">NIF<b class="red">*</b></label>
                                                                    <div class="">
                                                                        <input type="text" name="nif" id="nif"  class="col-md-12 col-xs-12  col-sm-4" />
                                                                        @if ($errors->has('nif'))
                                                                        <span class="help-block" style="color: red; font-weight: ">
                                                                            <strong>{{ $errors->first('nif') }}</strong>
                                                                        </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label class="control-label" for="tipo_cliente">Tipo Cliente</label>
                                                                    <div class="">
                                                                        <select  name="tipo_cliente_id" class="col-md-12 col-xs-12 col-sm-4 select2" id="tipo_cliente_id" data-placeholder="Selecione o tipo de cliente" >
                                                                            <option value=""></option>
                                                                            @foreach($tipos_clientes as $tipo)
                                                                                <option value="{{$tipo->id}}" {{(old('tipo_cliente_id')==$tipo->id)? 'selected':''}}>{{$tipo->designacao}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @if ($errors->has('tipo_cliente_id'))
                                                                        <span class="help-block" style="color: red; font-weight: ">
                                                                            <strong>{{ $errors->first('tipo_cliente_id') }}</strong>
                                                                        </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group has-info">
                                                                <div class="col-md-5">
                                                                    <label class="control-label" for="gestor">Gestor</label>
                                                                    <div class="">
                                                                        <select  name="gestor_id" class="col-md-12 col-xs-12 col-sm-4 select2" id="gestor_id" data-placeholder="Selecione o gestor">
                                                                            <option value=""></option>
                                                                            <option value="1" {{(old('gestor_id')==1)? 'selected':''}}>Gestor 1</option>
                                                                        </select>
                                                                         @if ($errors->has('gestor_id'))
                                                                        <span class="help-block" style="color: red; font-weight: ">
                                                                            <strong>{{ $errors->first('gestor_id') }}</strong>
                                                                        </span>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label class="control-label" for="saldo">Saldo<b class="red">*</b></label>
                                                                    <div class="">
                                                                        <input type="number" name="saldo" value="0.00" id="saldo" class="col-md-12 col-xs-12  col-sm-4" readonly="true" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div id="foto_user" class="tab-pane">
                                                            <div class="row" style="left: 18%; position: relative;">
                                                                <div class="form-group has-info">
                                                                    <br/>
                                                                    <div class="col-sm-8">
                                                                        <div class="widget-box">
                                                                            <div class="widget-header">
                                                                                <h4 class="widget-title">Carregamento da Foto</h4>

                                                                                <div class="widget-toolbar">
                                                                                    <a href="#" data-action="collapse">
                                                                                        <i class="ace-icon fa fa-chevron-up"></i>
                                                                                    </a>

                                                                                    <a href="#" data-action="close">
                                                                                        <i class="ace-icon fa fa-times"></i>
                                                                                    </a>
                                                                                </div>
                                                                            </div>

                                                                            <div class="widget-body">
                                                                                <div class="widget-main">
                                                                                    <div class="form-group">
                                                                                        <div class="col-xs-12">
                                                                                            <input name="foto" type="file" accept="image/*" id="id-input-file-3" value="" />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> <!--/.row -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="clearfix form-actions">
                                                    <div class="col-md-offset-3 col-md-9">
                                                        <button class="search-btn" type="submit" style="border-radius: 10px">
                                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                                            Salvar
                                                        </button>

                                                        &nbsp; &nbsp;
                                                        <button class="btn btn-danger" type="reset" style="border-radius: 10px">
                                                            <i class="ace-icon fa fa-undo bigger-110"></i>
                                                            Cancelar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!--/ MODAL DE CRIAR fornecedorS-->
            </div><!-- /.col -->
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
    </style>
@endsection
