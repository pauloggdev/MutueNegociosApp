<template>
<section class="content">
    <div class="row">
        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Entrada Produto Estoque
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Cadastro
                </small>
            </h1>
        </div>

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

        <div class="row">
            <div class="col-md-12">
                <div class="search-form-text">
                    <div class="search-text">
                        <i class="fa fa-product-hunt"></i>
                        Dados Referentes entrada produto no estoque
                    </div>
                </div>

                <form method="POST" enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                    <div class="second-row">
                        <div class="tabbable">
                            <div class="tab-content profile-edit-tab-content">
                                <div id="dados_fornecedor" class="tab-pane in active" style="">

                                    <div class="form-group has-info bold" style="left: 0%; position: relative">

                                        <div class="col-md-4">
                                            <label class="control-label bold label-select2" for="designacao">Nº Factura<b class="red fa fa-question-circle"></b></label>
                                            <div class="input-group">
                                                <input type="text" v-model="entradaData.num_factura_fornecedor" :class="errors.num_factura_fornecedor ? 'has-error' : ''" id="num_factura_fornecedor" class="col-md-12 col-xs-12 col-sm-4" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                </span>
                                            </div>
                                            <span v-if="errors.num_factura_fornecedor" class="error">{{errors.num_factura_fornecedor[0]}}</span>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="control-label bold label-select2" for="controlo_stock">Fornecedor<b class="red fa fa-question-circle"></b></label>
                                            <Select2 :options="fornecedores" v-model="entradaData.fornecedor_id" id="fornecedor_id" style="width: 100%" placeholder="Escolha o fornecedor">
                                            </Select2>
                                            <span v-if="errors.fornecedor_id" class="error">{{errors.fornecedor_id[0]}}</span>

                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label bold label-select2" for="controlo_stock">Armazéns<b class="red fa fa-question-circle"></b></label>
                                            <Select2 :options="armazens" v-model="entradaData.armazem_id" id="armazem_id" style="width: 100%" placeholder="Escolha o armazém">
                                            </Select2>
                                            <span v-if="errors.armazem_id" class="error">{{errors.armazem_id[0]}}</span>

                                        </div>

                                    </div>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-4">
                                            <label class="control-label" for="gestor">
                                                Factura/Data
                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                </span>
                                            </label>
                                            <div class>
                                                <date-pick v-model="entradaData.data_factura_fornecedor" :format="'DD/MM/YYYY'" id="dataStock"></date-pick>
                                            </div>
                                            <span v-if="errors.data_factura_fornecedor" class="error">{{errors.data_factura_fornecedor[0]}}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label" for="gestor">
                                                Data de entrada
                                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                    <i class="fa fa-question-circle bold text-danger"></i>
                                                </span>
                                            </label>
                                            <div class>
                                                <date-pick v-model="entradaData.created_at" :format="'DD/MM/YYYY'" id="dataStock"></date-pick>
                                            </div>
                                            <span v-if="errors.created_at" class="error">{{errors.created_at[0]}}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label bold label-select2" for="controlo_stock">Forma de Pagamento<b class="red fa fa-question-circle"></b></label>
                                            <Select2 :options="formasPagamentos" v-model="entradaData.forma_pagamento_id" style="width: 100%" placeholder="Escolha a forma de pagamento">
                                            </Select2>
                                            <span v-if="errors.forma_pagamento_id" class="error">{{errors.forma_pagamento_id[0]}}</span>

                                        </div>
                                    </div>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-6">
                                            <label class="control-label bold label-select2" for="controlo_stock">Selecione o produto<b class="red fa fa-question-circle"></b></label>
                                            <Select2 :options="produtos" v-model="entradaData.produto_id" style="width: 100%" placeholder="Selecione o produto">
                                            </Select2>
                                            <span v-if="errors.produtos" class="error">{{errors.produtos[0]}}</span>

                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label bold label-select2" for="designacao">Preço de compra<b class="red fa fa-question-circle"></b></label>
                                            <div class="input-group">
                                                <input type="number" v-model="entradaData.preco_compra" :class="errors.preco_compra ? 'has-error' : ''" id="preco_compra" class="col-md-12 col-xs-12 col-sm-4" />
                                                <span class="input-group-addon" id="basic-addon1">
                                                    <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                </span>

                                            </div>
                                            <span v-if="errors.preco_compra" class="error">{{errors.preco_compra[0]}}</span>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label bold label-select2" for="designacao">Desc(%)<b class="red fa fa-question-circle"></b></label>
                                            <div class="input-group">
                                                <input type="number" v-model="entradaData.descontoPerc" :min="0" :max="100" :class="errors.descontoPerc ? 'has-error' : ''" id="preco_compra" class="col-md-12 col-xs-12 col-sm-4" />
                                                <span class="input-group-addon" id="basic-addon1">
                                                    <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                </span>

                                            </div>
                                            <span v-if="errors.descontoPerc" class="error">{{errors.descontoPerc[0]}}</span>
                                        </div>

                                        <div class="col-md-2">
                                            <label class="control-label bold label-select2" for="controlo_stock">Quantidade<b class="red fa fa-question-circle"></b></label>
                                            <div class="input-icon">
                                                <vue-numeric-input v-model="entradaData.quantidade" :min="1" :step="1" id="quantidade" :class="errors.quantidade ? 'has-error' : ''"></vue-numeric-input>
                                                <span v-if="errors.quantidade" class="error">{{errors.quantidade[0]}}</span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-2">
                                            <button @click.prevent="addCarrinho" class="btn btn-sm btn-success">
                                                <i class="glyphicon glyphicon-plus bigger-110"></i>
                                                <span class="bigger-110 no-text-shadow">Adicionar</span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="widget-box widget-color-green" style="left: 0%">
                                        <div class="table-header widget-header">
                                            Todas os produtos de entrada adicionados
                                        </div>

                                        <!-- div.dataTables_borderWrap -->
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Designação</th>
                                                    <th style="text-align:center">Qtd</th>
                                                    <th style="text-align:right">Preço Compra</th>
                                                    <th style="text-align:right">Preço Venda</th>
                                                    <th style="text-align:right">Desc(%)</th>
                                                    <th style="text-align:right">Total Compra</th>
                                                    <th style="text-align:right">Total Venda</th>
                                                    <th style="text-align:right">Total Lucro</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr v-for="(c, i) in entradaData.produtos" :key="c.id">
                                                    <td>{{ c.produto_id }}</td>
                                                    <td>{{ c.designacao}}</td>
                                                    <td style="text-align:center">{{ c.quantidade|formatQt}}</td>
                                                    <td style="text-align:right">{{c.preco_compra|currency}}</td>
                                                    <td style="text-align:right">{{c.preco_venda|currency}}</td>
                                                    <td style="text-align:right">{{ c.descontoPerc|formatQt}}%</td>
                                                    <td style="text-align:right">{{c.total_compra|currency}}</td>
                                                    <td style="text-align:right">{{c.total_venda|currency}}</td>
                                                    <td style="text-align:right">{{c.lucroUnitario|currency}}</td>

                                                    <td colspan="1">
                                                        <div class="hidden-sm hidden-xs action-buttons">
                                                            <a class="red" @click="delItemCar(i, c)" style="cursor: pointer;">
                                                                <i data-v-28b992ac="" class="ace-icon fa fa-trash-o fa-2x icon-only bigger-130">
                                                                </i>
                                                            </a>
                                                        </div>
                                                    </td>

                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-2">
                                            <label class="control-label bold label-select2" for="designacao">Total S/Imposto,Desc<b class="red fa fa-question-circle"></b></label>
                                            <div class="input-group">
                                                <input type="number" v-model="entradaData.totalSemImpostoSemDesconto" class="col-md-12 col-xs-12 col-sm-4" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label bold label-select2" for="designacao">Desconto<b class="red fa fa-question-circle"></b></label>
                                            <div class="input-group">
                                                <input type="number" v-model="entradaData.totalDesconto" class="col-md-12 col-xs-12 col-sm-4" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label bold label-select2" for="designacao">Retenção<b class="red fa fa-question-circle"></b></label>
                                            <div class="input-group">
                                                <input type="number" v-model="entradaData.totalRetencao" class="col-md-12 col-xs-12 col-sm-4" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label bold label-select2" for="designacao">IVA<b class="red fa fa-question-circle"></b></label>
                                            <div class="input-group">
                                                <input type="number" v-model="entradaData.totalIva" class="col-md-12 col-xs-12 col-sm-4" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label bold label-select2" for="designacao">Total da compra<b class="red fa fa-question-circle"></b></label>
                                            <div class="input-group">
                                                <input type="text" :value="entradaData.total_compras|currency" :disabled="true" :min="0" class="col-md-12 col-xs-12 col-sm-4" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                </span>

                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label bold label-select2" for="designacao">Total da venda<b class="red fa fa-question-circle"></b></label>
                                            <div class="input-group">
                                                <input type="text" :value="entradaData.total_venda|currency" :disabled="true" :min="0" class="col-md-12 col-xs-12 col-sm-4" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                </span>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix form-actions">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button class="search-btn" type="submit" style="border-radius: 10px" @click.prevent="cadastrarEntradaEstoque">
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
                    </div>
                </form>
            </div>
        </div>

    </div>
</section>
</template>

<script>
import axios from "axios";
import {
    showError,
    baseUrl
} from "./../../../config/global";
import {
    mapState
} from "vuex";
import Swal from "sweetalert2";
import Select2 from "v-select2-component";
import DatePick from "vue-date-pick";
import "vue-date-pick/dist/vueDatePick.css";
import "vue-multiselect/dist/vue-multiselect.min.css";
import VueNumericInput from "vue-numeric-input";
import Multiselect from "vue-multiselect";

export default {
    props: ["guard", "formapagamentos"],

    components: {
        Select2,
        DatePick,
        VueNumericInput,
        Multiselect,
    },
    data() {
        return {
            errors: [],
            entradaData: {
                created_at: this.formatDate(),
                data_factura_fornecedor: this.formatDate(),
                total_compras: 0,
                total_venda: 0,
                descontoPerc: 0,
                totalLucro: 0,
                totalSemImpostoSemDesconto: 0,
                totalDesconto: 0,
                totalRetencao: 0,
                totalIva: 0,
                produtos: [],
                quantidade: 1,
                preco_compra: 0
            },
            armazens: [],
            fornecedores: [],
            formasPagamentos: [],
            produtos: [],
            router: this.guard.tipo_user_id == 2 ?
                window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`
        }
    },

    created() {

        this.listarArmazens();
        this.listarFornecedores();
        this.listarFormaPagamento();
        this.listarProdutos();

    },
    methods: {

        async addCarrinho() {

            if (!this.entradaData.num_factura_fornecedor) {
                this.$toasted.global.defaultError({
                    msg: "Informe o numero da factura",
                });
                return;
            } else if (!this.entradaData.data_factura_fornecedor) {
                this.$toasted.global.defaultError({
                    msg: "Informe a data da factura",
                });
                return;
            } else if (!this.entradaData.created_at) {
                this.$toasted.global.defaultError({
                    msg: "Informe a data entrada do produto",
                });
                return;
            } else if (!this.entradaData.forma_pagamento_id) {
                this.$toasted.global.defaultError({
                    msg: "Informe a forma de pagamento",
                });
                return;
            } else if (this.entradaData.preco_compra <= 0) {
                this.$toasted.global.defaultError({
                    msg: "Informe o preço de compra",
                });
                return;
            } else if (!this.entradaData.quantidade) {
                this.$toasted.global.defaultError({
                    msg: "Informe a quantidade",
                });
                return;

            }

            this.produtos.find(produto => {

                if (produto.id === Number.parseInt(this.entradaData.produto_id)) {

                    if (this.verificaSeProdutoExisteNoCarrinho(produto)) {
                        this.$toasted.global.defaultError({
                            msg: "Este produto já existe no carrinho",
                        });
                        return;
                    } else {
                        let total_compra = this.calcularPrecoCompra(Number(this.entradaData.preco_compra), this.entradaData.quantidade);
                        let total_venda = this.calcularPrecoVenda(produto.preco_venda, this.entradaData.quantidade);
                        let lucroUnitario = this.calcularLucro(total_compra, total_venda);

                        this.entradaData.total_compras = parseFloat(this.entradaData.total_compras) + parseFloat(total_compra);
                        this.entradaData.total_venda = parseFloat(this.entradaData.total_venda) + parseFloat(total_venda);
                        this.entradaData.totalLucro += lucroUnitario;

                        this.entradaData.produtos.push({
                            produto_id: produto.id,
                            designacao: produto.designacao,
                            quantidade: this.entradaData.quantidade,
                            preco_compra: parseFloat(this.entradaData.preco_compra),
                            descontoPerc: this.entradaData.descontoPerc,
                            lucroUnitario: lucroUnitario,
                            preco_venda: parseFloat(produto.preco_venda),
                            total_venda: parseFloat(total_venda),
                            total_compra: parseFloat(total_compra),
                        });
                    }
                }
            })

        },

        calcularPrecoVenda(precoVenda, quant) {
            return parseFloat(precoVenda) * parseInt(quant);
        },
        calcularLucro(total_compra, total_venda) {
            return parseFloat(total_venda) - parseInt(total_compra);
        },

        calcularPrecoCompra(precoCompra, quant) {
            return parseFloat(precoCompra) * parseInt(quant);
        },
        async delItemCar(pos, element) {

            this.entradaData.produtos.splice(pos, 1);

            this.entradaData.total_compras = this.calcularTotalCompra();
            this.entradaData.total_venda = this.calcularTotalVenda();
            this.entradaData.totalLucro = this.calcularTotalLucro();
        },
        calcularTotalVenda() {

            var total_venda = 0;
            this.entradaData.produtos.forEach(el => {
                total_venda += el.total_venda;
            });
            return total_venda;
        },
        calcularTotalLucro() {

            var total_lucro = 0;
            this.entradaData.produtos.forEach(el => {
                total_lucro += el.lucroUnitario;
            });
            return total_lucro;
        },
        calcularTotalCompra() {

            var total_compra = 0;
            this.entradaData.produtos.forEach(el => {
                total_compra += el.total_compra;
            });
            return total_compra;
        },
        verificaSeProdutoExisteNoCarrinho(produto) {

            return this.entradaData.produtos.find(element => {
                if (element.produto_id == produto.id) {
                    return true;
                }
            })

        },
        async listarProdutos() {

            try {
                let response = await axios.get(`${this.router}/listarProdutos`);
                if (response.status == 200) {
                    this.produtos = [];
                    response.data.produtos.forEach((item) => {
                        this.produtos.push({
                            text: item.designacao,
                            ...item
                        });
                    });
                }

            } catch (error) {

            }

        },

        listarFormaPagamento() {

            this.formapagamentos.forEach(pgt => {
                this.formasPagamentos.push({
                    id: pgt.id,
                    text: pgt.descricao,
                });
            });
        },

        async listarArmazens() {
            try {
                let response = await axios.get(`${this.router}/produtos/listarArmazens`);
                if (response.status == 200) {
                    this.armazens = [];
                    response.data.armazens.forEach((item) => {
                        this.armazens.push({
                            id: item.id,
                            text: item.designacao,
                        });
                    });
                    this.entradaData.armazem_id = response.data.armazens[0].id;
                }

            } catch (error) {

            }
        },
        async listarFornecedores() {

            try {
                let response = await axios.get(`${this.router}/listarFornecedores`);
                if (response.status == 200) {
                    this.fornecedores = [];
                    response.data.fornecedores.forEach((item) => {
                        this.fornecedores.push({
                            id: item.id,
                            text: item.nome,
                        });
                    });
                    this.entradaData.fornecedor_id = response.data.fornecedores[0].id;
                }

            } catch (error) {

            }
        },
        formatDate() {

            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            today = dd + '/' + mm + '/' + yyyy;

            return today;
        },
        async cadastrarEntradaEstoque() {

            this.entradaData.preco_compra = parseFloat(this.entradaData.preco_compra);
            this.entradaData.totalSemImpostoSemDesconto = parseFloat(this.entradaData.totalSemImpostoSemDesconto);
            this.entradaData.totalDesconto = parseFloat(this.entradaData.totalDesconto);
            this.entradaData.totalRetencao = parseFloat(this.entradaData.totalRetencao);
            this.entradaData.totalIva = parseFloat(this.entradaData.totalIva);

            if (this.entradaData.produtos.length > 0) {
                if (this.verificarCampoVazio(this.entradaData)) {
                    this.$toasted.global.defaultError({
                        msg: "Todos os campos devem ser preenchidos",
                    });
                    return;
                }

                // if (this.entradaData.total_compras != this.verificarValorCorrespondePrecoCompra(this.entradaData)) {
                //     this.$toasted.global.defaultError({
                //         msg: "Os valores informados não correspondem com o total da compra",
                //     });
                //     return;
                // }

            } else {
                this.$toasted.global.defaultError({
                    msg: "Adicione a entrada no carrinho",
                });
                return;
            }

            this.$loading(true)
            try {
                let response = await axios.post(`${this.router}/entradaStock`, this.entradaData, {
                    responseType: "arraybuffer",
                });

                if (response.status == 200) {
                    this.$loading(false)

                    this.$toasted.global.defaultSuccess();

                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Entrada registrado com sucesso!',
                        icon: 'success',
                        confirmButtonColor: '#3d5476',
                        confirmButtonText: 'Ok',
                        onClose: () => {
                            var file = new Blob([response.data], {
                                type: "application/pdf",
                            });
                            var fileURL = URL.createObjectURL(file);
                            window.open(fileURL);
                            document.location.reload(true)
                        }
                    });
                } else {
                    this.$loading(false)
                    console.log("Erro ao carregar pdf");
                }

            } catch (error) {
                this.$loading(false)
                this.$toasted.global.defaultError({
                    msg: "Erro ao cadastrar"
                });
                this.errors = error.response.data.errors;
            }
        },
        verificarValorCorrespondePrecoCompra(entrada) {
            return entrada.totalSemImpostoSemDesconto - entrada.totalDesconto - entrada.totalRetencao + entrada.totalIva;
        },
        verificarCampoVazio(entrada) {

            if (isNaN(entrada.totalSemImpostoSemDesconto) ||
                isNaN(entrada.totalDesconto) || isNaN(entrada.totalRetencao) ||
                isNaN(entrada.totalIva)) {
                return true
            } else {
                return false
            }

        }
    },

    mounted() {

    },

};
</script>

<style>
#dataStock>input {
    padding: 7px !important;
    width: 349px !important;
}

.vue-numeric-input .btn-decrement .btn-icon,
.btn.focus {
    background: #d15b47 !important;
}

.ui-accordion .ui-accordion-content {
    display: block;
}

.is-invalid,
.invalid-feedback {
    border-color: red;
    color: red;
}
</style>
