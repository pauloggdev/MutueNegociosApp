<template>
<div class="row">

    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Entrada Produto Estoque
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Listagem
            </small>
        </h1>
    </div><!-- /.page-header -->

    <div class="col-xs-12">

        <div class>
            <form class="form-search" method="get" action>
                <div class="row">
                    <div class>
                        <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-search"></i>
                            </span>

                            <input type="text" required autocomplete="on" v-model="searchQuery" class="form-control search-query" placeholder="Buscar Por numeração da factura..." />
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
                            <a :href="router+'/produtos/entrada/novo'" title="Adicionar novo entrada produto em estoque" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-plus"></i> Nova entrada
                            </a>
                            <!-- <a href="/empresa/imprimir-clientes" title="Imprimir cliente" target="new" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print"></i> Clientes
                            </a> -->
                            <!-- <a data-toggle="modal" href="#modalFiltrarClientes" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a> -->

                            <div class="dt-buttons btn-overlap btn-group pull-right">
                                <a class="dt-button buttons-collection buttons-colvis btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table">
                                    <span>
                                        <i class="fa fa-search bigger-110 text-primary"></i>
                                        <span class="hidden">Mostrar/Ocultar Colunas</span>
                                    </span>
                                </a>
                                <a class="dt-button buttons-copy buttons-html5 btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table">
                                    <span>
                                        <i class="fa fa-copy bigger-110 text-pink"></i>
                                        <span class="hidden">Copiar para uma tabela</span>
                                    </span>
                                </a>
                                <a class="dt-button buttons-csv buttons-html5 btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table">
                                    <span>
                                        <i class="fa fa-database bigger-110 text-orange" style="color: orange"></i>
                                        <span class="hidden">Exportar para CSV</span>
                                    </span>
                                </a>
                                <a class="dt-button buttons-print btn btn-white btn-primary btn-bold" tabindex="0" aria-controls="dynamic-table" href="#modalFiltrarClientes" data-toggle="modal">
                                    <span><i class="fa fa-print bigger-110 text-default"></i>
                                        <span class="hidden">Imprimir toda Tabela</span>
                                    </span>
                                </a>
                            </div>
                            <!-- <div class="pull-right tableTools-container"></div> -->
                        </div>

                        <div class="table-header widget-header">Todas entradas de produtos no estoque no Sistema</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nome do fornecedor</th>
                                        <th>Nº Factura</th>
                                        <th style="text-align:right">Preço de Compra</th>
                                        <th>Forma Pagamento</th>
                                        <th>Data entrada</th>
                                        <th>Armazéns</th>
                                        <th style="text-align:center">Status Pgt</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="entradastock in queryEntradaStock" :key="entradastock.id">
                                        <td>{{entradastock.id}}</td>
                                        <td>{{entradastock.fornecedor.nome}}</td>
                                        <td>{{entradastock.num_factura_fornecedor}}</td>
                                        <td style="text-align:right">{{entradastock.total_compras | currency}}</td>
                                        <td>{{entradastock.forma_pagamento.descricao}}</td>
                                        <td>{{entradastock.created_at | formatDate}}</td>
                                        <td>{{entradastock.armazem.designacao}}</td>
                                        <td class="hidden-480" style="text-align:center">
                                            <span class="label label-sm " :class="entradastock.statusPagamento == 1?'label-success':'label-danger'">{{entradastock.statusPagamento == 1?"Sim":"Não"}}</span>
                                        </td>
                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#ver_detalhes" data-toggle="modal" @click.prevent="mostrarModalDetalhes(entradastock)" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                </a>
                                                <a class="blue" @click.prevent="ImprimirEntrada(entradastock.id)" title="Reimprimir entrada produto" style="cursor:pointer;">
                                                    <i class="ace-icon fa fa-print bigger-160"></i>
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

    <!-- VER DETALHES  -->
    <div id="ver_detalhes" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Ver mais detalhes da entrada de produto
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">

                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Detalhes da entrada
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">
                        <div class="col-md-12">

                            <div class="second-row">

                                <div class="tabbable">
                                    <ul class="nav nav-tabs padding-16">
                                        <li class="active">
                                            <a data-toggle="tab" href="#dados_user">
                                                <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                                                Dados da entrada de produto
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content profile-edit-tab-content">
                                        <div id="dados_user" class="tab-pane in active">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Produto</th>
                                                        <th scope="col" style="text-align:right">Preço de compra</th>
                                                        <th scope="col" style="text-align:center">Qtd</th>
                                                        <th scope="col" style="text-align:right">Preço de venda</th>
                                                        <th scope="col" style="text-align:right">Lucro</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="entradaItem in entradaDetalhes" :key="entradaItem.id">
                                                        <td>{{entradaItem.produto.designacao}}</td>
                                                        <td style="text-align:right">{{entradaItem.preco_compra|currency}}</td>
                                                        <td style="text-align:center">{{entradaItem.quantidade|formatQt}}</td>
                                                        <td style="text-align:right">{{entradaItem.preco_venda|currency}}</td>
                                                        <td style="text-align:right">{{entradaItem.lucroUnitario|currency}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>
</template>

<script>
export default {

    props: ['guard', 'entradastock'],

    data() {
        return {
            searchQuery: "",
            USUARIO_EMPRESA: 2,
            router: "",
            entradaDetalhes: {}
        }
    },
    created() {
        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`
    },
    computed: {

        queryEntradaStock() {
            if (this.searchQuery) {
                let searchQuery = this.searchQuery.toLowerCase();
                let result = this.entradastock.filter(item => {
                    return item.num_factura_fornecedor.toLowerCase().match(searchQuery)
                });
                return result ? result : []
            } else {
                return this.entradastock
            }
        }
    },
    methods: {

        async ImprimirEntrada(entradaProdutoId) {

            try {
                this.$loading(true)

                let response = await axios.get(`${this.router}/imprimirEntradaStock/${entradaProdutoId}`, {
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
                this.$loading(false)
                console.log("Erro ao carregar pdf");

            }

        },
        mostrarModalDetalhes(entradaProduto) {

            this.entradaDetalhes = [...entradaProduto.entrada_stock_items];

            console.log(this.entradaDetalhes);
            return;

        }
    }

}
</script>

<style>

</style>
