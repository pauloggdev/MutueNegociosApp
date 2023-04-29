@extends('layout.appEmpresa')
@section('title','Funções & Permissões')
@section('content')

<section class="content">
    <div class="row">

        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                FUNÇÕES & PERMISSÕES   
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
                <div class="row" >
                    <form method="post" action="{{url('admin/funcoes-permissoes')}}/associar" id="validation-form" class="filter-form form-horizontal" >
                        @csrf
                        <div class="second-row">
                            <div class="form-group has-info">
                                <div class="col-md-5">
                                    <label class="control-label" for="role_id">Função</label>
                                    <div class="">
                                        <select style="height: 34px" class="col-md-12 col-xs-12 col-sm-4 select2" id="role_id" name="role_id" data-placeholder="Selecione a Função" required>
                                            <option value=""></option>
                                            @foreach($roles as $role)
                                                <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <hr>
                            <div class="row">
                                @foreach($permissions as $key => $permissao)
                                <div class="col-md-3">
                                    <div class="">
                                        <label class="pos-rel" style="margin-bottom: 15px">
                                            <input multiple="" type="checkbox" name="permissions[]" value="{{$permissao->name}}" id="marcar" class="ace input-lg" @if(($permissao->id == 0)) {!! 'checked="checked" ' !!} @endif />
                                            <span class="lbl bigger-120 text-info bolder"> {{$permissao->name}}</span>
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
