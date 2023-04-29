<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Funções
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

                            <input type="text" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar nome da função" />
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
                            <!-- <a href="#criar_banco" data-toggle="modal" title="Adicionar novo banco" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-banco-plus"></i> Nova função
                            </a> -->
                            <!-- <a href="/empresa/imprimir/bancos" data-toggle="modal" href="#modalClientes" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                </a>-->
                            <a data-toggle="modal" href="#modalFiltrarBancos" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a>
                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <div class="table-header widget-header">Todas funções do Sistema</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="center">Código</th>
                                        <th>Nome da função</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr v-for="role in buscarFuncoes" :key="role.id">
                                        <td class="center">{{ role.id }}</td>
                                        <td>{{ role.name }}</td>
                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#mostrarPermissoes" data-toggle="modal" @click.prevent="mostrarPermissoes(role.id)" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-unlock bigger-150 bolder success pink"></i>
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
    <!-- CRIAR BANCOS -->
    <div id="mostrarPermissoes" class="modal fade">
        <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Permissões
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">
                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Permissões : {{rolePermissions.name}}
                                </div>
                            </div>

                            <div class="tab-content profile-edit-tab-content">
                                <div id="dados_user" class="tab-pane in active">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Descrição</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="permission in rolePermissions.permissions" :key="permission.id">
                                                <td>{{ permission.name }}</td>
                                                <td>{{ permission.label }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
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
<!-- /.row -->
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";
import {
    maska
} from 'maska'
import {
    showError
} from "./../../../config/global";
import {
    mapState
} from "vuex";
import Swal from "sweetalert2";

export default {
    directives: {
        maska
    },
    components: {
        Select2,
    },
    props: ["roles"],
    data() {
        return {
            searchQuery: null,
            errors: [],
            USUARIO_EMPRESA: 2,
            router: "",
            rolePermissions: []
        };
    },

    created() {
       // this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`
    },
    mounted() {

    },
    computed: {
        buscarFuncoes() {
            if (this.searchQuery) {
                let result = this.roles.filter((item) => {
                    return item.name.toLowerCase().match(this.searchQuery.toLowerCase())
                });
                return result ? result : [];
            } else {
                return this.roles;
            }
        },
    },

    methods: {

        async mostrarPermissoes(roleId) {


            try {
                let response = await axios.get(`/admin/funcao/${roleId}/permissions`);
                if (response.status == 200) {
                    this.rolePermissions = response.data
                }
            } catch (error) {

                console.log('ERRO API');

            }
        },

        imprimir() {

        },
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
