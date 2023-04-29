@extends('layout.appAdmin')
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

            <div class="nav-search minimized col-xs-12" style="left: 0%">
                <form class="form-search" method="get" action='{!!url("admin/usuarios")!!}'>
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
                    <form action="" id="formPermissao" method="post">
                        <div class="box-body">
                           <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr class="">
                                        <th class="bolder center">Nome de Utilizador</th> 
                                        <th class="bolder center">Telefone</th>
                                        <th class="bolder center">Email</th>
                                        <th class="bolder center">Funcão</th>
                                        <th class="bolder center">Estado</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr class="center">
                                        <td><span class='text-danger bolder '>{{Auth::user()->name}}</span></td>
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
                                        <td style="width: 20%"><span class='label label-success bolder' style='border-radius: 8px;'>&nbsp;{{Auth::user()->status_id}}&nbsp; &nbsp;</span></td>
                                    </tr>
                                </tbody>   
                            </table>
                            <p><hr></p>
                            <div class="row">
                                @foreach($permissions as $key => $permission)
                                <div class="col-md-2 ">
                                    <div class="">
                                        <label class="pos-rel" style="margin-bottom: 15px">
                                            <input type="checkbox" name="permission[]" value="{{$permission->id}}" id="marcar" class="ace input-lg" @if(($permission->id == $permissao->id)) {!! 'checked="checked" ' !!} @endif />
                                            <span class="lbl bigger-120 text-info bolder"> {{$permission->name}}</span>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                        </div>
                    </form>
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
