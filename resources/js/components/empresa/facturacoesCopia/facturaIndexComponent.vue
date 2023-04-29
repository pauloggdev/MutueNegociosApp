<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            FACTURAS
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

                            <input type="text" name="query" required autocomplete="on" class="form-control search-query" placeholder="Buscar Por produto..." />
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

                        <div class="table-header widget-header">Todas facturas do Sistema</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nome Cliente</th>
                                        <th>Telefone Cliente</th>
                                        <th>Total Factura</th>
                                        <th>Valor a Pagar</th>
                                        <th>Tipo Factura</th>
                                        <th>Data Vencimento</th>
                                        <th>Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr v-for="factura in facturas" :key="factura.id">
                                        <td>{{factura.id}}</td>
                                        <td>{{factura.nome_do_cliente}}</td>
                                        <td>{{factura.telefone_cliente}}</td>
                                        <td>{{factura.total_preco_factura | currency}}</td>
                                        <td>{{factura.valor_a_pagar | currency}}</td>
                                        <td>{{factura.tipo_documento | currency}}</td>
                                        <td>{{factura.data_vencimento | formatDate}}</td>
                                        <td class="hidden-480">
                                            <span class="label label-sm " :class="factura.status_id == 1?'label-success':'label-warning'">{{factura.status.designacao}}</span>
                                        </td>

                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a class="blue" href="#" title="Detalhes factura">
                                                    <i class="ace-icon fa fa-search-plus bigger-160"></i>
                                                </a>
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
    props: ["facturas"],

    data() {
        return {};
    },

    methods: {

        ImprimirFactura(id) {

            Swal.fire({
                title: 'Deseja Reimprimir a factura?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.value) {
                    window.open(`/empresa/facturacao/imprimir-factura/${id}`);

                }
            })
            
            /*
            Swal.fire({
                title: 'Deseja Imprimir a factura?',
                icon: 'primary',
                confirmButtonColor: '#3d5476',
                confirmButtonText: 'Ok',
                onClose: () => {
                    window.open(`/empresa/facturacao/imprimir-factura/${id}`);
                }
            });
            */
        }

    }
};
</script>

<style scoped>
</style>
