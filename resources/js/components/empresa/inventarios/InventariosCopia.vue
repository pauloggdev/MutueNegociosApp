<template>
<div class="row">

    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Inventários
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Listagem
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="col-xs-12">

        <div class>
            <form class="form-search" method="get" action>
                <div class="row" style="margin-bottom:20px">
                    <a href="#criar_inventario" data-toggle="modal" title="Adicionar novo cliente" class="btn btn-success widget-box widget-color-blue" id="botoes">
                        <i class="fa fa-plus"></i> Novo inventário
                    </a>
                    <a data-toggle="modal" href="#modalFiltrarClientes" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                        <i class="fa fa-print text-default"></i> Imprimir
                    </a>
                </div>
            </form>
        </div>
        <div>
            <div class="row" style="margin-bottom:5px">
                <div class="col-md-4">
                    <label class="control-label" for="status_id">
                        Selecione o armazém
                    </label>
                    <div class>
                        <Select2 :options="optionsArmazens" v-model="inventario.armazem_id" @select="selecionarArmazem" placeholder="Escolha o Status">
                        </Select2>
                    </div>
                </div>
                <div class="col-md-4">
                    <label style="padding-top: 0px;" class="control-label bold" for="data_pago_banco">Data</label>
                    <div class="input-group" style="margin-bottom:15px">
                        <date-pick v-model="inventario.dataInicial" format="YYYY-MM-DD"></date-pick>
                    </div>
                </div>
                <!-- <div class="col-md-4">
                    <label style="padding-top: 0px;" class="control-label bold" for="data_pago_banco">Data Final<span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span></label>
                    <div class="input-group" style="margin-bottom:15px">
                        <date-pick v-model="inventario.dataFinal" format="YYYY-MM-DD"></date-pick>
                    </div>
                </div> -->

            </div>
        </div>

        <div class>
            <div class="row">
                <form id="adimitirCandidatos" method="POST" action>
                    <input type="hidden" name="_token" value />

                    <div class="col-xs-12 widget-box widget-color-green" style="left: 0%;">

                        <div class="table-header widget-header">Todos Inventários do Sistema</div>

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
                                        <th>Nº Inventário</th>
                                        <th>Data Inventário</th>
                                        <th>Operador</th>
                                        <th style="text-align: center">Status</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="inventario in queryInventarios" :key="inventario.id">
                                        <td class="center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </td>

                                        <td>{{inventario.numeracao}}</td>
                                        <td>{{inventario.created_at|formatDateTime2}}</td>
                                        <td>{{inventario.user_id}}</td>
                                        <td class="hidden-480" style="text-align: center">
                                            <span v-if="(inventario.status == 1)" class="label label-sm label-success" style="border-radius: 20px;">activo</span>

                                            <span v-else class="label label-sm label-warning" style="border-radius: 20px;">desactivo</span>
                                        </td>

                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#ver_detalhes" data-toggle="modal" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                </a>
                                                <a href="#editar_fornecedor" data-toggle="modal" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-print bigger-150 bolder success text-primary"></i>
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

    <!-- CRIAR INVENTARIO -->
    <div id="criar_inventario" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Inventário
                    </h4>
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
                                                Dados do inventário
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="row" style="margin-bottom:5px">
                                            <div class="col-md-4">
                                                <label style="padding-top: 0px;" class="control-label bold" for="data_pago_banco">
                                                    Data do inventário
                                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-question-circle bold text-danger"></i>
                                                    </span>
                                                </label>
                                                <div class="input-group" style="margin-bottom:15px">
                                                    <date-pick v-model="atualizastockData.data" format="DD-MM-YYYY"></date-pick>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="control-label" for="status_id">
                                                    Selecione o armazém
                                                </label>
                                                <div class>
                                                    <Select2 :options="optionsArmazens" v-model="atualizastockData.armazem_id" @select="selecionarArmazem2" placeholder="Escolha o Status">
                                                    </Select2>
                                                </div>
                                            </div>

                                        </div>
                                       
                                        <div id="dados_user" class="tab-pane in active">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Produto</th>
                                                        <th scope="col">Existência Actual</th>
                                                        <th scope="col">Nova Existência</th>
                                                        <th scope="col">Diferença</th>
                                                        <th scope="col" class="center">Actualizar stock</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(existenciastock, index) in  queryListarExistenciastock" :key="existenciastock.id">
                                                        <td>{{(existenciastock.produtos.designacao).toUpperCase()}}</td>
                                                        <td>{{existenciastock.quantidade|formatQt}}</td>
                                                        <td>
                                                            <div class="input-icon">
                                                                <vue-numeric-input v-model="existenciastock.qtdFisico" @input="alteradoQdtFisica($event, index,existenciastock.quantidade)" :min="0" :step="1" id="quantidade" :class="errors.qtdFisico ? 'has-error' : ''"></vue-numeric-input>
                                                                <span v-if="errors.qtdFisico" class="error">{{errors.qtdFisico[0]}}</span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" disabled  :v-model="diferenca" name="" id="">
                                                        </td>
                                                        <td class="center">
                                                            <input type="checkbox" name="" id="">
                                                        </td>
                                                        <!-- <td>{{actualizastock.quantidade_nova}}</td>
                                                        <td>{{actualizastock.quantidade_nova}}</td>
                                                        <td>{{actualizastock.quantidade_nova}}</td>
                                                        <td>0</td> -->
                                                    </tr>

                                                </tbody>
                                            </table>
                                            <div class="clearfix form-actions">
                                                <div class="col-md-12">
                                                    <label style="padding-top: 0px;" class="control-label bold" for="data_pago_banco">
                                                        Observação
                                                    </label>
                                                    <textarea name="" id="" cols="20" style="width:100%; height:60px;" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="clearfix form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button class="btn btn-success" type="reset" style="border-radius: 10px" @click.prevent="cadastrarInventario">
                                                <i class="ace-icon fa fa-check bigger-110"></i>
                                                Salvar
                                            </button>
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
import DatePicker from "vue2-datepicker";
import VueNumericInput from "vue-numeric-input";

import {
    baseUrl,
    showError
} from "../../../config/global";
export default {
    components: {
        Select2,
        DatePick,
        DatePicker,
        VueNumericInput
    },
    props: ["inventarios", "armazens", "guard", "atualizastock", "existenciastock"],
    data() {

        return {
            searchQuery: "",
            inventario: {
                armazem_id: "",
                dataInicial: "",
                //dataFinal: ""
            },
            atualizastockData: {
                armazem_id: "",
                data: this.formatDate(),

            },
            inventarioData: {},
            optionsInventario: [],
            optionsArmazens: [],
            errors: [],
            USUARIO_EMPRESA: 2,
            router: ""

        }
    },
    created() {

        this.inicializarData();
        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`
        this.listarArmazens()
    },

    computed: {

        diferenca(){

            return this.existenciastock.qtdFisico;

        },

        queryInventarios() {

            if (this.inventario.dataInicial) {

                let dataInicial = this.inventario.dataInicial
                //let  dataFinal = this.inventario.dataFinal
                return this.inventarios.filter(item => {
                    return item.armazem_id == this.inventario.armazem_id && item.data_inventario == dataInicial
                });

            } else {
                return this.inventarios.filter(item => {
                    return item.armazem_id == this.inventario.armazem_id
                });
            }

        },
        queryListarExistenciastock() {

            //let  dataFinal = this.inventario.dataFinal
            return this.existenciastock.filter(item => {
                return item.armazem_id == this.atualizastockData.armazem_id
            });

        }

    },

    methods: {

        // alteradoQdtFisica(e, quantidadeActual){

        //     console.log(this)


        //     if(e == NaN) this.existenciastock.diferenca = quantidadeActual

        //     this.existenciastock.diferenca = quantidadeActual - e;


        //    // if()

        //    // console.log(e);
        //     //console.log(quantidadeActual);

        // },

        cadastrarInventario() {

        },

        listarArmazens() {
            this.armazens.forEach(element => {
                this.optionsArmazens.push({
                    id: element.id,
                    text: element.designacao
                })
            });

            this.inventario.armazem_id = this.armazens[0].id
            this.atualizastockData.armazem_id = this.armazens[0].id
        },
        inicializarData() {

            this.inventario.dataInicial = this.formatDate();
            this.inventario.dataFinal = this.formatDate();
            this.atualizastockData.data = this.formatDate();

        },

        selecionarArmazem(armazem) {
            this.inventario.armazem_id = armazem.id;
        },
        selecionarArmazem2(armazem) {
            this.atualizastockData.armazem_id = armazem.id;
        },
        formatDate() {

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = dd + '-' + mm + '-' + yyyy;

            return today;
        },

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
