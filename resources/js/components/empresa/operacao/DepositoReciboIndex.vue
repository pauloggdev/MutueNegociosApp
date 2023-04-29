<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Depositos - Recibos
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Listagem
            </small>
        </h1>
    </div>
    <!-- /.page-header -->

    <div class="col-xs-12">
        <div>
            <form class="form-search" method="get">
                <div class="row">
                    <div>
                        <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-search"></i>
                            </span>

                            <input type="text" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar por nome, nif do cliente, numeração NC e numeração da factura..." />
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
                <form id="adimitirCandidatos" method="POST">
                    <div class="col-xs-12 widget-box widget-color-green" style="left: 0%;">
                        <div class="clearfix">
                            <a :href="router+'/facturas/recibo/novo'" title="emitir novo recibo" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa icofont-plus-circle"></i> Novo recibo
                            </a>
                            <a data-toggle="modal" @click.prevent="imprimir" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a>
                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <div class="table-header widget-header">Todas recibos emitidos</div>

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
                                        <th>Numeração</th>
                                        <th>Factura Referente</th>
                                        <th class="">Cliente</th>
                                        <th style="text-align:right">Valor Entregue</th>
                                        <th class="">Data Criada</th>
                                        <th class="">Forma Pagamento</th>
                                        <th style="text-align:center">Anulado</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>

                                <tbody v-if="datarecibos.length">
                                    <tr v-for="recibo in queryReciboData" :key="recibo.id">

                                        <td class="center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </td>

                                        <td>{{recibo.numeracao_recibo}}</td>
                                        <td>{{recibo.recibos_items[0].factura.numeracaoFactura}}</td>
                                        <td class="">{{recibo.cliente.nome}}</td>
                                        <td class="" style="text-align:right">{{recibo.valor_total_entregue | currency}}</td>
                                        <td class="">{{recibo.created_at | formatDateTime}}</td>
                                        <td class="">{{recibo.forma_pagamento.descricao}}</td>
                                        <td class="hidden-480" style="text-align:center">
                                            <span class="label label-sm " :class="recibo.anulado == 1?'label-success':'label-danger'">{{recibo.anulado == 1?"Não":"Sim"}}</span>
                                        </td>
                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#ver_detalhes" data-toggle="modal" @click.prevent="mostrarModalDetalhes(recibo)" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                </a>
                                                <a @click.prevent="printRecibo(recibo.id)" style="cursor: pointer;" class="pink" title="Editar este registo">
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
    <!-- /.col -->
    <!-- VER DETALHES  -->
    <div id="ver_detalhes" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Ver mais detalhes do Recibo
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
                                                        <th scope="col">Telefone</th>
                                                        <th scope="col">NIF</th>
                                                        <th scope="col">E-mail</th>
                                                        <th scope="col">Conta Corrente</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{reciboDetalhe.telefone_cliente}}</td>
                                                        <td>{{reciboDetalhe.nif_cliente}}</td>
                                                        <td>{{reciboDetalhe.email_cliente}}</td>
                                                        <td>{{reciboDetalhe.conta_corrente_cliente}}</td>
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
<!-- /.row -->
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";
import Swal from "sweetalert2";
import {
    showError,
    baseUrl
} from "./../../../config/global";
import {
    mapState
} from "vuex";

export default {
    props: ['guard', "datarecibos"],
    components: {
        Select2,
    },

    data() {
        return {
            searchQuery: '',
            clientes: [],
            errors: [],
            conta_corrente: "",
            reciboDetalhe:{},
            // dataNotaCredito: [],
            notaCreditoData: {
                cliente_id: "",
                valor_credito: "",
                descricao: ""
            },
            /**
             * constantes usados
             */
            USUARIO_EMPRESA: 2,
            router: ""
        };

    },
    computed: {
        queryReciboData() {
            if (this.searchQuery) {
                let result = this.datarecibos.filter((item) => {

                    let searchQuery = this.searchQuery.toLowerCase();
                    return item.cliente.nome.toLowerCase().match(searchQuery) ||
                        item.cliente.nif.toLowerCase().match(searchQuery) ||
                        item.numeracao_recibo.toLowerCase().match(searchQuery) ||
                        item.recibos_items[0].factura.numeracaoFactura.toLowerCase().match(searchQuery)
                });

                return result ? result : [];
            } else {
                return this.datarecibos;
            }
        },
    },

    created() {

       

        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`

        //this.listarNotaCredito();

        // this.listarTipoFormaPagamento();

        // this.status.forEach((element) => {
        //     this.statusGerais.push({
        //         id: element.id,
        //         text: element.designacao,
        //     });
        // });
    },

    methods: {

        mostrarModalDetalhes(recibo) {
            this.reciboDetalhe = recibo;
        },

        imprimir() {
            this.$loading(true)
            axios
                .get(
                    `${this.router}/imprimirTodosRecibos`, {
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

        // async listarNotaCredito() {

        //     try {

        //         let response = await axios.get(window.location.origin + `/empresa/listarNotaCredito`)

        //         if (response.status === 200) {
        //             this.datanotacredito = response.data;
        //         }
        //     } catch (error) {
        //         console.log("ERRO API");
        //     }
        // },

        selectCliente(c) {
            this.conta_corrente = c.conta_corrente;
            this.notaCreditoData.valor_credito = "";
            this.notaCreditoData.descricao = "";

        },

        async listarClientes() {

            try {

                let response = await axios.get(window.location.origin + `/empresa/notaCreditoDebitoListarclientes`);

                if (response.status === 200) {

                    response.data.clientes.forEach(element => {

                        this.clientes.push({
                            id: element.id,
                            conta_corrente: element.conta_corrente,
                            text: element.nome + " - NIF - " + element.nif
                        })
                    });
                }
            } catch (error) {
                console.log("ERRO API");
            }

        },
        modalCriar() {
            this.clientes = [];
            this.listarClientes();
        },
        async salvar() {

            if (!this.notaCreditoData.cliente_id) {
                this.$toasted.global.defaultError({
                    msg: "Selecione o cliente",
                });
                return;
            }

            try {

                let response = await axios.post(window.location.origin + `/empresa/notaCreditoSalvar`, this.notaCreditoData);

                if (response.status === 200) {

                    this.$toasted.global.defaultSuccess();

                    Swal.fire({
                        title: 'Sucesso',
                        text: 'unidade registada com sucesso!...',
                        icon: 'success',
                        confirmButtonColor: '#3d5476',
                        confirmButtonText: 'Ok',

                        onClose: () => {
                            document.location.reload(true)
                        }
                    });

                }

            } catch (error) {
                this.$toasted.global.defaultError({
                    msg: "Erro ao cadastrar",
                });
                this.errors = error.response.data.errors;
            }

        },
        async printRecibo(reciboId) {

            this.$loading(true)

            try {
                let response = await axios.get(`${this.router}/imprimirRecibo/${reciboId}`, {
                    responseType: "arraybuffer"
                });
                if (response.status === 200) {
                    this.$loading(false)
                    var file = new Blob([response.data], {
                        type: "application/pdf",
                    });
                    var fileURL = URL.createObjectURL(file);
                    window.open(fileURL);
                    //document.location.reload(true)
                } else {
                    this.$loading(false)
                    console.log("Erro ao carregar pdf");
                }
            } catch (error) {
                console.log("ERRO API");
            }

        }

    },

};
</script>

<style scoped>
.has-error {
    border-color: #f2a696 !important;
}

#botoes {
    left: 0%;
    border-radius: 15px;
    margin-top: 0.1%;
    padding: 6px 12px 6px 12px;
    position: relative;
    text-transform: uppercase;
}

.is-invalid,
.invalid-feedback {
    border-color: red;
    color: red;
}
</style>
