@extends('layout.appEmpresa')
@section('title','Alteração da Senha')
@section('content')

@if(Auth::user())
<section class="content">
    <div class="row">
        
        <div class="space-6"></div>
        <br/><br/>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1 style="text-transform: uppercase">
                Alteração da Senha
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Alteração
                </small>
            </h1>
        </div><!-- /.page-header -->

        <div class="col-xs-10">
            
            @if (Session::has('success'))
            <div class="alert alert-success alert-success" style="left: 12%; width: 98%; position: relative">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fa fa-check-square-o bigger-150"></i>{{ Session::get('success') }}</h5>
            </div>
           @endif

            @if (Session::has('errors'))
            <div class="alert alert-danger alert-danger" style="left: 12%; width: 98%; position: relative">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h5><i class="icon fa fa-exclamation-triangle bigger-150"></i> 
                @foreach($errors->all() as $erro)
                    <span>{{$erro}} </span>
                @endforeach
              </h5>
            </div>
            @endif
            <a href="#alterarSenha" data-toggle="modal" class = 'btn btn-success widget-box widget-color-blue' style="left: 12%; border-radius: 8px;" id="botoes"><i class="fa fa-lock"></i> Alterar Password</a>
            
            <div class="message-list-container" style="left: 11%; position: relative;">
                <div class="message-list" id="message-list">
                    <div class="message-item message-unread">

                        <div class="secundario"><!-- Barra de Filtro -->
                            <div>
                                <table id="dynamic-table" class="table table-striped table-bordered table-hover">

                                    <thead>
                                        <tr>
                                            <th class="bolder">Nome de Utilizador</th> 
                                            <th class="bolder">Telefone</th>
                                            <th class="bolder">Email</th>
                                            <th class="bolder">Função</th>
                                            <th class="bolder">Permissões</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td><span class='text-danger bolder'>{{Auth::user()->name}}</span></td>
                                            <td><span class='text-danger bolder'>{{Auth::user()->telefone}}</span></td>
                                            <td><span class='text-danger bolder'>{{Auth::user()->email}}</span></td>
                                            <td style="width: 20%">
                                                @if(!empty(Auth::user()->roles))
                                                    @foreach(Auth::user()->roles as $role)
                                                    <span class='label label-info bolder' style='border-radius: 8px;'>&nbsp;{{$role->name}}&nbsp; &nbsp;</span>
                                                    @endforeach
                                                @else
                                                    <span class = 'bolder text-danger'>Sem função</span>
                                                @endif
                                            </td>
                                            <td style="width: 20%">
                                                @if(!empty(Auth::user()->permissions))
                                                    @foreach(Auth::user()->permissions as $permission)
                                                    <span class='label label-info bolder' style='border-radius: 8px;'>&nbsp;{{$permission->name}}&nbsp; &nbsp;</span>
                                                    @endforeach
                                                @else
                                                    <span class = 'bolder text-danger'>Sem regras</span>
                                                @endif
                                            </td>
                                        </tr>
                                        
                                    </tbody>   
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

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
                            <form method = 'POST' action ="{{url('empresa/update_senha')}}/{{Auth::user()->id}}" class="form-horizontal validation-form" role="form">
                                {!! csrf_field() !!}
                                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                                
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
        </div><!-- /.col -->
    </div><!-- /.row -->
</section>
@endif
@endsection
