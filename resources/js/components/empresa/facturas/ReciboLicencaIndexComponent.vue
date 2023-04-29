<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Recibos Pagamento de Licenças
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

                        <div class="table-header widget-header">Todas Recibos de pagamento de licenças do Sistema</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Factura Referente</th>
                                        <th style="text-align:right">Valor Entregue</th>
                                        <th>Data Pagamento</th>
                                        <th>Forma Pagamento</th>
                                        <th>Coordenada Bancaria</th>
                                        <th>Operação Bancaria</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <tr v-for="recibo in queryRecibos" :key="recibo.id">
                                        <td>{{recibo.id}}</td>
                                        <td>{{recibo.nFactura}}</td>
                                        <td style="text-align:right">{{recibo.valor_depositado | currency}}</td>
                                        <td>{{recibo.created_at | formatDate}}</td>
                                        <td>{{recibo.forma_pagamento.descricao}}</td>
                                        <td>{{recibo.coordernada_bancaria.iban}}</td>
                                        <td>{{recibo.numero_operacao_bancaria}}</td>
                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">

                                                <a class="blue" @click.prevent="ImprimirRecibo(recibo.id)" title="imprimir comprovativo" style="cursor:pointer;">
                                                    <i class="ace-icon fa fa-print bigger-160"></i>
                                                </a>
                                                <a :href="'/upload/'+recibo.comprovativo_bancario" target="_blank" id="comprovativoBancario">
                                                    <i class="ace-icon fa fa-link bigger-160"></i>
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
    props: ["recibos", "guard"],

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

        async ImprimirRecibo(id) {

            this.$loading(true)

            let response = await axios.get(`${this.router}/recibosFacturasLicenca/${id}?viaImpressao=1`, {
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

        queryRecibos() {
            if (this.searchQuery) {
                let searchQuery = this.searchQuery.toLowerCase();
                let result = this.recibos.filter(item => {
                    return item.nFactura.toLowerCase().match(searchQuery) 

                });
                return result ? result : []
            } else {
                return this.recibos
            }
        }
    },
};
</script>

<style scoped>
</style>
