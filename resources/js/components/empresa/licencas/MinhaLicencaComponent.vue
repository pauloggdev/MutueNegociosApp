<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Minhas Licenças
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

                            <input type="text" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar Por marca..." />
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

                            <!-- <a data-toggle="modal" href="#modalFiltrarMarcas" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a> -->
                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <div class="table-header widget-header">Todas as minhas licenças</div>

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
                                        <th class="center">Código</th>
                                        <th class="">Licença</th>
                                        <th class="">Data activação</th>
                                        <th class="">Data Inicio</th>
                                        <th class="">Data Fim</th>
                                        <th class="center">Status</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="lc in queryLicencas" :key="lc.id">
                                        <td class="center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </td>

                                        <td class="center">{{lc.id}}</td>
                                        <td class="">{{lc.licenca.designacao}}</td>
                                        <td class="">{{lc.data_activacao | formatDate}}</td>
                                        <td class="">{{lc.data_inicio | formatDate}}</td>
                                        <td class="">{{lc.data_fim | formatDate}}</td>
                                        <td class="center">
                                            <span v-if="(new Date(lc.data_fim).getTime() > new Date().getTime()) || lc.licenca_id  == 4" class="label label-sm label-success" style="border-radius: 20px;">activo</span>
                                            <span v-else class="label label-sm label-warning" style="border-radius: 20px;">expirado</span>
                                        </td>

                                        <!-- <td class="hidden-480" style="text-align: center">
                                            <span v-if="(marca.statu_geral.id == 1)" class="label label-sm label-success" style="border-radius: 20px;">{{ marca.statu_geral.designacao }}</span>
                                            <span v-else class="label label-sm label-warning" style="border-radius: 20px;">{{ marca.statu_geral.designacao }}</span>
                                        </td>

                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#editar_marca" data-toggle="modal" @click.prevent="showModal(marca)" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                </a>
                                                <a data-toggle="modal" title="Eliminar este Registro" @click.prevent="deletar(marca)" style="cursor:pointer;">
                                                    <i class="ace-icon fa fa-trash-o bigger-150 bolder danger red"></i>
                                                </a>
                                            </div>
                                        </td> -->
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
    components: {
        Select2,
    },

    props: ["licencas", ],

    data() {
        return {
            searchQuery: '',
            USUARIO_EMPRESA: 2,
            router: ""

        };

    },

    created() {

        // const data1 = new Date('2021-03-29').getTime()
        // const data = new Date().getTime()

        // console.log(data1)
        // console.log(data)

        // console.log(this.comparaData('2021-03-21'));

    },

    computed: {
        
        queryLicencas() {
            if (this.searchQuery) {
                let result = this.licencas.filter((item) => {
                    return item.designacao.toLowerCase().match(this.searchQuery) ||
                        item.designacao.toUpperCase().match(this.searchQuery) ||
                        item.id == this.searchQuery
                });

                return result ? result : [];
            } else {
                return this.licencas;
            }
        },
        // comparaData(dataFimLicenca) {

        //     let dataFim = new Date(dataFimLicenca);
        //     let dataActual = new Date('2021-03-22');

        //     if (dataActual.getTime() > dataFim.getTime()) {

        //         return true
        //     }
        //     return false;
        // }
    },

    methods: {

    },

    mounted: {
        // comparaData(dataFimLicenca){

        //     let dataFim = new Date(dataFimLicenca); 
        //     let dataActual = new Date(); 

        //     if(dataActual.getTime() > dataFim.getTime()){

        //         return true
        //     }
        //     return false;
        // }
    }
};
</script>

<style scoped>

</style>
