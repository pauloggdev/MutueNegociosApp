<template>
<section class="content">
    <div class="row">

        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                CLIENTES
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

                                <input type="text" required autocomplete="on" v-model="searchQuery" class="form-control search-query" placeholder="Buscar clientes por nome e nif..." />
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
                                <a data-toggle="modal" @click.prevent="imprimirClientes" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
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

                            <div class="table-header widget-header">Todos clientes da empresa</div>

                            <!-- div.dataTables_borderWrap -->
                            <div>
                                <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                           
                                            <th>Referência</th>
                                            <th>Empresa</th>
                                            <th>Tipo</th>
                                            <th>Regime</th>
                                            <th>NIF</th>
                                            <th>Telefone</th>
                                            <th>Email</th>
                                            <th>Opções</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr v-for="cliente in queryClientes" :key="cliente.id">
                                            <td>{{cliente.referencia}}</td>
                                            <td>{{(cliente.nome.toString()).toUpperCase()}}</td>
                                            <td>{{cliente.tipocliente.designacao}}</td>
                                            <td>{{cliente.tiporegime.Designacao}}</td>
                                            <td>{{cliente.nif}}</td>
                                            <td>{{cliente.pessoal_Contacto}}</td>
                                            <td>{{cliente.email}}</td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a href="#ver_detalhes" data-toggle="modal" @click.prevent="mostrarModalDetalhes(cliente)" class="pink" title="Editar este registo">
                                                        <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
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

        <!-- VER DETALHES  -->
        <div id="ver_detalhes" class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Ver mais detalhes do cliente
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="left: 0%; position: relative;">

                            <div class="col-md-12">
                                <div class="search-form-text">
                                    <div class="search-text">
                                        <i class="fa fa-pencil"></i>
                                        Detalhes do cliente
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
                                                    Dados do Cliente
                                                </a>
                                            </li>

                                            <li>
                                                <a data-toggle="tab" href="#dadoLicenca">
                                                    <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                                                    Contacto
                                                </a>
                                            </li>
                                            <li>
                                                <a data-toggle="tab" href="#dadosDocumento">
                                                    <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                                                    Documentos
                                                </a>
                                            </li>

                                        </ul>

                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_user" class="tab-pane in active">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Nome do cliente</th>
                                                            <td>{{clienteDetalhes.nome}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Endereço</th>
                                                            <td>{{clienteDetalhes.endereco}}, {{clienteDetalhes.cidade}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">NIF</th>
                                                            <td>{{clienteDetalhes.nif}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Tipo de Cliente</th>
                                                            <td>{{clienteDetalhes.tipocliente.designacao}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Regime</th>
                                                            <td>{{clienteDetalhes.tiporegime.Designacao}}</td>
                                                        </tr>
                                                        <tr>
                                                        <th scope="row">Logotipo</th>
                                                        <td>
                                                            <img style="width:150px;" class="img-fluid" :src="'/upload/'+clienteDetalhes.logotipo" alt="">
                                                        </td>
                                                    </tr>

                                                    </tbody>

                                                </table>

                                            </div>

                                            <div id="dadoLicenca" class="tab-pane">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Telefone</th>
                                                            <td>{{clienteDetalhes.pessoal_Contacto}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Email</th>
                                                            <td>{{clienteDetalhes.email}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Website</th>
                                                            <a :href="clienteDetalhes.Website" target="_blank" rel="noopener noreferrer">{{clienteDetalhes.Website}}</a>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="dadosDocumento" class="tab-pane">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">NIF</th>
                                                            <td>
                                                                <a style="color:#337ab7;" target="blank" :href="clienteDetalhes.file_nif?'/upload/'+clienteDetalhes.file_nif:'#'">{{clienteDetalhes.file_nif?'Baixar NIF':'Sem documento nif'}}</a>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Alvará</th>
                                                            <td>
                                                            <a style="color:#337ab7;" target="blank" :href="clienteDetalhes.file_alvara?'/upload/'+clienteDetalhes.file_alvara:'#'">{{clienteDetalhes.file_alvara?'Baixar alvará':'Sem documento alvará'}}</a>
                                                            </td>
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
    props: ["clientes"],
    data() {

        return {
            searchQuery: "",
            errors: [],
            router: "",
            clienteDetalhes: {
                tipocliente: "",
                tiporegime: ""
            }

        }
    },
    created() {
        this.router = window.location.origin + `/admin`
    },

    computed: {

        queryClientes() {

            if (this.searchQuery) {

                let result = this.clientes.filter(item => {
                    let searchQuery = this.searchQuery.toLowerCase();
                    return item.nome.toLowerCase().match(searchQuery) ||
                        item.nif.match(searchQuery)
                });
                return result ? result : []
            } else {
                return this.clientes
            }

        }

    },

    methods: {
        mostrarModalDetalhes(cliente) {

            this.clienteDetalhes = {};
            this.clienteDetalhes = {
                ...cliente
            }
        },
        async imprimirClientes(){

             this.$loading(true)

            try {
                let response = await axios.get(`${this.router}/imprimirClientes`, {
                    responseType: "arraybuffer",
                });
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

            } catch (error) {
                this.$loading(false)
                console.log("Erro ao carregar pdf");
            }


        }

    }
}
</script>
