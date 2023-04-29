<template>
<div class="row">

    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Clientes
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

                            <input type="text" required autocomplete="on" v-model="searchQuery" class="form-control search-query" placeholder="Buscar cliente por nome..." />
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
                            <a href="#criar_cliente" data-toggle="modal" title="Adicionar novo cliente" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-plus"></i> Novo cliente
                            </a>
                            <!-- <a href="/empresa/imprimir-clientes" title="Imprimir cliente" target="new" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print"></i> Clientes
                            </a> -->
                            <a data-toggle="modal" href="#modalFiltrarClientes" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
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

                        <div class="table-header widget-header">Todos cliente do Sistema</div>

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
                                        <th>Nome do cliente</th>
                                        <th>Email</th>
                                        <th>NIF</th>
                                        <th>Telefone</th>
                                        <th>Conta Corrente</th>
                                        <th>Tipo Cliente</th>
                                        <th>País</th>
                                        <th>status</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="cliente in queryClientes" :key="cliente.id">
                                        <td class="center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </td>

                                        <td>{{cliente.nome}}</td>
                                        <td>{{cliente.email}}</td>
                                        <td>{{cliente.nif}}</td>
                                        <td>{{cliente.telefone_cliente}}</td>
                                        <td>{{cliente.conta_corrente}}</td>
                                        <td>{{cliente.tipocliente.designacao}}</td>
                                        <td>{{cliente.pais.designacao}}</td>

                                        <td class="hidden-480" style="text-align: center">
                                            <span v-if="(cliente.statu_geral.id == 1)" class="label label-sm label-success" style="border-radius: 20px;">{{ cliente.statu_geral.designacao }}</span>

                                            <span v-else class="label label-sm label-warning" style="border-radius: 20px;">{{ cliente.statu_geral.designacao }}</span>
                                        </td>
                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#ver_detalhes" v-if="cliente.diversos != 'Sim'" data-toggle="modal" @click.prevent="mostrarModalDetalhes(cliente)" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                </a>
                                                <a href="/empresa/cliente/editar/179">Editar</a>
                                                <a href="/empresa/cliente/179" v-if="cliente.diversos != 'Sim' && window.user.can['gerir clientes']"  class="pink"  title="Editar este registo">
                                                    <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                </a>
                                                <a data-toggle="modal" v-if="cliente.diversos != 'Sim' && window.user.can['gerir clientes']" title="Eliminar este Registro" @click.prevent="deletarCliente(cliente)" style="cursor:pointer;">
                                                    <i class="ace-icon fa fa-trash-o bigger-150 bolder danger red"></i>
                                                </a>
                                                <!-- <a title="Imprimir extrato" style="cursor:pointer;">
                                                    <i class="fa fa-print bigger-150 text-primary"></i>
                                                </a> -->
                                                <a href="#extrato_cliente" @click="mostrarExtratoConta(cliente)" data-toggle="modal" title="Imprimir extrato" style="cursor:pointer;">
                                                    <i class="fa fa-file bigger-150 text-primary"></i>
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

        <!-- CRIAR BANCOS -->
        <div id="criar_cliente" class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar cliente
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
                                        Dados do cliente
                                    </div>
                                </div>

                                <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_cliente">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados do cliente
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_cliente" class="tab-pane in active">
                                                    <div class="form-group has-info">
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Nome
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="cliente.nome" id="nome" class="col-md-12 col-xs-12 col-sm-4" :class="errors.nome?'has-error':''" placeholder="Informe o nome" />
                                                                <span v-if="errors.nome" class="error">{{errors.nome[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Email
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <!-- <i class="fa fa-question-circle bold text-danger"></i> -->
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="email" v-model="cliente.email" value id="email" class="col-md-12 col-xs-12 col-sm-4" :class="errors.email?'has-error':''" placeholder="Informe o E-mail" />
                                                                <span v-if="errors.email" class="error">{{errors.email[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Telefone
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-maska="'###-###-###'" v-model="cliente.telefone_cliente" value id="pessoa_contacto" class="col-md-12 col-xs-12 col-sm-4" :class="errors.pessoa_contacto?'has-error':''" placeholder="Informe o contacto" />
                                                                <span v-if="errors.telefone_cliente" class="error">{{errors.telefone_cliente[0]}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-info">
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Web Site
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="cliente.website" value id="website" class="col-md-12 col-xs-12 col-sm-4" placeholder="Informe o website" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Endereço
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-model="cliente.endereco" value id="endereco" class="col-md-12 col-xs-12 col-sm-4" :class="errors.endereco?'has-error':''" placeholder="Informe o endereço/morada do Cliente" />
                                                                <span v-if="errors.endereco" class="error">{{errors.endereco[0]}}</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Cidade
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-model="cliente.cidade" value id="endereco" :class="errors.cidade?'has-error':''" class="col-md-12 col-xs-12 col-sm-4" placeholder="Informe o cidade" />
                                                                <span v-if="errors.cidade" class="error">{{errors.cidade[0]}}</span>

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
                                                                <Select2 :options="paises" v-model="cliente.pais_id" :class="errors.pais_id?'has-error':''" placeholder="Selecione o país">
                                                                    <!-- <option disabled value="0">Select one</option> -->
                                                                </Select2>
                                                                <span v-if="errors.pais_id" class="error">{{errors.pais_id[0]}}</span>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                NIFF
                                                                 <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                           
                                                            <div class>
                                                                <input type="text" max="14" v-maska="'##############'" v-model="cliente.nif" class="col-md-12 col-xs-12 col-sm-4" :class="errors.nif?'has-error':''" placeholder="Informe o NIF" />
                                                                <span v-if="errors.nif" class="error">{{errors.nif[0]}}</span>
                                                            </div>
                                                            
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="tipocliente">
                                                                Tipo Cliente
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <Select2 :options="tipoCliente" v-model="cliente.tipo_cliente_id" :class="errors.tipo_cliente_id?'has-error':''" placeholder="Selecione o tipo de Cliente">
                                                                </Select2>
                                                                <span v-if="errors.tipo_cliente_id" class="error">{{errors.tipo_cliente_id[0]}}</span>

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-group has-info">
                                                        <!-- <div class="col-md-4">
                                                            <label class="control-label" for="gestor">
                                                                Gestor

                                                            </label>
                                                            <div class>
                                                                <Select2 :options="gestores" v-model="cliente.gestor_id" placeholder="Selecione o nome do Gestor">
                                                                </Select2>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Pessoa de Contacto
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-model="cliente.pessoa_contacto" class="col-md-12 col-xs-12 col-sm-4" :class="errors.pessoa_contacto?'has-error':''" placeholder="Informe a pessoa de contacto" />
                                                                <span v-if="errors.pessoa_contacto" class="error">{{errors.pessoa_contacto[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="tipocliente">
                                                                Número de Contracto
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <!-- <i class="fa fa-question-circle bold text-danger"></i> -->
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-model="cliente.numero_contrato" class="col-md-12 col-xs-12 col-sm-4" :class="errors.nif?'has-error':''" placeholder="Informe o nº de contracto" />
                                                            </div>
                                                        </div>
                                                         <div class="col-md-4">
                                                            <label class="control-label" for="saldo">
                                                                Conta Corrente
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-model="cliente.conta_corrente" disabled readonly id="saldo" class="col-md-12 col-xs-12 col-sm-4" placeholder="Informe a conta corrente do Cliente" />
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-group has-info">
                                                        <!-- <div class="col-md-4">
                                                            <label class="control-label" for="gestor">
                                                                Tipo Conta Corrente
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <Select2 :options="tipo_conta_corrente" v-model="tipoContaCorrente" placeholder="Selecione o tipo de conta corrente">
                                                                </Select2>
                                                            </div>
                                                        </div> -->
                                                       
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="saldo">
                                                                Taxa de Desconto
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <!-- <i class="fa fa-question-circle bold text-danger"></i> -->
                                                                </span> </label>
                                                            <div class>
                                                                <input type="number" v-model.number="cliente.taxa_de_desconto" id="saldo" class="col-md-12 col-xs-12 col-sm-4" placeholder="Informe a taxa de desconto" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="saldo">
                                                                Limite de Crédito
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <!-- <i class="fa fa-question-circle bold text-danger"></i> -->
                                                                </span> </label>
                                                            <div class>
                                                                <input type="number" v-model.number="cliente.limite_de_credito" id="saldo" class="col-md-12 col-xs-12 col-sm-4" />
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
                                                                <date-pick id="datapickEdit" v-model="cliente.data_contrato" :format="'DD-MM-YYYY'"></date-pick>
                                                            </div>
                                                            <!-- <div class>
                                                                <date-pick v-model="cliente.data_contrato" :format="'YYYY-MM-DD'"></date-pick>
                                                            </div> -->
                                                        </div>

                                                    </div>

                                                   

                                                </div>
                                            </div>
                                            <div class="clearfix form-actions">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button class="search-btn" style="border-radius: 10px" @click.prevent="salvar">
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

        <!-- EDITAR CLIENTE  -->
        <div id="edit_cliente" class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Editar cliente
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
                                        Dados do cliente
                                    </div>
                                </div>

                                <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_cliente">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados do cliente
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_cliente" class="tab-pane in active">
                                                    <div class="form-group has-info">
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Nome
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-model="clienteEdit.nome" id="nome" class="col-md-12 col-xs-12 col-sm-4" :class="errors.nome?'has-error':''" />
                                                                <span v-if="errors.nome" class="error">{{errors.nome[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Email
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <!-- <i class="fa fa-question-circle bold text-danger"></i> -->
                                                                </span> </label>
                                                            <div class>
                                                                <input type="email" v-model="clienteEdit.email" value id="email" class="col-md-12 col-xs-12 col-sm-4" :class="errors.email?'has-error':''" />
                                                                <span v-if="errors.email" class="error">{{errors.email[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Telefone
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-maska="'###-###-###'" v-model="clienteEdit.telefone_cliente" value id="pessoa_contacto" class="col-md-12 col-xs-12 col-sm-4" :class="errors.pessoa_contacto?'has-error':''" />
                                                                <span v-if="errors.telefone_cliente" class="error">{{errors.telefone_cliente[0]}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-info">
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Web Site
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="clienteEdit.website" value id="website" class="col-md-12 col-xs-12 col-sm-4" placeholder="Informe o website" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Endereço
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-model="clienteEdit.endereco" value id="endereco" class="col-md-12 col-xs-12 col-sm-4" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Cidade
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-model="clienteEdit.cidade" value id="cidade" class="col-md-12 col-xs-12 col-sm-4" />
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
                                                                <Select2 :options="paises" v-model="clienteEdit.pais_id">
                                                                    <!-- <option disabled value="0">Select one</option> -->
                                                                </Select2>

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
                                                                <input type="text" v-model="clienteEdit.nif" class="col-md-12 col-xs-12 col-sm-4" :class="errors.nif?'has-error':''" />
                                                                <span v-if="errors.nif" class="error">{{errors.nif[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="tipocliente">
                                                                Tipo Cliente
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <Select2 :options="tipoCliente" v-model="clienteEdit.tipo_cliente_id">
                                                                </Select2>

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="form-group has-info">
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="gestor">
                                                                Gestor

                                                            </label>
                                                            <div class>
                                                                <Select2 :options="gestores" v-model="clienteEdit.gestor_id" placeholder="Selecione o Gestor">
                                                                </Select2>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Pessoa de Contacto
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-model="clienteEdit.pessoa_contacto" class="col-md-12 col-xs-12 col-sm-4" :class="errors.nif?'has-error':''" />
                                                                <span v-if="errors.pessoa_contacto" class="error">{{errors.pessoa_contacto[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="tipocliente">
                                                                Número de Contracto
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <!-- <i class="fa fa-question-circle bold text-danger"></i> -->
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-model="clienteEdit.numero_contrato" class="col-md-12 col-xs-12 col-sm-4" :class="errors.nif?'has-error':''" placeholder="Informe o nº de contracto" />
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-group has-info">
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="saldo">
                                                                Conta Corrente
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-model="clienteEdit.conta_corrente" disabled readonly id="saldo" class="col-md-12 col-xs-12 col-sm-4" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="saldo">
                                                                Taxa de Desconto
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                </span> </label>
                                                            <div class>
                                                                <input type="number" v-model.number="clienteEdit.taxa_de_desconto" id="saldo" class="col-md-12 col-xs-12 col-sm-4" />
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="control-label" for="saldo">
                                                                Limite de Crédito
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <!-- <i class="fa fa-question-circle bold text-danger"></i> -->
                                                                </span> </label>
                                                            <div class>
                                                                <input type="number" v-model.number="clienteEdit.limite_de_credito" id="saldo" class="col-md-12 col-xs-12 col-sm-4" />
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-group has-info">
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="gestor">
                                                                Data Contracto
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <date-pick id="datapickEdit" v-model="clienteEdit.data_contrato" :format="'DD-MM-YYYY'"></date-pick>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix form-actions">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button class="search-btn" style="border-radius: 10px" @click.prevent="editar">
                                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                                        Editar
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
            </div>
        </div>
        <!-- FIM EDITAR CLIENTE-->

        <div id="extrato_cliente" class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> EXTRATO DE CONTA
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
                                        Dados do cliente
                                    </div>
                                </div>

                                <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_cliente">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados do cliente
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_motivo" class="tab-pane in active">
                                                    <div class="form-group has-info">
                                                        <div class="col-md-6">
                                                            <label class="control-label bold label-select2" for="designacao">Escolha a data Inferior<b class="red fa fa-question-circle"></b></label>
                                                            <div class="input-group">
                                                                <input type="datetime-local" v-model="clienteExtrato.dataInicial" id="designacao" class="col-md-12 col-xs-12 col-sm-4" />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="control-label bold label-select2" for="designacao">Escolha a data Superior<b class="red fa fa-question-circle"></b></label>
                                                            <div class="input-group">
                                                                <input type="datetime-local" v-model="clienteExtrato.dataFinal"  id="designacao" class="col-md-12 col-xs-12 col-sm-4" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-info">

                                                        <div class="col-md-12">
                                                            <label class="control-label" for="saldo">
                                                                Cliente
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-model="clienteExtrato.nome" disabled readonly id="saldo" class="col-md-12 col-xs-12 col-sm-4" placeholder="Informe a conta corrente do Cliente" />
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label class="control-label" for="saldo">
                                                                Conta Corrente
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <input type="text" v-model="clienteExtrato.conta_corrente" disabled readonly id="saldo" class="col-md-12 col-xs-12 col-sm-4" placeholder="Informe a conta corrente do Cliente" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix form-actions">
                                                <div class="col-md-9">
                                                    <button class="search-btn" style="border-radius: 10px" @click.prevent="imprimirExtrato">
                                                        <i class="ace-icon fa fa-print bigger-110"></i>
                                                        Imprimir
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
            </div>
        </div>

    </div>

    <!-- MODAL LISTAR CLIENTES  -->
    <div class="modal fade" id="modalFiltrarClientes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 460px;">
                <div class="modal-header text-center" id="logomarca-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white">&times;</span>
                    </button>
                    <h4 class="smaller">
                        <i class="fa fa-print bigger-110 text-default"></i> Imprimir por filtragem
                    </h4>
                </div>
                <div class="modal-body" style>
                    <form method="POST" class="form-horizontal validation-form" role="form">
                        <input type="hidden" name="_token" />

                        <div class="tabbable">
                            <div class="tab-content profile-edit-tab-content" style="padding:8px 33px 0px">
                                <div id="edit-basic" class="tab-pane in active">
                                    <div class="box box-primary">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="form-group has-info">

                                                    <div class="col-md-12">
                                                        <label for>Status</label>

                                                        <Select2 :options="statusOptions" v-model="filter.status_id">
                                                        </Select2>
                                                    </div>

                                                </div>

                                                <div class="form-group has-info">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-danger" type="reset" data-dismiss="modal">
                                    <i class="ace-icon fa fa-close bigger-110"></i>
                                    Cancelar
                                </button>
                                &nbsp; &nbsp;&nbsp; &nbsp;
                                <button class="btn btn-info" data-dismiss="modal" type="submit" @click.prevent="imprimir">
                                    <i class="fa fa-print bigger-110 text-default"></i>
                                    Imprimir
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /MODAL LISTAR CLIENTES -->

    <!-- VER DETALHES  -->
    <div id="ver_detalhes" class="modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Ver mais detalhes do Cliente
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">

                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Dados cliente
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
                                                Dados adicionais do cliente
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content profile-edit-tab-content">
                                        <div id="dados_user" class="tab-pane in active">
                                            <table class="table table-striped">
                                                <thead>

                                                    <tr>
                                                        <th scope="col">Cliente</th>
                                                        <th scope="col">Saldo total</th>
                                                        <th scope="col">Limite Crédito</th>
                                                        <th scope="col">Limite desconto</th>
                                                        <th scope="col">Endereço</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{clienteDetalhes.nome}}</td>
                                                        <td>{{clienteDetalhes.saldoActual}}</td>
                                                        <td>{{Number(clienteDetalhes.limite_de_credito) | currency }}</td>
                                                        <td>{{Number(clienteDetalhes.taxa_de_desconto)}}%</td>
                                                        <td>{{clienteDetalhes.endereco }}</td>
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
import Select2 from "v-select2-component";
import DatePicker from "vue2-datepicker";
import DatePick from "vue-date-pick";

import Swal from "sweetalert2";
import { maska } from "maska";
import { baseUrl, showError } from "../../../config/global";
export default {
  directives: {
    maska,
  },

  components: {
    Select2,
    DatePicker,
    DatePick,
  },

  props: ["clientes", "guard"],

  data() {
    return {
      clienteExtrato: {
        dataInicial: this.dateNow(),
        dataFinal: this.dateNow(),
      },
      searchQuery: null,
      paises: [],
      tipoCliente: [
        {
          id: 1,
          text: "Singular",
        },
        {
          id: 2,
          text: "Instituição Privada",
        },
        {
          id: 3,
          text: "Instituição Publica",
        },
        {
          id: 4,
          text: "Sociedade Anónima",
        },
        {
          id: 5,
          text: "ONG",
        },
        {
          id: 6,
          text: "Singular",
        },
      ],
      gestores: [],

      cliente: {
        status_id: 1, //inicia com status do select2 ativo
        saldo: 0,
        data_contrato: this.formatDate(),
        conta_corrente: "31.1.2.1.***",
        limite_de_credito: 0,
        taxa_de_desconto: 0,
        tipo_conta_corrente: null,
      },
      clienteEdit: {}, //object edit
      errors: [],

      options: [], //usado para preencher o select2,
      tipo_conta_corrente: [
        //array do option do select tipo conta corrente
        {
          id: "Nacional",
          text: "Nacional",
        },
        {
          id: "Estrangeiro",
          text: "Estrangeiro",
        },
      ],
      tipoContaCorrente: "Nacional",
      // status: [{
      //     id: 1,
      //     text: 'Activo'
      // }, {
      //     id: 2,
      //     text: 'Desactivo'
      // }],
      // filter: {},
      statusOptions: [
        {
          id: 1,
          text: "Activo",
        },
        {
          id: 2,
          text: "Desactivo",
        },
        {
          id: 3,
          text: "Todos",
        },
      ],
      filter: {
        status_id: 3,
      },
      clienteDetalhes: {},
      saldoActual: "",
      USUARIO_EMPRESA: 2,
      router: "",
    };
  },
  created() {
    this.router =
      this.guard.tipo_user_id == this.USUARIO_EMPRESA
        ? window.location.origin + `/empresa`
        : window.location.origin + `/empresa/funcionario`;

    this.loadPais();
    this.loadTipoCliente();
    this.loadGestores();
  },

  computed: {
    window() {
      return window.Laravel;
    },
    queryClientes() {
      if (this.searchQuery) {
        let result = this.clientes.filter((item) => {
          if (typeof item.nome == "string") {
            const searchQuery = this.searchQuery.toLowerCase();
            return item.nome.toLowerCase().match(searchQuery);
          }
        });

        return result ? result : [];
      } else {
        return this.clientes;
      }
    },
  },

  methods: {
    dateNow() {
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, "0");
      var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
      var yyyy = today.getFullYear();
      today = yyyy + "-" + mm + "-" + dd + "T" + "00:00";
      return today;
    },
    mostrarModalDetalhes(cliente) {
      this.mostrarSaldoCliente(cliente.id).then((response) => {
        this.clienteDetalhes = {
          nome: cliente.nome,
          taxa_de_desconto: cliente.taxa_de_desconto,
          limite_de_credito: cliente.limite_de_credito,
          saldoActual: this.saldoActual,
          endereco: cliente.endereco + " - " + cliente.cidade,
        };
      });
      document.getElementById("ver_detalhes").classList.add("fade");
    },
    async mostrarSaldoCliente(idCliente) {
      let response = await axios.get(
        `${this.router}/clientes/saldoActual/${idCliente}`
      );

      if (response.status === 200) {
        this.saldoActual = response.data;
      } else {
        this.saldoActual = 0.0;
      }
    },
    loadPais() {
      axios.get(`${baseUrl}/paises`).then((res) => {
        res.data.forEach((item) => {
          this.paises.push({
            id: item.id,
            text: item.designacao,
          });
        });
      });
    },

    formatDate() {
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, "0");
      var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
      var yyyy = today.getFullYear();

      today = dd + "/" + mm + "/" + yyyy;

      return today;
    },
    loadTipoCliente() {
      axios.get(`${baseUrl}/tipoCliente`).then((res) => {
        res.data.forEach((item) => {
          this.tipoCliente.push({
            id: item.id,
            text: item.designacao,
          });
        });
      });
    },
    loadGestores() {
      axios.get(`${this.router}/clientes/pegar-dependecias`).then((res) => {
        res.data.forEach((item) => {
          this.gestores.push({
            id: item.id,
            text: item.nome,
          });
        });
      });
    },
    mostrarExtratoConta(cliente) {
      this.errors = [];
      this.clienteExtrato = {
        id: cliente.id,
        dataInicial: this.clienteExtrato.dataInicial,
        dataFinal: this.clienteExtrato.dataFinal,
        nome: cliente.nome,
        conta_corrente: cliente.conta_corrente,
      };
    },
    async imprimirExtrato() {
      this.$loading(true);
      try {
        let response = await axios.post(
          `${this.router}/cliente/imprimirExtratoConta`,
          this.clienteExtrato,
          {
            responseType: "arraybuffer",
          }
        );

        if (response.status === 200) {
          this.$loading(false);
          var file = new Blob([response.data], {
            type: "application/pdf",
          });
          var fileURL = URL.createObjectURL(file);
          window.open(fileURL);
        }
      } catch (error) {
        this.$loading(false);
        console.log("Erro ao carregar pdf");
      }
    },

    imprimir() {
      this.$loading(true);

      axios
        .get(
          `${this.router}/imprimir-clientes?status=` + this.filter.status_id,
          {
            responseType: "arraybuffer",
          }
        )
        .then((response) => {
          if (response.status === 200) {
            this.$loading(false);

            var file = new Blob([response.data], {
              type: "application/pdf",
            });
            var fileURL = URL.createObjectURL(file);
            window.open(fileURL);
          } else {
            this.$loading(false);
            console.log("Erro ao carregar pdf");
          }
          //window.open("/empresa/imprimir/bancos?status=" + this.filter.status_id); //This will open Google in a new window.
        });
    },
    async salvar() {
      this.errors = [];

      this.cliente.tipo_conta_corrente = this.tipoContaCorrente;

      try {
        let response = await axios.post(
          `/empresa/clientes/adicionar`,
          this.cliente
        );

        if (response.status == 200) {
          this.$toasted.global.defaultSuccess();
          this.searchQuery = null;
          this.cliente = {};

          Swal.fire({
            title: "Sucesso",
            text: "Cliente cadastrado com sucesso!",
            icon: "success",
            confirmButtonColor: "#3d5476",
            confirmButtonText: "Ok",
            onClose: () => {
              document.location.reload(true);
            },
          });
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
    editar() {
      this.errors = [];
      axios
        .post(
          `${this.router}/clientes/update/${this.clienteEdit.id}`,
          this.clienteEdit
        )
        .then((response) => {
          if (response.status === 200) {
            this.$toasted.global.defaultSuccess();
            Swal.fire({
              title: "Sucesso",
              text: "Actualização feita com sucesso!",
              icon: "success",
              confirmButtonColor: "#3d5476",
              confirmButtonText: "Ok",
              onClose: () => {
                document.location.reload(true);
              },
            });
          }

          //this.reset();
        })
        .catch((error) => {
          if (error.response.status === 400) {
            this.$toasted.global.defaultError({
              msg: "Erro ao cadastrar",
            });
            this.errors = error.response.data;
          }
        });
    },
    deletarCliente(cliente) {
      Swal.fire({
        title: "Deseja remover o item?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ok",
      }).then((result) => {
        if (result.value) {
          axios
            .get(`${this.router}/clientes/deletar/${cliente.id}`)
            .then((res) => {
              if (res.status == 200) {
                this.$toasted.global.defaultSuccess();

                Swal.fire({
                  title: "Sucesso",
                  text: "Cliente removido com sucesso!...",
                  icon: "success",
                  confirmButtonColor: "#3d5476",
                  confirmButtonText: "Ok",
                  onClose: () => {
                    document.location.reload(true);
                  },
                });
              }
            })
            .catch((error) => {
              this.$toasted.global.defaultError({
                msg: "Sem Permissão para eliminar o fornecedor, contacte o administrador do sistema",
              });
            });
        }
      });
    },
    showModal(item) {
      this.clienteEdit = {};
      this.errors = [];
      this.clienteEdit = Object.assign({}, item);
      this.clienteEdit.data_contrato = this.formatDate(item.data_contrato);
      $("#datapickEdit input").attr("disabled", "true");
    },
  },
  watch: {
    tipoContaCorrente() {
      if (this.tipoContaCorrente == "Nacional") {
        this.cliente.conta_corrente = "31.1.2.1.***";
        this.clienteEdit.conta_corrente = "31.1.2.1.***";
      } else {
        this.cliente.conta_corrente = "31.1.2.2.***";
        this.clienteEdit.conta_corrente = "31.1.2.2.***";
      }
    },
  },
};
</script>

<style>
.has-error {
  border-color: #f2a696 !important;
}

.vdpComponent.vdpWithInput > input {
  padding: 6px !important;
  width: 231px !important;
}
</style>
