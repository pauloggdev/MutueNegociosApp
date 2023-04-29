<template>
<section class="content">
    <div class="row">
        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Transferência de Produto
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
                        Dados Referentes a transferência de produto
                    </div>
                </div>
                <form method="POST" enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                    <div class="second-row">
                        <div class="tabbable">
                            <div class="tab-content profile-edit-tab-content">
                                <div id="dados_fornecedor" class="tab-pane in active" style="">

                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-9">
                                            <label class="control-label bold label-select2" for="select_produto">Selecione o produto<b class="red fa fa-question-circle"></b></label>
                                            <Select2 :options="produtosOptions" @select="changeProduto" v-model="produto_id" id="produto_id" style="width: 100%" placeholder="Escolha o produto por designação, codigo, codigo barra">
                                            </Select2>
                                            <span v-if="errors.produto_id" class="error">{{errors.produto_id[0]}}</span>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label bold label-select2" for="spinner3">Quantidade à transferir<b class="red fa fa-question-circle"></b></label>
                                            <div class="input-icon">
                                                <vue-numeric-input v-model="quantidade_transferida" :min="0" :step="1" id="quantidade_destino" :class="errors.quantidade_destino ? 'has-error' : ''"></vue-numeric-input>
                                                <!-- <span v-if="errors.stocavel" class="error">{{errors.stocavel[0]}}</span> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-9">
                                            <label class="control-label bold label-select2" for="select_armazem">Armazém origem<b class="red fa fa-question-circle"></b></label>
                                            <Select2 :options="armazensOptions" @select="changeArmazemOrigem" v-model="armazem_origem_id" id="armazem_origem" style="width: 100%" placeholder="Escolha o armazem">
                                            </Select2>
                                            <!-- <span v-if="errors.fornecedor_id" class="error">{{errors.fornecedor_id[0]}}</span> -->
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label bold label-select2" for="designacao">Existência</label>
                                            <div class="input-group">
                                                <input type="text" :value="quantidade_origem | formatQt" :style="quantidade_origem == 0?'border-color:red;color:red !important':''" disabled id="" class="col-md-12 col-xs-12 col-sm-4" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-9">
                                            <label class="control-label bold label-select2" for="select_armazem">Armazém destino<b class="red fa fa-question-circle"></b></label>
                                            <Select2 :options="armazensOptions" @select="changeArmazemDestino" v-model="armazem_destino_id" id="armazem_destino" style="width: 100%" placeholder="Escolha o armazem">
                                            </Select2>
                                            <!-- <span v-if="errors.fornecedor_id" class="error">{{errors.fornecedor_id[0]}}</span> -->
                                        </div>

                                        <div class="col-md-3">
                                            <label class="control-label bold label-select2" for="designacao">Existência</label>
                                            <div class="input-group">
                                                <input type="text" :value="quantidade_destino | formatQt" :style="quantidade_destino == 0?'border-color:red;color:red !important':''" disabled id="" class="col-md-12 col-xs-12 col-sm-4" />
                                                <span class="input-group-addon">
                                                    <i class="fa fa-info-circle bigger-110 text-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group has-info bold" style="left: 0%; position: relative">
                                        <div class="col-md-12">
                                            <label class="control-label bold" for="descricao">Descrição</label>
                                            <div class="input-icon">
                                                <i class="ace-icon fa fa-comment"></i>
                                                <textarea type="text" style="height:50px" v-model="transferenciaData.descricao" id="descricao" class="col-md-12 col-xs-12 col-sm-4"></textarea>
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
                                            Todas os produtos a transferir
                                        </div>

                                        <!-- div.dataTables_borderWrap -->
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Produto</th>
                                                    <th>Armazém de Origem</th>
                                                    <th>Armazém destino</th>
                                                    <th>Quantidade</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr v-for="(c, i) in transferenciaData.transferenciaProdutoItems" :key="c.id">
                                                    <td>{{ c.produto_id }}</td>
                                                    <td>{{ c.produto_designacao }}</td>
                                                    <td>{{ c.armazem_origem }}</td>
                                                    <td>{{ c.armazem_destino }}</td>
                                                    <td>{{ c.quantidade_transferida | formatQt }}</td>
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
                                    <div class="clearfix form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button class="search-btn" type="submit" style="border-radius: 10px" @click.prevent="fazerTransferencia">
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

    props: ["guard", "produtos", "existenciastock", "armazens"],
    components: {
        Select2,
        DatePick,
        VueNumericInput,
        Multiselect,
    },

    data() {
        return {

            errors: [],
            transferenciaData: {
                canal_id: this.guard.tipo_user_id == 2 ? 2 : 3,
                transferenciaProdutoItems: []
            },
            produto_id: "",
            armazem_origem_id: "",
            armazem_destino_id: "",
            armazem_destino: "",
            armazem_origem: "",
            quantidade_transferida: 0,
            quantidade_destino: "",
            quantidade_origem: "",

            produtosOptions: [],
            armazensOptions: [],
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
                    id: element.id,
                    designacao: element.designacao

                });
            });
        },
        listarArmazens() {
            this.armazens.forEach(element => {
                this.armazensOptions.push({
                    text: element.designacao,
                    id: element.id,
                    designacao: element.designacao
                });
            });
            this.armazem_origem_id = this.armazens[0].id;
            this.armazem_destino_id = this.armazens[0].id;
        },
        async fazerTransferencia() {

            try {
                this.$loading(true)

                let response = await axios.post(`${this.router}/produtos/transferencia/salvar`, this.transferenciaData, {
                    responseType: "arraybuffer"
                });

                if (response.status === 200) {
                    this.$loading(false)

                    this.$toasted.global.defaultSuccess();

                    Swal.fire({
                        title: "Sucesso",
                        text: "Transferência de produto efectuado com sucesso!",
                        icon: "success",
                        confirmButtonColor: "#3d5476",
                        confirmButtonText: "Ok",
                        onClose: () => {
                            document.location.reload(true)
                        },
                    });
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
                this.$loading(false)
                if (error.response.data.isValid == false) {
                    this.$toasted.global.defaultError({
                        msg: error.response.data.errors
                    });
                    this.$loading(false)
                    return;
                }

            }

        },
        changeProduto() {

            this.listarExistenciaStockArmazemOrigem(Number(this.produto_id), Number(this.armazem_origem_id))
            this.listarExistenciaStockArmazemDestino(Number(this.produto_id), Number(this.armazem_destino_id))
            //this.esvaziaCarrinho();
        },
        async listarExistenciaStockArmazemOrigem(produtoId, armazemId) {

            let data = this.existenciastock.find(existencia => {
                return existencia.produto_id == produtoId && existencia.armazem_id == armazemId
            });

            this.quantidade_origem = typeof data == 'undefined' ? 0 : data.quantidade;
        },
        async listarExistenciaStockArmazemDestino(produtoId, armazemId) {

            let data = this.existenciastock.find(existencia => {
                return existencia.produto_id == produtoId && existencia.armazem_id == armazemId
            });

            this.quantidade_destino = typeof data == 'undefined' ? 0 : data.quantidade;

        },
        esvaziaCarrinho() {
            this.transferenciaData.transferenciaProdutoItems = []
        },

        changeArmazemOrigem() {

            if (this.produto_id) {
                this.listarExistenciaStockArmazemOrigem(this.produto_id, this.armazem_origem_id)
                this.listarExistenciaStockArmazemDestino(this.produto_id, this.armazem_destino_id)
            }
            // this.esvaziaCarrinho();

        },
        changeArmazemDestino() {

            if (this.produto_id) {
                this.listarExistenciaStockArmazemDestino(this.produto_id, this.armazem_destino_id)
                this.listarExistenciaStockArmazemOrigem(this.produto_id, this.armazem_origem_id)
            }
            // this.esvaziaCarrinho();

        },
        addCarrinho() {

            if (!this.produto_id) {
                this.$toasted.global.defaultError({
                    msg: "Selecione o produto",
                });
                return;
            }
            if (this.quantidade_transferida <= 0) {
                this.$toasted.global.defaultError({
                    msg: "A quantidade a transferir deve ser maior que 0",
                });
                return;
            }

            if (this.armazem_origem_id == this.armazem_destino_id) {
                this.$toasted.global.defaultError({
                    msg: "Informe armazém destino diferente do armazém de origem",
                });
                return;
            }
            if (this.quantidade_origem <= 0) {
                this.$toasted.global.defaultError({
                    msg: "A quantidade do armazém origem está vazio",
                });
                return;
            }

            if (this.transferenciaData.transferenciaProdutoItems.length) {

                if (!this.verificarExisteCarrinho()) {
                    this.verificarQtExistenteComQtTransferir(this.quantidade_transferida).then(result => {
                        if (result === true) {
                            this.$toasted.global.defaultError({
                                msg: "A quantidade a transferir é maior que existente",
                            });
                            return;
                        } else {
                            this.pushCarrinho();
                        }
                    });
                } else {
                    this.$toasted.global.defaultError({
                        msg: "O item já foi adicionar",
                    });
                    return;
                }
            } else {
                this.verificarQtExistenteComQtTransferir(this.quantidade_transferida).then(result => {
                    if (result === true) {
                        this.$toasted.global.defaultError({
                            msg: "A quantidade a transferir é maior que existente",
                        });
                        return;
                    } else {
                        this.pushCarrinho();
                    }
                });
            }

        },
        async verificarQtExistenteComQtTransferir(qtTransferir) {

            try {
                let response = await axios.get(`${this.router}/produtos/existenciaStock/${this.produto_id}/${this.armazem_origem_id}`);
                if (response.status == 200) {
                    if (qtTransferir > response.data.quantidade) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } catch (error) {

            }

        },
        delItemCar(index, element) {
            this.transferenciaData.transferenciaProdutoItems.splice(index, 1);
        },
        verificarExisteCarrinho() {
            return this.transferenciaData.transferenciaProdutoItems.find(itemCarrinho => {
                if (itemCarrinho.produto_id == this.produto_id &&
                    itemCarrinho.armazem_destino_id == this.armazem_destino_id &&
                    itemCarrinho.armazem_origem_id == this.armazem_origem_id) {
                    return itemCarrinho;
                }
            });
        },
        pushCarrinho() {

            this.transferenciaData.transferenciaProdutoItems.push({
                produto_id: Number(this.produto_id),
                produto_designacao: this.buscarProduto(this.produtosOptions, this.produto_id).designacao,
                armazem_origem: this.buscarArmazem(this.armazensOptions, this.armazem_origem_id).designacao,
                armazem_destino: this.buscarArmazem(this.armazensOptions, this.armazem_destino_id).designacao,
                armazem_origem_id: Number(this.armazem_origem_id),
                armazem_destino_id: Number(this.armazem_destino_id),
                quantidade_transferida: Number(this.quantidade_transferida)
            });
        },

        buscarProduto(produtos, id) {
            return produtos.find(produto => {
                if (produto.id == id) {
                    return produto;
                }
            });
        },
        buscarArmazem(armazens, id) {
            return armazens.find(armazem => {
                if (armazem.id == id) {
                    return armazem;
                }
            });
        }
    }

}
</script>

<style>

</style>
