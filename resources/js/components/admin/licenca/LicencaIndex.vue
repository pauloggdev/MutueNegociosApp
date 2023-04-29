<template>
<section class="content">
    <div class="row">

        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Licenças
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    listagem
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
                                <a href="#criar_licenca" data-toggle="modal" title="Adicionar nova licenca" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                    <i class="fa fa-plus"></i> Nova Licença
                                </a>
                                <!-- <a href="/empresa/imprimir-clientes" title="Imprimir cliente" target="new" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print"></i> Clientes
                            </a> -->
                                <a data-toggle="modal" @click.prevent="imprimirLicencas" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
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

                            <div class="table-header widget-header">Todas Licenças do Sistema</div>

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
                                            <th>Licença</th>
                                            <th style="text-align:right">Valor</th>
                                            <th>Descrição</th>
                                            <th>Status</th>
                                            <th>Opções</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="licenca in queryLicencas" :key="licenca.id">
                                            <td class="center">
                                                <label class="pos-rel">
                                                    <input type="checkbox" class="ace" />
                                                    <span class="lbl"></span>
                                                </label>
                                            </td>
                                            <td>{{licenca.id}}</td>
                                            <td>{{licenca.designacao}}</td>
                                            <td style="text-align:right">{{licenca.valor | currency}}</td>
                                            <td>{{licenca.descricao}}</td>
                                            <td class="hidden-480" style="text-align: center">
                                                <span v-if="(licenca.statu_geral.id == 1)" class="label label-sm label-success" style="border-radius: 20px;">{{ licenca.statu_geral.designacao }}</span>

                                                <span v-else class="label label-sm label-warning" style="border-radius: 20px;">{{ licenca.statu_geral.designacao }}</span>

                                            </td>

                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a href="#ver_detalhes" data-toggle="modal" @click.prevent="mostrarModalDetalhes(licenca)" class="pink" title="Editar este registo">
                                                        <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                    </a>
                                                    <a href="#editar_licenca" data-toggle="modal" class="pink" @click.prevent="mostrarModalEditar(licenca)" title="Editar este registo">
                                                        <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                    </a>
                                                    <a data-toggle="modal" title="Eliminar este Registro" @click.prevent="deletarLicenca(licenca)" style="cursor:pointer;">
                                                        <i class="ace-icon fa fa-trash-o bigger-150 bolder danger red"></i>
                                                    </a>
                                                    <!-- <a href="#extrato_cliente" data-toggle="modal" title="Imprimir extrato" style="cursor:pointer;">
                                                        <i class="fa fa-print bigger-150 text-default"></i>
                                                    </a> -->
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
        <div id="criar_licenca" class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Nova licença
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
                                        Dados da Licença
                                    </div>
                                </div>
                                <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_cliente">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados da Licença
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_cliente" class="tab-pane in active">
                                                    <div class="form-group has-info">
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Designação
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="licenca.designacao" id="designacao" class="col-md-12 col-xs-12 col-sm-4" :class="errors.designacao?'has-error':''" placeholder="Informe o nome" />
                                                                <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Tipo Licença
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <Select2 :options="tipoLicencaOptions" v-model="licenca.tipo_licenca_id" placeholder="Selecione o tipo de licença">
                                                                </Select2>
                                                                <span v-if="errors.tipo_licenca_id" class="error">{{errors.tipo_licenca_id[0]}}</span>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Status Licença
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <Select2 :options="statusOptions" v-model="licenca.status_licenca_id" placeholder="Selecione o status">
                                                                </Select2>
                                                                <span v-if="errors.status_licenca_id" class="error">{{errors.status_licenca_id[0]}}</span>

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="form-group has-info">
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Valor da licença
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="number" v-model="licenca.valor" id="valor" class="col-md-12 col-xs-12 col-sm-4" :class="errors.valor?'has-error':''" placeholder="Informe o valor da licença" />
                                                                <span v-if="errors.valor" class="error">{{errors.valor[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label bold label-select2" for="spinner3">Limite de Usuários<b class="red fa fa-question-circle"></b></label>
                                                            <div class="input-icon">
                                                                <vue-numeric-input v-model="licenca.limite_usuario" :min="0" :step="1" id="quantidade_destino" :class="errors.limite_usuario ? 'has-error' : ''"></vue-numeric-input>
                                                            </div>
                                                            <span v-if="errors.limite_usuario" class="error">{{errors.limite_usuario[0]}}</span>

                                                        </div>

                                                    </div>
                                                    <div class="form-group has-info">
                                                        <div class="col-md-12">
                                                            <label class="control-label bold" for="descricao">Descrição</label>
                                                            <div class="input-icon">
                                                                <i class="ace-icon fa fa-comment"></i>
                                                                <textarea type="text" style="height:50px" v-model="licenca.descricao" id="descricao" class="col-md-12 col-xs-12 col-sm-4"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" style="border-radius: 10px" @click.prevent="cadastrarLicenca">
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

        <div id="editar_licenca" class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Editar Licença
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
                                        Dados da Licença
                                    </div>
                                </div>
                                <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_cliente">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados da Licença
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_cliente" class="tab-pane in active">
                                                    <div class="form-group has-info">
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Designação
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" :disabled="licencaData.id == 4 || licencaData.id == 1 || licencaData.id == 2 || licencaData == 3 ? true: false" v-model="licencaData.designacao" id="designacao" class="col-md-12 col-xs-12 col-sm-4" :class="errors.designacao?'has-error':''" placeholder="Informe o nome" />
                                                                <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Tipo Licença
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <Select2 :disabled="licencaData.id == 4 || licencaData.id == 1 || licencaData.id == 2 || licencaData == 3 ? true: false" :options="tipoLicencaOptions" v-model="licencaData.tipo_licenca_id" placeholder="Selecione o tipo de licença">
                                                                </Select2>
                                                                <span v-if="errors.tipo_licenca_id" class="error">{{errors.tipo_licenca_id[0]}}</span>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Status Licença
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <Select2 :disabled="licencaData.id == 4 || licencaData.id == 1 || licencaData.id == 2 || licencaData == 3 ? true: false" :options="statusOptions" v-model="licencaData.status_licenca_id" placeholder="Selecione o status">
                                                                </Select2>
                                                                <span v-if="errors.status_licenca_id" class="error">{{errors.status_licenca_id[0]}}</span>

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="form-group has-info">
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Valor da licença
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input :disabled="licencaData.id == 4 || licencaData.id == 1 ? true: false" type="number" v-model="licencaData.valor" id="valor" class="col-md-12 col-xs-12 col-sm-4" :class="errors.valor?'has-error':''" placeholder="Informe o valor da licença" />
                                                                <span v-if="errors.valor" class="error">{{errors.valor[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label bold label-select2" for="spinner3">Limite de Usuários<b class="red fa fa-question-circle"></b></label>
                                                            <div class="input-icon">
                                                                <vue-numeric-input v-model="licencaData.limite_usuario" :min="0" :step="1" id="quantidade_destino" :class="errors.limite_usuario ? 'has-error' : ''"></vue-numeric-input>
                                                            </div>
                                                            <span v-if="errors.limite_usuario" class="error">{{errors.limite_usuario[0]}}</span>

                                                        </div>

                                                    </div>
                                                    <div class="form-group has-info">
                                                        <div class="col-md-12">
                                                            <label class="control-label bold" for="descricao">Descrição</label>
                                                            <div class="input-icon">
                                                                <i class="ace-icon fa fa-comment"></i>
                                                                <textarea type="text" style="height:50px" v-model="licencaData.descricao" id="descricao" class="col-md-12 col-xs-12 col-sm-4"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" style="border-radius: 10px" @click.prevent="editarLicenca">
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
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Ver mais detalhes da licença
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="left: 0%; position: relative;">

                            <div class="col-md-12">
                                <div class="search-form-text">
                                    <div class="search-text">
                                        <i class="fa fa-pencil"></i>
                                        Detalhes da licença
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
                                                    Dados do Licença
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_user" class="tab-pane in active">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Licença</th>
                                                            <td>{{licencaDetalhes.designacao}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Valor da Licença</th>
                                                            <td>{{licencaDetalhes.valor}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Limite Utilizadores</th>
                                                            <td>{{licencaDetalhes.limite_usuario}}</td>
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
</section>
</template>

<script>
import Select2 from 'v-select2-component';
import DatePick from 'vue-date-pick';
import Swal from "sweetalert2";
import VueNumericInput from "vue-numeric-input";

import {
    baseUrl,
    showError
} from "../../../config/global";
export default {
    components: {
        Select2,
        DatePick,
        VueNumericInput

    },
    props: ["licencas", "tipolicencas", "status"],
    data() {

        return {
            searchQuery: "",
            licenca: {
                limite_usuario: 1,
                canal_id: 3 //PORTA ADMIN
            },
            errors: [],
            licencaDetalhes: {},
            licencaData: {},
            tipoLicencaOptions: [],
            statusOptions: [],
            router: ""

        }
    },
    created() {

        this.listarTipoLicencas();
        this.listarStatus();
        this.router = window.location.origin + `/admin`

        

    },

    computed: {

        queryLicencas() {

            if (this.searchQuery) {

                let result = this.licencas.filter(item => {
                    let searchQuery = this.searchQuery.toLowerCase();
                    return item.designacao.toLowerCase().match(searchQuery) ||
                        item.descricao.toLowerCase().match(searchQuery)
                });
                return result ? result : []
            } else {
                return this.licencas
            }

        }

    },

    methods: {

        currency(valor) {
            return valor.toLocaleString('de-DE', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 3
            })
        },
        formatQt(valor) {
            return valor.toLocaleString('de-DE', {
                minimumFractionDigits: 1,
                maximumFractionDigits: 1
            })
        },

        listarTipoLicencas() {
            this.tipolicencas.forEach(element => {
                this.tipoLicencaOptions.push({
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
            this.licenca.status_licenca_id = this.status[0].id
        },
        mostrarModalDetalhes(licenca) {


            this.licencaDetalhes = {};
            this.licencaDetalhes = {
                designacao: licenca.designacao,
                valor: this.currency(licenca.valor),
                limite_usuario: this.formatQt(licenca.limite_usuario)
            }

        },

        mostrarModalEditar(licenca) {

            this.licencaData = {};
            this.errors = [];
            this.licencaData = Object.assign({}, licenca);

        },

        deletarLicenca(licenca) {

            Swal.fire({
                title: "Deseja remover o item?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ok",
            }).then((result) => {
                if (result.value) {
                    axios.get(`${this.router}/licencas/deletar/${licenca.id}`).then((res) => {

                        if (res.status == 200) {
                            this.$toasted.global.defaultSuccess();

                            Swal.fire({
                                title: 'Sucesso',
                                text: 'Cliente cadastrado com sucesso!...',
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
        async cadastrarLicenca() {

            let licenca = {
                canal_id: this.licenca.canal_id,
                designacao: this.licenca.designacao,
                limite_usuario: Number(this.licenca.limite_usuario),
                status_licenca_id: Number(this.licenca.status_licenca_id),
                tipo_licenca_id: Number(this.licenca.tipo_licenca_id),
                descricao: this.licencaData.descricao,

                valor: Number(this.licenca.valor),
            }

            try {
                let response = await axios.post(`${this.router}/licencas/adicionar`, licenca);

                if (response.status == 200) {
                    this.$toasted.global.defaultSuccess();
                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Licença cadastrado com sucesso!...',
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
        async editarLicenca() {

            let licencaData = {
                canal_id: this.licencaData.canal_id,
                designacao: this.licencaData.designacao,
                limite_usuario: Number(this.licencaData.limite_usuario),
                status_licenca_id: Number(this.licencaData.status_licenca_id),
                descricao: this.licencaData.descricao,
                tipo_licenca_id: Number(this.licencaData.tipo_licenca_id),
                valor: Number(this.licencaData.valor),
            }

            try {
                let response = await axios.put(`${this.router}/licencas/update/${this.licencaData.id}`, licencaData);
                if (response.status == 200) {
                    this.$toasted.global.defaultSuccess();
                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Licença editado com sucesso!...',
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
        async imprimirLicencas(){

            this.$loading(true)
            try {
                let response = await axios.get(`${this.router}/imprimirLicencas`, {
                    responseType: "arraybuffer",
                }).then((response) => {
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
                });
            } catch (error) {
                this.$loading(false)
                console.log("Erro ao carregar pdf");
            }

        }
    }
}
</script>
