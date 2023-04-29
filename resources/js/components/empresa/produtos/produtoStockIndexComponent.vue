<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            EXISTÊNCIA ESTOQUE
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

                            <input type="text" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar por nome de produto e armazém..." />
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

                            <a data-toggle="modal" href="#modalFiltrarProdutos" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a>
                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <div class="table-header widget-header">Todos estoques do Sistema</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>

                                    <tr>
                                        <th>Referência</th>
                                        <th>Nome</th>
                                        <th>Armazem</th>
                                        <th style="text-align:center">Qtd</th>
                                        <th style="text-align:right">Preço Compra</th>
                                        <th style="text-align:right">Preço Venda</th>
                                        <th style="text-align:center">Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr v-for="data in queryExistencia" :key="data.id">
                                        <td>{{data.produtos.referencia}}</td>
                                        <td>{{data.produtos.designacao.toUpperCase()}}</td>
                                        <td>{{data.armazens.designacao.toUpperCase()}}</td>
                                        <td style="text-align:center">{{data.quantidade | formatQt}}</td>
                                        <td style="text-align:right">{{(data.produtos.preco_compra?data.produtos.preco_compra:0) | currency}}</td>
                                        <td style="text-align:right">{{data.produtos.preco_venda | currency}}</td>

                                        <td class="hidden-480" style="text-align:center">
                                            <span class="label label-sm " :class="data.status_id === 1?'label-success':'label-warning'">{{data.status.designacao}}</span>
                                        </td>
                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a @click.prevent="printExistencia(data.id)" style="cursor: pointer;" class="pink" title="Editar este registo">
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
                                                        <label for>Selecione o armazém</label>
                                                        <Select2 :options="optionArmazens" v-model="existencia.armazem_id">
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
import Select2 from "v-select2-component";
export default {
    components: {
        Select2,
    },
    props: ["produtostock", "guard", "armazens"],

    data() {
        return {
            searchQuery: null,
            preco_compra: 0,
            optionArmazens: [],
            existencia: {
                armazem_id: ""
            },
            USUARIO_EMPRESA: 2,
            router: ""

        };
    },
    created() {

        this.listarArmazens();

        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`
    },
    computed: {
        queryExistencia() {
            if (this.searchQuery) {
                let result = this.produtostock.filter((item) => {

                    return item.armazens.designacao.toLowerCase().match(this.searchQuery.toLowerCase()) ||
                        item.produtos.designacao.toLowerCase().match(this.searchQuery.toLowerCase())
                });

                return result ? result : [];
            } else {
                return this.produtostock;
            }
        },
    },

    methods: {
        listarArmazens() {
            this.armazens.forEach(armazem => {
                this.optionArmazens.push({
                    id: armazem.id,
                    text: armazem.designacao
                })
                this.existencia.armazem_id = this.optionArmazens[0].id;
            });
        },
        imprimir() {

            this.$loading(true)
            axios
                .get(
                    `${this.router}/produtos/imprimir/existenciaStock?armazem=${this.existencia.armazem_id}`, {
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
                });
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
</style>
