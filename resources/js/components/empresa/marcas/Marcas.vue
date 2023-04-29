<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Marcas de Produtos
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
                            <a href="#criar_marca" data-toggle="modal" title="Adicionar novo marca" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa icofont-plus-circle"></i> Nova marca
                            </a>
                            <a data-toggle="modal" href="#modalFiltrarMarcas" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a>
                            <div class="pull-right tableTools-container"></div>
                        </div>

                        <div class="table-header widget-header">Todas as marcas de Produto</div>

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
                                        <th class="">Designação</th>
                                        <th class="center">Status</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="marca in queryMarcas" :key="marca.id">
                                        <td class="center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </td>

                                        <td class="center">{{marca.id}}</td>
                                        <td class="">{{marca.designacao}}</td>

                                        <td class="hidden-480" style="text-align: center">
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

        <!-- MODAL DE CRIAR marcas -->
        <div id="criar_marca" class="modal fade criar_marca">
            <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar marcas
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
                                        Dados do marca
                                    </div>
                                </div>

                                <form method="POST" action enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                    <div class="second-row">
                                        <div class="tabbable">

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_marca" class="tab-pane in active">

                                                    <div class="row">
                                                        <div class="form-group has-info">
                                                            <br><br>
                                                            <label style="padding-top: 10px;" class="col-sm-3 control-label no-padding-right bold" for="designacao">Nome da marca <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span>
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <input type="text" v-model="marca.designacao" placeholder="Informe a marca" class="col-xs-12" :class="errors.designacao?'has-error':''" id="designacao" required style="">
                                                                    <span class="input-group-addon">
                                                                        <i class="ace-icon fa fa-info bigger-150 text-info"></i>
                                                                    </span>
                                                                </div>
                                                                    <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span>
                                                            </div>
                                                        </div>

                                                        <div class="form-group has-info">
                                                            <label style="padding-top: 10px;" class="col-sm-3 control-label no-padding-right bold" for="password">Status <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span></label>
                                                            <div class="col-md-6">
                                                                <div class>
                                                                    <Select2 :options="statusGerais" v-model="marca.status_id" placeholder="Selecione o status">
                                                                    </Select2>
                                                                </div>
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
        <!--/ MODAL DE CRIAR marcas-->

        <!-- MODAL FILTRAR FABRICANTES  -->
        <div class="modal fade" id="modalFiltrarMarcas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

        <!-- MODAIS DE COMFIRMAÇÃO PARA EDITAR marca-->
        <div id="editar_marca" class="modal fade editar_marca">
            <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Actualizar marca
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
                                        Dados da marca
                                    </div>
                                </div>

                                <form method="POST" action enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                    <div class="second-row">
                                        <div class="tabbable">

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_marca" class="tab-pane in active">

                                                    <div class="row">
                                                        <div class="form-group has-info">
                                                            <br><br>
                                                            <label style="padding-top: 10px;" class="col-sm-3 control-label no-padding-right bold" for="designacao">Nome da marca <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span>
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class="col-md-6">
                                                                <div class="input-group">
                                                                    <input type="text" v-model="marcaEdit.designacao" placeholder="Informe a marca" class="col-xs-12" :class="errors.designacao?'has-error':''" id="designacao" required style="">
                                                                    <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span>
                                                                    <span class="input-group-addon">
                                                                        <i class="ace-icon fa fa-info bigger-150 text-info"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group has-info">
                                                            <label style="padding-top: 10px;" class="col-sm-3 control-label no-padding-right bold" for="password">Status <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span></label>
                                                            <div class="col-md-6">
                                                                <div class>
                                                                    <Select2 :options="statusGerais" v-model="marcaEdit.status_id" placeholder="Selecione o status">
                                                                    </Select2>
                                                                </div>
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
        <!-- MODAIS DE COMFIRMAÇÃO PARA EDITAR marca-->
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

    props: ["marcas", "status", "guard"],

    data() {
        return {
            searchQuery: '',

            marca: {
                status_id: 1, //inicia com status do select2 ativo
            },
            marcaEdit: {},

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
            statusGerais: [],
            OptionsStatus: [],
            filter: {
                status_id: 3,
            },
            USUARIO_EMPRESA: 2,
            router: ""

        };

    },

    created() {
        this.listarStatus();
        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`

    },

    computed: {
        queryMarcas() {
            if (this.searchQuery) {
                let result = this.marcas.filter((item) => {
                    return item.designacao.toLowerCase().match(this.searchQuery) ||
                        item.designacao.toUpperCase().match(this.searchQuery) ||
                        item.id == this.searchQuery
                });

                return result ? result : [];
            } else {
                return this.marcas;
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
            axios.get(`${baseUrl}/empresa/marcas/pegar-dependecias`).then(response => {

                // response.data.status_gerais.forEach((item) => {
                //     this.statusGerais.push({
                //         id: item.id,
                //         text: item.descricao
                //     })
                // });

            }).catch((error) => {
                console.log(error);
            });
        },

        salvar() {

            this.errors = [];

            axios.post(`${this.router}/marcas/adicionar`, this.marca).then(res => {

                this.$toasted.global.defaultSuccess();

                setTimeout(function () {
                    document.location.reload(true)
                }, 2000);

                Swal.fire({
                    title: 'Sucesso',
                    text: 'marca registada com sucesso!...',
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

            this.marcaEdit = {
                //ou simplesmente this.marcaEdit = Object.assign({}, order);
                id: item.id,
                designacao: item.designacao,
                status_id: item.status_id,
            };
        },

        editar() {
            this.errors = [];
            console.log(this.marcaEdit.id)
            axios.post(`${this.router}/marcas/update/${this.marcaEdit.id}`, this.marcaEdit).then((res) => {

                    this.$toasted.global.defaultSuccess();

                    setTimeout(function () {
                        document.location.reload(true)
                    }, 2000);

                    Swal.fire({
                        title: 'Sucesso',
                        text: 'marca registado com sucesso!...',
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
            console.log(item)
            Swal.fire({
                title: "Deseja remover o item?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ok",
            }).then((result) => {
                if (result.value) {
                    axios.get(`${this.router}/marcas/deletar/${item.id}`).then((res) => {
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
                            msg: "Sem Permissão para eliminar o marca, contacte o empresaistrador do sistema",
                        });
                    });
                }
            });
        },

        reset() {
            this.marca = {};
        },
        imprimir() {
            this.$loading(true)

            axios
                .get(
                    `${this.router}/imprimir/marcas?status=` + this.filter.status_id, {
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

    mounted() {
        // this.pegarDependencias();
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
