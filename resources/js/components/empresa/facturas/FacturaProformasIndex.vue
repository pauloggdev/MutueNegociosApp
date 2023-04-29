<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            FACTURAS PROFORMAS
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Listagem
            </small>
        </h1>
    </div>

    <div class="col-md-12">
        <div class>
            <form class="form-search" method="get" action>
                <div class="row">
                    <div class>
                        <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-search"></i>
                            </span>

                            <input type="text" name="query" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar Por nome, telefone, nif do cliente e numeração da factura" />
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

                        <div class="table-header widget-header">Todas facturas proformas do Sistema</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Cliente</th>
                                        <th>NIF</th>
                                        <th style="text-align:right">Total Factura</th>
                                        <th style="text-align:right">Valor a Pagar</th>
                                        <th>Numeração</th>
                                        <th>Emitido</th>
                                        <th>convertido</th>
                                        <th>Pago</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr v-for="factura in queryFacturasProformas" :key="factura.id">
                                        <td>{{factura.id}}</td>
                                        <td>{{factura.nome_do_cliente}}</td>
                                        <td>{{factura.nif_cliente}}</td>
                                        <td style="text-align:right">{{factura.total_preco_factura | currency}}</td>
                                        <td style="text-align:right">{{factura.valor_a_pagar | currency}}</td>
                                        <td>{{factura.numeracaoFactura}}</td>
                                        <td>{{factura.created_at | formatDateTime2}}</td>
                                        <!-- <td class="hidden-480">
                                            <span class="label label-sm " :class="factura.status_id == 1?'label-success':'label-warning'">{{factura.status.designacao}}</span>
                                        </td> -->

                                        <td class="hidden-480">
                                            <span class="label label-sm " :class="factura.convertidoFactura == 1?'label-success':'label-danger'">{{factura.convertidoFactura == 1?"Não":"Sim"}}</span>
                                        </td>
                                        <td class="hidden-480">
                                            <span class="label label-sm " :class="factura.statusFactura == 1?'label-danger':'label-success'">{{factura.statusFactura == 1?"Não":"Sim"}}</span>
                                        </td>

                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <!-- <a class="blue" href="#" title="Detalhes factura">
                                                    <i class="ace-icon fa fa-search-plus bigger-160"></i>
                                                </a> -->
                                                <a class="blue" @click.prevent="ImprimirFactura(factura.id)" title="Reimprimir factura" style="cursor:pointer;">
                                                    <i class="ace-icon fa fa-print bigger-160"></i>
                                                </a>
                                                <a class="blue" href="#converterFacturaProforma" @click.prevent="mostrarModalConverterFactura(factura)" data-toggle="modal" title="Converter factura proforma" style="cursor:pointer;">
                                                    <i class="ace-icon fa fa-exchange bigger-160"></i>
                                                </a>

                                            </div>

                                            <div class="hidden-md hidden-lg">
                                                <div class="inline pos-rel">
                                                    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                        <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                        <li>
                                                            <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
                                                                <span class="blue">
                                                                    <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                                </span>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                                <span class="green">
                                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                                </span>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                                                <span class="red">
                                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
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

    <!-- CRIAR FACTURA PROFORMA -->
    <div id="converterFacturaProforma" class="modal fade">
        <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Converter factura proforma
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
                                Os campos classedos com <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span> são de preenchimento obrigatório.
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <div class="row" style="left: 0%; position: relative;">
                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Dados da factura
                                </div>
                            </div>

                            <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                <div class="second-row">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs padding-16">
                                            <li class="active">
                                                <a data-toggle="tab" href="#dados_banco">
                                                    <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                    Dados da factura Proforma
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_banco" class="tab-pane in active">
                                                <div class="form-group has-info">
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="designacao">
                                                            Total factura
                                                        </label>
                                                        <div class>
                                                            <input type="text" :value="facturaProforma.total_preco_factura|currency" disabled id="designacao" class="col-md-12 col-xs-12 col-sm-4" />
                                                            <span v-if="errors.total_preco_factura" class="error">{{errors.total_preco_factura[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="designacao">
                                                            Total a Pagar
                                                        </label>
                                                        <div class>
                                                            <input :value="facturaProforma.valor_a_pagar|currency" disabled type="text" id="designacao" class="col-md-12 col-xs-12 col-sm-4" />
                                                            <span v-if="errors.valor_a_pagar" class="error">{{errors.valor_a_pagar[0]}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="status_id">
                                                            Forma de Pagamentos
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <Select2 :options="OptionsPagamentos" @select="setarPagamento($event)" placeholder="Escolha a forma pagamento">
                                                            </Select2>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Valor entregue
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input v-model.number="facturaProforma.valor_entregue" :min="0" type="number" id="valorEntregue" class="col-md-12 col-xs-12 col-sm-4" />
                                                            <span v-if="errors.valor_entregue" class="error">{{errors.valor_entregue[0]}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Troco
                                                        </label>
                                                        <div class>
                                                            <input :value="valorTroco|currency" disabled type="text" id="designacao" class="col-md-12 col-xs-12 col-sm-4" />
                                                            <span v-if="errors.troco" class="error">{{errors.troco[0]}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" style="border-radius: 10px" id="btnConverte" @click.prevent="salvar">
                                                    <i class="ace-icon fa fa-print bigger-110"></i>
                                                    Converter e Imprimir
                                                </button>
                                                &nbsp; &nbsp;
                                                <button class="btn btn-danger" style="border-radius: 10px" data-dismiss="modal">
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

</div>
<!-- /.row -->
</template>

<script>
import axios from 'axios'
import Swal from 'sweetalert2';
import Select2 from "v-select2-component";

export default {
    props: ["proformas", "guard", "formapagamentos"],
    components: {
        Select2
    },

    data() {
        return {

            OptionsPagamentos: [],
            facturaProforma: {
                total_preco_factura: 0,
                valor_a_pagar: 0,
                valor_entregue: 0,
                isCredito: false,
                produtos: []
            },
            errors: [],
            formas_pagamento: "",
            //valor_entregue:0,
            searchQuery: "",
            factura: {},
            /**
             * constantes usados
             */
            USUARIO_EMPRESA: 2,
            USUARIO_FUNCIONARIO: 3,
            USUARIO_EMPRESA: 2,
            router: ""
        };
    },

    created() {
        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`
    },

    methods: {

        async salvar(e) {

            //seta o valor do troco
            this.facturaProforma.troco = this.valorTroco;

            if (!this.facturaProforma.formas_pagamento_id) {
                this.$toasted.global.defaultError({
                    msg: `Informe a forma de pagamento`
                });
                return
            } else if (this.facturaProforma.valor_entregue < this.facturaProforma.valor_a_pagar && !this.facturaProforma.isCredito) {
                this.$toasted.global.defaultError({
                    msg: `O valor entregue deve ser maior ou igual ao total a pagar`
                });
                return
            } else if (this.facturaProforma.isCredito && this.facturaProforma.cliente.diversos == "Sim") {
                this.$toasted.global.defaultError({
                    msg: `Não permitido converter a factura com cliente diverso`
                });
                return
            } else if (this.facturaProforma.convertidoFactura == 2) {
                this.$toasted.global.defaultError({
                    msg: `Esta factura proforma já foi convertido para outro documento`
                });
                return
            } else {

                try {

                    let response = await axios.post(`${this.router}/converterFacturaProforma/salvar`, this.facturaProforma);

                    //console.log(response.data);return;

                    this.$loading(true)
                    if (response.status === 200 && response.data.status != 401) {

                        document.getElementById("btnConverte").setAttribute("data-dismiss", "modal");
                        this.$toasted.global.defaultSuccess();
                        Swal.fire({
                            title: 'Sucesso',
                            text: 'Factura registada com sucesso!',
                            icon: 'success',
                            confirmButtonColor: '#3d5476',
                            confirmButtonText: 'Ok',
                        });

                        let responseFactura = await axios.get(`${this.router}/facturacao/imprimir-factura/${response.data.id}/${response.data.tipoFolha}`, {
                            responseType: "arraybuffer"
                        });

                        if (responseFactura.status === 200) {
                            this.$loading(false)

                            var file = new Blob([responseFactura.data], {
                                type: "application/pdf",
                            });
                            var fileURL = URL.createObjectURL(file);
                            window.open(fileURL);
                            document.location.reload(true)
                        } else {
                            this.$loading(false)
                            console.log("Erro ao carregar pdf");
                        }
                    }
                } catch (error) {

                    if (error.response.data.isValid == false) {
                        this.$toasted.global.defaultError({
                            msg: error.response.data.errors
                        });
                        return;
                    }
                    this.errors = error.response.data.errors;
                    this.$loading(false)
                }

            }

        },
        setarPagamento(formaPagamento) {

            if (formaPagamento.isCredito) {

                this.facturaProforma.valor_entregue = 0;
                this.facturaProforma.troco = 0;
                this.facturaProforma.tipo_documento = 2; //tipo factura
                this.facturaProforma.statusFactura = 1; //divida
                this.facturaProforma.isCredito = true;
                document.getElementById("valorEntregue").disabled = true;

            } else {
                this.facturaProforma.tipo_documento = 1; //tipo recibo
                this.facturaProforma.statusFactura = 2; //factura recibo (Pago)
                this.facturaProforma.isCredito = false;
                document.getElementById("valorEntregue").disabled = false;
            }
            this.facturaProforma.formas_pagamento_id = formaPagamento.id;
        },
        mostrarModalConverterFactura(factura) {

            this.facturaProforma = {
                ...factura
            }
            this.OptionsPagamentos = []
            this.listarFormaPagamento()
        },

        async listarFormaPagamento() {

            this.formapagamentos.forEach(element => {
                this.OptionsPagamentos.push({
                    id: element.id,
                    text: element.descricao,
                    isCredito: element.tipo_credito == 1 ? true : false
                })
            })

        },

        async ImprimirFactura(id) {

            let router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`
            this.$loading(true)

            let response = await axios.get(`${router}/facturacao/imprimir-factura/${id}`, {
                responseType: "arraybuffer"
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
        }
    },
    computed: {

        valorTroco() {
            return this.facturaProforma.valor_entregue == 0 ? this.facturaProforma.valor_entregue : this.facturaProforma.valor_entregue - this.facturaProforma.valor_a_pagar;
        },
        queryFacturasProformas() {
            if (this.searchQuery) {
                let searchQuery = this.searchQuery.toLowerCase();
                let result = this.proformas.filter(item => {
                    return item.nome_do_cliente.toLowerCase().match(searchQuery) ||
                        item.nif_cliente.toLowerCase().match(searchQuery) ||
                        item.telefone_cliente.toLowerCase().match(searchQuery) ||
                        item.numeracaoFactura.toLowerCase().match(searchQuery)

                });
                return result ? result : []
            } else {
                return this.proformas
            }
        }
    }
};
</script>

<style scoped>
</style>
