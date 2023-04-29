<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Produtos / Serviços vendidos
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

                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <div class="table-header widget-header">Todos os produtos / servicos vendidos</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Designação</th>
                                        <th>Preço Compra</th>
                                        <th>Preço Venda</th>
                                        <th>estocavel</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>

                                <tbody v-if="produtos.length">

                                    <tr v-for="produto in queryProdutos" :key="produto.id">
                                        <td style="text-align:center">{{produto.id}}</td>
                                        <td>{{produto.designacao}}</td>
                                        <td>{{produto.preco_compra | currency}}</td>
                                        <td>{{produto.preco_venda | currency}}</td>
                                        <td class="hidden-480">
                                            <span class="label label-sm" :class="[produto.stocavel === 'Sim'?'label-warning':'label-primary']">{{produto.stocavel}}</span>
                                        </td>

                                        <td>
                                            <div class=" hidden-sm hidden-xs action-buttons">
                                                <a class="blue" style="cursor: pointer;" @click.prevent="mostrarRelatorioProd(produto)">
                                                    <i class="fa fa-print bigger-150 text-default"></i>
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
                                                            <a class="tooltip-error" data-rel="tooltip" title="Delete">
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

</div>
<!-- /.row -->
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
import Select2 from 'v-select2-component';

export default {
    components: {
        Select2
    },
    props: ["produtos", "status"],
    data() {
        return {
            searchQuery: "",
            produto: {},
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
        };
    },

    computed: {

        queryProdutos() {

            if (this.searchQuery) {

                let result = this.produtos.filter(item => {
                    return item.designacao.toLowerCase().match(this.searchQuery) ||
                        item.designacao.toUpperCase().match(this.searchQuery) ||
                        item.referencia.toLowerCase().match(this.searchQuery) ||
                        item.referencia.toUpperCase().match(this.searchQuery) ||
                        item.codigo_barra.toLowerCase().match(this.searchQuery) ||
                        item.id == this.searchQuery // quando o valor a pesquisar é um inteiro
                        ||
                        item.created_at.toLowerCase().match(this.searchQuery)
                });

                return result ? result : []

            } else {
                return this.produtos
            }

        }

    },

    methods: {

        async mostrarRelatorioProd(produto) {

            this.$loading(true)

            try {
                let response = await axios.get(`${baseUrl}/empresa/vendas-produto/${produto.id}`, {
                    responseType: "arraybuffer",
                });

                if (response.status === 200) {

                    this.$loading(false)
                    var file = new Blob([response.data], {
                        type: "application/pdf",
                    });
                    var fileURL = URL.createObjectURL(file);
                    window.open(fileURL);
                }
            } catch (error) {
                this.$loading(false)
                console.log("Erro ao carregar pdf");
            }

            // console.log(produto)

        },

        imprimir() {

            this.$loading(true)

            axios
                .get(
                    `${baseUrl}/empresa/imprimir-produtos?status=` + this.filter.status_id, {
                        responseType: "arraybuffer",
                    }
                )
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
                    //window.open("/empresa/imprimir/bancos?status=" + this.filter.status_id); //This will open Google in a new window.
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
