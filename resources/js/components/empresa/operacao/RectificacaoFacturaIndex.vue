<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Documentos Rectificados
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Listagem
            </small>
        </h1>
    </div>
    <!-- /.page-header -->

    <div class="col-xs-12">
        <div>
            <form class="form-search" method="get">
                <div class="row">
                    <div>
                        <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-search"></i>
                            </span>

                            <input type="text" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar por nome, nif do cliente e numeração NC..." />
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
                <form id="adimitirCandidatos" method="POST">
                    <div class="col-xs-12 widget-box widget-color-green" style="left: 0%;">
                        <div class="clearfix">
                            <a href="/empresa/facturas/rectificacao/novo" title="Adicionar novo formapagamento" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa icofont-plus-circle"></i> Rectificar documento
                            </a>
                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <div class="table-header widget-header">Todos documentos Rectificadas</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Numeração</th>
                                        <th>Referente Factura</th>
                                        <th>Nome</th>
                                        <th>Telefone</th>
                                        <th>Total Factura</th>
                                        <th>Valor a Pagar</th>
                                        <th>Tipo Documento</th>
                                        <th>Emitido</th>
                                        <!-- <th>Vencimento</th> -->
                                        <th>Pago</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="notaCredito in queryFacturas" :key="notaCredito.id">
                                        <td>{{notaCredito.id}}</td>
                                        <td>{{notaCredito.numeracaoDocumento}}</td>
                                        <td>{{notaCredito.factura.numeracaoFactura}}</td>
                                        <td>{{notaCredito.nome_do_cliente}}</td>
                                        <td>{{notaCredito.telefone_cliente}}</td>
                                        <td style="text-align:right">{{notaCredito.total_preco_factura | currency}}</td>
                                        <td style="text-align:right">{{notaCredito.valor_a_pagar | currency}}</td>
                                        <td>{{notaCredito.tipo_documento.designacao}}</td>
                                        <td>{{notaCredito.created_at | formatDate}}</td>
                                        <!-- <td>{{notaCredito.data_vencimento | formatDate}}</td> -->
                                        <!-- <td class="hidden-480">
                                            <span class="label label-sm " :class="factura.status_id == 1?'label-success':'label-warning'">{{factura.status.designacao}}</span>
                                        </td> -->

                                        <td class="hidden-480">
                                            <span class="label label-sm " :class="notaCredito.statusFactura == 1?'label-danger':'label-success'">{{notaCredito.statusFactura == 1?"Não":"Sim"}}</span>
                                        </td>

                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a class="blue" href="#" title="Detalhes factura">
                                                    <i class="ace-icon fa fa-search-plus bigger-160"></i>
                                                </a>
                                                <a class="blue" @click.prevent="ImprimirFactura(notaCredito.id, notaCredito.facturaId)" title="Reimprimir factura" style="cursor:pointer;">
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
    <!-- /.col -->

</div>
<!-- /.row -->
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";
import Swal from "sweetalert2";
import {
    showError,
    baseUrl
} from "./../../../config/global";
import {
    mapState
} from "vuex";

export default {
    props: ["facturas", "guard", "status"],
    components: {
        Select2,
    },

    data() {
        return {
            searchQuery: "",
            /**
             * constantes usados
             */
            USUARIO_EMPRESA: 2,
            USUARIO_FUNCIONARIO: 3,
            router: "",

        };

    },

    created() {

        console.log(this.facturas);
        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`

    },

    methods: {

        async ImprimirFactura(docRetificadoId, idFactura) {

            this.$loading(true)


            let response = await axios.get(`${this.router}/imprimirDocumentoRetificado/${docRetificadoId}/${idFactura}?viaImpressao=2`, {
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
        }

    },
    computed: {

        queryFacturas() {
            if (this.searchQuery) {
                let searchQuery = this.searchQuery.toLowerCase();
                let result = this.facturas.filter(item => {
                    return item.nome_do_cliente.toLowerCase().match(searchQuery) ||
                        item.nif_cliente.toLowerCase().match(searchQuery) ||
                        item.telefone_cliente.toLowerCase().match(searchQuery) ||
                        item.numeracaoDocumento.toLowerCase().match(searchQuery)

                });
                return result ? result : []
            } else {
                return this.facturas
            }
        }
    },

};
</script>

<style scoped>
.has-error {
    border-color: #f2a696 !important;
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
