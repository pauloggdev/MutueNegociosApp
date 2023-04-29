
@extends('layout.appEmpresa')
@section('title','Editar Fornecedor')
@section('content')

    <section class="content">

        <div class="page-header">
            <h1>Editar Fornecedor</h1>
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

                <div class="alert alert-info hidden-md hidden-lg">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    When device is smaller than
                    <span class="blue bolder">992px</span>
                    wide, side menu is automatically minimized.
                </div>
                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row" style="left: 0%; position: relative;">
            <div class="col-md-12">
                <div class="search-form-text">
                    <div class="search-text">
                        <i class="fa fa-pencil"></i>
                        Dados do fornecedor
                    </div>
                </div>

            <form method="post" action="{{url('empresa/fornecedores/update/')}}/{{$fornecedor->id}}"  class="filter-form form-horizontal" >
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <input type = 'hidden' name = '_method' value = 'PUT'>
                    <input type = 'hidden' name = 'remember_token' value = '{{Session::token()}}'>

                    <div class="second-row">

                        <div class="tabbable">
                            <ul class="nav nav-tabs padding-16">
                                <li class="active">
                                    <a data-toggle="tab" href="#dados_user">
                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                        Dados do fornecedor
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content profile-edit-tab-content" >
                                
                                <div id="dados_fornecedor" class="tab-pane in active" style="left: 0%; position: relative">
                                    
                                    <h4 class="header bolder smaller" style="color: #3d5476">Geral</h4>
                                    <div class="form-group has-info has-info" style="left: 6%; position: relative">
                                        <div class="col-md-5">
                                            <label class="control-label" for="nome">Nome<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <input type="text" name="nome" value="{{$fornecedor->nome}}" id="nome" required class="col-md-12 col-xs-12 col-sm-4" />
                                                @if ($errors->has('nome'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('nome') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <label class="control-label" for="pais_nacionalidade">País Nacionalidade<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <select  class="col-md-12 col-xs-12 col-sm-4 select2" id="pais_nacionalidade" name="pais_nacionalidade_id" data-placeholder="Selecione o país">
                                                    <option value=""></option>
                                                    @foreach($paises as $pais)
                                                        <option value="{{$pais->id}}"{{($pais->id == $fornecedor->pais_nacionalidade_id)?'selected="selected"':''}}>{{$pais->designacao}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('pais_nacionalidade_id'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('data_contracto') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group has-info" style="left: 6%; position: relative">
                                        <div class="col-md-5">
                                            <label class="control-label" for="nif">NIF<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <input type="text" name="nif" required id="nif" value="{{$fornecedor->nif}}" required class="col-md-12 col-xs-12  col-sm-4" />
                                                @if ($errors->has('nif'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('nif') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="control-label" for="status_id">Status<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <select name="status_id" style="height: 34px" class="col-md-12 col-xs-12  col-sm-4 select2" data-placeholder="Selecione o status" id="status_id">
                                                    <option value=""></option>
                                                    @foreach($status as $statu)
                                                        <option value="{{$statu->id}}"{{($statu->id == $fornecedor->status_id)?'selected="selected"':''}}>{{$statu->designacao}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('status_id'))
                                                <span class="help-block" style="color: red; font-weight:">
                                                    <strong>{{ $errors->first('status_id') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group has-info" style="left: 6%; position: relative">

                                        <div class="col-md-5">
                                            <label class="control-label" for="id-date-picker-1">Data de Contracto</label>
                                            <div class="input-group">
                                                <input type="text" name="data_contracto" value="{{$fornecedor->data_contracto}}" class="form-control date-picker" autocomplete="off" style="height: 35px;" autocomplete="off" id="id-date-picker-1" data-date-format="yyyy-mm-dd" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar bigger-110"></i>
                                                </span>
                                                @if ($errors->has('data_contracto'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('data_contracto') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="header bolder smaller" style="color: #3d5476">Contacto</h4>
                                    <div class="form-group has-info" style="left: 6%; position: relative">

                                        <div class="col-md-5">
                                            <label class="control-label" for="telefone_empresa">Telefone empresa<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <input type="text" name="telefone_empresa" value="{{$fornecedor->telefone_empresa}}" id="telefone_empresa" class="col-md-12 col-xs-12 col-sm-4" required />
                                                @if ($errors->has('telefone_empresa'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('telefone_empresa') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <label class="control-label" for="email_empresa">Email empresa<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <input type="email" name="email_empresa" value="{{$fornecedor->email_empresa}}" required id="endereco" class="col-md-12 col-xs-12  col-sm-4" />
                                                @if ($errors->has('email_empresa'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('email_empresa') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group has-info" style="left: 6%; position: relative">
                                        <div class="col-md-5">
                                            <label class="control-label" for="pessoal_contacto">Pessoa Contacto<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <input type="text" name="pessoal_contacto" value="{{$fornecedor->pessoal_contacto}}"  id="pessoal_contacto" class="col-md-12 col-xs-12  col-sm-4" required="" />
                                                @if ($errors->has('pessoal_contacto'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('pessoal_contacto') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="control-label" for="telefone_contacto">Telefone contacto<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <input type="text" name="telefone_contacto" value="{{$fornecedor->telefone_contacto}}" id="telefone_contacto" class="col-md-12 col-xs-12  col-sm-4" required="" />
                                                @if ($errors->has('telefone_contacto'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('telefone_contacto') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group has-info" style="left: 6%; position: relative">
                                        <div class="col-md-5">
                                            <label class="control-label" for="email_contacto">Email Contacto<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                            <div class="">
                                                <input type="email" name="email_contacto" value="{{$fornecedor->email_contacto}}" id="email_contacto" class="col-md-12 col-xs-12  col-sm-4" required="" />
                                                @if ($errors->has('email_contacto'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('email_contacto') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <label class="control-label" for="website">Web Site<b class="red"></b></label>
                                            <div class="">
                                                <input type="text" name="website" value="{{$fornecedor->website}}" id="website" class="col-md-12 col-xs-12  col-sm-4" />
                                                @if ($errors->has('website'))
                                                <span class="help-block" style="color: red; font-weight: ">
                                                    <strong>{{ $errors->first('website') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
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


































