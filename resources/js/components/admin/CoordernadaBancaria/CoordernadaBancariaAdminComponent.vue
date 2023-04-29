<template>
<section class="content">
    <div class="row">

        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Coordernada Bancaria
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

                                <input type="text" required autocomplete="on" v-model="searchQuery" class="form-control search-query" placeholder="Buscar Por banco..." />
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
                                <a href="#adicionar_banco" data-toggle="modal" title="Adicionar nova licenca" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                    <i class="fa fa-plus"></i> Novo Coord. bancaria
                                </a>
                                <!-- <a href="/empresa/imprimir-clientes" title="Imprimir cliente" target="new" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print"></i> Clientes
                            </a> -->
                                <!-- <a data-toggle="modal" @click.prevent="imprimirBancos" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                    <i class="fa fa-print text-default"></i> Imprimir
                                </a> -->

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

                            <div class="table-header widget-header">Todos coordernadas bancarias do Sistema</div>

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
                                            <th>Banco</th>
                                            <th>Nº Conta</th>
                                            <th>Iban</th>
                                            <th>Status</th>
                                            <th>Opções</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="coordernadaBancaria in queryCoordernadaBancaria" :key="coordernadaBancaria.id">
                                            <td class="center">
                                                <label class="pos-rel">
                                                    <input type="checkbox" class="ace" />
                                                    <span class="lbl"></span>
                                                </label>
                                            </td>
                                            <td>{{coordernadaBancaria.id}}</td>
                                            <td>{{coordernadaBancaria.banco.designacao}}</td>
                                            <td>{{coordernadaBancaria.num_conta}}</td>
                                            <td>{{coordernadaBancaria.iban}}</td>
                                            <td class="hidden-480" style="text-align: center">
                                                <span v-if="(coordernadaBancaria.status_id == 1)" class="label label-sm label-success" style="border-radius: 20px;">{{ coordernadaBancaria.statu_geral.designacao }}</span>
                                                <span v-else class="label label-sm label-warning" style="border-radius: 20px;">{{ coordernadaBancaria.statu_geral.designacao }}</span>
                                            </td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a href="#editar_banco" data-toggle="modal" class="pink" @click.prevent="mostrarModalEditar(coordernadaBancaria)" title="Editar este registo">
                                                        <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                    </a>
                                                    <a data-toggle="modal" title="Eliminar este Registro" @click.prevent="deletarCoordernadaBancaria(coordernadaBancaria)" style="cursor:pointer;">
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

        <!-- ADICIONAR COORDERNADAS  BANCARIA-->
        <div id="adicionar_banco" class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar coordernadas bancaria
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
                                        Dados da coordernada bancária
                                    </div>
                                </div>
                                <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_cliente">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados da coordernada bancária
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_cliente" class="tab-pane in active">
                                                    <div class="form-group has-info">
                                                        <div class="col-md-6">
                                                            <label class="control-label" for="num_conta">
                                                                Nº Conta
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="coordernadabancaria.num_conta" id="num_conta" class="col-md-12 col-xs-12 col-sm-4" :class="errors.num_conta?'has-error':''" placeholder="Informe o nº conta" />
                                                                <span v-if="errors.num_conta" class="error">{{errors.num_conta[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="control-label" for="num_conta">
                                                                Iban
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="coordernadabancaria.iban" id="num_conta" class="col-md-12 col-xs-12 col-sm-4" :class="errors.iban?'has-error':''" placeholder="Informe o iban" />
                                                                <span v-if="errors.iban" class="error">{{errors.iban[0]}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-info">
                                                        <div class="col-md-8">
                                                            <label class="control-label" for="designacao">
                                                                Bancos
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <Select2 :options="optionsBancos" v-model="coordernadabancaria.banco_id" placeholder="Selecione o banco">
                                                                </Select2>
                                                                <span v-if="errors.banco_id" class="error">{{errors.banco_id[0]}}</span>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Status
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <Select2 :options="optionStatus" v-model="coordernadabancaria.status_id" placeholder="Selecione o status">
                                                                </Select2>
                                                                <!-- <span v-if="errors.status_id" class="error">{{errors.status_id[0]}}</span> -->

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" style="border-radius: 10px" @click.prevent="salvarCoordernadaBancaria">
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
        <!-- EDITAR COORDERNADAS  BANCARIA-->
        <div id="editar_banco" class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar coordernadas bancaria
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
                                        Dados da coordernada bancária
                                    </div>
                                </div>
                                <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_cliente">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados da coordernada bancária
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_cliente" class="tab-pane in active">
                                                    <div class="form-group has-info">
                                                        <div class="col-md-6">
                                                            <label class="control-label" for="num_conta">
                                                                Nº Conta
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="coordernadaBancariaEdit.num_conta" id="num_conta" class="col-md-12 col-xs-12 col-sm-4" :class="errors.num_conta?'has-error':''" placeholder="Informe o nº conta" />
                                                                <span v-if="errors.num_conta" class="error">{{errors.num_conta[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="control-label" for="num_conta">
                                                                Iban
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="coordernadaBancariaEdit.iban" id="num_conta" class="col-md-12 col-xs-12 col-sm-4" :class="errors.iban?'has-error':''" placeholder="Informe o iban" />
                                                                <span v-if="errors.iban" class="error">{{errors.iban[0]}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-info">
                                                        <div class="col-md-8">
                                                            <label class="control-label" for="designacao">
                                                                Bancos
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <Select2 :options="optionsBancos" v-model="coordernadaBancariaEdit.banco_id" placeholder="Selecione o banco">
                                                                </Select2>
                                                                <span v-if="errors.banco_id" class="error">{{errors.banco_id[0]}}</span>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Status
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span> </label>
                                                            <div class>
                                                                <Select2 :options="optionStatus" v-model="coordernadaBancariaEdit.status_id" placeholder="Selecione o status">
                                                                </Select2>
                                                                <!-- <span v-if="errors.status_id" class="error">{{errors.status_id[0]}}</span> -->

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" style="border-radius: 10px" @click.prevent="editarCoordernadaBancaria">
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
    props: ["coordernadasbancaria", "status", "bancos"],
    data() {

        return {
            searchQuery: "",
            errors: [],
            router: "",
            coordernadabancaria: {},
            optionsBancos: [],
            optionStatus: [],
            coordernadaBancariaEdit: {},

        }
    },
    created() {
        this.listarStatus();
        this.listarBancos();
        this.router = window.location.origin + `/admin`
    },

    computed: {

        queryCoordernadaBancaria() {

            if (this.searchQuery) {

                let result = this.coordernadasbancaria.filter(item => {
                    let searchQuery = this.searchQuery.toLowerCase();
                    return item.designacao.toLowerCase().match(searchQuery) ||
                        item.sigla.toLowerCase().match(searchQuery)
                });
                return result ? result : []
            } else {
                return this.coordernadasbancaria
            }
        }

    },

    methods: {

        listarBancos() {

            this.bancos.forEach(banco => {

                this.optionsBancos.push({
                    id: banco.id,
                    text: banco.designacao
                })

            });

        },

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

        mostrarModalEditar(coordernada) {

            this.coordernadaBancariaEdit = {};
            this.errors = [];
            this.coordernadaBancariaEdit = Object.assign({}, coordernada);

        },
        listarStatus() {
            this.status.forEach(statu => {
                this.optionStatus.push({
                    id: statu.id,
                    text: statu.designacao
                })
            });
            this.coordernadabancaria.status_id = this.status[0].id
        },
        async salvarCoordernadaBancaria() {

            this.coordernadabancaria.canal_id = 3;
            try {

                let response = await axios.post(`${this.router}/coordenadasbancaria`, this.coordernadabancaria);

                if (response.status == 200) {
                    this.$toasted.global.defaultSuccess();
                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Coordernada bancária cadastrado com sucesso!',
                        icon: 'success',
                        confirmButtonColor: '#3d5476',
                        confirmButtonText: 'Ok',
                        onClose: () => {
                            document.location.reload(true)
                        }
                    });
                }

            } catch (error) {
                this.errors = error.response.data;
                this.$toasted.global.defaultError({
                    msg: "Erro ao cadastrao a coordernada bancarias",
                });
            }

        },
        async editarCoordernadaBancaria() {
            this.coordernadaBancariaEdit.canal_id = 3;
            try {

                let response = await axios.put(`${this.router}/coordenadasbancaria/${this.coordernadaBancariaEdit.id}`, this.coordernadaBancariaEdit);

                if (response.status == 200) {
                    this.$toasted.global.defaultSuccess();
                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Coordernada bancária cadastrado com sucesso!',
                        icon: 'success',
                        confirmButtonColor: '#3d5476',
                        confirmButtonText: 'Ok',
                        onClose: () => {
                           document.location.reload(true)
                        }
                    });
                }

            } catch (error) {
                this.errors = error.response.data;
                this.$toasted.global.defaultError({
                    msg: "Erro ao cadastrao a coordernada bancarias",
                });
            }
        },
        deletarCoordernadaBancaria(coordernadaBancaria){


              Swal.fire({
                title: "Deseja remover o item?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ok",
            }).then((result) => {
                if (result.value) {
                    axios.delete(`${this.router}/coordenadasbancaria/${coordernadaBancaria.id}`).then((response) => {
                        if (response.status == 200) {
                            this.$toasted.global.defaultSuccess();

                            Swal.fire({
                                title: 'Sucesso',
                                text: 'Coordernada bancaria removido com sucesso!',
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
                            msg: "Sem Permissão para eliminar a coordernada bancaria, contacte o administrador do sistema",
                        });
                    });
                }
            });

        },

        // async salvarBanco() {

        //     const banco = {
        //         canal_id: 3, //admin,
        //         designacao: this.banco.designacao,
        //         sigla: this.banco.sigla,
        //         status_id: this.banco.status_id
        //     }

        //     try {
        //         let response = await axios.post(`${this.router}/bancos`, banco);

        //         if (response.status == 200) {
        //             this.$toasted.global.defaultSuccess();
        //             Swal.fire({
        //                 title: 'Sucesso',
        //                 text: 'Banco cadastrado com sucesso!',
        //                 icon: 'success',
        //                 confirmButtonColor: '#3d5476',
        //                 confirmButtonText: 'Ok',
        //                 onClose: () => {
        //                     document.location.reload(true)
        //                 }
        //             });
        //         }
        //     } catch (error) {
        //         this.errors = error.response.data;
        //         this.$toasted.global.defaultError({
        //             msg: "Erro ao cadastrao o banco",
        //         });
        //     }

        // },
        // async editarBanco() {

        //     try {
        //         let response = await axios.put(`${this.router}/bancos/${this.bancoData.id}`, this.bancoData);

        //         console.log(response.data);

        //         if (response.status == 200) {
        //             this.$toasted.global.defaultSuccess();
        //             Swal.fire({
        //                 title: 'Sucesso',
        //                 text: 'Banco actualizado com sucesso!',
        //                 icon: 'success',
        //                 confirmButtonColor: '#3d5476',
        //                 confirmButtonText: 'Ok',
        //                 onClose: () => {
        //                     document.location.reload(true)
        //                 }
        //             });
        //         }
        //     } catch (error) {
        //         this.errors = error.response.data;
        //         this.$toasted.global.defaultError({
        //             msg: "Erro ao actualizar o banco",
        //         });
        //     }

        // },

        // deletarCoordernadaBancaria(banco) {

        //     Swal.fire({
        //         title: "Deseja remover o item?",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Ok",
        //     }).then((result) => {
        //         if (result.value) {
        //             axios.delete(`${this.router}/bancos/${banco.id}`).then((response) => {

        //                 console.log(response.data);

        //                 if (response.status == 200) {
        //                     this.$toasted.global.defaultSuccess();

        //                     Swal.fire({
        //                         title: 'Sucesso',
        //                         text: 'Banco removido com sucesso!',
        //                         icon: 'success',
        //                         confirmButtonColor: '#3d5476',
        //                         confirmButtonText: 'Ok',
        //                         onClose: () => {
        //                             //document.location.reload(true)
        //                         }
        //                     });
        //                 }
        //             }).catch((error) => {
        //                 this.$toasted.global.defaultError({
        //                     msg: "Sem Permissão para eliminar o fornecedor, contacte o administrador do sistema",
        //                 });
        //             });
        //         }
        //     });

        // },
        // async imprimirBancos() {

        //     this.$loading(true)
        //     try {
        //         let response = await axios.get(`${this.router}/imprimirBancos`, {
        //             responseType: "arraybuffer",
        //         }).then((response) => {
        //             if (response.status === 200) {

        //                 this.$loading(false)
        //                 var file = new Blob([response.data], {
        //                     type: "application/pdf",
        //                 });
        //                 var fileURL = URL.createObjectURL(file);
        //                 window.open(fileURL);
        //             } else {
        //                 this.$loading(false)
        //                 console.log("Erro ao carregar pdf");
        //             }
        //         });
        //     } catch (error) {
        //         this.$loading(false)
        //         console.log("Erro ao carregar pdf");
        //     }

        // }

    }
}
</script>
