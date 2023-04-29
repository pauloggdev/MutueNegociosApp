@extends('layout.appEmpresa')
@section('title','Perfil Utilizador')
@section('content')


<div class="page-header">
    <h1>
        Perfil do utilizador
    </h1>
</div><!-- /.page-header -->
@if (Session::has('success'))
<div class="alert alert-success alert-success" style="width: 98%; position: relative">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fa fa-check-square-o bigger-150"></i>{{ Session::get('success') }}</h5>
</div>
@endif

@if (Session::has('errors'))
<div class="alert alert-danger alert-danger" style="width: 98%; position: relative">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fa fa-exclamation-triangle bigger-150"></i>
        @foreach($errors->all() as $erro)
        <span>{{$erro}} </span>
        @endforeach
    </h5>
</div>
@endif

<div class="row">
    <div class="col-xs-12">
        <div>
            <div id="user-profile-1" class="user-profile row">
                <div class="col-xs-12 col-sm-3 center">
                    <div>
                        <span class="profile-picture">
                            <img id="avatar" style="height: 150px; width: 150px;" class="editable img-responsive" alt="Alex's Avatar" src="{{ url('/upload/'.$usuario['foto']) }}" />
                        </span>

                        <div class="space-4"></div>

                        <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                            <div class="inline position-relative">
                                <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                    <i class="ace-icon fa fa-circle light-green"></i>
                                    &nbsp;
                                    <span class="white">{{$usuario['name']}}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-9">
                    <div class="profile-user-info profile-user-info-striped">
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Nome </div>

                            <div class="profile-info-value">
                                <span class="editable" id="username">{{$usuario['name']}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> Telefone </div>

                            <div class="profile-info-value">
                                <span class="editable" id="username">{{$usuario['telefone']}}</span>
                            </div>
                        </div>
                        <div class="profile-info-row">
                            <div class="profile-info-name"> E-mail </div>
                            <div class="profile-info-value">
                                <span class="editable" id="username">{{$usuario['email']}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="profile-info-row">
                                <a href="#alterarSenha" data-toggle="modal" class='btn btn-success widget-box widget-color-blue' style="left: 6%; border-radius: 8px; margin-top:20px;" id="botoes"><i class="fa fa-lock"></i> Alterar Password</a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="profile-info-row">
                                <a href="/fichaCadastro" target="_blank" class='btn btn-success widget-box widget-color-blue' style="left: 6%; border-radius: 8px; margin-top:20px;" id="botoes"><i class="fa fa-print"></i> Ficha cadastro</a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div><!-- /.col -->
</div><!-- /.row -->

<!-- MODAL REGISTAR UTILIZADOR  -->
<div class="modal fade" id="alterarSenha" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 460px;">
            <div class="modal-header text-center" id="logomarca-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white">&times;</span>
                </button>
                <h4 class="smaller"><i class="ace-icon fa fa-pencil-square bigger-130 white"></i> Alteração da Senha</h4>
            </div>
            <div class="modal-body" style="">
                <form method='POST' action='/empresa/usuario/updateSenha/{{Auth::user()->id}}' class="form-horizontal validation-form" role="form">
                    {!! csrf_field() !!}
                    <input type='hidden' name='_token' value='{{Session::token()}}'>

                    <div class="tabbable">
                        <div class="tab-content profile-edit-tab-content">
                            <div id="edit-basic" class="tab-pane in active">
                                <div class="box box-primary">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="form-group has-info">
                                                <br><br>
                                                <label style="padding-top: 10px;" class="col-sm-3 control-label no-padding-right bold" for="old_password">Senha Antiga <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span></label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <input type="password" name="old_password" placeholder="Informe a Senha Antiga" class="col-xs-12" id="old_password" required style="padding: 8px 8px 9px;">
                                                        <span class="input-group-addon">
                                                            <i class="ace-icon fa fa-key bigger-150 text-info"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group has-info">
                                                <label style="padding-top: 10px;" class="col-sm-3 control-label no-padding-right bold" for="password">Nova Senha <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span></label>
                                                <div class="col-md-9">
                                                    <div class="input-group">
                                                        <input type="password" name="password" placeholder="Informe a nova Senha" class="col-xs-12" id="password" required style="padding: 8px 8px 9px;">
                                                        <span class="input-group-addon">
                                                            <i class="ace-icon fa fa-key bigger-150 text-info"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="btn btn-danger" type="reset" data-dismiss="modal">
                                <i class="ace-icon fa fa-close bigger-110"></i>
                                Cancelar
                            </button>
                            &nbsp; &nbsp;&nbsp; &nbsp;
                            <button class="btn btn-info" type="submit">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                Salvar
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- MODAL DE REGISTO DE UTILIZADOR -->

@endsection