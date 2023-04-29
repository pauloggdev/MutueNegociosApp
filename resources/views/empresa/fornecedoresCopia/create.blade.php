@extends('layout.appEmpresa')
@section('title','Adicionar Fornecedores')
@section('content')

<section class="content">

    <div class="page-header">
        <h1>Adicionar Fornecedores</h1>
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
                                                <label class="control-label" for="nome">Nome<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="text" name="nome" id="nome" required class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label" for="telefone_empresa">Telefone empresa</label>
                                                <div class="">
                                                    <input type="text" name="telefone_empresa" id="telefone_empresa" class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label" for="email_empresa">Email empresa<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="email" name="email_empresa" required id="endereco" class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label class="control-label" for="nif">NIF<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="text" name="nif" required id="nif" required class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label" for="website">Web Site<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="text" name="website" required id="website" class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label" for="pessoa_contacto">Pessoa Contacto<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="text" name="pessoa_contacto" id="pessoa_contacto" class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-4">
                                                <label class="control-label" for="telefone_contacto">Telefone contacto<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="text" name="telefone_contacto" id="telefone_contacto" class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label" for="email_contacto">Email Contacto<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                <div class="">
                                                    <input type="text" name="email_contacto" id="email_contacto" class="col-md-12 col-xs-12  col-sm-4" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label" for="canal_id">Canal</label>
                                                <div class="">
                                                    <select style="height: 34px" class="col-md-12 col-xs-12  col-sm-4" id="canal_id" name="canal_id">
                                                        <option value="">-----</option>
                                                        <option value="1">Canal 1</option>
                                                    </select>                                                
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="form-group">

                                            <div class="col-md-4">
                                                <label class="control-label" for="status_id">Status</label>
                                                <div class="">
                                                    <select style="height: 34px" class="col-md-12 col-xs-12  col-sm-4" id="status_id" name="status_id">
                                                        <option value="">-----</option>
                                                        <option value="1">Status 1</option>
                                                    </select>                                                
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="id-date-picker-1">Date Contracto</label>
                                                <div class="input-group">

                                                <input class="form-control date-picker" autocomplete="off" style="height: 35px;" autocomplete="off" id="id-date-picker-1" type="text" name="data_contracto" data-date-format="dd-mm-yyyy" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-calendar bigger-110"></i>
                                                </span>
                                            </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="control-label" for="tipo_cliente">País Nacionalidade</label>
                                                <div class="">
                                                    <select style="height: 34px;" class="col-md-12 col-xs-12 col-sm-4" id="pais_nacionalidade" name="pais_nacionalidade_id">
                                                        <option value="">-----</option>
                                                        <option value="1">Angola</option>
                                                    </select>                                                
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


