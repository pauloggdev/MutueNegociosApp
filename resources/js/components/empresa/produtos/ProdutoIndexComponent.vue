<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            PRODUTOS
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

                            <input type="text" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar Por Produtos..." />
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
                            <a href="/empresa/produtos/create" title="Adicionar novo produto" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-produto-plus"></i> Adicionar produtos
                            </a>
                            <a data-toggle="modal" href="#modalFiltrarProdutos" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a>
                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <div class="table-header widget-header">Todos produtos do Sistema</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Categoria</th>
                                        <th>Taxa</th>
                                        <th style="text-align:right">Preço Compra</th>
                                        <th style="text-align:right">Preço Venda</th>
                                        <th style="text-align:center">estocavel</th>
                                        <th style="text-align:center">estado</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="produto in queryProdutos" :key="produto.id">
                                        <td style="text-transform:uppercase">{{produto.designacao}}</td>
                                        <td style="text-transform:uppercase">{{produto.categoria.designacao}}</td>
                                        <td>{{produto.tipo_taxa.descricao}}</td>
                                        <td style="text-align:right">{{(produto.preco_compra?produto.preco_compra:0) | currency}}</td>
                                        <td style="text-align:right">{{produto.preco_venda | currency}}</td>
                                        <td class="hidden-480" style="text-align:center">
                                            <span class="label label-sm label-success" v-if="produto.stocavel =='Sim'">{{produto.stocavel}}</span>
                                            <span class="label label-sm label-warning" v-else>{{produto.stocavel}}</span>
                                        </td>
                                        <td class="hidden-480" style="text-align:center">
                                            <span class="label label-sm label-success" v-if="produto.status_id ==1 ">Activo</span>
                                            <span class="label label-sm label-warning" v-else>Desactivo</span>
                                        </td>

                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <!-- <a class="blue" href="#">
                                                    <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                                </a> -->

                                                <a :href="router+'/produto/editar/'+produto.uuid">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>

                                                <a class="red" href="" @click.prevent="deletar(produto)">
                                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                </a>
                                            </div>

                                            <div class="hidden-md hidden-lg">
                                                <div class="inline pos-rel">
                                                    <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                        <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                                    </button>

                                                    <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                        <li>
                                                            <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
                                                                <span class="blue">
                                                                    <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                                </span>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                                <span class="green">
                                                                    <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                                </span>
                                                            </a>
                                                        </li>

                                                        <li>
                                                            <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                                                <span class="red">
                                                                    <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                                </span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
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

    <!-- MODAL LISTAR produtos  -->
    <div class="modal fade" id="modalFiltrarProdutos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="width: 460px;">
                <div class="modal-header text-center" id="logomarca-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="white">&times;</span>
                    </button>
                    <h4 class="smaller">
                        <i class="fa fa-print bigger-110 text-default"></i> Imprimir por filtragem
                    </h4>
                </div>
                <div class="modal-body" style>
                    <form method="POST" class="form-horizontal validation-form" role="form">
                        <input type="hidden" name="_token" />

                        <div class="tabbable">
                            <div class="tab-content profile-edit-tab-content" style="padding:8px 33px 0px">
                                <div id="edit-basic" class="tab-pane in active">
                                    <div class="box box-primary">
                                        <div class="box-body">
                                            <div class="row">
                                                <div class="form-group has-info">

                                                    <div class="col-md-12">
                                                        <label for>Status</label>

                                                        <Select2 :options="statusOptions" v-model="filter.status_id">
                                                            <!-- <option disabled value="0">Select one</option> -->
                                                        </Select2>
                                                    </div>

                                                </div>

                                                <div class="form-group has-info">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-danger" type="reset" data-dismiss="modal">
                                    <i class="ace-icon fa fa-close bigger-110"></i>
                                    Cancelar
                                </button>
                                &nbsp; &nbsp;&nbsp; &nbsp;
                                <button class="btn btn-info" data-dismiss="modal" type="submit" @click.prevent="imprimir">
                                    <i class="fa fa-print bigger-110 text-default"></i>
                                    Imprimir
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /MODAL LISTAR produtos -->
</div>
<!-- /.row -->
</template>

<script>
import axios from "axios";
import {
    showError
} from "./../../../config/global";
import {
    mapState
} from "vuex";
import Select2 from 'v-select2-component';

import Swal from "sweetalert2";

export default {
    components: {
        Select2
    },
    props: ["produtos", "status", "guard"],

    data() {
        return {
            searchQuery: "",
            produto: {
                preco_compra: 0,
            },
            statusOptions: [{
                    id: 1,
                    text: "Activo",
                },
                {
                    id: 2,
                    text: "Desactivo",
                },
                {
                    id: 3,
                    text: "Todos",
                },
            ],
            filter: {
                status_id: 3,
            },
            USUARIO_EMPRESA: 2,
            router: ""
        };
    },

    created() {
        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`

    },
    computed: {

        window() {
      return window.Laravel;
    },

        queryProdutos() {
            if (this.searchQuery) {
                let searchQuery = this.searchQuery.toLowerCase();
                let result = this.produtos.filter(item => {
                    return item.designacao.toLowerCase().match(searchQuery)
                });
                return result ? result : []
            } else {
                return this.produtos
            }
        }
    },

    methods: {

        imprimir() {

            this.$loading(true)
            axios.get(`${this.router}/imprimir-produtos?status=` + this.filter.status_id, {
                    responseType: "arraybuffer"
                })
                .then((response) => {
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
                });

        },
        deletar(item) {
            Swal.fire({
                title: "Deseja remover o item?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ok",
            }).then((result) => {
                if (result.value) {

                    axios.get(`${this.router}/produtos/deletar/${item.id}`).then(response => {

                        if (response.status == 200) {

                            this.$toasted.global.defaultSuccess();
                            Swal.fire({
                                title: 'Sucesso',
                                text: 'Banco removido com sucesso!',
                                icon: 'success',
                                confirmButtonColor: '#3d5476',
                                confirmButtonText: 'Ok',
                                onClose: () => {
                                    document.location.reload(true)
                                }
                            });

                        }

                    }).catch(error => {
                        if (error.response.data.isValid == false) {
                            this.$toasted.global.defaultError({
                                msg: error.response.data.errors
                            });
                        } else {
                            this.$toasted.global.defaultError({
                                msg: "Não é possivel eliminar um produto existente em documentos emitido",
                            });
                        }

                    });

                }
            });
        },

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
