
@extends('layout.appEmpresa')
@section('title','Adicionar Clientes')
@section('content')

    <section class="content">

        <div class="page-header">
            <h1>Adicionar Categorias</h1>
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
                {{-- FIM --}}

                {{-- ERROR --}}

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
                
                {{-- FIM ERROR --}}


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

    </section>
@endsection
