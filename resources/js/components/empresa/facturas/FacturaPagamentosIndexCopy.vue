<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Facturas

            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Pagamentos
            </small>
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

                            <input type="text" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar Por nome, email, telefone do cliente e referência da factura..." />
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
                            <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="table-header widget-header">Todos Facturas do Sistema</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nome Cliente</th>
                                        <th>Telefone Cliente</th>
                                        <th>Total Factura</th>
                                        <th>Valor a Pagar</th>
                                        <th>Tipo Factura</th>
                                        <th>Data Vencimento</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="factura in queryFacturas" :key="factura.id">
                                        <td class="center">{{ factura.id }}</td>
                                        <td>{{ factura.nome_do_cliente }}</td>
                                        <td>{{ factura.telefone_cliente }}</td>
                                        <td>{{ factura.total_preco_factura | currency }}</td>
                                        <td>{{ factura.valor_a_pagar | currency }}</td>
                                        <td>{{ factura.tipo_documento | currency }}</td>
                                        <td>{{ factura.data_vencimento | formatDate}}</td>
                                        <td class="hidden-480">
                                            <span class="label label-sm " :class="factura.status_id == 1?'label-success':'label-warning'">{{factura.status.designacao}}</span>
                                        </td>

                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a class="blue" href="#" title="Detalhes factura">
                                                    <i class="ace-icon fa fa-search-plus bigger-160"></i>
                                                </a>
                                                <a class="blue" href="#emitirRecibo" data-toggle="modal" @click.prevent="showModal(factura)" title="emitir recibo" style="cursor:pointer;">
                                                    <i class="ace-icon fa fa-money bigger-160"></i>
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

        <!-- CRIAR BANCOS -->
        <div id="emitirRecibo" class="modal fade">
            <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Emitir Recibo
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="left: 0%; position: relative;">
                            <div class="col-md-12">
                                <div class="search-form-text">
                                    <div class="search-text">
                                        <i class="fa fa-pencil"></i>
                                        Emitir Recibo
                                    </div>
                                </div>

                                <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_banco">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados do recibo
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_banco" class="tab-pane in active">
                                                    <div class="form-group has-info">
                                                        <div class="col-md-12">
                                                            <label class="control-label" for="designacao">
                                                                Nome do Cliente
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="infoRecibo.nomeCliente" class="col-md-12 col-xs-12 col-sm-4" />
                                                                <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- <div class="col-md-3">
                                                            <label class="control-label" for="designacao">Sigla</label>
                                                            <div class>
                                                                <input type="text" v-model="banco.sigla" id="sigla" class="col-md-12 col-xs-12 col-sm-4" :class="errors.sigla?'has-error':''" placeholder="Informe a sigla do Banco" />
                                                                <span v-if="errors.sigla" class="error">{{errors.sigla[0]}}</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="control-label" for="status_id">
                                                                status
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <Select2 :options="options" v-model="banco.status_id" placeholder="Escolha o Status">
                                                                </Select2>
                                                            </div>
                                                        </div> -->
                                                    </div>

                                                    <div class="form-group has-info">
                                                        <div class="col-md-6">
                                                            <label class="control-label" for="designacao">
                                                                Saldo Actual
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="infoRecibo.saldoActual" class="col-md-12 col-xs-12 col-sm-4" />
                                                                <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="control-label" for="designacao">
                                                                Conta Corrente
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="infoRecibo.contaCorrente" class="col-md-12 col-xs-12 col-sm-4" />
                                                                <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group has-info">
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Factura a Liquidar
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="infoRecibo.saldoActual" class="col-md-12 col-xs-12 col-sm-4" />
                                                                <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Total Factura
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="infoRecibo.contaCorrente" class="col-md-12 col-xs-12 col-sm-4" />
                                                                <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                                                            </div>
                                                        </div>
                                                         <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Valor a Pagar
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="infoRecibo.contaCorrente" class="col-md-12 col-xs-12 col-sm-4" />
                                                                <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group has-info">
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Data Operação
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="infoRecibo.saldoActual" class="col-md-12 col-xs-12 col-sm-4" />
                                                                <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                Forma de Pagamento
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="infoRecibo.contaCorrente" class="col-md-12 col-xs-12 col-sm-4" />
                                                                <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                                                            </div>
                                                        </div>
                                                         <div class="col-md-4">
                                                            <label class="control-label" for="designacao">
                                                                OBS
                                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                                </span>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="infoRecibo.contaCorrente" class="col-md-12 col-xs-12 col-sm-4" />
                                                                <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                                                            </div>
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
    </div>

</div>
<!-- /.row -->
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";

import {
    showError
} from "./../../../config/global";
import {
    mapState
} from "vuex";
import Swal from "sweetalert2";

export default {
    components: {
        Select2,
    },
    props: ["facturas"],
    data() {
        return {
            searchQuery: null,
            infoRecibo:{

            }

        };
    },

    methods: {

        showModal(item) { // Abre a modal de emitir recibo

            this.infoRecibo = {

                nomeCliente: item.cliente.nome,
                contaCorrente: item.cliente.conta_corrente,
                saldoActual: item.cliente.limite_de_credito,
                total_factura: item.total_preco_factura,
                numeracaoFactura: item.numeracaoFactura + ' ref:' + item.faturaReference

            }

            console.log(this.dataEmitirRecibo)

            console.log(item)
            console.log(item.cliente)

        },

    },
    computed: {
        queryFacturas() {
            if (this.searchQuery) {
                let result = this.facturas.filter((item) => {
                    return item.nome_do_cliente.toLowerCase().match(this.searchQuery)

                });

                return result ? result : [];
            } else {
                return this.facturas;
            }
        },
    }
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
