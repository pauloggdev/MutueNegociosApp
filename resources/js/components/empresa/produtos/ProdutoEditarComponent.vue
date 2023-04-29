<template>
<section class="content">
    <div class="row">
        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                EDITAR PRODUTOS
            </h1>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <!-- AVISO -->
                <div class="alert alert-warning hidden-sm hidden-xs">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    Os campos marcados com
                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span>
                    são de preenchimento obrigatório.
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-md-12">
                <div class="search-form-text">
                    <div class="search-text">
                        <i class="fa fa-product-hunt"></i>
                        Dados Referentes ao Produto e serviços
                    </div>
                </div>
                <form method="POST" enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                    <div class="second-row">
                        <div class="tabbable">
                            <div class="tab-content profile-edit-tab-content">
                                <div id="dados_fornecedor" class="tab-pane in active" style="">
                                    <!-- INICIO  -->
                                    <h4 class="header bolder smaller" style="color: #3d5476">
                                        Geral
                                    </h4>
                                    <div>
                                        <div class="form-group has-info bold" style="left: 0%; position: relative">
                                            <div class="col-md-6">
                                                <label class="control-label bold label-select2" for="designacao">Nome do Produto<b class="red fa fa-question-circle"></b></label>
                                                <div class="input-group">
                                                    <input type="text" v-model="produto.designacao" :class="errors.designacao ? 'has-error' : ''" id="designacao" class="col-md-12 col-xs-12 col-sm-4" />
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                    </span>
                                                </div>
                                                <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span>
                                            </div>

                                            <div>
                                                <div class="col-md-6">
                                                    <label class="control-label bold label-select2" for="total">Código de Barras</label>

                                                    <div class="input-group">
                                                        <input type="text" v-model="produto.codigo_barra" id="total" class="col-md-12 col-xs-12 col-sm-3" required />
                                                        <span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-barcode bigger-110 text-info"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group has-info bold" style="left: 0%; position: relative">
                                            <div class="col-md-6">
                                                <label class="control-label bold label-select2" for="categoria_id">Categoria<b class="red"></b></label>
                                                    <Select2 :options="optionsCategorias" v-model="produto.categoria_id" id="categoria_id" style="width: 100%" placeholder="Escolha a Categoria do Produto">
                                                    </Select2>
                                                    <a href="#criar_categoria" data-toggle="modal" class="pull-right" style="margin-top: -27px; position: relative">
                                                        <i class="fa icofont-plus-circle bigger-150" style="color: #337ab7"></i>
                                                    </a>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="control-label bold label-select2" for="status_id">Status<b class="red fa fa-question-circle"></b></label>
                                                <Select2 :options="optionsStatus" v-model="produto.status_id" id="status_id" style="width: 100%">
                                                </Select2>
                                            </div>
                                        </div>
                                        <h4 class="header bolder smaller" style="color: #3d5476">
                                            Vendas
                                        </h4>

                                        <div>
                                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                                <div class="col-md-3">
                                                    <label class="control-label bold label-select2" for="preco_compra">Preço de Compra<b class="red fa fa-question-"></b></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">Kz</div>
                                                        <input v-model.number="produto.preco_compra" type="number" class="form-control" id="preco_compra" data-target="form_supply_price" style="height: 35px; font-size: 13pt" />
                                                        <span class="input-group-addon" id="basic-addon1">
                                                            <i class="fa fa-calculator price-popup-icon" data-target="form_supply_price_smartprice"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="control-label bold label-select2" for="margem_lucro">Margem<b class="red fa fa-question-"></b></label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon">%</div>
                                                        <input v-model.number="margem_lucro" disabled type="number" class="markup form-control" id="margem_lucro" title="Margem de lucro que pretende ter na venda do produto." style="height: 35px; font-size: 13pt" />
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="control-label bold label-select2" for="preco_venda">Preço de Venda<b class="red fa fa-question-circle"></b></label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon">Kz</div>
                                                        <input v-model.number="produto.preco_venda" :class="errors.preco_venda ? 'has-error' : ''" id="preco_venda" type="number" class="price_with_tax form-control" title="Preço de venda ao público calculado com imposto." style="height: 35px; font-size: 13pt" />
                                                    </div>
                                                    <span v-if="errors.preco_venda" class="error">{{errors.preco_venda[0]}}</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="control-label bold" for="id-date-picker-1">Data de Expiração</label>
                                                    <div class="input-group">
                                                        <date-pick v-model="produto.data_expiracao" :format="'DD-MM-YYYY'"></date-pick>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                                <div class="col-md-6">
                                                    <label class="control-label bold label-select2" for="codigo_taxa">Imposto/Taxas<b class="red fa fa-question-circle"></b></label>

                                                    <Select2 :options="optionsTaxas" v-model="produto.codigo_taxa" @select="selecionarTaxa" :class="errors.codigo_taxa ? 'has-error' : ''" id="codigo_taxa" style="width: 100%" placeholder="Escolha o valor da taxa">
                                                    </Select2>
                                                    <span v-if="errors.codigo_taxa" class="error">{{errors.codigo_taxa[0]}}</span>

                                                </div>

                                                 <div class="col-md-6">
                                                    <label class="control-label bold label-select2" for="motivo_isencao_id">Motivo de Isenção<b class="red fa fa-question-circle"></b></b></label>
                                                    <Select2 :options="optionsMotivos" v-model="produto.motivo_isencao_id" :disabled="disabledMotivos" :class="errors.motivo_isencao_id ? 'has-error' : ''
                                                                " id="motivo_isencao_id" style="width: 100%" placeholder="Escolha o motivo de isenção">
                                                    </Select2>
                                                    <span v-if="errors.motivo_isencao_id" class="error">{{ errors.motivo_isencao_id[0] }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                                <div class="col-md-2">
                                                    <label class="control-label bold label-select2" for="spinner3">Qtd. Mínima</label>
                                                    <div class="input-icon" id="quantidade_minima">
                                                        <vue-numeric-input v-model="produto.quantidade_minima" :disabled="disabledInputs" :min="0" :step="1"></vue-numeric-input>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label bold label-select2" for="spinner4">Qtd. Crítica</label>
                                                    <div class="input-icon" id="quantidade_critica">
                                                        <vue-numeric-input v-model="produto.quantidade_critica" :disabled="disabledInputs" :min="0" :step="1"></vue-numeric-input>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label bold label-select2" for="controlo_stock">Controlar Stock
                                                        <b class="red fa fa-question-circle"></b></label>
                                                    <div class="">
                                                        <Select2 :options="controleStock" v-model="produto.stocavel" :class="errors.stocavel ? 'has-error' : ''" id="controlo_stock" @change="selecionarExistenciaStock">
                                                        </Select2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="header bolder smaller" style="color: #3d5476">
                                            Características
                                        </h4>
                                        <div>
                                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                                <div class="col-md-4">
                                                    <label class="control-label bold label-select2" for="unidade_id">Unidade<b class="red"></b></label>
                                                    <Select2 :options="optionsUnidadeMedidas" v-model="produto.unidade_medida_id" id="unidade_id" style="width: 100%" placeholder="Escolha a unidade do Produto">
                                                    </Select2>
                                                    <a href="#criar_unidade" data-toggle="modal" class="pull-right" style="margin-top: -27px; position: relative">
                                                        <i class="fa icofont-plus-circle bigger-150" style="color: #337ab7"></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-4">
                                                   

                                                    <label class="control-label bold label-select2" for="fabricante_id">Fabricante<b class="red fa fa-question-"></b></label>
                                                <Select2 :options="optionsFabricantes" v-model="produto.fabricante_id" id="fabricante_id" style="width: 100%" placeholder="Selecione o fabricante">
                                                </Select2>

                                                <a href="#criar_fabricante" data-toggle="modal" class="pull-right" style="margin-top: -27px; position: relative">
                                                    <i class="fa icofont-plus-circle bigger-150" style="color: #337ab7"></i>
                                                </a>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="control-label bold label-select2" for="marca_id">Marca<b class="red"></b></label>
                                                    <Select2 :options="optionsMarcas" v-model="produto.marca_id" id="marca_id" style="width: 100%" placeholder="Escolha a Marca do Produto">
                                                    </Select2>
                                                    <a href="#criar_marca" data-toggle="modal" class="pull-right" style="margin-top: -27px; position: relative">
                                                        <i class="fa icofont-plus-circle bigger-150" style="color: #337ab7"></i>
                                                    </a>
                                                </div>
                                            </div>

                                        </div>

                                        <h4 class="header bolder smaller" style="color: #3d5476">
                                            Dados adicionais
                                        </h4>
                                        <div class="form-group has-info bold" style="left: 0%; position: relative">
                                            <div class="col-md-6">
                                                <label class="control-label bold" for="descricao">Descrição</label>
                                                <div class="input-icon">
                                                    <i class="ace-icon fa fa-comment"></i>
                                                    <textarea type="text" v-model="produto.descricao" id="descricao" class="col-md-12 col-xs-12 col-sm-4"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="id-input-file-3" class="text-info">Imagem do Produto</label>
                                                <div class="file-upload-wrapper">

                                                    <input type="file" :value="produto.imagem_produto" accept="application/image/*" id="id-input-file-3">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- FIM -->
                                    </div>

                                    <!-- FIM -->
                                </div>
                            </div>
                        </div>

                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="search-btn" type="submit" style="border-radius: 10px" @click.prevent="salvar">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Salvar
                                </button>

                                &nbsp; &nbsp;
                                <button class="btn btn-danger" type="reset" style="border-radius: 10px">
                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        <!-- CRIAR fabricanteS -->
        <div id="criar_fabricante" class="modal fade">
            <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i>
                            Adicionar fabricante
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- AVISO -->
                                <div class="alert alert-warning hidden-sm hidden-xs">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    Os campos marcados com
                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span>
                                    são de preenchimento obrigatório.
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row" style="left: 0%; position: relative">
                            <div class="col-md-12">
                                <div class="search-form-text">
                                    <div class="search-text">
                                        <i class="fa fa-pencil"></i>
                                        Dados do fabricante
                                    </div>
                                </div>

                                <form enctype="multipart/form-data" class="filter-form form-horizontal" id>
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_fabricante">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados do fabricante
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_fabricante" class="tab-pane in active" style="left: 12%; position: relative">
                                                    <div class="form-group">
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="designacao">
                                                                Nome do fabricante
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="fabricante.designacao" id="designacao" class="col-md-12 col-xs-12 col-sm-4" :class="
                                      errors.designacao ? 'has-error' : ''
                                    " />
                                                                <span v-if="errors.designacao" class="error">{{ errors.designacao[0] }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-5">
                                                            <label class="control-label" for="status_id">
                                                                status
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <Select2 :options="optionsStatus" v-model="fabricante.status_id" style="width: 100%">
                                                                </Select2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix form-actions">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button class="search-btn" style="border-radius: 10px" data-dismiss="modal" @click.prevent="salvarFabricante">
                                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                                        Salvar
                                                    </button>
                                                    &nbsp; &nbsp;
                                                    <button class="btn btn-danger" type="reset" style="border-radius: 10px">
                                                        <i class="ace-icon fa fa-undo bigger-110"></i>
                                                        Cancelar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- Fim CRIAR Fabricante -->
        <!-- MODAL DE CRIAR unidades -->
        <div id="criar_unidade" class="modal fade criar_unidade">
            <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i>
                            Adicionar unidades
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- AVISO -->
                                <div class="alert alert-warning hidden-sm hidden-xs">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    Os campos unidadedos com
                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span>
                                    são de preenchimento obrigatório.
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row" style="left: 0%; position: relative">
                            <div class="col-md-12">
                                <div class="search-form-text">
                                    <div class="search-text">
                                        <i class="fa fa-pencil"></i>
                                        Dados da unidade
                                    </div>
                                </div>

                                <form method="POST" action enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_unidade" class="tab-pane in active">
                                                    <div class="row">
                                                        <div class="form-group has-info">
                                                            <br /><br />
                                                            <label style="padding-top: 10px" class="col-sm-3 control-label no-padding-right bold" for="designacao">Nome da unidade
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span>
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <input type="text" v-model="unidade.designacao" placeholder="Informe a unidade" class="col-xs-12" :class="
                                        errors.designacao ? 'has-error' : ''
                                      " id="designacao" style="" />
                                                                    <span v-if="errors.descricao" class="error">{{ errors.descricao[0] }}</span>
                                                                    <span class="input-group-addon">
                                                                        <i class="ace-icon fa fa-info bigger-150 text-info"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group has-info">
                                                            <label style="padding-top: 10px" class="col-sm-3 control-label no-padding-right bold" for="password">Status
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span></label>
                                                            <div class="col-md-6">
                                                                <div class>
                                                                    <Select2 :options="optionsStatus" v-model="unidade.status_id" placeholder="Selecione o status">
                                                                    </Select2>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" type="submit" style="border-radius: 10px" @click.prevent="salvarUnidade">
                                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                                    Salvar
                                                </button>
                                                &nbsp; &nbsp;
                                                <button class="btn btn-danger" type="reset" style="border-radius: 10px">
                                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--/ MODAL DE CRIAR unidades-->

        <!-- MODAL DE CRIAR categorias -->
        <div id="criar_categoria" class="modal fade criar_categoria">
            <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i>
                            Adicionar categorias
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- AVISO -->
                                <div class="alert alert-warning hidden-sm hidden-xs">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    Os campos marcados com
                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span>
                                    são de preenchimento obrigatório.
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row" style="left: 0%; position: relative">
                            <div class="col-md-12">
                                <div class="search-form-text">
                                    <div class="search-text">
                                        <i class="fa fa-pencil"></i>
                                        Dados do categoria
                                    </div>
                                </div>

                                <form method="POST" action enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_categoria" class="tab-pane in active">
                                                    <div class="row">
                                                        <div class="form-group has-info">
                                                            <br /><br />
                                                            <label style="padding-top: 10px" class="col-sm-3 control-label no-padding-right bold" for="designacao">Nome da Categoria
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span>
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <input type="text" v-model="categoria.designacao" placeholder="Informe a Categoria" class="col-xs-12" :class="
                                        errors.designacao ? 'has-error' : ''
                                      " id="designacao" style="" />
                                                                    <span v-if="errors.designacao" class="error">{{ errors.designacao[0] }}</span>
                                                                    <span class="input-group-addon">
                                                                        <i class="ace-icon fa fa-info bigger-150 text-info"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group has-info">
                                                            <label style="padding-top: 10px" class="col-sm-3 control-label no-padding-right bold" for="password">Status
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span></label>
                                                            <div class="col-md-6">
                                                                <div class>
                                                                    <Select2 :options="optionsStatus" v-model="categoria.status_id" placeholder="Selecione o status">
                                                                    </Select2>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" type="submit" style="border-radius: 10px" @click.prevent="salvarCategoria">
                                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                                    Salvar
                                                </button>
                                                &nbsp; &nbsp;
                                                <button class="btn btn-danger" type="reset" style="border-radius: 10px">
                                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--/ MODAL DE CRIAR categorias-->

        <!-- MODAL DE CRIAR marcas -->
        <div id="criar_marca" class="modal fade criar_marca">
            <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i>
                            Adicionar marcas
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- AVISO -->
                                <div class="alert alert-warning hidden-sm hidden-xs">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    Os campos marcados com
                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span>
                                    são de preenchimento obrigatório.
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="row" style="left: 0%; position: relative">
                            <div class="col-md-12">
                                <div class="search-form-text">
                                    <div class="search-text">
                                        <i class="fa fa-pencil"></i>
                                        Dados do marca
                                    </div>
                                </div>

                                <form method="POST" action enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_marca" class="tab-pane in active">
                                                    <div class="row">
                                                        <div class="form-group has-info">
                                                            <br /><br />
                                                            <label style="padding-top: 10px" class="col-sm-3 control-label no-padding-right bold" for="designacao">Nome da marca
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span>
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <input type="text" v-model="marca.designacao" placeholder="Informe a marca" class="col-xs-12" :class="
                                        errors.designacao ? 'has-error' : ''
                                      " id="designacao" style="" />
                                                                    <span v-if="errors.descricao" class="error">{{ errors.descricao[0] }}</span>
                                                                    <span class="input-group-addon">
                                                                        <i class="ace-icon fa fa-info bigger-150 text-info"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group has-info">
                                                            <label style="padding-top: 10px" class="col-sm-3 control-label no-padding-right bold" for="password">Status
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span></label>
                                                            <div class="col-md-6">
                                                                <div class>
                                                                    <Select2 :options="optionsStatus" v-model="marca.status_id" placeholder="Selecione o status">
                                                                    </Select2>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" type="submit" style="border-radius: 10px" @click.prevent="salvarMarca">
                                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                                    Salvar
                                                </button>
                                                &nbsp; &nbsp;
                                                <button class="btn btn-danger" type="reset" style="border-radius: 10px">
                                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--/ MODAL DE CRIAR marcas-->
    </div>
</section>
</template>

<script>
import axios from "axios";
import { showError, baseUrl } from "./../../../config/global";
import { mapState } from "vuex";
import Swal from "sweetalert2";
import Select2 from "v-select2-component";
import DatePick from "vue-date-pick";
import "vue-date-pick/dist/vueDatePick.css";
import "vue-multiselect/dist/vue-multiselect.min.css";
import VueNumericInput from "vue-numeric-input";
import Multiselect from "vue-multiselect";

export default {
  props: [
    "produto",
    "fabricantes",
    "status",
    "motivos",
    "unidademedidas",
    "categorias",
    "marcas",
    "guard",
    "taxas",
    "empresa",
  ],

  components: {
    Select2,
    DatePick,
    VueNumericInput,
    Multiselect,
  },
  data() {
    return {
      // produto:{},
      errors: [],
      fabricante: {},
      unidade: {},
      categoria: {},
      marca: {},
      margem_lucro: "",
      optionsFabricantes: [],
      optionsStatus: [],
      optionsTaxas: [],
      optionsMotivos: [],
      optionsUnidadeMedidas: [],
      optionsCategorias: [],
      optionsMarcas: [],
      disabledMotivos: false,
      controleStock: [
        {
          id: 1,
          text: "SIM",
        },
        {
          id: 2,
          text: "NÃO",
        },
      ],
      disabledInputs: this.produto.stocavel == "Sim" ? false : true,
      USUARIO_EMPRESA: 2,
      router: "",
    };
  },

  created() {
    //console.log(this.produto);return;
    this.listarTaxas();
    this.listarMotivos();
    this.listarStatus();
    this.listarFabricantes();
    this.listarUnidadeMedidas();
    this.listarCategorias();
    this.listarMarcas();
    this.router =
      this.guard.tipo_user_id == this.USUARIO_EMPRESA
        ? window.location.origin + `/empresa`
        : window.location.origin + `/empresa/funcionario`;
    this.produto.stocavel = this.produto.stocavel == "Sim" ? 1 : 2;

    this.setarTaxaMotivo();
  },

  mounted() {},

  methods: {
    setarTaxaMotivo() {
      if (this.produto.tipo_taxa.taxa > 0) {
        this.produto.motivo_isencao_id = null;
        this.disabledMotivos = true;
      }
      this.produto.taxa = this.produto.tipo_taxa.taxa;
    },

    selecionarTaxa(tx) {
      if (tx.taxa > 0) {
        this.produto.motivo_isencao_id = null;
        this.disabledMotivos = true;
        this.listarMotivos();
      } else {
        this.disabledMotivos = false;
      }
      this.produto.taxa = tx.taxa;
    },

    listarTaxas() {
      this.taxas.forEach((tx) => {
        this.optionsTaxas.push({
          id: tx.codigo,
          text: tx.descricao,
          taxa: tx.taxa,
        });
      });
      // this.produto.taxa = this.taxas[0].taxa
    },
    listarMotivos() {
      this.motivos.forEach((motivo) => {
        this.optionsMotivos.push({
          id: motivo.codigo,
          text: motivo.descricao,
        });
      });
    },
    listarUnidadeMedidas() {
      this.unidademedidas.forEach((unidade) => {
        this.optionsUnidadeMedidas.push({
          id: unidade.id,
          text: unidade.designacao,
        });
      });
    },
    listarCategorias() {
      this.categorias.forEach((categoria) => {
        this.optionsCategorias.push({
          id: categoria.id,
          text: categoria.designacao,
        });
      });
    },
    listarMarcas() {
      this.marcas.forEach((marca) => {
        this.optionsMarcas.push({
          id: marca.id,
          text: marca.designacao,
        });
      });
    },

    listarStatus() {
      this.status.forEach((statu) => {
        this.optionsStatus.push({
          id: statu.id,
          text: statu.designacao,
        });
      });
      this.fabricante.status_id = this.status[0].id;
      this.unidade.status_id = this.status[0].id;
      this.categoria.status_id = this.status[0].id;
      this.marca.status_id = this.status[0].id;
    },
    listarFabricantes() {
      this.fabricantes.forEach((fabricante) => {
        this.optionsFabricantes.push({
          id: fabricante.id,
          text: fabricante.designacao,
        });
      });
      // this.produto.fabricante_id = this.fabricantes[0].id
    },
    selecionarExistenciaStock(estocavel) {
      if (estocavel == 1) {
        //estocavel
        this.disabledInputs = false;
      } else {
        this.disabledInputs = true;
        this.produto.quantidade_minima = 0;
        this.produto.quantidade_critica = 0;
      }
    },
    salvarFabricante() {
      this.errors = [];
      axios
        .post(`${this.router}/fabricantes/adicionar`, this.fabricante)
        .then((response) => {
          if (response.status === 200) {
            this.$toasted.global.defaultSuccess();
            document.location.reload(true);
          }
        })
        .catch((error) => {
          this.$toasted.global.defaultError({
            msg: "Erro ao cadastrar",
          });
          this.errors = error.response.data.errors;
        });
    },

    salvarUnidade() {
      this.errors = [];
      axios
        .post(`${this.router}/unidades/adicionar`, this.unidade)
        .then((response) => {
          if (response.status === 200) {
            this.$toasted.global.defaultSuccess();
            document.location.reload(true);
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.$toasted.global.defaultError({
              msg: "Erro ao cadastrar",
            });
            this.errors = error.response.data.errors;
          }
        });
    },
    salvarCategoria() {
      this.errors = [];

      axios
        .post(`${this.router}/categorias/adicionar`, this.categoria)
        .then((response) => {
          if (response.status === 200) {
            this.$toasted.global.defaultSuccess();
            document.location.reload(true);
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.$toasted.global.defaultError({
              msg: "Erro ao cadastrar",
            });
            this.errors = error.response.data.errors;
          }
        });
    },
    salvarMarca() {
      this.errors = [];

      axios
        .post(`${this.router}/marcas/adicionar`, this.marca)
        .then((response) => {
          if (response.status === 200) {
            this.$toasted.global.defaultSuccess();
            document.location.reload(true);
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.$toasted.global.defaultError({
              msg: "Erro ao cadastrar",
            });
            this.errors = error.response.data.errors;
          }
        });
    },

    async salvar() {
      this.$loading(true);

      this.errors = [];

      let produto = {
        id: this.produto.id,
        designacao: this.produto.designacao,
        preco_venda: this.produto.preco_venda,
        preco_compra: this.produto.preco_compra,
        marca_id: this.produto.marca_id,
        categoria_id: this.produto.categoria_id,
        status_id: this.produto.status_id,
        unidade_medida_id: this.produto.unidade_medida_id,
        fabricante_id: this.produto.fabricante_id,
        codigo_taxa: this.produto.codigo_taxa,
        motivo_isencao_id: this.produto.motivo_isencao_id,
        quantidade_minima: this.produto.quantidade_minima,
        quantidade_critica: this.produto.quantidade_critica,
        imagem_produto: this.produto.imagem_produto,
        codigo_barra: this.produto.codigo_barra,
        descricao: this.produto.descricao,
        stocavel: this.produto.stocavel,
        // armazens: this.produto.existencia_estock,
        taxa: this.produto.taxa,
      };
      try {
        let response = await axios.post(
          `${this.router}/produtos/editar/${produto.id}`,
          produto
        );

        if (response.status == 200) {
          this.$toasted.global.defaultSuccess();
          Swal.fire({
            title: "Sucesso",
            text: "Produto registado com sucesso!",
            icon: "success",
            confirmButtonColor: "#3d5476",
            confirmButtonText: "Ok",
            onClose: () => {
              document.location.reload(true);
            },
          });

          this.reset();
        }
      } catch (error) {
        this.$loading(false);
        if (error.response.status === 400) {
          this.$toasted.global.defaultError({
            msg: "Erro ao cadastrar",
          });
          this.errors = error.response.data;
        }
      }
    },
  },
  watch: {},
};
</script>

<style>
#botoes {
  left: 0%;
  border-radius: 15px;
  margin-top: 0.1%;
  padding: 6px 12px 6px 12px;
  position: relative;
  text-transform: uppercase;
}

.vdpComponent.vdpWithInput > input {
  padding: 8px !important;
  width: 258px !important;
}

.numeric-input {
  text-align: center !important;
  padding: 8px !important;
  font-size: 15px !important;
  color: black !important;
}

.vue-numeric-input .btn:disabled {
  opacity: 1 !important;
}

.vue-numeric-input .btn-increment .btn-icon,
.btn.focus {
  background: #41b883 !important;
}

.vue-numeric-input .btn-decrement .btn-icon,
.btn.focus {
  background: #d15b47 !important;
}

.ui-accordion .ui-accordion-content {
  display: block;
}

.is-invalid,
.invalid-feedback {
  border-color: red;
  color: red;
}

.label-select2 {
  margin-bottom: 10px;
}

textarea {
  height: 123px;
}
</style>
