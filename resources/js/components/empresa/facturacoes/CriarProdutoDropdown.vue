<template>
<div id="right-menu" class="modal aside" data-body-scroll="false" data-offset="true" data-placement="right" data-fixed="true" data-backdrop="false" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header no-padding">
                <div class="table-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <span class="white">&times;</span>
                    </button>
                    Cadastrar Produtos
                </div>
            </div>

            <div class="modal-body">
                <form method="POST" enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                    <div>
                        <div class="second-row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label" for="nome">
                                        Nome Produto
                                        <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                    </label>
                                    <div class="input-icon">
                                        <input type="text" v-model="produto.nome" id="preco" class="col-md-12 col-xs-12 col-sm-4" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label class="control-label" for="preco">
                                        Preço
                                        <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                    </label>
                                    <div class="input-icon">
                                        <input type="text" v-model="produto.preco" id="preco" class="col-md-12 col-xs-12 col-sm-4" />
                                        <i class="ace-icon fa fa-money"></i>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="categoria">
                                        Categória
                                        <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                    </label>
                                    <div class="input-icon">
                                        <select class="col-md-12 col-xs-12 col-sm-4 select2" id="categoria" v-model="produto.categoria_id" data-placeholder="Selecione a categória">
                                            <option value></option>
                                            <option value="1">BFA</option>
                                            <option value="2">SOL</option>
                                            <option value="3">BPC</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <label class="control-label" for="fabricante">
                                        Fabricante
                                        <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                    </label>
                                    <div class="input-icon">
                                        <select class="col-md-12 col-xs-12 col-sm-4 select2" id="fabricante" v-model="produto.fabricante_id" data-placeholder="Selecione o fabricante">
                                            <option value></option>
                                            <option value="1">BFA</option>
                                            <option value="2">SOL</option>
                                            <option value="3">BPC</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label class="control-label" for="unid_medida">
                                        Unid. Medida
                                        <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                    </label>
                                    <div class="input-icon">
                                        <select class="col-md-12 col-xs-12 col-sm-4 select2" id="unid_medida" v-model="produto.unid_medida" data-placeholder="Selecione a unidade">
                                            <option value></option>
                                            <option value="1">BFA</option>
                                            <option value="2">SOL</option>
                                            <option value="3">BPC</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="statu_id">
                                        Status
                                        <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                    </label>
                                    <div class="input-icon">
                                        <select class="col-md-12 col-xs-12 col-sm-4 select2" id="statu_id" v-model="produto.statu_id" data-placeholder="Selecione a Status">
                                            <option value></option>
                                            <option value="1">BFA</option>
                                            <option value="2">SOL</option>
                                            <option value="3">BPC</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label class="control-label" for="quant_min">
                                        Qtd. Miníma
                                        <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                    </label>
                                    <div class="input-icon">
                                        <input type="text" v-model="produto.quant_min" id="quant_min" class="col-md-12 col-xs-12 col-sm-4" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="quant_critica">
                                        Qtd. Crítica
                                        <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                    </label>
                                    <div class="input-icon">
                                        <input type="text" v-model="produto.quant_critica" id="quant_critica" class="col-md-12 col-xs-12 col-sm-4" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label class="control-label" for="cod_barra">
                                        Cod. Barra
                                        <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                    </label>
                                    <div class="input-icon">
                                        <input type="text" v-model="produto.cod_barra" id="cod_barra" class="col-md-12 col-xs-12 col-sm-4" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="data_expiracao">
                                        Data Expiração
                                        <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                    </label>
                                    <div class="input-icon">
                                        <input type="text" v-model="produto.data_expiracao" id="data_expiracao" class="col-md-12 col-xs-12 col-sm-4" />
                                        <i class="ace-icon fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label class="control-label" for="cod_taxa">
                                        Código de taxa
                                        <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                    </label>
                                    <div class="input-icon">
                                        <input type="text" v-model="produto.cod_taxa" id="cod_taxa" class="col-md-12 col-xs-12 col-sm-4" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label" for="estocavel">
                                        Estócavel
                                        <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                    </label>
                                    <div class="input-icon">
                                        <input type="text" v-model="produto.estocavel" id="estocavel" class="col-md-12 col-xs-12 col-sm-4" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <label class="control-label" for="obs">
                                        Descrição
                                        <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                    </label>
                                    <div class="input-icon" id="description">
                                        <textarea name id cols="30" rows="10" v-model="produto.descricao"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="hr hr-18 dotted"></div>

                            <div class="clearfix form-actions align-right">
                                <div class="col-md-12">
                                    <button class="btn-add-produto" @click.prevent="cadastrar">
                                        <i class="fa fa-plus-circle"></i> Cadastrar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="space"></div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</template>

<script>
import axios from 'axios'
import { baseUrl } from './../../../config/global'
export default {
    data() {
        return {
            produto: {}
        };
    },
    methods: {
        cadastrar() {
            console.log(this.produto);
        },
        listarCategorias(){
            axios.get(`${baseUrl}/empresa/categorias`).then(res=>{
                console.log(res)
            }).catch(error=>{
                console.log(error)
            })
        }
    },
    created(){
        this.listarCategorias()
    }
};
</script>

<style scoped>
.modal.aside-vc.navbar-offset .modal-dialog {
    width: 500px;
}

#description textarea {
    width: 409px;
    height: 70px;
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
</style>
