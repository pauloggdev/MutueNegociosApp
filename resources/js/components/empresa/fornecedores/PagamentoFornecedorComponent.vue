<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Pagamento Fornecedor
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Listagem
            </small>
        </h1>
    </div>
    <!-- /.page-header -->

    <div class="col-xs-12">
        <div class>
            <form class="form-search" method="get" action>
                <div class="row">
                    <div class>
                        <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-search"></i>
                            </span>

                            <input type="text" required autocomplete="on" v-model="searchQuery" class="form-control search-query" placeholder="Buscar por Nº factura, Nº recibo e nome fornecedor..." />
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
                    <!-- <div class="form-check">
                        <input class="form-check-input" @change="filterPagamento" :value="3" checked type="radio" name="flexRadioDefault" id="flexRadioDefault1" />
                        <label class="form-check-label" for="flexRadioDefault1">
                            Todos
                        </label>
                        <input class="form-check-input" @change="filterPagamento" :value="1" type="radio" name="flexRadioDefault" id="flexRadioDefault2" />
                        <label class="form-check-label" for="flexRadioDefault2">
                            Facturas Pendentes
                        </label>
                        <input class="form-check-input" @change="filterPagamento" :value="2" type="radio" name="flexRadioDefault" id="flexRadioDefault3" />
                        <label class="form-check-label" for="flexRadioDefault3">
                            Facturas Pagas na Totalidade
                        </label>
                    </div> -->
                    <div class="form-check"></div>

                    <div class="col-xs-12 widget-box widget-color-green" style="left: 0%;">
                        <div class="clearfix">
                            <a href="#criar_fornecedor" data-toggle="modal" @click="mostrarModal" title="Adicionar novo cliente" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-plus"></i> Novo pagamento
                            </a>
                            <!-- <a href="/empresa/imprimir-clientes" title="Imprimir cliente" target="new" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print"></i> Clientes
                            </a> -->
                            <!-- <a data-toggle="modal" href="#modalFiltrarClientes" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i>
                                Imprimir
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

                        <div class="table-header widget-header">
                            Todos Fornecedores do Sistema
                        </div>

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
                                        <th>Nº da Factura</th>
                                        <th>Data Pagamento</th>
                                        <th>Nº do Recibo</th>
                                        <th>Valor Pago</th>
                                        <th>Status</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="pagamento in queryPagamentoFornecedor" :key="pagamento.id">

                                        <td class="center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </td>
                                        <td>{{pagamento.id}}</td>
                                        <td>{{pagamento.nFactura}}</td>
                                        <td>{{pagamento.dataPagamento | formatDate}}</td>
                                        <td>{{pagamento.nextPagamento}}</td>
                                        <td>{{pagamento.valor | currency}}</td>
                                        <td class="hidden-480" style="text-align: center">
                                            <span v-if="(pagamento.status_id == 1)" class="label label-sm label-success" style="border-radius: 20px;">{{ pagamento.statu_geral.designacao }}</span>
                                            <span v-else class="label label-sm label-warning" style="border-radius: 20px;">{{ pagamento.statu_geral.designacao }}</span>
                                        </td>

                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a @click.prevent="printPagamento(pagamento.id, 2)" style="cursor: pointer;" class="pink" title="Editar este registo">
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

    <!-- CRIAR FORNECEDOR -->
    <div id="criar_fornecedor" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i>
                        Pagamento Fornecedor
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
                                    Os campos marcados com
                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span>
                                    são de preenchimento obrigatório.
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Dados do Pagamento fornecedor
                                </div>
                            </div>

                            <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                <div class="second-row">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs padding-16">
                                            <li class="active">
                                                <a data-toggle="tab" href="#dados_cliente">
                                                    <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                    Dados do Pagamento
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_cliente" class="tab-pane in active">
                                                <div class="form-group has-info">
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="designacao">
                                                            Escolha o
                                                            fornecedor
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <Select2 :options="fornecedoresData" @select="selecionaFornecedor($event)" v-model="pagamento.fornecedor_id" placeholder="Selecione o fornecedor">
                                                                <!-- <option disabled value="0">Select one</option> -->
                                                            </Select2>
                                                            <span v-if="errors.fornecedor_id" class="error">{{errors.fornecedor_id[0]}}</span>

                                                            <!-- <span v-if="errors.pais_nacionalidade_id" class="error">{{errors.pais_nacionalidade_id[0]}}</span> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="designacao">
                                                            Conta Corrente
                                                        </label>
                                                        <div class>
                                                            <input type="text" id="nome" v-model="conta_corrente" disabled class="col-md-12 col-xs-12 col-sm-4" placeholder="Informe o nome" />
                                                            <span v-if="errors.conta_corrente" class="error">{{errors.conta_corrente[0]}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="designacao">
                                                            Escolha a
                                                            factura
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <Select2 :options="facturas" @select="selecionarFactura($event)" placeholder="Selecione o fornecedor">
                                                                <!-- <option disabled value="0">Select one</option> -->
                                                            </Select2>
                                                            <span v-if="errors.nFactura" class="error">{{errors.nFactura[0]}}</span>

                                                            <!-- <span v-if="errors.pais_nacionalidade_id" class="error">{{errors.pais_nacionalidade_id[0]}}</span> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="designacao">
                                                            Valor da factura
                                                        </label>
                                                        <div class>
                                                            <input type="text" :value="pagamento.total_compras|currency" disabled id="nome" class="col-md-12 col-xs-12 col-sm-4" placeholder="valor da factura" />
                                                            <!-- <span v-if="errors.nome" class="error">{{errors.nome[0]}}</span> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Pagamento
                                                            Efectuados

                                                        </label>
                                                        <div class>
                                                            <Select2 :options="pagamentosEfectuados" @select="selecionarPagamentoEfectuado($event)">
                                                                <!-- <option disabled value="0">Select one</option> -->
                                                            </Select2>

                                                            <!-- <span v-if="errors.pais_nacionalidade_id" class="error">{{errors.pais_nacionalidade_id[0]}}</span> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Valor do Recibo
                                                        </label>
                                                        <div class>
                                                            <input type="text" :value="valor_recibo|currency" disabled id="nome" class="col-md-12 col-xs-12 col-sm-4" placeholder="0,00" />
                                                            <!-- <span v-if="errors.nome" class="error">{{errors.nome[0]}}</span> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Valor da Divida
                                                        </label>
                                                        <div class>
                                                            <input type="text" :value="valor_divida|currency" disabled id="nome" class="col-md-12 col-xs-12 col-sm-4" placeholder="0,00" />
                                                            <!-- <span v-if="errors.nome" class="error">{{errors.nome[0]}}</span> -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Forma de Pagamento
                                                        </label>
                                                        <div class>
                                                            <Select2 :options="pagamentosData" @select="selecionarFormaPagamento($event)">
                                                                <!-- <option disabled value="0">Select one</option> -->
                                                            </Select2>
                                                            <span v-if="errors.formaPagamentoId" class="error">{{errors.formaPagamentoId[0]}}</span>

                                                            <!-- <span v-if="errors.pais_nacionalidade_id" class="error">{{errors.pais_nacionalidade_id[0]}}</span> -->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="designacao">
                                                            Nº Recibo
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="pagamento.nextPagamento" id="nome" class="col-md-12 col-xs-12 col-sm-4" placeholder="" />

                                                            <span v-if="errors.nextPagamento" class="error">{{errors.nextPagamento[0]}}</span>
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
                                                            <input type="number" :min="0" v-model="pagamento.valor" id="nome" class="col-md-12 col-xs-12 col-sm-4" />
                                                            <span v-if="errors.valor" class="error">{{errors.valor[0]}}</span>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button class="search-btn" style="border-radius: 10px" @click.prevent="salvarPagamento">
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
</template>

<script>
import Select2 from "v-select2-component";
import DatePick from "vue-date-pick";
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
    props: ["fornecedores", "pagamentofornecedor", "pagamentos", "guard"],
    data() {
        return {
            errors: [],
            searchQuery: "",
            fornecedoresData: [],
            pagamentosData: [],
            pagamentosEfectuados: [],
            valor_recibo: "",
            totalPagoRecibo: "",
            valor_divida: "",
            conta_corrente: "",
            facturas: [],
            pagamento: {
                total_compras: "",
                fornecedor_id: "",
                factura_num: "",
                formaPagamentoId: "",
                valor: 0,
                nextPagamento: "",
                conta_fornecedor: ""
            },
            errors: [],
            filterPgt: 1,
            USUARIO_EMPRESA: 2,
            router: ""
        };
    },
    created() {
        this.router =
            this.guard.tipo_user_id == this.USUARIO_EMPRESA ?
            window.location.origin + `/empresa` :
            window.location.origin + `/empresa/funcionario`;

        this.listarFornecedores();
        this.listarPagamentos();
    },

    computed: {
        queryPagamentoFornecedor() {

            if (this.searchQuery) {
                let result = this.pagamentofornecedor.filter(item => {

                    // if (this.filterPgt) {
                    //     const filter = this.filterPgt == 3 ? null : this.filterPgt;
                    //    // console.log(filter);return;
                    //     return item.entrada_produto.statusPagamento == filter
                    // } 
                    // if (this.searchQuery) {

                    let searchQuery = this.searchQuery.toLowerCase();
                    return item.nFactura.toLowerCase().match(searchQuery) ||
                        item.fornecedor.nome.toLowerCase().match(searchQuery) ||
                        item.nextPagamento.toLowerCase().match(searchQuery)
                    // }
                });
                return result ? result : [];
            }

            return this.pagamentofornecedor;

        }
    },

    methods: {

        async salvarPagamento() {

            let pagamentoFornecedor = {
                fornecedor_id: this.pagamento.fornecedor_id,
                nFactura: this.pagamento.factura_num,
                formaPagamentoId: this.pagamento.formaPagamentoId,
                valor: Number(this.pagamento.valor),
                nextPagamento: this.pagamento.nextPagamento,
                conta_fornecedor: this.conta_corrente,
                entrada_produto_id: Number(this.pagamento.entrada_produto_id),
                divida: this.valor_divida
            }

            if (pagamentoFornecedor.valor > this.pagamento.total_compras) {
                this.$toasted.global.defaultError({
                    msg: "O valor entregue deve ser menor ou igual a valor da factura",
                });
                return;
            }

            // console.log(pagamentoFornecedor);return;
            try {
                this.$loading(true)

                let response = await axios.post(`${this.router}/pagamentoFacturaFornecedor`, pagamentoFornecedor);
                if (response.status == 200) {
                    this.$loading(false)


                    this.$toasted.global.defaultSuccess();
                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Cliente cadastrado com sucesso!...',
                        icon: 'success',
                        confirmButtonColor: '#3d5476',
                        confirmButtonText: 'Ok',
                        onClose: () => {
                            this.printPagamento(response.data.id, 1);
                            document.location.reload(true)
                        }
                    });

                }
            } catch (error) {
                this.errors = error.response.data.errors;
                this.$loading(false)
            }

        },
        filterPagamento(pgt) {
            this.filterPgt = pgt.target.value
        },

        async buscarDividaRestante(entradaProdutoId, fornecedorId) {

            try {
                let response = await axios.get(`${this.router}/buscarDividaRestante/${entradaProdutoId}/${fornecedorId}`);
                if (response.status == 200) {
                    this.valor_divida = response.data == 0 ? this.pagamento.total_compras : this.pagamento.total_compras - response.data;
                }
            } catch (error) {

            }
        },
        async mostrarModal() {
            this.listarFacturas();
        },
        listarPagamentos() {
            try {

                const pagtCredito = 2;
                this.pagamentos.map(pagamento => {

                    if (pagamento.id != pagtCredito) {
                        this.pagamentosData.push({
                            id: pagamento.id,
                            text: pagamento.descricao
                        });

                    }
                });
            } catch (error) {}

        },
        async listarFornecedores() {
            try {
                this.fornecedores.map(fornecedor => {
                    this.fornecedoresData.push({
                        id: fornecedor.id,
                        text: fornecedor.nome,
                        conta_corrente: fornecedor.conta_corrente
                    });
                });
                this.pagamento.fornecedor_id = this.fornecedores[0].id;
                this.conta_corrente = this.fornecedores[0].conta_corrente;
            } catch (error) {}
        },

        selecionarPagamentoEfectuado(recibo) {
            this.valor_recibo = recibo.valor;
            //this.valor_divida = this.pagamento.total_compras - this.totalPagoRecibo;

        },
        selecionarFormaPagamento(pagamento) {
            this.pagamento.formaPagamentoId = Number(pagamento.id)
        },

        selecionarFactura(factura) {
            this.buscarDividaRestante(factura.id, this.pagamento.fornecedor_id);
            this.pagamento.total_compras = factura.total_compras;
            this.valor_recibo = "";
            this.pagamento.factura_num = factura.numeracaoFactura
            this.pagamento.entrada_produto_id = factura.id;
            this.listarPagamentosEfectuados(factura);
        },
        selecionaFornecedor(fornecedor) {
            this.pagamento.total_compras = "";
            this.conta_corrente = fornecedor.conta_corrente;
            this.listarFacturas();
        },
        // },
        async listarPagamentosEfectuados(factura) {
            try {
                this.pagamentosEfectuados = [];
                let response = await axios.get(
                    `${this.router}/pagamentoEfectuadosFacturaFornecedor?nFactura=${factura.numeracaoFactura}&fornecedorId=${factura.fornecedor_id}`
                );

                this.calcularTotalPagoRecibo(response);

                response.data.pagamentoEfecturados.forEach(recibo => {
                    this.pagamentosEfectuados.push({
                        id: recibo.id,
                        text: recibo.nextPagamento,
                        valor: recibo.valor
                    });
                });
            } catch (error) {}
        },

        calcularTotalPagoRecibo(response) {
            var total_pago = 0;
            response.data.pagamentoEfecturados.forEach(recibo => {
                total_pago += recibo.valor;
            });

            this.totalPagoRecibo = total_pago;

        },
        async listarFacturas() {
            try {
                this.facturas = [];
                let response = await axios.get(
                    `${this.router}/listarFacturasFornecedores/${this.pagamento.fornecedor_id}`
                );
                response.data.facturas.forEach(factura => {
                    this.facturas.push({
                        id: factura.id,
                        text: factura.num_factura_fornecedor,
                        numeracaoFactura: factura.num_factura_fornecedor,
                        entrada_produto_id: factura.id,
                        fornecedor_id: factura.fornecedor_id,
                        total_compras: factura.total_compras
                    });
                });
            } catch (error) {}
        },
        async printPagamento(pagamentoId, viaImpressao) {

            this.$loading(true)

            let response = await axios.get(`${this.router}/imprimirPagamentoFornecedor/${pagamentoId}/${viaImpressao}`, {
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

        },
        formatDate() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, "0");
            var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
            var yyyy = today.getFullYear();

            today = yyyy + "-" + mm + "-" + dd;

            return today;
        }
    }
};
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
