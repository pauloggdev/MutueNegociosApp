@extends('layout.appEmpresa')
@section('title','Adicionar Clientes')
@section('content')

<section class="content">
    <div class="page-header">
        <h1>Adicionar Clientes</h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div class="alert alert-warning hidden-sm hidden-xs">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                Os campos marcados com <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b> são de preenchimento obrigatório.
            </div>

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

    <div class="row">
        <div class="col-xs-12">


            <div class="widget-box">


                <div class="widget-body">
                    <div class="widget-main">
                        <div id="fuelux-wizard-container">

                            <div class="step-content pos-rel">
                                <div class="step-pane active" data-step="1">

                                    <form class="form-horizontal" id="validation-form" enctype="multipart/form-data" method="POST">
                                        @csrf
                                        <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>

                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label class="control-label" for="nome">Nome<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="text" name="nome" id="nome" class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label" for="pessoa_contacto">Pessoa Contato</label>
                                                <div class="">
                                                    <input type="text" name="pessoa_contacto" id="pessoa_contacto" class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label" for="endereco">Endereco<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="text" name="endereco"   id="endereco" class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label class="control-label" for="email">Email<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="email" name="email"  id="email"  class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label" for="website">Web Site<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="text" name="website" id="website" class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label" for="saldo">Saldo<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="number" name="saldo" id="saldo" class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label class="control-label" for="gestor">Gestor</label>
                                                <div class="">
                                                    <select style="height: 34px" class="col-md-12 col-xs-12  col-sm-4" id="gestor" name="gestor_id">
                                                        <option value="">-----</option>
                                                        <option value="1">Gestor 1</option>
                                                    </select>                                                
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="control-label" for="pais_id">País</label>
                                                <div class="">
                                                    <select style="height: 34px" class="col-md-12 col-xs-12 col-sm-4" id="pais_id" name="pais_id">

                                                        <option value="">-----</option>
                                                        <option value="1">Angola</option>
                                                    </select>                                                
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="control-label" for="nome">NIF<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="text" name="nif" id="nif"  class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label class="control-label" for="tipo_cliente">Tipo Cliente</label>
                                                <div class="">
                                                    <select style="height: 34px" class="col-md-12 col-xs-12 col-sm-4" id="tipo_cliente_id" name="tipo_cliente_id">

                                                        <option value="">-----</option>
                                                        <option value="1">Singular</option>
                                                    </select>                                                
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <input type="file" class="control" name="foto" id="">
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