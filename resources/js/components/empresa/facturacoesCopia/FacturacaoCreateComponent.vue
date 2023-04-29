<template>
<div class="facturaRegibo">
    <div class="modal-content">
        <div class="modal-body">
            <div class="row">
                <div>
                    <div class="search-form-text" id="headerTitle">
                        <div class="search-text">
                            <i class="menu-icon glyphicon glyphicon-barcode"></i>
                            Facturação
                        </div>
                        <div class="search-text" id="valorPgt">
                            <!-- <i class="menu-icon glyphicon glyphicon-barcode"></i> -->
                           Total {{facturacao.valor_a_pagar|currency}}
                        </div>
                    </div>

                </div>
            </div>
            <div class="row" id="content-facturacao">
                <div class="col-md-4 grid-facturacao" id="produto-item">
                    <div class="clearfix">
                        <div class="pull-right tableTools-container"></div>
                    </div>
                    <div id="info-total">
                        <div>
                            <div class="total-item">Total a pagar<span>{{facturacao.valor_a_pagar|currency}}</span></div>
                            <div class="total-item">Troco <span>{{facturacao.troco?facturacao.troco:0|currency}}</span></div>
                            <div class="total-item">Desconto <span>{{facturacao.desconto|currency}}</span></div>
                            <div class="total-item">Total da factura <span>{{facturacao.total_preco_factura | currency }}</span></div>
                            <div class="total-item">Valor extenso <span>{{facturacao.valor_extenso }}</span></div>
                        </div>

                    </div>
                    <div class="table-header">Produtos e serviços</div>

                    <table class="table table-striped table-hover" v-if="facturacao.produtos.length">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th style="display:flex; justify-content:flex-end">Preço.Unit.</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="prod in facturacao.produtos" :key="prod.id" @click="showModal(prod)">
                                <td>{{prod.designacao}} <b>({{prod.quant}})</b></td>
                                <td>{{prod.preco | currency }}</td>
                                <td colspan="1">
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
                        </tfoot>
                    </table>
                    <div v-else id="semProduto">
                        <div class="semProdutoDescription">
                            <div>
                                <i class="glyphicon glyphicon-list"></i>
                            </div>
                            <div>
                                <div class="text">Não existe produto/serviços na lista</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 grid-facturacao" style="padding-top:10px">

                    <div class="row">

                        <!-- PESQUISA PRODUTOS  -->

                        <div class="col-md-12">
                            <span class="input-form-icon">
                                <form action id="search-form">
                                    <input type="text" class="col-md-12 search-query" placeholder="Buscar produtos e serviços..." autocomplete="off" v-model="searchQuery" autofocus />

                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                                    <!-- <i class="ace-icon fa fa-remove nav-search-icon" id="icon-remove" @click="clearInput"></i> -->

                                </form>
                            </span>
                        </div>

                        <!-- FIM PESQUISA PRODUTOS  -->

                    </div>
                    <hr>
                    <!-- SELECT2 ARMAZENS E CATEGORIAS  -->

                    <div class="row">

                        <!-- SELECT2 ARMAZENS  -->
                        <div class="col-md-12">
                            <label class="control-label bold" for="preco_compra">
                                Loja/Armazém
                            </label>
                            <Select2 :options="armazens" v-model="armazem">
                                <!-- <option disabled value="0">Select one</option> -->
                            </Select2>
                        </div>

                        <!-- FIM SELECT2 ARMAZENS  -->

                    </div>
                    <!-- FIM SELECT2 ARMAZENS E CATEGORIAS  -->

                    <!-- LISTAR PRODUTOS  -->

                    <div class="row scroller" v-if="resultQuery.length > 0">

                        <div class="col-md-4 content-produto" v-for="prod in resultQuery" :key="prod.id" @click="addFacturacao(prod)">

                            <div class="widget-box widget-color-dark light-border produto-item" style="heigth:100px" id="widget-box-6">
                                <div class="widget-header">
                                    <div class="widget-title smaller"><span class="badge badge-danger"> {{prod.preco_venda | currency}}</span>
                                        <!--|<span class="badge badge-danger">Alert</span> -->
                                    </div>
                                </div>

                                <div class="widget-body produto-info">
                                    <div class="widget-main padding-6">
                                        <div class="alert alert-info">{{prod.designacao}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="resultQuery==null">
                        <h1>Sem produtos</h1>
                    </div>

                    <!-- FIM PRODUTOS  -->

                </div>
                <div class="col-md-3" style="padding:0px">

                    <!-- INPUT PESQUISA CLIENTE  -->
                    <div class="col-md-12" style="padding:10px;margin-bottom:10px">
                        <PesquisarCliente></PesquisarCliente>
                    </div>
                    <!-- FIM INPUT PESQUISA CLIENTE  -->

                    <div class="col-md-12" style="padding:0px">
                        <div class="tabbable">
                            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                                <li class="active">
                                    <a data-toggle="tab" href="#dropdown14">Pagamento</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#dropdown16">Desconto/Retenção</a>
                                </li>
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

                                            <div class="inputFormPag">
                                                <Select2 :options="formaPagamentos" v-model="facturacao.formas_pagamento_id">
                                                </Select2>
                                            </div>
                                            <div class="inputFormPag">
                                                <label class="control-label bold" for="preco_compra">
                                                    Valor Entregue
                                                </label>

                                                <input type="number" v-model="valor_entregue" class="form-control" :class="error?'has-error':''">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div id="dropdown16" class="tab-pane">

                                    <div class="row">
                                        <div class="col-md-12 inputFormPag">

                                            <div class="inputFormPag">
                                                <label class="control-label bold" for="preco_compra">
                                                    Desconto
                                                </label>

                                                <input type="number" v-model.number="desconto" class="form-control">
                                            </div>
                                            <div class="checkbox">
                                                <label class="block">
                                                    <input v-model="retencao" name="form-field-checkbox" type="checkbox" class="ace input-sm" />
                                                    <span class="lbl bigger-100">Aplicar retenção na fonte</span>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" style="padding:0px">
                        <div class="tabbable">
                            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                                <li class="active">
                                    <a data-toggle="tab" href="#dropdown17">Tipo Factura</a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#dropdown18">Formato factura</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="dropdown17" class="tab-pane in active">

                                    <div class="radio">

                                        <label>
                                            <input name="form-field-radio1" v-model="tipo_documento" :value="1" type="radio" class="ace input-sm" />
                                            <span class="lbl bigger-100"> Recibo</span>
                                        </label>
                                        <label>
                                            <input name="form-field-radio2" v-model="tipo_documento" :value="2" type="radio" class="ace input-sm" />
                                            <span class="lbl bigger-100">Factura</span>
                                        </label>

                                        <label>
                                            <input name="form-field-radio3" v-model="tipo_documento" :value="3" type="radio" class="ace input-sm" />
                                            <span class="lbl bigger-100">Proforma</span>
                                        </label>
                                    </div>

                                </div>

                                <div id="dropdown18" class="tab-pane">
                                    <div class="row">
                                        <div class="col-md-12 inputFormPag">

                                            <div class="radio">

                                                <label>
                                                    <input name="form-field-radio_1" v-model="tipoFolha" :value="1" type="radio" class="ace input-sm" />
                                                    <span class="lbl bigger-100">A4</span>
                                                </label>
                                                <label>
                                                    <input name="form-field-radio_2" v-model="tipoFolha" :value="2" type="radio" class="ace input-sm" />
                                                    <span class="lbl bigger-100"> A5</span>
                                                </label>

                                                <label>
                                                    <input name="form-field-radio_3" v-model="tipoFolha" :value="3" type="radio" class="ace input-sm" />
                                                    <span class="lbl bigger-100">Ticket</span>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" style="padding:0px">

                        <div class="tabbable">
                            <ul class="nav nav-tabs padding-12 tab-color-blue background-blue" id="myTab4">
                                <li class="active">
                                    <a data-toggle="tab" href="#clienteDiverso1">Clientes-Gerais</a>
                                </li>

                                <li>
                                    <a data-toggle="tab" href="#clienteDiverso2">Clientes-Outros</a>
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
                                                NIF
                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                </span>
                                            </label>
                                            <input type="text" v-model="cliente.nif_cliente" class="form-control">
                                        </div>
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
                                                Email
                                            </label>

                                            <input type="text" v-model="cliente.email_cliente" class="form-control">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div id="clienteDiverso2" class="tab-pane">
                                    <div class="row">
                                        <div class="col-md-12 inputFormPag">
                                            <label class="control-label bold" for="conta_corrente">
                                                Conta Corrente
                                                <!-- <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                </span> -->
                                            </label>
                                            <input autocomplete="true" type="text" v-model="cliente.conta_corrente_cliente" class="form-control">
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

        </div>
        <div class="row">
            <div class="" style="float:right;padding-right: 10px;margin-right:10px">
                <a href="#" class="btn btn-app btn-primary btn-xs" @click.prevent="cadastrarFactura">
                    <i class="ace-icon fa fa-print bigger-160"></i>
                    Facturar
                </a>
            </div>
        </div>

    </div>
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
                        <label class="control-label" for="desconto">Retenção</label>

                        <div class="checkbox" style="margin-top:0;">
                            <label class="block">
                                <input v-model="produto.retencao_produto" name="form-field-checkbox" type="checkbox" class="ace input-sm" />
                                <span class="lbl bigger-100" style="padding:7px;">Aplicar retenção no item</span>
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
import axios from 'axios'
import Select2 from 'v-select2-component';
import PesquisarCliente from "./PesquisarCliente";
import Swal from 'sweetalert2';

import {
    mapGetters
} from "vuex";

import {
    baseUrl
} from '../../../config/global';

export default {
    components: {
        Select2,
        PesquisarCliente,
    },
    data() {
        return {

            desconto_max: null, //valor maximo do desconto passado por parametro
            isList: true,
            produto: {}, //dados para editar qt,desconto, retencao
            tipo_documento: 1, //tipo factura
            formaPagamentos: [], //array bd forma de pagamentos
            armazens: [],
            valor_entregue: "",
            retencao: "",
            desconto: 0,
            tipoFolha: 1, //tipo folha
            error: false,
            armazem: 1,

            searchQuery: null, //Pesquisa produtos e serviços
            categorias: [],
            quantidade: 1 //quant inicial ao adicionar produto no carrinho

        }
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
        },
        produtos() {
            return this.$store.getters.produtos;
        },

        resultQuery() {
            if (this.searchQuery) {
                return this.produtos.filter(item => {

                    return item.designacao.toLowerCase().match(this.searchQuery)
                           || item.designacao.toUpperCase().match(this.searchQuery)
                           || item.referencia.toLowerCase().match(this.searchQuery)
                           || item.referencia.toUpperCase().match(this.searchQuery)
                           || item.codigo_barra.toLowerCase().match(this.searchQuery)
                           || item.id==this.searchQuery // quando o valor a pesquisar é um inteiro
                           || item.created_at.toLowerCase().match(this.searchQuery)
                });
            } else {
                return this.produtos;
            }
        }
    },
    created() {

        this.$store.dispatch("loadProdutos", this.armazem);
        this.loadFormaPagamentos();
        this.loadArmazens();


        this.$store.commit("SET_TIPO_FACTURA", this.tipo_documento);

    },
    watch: {
        valor_entregue() {
            this.$store.commit("SET_VALOR_ENTREGUE", this.valor_entregue);
        },
        retencao() {
            console.log(this.retencao)
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
        tipoFolha() {
            this.$store.commit("SET_TIPO_FOLHA", this.tipoFolha);
        },
        armazem() {

            this.$store.dispatch("loadProdutos", this.armazem);
            this.limparTodosDados();
        }
    },
    methods: {
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
        clearInput() {
            this.searchQuery = null
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
        },
        addFacturacao(item) { //adicionar produto no carrinho

            const order = {
                id: item.id,
                designacao: item.designacao,
                preco: item.preco_venda,
                preco_compra: item.preco_compra,
                quant: this.quantidade,
                stocavel: item.stocavel,

                /**adiciona a quantidade em estock, caso não existir retorna 0*/
                //quant_stock_produto: item.existencia_estock ? item.existencia_estock.quantidade : 0,

                iva_produto: item.taxa,
                taxa: item.taxa,
                unidade: item.designacao_unidade_medida
            };

            this.$store.dispatch("addFacturacao", order);

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
                    this.limparTodosDados();

                }
            })
        },
        limparTodosDados() {
            this.$store.commit("SET_CLIENTE_FACTURACAO", {});
            this.$store.commit("CLEAR_FACTURACAO_ITEM", []);
            this.valor_entregue = "";
            this.desconto = 0;
            this.facturacao.troco = ""
            this.facturacao.total_preco_factura = 0
            this.facturacao.valor_a_pagar = 0
            this.facturacao.valor_extenso = ""

            this.facturacao.tipoFolha = 1
            this.tipo_documento = 1
            this.retencao = false
        },
        cadastrarFactura() {

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

                console.log(this.facturacao)

                axios.post(`${baseUrl}/empresa/facturacao/salvar`, this.facturacao).then(res => {
                    
                    this.$toasted.global.defaultSuccess();

                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Factura registada com sucesso!...',
                        icon: 'success',
                        confirmButtonColor: '#3d5476',
                        confirmButtonText: 'Ok',
                        onClose: () => {
                            window.open(`/empresa/facturacao/imprimir-factura/${res.data.id}/${this.tipoFolha}`);
                            // window.open(`/empresa/facturacao/imprimir-factura/${res.data.id}`);

                            this.limparTodosDados();
                        }
                    });

                }).catch(error => {
                    console.log('ERRO API');
                })

            }

        },
    }

}
</script>

<style scoped>
.alert {
    padding: 8px;
    font-size: 11px;
}

.nav-tabs.tab-color-blue>li>a {
    background-color: #307ECC;
}

.nav-tabs.tab-color-blue>li.active>a,
.nav-tabs.tab-color-blue>li.active>a:focus,
.nav-tabs.tab-color-blue>li.active>a:hover {
    background-color: white;
    color: #333;
}

#info-total {
    display: flex;
    flex-direction: column;
    border: 1px solid #ccbfbf;
    background: #0c1b25;
    color: white;
    padding: 10px;
    border-radius: 5px 5px 0px 0;
}

.total-item {
    padding: 2px;
    border-bottom: 1px solid #504848;
    display: flex;
    justify-content: space-between;
}

.total-item span {
    color: #fff;
}

.checkbox label input[type=checkbox].ace+.lbl {
    margin-left: -19px;
    background: #ccc;
    padding: 10px;
    border-radius: 5px;
    color: #333;
}

.radio label input[type=radio].ace+.lbl {
    margin-left: -19px;

    background: #ccc;
    padding: 4px;
    border-radius: 5px;
    color: #333;
}

.tipoFacturar {
    display: flex;
}

.inputFormPag {
    margin-bottom: 7px;
}

input {
    height: 35px;
    border-radius: 5px !important;
}

.alert-info {
    background: #103d54;
    color: white;
    height: 73px;

}

.widget-color-dark>.widget-header {
    background: #333;

}

.content-produto {

    border-bottom: 1px solid #e2dbdb;
    padding-bottom: 10px !important;
    padding-top: 10px !important;

}

.produto-item:hover {
    cursor: pointer;
}

.produto-info {
    height: 85px;
    color: white;
}

.grid-facturacao {
    border: 1px solid #e8e8e8;
    height: 100%;
}

#content-facturacao {
    height: 688px;
}

.search-query {
    border: 1px solid #6fb3e0;
    border-radius: 4px !important;
    padding-left: 24px;
}

.search-query:focus {
    border: 1px solid #6fb3e0;
}

span.input-form-icon {
    position: relative;
}

span.input-form-icon .ace-icon {
    padding: 0 3px;
    z-index: 2;
    position: absolute;
    top: 1px;
    bottom: 1px;
    left: 3px;
    line-height: 30px;
    display: inline-block;
    color: #6fb3e0 !important;
    font-size: 16px;
}

#icon-remove {
    left: 236px;
    cursor: pointer;
}

table tr,
th {
    height: 20px;
    font-size: 13px;
    font-family: unset;
    cursor: pointer;
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
    font-size: 13px;
    font-weight: 500;
    /* letter-spacing: 0.2rem; */
}

.semProdutoDescription {
    display: flex;
    flex-direction: column;
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

.search-form-text #valorPgt {
    display: inline-block;
    font-size: 20px;
    color: #fff;
    text-transform: uppercase;
    background: #333;
    padding: 13px 30px;
    font-weight: 700;
}

#headerTitle {
    display: flex;
    justify-content: space-between;
}

.scroller {
    width: 100%;
    height: 457px;
    overflow-y: scroll;
    scrollbar-color: rebeccapurple green;
}
</style>
