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

            <div class="row">

                <div class="col-md-4" id="produto-item">
                    <div class="clearfix">
                        <div class="pull-right tableTools-container"></div>
                    </div>
                    <div class="table-header">
                        *****
                    </div>
                    <div class="table-header">Produtos e serviços</div>

                    <table id="dynamic-table" class="table table-striped  table-hover">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Preço.Unit.</th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>COMPUTADOR HP <b>(5)</b></td>
                                <td>10000,00</td>
                                <td>
                                    <div class="hidden-sm hidden-xs action-buttons">
                                        <a class="red" @click.stop="removeFacturacao(prod.id)">
                                            <i class="ace-icon glyphicon glyphicon-remove bigger-130"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>SOFTWARE MUTUE <b>(5)</b></td>
                                <td>30000,00</td>
                                <td>
                                    <div class="hidden-sm hidden-xs action-buttons">
                                        <a class="red" @click.stop="removeFacturacao(prod.id)">
                                            <i class="ace-icon glyphicon glyphicon-remove bigger-130"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>COMPUTADOR DELL <b>(5)</b></td>
                                <td>20000,00</td>
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
                        </tfoot>
                    </table>
                </div>
                <div class="col-md-6" id="produtos-list">
                    <!-- <PesquisarCliente></PesquisarCliente> -->

                </div>
                <div class="col-md-2">...</div>

            </div>

            <!-- FIM -->

        </div>
        <!-- /.modal-content -->
    </div>

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
#produto-item{
    border: 1px solid #ccc;
}
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
