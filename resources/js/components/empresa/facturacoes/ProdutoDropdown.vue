<template>
<div id="right-menu" class="modal aside" data-body-scroll="false" data-offset="true" data-placement="right" data-fixed="true" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header no-padding">
                <div class="table-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <span class="white">&times;</span>
                    </button>
                    Todos os Produtos
                </div>
            </div>

            <div class="modal-body produtoSearch">
                <div class="Search-and-add">
                    <form action>
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-search"></i>
                            </span>

                            <input type="text" v-model="searchQuery" class="form-control search-query" placeholder="Pesquisa o produto" />

                            <span class="input-group-addon" data-target="#right-menu" data-toggle="modal" type="button" id="addProduto">
                                <i class="fa fa-plus-circle"></i> Produto
                            </span>
                        </div>
                    </form>
                </div>

                <div class="list-produtos" v-for="prod in resultQuery" :key="prod.id" @click="addFacturacao(prod)">
                    <div class="produto-nome">
                        <h5 class="lighter">{{prod.designacao}}</h5>
                    </div>
                    <div class="produto-preco">
                        <h5 class="lighter">{{prod.preco_venda | currency}}</h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</template>

<script>
import CriarProdutoDropdown from './CriarProdutoDropdown'
import axios from 'axios'
import { baseUrl } from '../../../config/global';

export default {
    name: "ProdutoDropdown",
    components: {
        CriarProdutoDropdown
    },
    props: ['title'],
    data() {
        return {
            searchQuery: null,
            quantidade: 1,
            desconto: 0
        };
    },
    computed: {
        produtos() {
            return this.$store.getters.produtos;
        },

        resultQuery() {
            if (this.searchQuery) {

                let result = this.produtos.filter(item => {

                   return item.designacao.toLowerCase().match(this.searchQuery)
                        || item.designacao.toUpperCase().match(this.searchQuery)
                        || item.referencia.toLowerCase().match(this.searchQuery)
                        || item.referencia.toUpperCase().match(this.searchQuery)
                        || item.id==this.searchQuery // quando o valor a pesquisar é um inteiro
                });
                return result ? result : []
            } else {
                return this.produtos
            }
        }
    },
    methods: {
        addFacturacao(item) {


            const order = {
                id: item.id,
                designacao: item.designacao,
                preco: item.preco_venda,
                preco_compra: item.preco_compra,
                quant: this.quantidade,
                stocavel:item.stocavel,

                /**adiciona a quantidade em estock, caso não existir retorna 0*/
                //quant_stock_produto: item.existencia_estock ? item.existencia_estock.quantidade : 0,

                iva_produto: item.taxa,
                taxa: item.taxa,
                unidade: item.designacao_unidade_medida
            };
            
            this.$store.dispatch("addFacturacao", order);

        }
    },

    

};
</script>

<style>
.produto-dropdown-content {
    position: absolute;
    right: 0;
    background-color: #f9f9f9;
    min-width: 170px;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    padding: 10px;
    z-index: 99999;
    top: 0;
    position: fixed;
    height: 100%;
}

.modal.aside-vc.navbar-offset .modal-dialog {
    width: 370px;
}

.produtoSearch input {
    height: 45px;
    font-size: 20px;
    padding-left: 40px;
    margin-bottom: 10px;
}

.produtoSearch {
    padding: 0;
}

.list-produtos {
    display: flex;
    justify-content: space-between;
    padding-top: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #ccc;
    cursor: pointer;
    padding-left: 10px;
}

.list-produtos:hover {
    background-color: rgb(218, 205, 205);
}

.input-group {
    margin-bottom: 10px;
    margin-top: 10px;
}

.input-group-addon#addProduto {
    background: #4bae4f;
    color: #fff;
    border-radius: 0;
    margin-top: 10px;
    padding: 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.input-group-addon#addProduto:hover {
    background-color: #256327;
}
</style>
