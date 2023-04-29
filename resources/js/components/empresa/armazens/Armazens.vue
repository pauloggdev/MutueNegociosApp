<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            ARMAZÉM
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

                            <input type="text" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar Por armazen..." />
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
                            <a href="#criar_armazen" data-toggle="modal" title="Adicionar novo armazém" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-armazen-plus"></i> Novo armazém
                            </a>
                            <a data-toggle="modal" href="#modalFiltrarBancos" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a>
                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <div class="table-header widget-header">Todos armazém do Sistema</div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                       
                                        <th>Codigo</th>
                                        <th>Nome do Armazém</th>
                                        <th>Localização</th>
                                        <th>Data de criação</th>
                                        <th class="center">Status</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="armazen in queryArmazens" :key="armazen.id">
                                       

                                        <td>{{armazen.codigo}}</td>
                                        <td>{{armazen.designacao}}</td>
                                        <td>{{armazen.localizacao}}</td>
                                        <td>{{armazen.created_at | formatDate}}</td>

                                        <td class="hidden-480" style="text-align: center">
                                            <span v-if="(armazen.statu_geral.id == 1)" class="label label-sm label-success" style="border-radius: 20px;">{{ armazen.statu_geral.designacao }}</span>
                                            <span v-else class="label label-sm label-warning" style="border-radius: 20px;">{{ armazen.statu_geral.designacao }}</span>
                                        </td>

                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#editar_armazen" v-if="armazen.diversos != 1" data-toggle="modal" @click.prevent="showModal(armazen)" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                </a>
                                                <a data-toggle="modal" v-if="armazen.diversos != 1" title="Eliminar este Registro" @click.prevent="deletar(armazen)" style="cursor:pointer;">
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

        <!-- MODAL DE CRIAR armazens -->
        <div id="criar_armazen" class="modal fade criar_armazen">
            <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar armanzém
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
                                        Dados do armazém
                                    </div>
                                </div>

                                <form method="POST" action enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_armazen">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados do armazém
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_armazen" class="tab-pane in active" style="left: 12%; position: relative">
                                                    <div class="form-group has-info">

                                                        <div class="col-md-5">
                                                            <label class="control-label" for="designacao">
                                                                Nome do armazém
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="armazen.designacao" id="designacao" class="col-md-12 col-xs-12 col-sm-4" :class="errors.designacao?'has-error':''" placeholder="Nome/Designação do Armazém" />
                                                                <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="sigla">
                                                                Sigla
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="armazen.sigla" id="sigla" class="col-md-12 col-xs-12 col-sm-4" :class="errors.sigla?'has-error':''" placeholder="Sigla do armazém" />
                                                                <span v-if="errors.sigla" class="error">{{errors.sigla[0]}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-info">
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="localizacao">
                                                                Localização
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="armazen.localizacao" id="localizacao" class="col-md-12 col-xs-12 col-sm-4" :class="errors.localizacao?'has-error':''" placeholder="Localização exacta do Armazém" />
                                                                <span v-if="errors.localizacao" class="error">{{errors.localizacao[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="status_id">
                                                                status
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <Select2 :options="statusGerais" v-model="armazen.status_id" placeholder="Selecione o status">
                                                                </Select2>
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
        <!--/ MODAL DE CRIAR armazens-->

        <!-- MODAIS PARA EDITAR ARMAZÉM-->
        <div id="editar_armazen" class="modal fade editar_armazen">
            <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Editar armanzém
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
                                        Dados do armazém
                                    </div>
                                </div>

                                <form method="POST" action enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_armazen">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados do armazém
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_armazen" class="tab-pane in active" style="left: 12%; position: relative">
                                                    <div class="form-group has-info">

                                                        <div class="col-md-5">
                                                            <label class="control-label" for="designacao">
                                                                Nome do armazém
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="armazemEdit.designacao" id="designacao" class="col-md-12 col-xs-12 col-sm-4" :class="errors.designacao?'has-error':''" placeholder="Nome/Designação do Armazém" />
                                                                <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="sigla">
                                                                Sigla
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="armazemEdit.sigla" id="sigla" class="col-md-12 col-xs-12 col-sm-4" :class="errors.sigla?'has-error':''" placeholder="Sigla do armazém" />
                                                                <span v-if="errors.sigla" class="error">{{errors.sigla[0]}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group has-info">
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="localizacao">
                                                                Localização
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="armazemEdit.localizacao" id="localizacao" class="col-md-12 col-xs-12 col-sm-4" :class="errors.localizacao?'has-error':''" placeholder="Localização exacta do Armazém" />
                                                                <span v-if="errors.localizacao" class="error">{{errors.localizacao[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="status_id">
                                                                status
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <Select2 :options="statusGerais" v-model="armazemEdit.status_id" placeholder="Selecione o status">
                                                                </Select2>
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
        <!-- MODAIS DE COMFIRMAÇÃO PARA EDITAR ARMAZÉM-->
    </div>
    <!-- /.col -->

    <!-- MODAL FILTRAR BANCOS  -->
    <div class="modal fade" id="modalFiltrarBancos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    <!-- /MODAL FILTRAR BANCOS-->
</div>
<!-- /.row -->
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";
import Swal from "sweetalert2";
import {showError,baseUrl} from "./../../../config/global";
import {
    mapState
} from "vuex";

export default {
    components: {
        Select2,
    },
    props: ['armazens', 'status', 'guard'],
    data() {
        return {
            searchQuery: '',
            armazen: {
                status_id: 1, //inicia com status do select2 ativo
            },
            armazemEdit: {},

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
        this.listarStatus();
    },

    computed: {
         window() {
      return window.Laravel;
    },
        queryArmazens() {

            if (this.searchQuery) {
                let result = this.armazens.filter((item) => {
                    return item.designacao.toLowerCase().match(this.searchQuery) ||
                        item.designacao.toUpperCase().match(this.searchQuery) ||
                        item.codigo.toLowerCase().match(this.searchQuery) ||
                        item.codigo.toUpperCase().match(this.searchQuery) ||
                        item.localizacao.toLowerCase().match(this.searchQuery) ||
                        item.localizacao.toUpperCase().match(this.searchQuery) ||
                        item.id == this.searchQuery ||
                        item.created_at.toLowerCase().match(this.searchQuery)
                });

                return result ? result : [];
            } else {
                return this.armazens;
            }
        },
    },

    methods: {

        listarStatus() {

            this.status.forEach(element => {

                this.statusGerais.push({
                    id: element.id,
                    text: element.designacao
                })

            });

        },

        pegarDependencias() {
            axios.get(`${baseUrl}/empresa/armazens/pegar-dependecias`).then(response => {

                // response.data.status_gerais.forEach((item) => {
                //     this.statusGerais.push({
                //         id: item.id,
                //         text: item.designacao
                //     })
                // });

            }).catch((error) => {
                console.log(error);
            });
        },

        salvar() {

            this.errors = [];

            axios.post(`${this.router}/armazens/adicionar`, this.armazen).then(res => {

                this.$toasted.global.defaultSuccess();

                setTimeout(function () {
                    document.location.reload(true)
                }, 2000);

                Swal.fire({
                    title: 'Sucesso',
                    text: 'Armazém registado com sucesso!',
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
            this.armazemEdit = {
                //ou simplesmente this.armazemEdit = Object.assign({}, order);
                id: item.id,
                designacao: item.designacao,
                codigo: item.codigo,
                localizacao: item.localizacao,
                status_id: item.status_id,
            };
        },

        editar() {
            this.errors = [];
            axios.post(`${this.router}/armazens/update/${this.armazemEdit.id}`, this.armazemEdit).then((res) => {

                    this.$toasted.global.defaultSuccess();

                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Armazém registado com sucesso!',
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
                    axios.get(`${this.router}/armazens/deletar/${item.id}`).then((res) => {
                        this.$toasted.global.defaultSuccess();

                        setTimeout(function () {
                            document.location.reload(true)
                        }, 2000);
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
                            msg: "Sem Permissão para eliminar o armazém, contacte o administrador do sistema",
                        });
                    });
                }
            });
        },

        reset() {
            this.armazen = {};
            this.armazemEdit = {};
        },
        imprimir() {
            this.$loading(true)

            axios
                .get(
                    `${this.router}/imprimir/armazens?status=` + this.filter.status_id, {
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
