<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Nota de Crédito
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

                            <input type="text" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar por nome, nif do cliente e numeração NC..." />
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
                            <a href="#criar_nota_credito" data-toggle="modal" @click="modalCriar" title="Adicionar novo formapagamento" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa icofont-plus-circle"></i> Adicionar Crédito
                            </a>
                            <a @click="imprimirTodasNotaCredito()" title="Nota de credito" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a>
                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <div class="table-header widget-header">Todos Creditos</div>

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
                                        <th class="">Cliente</th>
                                        <th class="">Conta corrente</th>
                                        <th class="">NIF</th>
                                        <th style="text-align: right">Valor crédito</th>
                                        <th class="">Descrição</th>
                                        <th class="">Data Criada</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>

                                <tbody v-if="datanotacredito.length">
                                    <tr v-for="notaCredito in querydatanotacredito" :key="notaCredito.id">
                                        <td class="center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </td>

                                        <td>{{notaCredito.numeracaoDocumento}}</td>
                                        <td class="">{{notaCredito.cliente.nome}}</td>
                                        <td class="">{{notaCredito.cliente.conta_corrente}}</td>
                                        <td class="">{{notaCredito.cliente.nif}}</td>
                                        <td class="" style="text-align:right">{{notaCredito.valor_credito | currency}}</td>
                                        <td class="">{{notaCredito.descricao}}</td>
                                        <td class="">{{notaCredito.created_at | formatDateTime}}</td>

                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#ver_detalhes" data-toggle="modal" @click.prevent="mostrarModalDetalhes(notaCredito.cliente)" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                </a>
                                                <a @click.prevent="printNotaCredito(notaCredito.id)" style="cursor: pointer;" class="pink" title="Editar este registo">
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

    <!-- MODAL DE CRIAR formapagamentos -->
    <div id="criar_nota_credito" class="modal fade criar_nota_credito">
        <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar Nota de crédito
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
                                Os campos com <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span> são de preenchimento obrigatório.
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <div class="row" style="left: 0%; position: relative;">
                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Nota de crédito
                                </div>
                            </div>

                            <form method="POST" action enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                <div class="second-row">
                                    <div class="tabbable">

                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_formapagamento" class="tab-pane in active">

                                                <div class="row">
                                                    <div class="form-group has-info">

                                                        <label style="padding-top: 10px;" class="col-sm-3 control-label no-padding-right bold" for="designacao">Selecione o cliente<span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span>
                                                            <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                        </label>
                                                        <div class="col-md-6">
                                                            <div class>
                                                                <Select2 @select="selectCliente($event)" :options="clientes" :class="errors.valor_credito?'has-error':''" v-model="notaCreditoData.cliente_id" placeholder="Selecione o cliente">
                                                                </Select2>
                                                            </div>
                                                            <span v-if="errors.cliente_id" class="error">{{errors.cliente_id[0]}}</span>

                                                        </div>
                                                    </div>
                                                    <div class="form-group has-info">
                                                        <label style="padding-top: 10px;" class="col-sm-3 control-label no-padding-right bold" for="designacao">Conta Corrente<span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" v-model="conta_corrente" disabled class="col-xs-12" id="designacao" required style="">
                                                                <span class="input-group-addon">
                                                                    <i class="ace-icon fa fa-info bigger-150 text-info"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group has-info">
                                                        <label style="padding-top: 10px;" class="col-sm-3 control-label no-padding-right bold" for="designacao">Saldo actual<span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="text" v-model="saldoActual" disabled class="col-xs-12" id="designacao" required style="">
                                                                <span class="input-group-addon">
                                                                    <i class="ace-icon fa fa-info bigger-150 text-info"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-info">
                                                        <label style="padding-top: 10px;" class="col-sm-3 control-label no-padding-right bold" for="designacao">Valor<span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span>
                                                        </label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <input type="number" v-model="notaCreditoData.valor_credito" :class="errors.valor_credito?'has-error':''" autocomplete="off" class="col-xs-12" id="designacao" required style="">
                                                                <span class="input-group-addon">
                                                                    <i class="ace-icon fa fa-info bigger-150 text-info"></i>
                                                                </span>
                                                            </div>
                                                            <span v-if="errors.valor_credito" class="error">{{errors.valor_credito[0]}}</span>

                                                        </div>
                                                    </div>
                                                    <div class="form-group has-info">
                                                        <label style="padding-top: 10px;" class="col-sm-3 control-label no-padding-right bold" for="designacao">Descrição<span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span>
                                                            <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                        </label>
                                                        <div class="col-md-6">
                                                            <div class="input-group">
                                                                <textarea class="col-xs-12" v-model="notaCreditoData.descricao" cols="50" rows="10" :class="errors.descricao?'has-error':''"></textarea>
                                                            </div>
                                                            <span v-if="errors.descricao" class="error">{{errors.descricao[0]}}</span>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="form-group has-info">

                                                        <label style="padding-top: 10px;" class="col-sm-3 control-label no-padding-right bold" for="password">Tipo Pagamento <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span></label>
                                                        <div class="col-md-6">
                                                            <div class>
                                                                <Select2 :options="tipoFormaPgt" v-model="formapagamento.tipoFormaPgt" placeholder="Selecione o status">
                                                                </Select2>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group has-info">

                                                        <label style="padding-top: 10px;" class="col-sm-3 control-label no-padding-right bold" for="password">Status <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span></label>
                                                        <div class="col-md-6">
                                                            <div class>
                                                                <Select2 :options="statusGerais" v-model="formapagamento.status_id" placeholder="Selecione o status">
                                                                </Select2>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button class="search-btn" href="#criar_nota_credito" data-toggle="modal" type="submit" style="border-radius: 10px" @click.prevent="salvar">
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
    <!--/ MODAL DE CRIAR formapagamentos-->

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
    props: ["datanotacredito", "guard"],
    components: {
        Select2,
    },

    data() {
        return {
            searchQuery: '',
            clientes: [],
            errors: [],
            conta_corrente: "",
            saldoActual: "",
            clienteDetalhes: {},
            style: {
                type: String,
                default: '1'
            },

            // dataNotaCredito: [],
            notaCreditoData: {
                cliente_id: "",
                valor_credito: "",
                valor_extenso: "",
                descricao: ""
            },
            USUARIO_EMPRESA: 2,
            router: ""
        };

    },
    computed: {
        querydatanotacredito() {
            if (this.searchQuery) {
                let result = this.datanotacredito.filter((item) => {

                    let searchQuery = this.searchQuery.toLowerCase();
                    return item.cliente.nome.toLowerCase().match(searchQuery) ||
                        item.cliente.nif.toLowerCase().match(searchQuery) ||
                        item.numeracaoDocumento.toLowerCase().match(searchQuery)
                });

                return result ? result : [];
            } else {
                return this.datanotacredito;
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

        mostrarModalDetalhes(cliente) {

            this.mostrarSaldoCliente(cliente.id).then(response => {
                this.clienteDetalhes = {
                    nome: cliente.nome,
                    taxa_de_desconto: cliente.taxa_de_desconto,
                    limite_de_credito: cliente.limite_de_credito,
                    saldoActual: this.saldoActual,
                    endereco: cliente.endereco + ' - ' + cliente.cidade,
                };

            })
            document.getElementById("ver_detalhes").classList.add("fade");

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
            this.notaCreditoData.nome_do_cliente = c.nome_do_cliente;
            this.notaCreditoData.telefone_cliente = c.telefone_cliente;
            this.notaCreditoData.nif_cliente = c.nif_cliente;
            this.notaCreditoData.email_cliente = c.email_cliente;
            this.notaCreditoData.endereco_cliente = c.endereco_cliente;
            this.notaCreditoData.conta_corrente_cliente = c.conta_corrente_cliente;

            this.mostrarSaldoCliente(c.id);

        },

        async mostrarSaldoCliente(idCliente) {

            let response = await axios.get(`${this.router}/clientes/saldoActual/${idCliente}`);

            if (response.status === 200) {
                this.saldoActual = response.data;
            } else {
                this.saldoActual = 0.00
            }
        },

        async listarClientes() {

            try {

                let response = await axios.get(`${this.router}/notaCreditoDebitoListarclientes`);

                if (response.status === 200) {

                    response.data.clientes.forEach(element => {

                        this.clientes.push({
                            id: element.id,
                            conta_corrente: element.conta_corrente,
                            text: element.nome + " - NIF - " + element.nif,
                            nome_do_cliente: element.nome,
                            telefone_cliente: element.telefone_cliente,
                            nif_cliente: element.nif,
                            email_cliente: element.email,
                            endereco_cliente: element.endereco,
                            conta_corrente_cliente: element.conta_corrente
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

            // console.log(this.notaCreditoData.valor_credito.toFixed(2))

            //Formatação do valor extenso
            var extenso = require('extenso');

            let valor_toFixed = new Number(this.notaCreditoData.valor_credito).toFixed(2);
            let valor = valor_toFixed.toString().replace(".", ",");

            this.notaCreditoData.valor_extenso = extenso(valor, {
                number: {
                    decimal: 'informal'
                }
            })

            if (!this.notaCreditoData.cliente_id) {
                this.$toasted.global.defaultError({
                    msg: "Selecione o cliente",
                });
                return;
            }

            if (this.notaCreditoData.valor_credito < 0) {

                this.$toasted.global.defaultError({
                    msg: "Não permitido valor negativo",
                });
                return;
            }
            if (!this.notaCreditoData.descricao) {

                this.$toasted.global.defaultError({
                    msg: "Informe a descrição",
                });
                return;
            }

            this.$loading(true)

            try {

                let responseComparaData = await axios.get(
                    `${this.router}/comparaDataDocumento?tabela=notas_credito`
                );

                if (responseComparaData.data.status == 401) {
                    this.$toasted.global.defaultError({
                        msg: responseComparaData.data.errors
                    });
                    this.$loading(false)
                    return;
                }

                let response = await axios.post(`${this.router}/notaCreditoSalvar`, this.notaCreditoData, {
                    responseType: "arraybuffer"
                });

                if (response.status === 200) {

                    this.$toasted.global.defaultSuccess();

                    Swal.fire({
                        title: "Sucesso",
                        text: "Nota de Crédito registrado com sucesso!...",
                        icon: "success",
                        confirmButtonColor: "#3d5476",
                        confirmButtonText: "Ok",
                        onClose: () => {
                            this.$loading(false)
                            var file = new Blob([response.data], {
                                type: "application/pdf",
                            });
                            var fileURL = URL.createObjectURL(file);
                            window.open(fileURL);
                            document.location.reload(true)
                        },
                    });

                } else {
                    this.$loading(false)
                    console.log("Erro ao carregar pdf");

                }

            } catch (error) {
                console.log("Erro Api")
            }

        },
        async imprimirTodasNotaCredito() {

            this.$loading(true)

            try {
                let response = await axios.get(`${this.router}/imprimirTodasNotaCredito`, {
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

        },
        async printNotaCredito(notaCreditoId) {

            this.$loading(true)

            try {
                let response = await axios.get(`${this.router}/imprimirNotaCredito/${notaCreditoId}`, {
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
