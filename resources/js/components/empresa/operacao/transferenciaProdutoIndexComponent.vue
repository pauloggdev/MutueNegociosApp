<template>
<div class="row">

    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Produtos transferidos
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

                            <input type="text" required autocomplete="on" v-model="searchQuery" class="form-control search-query" placeholder="Buscar Por numeração..." />
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
                            <a :href="router+'/produtos/transferencia/novo'" title="Adicionar novo entrada produto em estoque" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-plus"></i> Nova transferência
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
                                        <th class="center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </th>
                                        <th>Código</th>
                                        <th>Numeração</th>
                                        <th>Data da Transferência</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="transferencia in queryTransferencias" :key="transferencia.id">

                                        <td class="center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </td>

                                        <td>{{transferencia.id}}</td>
                                        <td>{{transferencia.numeracao_transferencia}}</td>
                                        <td>{{ transferencia.created_at | formatDate }}</td>
                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#ver_detalhes" data-toggle="modal" @click.prevent="mostrarModalDetalhes(transferencia)" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                </a>

                                                <a title="Imprimir extrato" style="cursor:pointer;" @click.prevent="imprimirTransferencia(transferencia)">
                                                    <i class="fa fa-print bigger-150 text-primary"></i>
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

    <!-- VER DETALHES  -->
    <div id="ver_detalhes" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Ver mais detalhes da transferência
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">

                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Detalhes da transferência
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
                                                Dados da transferência de produto
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content profile-edit-tab-content">
                                        <div id="dados_user" class="tab-pane in active">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Código</th>
                                                        <th scope="col">Produto</th>
                                                        <th scope="col">Armazém origem</th>
                                                        <th scope="col">Armazém destino</th>
                                                        <th scope="col">Qtd Transferido</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="transfItem in transferenciaItems" :key="transfItem.id">
                                                        <td>{{transfItem.produto_id}}</td>
                                                        <td>{{transfItem.produto_designacao}}</td>
                                                        <td>{{transfItem.armazem_origem}}</td>
                                                        <td>{{transfItem.armazem_destino}}</td>
                                                        <td>{{transfItem.quantidade_transferida | formatQt}}</td>
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

    props: ["guard", "transferencia"],

    data() {
        return {
            searchQuery: "",
            transferenciaItems: [],
            router: this.guard.tipo_user_id == 2 ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`

        }
    },
    created() {

        console.log(this.guard);

    },
    methods: {
        mostrarModalDetalhes(transferencia) {

            this.transferenciaItems = [];
            this.transferencia.forEach(transf => {
                if (transferencia.id == transf.id) {
                    transf.transferencia_produto_items.forEach(transfItem => {
                        this.transferenciaItems.push(transfItem);

                    });

                }
            });

        },
        async imprimirTransferencia(transferencia) {

            try {
                this.$loading(true)

                let response = await axios.get(`${this.router}/produtos/transferencia/imprimir/${transferencia.id}`, {
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

        }
    },
    computed: {
        queryTransferencias() {
            if (this.searchQuery) {
                let result = this.transferencia.reverse().filter((item) => {

                    let searchQuery = this.searchQuery.toLowerCase();
                    return item.numeracao_transferencia.toLowerCase().match(searchQuery)
                });

                return result ? result : [];
            } else {
                return this.transferencia.reverse();
            }
        },
    },

}
</script>

<style>

</style>
