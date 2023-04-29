@extends('layout.appEmpresa')
@section('title','Utilizadores')
@section('content')

<section class="content">
    <div class="row">
        
        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                UTILIZADORES   
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Editar
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
            
            <div class="">
                <div class="row" >
                    <!-- MODAL DE EDITAR -->
                    <div class="row" style="left: 0%; position: relative;">
                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Dados do Utilizador
                                </div>

                                <div class="home-text">
                                    <i class="fa fa-photo"></i>
                                    Foto do Utilizador
                                </div>
                            </div>

                            <form method = 'POST' action='{!! url("empresa/usuarios/update")!!}/{!!$user->id!!}' enctype="multipart/form-data" class="filter-form form-horizontal" id="validation-form">
                                {{ csrf_field() }}
                                <!-- <input type = 'hidden' name = 'remember_token' value = '{{Session::token()}}'> -->

                                <div class="second-row">

                                    <div class="tabbable">
                                        <ul class="nav nav-tabs padding-16">
                                            <li class="active">
                                                <a data-toggle="tab" href="#dados">
                                                    <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                    Dados do Utilizador
                                                </a>
                                            </li>

                                            <li>
                                                <a data-toggle="tab" href="#foto">
                                                    <i class="red ace-icon fa fa-photo bigger-125"></i>
                                                    Foto do Utilizador
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados" class="tab-pane in active" style="left: 12%; position: relative">
                                                <div class="form-group has-info">
                                                    <div class="col-md-5">
                                                        <label class="control-label" for="nome">Nome<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                        <div class="">
                                                            <input type="text" name="name" value="{{$user->name}}" id="name" class="col-md-12 col-xs-12  col-sm-4 form-control" required/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <label class="control-label" for="nif">Username<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                        <div class="">
                                                            <input type="text" name="username" value="{{$user->username}}" required id="username" class="col-md-12 col-xs-12  col-sm-4 form-control" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group has-info">

                                                    <div class="col-md-5">
                                                        <label class="control-label" for="email_empresa">Email<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                        <div class="">
                                                            <input type="email" name="email" value="{{$user->email}}" id="email" class="col-md-12 col-xs-12  col-sm-4 form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <label class="control-label" for="telefone_empresa">Telefone</label>
                                                        <div class="">
                                                            <input type="text" name="telefone" value="{{$user->telefone}}" id="phone" class="col-md-12 col-xs-12  col-sm-4 form-control" required="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="foto" class="tab-pane">
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
                                                                        <div class="form-group has-info">
                                                                            <div class="col-xs-12">
                                                                                <input name="logotipo" type="file" accept="image/*" value="{{ old('foto') }}" id="id-input-file-3" />
                                                                                <!-- <input name="foto_user" type="file" value="{{$user->foto}}" accept="image/*" id="id-input-file-3" hidden="true" /> -->
                                                                            </div>
                                                                        </div>

                                                                        <label>
                                                                            <input type="checkbox" value="Sim"  name="file-format" id="id-file-format" class="ace"  hidden="" />
                                                                            <span class="lbl"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> /.row 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button class="search-btn" type="submit" style="border-radius: 10px" > <!--onclick="event.preventDefault();document.getElementById('form-edit').submit();"-->
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
                    <!--/ MODAIS DE EDITAR-->
                </div>
            </div> 
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
