<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Fabricantes
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

                            <input type="text" v-model="searchQuery" name="query" required autocomplete="on" class="form-control search-query" placeholder="Buscar Por designação e código do fabricante..." />
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
                            <a v-if="window.user.can['gerir fabricantes']" href="#criar_fabricante" data-toggle="modal" title="Adicionar novo fabricante" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-fabricante-plus"></i> Novo fabricante
                            </a>
                            <a @click.prevent="imprimir" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a>
                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <div class="table-header widget-header">Todos fabricante do Sistema</div>

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
                                        <th>Nome do fabricante</th>
                                        <th class="center">status</th>
                                        <th class="center">Data do Registro</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="fabricante in queryFabricantes" :key="fabricante.id">

                                        <td class="center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </td>
                                        <td class="center">{{fabricante.id}}</td>

                                        <td>{{ fabricante.designacao }}</td>
                                        <td class="hidden-480" style="text-align: center">
                                            <span v-if="(fabricante.statu_geral.id == 1)" class="label label-sm label-success" style="border-radius: 20px;">{{ fabricante.statu_geral.designacao }}</span>

                                            <span v-else class="label label-sm label-warning" style="border-radius: 20px;">{{ fabricante.statu_geral.designacao }}</span>
                                        </td>

                                        <td class="center">{{ fabricante.created_at | formatDateTime}}</td>

                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#editar_fabricante" v-if="fabricante.diversos != 'Sim'" data-toggle="modal" @click.prevent="showModal(fabricante)" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                </a>
                                                <a data-toggle="modal" v-if="fabricante.diversos != 'Sim'" title="Eliminar este Registro" @click.prevent="deletar(fabricante)" style="cursor:pointer;">
                                                    <i class="ace-icon fa fa-trash-o bigger-150 bolder danger red"></i>
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

        <!-- CRIAR fabricanteS -->
        <div id="criar_fabricante" class="modal fade">
            <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar fabricante
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12">
                                <!-- AVISO -->
                                <div class="alert alert-warning hidden-sm hidden-xs">
                                    <button type="button" class="close" data-dismiss="alert">
                                        <i class="ace-icon fa fa-times"></i>
                                    </button>
                                    Os campos marcados com <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span> são de preenchimento obrigatório.
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <div class="row" style="left: 0%; position: relative;">
                            <div class="col-md-12">
                                <div class="search-form-text">
                                    <div class="search-text">
                                        <i class="fa fa-pencil"></i>
                                        Dados do fabricante
                                    </div>
                                </div>

                                <form enctype="multipart/form-data" class="filter-form form-horizontal" id>
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_fabricante">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados do fabricante
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_fabricante" class="tab-pane in active" style="left: 12%; position: relative">
                                                    <div class="form-group">
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="designacao">
                                                                Nome do fabricante
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="fabricante.designacao" id="designacao" class="col-md-12 col-xs-12 col-sm-4" :class="errors.designacao?'has-error':''" />
                                                                <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span>

                                                            </div>
                                                        </div>

                                                        <div class="col-md-5">
                                                            <label class="control-label" for="status_id">
                                                                status
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <Select2 :options="OptionsStatus" v-model="fabricante.status_id">

                                                                </Select2>
                                                                <!-- <select style="height: 34px" class="col-md-12 col-xs-12 col-sm-4" v-model="fabricante.status_id" data-placeholder="Selecione o status">
                                                                    <option v-for="statu in status" v-bind:value="statu.id" :key="statu.id">{{statu.designacao}}</option>
                                                                </select> -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="clearfix form-actions">
                                                <div class="col-md-offset-3 col-md-9">
                                                    <button class="search-btn" style="border-radius: 10px" @click.prevent="salvar">
                                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                                        Salvar
                                                    </button>
                                                    &nbsp; &nbsp;
                                                    <button class="btn btn-danger" type="reset" style="border-radius: 10px">
                                                        <i class="ace-icon fa fa-undo bigger-110"></i>
                                                        Cancelar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

   

    <!-- EDITAR fabricanteS -->
    <div id="editar_fabricante" class="modal fade">
        <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Editar fabricante
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- AVISO -->
                            <div class="alert alert-warning hidden-sm hidden-xs">
                                <button type="button" class="close" data-dismiss="alert">
                                    <i class="ace-icon fa fa-times"></i>
                                </button>
                                Os campos marcados com <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span> são de preenchimento obrigatório.
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <div class="row" style="left: 0%; position: relative;">
                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Dados do fabricante
                                </div>
                            </div>

                            <form enctype="multipart/form-data" class="filter-form form-horizontal" id>
                                <div class="second-row">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs padding-16">
                                            <li class="active">
                                                <a data-toggle="tab" href="#dados_fabricante">
                                                    <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                    Dados do fabricante
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_fabricante" class="tab-pane in active" style="left: 12%; position: relative">
                                                <div class="form-group">
                                                    <div class="col-md-5">
                                                        <label class="control-label" for="designacao">
                                                            Nome do fabricante
                                                            <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                        </label>
                                                        <div class>
                                                            <input type="text" v-model="fabricanteEdit.designacao" id="designacao" class="col-md-12 col-xs-12 col-sm-4" :class="errors.designacao?'has-error':''" />
                                                            <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <label class="control-label" for="status_id">
                                                            status
                                                            <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                        </label>
                                                        <div class>
                                                            <Select2 :options="OptionsStatus" v-model="fabricanteEdit.status_id">

                                                            </Select2>
                                                            <!-- <select style="height: 34px" class="col-md-12 col-xs-12 col-sm-4" v-model="fabricanteEdit.status_id" data-placeholder="Selecione o status">
                                                                <option v-for="statu in status" v-bind:value="statu.id" :key="statu.id">{{statu.designacao}}</option>
                                                            </select> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" style="border-radius: 10px" @click.prevent="editar">
                                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                                    Salvar
                                                </button>
                                                &nbsp; &nbsp;
                                                <button class="btn btn-danger" type="reset" style="border-radius: 10px">
                                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- FIM EDITAR fabricanteS -->

</div>
<!-- /.row -->
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";
import Swal from "sweetalert2";

import {
    showError
} from "./../../../config/global";
import {
    mapState
} from "vuex";

export default {
    components: {
        Select2,
    },
    props: ["fabricantes", "status", "guard"],
    data() {
        return {
            fabricante: {
                status_id: 1
            },
            fabricanteEdit: {},
            OptionsStatus: [], //usado para form create e edit
            errors: [],
            statusOptions: [{
                    id: 1,
                    text: "Activo",
                },
                {
                    id: 2,
                    text: "Desactivo",
                },
                {
                    id: 3,
                    text: "Todos",
                },
            ],
            filter: {
                status_id: 3,
            },
            searchQuery: "",
            USUARIO_EMPRESA: 2,
            router: ""
            //statuId: 1
        };
    },
    created() {

        this.listarStatus();
        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`
    },
    computed: {
          window() {
      return window.Laravel;
    },
        queryFabricantes() {
            if (this.searchQuery) {
                let result = this.fabricantes.filter((item) => {

                    let searchQuery = this.searchQuery.toLowerCase();
                    return item.designacao.toLowerCase().match(searchQuery) || item.id == searchQuery
                });

                return result ? result : [];
            } else {
                return this.fabricantes;
            }
        },
    },

    methods: {
        listarStatus() {

            this.status.forEach(element => {

                this.OptionsStatus.push({
                    id: element.id,
                    text: element.designacao
                })

            });
        },
        salvar() {

            this.errors = [];
            axios
                .post(`${this.router}/fabricantes/adicionar`, this.fabricante)
                .then(res => {
                    this.$toasted.global.defaultSuccess();
                    Swal.fire({
                        title: "Sucesso",
                        text: "Produto registado com sucesso!...",
                        icon: "success",
                        confirmButtonColor: "#3d5476",
                        confirmButtonText: "Ok",
                        onClose: () => {
                            document.location.reload(true)
                        },
                    });
                    this.reset();
                })
                .catch(error => {
                    this.$toasted.global.defaultError({
                        msg: "Erro ao cadastrar"
                    });
                    this.errors = error.response.data.errors;
                });

        },
        showModal(fabricante) {

            this.reset();
            this.errors = [];
            //this.fabricanteEdit = Object.assign(fabricante, this.fabricanteEdit);

            this.fabricanteEdit = {
                //ou simplesmente this.armazemEdit = Object.assign({}, order);
                id: fabricante.id,
                designacao: fabricante.designacao,
                status_id: fabricante.status_id
            };

        },

        async editar() {

            try {

                let response = await axios.put(`${this.router}/fabricantes/update/${this.fabricanteEdit.id}`, this.fabricanteEdit)

                if (response.status === 200) {

                    this.$toasted.global.defaultSuccess();

                    setTimeout(function () {
                        document.location.reload(true);
                    }, 2000);
                    this.reset();

                }
            } catch (error) {

                this.$toasted.global.defaultError({
                    msg: "Erro ao actualizar",
                });
                this.errors = error.response.data.errors;

            }

        },
        deletar(item) {
            Swal.fire({
                title: "Deseja remover o item?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ok",
            }).then((result) => {
                if (result.value) {
                    axios.get(`${this.router}/fabricantes/deletar/${item.id}`).then((res) => {
                        this.$toasted.global.defaultSuccess();
                        Swal.fire({
                            title: 'Sucesso',
                            text: 'Banco registado com sucesso!...',
                            icon: 'success',
                            confirmButtonColor: '#3d5476',
                            confirmButtonText: 'Ok',
                            onClose: () => {
                                document.location.reload(true)
                            }
                        });

                        this.reset();
                    }).catch((error) => {
                        this.$toasted.global.defaultError({
                            msg: "Sem Permissão para eliminar o fabricante, contacte o administrador do sistema",
                        });
                    });
                }
            });
        },

        reset() {
            this.fabricante = {};
            this.fabricanteEdit = {};
        },
        imprimir() {
            this.$loading(true)

            axios
                .get(
                    `${this.router}/imprimir/fabricantes?status=` + this.filter.status_id, {
                        responseType: "arraybuffer",
                    }
                )
                .then((response) => {
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
                    //window.open("/empresa/imprimir/bancos?status=" + this.filter.status_id); //This will open Google in a new window.
                });
        },
    }
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
