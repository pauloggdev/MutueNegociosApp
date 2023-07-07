<template>
    <div class="page-content">
        <div class="space-6"></div>
        <div class="row">
            <div class="page-header">
                <h1>
                    Página Inicial
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Dasboard
                    </small>
                </h1>
            </div>
            <!-- /.page-header -->
        </div>

        <div class="row">
            <div class="col-xs-12">
                <!-- PÁGINA INICIAL DE CONTEÚDOS -->


                <div class="row">
                    <div class="space-6"></div>

                    <div class="col-sm-7">
                        <!-- Usuarios -->
                        <a href="/admin/utilizadores">
                            <div class="infobox infobox-green">
                                <div class="infobox-icon">
                                    <i class="ace-icon fa fa-users"></i>
                                </div>

                                <div class="infobox-data">
                                    <span class="infobox-data-number">{{countusers|formatQt}}</span>
                                    <div class="infobox-content bold" style="color:black;">Utilizadores</div>
                                </div>
                            </div>
                        </a>

                        <!-- Clientes -->
                        <a href="/admin/clientes">
                            <div class="infobox infobox-blue2">
                                <div class="infobox-icon">
                                    <i class="ace-icon glyphicon glyphicon-user"></i>
                                </div>
                                <div class="infobox-data">
                                    <span class="infobox-data-number">{{countclientes|formatQt}}</span>
                                    <div class="infobox-content bold" style="color:black;">Clientes</div>
                                </div>
                            </div>
                        </a>
                        <a href="/admin/licencas">
                            <div class="infobox infobox-pink">
                            <div class="infobox-icon">
                                <i class="ace-icon fa fa-shopping-cart"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number">{{countlicencas|formatQt}}</span>
                                <div class="infobox-content bold" style="color:black;">Licenças</div>
                            </div>
                            </div>
                        </a>

                        <a href="/admin/pedidos/licenca">
                            <div class="infobox infobox-green" style="height:90px">
                            <div class="infobox-icon">
                                <i class="ace-icon fa fa-shopping-cart"></i>
                            </div>
                            <div class="infobox-data">
                                <span class="infobox-data-number">{{countlicencasativas|formatQt}}</span>
                                <div class="infobox-content" style="color:black;">Pedido activação Licenças activas</div>
                            </div>
                            </div>
                        </a>

                        <a href="/admin/pedidos/licenca">
                             <div class="infobox infobox-green2" style="height:90px">
                            <div class="infobox-icon">
                                <i class="ace-icon fa fa-shopping-cart"></i>
                            </div>
                            <div class="infobox-data">
                                <span class="infobox-data-number">{{countlicencaspendente|formatQt}}</span>
                                <div class="infobox-content"  style="color:black;font-size:12px">Pedido activação Licenças Pendentes</div>
                            </div>
                            </div>
                        </a>

                       <a href="/admin/pedidos/licenca">
                            <div class="infobox infobox-orange2" style="height:90px">
                            <div class="infobox-icon">
                                <i class="ace-icon fa fa-shopping-cart"></i>
                            </div>
                            <div class="infobox-data">
                                <span class="infobox-data-number">{{countlicencasrejeitada|formatQt}}</span>
                                <div class="infobox-content" style="color:black;">Pedido activação Licenças Rejeitadas</div>
                            </div>
                        </div>
                       </a>

                       <a href="/admin/bancos">

                            <div class="infobox infobox-orange2">
                            <div class="infobox-icon">
                                <i class="ace-icon fa fa-bank"></i>
                            </div>
                            <div class="infobox-data">
                                <span class="infobox-data-number">{{countbancos|formatQt}}</span>
                                <div class="infobox-content" style="color:black;">Bancos</div>
                            </div>
                        </div>
                       </a>
                    </div>
                    <div class="vspace-12-sm"></div>
                    <div class="col-sm-5">
                        <div class="widget-box">
                            <div class="widget-header widget-header-flat widget-header-small">
                                <h5 class="widget-title">
                                    <i class="ace-icon fa fa-signal"></i>
                                    Licenças mais vendido
                                </h5>


                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div id="piechart-placeholder"></div>
                                </div>
                                <!-- /.widget-main -->
                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="hr hr32 hr-dotted"></div>
                <div class="hr hr32 hr-dotted"></div>
                <!-- FIM DA PÁGINA DE CONTEÚDOS -->
            </div>
            <!-- /.col -->
        </div>
        <div class="row">
      <div class="col-md-6">
        <BarChart :licencaativasmensal="licencaativasmensal" />
      </div>
      <!-- <div class="col-md-6">
        <LineChart />
      </div> -->
    </div>
        <!-- /.row -->
    </div>
    <!-- /.row -->
</template>

<script>
import axios from "axios";
import Swal from "sweetalert2";
import BarChart from "./BarChart.vue";

import Select2 from "v-select2-component";

import {
    showError,
    baseUrl
} from "./../../../config/global";
import {
    mapState
} from "vuex";

export default {
    components: {
        Select2,
        BarChart

    },

    props: [
    "dashboards",
    "auth",
    "operacaomensal",
    "countusers",
    "countclientes",
    "countlicencas",
    "countlicencasativas",
    "countlicencaspendente",
    "countlicencasrejeitada",
    "licencaativasmensal",
    "countbancos"],

    data() {
        return {
            user: "",
            searchQuery: null,
            errors: [],
            options: [], //usado para preencher o select2
            //Pegam as dependências para o Dashboard
            users: [],
            clientes: [],
            lojas: [],
            fornecedores: [],
            fabricantes: [],
            bancos: [],
            gestores: [],
            produtos: [],
            produto_stock: [],
            vendas: [],
        };
    },

    created() {
        //this.user = window.Laravel.user;
    },

    computed: {
        // queryBancos() {
        //     if (this.searchQuery) {
        //         let result = this.bancos.filter(item => {
        //             return this.searchQuery
        //                 .toLowerCase()
        //                 .split(" ")
        //                 .every(v => item.designacao.toLowerCase().includes(v));
        //         });
        //         return result ? result : []
        //     } else {
        //         return this.bancos
        //     }
        // }
    },

    methods: {




    },

    mounted() {
        //this.dependenciaDashboard();
    }
}; //Fim do export default
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

