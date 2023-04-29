@extends('layout.appEmpresa')
@section('title','Listar Assinaturas')
@section('content')

<section class="content">
    <div class="row">
        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Assinaturas
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Listagem
                </small>
            </h1>
        </div><!-- /.page-header -->
    </div>

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
            <!-- PAGE CONTENT BEGINS -->
            <div class="clearfix">
                <div class="pull-right">
                    <span class="green middle bolder">Escolha a operação: &nbsp;</span>

                    <div class="btn-toolbar inline middle no-margin">
                        <div id="toggle-result-page" data-toggle="buttons" class="btn-group no-margin">
                            <label class="btn btn-sm btn-pink btn-xs active">
                                <i class="ace-icon glyphicon glyphicon-barcode bigger-130 bold"></i>
                                <span class="bigger-130 bold">SOLICITAR FACTURA</span>
                                <input type="radio" value="1" />
                            </label>

                            <label class="btn btn-sm btn-purple btn-xs">
                                <i class="ace-icon fa fa-shopping-cart bigger-150 bold"></i>
                                <span class="bigger-130 bold">COMPRAR LICENÇA</span>
                                <input type="radio" value="2" />
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hr dotted"></div>

            <div>
                <div class="row search-page" id="search-page-1">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-3">
                                <div class="search-area well well-sm">
                                    <div class="search-filter-header bg-primary">
                                        <h5 class="smaller no-margin-bottom">
                                            <i class="ace-icon fa fa-sliders light-green bigger-130"></i>&nbsp; Complementos
                                        </h5>
                                    </div>

                                    <div class="space-10"></div>

                                    <form>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-11 col-md-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="keywords" placeholder="Look within results" />
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-default no-border btn-sm">
                                                            <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="hr hr-dotted"></div>

                                    <h4 class="blue smaller">
                                        <i class="fa fa-tags"></i>
                                        Categoria
                                    </h4>

                                    <div class="tree-container">
                                        <ul id="cat-tree">
                                            <li>A</li>
                                            <li>A</li>
                                            <li>A</li>
                                        </ul>
                                    </div>

                                    <div class="hr hr-dotted hr-24"></div>

                                    <div class="text-center">
                                        <button type="button" class="btn btn-default btn-round btn-sm btn-white">
                                            <i class="ace-icon fa fa-remove red2"></i>
                                            Reset
                                        </button>

                                        <button type="button" class="btn btn-default btn-round btn-white">
                                            <i class="ace-icon fa fa-refresh green"></i>
                                            Update
                                        </button>
                                    </div>

                                    <div class="space-4"></div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-9">
                                <div class="row">
                                    <div class="col-xs-12">
                                        @foreach($licencas as $licenca)
                                        <?php
                                        if ($licenca->tipoLicenca->designacao == 'Anual') {
                                            $color = 'blue';
                                            $btn = 'primary';
                                        } elseif ($licenca->tipoLicenca->designacao == 'Mensal') {
                                            $color = 'green';
                                            $btn = 'success';
                                        } else {
                                            $color = 'red';
                                            $btn = 'danger';
                                        }
                                        ?>
                                        <div class="media search-media" style="border-radius: bold">
                                            <div class="media-left">
                                                <a href="#">
                                                    <img src="{{url('assets/images/placeholder/geradorsenha.png')}}" class="media-object" data-src="holder.js/72x72" />
                                                </a>
                                            </div>

                                            <div class="media-body">
                                                <div>
                                                    <h4 class="media-heading">
                                                        <a href="#" class="{{$color}}" style="font-weight: bolder">{{$licenca->licenca}}</a>
                                                    </h4>
                                                </div>
                                                <p>{{$licenca->descricao}}</p>

                                                <div class="search-actions text-center">
                                                    <span class="text-info">Kz</span>
                                                    <span class="blue bolder bigger-150">{{$licenca->tipoLicenca->valor?$licenca->tipoLicenca->valor:Null}}</span>
                                                    {{$licenca->tipoLicenca->designacao?$licenca->tipoLicenca->designacao:Null}}
                                                    <div class="action-buttons bigger-125">
                                                        <a href="#">
                                                            <i class="ace-icon fa fa-star-half-o orange2"></i>
                                                        </a>
                                                        <a href="#">
                                                            <i class="ace-icon fa fa-star-half-o orange2"></i>
                                                        </a>
                                                        <a href="#">
                                                            <i class="ace-icon fa fa-star light-grey"></i>
                                                        </a>
                                                        <a href="#">
                                                            <i class="ace-icon fa fa-star light-grey"></i>
                                                        </a>
                                                        <a href="#">
                                                            <i class="ace-icon fa fa-star light-grey"></i>
                                                        </a>
                                                    </div>
                                                    
                                                    <a href="#" data-target=".solicita_factura{{$licenca->id}}" data-toggle="modal" class="search-btn-action btn btn-sm btn-block btn-{{$btn}} bold">
                                                        <i class="ace-icon glyphicon glyphicon-print bold"></i>
                                                        Solicitar
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!--INICIO MODAL SOLICITAR FACTURA -->
                                        <div class="modal fade solicita_factura{{$licenca->id}}">
                                            <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                                                <div class="modal-content">
                                                    <div class="modal-header text-center">
                                                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                                                        <h3 class="smaller blue"><i class="ace-icon fa fa-barcode bigger-110 blue"></i> Solicitação da Factura</h3>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row" style="left: 0%; position: relative;">
                                                            <div class="col-md-12">

                                                                <div class="search-form-text">
                                                                    <div class="search-text">
                                                                        <i class="fa fa-info-circle bigger-150"></i>
                                                                        Informações preliminares da Factura
                                                                    </div>
                                                                </div>
                                                                <form method = 'POST' action='{{url('empresa/pedido-factura-licenca')}}/{{base64_encode($licenca->id)}}' enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">									
                                                                    <div>
                                                                        @csrf
                                                                        <input type = 'hidden' name = 'licenca_id' value = '{{$licenca->id}}'>
                                                                        <div class="second-row">
                                                                            <div class="form-group has-info">

                                                                                <div class="col-md-6">
                                                                                    <label class="control-label" for="designacao_licenca">Designação da Licença<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                                                    <div class="input-icon">
                                                                                        <input type="text" name="designacao_licenca" value="{{$licenca->licenca}}" class="form-control" id="designacao_licenca" autocomplete="off" style="height: 35px;" readonly="true"/>
                                                                                        <i class="ace-icon fa fa-key"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label class="control-label" for="tipo_licenca">Tipo de Licença<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                                                    <div class="input-icon">
                                                                                        <input type="text" name="tipo_licenca" id="tipo_licenca" value="{{$licenca->tipoLicenca->designacao?$licenca->tipoLicenca->designacao:Null}}"  class="col-md-12 col-xs-12  col-sm-4" readonly="" />
                                                                                        <i class="ace-icon fa fa-calendar-o"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="form-group has-info">
                                                                                <div class="col-md-6">
                                                                                    <label class="control-label" for="custo_licenca">Custo da Licença<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                                                    <div class="input-icon">
                                                                                        <input type="text" value="{{$licenca->tipoLicenca->valor}}" name="custo_licenca" id="custo_licenca" class="col-md-12 col-xs-12 col-sm-4" readonly/>
                                                                                        <i class="ace-icon fa fa-money"></i>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                                <div>
                                                                                    <div class="col-md-3">
                                                                                        <label class="control-label" for="quantidade">Quantidade</label>
                                                                                        <div class="input-icon">
                                                                                            <input type="number" name="quantidade" value="{{ old('quantidade')}}" class="form-control col-md-12 col-xs-12 col-sm-4"  id="spinner3" min="1" style="height: 35px;" required>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <label class="control-label" for="total">Total a Pagar<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                                                        <div class="input-icon">
                                                                                            <input type="number" name="total" id="total" value="{{$licenca->tipoLicenca->valor}}" class="col-md-12 col-xs-12 col-sm-4" required="" readonly/>
                                                                                            <i class="ace-icon fa fa-calculator"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="hr hr-18 dotted"></div>

                                                                            <div class="clearfix form-actions align-right">
                                                                                <div class="col-md-offset-3 col-md-9">
                                                                                    <button class="search-btn" type="submit" style="border-radius: 10px">
                                                                                        <i class="ace-icon fa fa-print bigger-110"></i>
                                                                                        Imprimir Factura
                                                                                    </button>

                                                                                    &nbsp; &nbsp;
                                                                                    <button class="btn btn-danger" type="reset" style="border-radius: 10px">
                                                                                        <i class="ace-icon fa fa-undo bigger-110"></i>
                                                                                        Cancelar
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="space"></div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div>
                                        <!--FIM MODAL SOLICITAR FACTURA -->
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SLIDE 2 COMPRA OU PAGAMENTO DAS LICENÇAS-->    
            <div class="hide">
                <div class="row search-page" id="search-page-2">
                    <div class="col-xs-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-3">
                                <div class="search-area well well-sm">
                                    <div class="search-filter-header bg-primary">
                                        <h5 class="smaller no-margin-bottom">
                                            <i class="ace-icon fa fa-sliders light-green bigger-130"></i>&nbsp; Complementos
                                        </h5>
                                    </div>

                                    <div class="space-10"></div>

                                    <form>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-11 col-md-10">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="keywords" placeholder="Look within results" />
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-default no-border btn-sm">
                                                            <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="hr hr-dotted"></div>

                                    <h4 class="blue smaller">
                                        <i class="fa fa-tags"></i>
                                        Categoria
                                    </h4>

                                    <div class="tree-container">
                                        <ul id="cat-tree">
                                            <li>A</li>
                                            <li>A</li>
                                            <li>A</li>
                                        </ul>
                                    </div>

                                    <div class="hr hr-dotted hr-24"></div>

                                    <div class="text-center">
                                        <button type="button" class="btn btn-default btn-round btn-sm btn-white">
                                            <i class="ace-icon fa fa-remove red2"></i>
                                            Reset
                                        </button>

                                        <button type="button" class="btn btn-default btn-round btn-white">
                                            <i class="ace-icon fa fa-refresh green"></i>
                                            Update
                                        </button>
                                    </div>

                                    <div class="space-4"></div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-9">
                                <div class="row">
                                    <div class="search-area well col-xs-12">
                                        <form class="form-search" method="get" action='{!!url("admin/usuarios")!!}'>
                                            <div class="row">
                                                <div class="">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-addon">
                                                            <i class="ace-icon fa fa-search"></i>
                                                        </span>

                                                        <input type="text" name="query" required autocomplete="on" class="form-control search-query" placeholder="Buscar Por armazen..."/>
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
                                </div>

                                <div class="row">
                                    @foreach($licencas as $licenca)
                                        <?php
                                        if ($licenca->tipoLicenca->designacao == 'Anual') {
                                            $color = 'blue';
                                            $btn = 'primary';
                                        } elseif ($licenca->tipoLicenca->designacao == 'Mensal') {
                                            $color = 'green';
                                            $btn = 'success';
                                        } else {
                                            $color = 'red';
                                            $btn = 'danger';
                                        }
                                        ?>
                                    <div class="col-xs-6 col-sm-4 pricing-box">
                                        <div class="widget-box widget-color-{{$color}}">
                                            <div class="widget-header">
                                                <h5 class="widget-title bigger lighter">{{$licenca->licenca}}</h5>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <ul class="list-unstyled spaced2">
                                                        <li style="text-align: center">
                                                            <i class="ace-icon fa fa-check green"></i>
                                                            {{$licenca->descricao}}
                                                        </li>
                                                    </ul>

                                                    <hr />
                                                    <div class="price">
                                                        {{$licenca->tipoLicenca->valor}} kz<small>/{{$licenca->tipoLicenca->designacao}}</small>
                                                    </div>
                                                </div>

                                                <div>
                                                    <a href="#" data-target=".modal_comprar{{$licenca->id}}"  data-toggle="modal" class="btn btn-block btn-{{$btn}}">
                                                        <i class="ace-icon fa fa-shopping-cart bigger-110"></i>
                                                        <span>Comprar</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!--INICIO MODAL COMPRAR LICENÇA -->
                                    <div class="modal fade modal_comprar{{$licenca->id}}">
                                        <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                                            <div class="modal-content">
                                                <div class="modal-header text-center">
                                                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                                                    <h3 class="smaller bold blue"><i class="ace-icon fa fa-paypal bigger-150 blue"></i> Efectuar Pagamento</h3>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row" style="left: 0%; position: relative;">
                                                        <div class="col-md-12">

                                                            <div class="search-form-text">
                                                                <div class="search-text">
                                                                    <i class="fa fa-money"></i>
                                                                    Dados do Pagamento
                                                                </div>
                                                            </div>
                                                            <form method = 'POST' action='{{url('empresa/pedido-licenca')}}/{{base64_encode($licenca->id)}}' enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">									
                                                                <div>
                                                                    @csrf
                                                                    <div class="second-row">
                                                                        <div class="form-group has-info">
                                                                            <div class="col-md-6">
                                                                                <label class="control-label" for="id-date-picker-1">Data Pago no Banco<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                                                <div class="input-icon">
                                                                                    <input type="text" name="data_pago_banco" class="form-control date-picker" id="id-date-picker-1" data-date-format="yyyy-mm-dd" required autocomplete="off" style="height: 35px;"/>
                                                                                    <i class="ace-icon fa fa-calendar"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="control-label" for="numero_operacao_bancaria">Nº Operação Bancária<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                                                <div class="input-icon">
                                                                                    <input type="text" name="numero_operacao_bancaria" id="numero_operacao_bancaria"  class="col-md-12 col-xs-12  col-sm-4" required />
                                                                                    <i class="ace-icon fa fa-credit-card"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="form-group has-info">
                                                                            <div class="col-md-6">
                                                                                <label class="control-label" for="forma_pagamento">Forma de Pagamento<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                                                <div class="input-icon">
                                                                                    <select name="forma_pagamento" class="col-md-12 col-xs-12 col-sm-4 select2" id="forma_pagamento" data-placeholder="Selecione a forma pagamento" required>
                                                                                        <option value=""></option>
                                                                                        <option value="1">TPA</option>
                                                                                        <option value="2">DEPOSITO</option>
                                                                                        <option value="3">TRANSFERÊNCIA</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label class="control-label" for="conta_movimentada">Conta Movimentada<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                                                <div class="input-icon">
                                                                                    <select class="col-md-12 col-xs-12 col-sm-4 select2" id="conta_movimentada" name="conta_movimentada" data-placeholder="Selecione a conta movimentar" required>
                                                                                        <option value=""></option>
                                                                                        <option value="1">BFA</option>
                                                                                        <option value="2">SOL</option>
                                                                                        <option value="3">BPC</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="form-group has-info">
                                                                            <div class="col-md-6">
                                                                                <label class="control-label" for="valorDepositado">Valor Pago no Banco<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label> 
                                                                                <div class="input-icon">
                                                                                    <input type="number" value="{{$licenca->tipoLicenca->valor}}" name="valorDepositado" min="{{$licenca->tipoLicenca->valor}}" id="valorDepositado" class="col-md-12 col-xs-12 col-sm-4" required />
                                                                                    <i class="ace-icon fa fa-money"></i>
                                                                                </div>
                                                                            </div>
                                                                            <row>
                                                                                <div class="col-md-3">
                                                                                    <label class="control-label" for="quantidade">Quantidade</label>
                                                                                    <div class="input-icon">
                                                                                        <input type="number" name="quantidade" value="{{ old('quantidade')}}" class="form-control col-md-12 col-xs-12 col-sm-4" id="spinner4" min="1" style="height: 35px;" required>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label class="control-label" for="total">Valor a Pagar<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                                                    <div class="input-icon">
                                                                                        <input type="number" name="total" id="total" value="{{$licenca->tipoLicenca->valor}}" min="{{$licenca->tipoLicenca->valor}}" class="col-md-12 col-xs-12 col-sm-4" required="" readonly/>
                                                                                        <i class="ace-icon fa fa-calculator"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </row>
                                                                        </div>
                                                                        
                                                                        <div class="hr hr-18 dotted"></div>

                                                                        <div class="form-group has-info">
                                                                            
                                                                            <div class="col-md-6">
                                                                                <label class="control-label" for="observacao">Observação<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                                                <div class="input-icon">
                                                                                    <i class="ace-icon fa fa-comment"></i>
                                                                                    <textarea type="text" name="observacao" id="observacao" class="col-md-12 col-xs-12 col-sm-4"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                            <div class="col-md-6">
                                                                                <div class="widget-box">
                                                                                    <div class="widget-header">
                                                                                        <h4 class="widget-title">Anexar o talão do banco</h4>

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
                                                                                                <div class="col-mb-10">
                                                                                                    <input name="foto" type="file" accept="image/*" id="id-input-file-2" value="" required/>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="clearfix form-actions align-right">
                                                                            <div class="col-md-offset-3 col-md-9">
                                                                                <button class="search-btn" type="submit" style="border-radius: 10px">
                                                                                    <i class="ace-icon fa fa-money bigger-110"></i>
                                                                                    Efectuar Pagamento
                                                                                </button>

                                                                                &nbsp; &nbsp;
                                                                                <button class="btn btn-danger" type="reset" style="border-radius: 10px">
                                                                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                                                                    Cancelar
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="space"></div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>
                                    <!--FIM MODAL COMPRAR LICENÇA -->
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</section>

@endsection
