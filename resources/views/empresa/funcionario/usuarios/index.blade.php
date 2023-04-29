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
                <form class="form-search" method="get" action='{!!url("empresa/usuarios")!!}'>
                    <div class="row">
                        <div class="">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-search"></i>
                                </span>

                                <input type="text" name="query" required autocomplete="on" class="form-control search-query" placeholder="Buscar Por Utilizadores..."/>
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
                                <a href='#criar_user' data-toggle="modal" title="Adicionar novo Utilizador" class = 'btn btn-success widget-box widget-color-blue' id="botoes"><i class="fa fa-user-plus"></i> Novo Utilizador</a>
                                <div class="pull-right tableTools-container"></div>
                            </div>

                            <div class="table-header widget-header">
                                Todos Utilizadores do Sistema
                            </div>

                            <!-- div.dataTables_borderWrap -->
                            <div>
                                <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                    
                                    <thead>
                                        <tr>
                                            <th class="center">
                                                <label class="pos-rel" for="permissao">
                                                    <input type="checkbox" id="marcarTodos" class="ace input-lg" >
                                                    <span class="lbl text-info"></span>
                                                </label>
                                            </th>
                                            <th>Nome de Utilizador</th>
                                            <th>Email</th>
                                            <th>Telefone</th>
                                            <th>Opções</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td class="center">
                                                <label class="pos-rel ">
                                                    <input type="checkbox" id="marcar" class="ace input-lg" />
                                                    <span class="lbl"></span>
                                                </label>
                                            </td>

                                            <td>{{$user->name}}</td>
                                            <td style="width: 20%">{{$user->email}}</td>
                                            <td>{{$user->telefone}}</td>

                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a class="" href='' data-toggle="modal" data-target='.editar_user{{$user->id}}' class="pink" title="Editar este registo">
                                                        <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                    </a>
                                                    
                                                    <a class=" " data-toggle="modal" href="" data-target=".eliminar{{$user->id}}" title="Eliminar este Utilizador">
                                                        <i class="ace-icon fa fa-trash-o bigger-150 bolder danger red"></i>
                                                    </a>
                                                    
                                                    <a href="{{url('empresa/usuarios')}}/{{$user->id}}" class="" class="pink" title="Configurar Permissões">
                                                        <i class="ace-icon fa fa-cogs bigger-150 bolder text-primary"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        
                                        <div class="modal fade width-100 eliminar{{$user->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-default">
                                              <div class="modal-content">
                                                  <div class="widget-header modal-header">
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="text-danger">×</span></button>
                                                      <h4 class="smaller"><i class="ace-icon fa fa-exclamation-triangle red"></i> Eliminar Utilizador</h4>
                                                  </div>
                                                <div class="modal-body alert alert-danger bigger-110" >
                                                    <p class="bigger-110 center grey" style="color: orange;">
                                                       <i class="ace-icon fa fa-exclamation-triangle red bigger-110"></i>
                                                        <?php echo "Tem certeza que quer eliminar este Utilizador? "?>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                  <button type="button" class=" btn btn-inverse btn-flat widget-color-blue1" data-dismiss="modal" style="border-radius: 10px">Cancelar</button>
                                                  <a href="{{url('empresa/usuarios')}}/{{$user->id}}/delete" class="bigger-10 btn btn-danger btn-flat widget-color-blue1" style="border-radius: 10px"> Eliminar</a>
                                                </div>
                                              </div>
                                            </div>
                                        </div><!-- MODAIS DE COMFIRMAÇÃO PARA ELIMINAR-->

                                        <!-- MODAL DE EDITAR -->
                                        <div id="" class="modal fade editar_user{{$user->id}}">
                                            <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                                                <div class="modal-content">
                                                    <div class="modal-header text-center">
                                                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                                                        <h4 class="smaller"><i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar Utilizador</h4>
                                                    </div>
                                                    <div class="modal-body">
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

                                                                <form method = 'POST' action='{!! url("empresa/usuarios")!!}/{!!$user->id!!}/update' enctype="multipart/form-data" class="filter-form form-horizontal" >
                                                                    {{ method_field('PUT') }}
                                                                    {{ csrf_field() }}
                                                                    <input type = 'hidden' name = '_method' value = 'PUT'>
                                                                    <input type = 'hidden' name = 'remember_token' value = '{{Session::token()}}'>

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
                                                                                                                    <input name="foto" type="file" accept="image/*" value="{{$user->foto}}" id="id-input-file-3" />
                                                                                                                    <input name="foto_user" type="file" value="{{$user->foto}}" accept="image/*" id="id-input-file-3" hidden="true" />
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
                                                </div> 
                                            </div>
                                        </div>
                                        <!--/ MODAIS DE EDITAR-->
                                     @endforeach
                                    </tbody> 
                                </table>
                                 {{$users->render()}}
                            </div>
                        </div><!-- /.col-xs-12 -->
                   </form>
                </div>
            </div>
             
           <!-- MODAL DE CRIAR USERS -->
            <div id="criar_user" class="modal fade criar_user">
                <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                    <div class="modal-content">
                        <div class="modal-header text-center">
                            <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                            <h4 class="smaller"><i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar Utilizador</h4>
                        </div>
                        <div class="modal-body">
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

                                    <form method = 'POST' action='{!!url("empresa/usuarios")!!}' enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                        {!! csrf_field() !!}
                                        <input type = 'hidden' name = 'remember_token' value = '{{Session::token()}}'>

                                        <div class="second-row">
                                            
                                            <div class="tabbable">
                                                <ul class="nav nav-tabs padding-16">
                                                    <li class="active">
                                                        <a data-toggle="tab" href="#dados_user">
                                                            <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                            Dados do Utilizador
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a data-toggle="tab" href="#foto_user">
                                                            <i class="red ace-icon fa fa-photo bigger-125"></i>
                                                           Foto do Utilizador
                                                        </a>
                                                    </li>
                                                </ul>

                                                <div class="tab-content profile-edit-tab-content">
                                                    <div id="dados_user" class="tab-pane in active" style="left: 12%; position: relative">
                                                        <div class="form-group has-info">
                                                            <div class="col-md-5">
                                                                <label class="control-label" for="nome">Nome<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                                <div class="">
                                                                    <input type="text" name="name" value="{{ old('name')}}" id="name" class="col-md-12 col-xs-12  col-sm-4" required/>
                                                                    @if ($errors->has('name'))
                                                                    <span class="help-block" style="color: red; font-weight: ">
                                                                        <strong>{{ $errors->first('name') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-5">
                                                                <label class="control-label" for="username">Username<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                                <div class="">
                                                                    <input type="text" name="username" value="{{ old('username')}}" id="username" class="col-md-12 col-xs-12  col-sm-4" required />
                                                                    @if ($errors->has('username'))
                                                                    <span class="help-block" style="color: red; font-weight: ">
                                                                        <strong>{{ $errors->first('username') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group has-info">
                                                            
                                                            <div class="col-md-5">
                                                                <label class="control-label" for="email_empresa">Email<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                                <div class="">
                                                                    <input type="email" name="email" value="{{ old('email')}}" id="email" class="col-md-12 col-xs-12  col-sm-4" required=""/>
                                                                    @if ($errors->has('email'))
                                                                    <span class="help-block" style="color: red; font-weight: ">
                                                                        <strong>{{ $errors->first('email') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-5">
                                                                <label class="control-label" for="telefone_empresa">Telefone</label>
                                                                <div class="">
                                                                    <input type="text" name="telefone" value="{{ old('telefone')}}" id="phone" class="col-md-12 col-xs-12 col-sm-4" maxlength="9" required="" />
                                                                    @if ($errors->has('telefone'))
                                                                    <span class="help-block" style="color: red; font-weight: ">
                                                                        <strong>{{ $errors->first('telefone') }}</strong>
                                                                    </span>
                                                                    @endif
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
                                                                                <div class="form-group has-info">
                                                                                    <div class="col-xs-12">
                                                                                        <input name="foto" type="file" accept="image/*" id="id-input-file-3" value="" />
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
            </div><!--/ MODAL DE CRIAR USERS-->  
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
