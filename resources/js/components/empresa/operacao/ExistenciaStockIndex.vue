<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Actualizar produto no estoque
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

                            <input type="text" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar por referência, produto e armazém..." />
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
                            <a :href="router+'/produtos/actualizar/novo'" title="emitir novo recibo" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa icofont-plus-circle"></i> Actualizar estoque
                            </a>
                            <!-- <a data-toggle="modal" href="#modalFiltrarProdutos" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a> -->
                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <div class="table-header widget-header">Todos os produtos do estoque</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Referência Produto</th>
                                        <th>Produto</th>
                                        <th>Armazém</th>
                                        <th style="text-align: center">Qtd anterior</th>
                                        <th style="text-align: center">Qtd Nova</th>
                                        <th>Data Actualização</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr v-for="existencia in queryExistencia" :key="existencia.id">
                                        <td>{{existencia.produtos.referencia}}</td>
                                        <td>{{existencia.produtos.designacao.toUpperCase()}}</td>
                                        <td>{{existencia.armazens.designacao}}</td>
                                        <td style="text-align: center">{{existencia.quantidade_antes | formatQt}}</td>
                                        <td style="text-align: center">{{existencia.quantidade_nova | formatQt}}</td>
                                        <td>{{existencia.created_at | formatDate}}</td>
                                        <td class="hidden-480" style="text-align: center">
                                            <span v-if="(existencia.status_id == 1)" class="label label-sm label-success" style="border-radius: 20px;">Activo</span>
                                            <span v-else class="label label-sm label-warning" style="border-radius: 20px;">Desactivo</span>
                                        </td>
                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a @click.prevent="printExistencia(existencia.id)" style="cursor: pointer;" class="pink" title="Editar este registo">
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

</div>
<!-- /.row -->
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";

import {
    showError
} from "./../../../config/global";
import {
    mapState
} from "vuex";
import Select2 from 'v-select2-component';

export default {
    components: {
        Select2
    },
    props: ["atualizacaostock", "guard"],
    data() {
        return {
            searchQuery: "",
            USUARIO_EMPRESA: 2,
            router: ""

        };
    },
    created() {
        
        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`

    },
    computed: {

        queryExistencia() {

            if (this.searchQuery) {

                let result = this.atualizacaostock.filter(item => {

                    let searchQuery = this.searchQuery.toLowerCase();

                    return item.produtos.designacao.toLowerCase().match(searchQuery) ||
                        item.armazens.designacao.toLowerCase().match(searchQuery) ||
                        item.produtos.referencia.toLowerCase().match(searchQuery)
                        
                });

                return result ? result : []

            } else {
                return this.atualizacaostock
            }
        },
    },

    methods: {

        async printExistencia(existenciaId) {

            this.$loading(true)

            try {
                let response = await axios.get(`${this.router}/produtos/imprimirActualizacaoStock/${existenciaId}`,{
                    responseType: "arraybuffer"
                });
                if (response.status === 200) {
                    this.$loading(false)
                    var file = new Blob([response.data], {
                        type: "application/pdf",
                    });
                    var fileURL = URL.createObjectURL(file);
                    window.open(fileURL);
                    document.location.reload(true)
                } else {
                    this.$loading(false)
                    console.log("Erro ao carregar pdf");
                }
            } catch (error) {
                console.log("ERRO API");
            }

        }

    }
};
</script>

<style scoped>
#filter {
    margin-bottom: 15px;
}

.box-content {
    background: rgb(236, 241, 247);
    ;
    padding: 20px;
    height: 100%;
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
