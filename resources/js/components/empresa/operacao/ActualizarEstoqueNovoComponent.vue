<template>
<section class="content">
    <div class="row">
        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Actualizar Produto Estoque
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
                        Dados Referentes actualização de produto no estoque
                    </div>
                </div>
                <form method="POST" enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                    <div class="second-row">
                        <div class="tabbable">
                            <div class="tab-content profile-edit-tab-content">
                                <div id="dados_fornecedor" class="tab-pane in active" style="">

                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-6">
                                            <label class="control-label bold label-select2" for="select_produto">Selecione o produto<b class="red fa fa-question-circle"></b></label>
                                            <Select2 :options="produtosOptions" @select="changeProduto" v-model="actualizaStockData.produto_id" id="produto_id" style="width: 100%" placeholder="Escolha o produto por designação, codigo, codigo barra">
                                            </Select2>
                                            <span v-if="errors.produto_id" class="error">{{errors.produto_id[0]}}</span>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label bold label-select2" for="select_armazem">Selecione o armazem<b class="red fa fa-question-circle"></b></label>
                                            <Select2 :options="armazensOptions" @select="changeArmazem" v-model="actualizaStockData.armazem_id" id="armazem_id" style="width: 100%" placeholder="Escolha o armazem">
                                            </Select2>
                                            <!-- <span v-if="errors.fornecedor_id" class="error">{{errors.fornecedor_id[0]}}</span> -->
                                        </div>
                                    </div>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-4">
                                            <label class="control-label bold label-select2" for="designacao">Código barra</label>
                                            <div class="input-group">
                                                <input type="text" v-model="actualizaStockData.codigo_barra" disabled id="" class="col-md-12 col-xs-12 col-sm-4" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="control-label bold label-select2" for="designacao">Referência produto</label>
                                            <div class="input-group">
                                                <input type="text" v-model="actualizaStockData.referencia" disabled id="" class="col-md-12 col-xs-12 col-sm-4" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label bold label-select2" for="spinner3">Existência Actual</label>
                                            <div class="input-icon">
                                                <vue-numeric-input v-model="actualizaStockData.quantidade_antes" :min="0" :step="1" id="quantidade" disabled :class="errors.quantidade_antes ? 'has-error' : ''"></vue-numeric-input>
                                                <!-- <span v-if="errors.stocavel" class="error">{{errors.stocavel[0]}}</span> -->
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label bold label-select2" for="spinner3">Existência nova</label>
                                            <div class="input-icon">
                                                <vue-numeric-input v-model="actualizaStockData.quantidade_nova" :min="0" :step="1" :class="errors.quantidade_nova ? 'has-error' : ''"></vue-numeric-input>
                                                <span v-if="errors.quantidade_nova" class="error">{{errors.quantidade_nova[0]}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-12">
                                            <label class="control-label bold" for="descricao">Descrição</label>
                                            <div class="input-icon">
                                                <i class="ace-icon fa fa-comment"></i>
                                                <textarea type="text" v-model="actualizaStockData.descricao" id="descricao" class="col-md-12 col-xs-12 col-sm-4"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group has-info bold">
                                    <div class="col-md-4">
                                        <button class="search-btn" type="submit" style="border-radius: 10px" @click.prevent="diminuirEstoque">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            Diminuir
                                        </button>

                                    </div>

                                    <div class="col-md-4">
                                        <button class="search-btn" type="submit" style="border-radius: 10px" @click.prevent="adicionarEstoque">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            Adicionar
                                        </button>
                                    </div>
                                    <div class="col-md-4">
                                        <button class="search-btn" type="submit" style="border-radius: 10px" @click.prevent="actualizarEstoque">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            Actualizar
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
    props: ["guard", "produtos", "armazens"],

    components: {
        Select2,
        DatePick,
        VueNumericInput,
        Multiselect,
    },
    data() {
        return {
            errors: [],
            produtosOptions: [],
            armazensOptions: [],
            descricao: "",
            actualizaStockData: {
                quantidade_nova: 0
            },
            router: this.guard.tipo_user_id == 2 ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`

        }
    },

    created() {
        this.listarProdutos();
        this.listarArmazens();
    },
    methods: {

        listarProdutos() {
            this.produtos.forEach(element => {

                this.produtosOptions.push({
                    text: element.designacao,
                    id: element.id
                });
            });
        },
        listarArmazens() {
            this.armazens.forEach(element => {
                this.armazensOptions.push({
                    text: element.designacao,
                    id: element.id
                });
            });
            this.actualizaStockData.armazem_id = this.armazens[0].id;
        },
        changeProduto(produto) {
            this.listarExistenciaStockPorIdArmazem(produto.id, this.actualizaStockData.armazem_id)
        },
        changeArmazem(armazem) {
            if (this.actualizaStockData.produto_id) {
                this.listarExistenciaStockPorIdArmazem(this.actualizaStockData.produto_id, armazem.id)
            }
        },

        async listarExistenciaStockPorIdArmazem(produtoId, armazemId) {

            const PORTAL_CLIENTE = 2;
            const STATUS_ATIVO = 1;

            try {
                let response = await axios.get(`${this.router}/produtos/existenciaStock/${produtoId}/${armazemId}`);
                if (response.status == 200) {

                    this.actualizaStockData = {
                        produto_id: response.data.produtos.id,
                        codigo_barra: response.data.produtos.codigo_barra,
                        referencia: response.data.produtos.referencia,
                        quantidade_antes: response.data.quantidade,
                        canal_id: PORTAL_CLIENTE,
                        status_id: STATUS_ATIVO,
                        armazem_id: Number(armazemId),
                        descricao: this.actualizaStockData.descricao,
                        quantidade_nova: this.actualizaStockData.quantidade_nova,
                    }
                }
            } catch (error) {

            }

        },
        adicionarEstoque() {

            const OPERACAO_ADICIONAR = 2;

            this.requestStock(OPERACAO_ADICIONAR);

        },
        diminuirEstoque() {

            const OPERACAO_DIMINUIR = 1;

            this.requestStock(OPERACAO_DIMINUIR);

        },
        actualizarEstoque() {

            const OPERACAO_ATUALIZAR = 3;
            this.requestStock(OPERACAO_ATUALIZAR);

        },

        async requestStock(operacao) {

            this.$loading(true)

            try {
                let response = await axios.post(`${this.router}/produtos/actualizarStock?operacao=${operacao}`, this.actualizaStockData);

                if (response.status == 200) {

                    this.$toasted.global.defaultSuccess();
                    Swal.fire({
                        title: "Sucesso",
                        text: "Estoque actualizado com sucesso!",
                        icon: "success",
                        confirmButtonColor: "#3d5476",
                        confirmButtonText: "Ok"
                    });

                    this.printExistencia(response.data.id);
                                       document.location.reload(true)


                }

            } catch (error) {
                this.$loading(false)

                this.$toasted.global.defaultError({
                    msg: "Erro ao cadastrar",
                });
                this.errors = error.response.data.errors;
            }

        },
        async printExistencia(existenciaId) {

            this.$loading(true)

            try {
                let response = await axios.get(`${this.router}/produtos/imprimir/existenciaStock/${existenciaId}`, {
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
            } catch (error) {
                console.log("ERRO API");
            }

        }

    },

    mounted() {

    },

};
</script>

<style>
#descricao {
    padding-left: 25px;
}

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
