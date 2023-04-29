
@extends('layout.appEmpresa')
@section('title','Editar fabricantes')
@section('content')

    <section class="content">

        <div class="page-header">
            <h1>Editar fabricantes</h1>
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
                        Dados do fabricante
                    </div>
                </div>

            <form method="post" action="{{url('empresa/fabricantes/update/')}}/{{$fabricante->id}}"  class="filter-form form-horizontal" >
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
                                    Dados do fabricante
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content profile-edit-tab-content" style="height: 200px;">
                            <div id="dados_user" class="tab-pane in active" style="left: 12%; position: relative">
                                <div class="form-group has-info">
                                    <div class="col-md-5">
                                        <label class="control-label" for="fabricante">Nome<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                        <div class="">
                                            <input type="text" name="designacao" value="{{$fabricante->designacao}}" id="designacao" class="col-md-12 col-xs-12  col-sm-4" required/>
                                            @if ($errors->has('designacao'))
                                            <span class="help-block" style="color: red; font-weight: ">
                                                <strong>{{ $errors->first('designacao') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-5">
                                        <label class="control-label" for="status">Status<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                        <div class="">
                                            <select name="status_id" style="height: 34px" class="col-md-12 col-xs-12  col-sm-4 select2" data-placeholder="Selecione o status" id="gestor">
                                                <option value=""></option>
                                                @foreach($status as $statu)
                                                    <option value="{{$statu->id}}"{{($statu->id == $fabricante->status_id)?'selected="selected"':''}}>{{$statu->designacao}}</option>
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


































