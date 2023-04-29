<template>
<section class="content">
    <div class="row">

        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Valor Licença / Empresa
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    listagem
                </small>
            </h1>
        </div>
        <div class="col-xs-12">

            <div class>
                <form class="form-search" method="get" action>
                    <div class="row">
                        <div class>
                            <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-search"></i>
                                </span>

                                <input type="text" required autocomplete="on" v-model="searchQuery" class="form-control search-query" placeholder="Buscar Por fornecedores..." />
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
                          
                            <div class="table-header widget-header">Todas Licenças do Sistema</div>
                            <div>
                                <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th style="width:350px">Empresa</th>
                                            <th>E-mail</th>
                                            <th>NIF</th>
                                            <th>Contacto</th>
                                            <th>Status</th>
                                            <th>Opções</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                         <tr v-for="empresa in queryEmpresas" :key="empresa.id">
                                            <td>{{empresa.id}}</td>
                                            <td>{{empresa.nome}}</td>
                                            <td>{{empresa.email}}</td>
                                            <td>{{empresa.nif}}</td>
                                            <td>{{empresa.pessoal_Contacto}}</td>
                                            <td>
                                                <span v-if="(empresa.statusgerais.id == 1)" class="label label-sm label-success" style="border-radius: 20px;">{{ empresa.statusgerais.designacao }}</span>
                                                <span v-else class="label label-sm label-warning" style="border-radius: 20px;">{{ empresa.statusgerais.designacao }}</span>
                                            </td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a href="#licencaEditar" data-toggle="modal" class="pink" @click.prevent="mostrarModalLicenca(empresa)" title="Editar valor licença por empresa">
                                                        <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
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
        <div id="licencaEditar" class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Ver mais detalhes da licença
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="left: 0%; position: relative;">

                            <div class="col-md-12">
                                <div class="search-form-text">
                                    <div class="search-text">
                                        {{dataEmpresa.nome}}
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
                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_user" class="tab-pane in active">
                                                <table class="table table-bordered">
                                                    <tbody>
                                                        <tr v-for="data in dataEmpresa.licencas" :key="data.id">
                                                            <th scope="row" style="width: 221px;">{{data.licenca.designacao}}</th>
                                                            <td>
                                                                <vue-numeric-input v-model="data.valor" :min="0" :disabled="data.licenca.id === 1"></vue-numeric-input>
                                                            </td>
                                                            <td>
                                                                <a title="Adicionar novo banco" @click="editarValorLicenca(data)"
                                                                    class="btn btn-success widget-box widget-color-blue" 
                                                                    id="botoes"><i class="fa fa-banco-plus"></i> Editar </a>
                                                            </td>
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
</section>
</template>

<script>



import {
    baseUrl,
    showError
} from "../../../config/global";
import VueNumericInput from "vue-numeric-input";
import Swal from "sweetalert2";


export default {
    components: {
        VueNumericInput

    },
    props: ["empresas"],
    data() {

        return {
            searchQuery: "",
            dataEmpresa: {},
            router: ""
        }
    },
    created() {
        this.router = window.location.origin + `/admin`
    },
    methods: {

        async editarValorLicenca(data){

             try {
                let response = await axios.post(`${this.router}/licencas/definirValor`, data);

                if (response.status == 200) {
                    this.$toasted.global.defaultSuccess();
                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Licença cadastrado com sucesso!',
                        icon: 'success',
                        confirmButtonColor: '#3d5476',
                        confirmButtonText: 'Ok',
                        onClose: () => {
                            document.location.reload(true)
                        }
                    });
                }
            } catch (error) {
                this.errors = error.response.data.errors;
            }

        },

        mostrarModalLicenca(empresa){
            this.dataEmpresa = Object.assign({}, empresa);
        }
    },
    computed: {

         queryEmpresas() {

            if (this.searchQuery) {

                let result = this.empresas.filter(item => {
                    let searchQuery = this.searchQuery.toLowerCase();
                    return item.nome.toLowerCase().match(searchQuery) ||
                        item.nif.toLowerCase().match(searchQuery) ||
                        item.email.toLowerCase().match(searchQuery)
                });
                return result ? result : []
            } else {
                return this.empresas
            }

        }

       

    },
}
</script>
