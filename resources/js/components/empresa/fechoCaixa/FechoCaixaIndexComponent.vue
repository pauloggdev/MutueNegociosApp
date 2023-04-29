<template>
<div class="row">

    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Fecho de caixa
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
                                        <th>Data do fecho</th>
                                        <th>Valor Cash/Dinheiro</th>
                                        <th>Valor transferência</th>
                                        <th>Valor depósito</th>
                                        <th>Valor multicaixa</th>
                                        <th>Facturas anuladas</th>
                                        <th>Facturas Proforma</th>
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
                                                <a href="#editar_fornecedor" data-toggle="modal" class="pink" @click.prevent="mostrarModalEditar(fornecedor)" title="Editar este registo">
                                                    <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                </a>
                                                <a data-toggle="modal" title="Eliminar este Registro" @click.prevent="deletarFornecedor(fornecedor)" style="cursor:pointer;">
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


</div>
</template>

<script>
import Select2 from 'v-select2-component';
import DatePick from 'vue-date-pick';
import Swal from "sweetalert2";

import {
    baseUrl,
    showError
} from "../../../config/global";
export default {
    components: {
        Select2,
        DatePick
    },
    props: ["guard"],
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
        },
        formatDate() {

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = yyyy + '-' + mm + '-' + dd;

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
        async cadastrarFornecedor() {

            try {
                let response = await axios.post(`${this.router}/fornecedores/adicionar`, this.fornecedor);
                if (response.status == 200) {
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
            } catch (error) {
                this.errors = error.response.data.errors;
            }
        },
        async editarFornecedor() {

            try {
                let response = await axios.put(`${this.router}/fornecedores/update/${this.fornecedorData.id}`, this.fornecedorData);
                if (response.status == 200) {
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
