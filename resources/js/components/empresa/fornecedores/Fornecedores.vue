<template>
<div class="row">

    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Fornecedores
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Listagem
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="col-xs-12">

        <div class>
            <form class="form-search" method="get" action>
                <div class="row">
                    <div class>
                        <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-search"></i>
                            </span>

                            <input type="text" required autocomplete="on" v-model="searchQuery" class="form-control search-query" placeholder="Buscar Por fornecedores..." />
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

        <div class>
            <div class="row">
                <form id="adimitirCandidatos" method="POST" action>
                    <input type="hidden" name="_token" value />

                    <div class="col-xs-12 widget-box widget-color-green" style="left: 0%;">
                        <div class="clearfix">
                            <a v-if="window.user.can['gerir fornecedores'] && window.isSuperAdmin" href="#criar_fornecedor" data-toggle="modal" title="Adicionar novo cliente" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-plus"></i> Novo fornecedor
                            </a>
                            <!-- <a href="/empresa/imprimir-clientes" title="Imprimir cliente" target="new" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print"></i> Clientes
                            </a> -->
                            <a @click.prevent="printFornecendor" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a>

                            <div class="dt-buttons btn-overlap btn-group pull-right">
                                <a class="dt-button buttons-collection buttons-colvis btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table">
                                    <span>
                                        <i class="fa fa-search bigger-110 text-primary"></i>
                                        <span class="hidden">Mostrar/Ocultar Colunas</span>
                                    </span>
                                </a>
                                <a class="dt-button buttons-copy buttons-html5 btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table">
                                    <span>
                                        <i class="fa fa-copy bigger-110 text-pink"></i>
                                        <span class="hidden">Copiar para uma tabela</span>
                                    </span>
                                </a>
                                <a class="dt-button buttons-csv buttons-html5 btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table">
                                    <span>
                                        <i class="fa fa-database bigger-110 text-orange" style="color: orange"></i>
                                        <span class="hidden">Exportar para CSV</span>
                                    </span>
                                </a>
                                <a class="dt-button buttons-print btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table" href="#modalFiltrarClientes" data-toggle="modal">
                                    <span><i class="fa fa-print bigger-110 text-default"></i>
                                        <span class="hidden">Imprimir toda Tabela</span>
                                    </span>
                                </a>
                            </div>
                            <!-- <div class="pull-right tableTools-container"></div> -->
                        </div>

                        <div class="table-header widget-header">Todos Fornecedores do Sistema</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </th>
                                        <th>Código</th>
                                        <th>Nome do fornecedor</th>
                                        <th>Email</th>
                                        <th>Telefone</th>
                                        <th style="text-align: center">Status</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="fornecedor in queryFornecedores" :key="fornecedor.id">
                                        <td class="center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </td>

                                        <td>{{fornecedor.id}}</td>
                                        <td>{{fornecedor.nome}}</td>
                                        <td>{{fornecedor.email_empresa}}</td>
                                        <td>{{fornecedor.telefone_empresa}}</td>
                                        <td class="hidden-480" style="text-align: center">
                                            <span v-if="(fornecedor.status_id == 1)" class="label label-sm label-success" style="border-radius: 20px;">{{ fornecedor.statu_geral.designacao }}</span>

                                            <span v-else class="label label-sm label-warning" style="border-radius: 20px;">{{ fornecedor.statu_geral.designacao }}</span>
                                        </td>

                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#ver_detalhes" data-toggle="modal" @click.prevent="mostrarModalDetalhes(fornecedor)" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                </a>
                                                <a href="#editar_fornecedor" v-if="fornecedor.diversos != 1" data-toggle="modal" class="pink" @click.prevent="mostrarModalEditar(fornecedor)" title="Editar este registo">
                                                    <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                </a>
                                                <a data-toggle="modal" v-if="fornecedor.diversos != 1" title="Eliminar este Registro" @click.prevent="deletarFornecedor(fornecedor)" style="cursor:pointer;">
                                                    <i class="ace-icon fa fa-trash-o bigger-150 bolder danger red"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.col-xs-12 -->
                </form>
            </div>
        </div>
    </div>

    <!-- CRIAR FORNECEDOR -->
    <div id="criar_fornecedor" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Editar fornecedores
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- AVISO -->
                                <div class="alert alert-warning hidden-sm hidden-xs">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    Os campos marcados com <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span> são de preenchimento obrigatório.
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Dados do fornecedor
                                </div>
                            </div>

                            <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                <div class="second-row">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs padding-16">
                                            <li class="active">
                                                <a data-toggle="tab" href="#dados_cliente">
                                                    <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                    Dados do Fornecedor
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_cliente" class="tab-pane in active">
                                                <h4 class="header bolder smaller" style="color: #3d5476">Geral</h4>

                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Nome
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="fornecedor.nome"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.nome?'has-error':''" placeholder="Informe o nome" />
                                                            <span v-if="errors.nome" class="error">{{errors.nome[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            NIF
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input v-maska="'##############'" type="text" v-model="fornecedor.nif"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.nif?'has-error':''" placeholder="Informe o nif" />
                                                            <span v-if="errors.nif" class="error">{{errors.nif[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Nacionalidade
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span> </label>
                                                        <div class>
                                                            <Select2 :options="paisesOptions" v-model="fornecedor.pais_nacionalidade_id" placeholder="Selecione o país">
                                                                <!-- <option disabled value="0">Select one</option> -->
                                                            </Select2>
                                                            <span v-if="errors.pais_nacionalidade_id" class="error">{{errors.pais_nacionalidade_id[0]}}</span>

                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group has-info">

                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Status
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span> </label>
                                                        <div class>
                                                            <Select2 :options="statusOptions" v-model="fornecedor.status_id" placeholder="Selecione o país">
                                                                <!-- <option disabled value="0">Select one</option> -->
                                                            </Select2>
                                                            <span v-if="errors.status_id" class="error">{{errors.status_id[0]}}</span>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="gestor">
                                                            Data Contracto
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <date-pick v-model="fornecedor.data_contracto" format="YYYY-MM-DD"></date-pick>
                                                        </div>
                                                    </div>

                                                </div>
                                                <h4 class="header bolder smaller" style="color: #3d5476">Contacto</h4>
                                                <div class="form-group has-info">

                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Telefone empresa
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-maska="'###-###-###'" v-model="fornecedor.telefone_empresa"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.telefone_empresa?'has-error':''" placeholder="Informe o telefone do fornecedor" />
                                                            <span v-if="errors.telefone_empresa" class="error">{{errors.telefone_empresa[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Email empresa
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="fornecedor.email_empresa"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.email_empresa?'has-error':''" placeholder="Informe o email do fornecedor" />
                                                            <span v-if="errors.email_empresa" class="error">{{errors.email_empresa[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Pessoa Contacto
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="fornecedor.pessoal_contacto"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.pessoal_contacto?'has-error':''" placeholder="Informe nome pessoa contacto" />
                                                            <span v-if="errors.pessoal_contacto" class="error">{{errors.pessoal_contacto[0]}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Telefone contacto
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-maska="'###-###-###'" v-model="fornecedor.telefone_contacto"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.telefone_contacto?'has-error':''" placeholder="Informe o telefone de contacto" />
                                                            <span v-if="errors.telefone_contacto" class="error">{{errors.telefone_contacto[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Email Contacto
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="fornecedor.email_contacto"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.email_contacto?'has-error':''" placeholder="Informe o email de contacto" />
                                                            <span v-if="errors.email_contacto" class="error">{{errors.email_contacto[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Web Site
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="fornecedor.website"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.website?'has-error':''" placeholder="Informe o web site" />
                                                            <span v-if="errors.website" class="error">{{errors.website[0]}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-8">
                                                        <label class="control-label" for="designacao">
                                                            Endereço
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="fornecedor.endereco"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.endereco?'has-error':''" placeholder="Informe o endereço" />
                                                            <span v-if="errors.endereco" class="error">{{errors.endereco[0]}}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="clearfix form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button class="search-btn" style="border-radius: 10px" @click.prevent="cadastrarFornecedor">
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

    <!-- EDITAR FORNECEDOR -->
    <div id="editar_fornecedor" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar fornecedores
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- AVISO -->
                                <div class="alert alert-warning hidden-sm hidden-xs">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    Os campos marcados com <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span> são de preenchimento obrigatório.
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Dados do fornecedor
                                </div>
                            </div>

                            <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                <div class="second-row">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs padding-16">
                                            <li class="active">
                                                <a data-toggle="tab" href="#dados_cliente">
                                                    <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                    Dados do Fornecedor
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_cliente" class="tab-pane in active">
                                                <h4 class="header bolder smaller" style="color: #3d5476">Geral</h4>

                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Nome
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="fornecedorData.nome"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.nome?'has-error':''" placeholder="Informe o nome" />
                                                            <span v-if="errors.nome" class="error">{{errors.nome[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            NIF
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="fornecedorData.nif"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.nif?'has-error':''" placeholder="Informe o nif" />
                                                            <span v-if="errors.nif" class="error">{{errors.nif[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Conta Corrente
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" disabled v-model="fornecedorData.conta_corrente" id="conta_corrente" class="col-md-12 col-xs-12 col-sm-4" :class="errors.conta_corrente?'has-error':''" />
                                                            <span v-if="errors.conta_corrente" class="error">{{errors.conta_corrente[0]}}</span>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Nacionalidade
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span> </label>
                                                        <div class>
                                                            <Select2 :options="paisesOptions" v-model="fornecedorData.pais_nacionalidade_id" placeholder="Selecione o país">
                                                                <!-- <option disabled value="0">Select one</option> -->
                                                            </Select2>
                                                            <span v-if="errors.pais_nacionalidade_id" class="error">{{errors.pais_nacionalidade_id[0]}}</span>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Status
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span> </label>
                                                        <div class>
                                                            <Select2 :options="statusOptions" v-model="fornecedorData.status_id" placeholder="Selecione o país">
                                                                <!-- <option disabled value="0">Select one</option> -->
                                                            </Select2>
                                                            <span v-if="errors.status_id" class="error">{{errors.status_id[0]}}</span>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="gestor">
                                                            Data Contracto
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <date-pick v-model="fornecedorData.data_contracto" :format="'DD-MM-YYYY'" id="datapickEdit"></date-pick>
                                                        </div>
                                                    </div>

                                                </div>
                                                <h4 class="header bolder smaller" style="color: #3d5476">Contacto</h4>
                                                <div class="form-group has-info">

                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Telefone empresa
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-maska="'###-###-###'" v-model="fornecedorData.telefone_empresa"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.telefone_empresa?'has-error':''" placeholder="Informe o telefone do fornecedor" />
                                                            <span v-if="errors.telefone_empresa" class="error">{{errors.telefone_empresa[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Email empresa
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="fornecedorData.email_empresa"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.email_empresa?'has-error':''" placeholder="Informe o email do fornecedor" />
                                                            <span v-if="errors.email_empresa" class="error">{{errors.email_empresa[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Pessoa Contacto
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="fornecedorData.pessoal_contacto"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.pessoal_contacto?'has-error':''" placeholder="Informe nome pessoa contacto" />
                                                            <span v-if="errors.pessoal_contacto" class="error">{{errors.pessoal_contacto[0]}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Telefone contacto
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-maska="'###-###-###'" v-model="fornecedorData.telefone_contacto"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.telefone_contacto?'has-error':''" placeholder="Informe o telefone de contacto" />
                                                            <span v-if="errors.telefone_contacto" class="error">{{errors.telefone_contacto[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Email Contacto
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="fornecedorData.email_contacto"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.email_contacto?'has-error':''" placeholder="Informe o email de contacto" />
                                                            <span v-if="errors.email_contacto" class="error">{{errors.email_contacto[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Web Site
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="fornecedorData.website"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.website?'has-error':''" placeholder="Informe o web site" />
                                                            <span v-if="errors.website" class="error">{{errors.website[0]}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-8">
                                                        <label class="control-label" for="designacao">
                                                            Endereço
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="fornecedorData.endereco"  class="col-md-12 col-xs-12 col-sm-4" :class="errors.endereco?'has-error':''" placeholder="Informe o endereço" />
                                                            <span v-if="errors.endereco" class="error">{{errors.endereco[0]}}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    <div class="clearfix form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button class="search-btn" style="border-radius: 10px" @click.prevent="editarFornecedor">
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

    <!-- VER DETALHES  -->
    <div id="ver_detalhes" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Ver mais detalhes do fornecedores
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">

                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Detalhes do fornecedor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">
                        <div class="col-md-12">

                            <div class="second-row">

                                <div class="tabbable">
                                    <ul class="nav nav-tabs padding-16">
                                        <li class="active">
                                            <a data-toggle="tab" href="#dados_user">
                                                <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                                                Dados do Fornecedor
                                            </a>
                                        </li>

                                        <li>
                                            <a data-toggle="tab" href="#foto_user">
                                                <i class="red ace-icon fa fa-phone bigger-125"></i>
                                                Contatos
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content profile-edit-tab-content">
                                        <div id="dados_user" class="tab-pane in active">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">Nome</th>
                                                        <td>{{fornecedorDetalhes.nome}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">NIF</th>
                                                        <td>{{fornecedorDetalhes.nif}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Email fornecedor</th>
                                                        <td>{{fornecedorDetalhes.email_empresa}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">web site</th>
                                                        <td>
                                                            <a href="" target="_blank">{{fornecedorDetalhes.website}}</a>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">País</th>
                                                        <td>{{fornecedorDetalhes.pais.designacao?fornecedorDetalhes.pais.designacao:"" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Data Contracto</th>
                                                        <td>{{fornecedorDetalhes.data_contracto | formatDate}}</td>
                                                    </tr>

                                                </tbody>

                                            </table>

                                        </div>

                                        <div id="foto_user" class="tab-pane">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">Telefone Fornecedor</th>
                                                        <td>{{fornecedorDetalhes.telefone_empresa}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Telefone</th>
                                                        <td>{{fornecedorDetalhes.telefone_contacto}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="row">Email</th>
                                                        <td>{{fornecedorDetalhes.email_contacto}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>
</template>

<script>
import Select2 from 'v-select2-component';
import DatePick from 'vue-date-pick';
import Swal from "sweetalert2";
import {
    maska
} from 'maska'

import {
    baseUrl,
    showError
} from "../../../config/global";
export default {
    directives: {
        maska
    },

    components: {
        Select2,
        DatePick
    },
    props: ["fornecedores", "paises", "status", "guard"],
    data() {

        return {
            searchQuery: "",
            fornecedor: {
                data_contracto: this.formatDate(),

            },
            fornecedorData: {},
            fornecedorDetalhes: {
                pais: {}
            },
            errors: [],
            paisesOptions: [],
            statusOptions: [],
            USUARIO_EMPRESA: 2,
            router: ""

        }
    },
    created() {
        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`
        this.listarPaises();
        this.listarStatus();
    },

    computed: {

        window() {
            return window.Laravel;
        },

        queryFornecedores() {

            if (this.searchQuery) {

                let result = this.fornecedores.filter(item => {
                    let searchQuery = this.searchQuery.toLowerCase();
                    return item.nome.toLowerCase().match(searchQuery) ||
                        item.nif.toLowerCase().match(searchQuery) ||
                        item.email_empresa.toLowerCase().match(searchQuery)
                });
                return result ? result : []
            } else {
                return this.fornecedores
            }

        }

    },

    methods: {

        printFornecendor() {

            this.$loading(true);

            axios.get(
                    `${this.router}/fornecedorImprimir`, {
                        responseType: "arraybuffer",
                    }
                )
                .then((response) => {
                    if (response.status === 200) {

                        this.$loading(false)
                        var file = new Blob([response.data], {
                            type: "application/pdf",
                        });
                        var fileURL = URL.createObjectURL(file);
                        window.open(fileURL);
                    } else {
                        this.$loading(false)
                        console.log("Erro ao carregar pdf");
                    }
                    //window.open("/empresa/imprimir/bancos?status=" + this.filter.status_id); //This will open Google in a new window.
                });
        },

        listarPaises() {
            this.paises.forEach(element => {
                this.paisesOptions.push({
                    id: element.id,
                    text: element.designacao
                })
            });
        },
        listarStatus() {
            this.status.forEach(element => {
                this.statusOptions.push({
                    id: element.id,
                    text: element.designacao
                })

            });
            this.fornecedor.status_id = this.status[0].id;
        },
        formatDate() {

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = dd + '-' + mm + '-' + yyyy;

            return today;
        },
        mostrarModalEditar(fornecedor) {

            this.fornecedorData = {};
            this.errors = [];
            this.fornecedorData = Object.assign({}, fornecedor);
            $("#datapickEdit input").attr("disabled", "true");

        },
        mostrarModalDetalhes(fornecedor) {

            this.fornecedorDetalhes = {};
            this.fornecedorDetalhes = Object.assign({}, fornecedor);

        },
        deletarFornecedor(fornecedor) {

            Swal.fire({
                title: "Deseja remover o item?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ok",
            }).then((result) => {
                if (result.value) {
                    axios.get(`${this.router}/fornecedores/deletar/${fornecedor.id}`).then((res) => {

                        if (res.status == 200) {
                            this.$toasted.global.defaultSuccess();

                            Swal.fire({
                                title: 'Sucesso',
                                text: 'Cliente cadastrado com sucesso!',
                                icon: 'success',
                                confirmButtonColor: '#3d5476',
                                confirmButtonText: 'Ok',
                                onClose: () => {
                                    document.location.reload(true)
                                }
                            });

                        }

                    }).catch((error) => {
                        this.$toasted.global.defaultError({
                            msg: "Sem Permissão para eliminar o fornecedor, contacte o administrador do sistema",
                        });
                    });
                }
            });

        },
        async cadastrarFornecedor() {

            try {
                let response = await axios.post(`/empresa/fornecedores/adicionar`, this.fornecedor);
                if (response.status == 200) {
                    this.$toasted.global.defaultSuccess();
                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Fornecedor cadastrado com sucesso!',
                        icon: 'success',
                        confirmButtonColor: '#3d5476',
                        confirmButtonText: 'Ok',
                        onClose: () => {
                           document.location.reload(true)
                        }
                    });
                }
            } catch (error) {
                this.errors = error.response.data.errors;
            }
        },
        async editarFornecedor() {

            try {
                let response = await axios.post(`${this.router}/fornecedores/update/${this.fornecedorData.id}`, this.fornecedorData);
                if (response.status == 200) {
                    this.$toasted.global.defaultSuccess();
                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Fornecedor actualizado com sucesso!',
                        icon: 'success',
                        confirmButtonColor: '#3d5476',
                        confirmButtonText: 'Ok',
                        onClose: () => {
                            document.location.reload(true)
                        }
                    });
                }
            } catch (error) {
                this.errors = error.response.data.errors;
            }

        }
    }
}
</script>

<style>
.has-error {
    border-color: #f2a696 !important;
}

.vdpComponent.vdpWithInput>input {
    padding: 6px !important;
    width: 231px !important;
}
</style>
