
@extends('layout.appEmpresa')
@section('title','Editar Clientes')
@section('content')

    <section class="content">

        <div class="page-header">
            <h1>EDITAR DADOS DO CLIENTES</h1>
        </div><!-- /.page-header -->

        <div class="row">
            <div class="col-xs-12">
                <!-- AVISO -->
                <div class="alert alert-warning hidden-sm hidden-xs">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    Os campos marcados com <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b> são de preenchimento obrigatório.
                </div>

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
                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->

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

                <form method="post" action="{{url('empresa/clientes/update/')}}/{{base64_encode($cliente->id)}}" id="validation-form"  class="filter-form form-horizontal" enctype="multipart/form-data" >
                    @method('PUT')
                    {{ csrf_field() }}
                    <input name="id"value="{{$cliente->id}}" type ='hidden'/>

                    <input type = 'hidden' name = '_method' value = 'PUT'>
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
                                    <a data-toggle="tab" href="#foto_cliente">
                                        <i class="red ace-icon fa fa-photo bigger-125"></i>
                                        Foto do Cliente
                                    </a>
                                </li>

                            </ul>

                            <div class="tab-content profile-edit-tab-content" style="height: 500px;">
                                <div id="dados_cliente" class="tab-pane in active" style="left: 12%; position: relative">
                                    <div class="form-group has-info">
                                        <div class="col-md-5">
                                            <label class="control-label" for="nome">Nome<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <input type="text" name="nome"value="{{$cliente->nome}}" id="nome" required class="col-md-12 col-xs-12  col-sm-4" />
                                                @if ($errors->has('nome'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('nome') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <label class="control-label" for="email">Email</label>
                                            <div class="">
                                                <input type="text" name="email"value="{{$cliente->email}}" id="telefone_empresa" class="col-md-12 col-xs-12  col-sm-4" />
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
                                            <label class="control-label" for="pessoa_contacto">Contato<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <input type="text" name="pessoa_contacto"value="{{$cliente->pessoa_contacto}}" required id="pessoa_contacto" class="col-md-12 col-xs-12  col-sm-4" />
                                                @if ($errors->has('pessoa_contacto'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('pessoa_contacto') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <label class="control-label" for="endreco">Endereço<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <input type="text" name="endereco" value="{{$cliente->endereco}}" id="endereco" class="col-md-12 col-xs-12  col-sm-4" />
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
                                            <label class="control-label" for="website">web site<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <input type="text" name="website"value="{{$cliente->website}}" id="website" class="col-md-12 col-xs-12  col-sm-4" />
                                                @if ($errors->has('website'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('website') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="control-label" for="pais_id">País Nacionalidade</label>
                                            <div class="">
                                                <select  class="col-md-12 col-xs-12 col-sm-4 select2" id="pais_id" name="pais_id" data-placeholder="Selecione o país">
                                                    <option value=""></option>
                                                    @foreach($paises as $pais)
                                                        <option value="{{$pais->id}}"{{($pais->id == $cliente->pais_id)?'selected="selected"':''}}>{{$pais->designacao}}</option>
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
                                            <label class="control-label" for="nif">NIF<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <input type="text" name="nif" id="nif" value="{{$cliente->nif}}"  class="col-md-12 col-xs-12  col-sm-4" />
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
                                                <select name="tipo_cliente_id" class="col-md-12 col-xs-12 col-sm-4 select2" id="tipo_cliente_id"  data-placeholder="Selecione o tipo de cliente">
                                                    <option value=""></option>
                                                    @foreach($tipos_clientes as $tipo)
                                                        <option value="{{$tipo->id}}"{{($tipo->id == $cliente->tipo_cliente_id)?'selected="selected"':''}}>{{$tipo->designacao}}</option>
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
                                                <select name="gestor_id" class="col-md-12 col-xs-12 col-sm-4 select2" id="gestor_id" data-placeholder="Selecione o gestor">
                                                    <option value="{{$cliente->gestor_id}}">{{$cliente->gestor->nome}}</option>
                                                </select>
                                                 @if ($errors->has('gestor_id'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('gestor_id') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="control-label" for="saldo">Saldo<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <input type="number" name="saldo" value="{{$cliente->saldo}}" id="saldo" class="col-md-12 col-xs-12  col-sm-4" />
                                                @if ($errors->has('saldo'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('saldo') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group has-info">
                                        <div class="col-md-5">
                                            <label class="control-label" for="status_id">status<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <select name="status_id" style="height: 34px" class="col-md-12 col-xs-12  col-sm-4 select2" id="status_id" data-placeholder="Selecione o status">
                                                    <option value=""></option>
                                                    @foreach($status as $statu)
                                                        <option value="{{$statu->id}}"{{($statu->id == $cliente->status_id)?'selected="selected"':''}}>{{$statu->designacao}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('status_id'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('status_id') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div id="foto_cliente" class="tab-pane">
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
                                <button class="search-btn" style="width:247px;font-size:16px;height:46px;background:#18a79f;color:white;border:1px solid #2cbdb8;cursor:pointer;border-radius: 10px;" type="submit" style="border-radius: 10px">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Editar
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

    </section>
@endsection


































