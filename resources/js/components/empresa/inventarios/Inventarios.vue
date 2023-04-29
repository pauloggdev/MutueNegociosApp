<template>
<div class="row">

    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Inventário
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

                            <input type="text" required autocomplete="on" v-model="searchQuery" class="form-control search-query" placeholder="Buscar por numeração do inventário..." />
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
                            <a href="#criar_inventario" data-toggle="modal" title="Adicionar novo cliente" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-plus"></i> Novo inventário
                            </a>
                            <!-- <a href="/empresa/imprimir-clientes" title="Imprimir cliente" target="new" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print"></i> Clientes
                            </a> -->
                            <!-- <a data-toggle="modal" href="#modalFiltrarClientes" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
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

                        <div class="table-header widget-header">Todos inventarios do Sistema</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>

                                        <th>Código</th>
                                        <th>Numeração</th>
                                        <th>Data Inventário</th>
                                        <th>Armazém</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="inventario in queryInventarios" :key="inventario.id">

                                        <td>{{ inventario.id }}</td>
                                        <td>{{ inventario.numeracao }}</td>
                                        <td>{{ inventario.data_inventario | formatDate }}</td>
                                        <td>{{ inventario.armazem.designacao.toUpperCase()}}</td>
                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#ver_detalhes" data-toggle="modal" @click.prevent="mostrarModalDetalhes(inventario)" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                </a>

                                                <a title="Imprimir extrato" style="cursor:pointer;" @click.prevent="imprimirInventario(inventario.id)">
                                                    <i class="fa fa-print bigger-150 text-primary"></i>
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
        <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
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
                            <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                <div class="second-row">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs padding-16">
                                            <li class="active">
                                                <a data-toggle="tab" href="#dados_banco">
                                                    <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
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
                                                        <date-pick v-model="dataInventario" format="DD-MM-YYYY"></date-pick>
                                                    </div>
                                                    <span v-if="errors.data_inventario" class="error">{{errors.data_inventario[0]}}</span>

                                                </div>
                                                <div class="col-md-8">
                                                    <label class="control-label" for="status_id">
                                                        Selecione o armazém
                                                    </label>
                                                    <div class>
                                                        <Select2 :options="optionsArmazens" v-model="armazemInventario" @select="selecionarArmazem2" placeholder="Escolha o Status">
                                                        </Select2>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="" style="float:right">
                                                <input type="checkbox" name="" id="actualizaTodos" @click="actualizarTodosProduto">
                                                <label for="actualizaTodos">
                                                    Actualizar todos
                                                </label>

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
                                                        <tr v-for="(existenciastock, index) in inventarioData" :key="existenciastock.existenciaId">

                                                            <td>{{(existenciastock.produtoDesignacao).toUpperCase()}}</td>
                                                            <td>{{existenciastock.existenciaActual|formatQt}}</td>
                                                            <td>
                                                                <div class="input-icon">
                                                                    <vue-numeric-input v-model="existenciastock.existenciaNova" @input="alteradoQdtFisica($event, index, existenciastock.existenciaActual)" :min="0" :step="1" id="quantidade" :class="errors.existenciaActual ? 'has-error' : ''"></vue-numeric-input>
                                                                    <!-- <span v-if="errors.qtdFisico" class="error">{{errors.qtdFisico[0]}}</span> -->
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <input type="text" disabled v-model="existenciastock.diferenca" name="" id="">
                                                            </td>
                                                            <td class="center">
                                                                <input type="checkbox" @input="checkActualizarStock($event, index)" name="" class="checkedInventario">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <div>
                                                    <label class="control-label" for="status_id">
                                                        Observação
                                                    </label>
                                                    <textarea name="" v-model="observacao" id="" style="width:100%; height:50px" cols="30" rows="10"></textarea>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" style="border-radius: 10px" data-dismiss="modal" @click.prevent="salvarInventario">
                                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                                    Salvar
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
    <!-- VER DETALHES  -->
    <div id="ver_detalhes" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Ver mais detalhes do Inventário
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">

                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Detalhes do Inventário
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
                                                Dados de actualização de produto
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content profile-edit-tab-content">
                                        <div id="dados_user" class="tab-pane in active">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Código</th>
                                                        <th scope="col">Produto</th>
                                                        <th scope="col">Existência Anterior</th>
                                                        <th scope="col">Existência Nova</th>
                                                        <th scope="col">Diferença</th>
                                                        <th scope="col">Actualizou</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="inventarioItem in inventarioDetalhes" :key="inventarioItem.id">
                                                        <td>{{inventarioItem.produto.id}}</td>
                                                        <td>{{inventarioItem.produto.designacao.toUpperCase()}}</td>
                                                        <td>{{inventarioItem.existenciaAnterior | formatQt}}</td>
                                                        <td>{{inventarioItem.existenciaActual | formatQt}}</td>
                                                        <td>{{inventarioItem.diferenca | formatQt}}</td>
                                                        <td>{{inventarioItem.actualizou}}</td>
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
import VueNumericInput from "vue-numeric-input";

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
        DatePick,
        VueNumericInput
    },
    props: ["armazens", "inventarios", "existenciastock", "guard"],
    data() {

        return {
            searchQuery: "",
            dataInventario: this.formatDate(),
            armazemInventario: "",
            observacao: "",
            optionsArmazens: [],
            errors: [],
            USUARIO_EMPRESA: 2,
            router: "",
            inventarioData: [],
            inventarioDetalhes: ""

        }
    },
    created() {
        //console.log(this.inventarios);
        this.listarArmazens();
        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`

    },
    mounted() {
        this.listarExistencia()
    },
    computed: {
        queryInventarios() {
            if (this.searchQuery) {
                let result = this.inventarios.filter((item) => {

                    let searchQuery = this.searchQuery.toLowerCase();
                    return item.numeracao.toLowerCase().match(searchQuery)
                });

                return result ? result : [];
            } else {
                return this.inventarios;
            }
        },
    },
    methods: {

        salvarInventario() {

            this.errors = [];

            if (this.verificarSeAlterouInventario()) {
                this.$loading(true)

                const data = {
                    data_inventario: this.dataInventario,
                    armazem_id: this.armazemInventario,
                    inventarioData: this.inventarioData,
                    observacao: this.observacao
                }
                this.errors = [];
                axios.post(`${this.router}/inventario/adicionar`, data).then((response) => {

                        if (response.status === 200) {
                            this.imprimirInventario(response.data);

                            this.$toasted.global.defaultSuccess();
                            Swal.fire({
                                title: 'Sucesso',
                                text: 'Inventário registado com sucesso!',
                                icon: 'success',
                                confirmButtonColor: '#3d5476',
                                confirmButtonText: 'Ok',
                                onClose: () => {
                                    document.location.reload(true)
                                }
                            });

                        }

                    })
                    .catch((error) => {

                        this.$loading(false)

                        if (error.response.status === 400) {
                            this.$toasted.global.defaultError({
                                msg: "Erro ao cadastrar"
                            });
                            this.errors = error.response.data;
                        }
                    });
            }
        },
        mostrarModalDetalhes(inventario) {
            this.inventarioDetalhes = inventario.inventario_items;
        },

        verificarSeAlterouInventario() {
            return this.inventarioData.some(el => el.existenciaActual != el.existenciaNova)
        },

        formatQt(value) {
            return value.toLocaleString('de-DE', {
                minimumFractionDigits: 1,
                maximumFractionDigits: 1
            })

        },
        async imprimirInventario(inventarioId) {

            try {
                this.$loading(true)

                let response = await axios.get(`${this.router}/inventario/imprimir/${inventarioId}`, {
                    responseType: "arraybuffer"
                });

                if (response.status === 200) {

                    this.$loading(false)
                    var file = new Blob([response.data], {
                        type: "application/pdf",
                    });
                    var fileURL = URL.createObjectURL(file);
                    window.open(fileURL);
               //     document.location.reload(true)

                } else {
                    this.$loading(false)
                    console.log("Erro ao carregar pdf");
                }

            } catch (error) {
                this.$loading(false)
                console.log("Erro ao carregar pdf");

            }

        },

        checkActualizarStock(event, index) {
            const checked = event.target.checked
            this.inventarioData[index].checked = checked
        },

        alteradoQdtFisica(value, index, existenciaActual) {

            const existenciaNova = value ? value : 0

            this.inventarioData[index].existenciaNova = existenciaNova
            this.inventarioData[index].diferenca = this.formatQt(existenciaNova - existenciaActual);

        },

        listarArmazens() {
            this.armazens.forEach(element => {
                this.optionsArmazens.push({
                    id: element.id,
                    text: element.designacao
                })
            });
            this.armazemInventario = this.armazens[0].id
        },
        selecionarArmazem2(armazem) {
            this.armazemInventario = armazem.id;
            this.listarExistencia();
        },
        listarExistencia() {

            this.inventarioData = [];
            this.existenciastock.filter((existencia, index) => {

                if (existencia.armazem_id == this.armazemInventario) {


                    this.inventarioData.push({
                        id: existencia.id,
                        produto_id: existencia.produto_id,
                        produtoDesignacao: existencia.produtoDesignacao,
                        existenciaActual: existencia.quantidade,
                        preco_venda: existencia.preco_venda,
                        preco_compra: existencia.preco_compra,
                        existenciaNova: existencia.quantidade,
                        diferenca: this.formatQt(0),
                        checked: false
                    })
                }
            });

        },
        formatDate() {

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = dd + '-' + mm + '-' + yyyy;

            return today;
        },

        actualizarTodosProduto() {

            const checked = document.getElementById("actualizaTodos").checked;

            this.inventarioData.forEach(inventario => {
                inventario.checked = checked;
            })

            const allChecked = document.querySelectorAll(".checkedInventario");
            Array.from(allChecked).forEach(element => {
                element.checked = checked;
            });

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
