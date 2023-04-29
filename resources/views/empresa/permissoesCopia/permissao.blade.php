@extends('layout.appEmpresa')
@section('title','Permissões')
@section('content')

<section class="content">
    <div class="row">

        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                PERMISSÕES   
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    configurações
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
                <div class="tabbable">
                    
                    <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr class="">
                                <th class="bolder center">Nome de Utilizador</th> 
                                <th class="bolder center">Telefone</th>
                                <th class="bolder center">Email</th>
                                <th class="bolder center">Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr class="center">
                                <td><span class='text-danger bolder '>{{$user->name}}</span></td>
                                <td><span class='text-danger bolder'>{{$user->telefone}}</span></td>
                                <td><span class='text-danger bolder'>{{$user->email}}</span></td>
                                <td class="hidden-480" style="text-align: center">
                                    @if($statusgerais == 'Activo')
                                        <span class="label label-sm label-success" style="border-radius: 20px;">{{$statusgerais}}</span>
                                    @elseif($statusgerais == 'Desactivo')
                                        <span class="label label-sm label-danger" style="border-radius: 20px;">{{$statusgerais}}</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>   
                    </table>
                    
                    <hr>
                    <ul class="nav nav-tabs padding-16">
                        <li class="active">
                            <a data-toggle="tab" href="#permissao">
                                <i class="green ace-icon fa fa fa-edit bigger-125"></i>
                                Funções
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#funcao">
                                <i class="red ace-icon fa fa-lock bigger-125"></i>
                                Permissões
                            </a>
                        </li>
                        <li>
                            <div class=" widget-color-blue"  style=" left: 139%; float: right; position: relative">
                                <div class="clearfix">
                                    <a href='{{url('empresa/usuarios')}}' title="Listar Utilizadores" class = 'btn btn-primary widget-box widget-color-blue' id="botoes"><i class="glyphicon glyphicon-user"></i> Utilizadores</a>
                                    <a href='{{url('empresa/funcoes-permissoes')}}' title="Listar Permissões & Funões" class = 'btn btn-primary widget-box widget-color-blue' id="botoes"><i class="glyphicon glyphicon-cog"></i> Funções & Permissões</a>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <div class="tab-content ">
                        <div id="permissao" class="tab-pane in active">
                           <form method="post" action="{{url('empresa/funcoes')}}/{{$user->id}}/concederFuncoes" class="filter-form form-horizontal" >
                                @csrf
                               <hr> 
                               <div class="row">
                                    @foreach($roles as $key => $role)
                                    <div class="col-md-3">
                                        <div class="">
                                            <label class="pos-rel bold text-info" style="margin-bottom: 15px">
                                                <input multiple="" type="checkbox" name="role[]" value="{{$role->name}}" id="marcar" class="ace input-lg" @if(in_array($role->id, $funcao_id)) {!! 'checked="checked" ' !!} @endif />
                                                <span class="lbl bigger-120 text-info bolder"> {{$role->name}}</span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                               <hr>
                               
                               <br>
                                <div class="clearfix form-actions">
                                    <div class="col-md-offset-9">
                                        <button class="search-btn" style="width:247px;font-size:16px;height:46px;background:#18a79f;color:white;border:1px solid #2cbdb8;cursor:pointer;border-radius: 10px;" type="submit" style="border-radius: 10px">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            Actualizar Funções
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div id="funcao" class="tab-pane">
                            <form method="POST" action="{{url('empresa/permissoes')}}/{{$user->id}}/concederPermissoes" class="filter-form form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <hr> 
                                <div class="row">
                                    @foreach($permissions as $key => $permission)
                                    <div class="col-md-3">        
                                        <div class="">
                                            <label class="pos-rel text-info bold" style="margin-bottom: 15px">
                                                <input multiple="" type="checkbox" name="permission[]" value="{{$permission->name}}" id="marcar" class="ace input-lg" @if(in_array($permission->id, $permissao_id)){!! 'checked="checked" ' !!} @endif />
                                                <span class="lbl bigger-120 text-info bolder"> {{$permission->name}}</span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                <hr>
                                
                                <div class="clearfix form-actions">
                                    <div class="col-md-offset-9">
                                        <button class="search-btn" style="width:247px;font-size:16px;height:46px;background:#18a79f;color:white;border:1px solid #2cbdb8;cursor:pointer;border-radius: 10px;" type="submit" style="border-radius: 10px">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            Actualizar Permissões
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
</section>

<script type="text/javascript">
    $(document).ready(function () {

        $("#marcarTodos").click(function () {

            if ($(this).attr("checked")) {
                $('.marcar').each(
                        function () {
                            $(this).attr("checked", true);
                        }
                );
            } else {
                $('.marcar').each(
                        function () {
                            $(this).attr("checked", false);
                        }
                );
            }
        });

        $("#formPermissao").validate({
            rules: {
                nome: {required: true}
            },
            messages: {
                nome: {required: 'Campo obrigatório'}
            }
        });

    });
</script>

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
