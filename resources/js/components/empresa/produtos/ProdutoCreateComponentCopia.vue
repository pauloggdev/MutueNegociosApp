<template>
<section class="content">
    <div class="row">
        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                CADASTRO DE PRODUTOS
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Cadastro
                </small>
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
                                                <!-- <div class="col-md-3">
                                                    <label class="control-label bold label-select2" for="referencia">Referência<b class="red fa fa-question-"></b></label>
                                                    <div class="input-group">
                                                        <input type="text" v-model="produto.referencia" id="referencia" class="col-md-12 col-xs-12 col-sm-3" required />
                                                        <span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-qrcode bigger-110 text-info"></i>
                                                        </span>
                                                    </div>
                                                </div> -->

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
                                                <label class="control-label bold label-select2" for="fabricante_id">Fabricantes<b class="red fa fa-question-"></b></label>
                                                <Select2 :options="fabricantes" v-model="produto.fabricante_id" id="fabricante_id" style="width: 100%" placeholder="Selecione o fabricante">
                                                </Select2>

                                                <a v-if="guard.tipo_user_id == 2" href="#criar_fabricante" data-toggle="modal" class="pull-right" style="margin-top: -27px; position: relative">
                                                    <i class="fa icofont-plus-circle bigger-150" style="color: #337ab7"></i>
                                                </a>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="control-label bold label-select2" for="status_id">Status<b class="red fa fa-question-circle"></b></label>
                                                <Select2 :options="statusGerais" v-model="produto.status_id" id="status_id" style="width: 100%">
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
                                                        <input v-model.number="preco_compra" type="number" class="form-control" id="preco_compra" data-target="form_supply_price" style="height: 35px; font-size: 13pt" />
                                                        <span class="input-group-addon" id="basic-addon1">
                                                            <i class="fa fa-calculator price-popup-icon" data-target="form_supply_price_smartprice"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <label class="control-label bold label-select2" for="margem_lucro">Margem<b class="red fa fa-question-"></b></label>

                                                    <div class="input-group">
                                                        <div class="input-group-addon">%</div>
                                                        <input v-model.number="margem_lucro" type="number" class="markup form-control" id="margem_lucro" title="Margem de lucro que pretende ter na venda do produto." style="height: 35px; font-size: 13pt" />
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
                                                        <date-pick v-model="produto.data_expiracao" :format="'YYYY-MM-DD'"></date-pick>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                                <div class="col-md-6">
                                                    <label class="control-label bold label-select2" for="codigo_taxa">Imposto/Taxas<b class="red fa fa-question-circle"></b></label>
                                                    <!-- <Select2 :options="taxas" v-model="produto.codigo_taxa" :class="errors.codigo_taxa?'has-error':''" id="codigo_taxa" @change="checkTaxa($event)" style="width:100%" placeholder="Escolha o valor da taxa">
                                                </Select2> -->
                                                    <!-- <Select2 :options="taxas" v-model="produto.codigo_taxa" :class="errors.codigo_taxa ? 'has-error' : ''" id="codigo_taxa" @change="desabilitarCampoMotivo" style="width: 100%" placeholder="Escolha o valor da taxa">
                                                    </Select2> -->
                                                    <Select2 :options="taxas" v-model="produto.codigo_taxa" :class="errors.codigo_taxa ? 'has-error' : ''" id="codigo_taxa" @select="checkTaxa" style="width: 100%" placeholder="Escolha o valor da taxa">
                                                    </Select2>
                                                    <span v-if="errors.codigo_taxa" class="error">{{errors.codigo_taxa[0]}}</span>

                                                </div>

                                                <div class="col-md-6">
                                                    <label class="control-label bold label-select2" for="motivo_isencao_id">Motivo de Isenção<b class="red fa fa-question-circle"></b></b></label>
                                                    <!-- <Select2 :options="motivos" v-model="produto.motivo_isencao_id" :class="errors.motivo_isencao_id ? 'has-error' : ''
                                                                " id="motivo_isencao_id" @change="desabilitarCampoTaxa" style="width: 100%" placeholder="Escolha o motivo de isenção">
                                                    </Select2> -->
                                                    <Select2 :options="motivos" v-model="produto.motivo_isencao_id" :class="errors.motivo_isencao_id ? 'has-error' : ''
                                                                " id="motivo_isencao_id" style="width: 100%" placeholder="Escolha o motivo de isenção">
                                                    </Select2>
                                                    <span v-if="errors.motivo_isencao_id" class="error">{{ errors.motivo_isencao_id[0] }}</span>
                                                </div>
                                            </div>
                                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                                <div class="col-md-2">
                                                    <label class="control-label bold label-select2" for="spinner3">Qtd. Mínima</label>
                                                    <div class="input-icon" id="quantidade_minima">
                                                        <vue-numeric-input v-model="produto.quantidade_minima" :min="0" :step="1"></vue-numeric-input>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label bold label-select2" for="spinner4">Qtd. Crítica</label>
                                                    <div class="input-icon" id="quantidade_critica">
                                                        <vue-numeric-input v-model="produto.quantidade_critica" :min="0" :step="1"></vue-numeric-input>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label bold label-select2" for="controlo_stock">Controlar Stock
                                                        <b class="red fa fa-question-circle"></b></label>
                                                    <div class="">
                                                        <Select2 :options="controleStock" v-model="produto.stocavel" :class="errors.stocavel ? 'has-error' : ''" id="controlo_stock" @change="desabilitarCampoExistenciaStock">
                                                        </Select2>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="control-label bold label-select2" for="spinner3">Exitência no Stock</label>
                                                    <div class="input-icon">
                                                        <vue-numeric-input v-model="produto.quantidade" :min="0" :step="1" id="quantidade" :class="errors.stocavel ? 'has-error' : ''"></vue-numeric-input>
                                                        <span v-if="errors.stocavel" class="error">{{errors.stocavel[0]}}</span>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-4">
                                                    <label class="control-label bold label-select2" for="tipo_stock">Tipo de Stock <b class="red fa fa-question-"></b></label>
                                                    <Select2 :options="tipoStocagens" v-model="produto.tipo_stocagem_id" id="tipo_stock" placeholder="Escola o tipo de Stock">
                                                    </Select2>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <h4 class="header bolder smaller" style="color: #3d5476">
                                        Armazém / Loja
                                    </h4>
                                    <div>
                                        <div class="form-group has-info bold" style="left: 0%; position: relative">
                                            <div class="col-md-12">
                                                <div>
                                                    <label class="control-label bold label-select2" for="controlo_stock">Armazéns<b class="red fa fa-question-circle"></b></label>
                                                    <multiselect v-model="produto.armazens" :class="errors.armazens ? 'has-error' : ''" tag-placeholder="Add this as new tag" placeholder="Selecione o Armazém" label="designacao" track-by="id" :options="options_armazens" :multiple="true" :taggable="true" @tag="addTag" selectLabel="Pressione enter para selecionar" deselectLabel="Pressione enter para remover"></multiselect>
                                                    <span v-if="errors.armazens" class="error">{{errors.armazens[0]}}</span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="header bolder smaller" style="color: #3d5476">
                                        Características
                                    </h4>
                                    <div>
                                        <div class="form-group has-info bold" style="left: 0%; position: relative">
                                            <!-- <div class="col-md-6">
                                                <label class="control-label bold label-select2" for="classe_id">Classe de Bem<b class="red"></b></label>
                                                <Select2 :options="classes" v-model="produto.classe_id" id="classe_id" style="width: 100%" placeholder="Escolha a classe de bem do Produto">
                                                </Select2>
                                                <a href="#criar_classe" data-toggle="modal" class="pull-right" style="margin-top: -27px; position: relative">
                                                    <i class="fa icofont-plus-circle bigger-150" style="color: #337ab7"></i>
                                                </a>
                                            </div> -->

                                            <div class="col-md-4">
                                                <label class="control-label bold label-select2" for="unidade_id">Unidade<b class="red"></b></label>
                                                <Select2 :options="unidadeMedidas" v-model="produto.unidade_medida_id" id="unidade_id" style="width: 100%" placeholder="Escolha a unidade do Produto">
                                                </Select2>
                                                <a href="#criar_unidade" data-toggle="modal" class="pull-right" style="margin-top: -27px; position: relative">
                                                    <i class="fa icofont-plus-circle bigger-150" style="color: #337ab7"></i>
                                                </a>
                                            </div>
                                             <div class="col-md-4">
                                                <label class="control-label bold label-select2" for="categoria_id">Categoria<b class="red"></b></label>
                                                <Select2 :options="categorias" v-model="produto.categoria_id" id="categoria_id" style="width: 100%" placeholder="Escolha a Categoria do Produto">
                                                </Select2>
                                                <a href="#criar_categoria" data-toggle="modal" class="pull-right" style="margin-top: -27px; position: relative">
                                                    <i class="fa icofont-plus-circle bigger-150" style="color: #337ab7"></i>
                                                </a>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label bold label-select2" for="marca_id">Marca<b class="red"></b></label>
                                                <Select2 :options="marcas" v-model="produto.marca_id" id="marca_id" style="width: 100%" placeholder="Escolha a Marca do Produto">
                                                </Select2>
                                                <a href="#criar_marca" data-toggle="modal" class="pull-right" style="margin-top: -27px; position: relative">
                                                    <i class="fa icofont-plus-circle bigger-150" style="color: #337ab7"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="form-group has-info bold" style="left: 0%; position: relative">
                                            <!-- <div class="col-md-6">
                                                <label class="control-label bold label-select2" for="categoria_id">Categoria<b class="red"></b></label>
                                                <Select2 :options="categorias" v-model="produto.categoria_id" id="categoria_id" style="width: 100%" placeholder="Escolha a Categoria do Produto">
                                                </Select2>
                                                <a href="#criar_categoria" data-toggle="modal" class="pull-right" style="margin-top: -27px; position: relative">
                                                    <i class="fa icofont-plus-circle bigger-150" style="color: #337ab7"></i>
                                                </a>
                                            </div> -->

                                            <!-- <div class="col-md-6">
                                                <label class="control-label bold label-select2" for="marca_id">Marca<b class="red"></b></label>
                                                <Select2 :options="marcas" v-model="produto.marca_id" id="marca_id" style="width: 100%" placeholder="Escolha a Marca do Produto">
                                                </Select2>
                                                <a href="#criar_marca" data-toggle="modal" class="pull-right" style="margin-top: -27px; position: relative">
                                                    <i class="fa icofont-plus-circle bigger-150" style="color: #337ab7"></i>
                                                </a>
                                            </div> -->
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

                                                <input type="file" :value="produto.imagem_produto" accept="application/image/*" id="id-input-file-3" >
                                                <!-- <input type="file" :v-model="produto.imagem_produto" accept="application/pdf,image/*" id="id-input-file-3" class="imagem" /> -->
                                            </div>
                                        </div>
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
        <!-- /.row -->

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
                                                                <Select2 :options="statusGerais" v-model="fabricante.status_id" style="width: 100%">
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

        <!-- MODAL DE CRIAR classes -->
        <div id="criar_classe" class="modal fade criar_classe">
            <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">
                            ×
                        </button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i>
                            Adicionar classes
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
                                    Os campos classedos com
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
                                        Dados do classe
                                    </div>
                                </div>

                                <form method="POST" action enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_classe" class="tab-pane in active">
                                                    <div class="row">
                                                        <div class="form-group has-info">
                                                            <br /><br />
                                                            <label style="padding-top: 10px" class="col-sm-3 control-label no-padding-right bold" for="designacao">Nome da classe
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span>
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <input type="text" v-model="classe.designacao" placeholder="Informe a classe" class="col-xs-12" :class="
                                        errors.designacao ? 'has-error' : ''
                                      " id="designacao" required style="" />
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
                                                                    <Select2 :options="statusGerais" v-model="classe.status_id" placeholder="Selecione o status">
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
                                                <button class="search-btn" type="submit" style="border-radius: 10px" data-dismiss="modal" @click.prevent="salvarClasse">
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
        <!--/ MODAL DE CRIAR classes-->

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
                                      " id="designacao" required style="" />
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
                                                                    <Select2 :options="statusGerais" v-model="unidade.status_id" placeholder="Selecione o status">
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
                                      " id="designacao" required style="" />
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
                                                                    <Select2 :options="statusGerais" v-model="categoria.status_id" placeholder="Selecione o status">
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
                                      " id="designacao" required style="" />
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
                                                                    <Select2 :options="statusGerais" v-model="marca.status_id" placeholder="Selecione o status">
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
import {
    showError,
    baseUrl
} from "./../../../config/global";
import {
    mapState
} from "vuex";
import Swal from "sweetalert2";
import Select2 from "v-select2-component";
import DatePick from "vue-date-pick";
import "vue-date-pick/dist/vueDatePick.css";
import "vue-multiselect/dist/vue-multiselect.min.css";
import VueNumericInput from "vue-numeric-input";
import Multiselect from "vue-multiselect";

export default {
    props: ["produtos", "status", "guard", "empresa"],

    components: {
        Select2,
        DatePick,
        VueNumericInput,
        Multiselect,
    },
    data() {
        return {
            fabricante: {
                status_id: 1,
            },
            classe: {
                status_id: 1, //inicia com status do select2 ativo
            },
            unidade: {
                status_id: 1, //inicia com status do select2 ativo
            },
            categoria: {
                status_id: 1, //inicia com status do select2 ativo
            },
            marca: {
                status_id: 1, //inicia com status do select2 ativo
            },
            errors: [],
            produto: {
                designacao: "",
                referencia: "",
                codigo_barra: "",
                fabricante_id: "",
                status_id: 1,
                preco_compra: "",
                margem_lucro: "",
                preco_venda: "",
                data_expiracao: "",
                codigo_taxa: "",
                taxa: "",
                motivo_isencao_id: "",
                quantidade_minima: 0,
                quantidade_critica: 0,
                stocavel: 1,
                quantidade: 0,
                classe_id: "",
                unidade_medida_id: "",
                categoria_id: "",
                marca_id: "",
                armazens: [],
                descricao: "",
                imagem_produto: "",
                data_expiracao: null,
            },

            /**
             * Opção do select
             */
            options_armazens: [],
            fabricantes: [],
            statusGerais: [],
            unidadeMedidas: [],
            classes: [],
            categorias: [],
            marcas: [],
            taxas: [],
            motivos: [],
            tipoStocagens: [],
            controleStock: [{
                    id: 1,
                    text: "SIM",
                },
                {
                    id: 2,
                    text: "NÃO",
                },
            ],
            margem_lucro: "",
            preco_compra: "",

            dependencias: [],
            USUARIO_EMPRESA: 2,
            router: "",

            regimeNaoSujeicao: 3,
            regimeTransitorio: 2,
            regimeGeral: 1,

            regimeEmpresaAuth: this.empresa.tiporegime.id,
        };
    },

    created() {
        this.router =
            this.guard.tipo_user_id == this.USUARIO_EMPRESA ?
            window.location.origin + `/empresa` :
            window.location.origin + `/empresa/funcionario`;
    },

    mounted() {

        this.listarMotivoOuTaxaRegimeDaEmpresa();

        this.pegarDependencias();
        this.loadArmazen();

    },

    methods: {

        checkTaxa(codigo) {

            if (this.regimeEmpresaAuth == this.regimeGeral) {

                this.produto.taxa = codigo.taxa;
                if (codigo.taxa >= 1) {
                    $("#motivo_isencao_id").attr("disabled", "true");
                    this.motivos = [];
                } else {
                    $("#motivo_isencao_id").removeAttr("disabled");
                    this.listarMotivos(this.regimeEmpresaAuth);
                }
            } else if (this.regimeEmpresaAuth == this.regimeTransitorio) {
                $("#codigo_taxa").attr("disabled", "true");
                this.taxas = [];
            }

        },

        listarMotivoOuTaxaRegimeDaEmpresa() {

            if (this.regimeEmpresaAuth === this.regimeNaoSujeicao || this.regimeEmpresaAuth === this.regimeTransitorio) {
                $("#codigo_taxa").attr("disabled", "true");
                this.taxas = [];
            } else {
                this.listarTaxas();
            }

            this.listarMotivos(this.regimeEmpresaAuth);

        },
        desabilitarCampoExistenciaStock(estocavel) {

            if (estocavel == 1) { //estocavel
                // this.produto.quantidade = 1;
                $("#quantidade .numeric-input").removeAttr("disabled");
                $("#quantidade_minima .numeric-input").removeAttr("disabled");
                $("#quantidade_critica .numeric-input").removeAttr("disabled");

            } else {
                $("#quantidade .numeric-input").attr("disabled", "true");
                $("#quantidade_minima .numeric-input").attr("disabled", "true");
                $("#quantidade_critica .numeric-input").attr("disabled", "true");
                this.produto.quantidade_minima = 0;
                this.produto.quantidade_critica = 0;
                this.produto.quantidade = 0;
            }
        },

        // verificaDiferenteNaoSujeitacao() {
        //     if (this.regimeEmpresaAuth = this.regimeNaoSujeicao) {
        //         this.listarTaxas();
        //     }
        // },

        async listarTaxas() {

            this.taxas = [];
            try {
                let response = await axios.get(`${this.router}/taxaIvaListar`);
                if (response.status === 200) {
                    response.data.taxas.forEach((item) => {
                        this.taxas.push({
                            id: item.codigo,
                            text: item.descricao,
                            taxa: item.taxa
                        });
                    });

                    //lista a taxa default no select
                    this.produto.codigo_taxa = response.data.taxas[0].codigo;

                }
            } catch (error) {
                console.log("Erro", error);
            }
        },

        async listarMotivos(regimeEmpresaAuth) {

            this.motivos = [];
            try {
                let response = await axios.get(
                    `${this.router}/motivoIvaListar/${regimeEmpresaAuth}`
                );
                if (response.status === 200) {
                    response.data.forEach((item) => {
                        this.motivos.push({
                            id: item.codigo,
                            text: item.descricao,
                        });
                    });
                }
            } catch (error) {}
        },

        desabilitarCampoMotivo(valor) {
            if (valor >= 2) {
                $("#motivo_isencao_id").attr("disabled", "true");
                this.motivos = [];
            } else {
                $("#motivo_isencao_id").removeAttr("disabled");
                this.motivos = [];
                this.listarMotivos(this.regimeEmpresaAuth);
            }
        },
        loadArmazen() {
            axios
                .get(`${this.router}/produtos/listarArmazens`)
                .then((response) => {
                    response.data.armazens.forEach((item) => {
                        this.options_armazens.push({
                            id: item.id,
                            designacao: item.designacao,
                        });
                    });

                    //lista a loja default no select
                    this.produto.armazens.push({
                        id: response.data.armazens[0].id,
                        designacao: response.data.armazens[0].designacao,
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        pegarDependencias: function () {
            axios
                .get(`${this.router}/pegar-dependecias`)
                .then((response) => {
                    let data = response.data;

                    this.fabricantes = [];
                    data.fabricantes.forEach((item) => {
                        this.fabricantes.push({
                            id: item.id,
                            text: item.designacao,
                        });
                    });
                    //lista a loja default no select
                    this.produto.fabricante_id = response.data.fabricantes[0].id;

                    this.statusGerais = [];

                    data.status_gerais.forEach((item) => {
                        this.statusGerais.push({
                            id: item.id,
                            text: item.designacao,
                        });
                    });

                    this.unidadeMedidas = [];

                    data.unidade_medidas.forEach((item) => {
                        this.unidadeMedidas.push({
                            id: item.id,
                            text: item.designacao,
                        });
                    });
                    this.produto.unidade_medida_id = data.unidade_medidas[0].id;
                    

                    this.classes = [];

                    data.classes.forEach((item) => {
                        this.classes.push({
                            id: item.id,
                            text: item.designacao,
                        });
                    });

                    this.categorias = [];

                    data.categorias.forEach((item) => {
                        this.categorias.push({
                            id: item.id,
                            text: item.designacao,
                        });
                    });

                    this.marcas = [];

                    data.marcas.forEach((item) => {
                        this.marcas.push({
                            id: item.id,
                            text: item.designacao,
                        });
                    });

                    this.tipoStocagens = [];

                    data.tipos_stocagens.forEach((item) => {
                        this.tipoStocagens.push({
                            id: item.id,
                            text: item.designacao,
                        });
                    });
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        addTag(newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000),
            };
            this.produto.armazens.push(tag);
        },

        async salvar() {

            this.$loading(true)

            this.errors = [];
            try {

                let response = await axios.post(`${this.router}/produtos/adicionar`, this.produto);

                if (response.status == 200) {

                    this.$loading(false)

                    this.$toasted.global.defaultSuccess();
                    Swal.fire({
                        title: "Sucesso",
                        text: "Produto registado com sucesso!...",
                        icon: "success",
                        confirmButtonColor: "#3d5476",
                        confirmButtonText: "Ok",
                        onClose: () => {
                           document.location.reload(true)
                        },
                    });
                    this.reset();
                }
            } catch (error) {
                this.$loading(false)

                this.$toasted.global.defaultError({
                    msg: "Erro ao cadastrar",
                });
                this.errors = error.response.data.errors;
            }

        },

        salvarFabricante() {

            this.errors = [];

            axios
                .post(`${this.router}/fabricantes/adicionar`, this.fabricante)
                .then((res) => {
                    this.$toasted.global.defaultSuccess();

                    this.pegarDependencias();

                    this.fabricante = {
                        status_id: 1, //inicia com status do select2 ativo
                    };
                })
                .catch((error) => {
                    this.$toasted.global.defaultError({
                        msg: "Erro ao cadastrar",
                    });
                    this.errors = error.response.data.errors;
                });
        },

        salvarClasse() {
            this.errors = [];
            axios
                .post(`${this.router}/classes/adicionar`, this.classe)
                .then((res) => {
                    this.$toasted.global.defaultSuccess();

                    this.pegarDependencias();

                    this.classe = {
                        status_id: 1, //inicia com status do select2 ativo
                    };
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

        salvarUnidade() {
            this.errors = [];
            axios
                .post(`${this.router}/unidades/adicionar`, this.unidade)
                .then((res) => {
                    this.$toasted.global.defaultSuccess();
                    this.pegarDependencias();

                    this.unidade = {
                        status_id: 1, //inicia com status do select2 ativo
                    };
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
                .then((res) => {
                    this.$toasted.global.defaultSuccess();

                    this.pegarDependencias();
                    this.categoria = {
                        status_id: 1, //inicia com status do select2 ativo
                    };
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
                .then((res) => {
                    this.$toasted.global.defaultSuccess();

                    this.pegarDependencias();
                    this.marca = {
                        status_id: 1, //inicia com status do select2 ativo
                    };
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

        formatDate() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, "0");
            var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
            var yyyy = today.getFullYear();

            today = yyyy + "-" + mm + "-" + dd;

            return today;
        },
        reset() {
            this.produto = {};
        },
    },

    watch: {
        margem_lucro() {
            if (this.preco_compra || this.margem_lucro) {
                if (this.margem_lucro > 100) {
                    this.margem_lucro = 100;
                }

                this.produto.margem_lucro = this.margem_lucro;
                this.produto.preco_compra = this.preco_compra;
                this.produto.preco_venda =
                    parseFloat(this.preco_compra) +
                    (this.preco_compra * this.margem_lucro) / 100;
            } else {
                this.produto.preco_venda = "";
            }
        },
        preco_compra() {
            if (this.preco_compra || this.margem_lucro) {
                this.produto.margem_lucro = this.margem_lucro;
                this.produto.preco_compra = this.preco_compra;
                this.produto.preco_venda =
                    parseFloat(this.preco_compra) +
                    (this.preco_compra * this.margem_lucro) / 100;
            } else {
                this.produto.preco_venda = "";
            }
        },
    },
};
</script>

<style>
#descricao {
    padding-left: 25px;
}

#botoes {
    left: 0%;
    border-radius: 15px;
    margin-top: 0.1%;
    padding: 6px 12px 6px 12px;
    position: relative;
    text-transform: uppercase;
}

.vdpComponent.vdpWithInput>input {
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
