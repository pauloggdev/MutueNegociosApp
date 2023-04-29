<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            GESTORES
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

                            <input type="text" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar Por gestor..." />
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
                            <a href="#criar_gestor" data-toggle="modal" title="Adicionar novo gestor" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa icofont-plus-circle"></i> Novo Gestor
                            </a>
                            <a data-toggle="modal" href="#modalFiltrarGestores" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a>
                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <div class="table-header widget-header">Todos os gestores de Isenção</div>

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
                                        <th class="center">Codigo</th>
                                        <th>Nome</th>
                                        <th>Telefone</th>
                                        <th>Email</th>
                                        <th class="center">Status</th>
                                        <th>Data de criação</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="gestor in queryGestores" :key="gestor.id">
                                        <td class="center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </td>

                                        <td class="center">{{gestor.id}}</td>
                                        <td>{{gestor.nome}}</td>
                                        <td>{{gestor.user.telefone}}</td>
                                        <td>{{gestor.user.email}}</td>

                                        <td class="hidden-480" style="text-align: center">
                                            <span v-if="(gestor.statu_geral.id == 1)" class="label label-sm label-success" style="border-radius: 20px;">{{ gestor.statu_geral.designacao }}</span>
                                            <span v-else class="label label-sm label-warning" style="border-radius: 20px;">{{ gestor.statu_geral.designacao }}</span>
                                        </td>
                                        <td>{{gestor.created_at | formatDateTime}}</td>

                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#editar_gestor" data-toggle="modal" @click.prevent="showModal(gestor)" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                </a>
                                                <a data-toggle="modal" title="Eliminar este Registro" @click.prevent="deletar(gestor)" style="cursor:pointer;">
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

        <!-- MODAL DE CRIAR gestores -->
        <div id="criar_gestor" class="modal fade criar_gestor">
            <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar gestores
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
                                        Dados do gestor
                                    </div>
                                </div>

                                <form method="POST" action enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_gestor">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados do gestor
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_gestor" class="tab-pane in active">

                                                    <div class="form-group has-info">
                                                        <div class="col-md-8">
                                                            <label class="control-label" for="descricao">
                                                                Nome do Gestor
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="gestor.name" id="descricao" class="col-md-12 col-xs-12 col-sm-4" :class="errors.name?'has-error':''" placeholder="Nome/Designação do gestor" />
                                                                <span v-if="errors.name" class="error">{{errors.name[0]}}</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="control-label" for="status_id">
                                                                Status
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <Select2 :options="statusGerais" v-model="gestor.status_id" placeholder="Selecione o status">
                                                                </Select2>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-group has-info">

                                                        <div class="col-md-6">
                                                            <label class="control-label" for="codigo">
                                                                Telefone
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="gestor.telefone" id="codigo" class="col-md-12 col-xs-12 col-sm-4" :class="errors.telefone?'has-error':''" maxlength="9" placeholder="Telefone do gestor" />
                                                                <span v-if="errors.telefone" class="error">{{errors.telefone[0]}}</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="control-label" for="codigo">
                                                                Email
                                                                <b class="red"><i class="fa fa-question- bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="email" v-model="gestor.email" id="codigo" class="col-md-12 col-xs-12 col-sm-4" :class="errors.email?'has-error':''" placeholder="Email do gestor" />
                                                                <span v-if="errors.email" class="error">{{errors.email[0]}}</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" type="submit" style="border-radius: 10px" @click.prevent="salvar">
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--/ MODAL DE CRIAR gestores-->
        <!-- MODAL FILTRAR FABRICANTES  -->
        <div class="modal fade" id="modalFiltrarGestores" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content" style="width: 460px;">
                    <div class="modal-header text-center" id="logomarca-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true" class="white">&times;</span>
                        </button>
                        <h4 class="smaller">
                            <i class="fa fa-print bigger-110 text-default"></i> Imprimir por filtragem
                        </h4>
                    </div>
                    <div class="modal-body" style>
                        <form method="POST" class="form-horizontal validation-form" role="form">
                            <input type="hidden" name="_token" />

                            <div class="tabbable">
                                <div class="tab-content profile-edit-tab-content" style="padding:8px 33px 0px">
                                    <div id="edit-basic" class="tab-pane in active">
                                        <div class="box box-primary">
                                            <div class="box-body">
                                                <div class="row">
                                                    <div class="form-group has-info">
                                                        <div class="col-md-12">
                                                            <label for>Status</label>

                                                            <Select2 :options="statusOptions" v-model="filter.status_id">
                                                                <!-- <option disabled value="0">Select one</option> -->
                                                            </Select2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="btn btn-danger" type="reset" data-dismiss="modal">
                                        <i class="ace-icon fa fa-close bigger-110"></i>
                                        Cancelar
                                    </button>
                                    &nbsp; &nbsp;&nbsp; &nbsp;
                                    <button class="btn btn-info" data-dismiss="modal" type="submit" @click.prevent="imprimir">
                                        <i class="fa fa-print bigger-110 text-default"></i>
                                        Imprimir
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /MODAL FILTRAR FABRICANTE-->

        <!-- MODAIS DE COMFIRMAÇÃO PARA EDITAR gestor-->
        <div id="editar_gestor" class="modal fade editar_gestor">
            <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar gestor
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
                                        Dados do gestor
                                    </div>
                                </div>

                                <form method="POST" action enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_gestor">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados do gestor
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_gestor" class="tab-pane in active">
                                                    <div class="form-group has-info">

                                                        <div class="col-md-8">
                                                            <label class="control-label" for="descricao">
                                                                Nome do Gestor
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="gestorEdit.name" id="descricao" class="col-md-12 col-xs-12 col-sm-4" :class="errors.name?'has-error':''" placeholder="Nome/Designação do gestor" />
                                                                <span v-if="errors.name" class="error">{{errors.name[0]}}</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="control-label" for="status_id">
                                                                Status
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <Select2 :options="statusGerais" v-model="gestorEdit.status_id" placeholder="Selecione o status">
                                                                </Select2>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-group has-info">

                                                        <div class="col-md-6">
                                                            <label class="control-label" for="codigo">
                                                                Telefone
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="gestorEdit.telefone" id="codigo" class="col-md-12 col-xs-12 col-sm-4" :class="errors.telefone?'has-error':''" maxlength="9" placeholder="Telefone do gestor" />
                                                                <span v-if="errors.telefone" class="error">{{errors.telefone[0]}}</span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="control-label" for="codigo">
                                                                Email
                                                                <b class="red"><i class="fa fa-question- bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="email" v-model="gestorEdit.email" id="codigo" class="col-md-12 col-xs-12 col-sm-4" :class="errors.email?'has-error':''" placeholder="Email do gestor" />
                                                                <span v-if="errors.email" class="error">{{errors.email[0]}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" type="submit" style="border-radius: 10px" @click.prevent="editar">
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- MODAIS DE COMFIRMAÇÃO PARA EDITAR gestor-->
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

    props: ["gestores", "status", "user", "guard"],

    data() {
        return {
            searchQuery: '',

            gestor: {
                status_id: 1, //inicia com status do select2 ativo
            },
            gestorEdit: {
                user: {
                    name: null,
                    telefone: null,
                    email: null,
                    status_id: null
                },
            },

            errors: [],
            statusGerais: [],
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
            USUARIO_EMPRESA: 2,
            router: ""

        };

    },

    created() {

        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`
        this.listasStatus();

    },

    computed: {
        queryGestores() {
            if (this.searchQuery) {
                let result = this.gestores.filter((item) => {
                    return item.nome.toLowerCase().match(this.searchQuery) ||
                        item.nome.toUpperCase().match(this.searchQuery) ||
                        item.id == this.searchQuery ||
                        item.created_at.toLowerCase().match(this.searchQuery)
                });

                return result ? result : [];
            } else {
                return this.gestores;
            }
        },
    },

    methods: {

        listasStatus() {

            this.status.forEach((element) => {
                this.statusGerais.push({
                    id: element.id,
                    text: element.designacao,
                });
            });

        },

        salvar() {


            console.log(this.gestor)

            this.errors = [];

            axios.post(`${this.router}/gestores/adicionar`, this.gestor).then(res => {

                this.$toasted.global.defaultSuccess();

                Swal.fire({
                    title: 'Sucesso',
                    text: 'gestor registado com sucesso!...',
                    icon: 'success',
                    confirmButtonColor: '#3d5476',
                    confirmButtonText: 'Ok',
                    onClose: () => {
                        document.location.reload(true)
                    }
                });

                this.reset();

            }).catch(error => {
                if (error.response.status == 422) {
                    this.$toasted.global.defaultError({
                        msg: "Erro ao cadastrar"
                    });
                    this.errors = error.response.data.errors;
                }
            });
        },

        showModal(item) { // Abre a modal para editar os bancos

            this.reset();
            this.errors = [];

            this.gestorEdit = {
                //ou simplesmente this.gestorEdit = Object.assign({}, order);
                id: item.id,
                nome: item.nome,
                status_id: item.status_id,
                name: item.user.name,
                telefone: item.user.telefone,
                email: item.user.email,
                status_id: item.user.status_id,
                user: {
                    id:item.user.id,
                    name: item.user.name,
                    telefone: item.user.telefone,
                    email: item.user.email,
                    status_id: item.user.status_id,
                },
            };

        },

        editar() {
            this.errors = [];
            axios.post(`${this.router}/gestores/update/${this.gestorEdit.id}`, this.gestorEdit).then((res) => {

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
                })
                .catch((error) => {
                    this.$toasted.global.defaultError({
                        msg: "Erro ao actualizar",
                    });
                    this.errors = error.response.data.errors;
                });
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
                    axios.get(`${this.router}/gestores/deletar/${item.id}`).then((res) => {
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
                            msg: "Sem Permissão para eliminar o gestor, contacte o empresaistrador do sistema",
                        });
                    });
                }
            });
        },

        reset() {
            this.gestor = {};
        },
        imprimir() {
            this.$loading(true)

            axios
                .get(
                    `${this.router}/imprimir/gestores?status=` + this.filter.status_id, {
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
    },

    mounted() {}
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
