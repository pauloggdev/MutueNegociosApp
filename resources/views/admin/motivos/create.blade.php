
@extends('layout.appEmpresa')
@section('title','Adicionar Armazens')
@section('content')

<section class="content">

    <div class="page-header">
        <h1>Adicionar Armazens</h1>
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
           <!--FIM-->

            <!--ERROR-->

            @if($errors->all())
            @foreach($errors->all() as $error)
            <div class="alert alert-danger hidden-sm hidden-xs">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                {{$error}}
            </div>
            @endforeach
            @endif

            <!--FIM ERROR-->


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

    <div class="row">
        <div class="col-xs-12">
            <div class="widget-box">
                <div class="widget-body">
                    <div class="widget-main">
                        <div id="fuelux-wizard-container">

                            <div class="step-content pos-rel">
                                <div class="step-pane active" data-step="1">

                                    <form class="form-horizontal" id="validation-form" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label class="control-label" for="codigo">Codigo<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="text" name="codigo" id="codigo" class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label" for="designacao">Nome<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="text" name="designacao" id="designacao" class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label" for="status">Status</label>
                                                <div class="">
                                                    <select style="height: 34px" class="col-md-12 col-xs-12  col-sm-4" id="gestor" name="status_id">
                                                        <option value="">-----</option>
                                                        @foreach($status as $statu)
                                                            <option value="{{$statu->id}}">{{$statu->designacao}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-6">
                                                <label class="control-label" for="localizacao">Localização<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="text" name="localizacao" id="localizacao" class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success" type="button">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            Salvar
                                        </button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.widget-main -->
                </div><!-- /.widget-body -->
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->

</section>
@endsection
