<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Facturas de Licenças
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

                            <input type="text" name="query" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar por numeração da factura" />
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

                        <div class="table-header widget-header">Todas facturas de licenças do Sistema</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Descrição Licença</th>
                                        <th style="text-align:right">Total Factura</th>
                                        <th style="text-align:right">Valor a Pagar</th>
                                        <th>Tipo Documento</th>
                                        <th>Numeração</th>
                                        <th>Emitido</th>
                                        <th>Pago</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="factura in queryFacturas" :key="factura.id">
                                        <td>{{factura.id}}</td>
                                        <td>{{factura.descricao}}</td>
                                        <td style="text-align:right">{{factura.total_preco_factura | currency}}</td>
                                        <td style="text-align:right">{{factura.valor_a_pagar | currency}}</td>
                                        <td>{{factura.tipo_documento}}</td>
                                        <td>{{factura.numeracaoFactura}}</td>
                                        <td>{{factura.created_at | formatDate}}</td>
                                        <td class="hidden-480">
                                            <span class="label label-sm " :class="factura.statusFactura == 1?'label-danger':'label-success'">{{factura.statusFactura == 1?"Não":"Sim"}}</span>
                                        </td>

                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a class="blue" @click.prevent="ImprimirFactura(factura.id)" title="Reimprimir factura" style="cursor:pointer;">
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

</div>
<!-- /.row -->
</template>

<script>
import Swal from 'sweetalert2';

export default {
    props: ["facturas", "guard"],

    data() {
        return {

            searchQuery: "",
            /**
             * constantes usados
             */
            USUARIO_EMPRESA: 2,
            USUARIO_FUNCIONARIO: 3,
            router: ""
        };
    },
    created() {
        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`
    },

    methods: {

        async ImprimirFactura(id) {


            const FOLHA_A4 = 1;
            this.$loading(true)

            let response = await axios.get(`${this.router}/planos-assinaturas/imprimir-factura/${id}?viaImpressao=2`, {
                responseType: "arraybuffer"
            });

            if (response.status == 200) {
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
        }
    },
    computed: {

        queryFacturas() {
            if (this.searchQuery) {
                let searchQuery = this.searchQuery.toLowerCase();
                let result = this.facturas.filter(item => {
                    return item.numeracaoFactura.toLowerCase().match(searchQuery)

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
</style>
