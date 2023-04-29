<template>
<div class="facturaRegibo">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-form-text">
                        <div class="search-text">
                            <i class="menu-icon glyphicon glyphicon-barcode"></i>
                            Facturação
                        </div>
                    </div>

                </div>
            </div>

            <!-- FIM -->

            <!-- PESQUISA CLIENTE  -->
            <div class="row" style="margin-bottom:10px;">
                <!-- INPUT PESQUISA CLIENTE  -->
                <div class="col-md-12">
                    <PesquisarCliente></PesquisarCliente>
                </div>
                <!-- FIM INPUT PESQUISA CLIENTE  -->
            </div>
            <!-- FIM PESQUISA CLIENTE  -->

            <div class="row">
                <!-- CLIENTES DIVERSOS  -->
                <div class="col-md-4 cardInfo">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tabbable">
                                <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                                    <li class="active">
                                        <a data-toggle="tab" href="#clienteDiverso1">Dados Gerais/Cliente</a>
                                    </li>

                                    <li>
                                        <a data-toggle="tab" href="#clienteDiverso2">Contato/Cliente</a>
                                    </li>

                                </ul>
                                <div class="tab-content">
                                    <div id="clienteDiverso1" class="tab-pane in active">

                                        <div class="row">
                                            <div class="col-md-12 inputFormPag">
                                                <label class="control-label bold" for="preco_compra">
                                                    Nome
                                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-question-circle bold text-danger"></i>
                                                    </span>
                                                </label>
                                                <input autocomplete="true" type="text" v-model="cliente.nome_do_cliente" class="form-control">
                                            </div>
                                            <div class="col-md-12 inputFormPag">
                                                <label class="control-label bold" for="preco_compra">
                                                    Email
                                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-question-circle bold text-danger"></i>
                                                    </span>
                                                </label>

                                                <input type="text" v-model="cliente.email_cliente" class="form-control">
                                            </div>
                                            <div class="col-md-12 inputFormPag">
                                                <label class="control-label bold" for="preco_compra">
                                                    NIF
                                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-question-circle bold text-danger"></i>
                                                    </span>
                                                </label>
                                                <input type="text" v-model="cliente.nif_cliente" class="form-control">
                                            </div>

                                        </div>
                                    </div>
                                    <div id="clienteDiverso2" class="tab-pane">
                                        <div class="row">
                                            <div class="col-md-12 inputFormPag">
                                                <label class="control-label bold" for="preco_compra">
                                                    Telefone
                                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-question-circle bold text-danger"></i>
                                                    </span>
                                                </label>
                                                <input type="text" v-model="cliente.telefone_cliente" class="form-control">
                                            </div>
                                            <div class="col-md-12 inputFormPag">
                                                <label class="control-label bold" for="preco_compra">
                                                    Endereço
                                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-question-circle bold text-danger"></i>
                                                    </span>
                                                </label>

                                                <input type="text" v-model="cliente.endereco_cliente" class="form-control">
                                            </div>

                                        </div>
                                    </div>
                                    <button v-if="cliente.nome_do_cliente" type="button" class="btn btn-white btn-danger btn-sm" @click="limparCliente">
                                        <i class="ace-icon glyphicon glyphicon-remove" aria-hidden="true"></i>
                                        Limpar
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- CLIENTES FIM DIVERSOS  -->

                <!-- FORMA PAGAMENTOS  -->
                <div class="col-md-4 cardInfo">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tabbable">
                                <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                                    <li class="active">
                                        <a data-toggle="tab" href="#dropdown14">Forma Pagamento</a>
                                    </li>
                                    <!-- <li>
                                        <a data-toggle="tab" href="#dropdown16">Câmbio</a>
                                    </li> -->
                                </ul>

                                <div class="tab-content">
                                    <div id="dropdown14" class="tab-pane in active">

                                        <div class="row">
                                            <div class="col-md-12 inputFormPag">
                                                <label class="control-label bold" for="preco_compra">
                                                    Forma Pagamento
                                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-question-circle bold text-danger"></i>
                                                    </span>
                                                </label>

                                                <div>
                                                    <Select2 :options="formaPagamentos" v-model="facturacao.formas_pagamento_id">
                                                        <!-- <option disabled value="0">Select one</option> -->
                                                    </Select2>
                                                </div>

                                                <!-- <select style="height: 34px" class="col-md-12 col-xs-12 col-sm-4 select2" v-model="facturacaoInfo.formasPagamento_id" data-placeholder="Selecione o status">
                                                    <option v-for="formaPagamento in formaPagamentos" :value="formaPagamento.id" :key="formaPagamento.id">{{formaPagamento.designacao}}</option>
                                                </select> -->

                                            </div>
                                            <div class="col-md-12 inputFormPag">
                                                <label class="control-label bold" for="preco_compra">
                                                    Selecione o armazem
                                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-question-circle bold text-danger"></i>
                                                    </span>
                                                </label>

                                                <div>
                                                    <Select2 :options="armazens" v-model="armazem">
                                                    </Select2>
                                                </div>
                                            </div>
                                            <div class="col-md-12 inputFormPag">
                                                <label class="control-label bold" for="preco_compra">
                                                    Valor Entregue
                                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-question-circle bold text-danger"></i>
                                                    </span>
                                                </label>
                                                <input type="number" v-model.trim="valor_entregue" class="form-control" :class="error?'has-error':''">
                                            </div>
                                            <div class="col-md-12 inputFormPag">
                                                <label class="control-label bold" for="preco_compra">
                                                    Troco
                                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                    </span>
                                                </label>
                                                <input disabled type="text" :value="facturacao.troco|currency" class="form-control">
                                            </div>

                                        </div>
                                    </div>
                                    <!-- <div id="dropdown16" class="tab-pane">
                                        <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade.</p>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIM FORMA PAGAMENTOS  -->

                <!-- TIPO FACTURAR -->
                <div class="col-md-4 cardInfo">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="tabbable">
                                <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                                    <li class="active">
                                        <a data-toggle="tab" href="#home4">Tipo factura</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div id="home4" class="tab-pane in active tipoFacturar">

                                        <div class="radio">

                                            <label>
                                                <input name="form-field-radio" v-model="tipo_documento" :value="1" type="radio" class="ace input-lg" />
                                                <span class="lbl bigger-120">Factura</span>
                                            </label>
                                            <label>
                                                <input name="form-field-radio" v-model="tipo_documento" :value="2" type="radio" class="ace input-lg" />
                                                <span class="lbl bigger-120"> Recibo</span>
                                            </label>

                                            <label>
                                                <input name="form-field-radio" v-model="tipo_documento" :value="3" type="radio" class="ace input-lg" />
                                                <span class="lbl bigger-120">Proforma</span>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div id="home4" class="tab-pane in active tipoFacturar">

                                        <div class="radio">
                                            <label>
                                                <input name="form-field-radio_a" v-model="facturacao.tipoFolha" :value="1" type="radio" class="ace input-lg" />
                                                <span class="lbl bigger-120">A4</span>
                                            </label>
                                            <label>
                                                <input name="form-field-radio_a" v-model="facturacao.tipoFolha" :value="2" type="radio" class="ace input-lg" />
                                                <span class="lbl bigger-120">A5</span>
                                            </label>

                                            <label>
                                                <input name="form-field-radio_a" v-model="facturacao.tipoFolha" :value="3" type="radio" class="ace input-lg" />
                                                <span class="lbl bigger-120">Ticket</span>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="tabbable">
                                <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                                    <li class="active">
                                        <a data-toggle="tab" href="#desconto1">Desconto</a>
                                    </li>

                                    <li>
                                        <a data-toggle="tab" href="#retencao1">Retenção</a>
                                    </li>

                                </ul>

                                <div class="tab-content">
                                    <div id="desconto1" class="tab-pane in active">
                                        <label class="control-label bold" for="preco_compra">
                                            Desconto
                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                            </span>
                                        </label> <input type="number" v-model.number="desconto" class="form-control">
                                    </div>

                                    <div id="retencao1" class="tab-pane">
                                        <div class="row">

                                            <div class="col-md-12">

                                                <div class="checkbox">
                                                    <label class="block">
                                                        <input v-model="retencao" name="form-field-checkbox" type="checkbox" class="ace input-lg" />
                                                        <span class="lbl bigger-120">Aplicar retenção na fonte</span>
                                                    </label>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- FIM TIPO FACTURAR  -->

            </div>

            <!-- TODA TABLE  -->
            <div class="row">
                <!-- PARTE LATERAL DIREITO PESQUISA CLIETEN E ADD PRODUTO -->
                <div class="col-md-12">
                    <div class="row">

                        <div class="col-md-12">

                            <div class="row">

                                <!-- BOTTOM ADD  -->
                                <div class="col-md-12">
                                    <button data-target="#right-menu" data-toggle="modal" type="button" class="btn-add-produto">
                                        <i class="fa fa-plus-circle"></i> Adicionar
                                    </button>
                                </div>
                                <!-- FIM BOTTOM ADD  -->

                                <!-- TABLE ITEM  -->
                                <div class="col-md-12">
                                    <div class="clearfix">
                                        <div class="pull-right tableTools-container"></div>
                                    </div>
                                    <div class="table-header">Produtos e serviços</div>

                                    <!-- div.table-responsive -->

                                    <!-- div.dataTables_borderWrap -->
                                    <div v-if="facturacao.produtos.length">
                                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Cod.</th>
                                                    <th>Produto</th>
                                                    <th>Preço.Unit.</th>
                                                    <th>Unid.</th>
                                                    <th class="hidden-480">Qtd.</th>
                                                    <th>Incid.</th>
                                                    <th>Desc</th>
                                                    <th>IVA</th>
                                                    <th>Retenção</th>
                                                    <th>Total c/IVA</th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr v-for="prod in facturacao.produtos" :key="prod.id" @click="showModal(prod)">
                                                    <td>{{prod.id}}</td>
                                                    <td>{{prod.designacao}}</td>
                                                    <td>{{prod.preco | currency }}</td>
                                                    <td>{{prod.unidade }}</td>
                                                    <td class="hidden-480">{{prod.quant}}</td>
                                                    <td>{{prod.incidencia_produto | currency }}</td>
                                                    <td class="hidden-480">{{prod.desconto_produto | currency}}</td>

                                                    <td>{{prod.iva_produto | currency}}</td>
                                                    <td>{{prod.retencao_produto | currency}}</td>
                                                    <td>{{prod.valor_com_iva | currency}}</td>

                                                    <td>
                                                        <div class="hidden-sm hidden-xs action-buttons">
                                                            <a class="red" @click.stop="removeFacturacao(prod.id)">
                                                                <i class="ace-icon glyphicon glyphicon-remove bigger-130"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <td colspan="1">
                                                    <button type="button" class="btn btn-white btn-danger btn-sm mt-4" @click="limparTodosItem">
                                                        <i class="ace-icon glyphicon glyphicon-remove" aria-hidden="true"></i>
                                                        Limpar
                                                    </button>
                                                </td>
                                                <td colspan="1"></td>
                                                <td colspan="3" class="valor_total">Total da Factura</td>
                                                <td colspan="6" class="text-rigth valor_total result">{{facturacao.total_preco_factura | currency }}</td>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div v-else id="semProduto">
                                        <div class="semProdutoDescription">
                                            <div>
                                                <i class="glyphicon glyphicon-list"></i>
                                            </div>
                                            <div>
                                                <div class="text">Não existe produto na lista</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIM TABLE ITEM  -->

                            </div>

                        </div>

                    </div>
                </div>
                <!-- FIM PARTE LATERAL DIREITO PESQUISA CLIETEN E ADD PRODUTO -->
            </div>
            <!-- FIM TODA TABLE  -->

            <!-- VALOR EXTENSO  -->
            <div class="row" v-if="facturacao.produtos.length">
                <div class="panel panel-default" style="margin-top:10px;">
                    <div class="panel-body">

                        <div class="row">

                            <div class="form-group col-md-3">
                                <label class="control-label bold" for="preco_compra">
                                    IVA
                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                    </span>
                                </label>
                                <div class="input-group">
                                    <input disabled type="text" :value="facturacao.total_iva|currency" class="form-control" data-target="form_supply_price" style="height: 35px; font-size: 13pt" />
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label bold" for="preco_compra">
                                    Retenção
                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                    </span>
                                </label>
                                <div class="input-group">
                                    <input disabled type="text" :value="facturacao.retencao|currency" class="form-control" data-target="form_supply_price" style="height: 35px; font-size: 13pt" />
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label bold" for="preco_compra">
                                    Desconto
                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                    </span>
                                </label>
                                <div class="input-group">
                                    <input disabled type="text" :value="facturacao.desconto|currency" class="form-control" data-target="form_supply_price" style="height: 35px; font-size: 13pt" />
                                </div>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label bold" for="preco_compra">
                                    Total Pagar
                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                    </span>
                                </label>
                                <div class="input-group">
                                    <input disabled type="text" :value="facturacao.valor_a_pagar|currency" class="form-control" data-target="form_supply_price" style="height: 35px; font-weight: bold;color: red!important; font-size: 13pt" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="control-label bold" for="preco_compra">
                                    Valor Extenso
                                    <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                    </span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-addon"></div>
                                    <input disabled type="text" :value="facturacao.valor_extenso" class="form-control" data-target="form_supply_price" style="height: 35px; font-size: 13pt" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="" style="float:right;padding-right: 10px">
                                <a href="#" class="btn btn-app btn-primary btn-xs" @click.prevent="cadastrarFactura">
                                    <i class="ace-icon fa fa-print bigger-160"></i>
                                    Facturar
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- FIM VALOR EXTENSO  -->

        </div>
        <!-- /.modal-content -->
    </div>
    <ProdutoDropdown v-if="isList"></ProdutoDropdown>
    <CriarProdutoDropdown v-else></CriarProdutoDropdown>

    <modal name="set-edit-facturacao">
        <div class="modal-header" id="modalEditFactura">
            <button type="button" class="close" @click="CloseModal" aria-hidden="true">&times;</button>
            <h3 class="smaller lighter blue no-margin">{{produto.designacao}}</h3>
        </div>

        <div class>
            <form action>
                <div class="form-group">
                    <div class="col-md-12" style="margin-bottom:5px">
                        <label class="control-label" for="nome">Quantidade</label>
                        <div class="input-icon">
                            <input type="number" min="1" v-model.number="produto.quantidade_produto" autocomplete="off" style="height: 35px;" class="col-md-12" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <label class="control-label" for="desconto">Desconto</label>
                        <div class="input-icon">
                            <input type="number" min="0" v-model.number="produto.desconto_produto" class="col-md-12 col-xs-12 col-sm-4" />
                            <i class="ace-icon fa fa-percent"></i>
                        </div>
                    </div>
                    <div class="col-md-6">

                        <div class="checkbox">
                            <label class="block">
                                <input v-model="produto.retencao_produto" name="form-field-checkbox" type="checkbox" class="ace input-lg" />
                                <span class="lbl bigger-120">Aplicar retenção no item</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12" style="margin-top:10px">
                        <button class="btn btn-sm btn-success pull-left" @click.prevent="EditItemProduto" data-dismiss="modal">
                            <i class="ace-icon fa fa-check"></i>
                            Salvar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </modal>

</div>
</template>

<script>
import axios from "axios";
import ProdutoDropdown from "./ProdutoDropdown";
import PesquisarCliente from "./PesquisarCliente";
import CriarProdutoDropdown from "./CriarProdutoDropdown";
import Select2 from 'v-select2-component';
import Multiselect from 'vue-multiselect'

import VuePhoneNumberInput from 'vue-phone-number-input';
import 'vue-phone-number-input/dist/vue-phone-number-input.css';

import {
    mapGetters
} from "vuex";
import {
    baseUrl
} from '../../../config/global';
import Swal from 'sweetalert2';

export default {
    components: {
        ProdutoDropdown,
        PesquisarCliente,
        CriarProdutoDropdown,
        VuePhoneNumberInput,
        Select2,
        Multiselect
    },

    data() {
        return {

            desconto_max: null, //valor maximo do desconto passado por parametro
            isList: true,

            produto: {}, //dados para editar qt,desconto, retencao

            tipo_documento: 1,
            formaPagamentos: [], //array bd forma de pagamentos
            armazens: [], //array bd armazens

            valor_entregue: "",
            retencao: "",
            desconto: 0,
            tipoFolha: 1,
            error: false,
            armazem: 1
        };
    },
    computed: {
        ...mapGetters({
            cliente: "CLIENTE_FACTURACAO"
        }),
        facturacao() {
            return this.$store.getters.facturacao;
        },
        total() {
            return this.$store.getters.total_preco_factura;
        }
    },
    created() {
        this.$store.dispatch("loadProdutos", this.armazem);
        this.loadFormaPagamentos();
        this.loadArmazens()
    },
    watch: {
        valor_entregue() {
            this.$store.commit("SET_VALOR_ENTREGUE", this.valor_entregue);
        },
        retencao() {
            this.$store.commit("ADD_RETENCAO_TODO_ITEM", this.retencao);
        },
        desconto() {

            if (this.desconto >= 0) {
                if (this.desconto > this.desconto_max) {
                    this.$toasted.global.defaultError({
                        msg: `O valor máximo de desconto é de ${this.desconto_max} %`
                    });
                    this.desconto = this.desconto_max
                } else {
                    this.$store.commit("ADD_DESCONTO_TODO_ITEM", this.desconto);
                }
            } else {
                this.desconto = 0;
            }

        },
        tipo_documento() {
            this.$store.commit("SET_TIPO_FACTURA", this.tipo_documento);
        },
        armazem() {
            this.$store.dispatch("loadProdutos", this.armazem);
            this.limparTodosDados();
        }

    },

    methods: {

        limparCliente() {

            Swal.fire({
                title: 'Deseja limpar dados do cliente?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    this.$store.commit("SET_CLIENTE_FACTURACAO", {});
                }
            })

        },
        limparTodosItem() {

            Swal.fire({
                title: 'Deseja limpar todos itens?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    this.$store.commit("CLEAR_FACTURACAO_ITEM", []);
                }
            })
        },
        limparTodosDados() {
            this.$store.commit("SET_CLIENTE_FACTURACAO", {});
            this.$store.commit("CLEAR_FACTURACAO_ITEM", []);
            this.valor_entregue = "";
            this.desconto = 0;
            this.facturacao.troco = ""
            this.facturacao.tipoFolha = 1
            this.tipo_documento = 1
            this.retencao = false
        },
        loadFormaPagamentos() {
            axios.get(`${baseUrl}/empresa/facturacao/formaPagamentos`).then(res => {

                res.data.formasPagamento.forEach((item, index) => {
                    this.formaPagamentos.push({
                        id: item.id,
                        text: item.designacao
                    })
                });

                //Pega o valor maximo de desconto
                this.desconto_max = res.data.desconto_max.valor;

            }).catch(error => {
                console.log('ERRO API')
            })
        },
        loadArmazens() {

            axios.get(`${baseUrl}/empresa/facturacao/armazens`).then(res => {

                res.data.armazens.forEach((item, index) => {
                    this.armazens.push({
                        id: item.id,
                        text: item.designacao
                    })
                });

                this.$store.commit("set_armazem", res.data.armazens[0].id);

            }).catch(error => {
                console.log('ERRO API')
            })

        },

        //Verifica objeto vazio
        isEmpty(obj) {
            return Object.keys(obj).length === 0;
        },
        cadastrarFactura() {

            //  console.log(this.facturacao)
            //  return

            if (this.isEmpty(this.facturacao.cliente) && this.isEmpty(this.facturacao.cliente)) {
                this.$toasted.global.defaultError({
                    msg: "Informe dados do cliente"
                });
                return
            } else if (this.isEmpty(this.facturacao.produtos)) {
                this.$toasted.global.defaultError({
                    msg: "Adicione item na facturação"
                });
                return
            } else if (this.facturacao.valor_entregue === null) {
                this.$toasted.global.defaultError({
                    msg: "Informe o valor entregar"
                });
                this.error = true;
                return
            } else if (this.facturacao.valor_entregue < this.facturacao.valor_a_pagar) {
                this.$toasted.global.defaultError({
                    msg: "O valor entregue é menor ao valor a pagar"
                });
                this.error = true;
                return
            } else {

                axios.post(`${baseUrl}/empresa/facturacao/salvar`, this.facturacao).then(res => {

                    this.$toasted.global.defaultSuccess();

                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Factura registada com sucesso!...',
                        icon: 'success',
                        confirmButtonColor: '#3d5476',
                        confirmButtonText: 'Ok',
                        onClose: () => {
                            window.open(`/empresa/facturacao/imprimir-factura/${res.data.id}`);

                            this.limparTodosDados();
                        }
                    });

                }).catch(error => {
                    console.log('ERRO API');
                })

            }

        },
        removeFacturacao(item) {

            Swal.fire({
                title: 'Deseja remover o item?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    this.$store.dispatch("removeFacturacaoList", item);

                }
            })
        },
        showModal(produto) {

            let order = {
                id: produto.id,
                designacao: produto.designacao,
                quantidade_produto: produto.quant,
                desconto_produto: ((produto.desconto_produto / (produto.preco * produto.quant)) * 100),
                retencao_produto: produto.retencao_produto || this.$store.getters.facturacao.is_retencao ? true : false,
            }
            this.produto = Object.assign({}, order);
            this.$modal.show("set-edit-facturacao");
        },
        CloseModal() {
            this.$modal.hide("set-edit-facturacao");
        },
        EditItemProduto() {

            this.produto.quantidade_produto = parseInt(this.produto.quantidade_produto); //converte int
            this.produto.desconto_produto = parseInt(this.produto.desconto_produto); //converte int

            //Verifica se existe uma retenção geral
            if (this.$store.getters.is_retencao && !this.produto.retencao_produto) {
                this.$toasted.global.defaultError({
                    msg: "Encontra activo a retenção na fonte"
                });

            } else if (this.$store.getters.desconto_geral && this.$store.getters.desconto_geral != this.produto.desconto_produto) {

                this.$toasted.global.defaultError({
                    msg: "Zera o desconto geral"
                });

            } else {

                //ENTRA AQUI CASO NÃO FOR SETADO UM DESCONTO GERAL E UM RETENÇÃO GERAL
                if (this.produto.desconto_produto >= 0 && this.produto.quantidade_produto >= 0) {
                    if (this.produto.desconto_produto > this.desconto_max) {
                        this.$toasted.global.defaultError({
                            msg: `O valor máximo de desconto é de ${this.desconto_max} %`
                        });
                        this.desconto_produto = this.desconto_max
                    } else {

                        this.$store.dispatch("SET_EDIT_FACTURACAO", this.produto);
                        this.$modal.hide("set-edit-facturacao");
                    }
                } else {
                    this.produto.desconto_produto = this.produto.desconto_produto;
                    this.produto.quantidade_produto = this.produto.quantidade_produto;
                }

            }

            //console.log(this.produto);
        }
    }
};
</script>

<style scoped>
.has-error {
    border-color: #f2a696 !important;
}

.content {
    margin-top: 15px;
    margin-left: 12px;
    padding-top: 15px;

    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);
}

.search-form-text {
    margin-bottom: 25px;
}

input {
    height: 35px;
    border-radius: 5px;
}

.main {
    margin-top: 20px;
}

.display {
    display: flex;
    align-items: center;
}

/* CSS-CLIENTE */

/* CSS-PRODUTO */
#info-produto {
    height: 150px;
}

.glyphicon-remove:before {
    color: red;
}

/* tabela facturacao */
.valor_total {
    font-size: 18px;
    font-weight: bold;
    background-color: #f3f1f1;
    height: 45px;
}

.valor_total.result {
    color: red;
}

table tr,
th {
    height: 40px;
    font-size: 14px;
    font-family: unset;
    cursor: pointer;
}

.btn-add-produto {
    background: #4bae4f;
    color: #fff;
    border-radius: 0;
    margin-top: 10px;
    padding: 10px;
    border: none;
    border-radius: 5px;
}

.btn-add-produto_1 {
    display: flex;
    flex-direction: row;
}

.btn-add-produto:hover {
    background-color: #256327;
}

#semProduto {
    display: flex;
    justify-content: center;
    text-align: center;
    padding-top: 15px;
    border: 1px solid #ccc;
    padding-bottom: 20px;
}

#semProduto .text {
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0.2rem;
}

.semProdutoDescription {
    display: flex;
    flex-direction: column;
}

.glyphicon-list {
    font-size: 4rem;
}

#btn-modal-edit-facturacao button {
    margin-top: 20px;
}

.modal-header#modalEditFactura {
    background-color: #307ecc;
    color: white;
}

.modal-header#modalEditFactura h3.smaller {
    color: white !important;
}

.tr_cliente tr {
    border-bottom: 1px solid #ccc;
}

#table_cliente_factura {
    margin-bottom: 10px;
}

#form-field-select-1 {
    height: 35px;
    font-size: 16px;
    width: 300px;
}

input {
    font-size: 16px;
}

tr {
    font-size: 11px;
}

.tipoFacturar {
    display: flex;
}

.inputFormPag {
    margin-bottom: 15px;
}

body {
    font-family: 'Source Sans Pro', 'Helvetica Neue', Arial, sans-serif;
    text-rendering: optimizelegibility;
    -moz-osx-font-smoothing: grayscale;
    -moz-text-size-adjust: none;
}

h1,
.muted {
    color: #2c3e5099;
}

h1 {
    font-size: 26px;
    font-weight: 600;
}

.select2-container .select2-selection--single {
    height: 35px;
    padding: 4px;
}

#app {
    max-width: 30em;
    margin: 1em auto;
}
</style>
