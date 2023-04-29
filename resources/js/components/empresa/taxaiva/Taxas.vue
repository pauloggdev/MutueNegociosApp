<template>
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            Taxas
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

                            <input type="text" v-model="searchQuery" required autocomplete="on" class="form-control search-query" placeholder="Buscar Por taxa..." />
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
                        <!-- <div class="clearfix">
                            <a href="#criar_taxa" data-toggle="modal" title="Adicionar novo taxa" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa icofont-plus-circle"></i> Nova taxa
                            </a>
                            <div class="pull-right tableTools-container"></div>
                        </div> -->

                        <div class="table-header widget-header">Todos as taxas do Iva</div>

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
                                        <th class="center">Valor da Taxa</th>
                                        <th>Descrição</th>
                                        <th class="center">Status</th>
                                        <!-- <th>Opções</th> -->
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr v-for="taxa in queryTaxas" :key="taxa.codigo">
                                        <td class="center">
                                            <label class="pos-rel">
                                                <input type="checkbox" class="ace" />
                                                <span class="lbl"></span>
                                            </label>
                                        </td>

                                        <td class="center">{{taxa.codigo}}</td>
                                        <td class="center">{{taxa.taxa}}</td>
                                        <td>{{taxa.descricao}}</td>

                                        <td class="hidden-480" style="text-align: center">
                                            <span v-if="(taxa.statu_geral.id == 1)" class="label label-sm label-success" style="border-radius: 20px;">{{ taxa.statu_geral.designacao }}</span>
                                            <span v-else class="label label-sm label-warning" style="border-radius: 20px;">{{ taxa.statu_geral.designacao }}</span>
                                        </td>

                                        <!-- <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#editar_taxa" data-toggle="modal" @click.prevent="showModal(taxa)" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                </a>
                                                <a data-toggle="modal" title="Eliminar este Registro" @click.prevent="deletar(taxa)" style="cursor:pointer;">
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

        <!-- MODAL DE CRIAR taxas -->
        <div id="criar_taxa" class="modal fade criar_taxa">
            <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar taxas
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
                                        Dados da taxa
                                    </div>
                                </div>

                                <form method="POST" action enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_taxa">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados da taxa
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_taxa" class="tab-pane in active">
                                                    <div class="form-group has-info">
                                                        <div class="col-md-6">
                                                            <label class="control-label" for="codigo">
                                                                Valor da Taxa
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="taxa.taxa" id="codigo" class="col-md-12 col-xs-12 col-sm-4" :class="errors.taxa?'has-error':''" placeholder="Código do taxa" />
                                                                <span v-if="errors.taxa" class="error">{{errors.taxa[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-md-6">
                                                            <label class="control-label" for="descricao">
                                                                Descrição do taxa
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="taxa.descricao" id="descricao" class="col-md-12 col-xs-12 col-sm-4" :class="errors.descricao?'has-error':''" placeholder="Nome/Designação do taxa" />
                                                                <span v-if="errors.descricao" class="error">{{errors.descricao[0]}}</span>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-md-6">
                                                            <label class="control-label" for="codigostatus">
                                                                Status
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <Select2 :options="statusGerais" v-model="taxa.codigostatus" placeholder="Selecione o status">
                                                                </Select2>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-md-6">
                                                            <label class="control-label" for="codigostatus">
                                                                Motivos
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <Select2 :options="motivos" v-model="taxa.codigoMotivo" placeholder="Selecione o status">
                                                                </Select2>
                                                            </div>
                                                        </div> -->
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
        <!--/ MODAL DE CRIAR taxas-->

        <!-- MODAIS DE COMFIRMAÇÃO PARA EDITAR taxa-->
        <div id="editar_taxa" class="modal fade editar_taxa">
            <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller">
                            <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Actualizar taxa
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
                                        Dados da Taxa
                                    </div>
                                </div>

                                <form method="POST" action enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_taxa">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados da Taxa
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_taxa" class="tab-pane in active">
                                                    <div class="form-group has-info">
                                                        <div class="col-md-6">
                                                            <label class="control-label" for="codigo">
                                                                Valor da Taxa
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="taxaEdit.taxa" id="codigo" class="col-md-12 col-xs-12 col-sm-4" :class="errors.taxa?'has-error':''" placeholder="Código do taxa" />
                                                                <span v-if="errors.taxa" class="error">{{errors.taxa[0]}}</span>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-md-6">
                                                            <label class="control-label" for="descricao">
                                                                Descrição do taxa
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <input type="text" v-model="taxaEdit.descricao" id="descricao" class="col-md-12 col-xs-12 col-sm-4" :class="errors.descricao?'has-error':''" placeholder="Nome/Designação da taxa" />
                                                                <span v-if="errors.descricao" class="error">{{errors.descricao[0]}}</span>
                                                            </div>
                                                        </div> -->
                                                        <div class="col-md-6">
                                                            <label class="control-label" for="codigostatus">
                                                                Status
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <Select2 :options="statusGerais" v-model="taxaEdit.codigostatus" placeholder="Selecione o status">
                                                                </Select2>
                                                            </div>
                                                        </div>
                                                        <!-- <div class="col-md-6">
                                                            <label class="control-label" for="codigostatus">
                                                                Motivos
                                                                <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                                                            </label>
                                                            <div class>
                                                                <Select2 :options="motivos" v-model="taxaEdit.codigoMotivo" placeholder="Selecione o status">
                                                                </Select2>
                                                            </div>
                                                        </div> -->
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
        <!-- MODAIS DE COMFIRMAÇÃO PARA EDITAR taxa-->
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

export default {
    components: {
        Select2,
    },

    props: ["taxas", "status", "user", "guard"],

    data() {
        return {
            searchQuery: '',
            taxa: {
                codigostatus: 1, //inicia com status do select2 ativo
            },
            taxaEdit: {},

            errors: [],
            statusGerais: [],
            motivos: [],
            USUARIO_EMPRESA: 2,
            router: ""

        };

    },

    created() {

        this.router = this.guard.tipo_user_id == this.USUARIO_EMPRESA ? window.location.origin + `/empresa` : window.location.origin + `/empresa/funcionario`

        this.listarMotivos();

        this.status.forEach((element) => {
            this.statusGerais.push({
                id: element.id,
                text: element.designacao,
            });
        });
        this.taxa.codigostatus = this.status[0].id


    },

    computed: {
        queryTaxas() {
            if (this.searchQuery) {
                let result = this.taxas.filter((item) => {
                    return item.descricao.toLowerCase().match(this.searchQuery) ||
                        item.descricao.toUpperCase().match(this.searchQuery) ||
                        item.taxa == this.searchQuery ||
                        item.codigo == this.searchQuery
                });

                return result ? result : [];
            } else {
                return this.taxas;
            }
        },
    },

    methods: {

        listarMotivos() {

            axios.get(`${this.router}/motivoIvaListar`).then(response => {

                console.log(response.data);

                response.data.forEach((item) => {
                    this.motivos.push({
                        id: item.codigo,
                        text: item.descricao
                    })
                });

            }).catch((error) => {
                console.log(error);
            });

        },

        pegarDependencias() {
            axios.get(`${this.router}/taxaIva/pegar-dependecias`).then(response => {

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

            this.taxa.codigoMotivo = 10; //motivo default

            this.errors = [];

            axios.post(`${this.router}/taxaIva/adicionar`, this.taxa).then(res => {

                this.$toasted.global.defaultSuccess();
                Swal.fire({
                    title: 'Sucesso',
                    text: 'Taxa registada com sucesso!',
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

            this.taxaEdit = {
                //ou simplesmente this.taxaEdit = Object.assign({}, order);
                codigo: item.codigo,
                descricao: item.descricao,
                taxa: item.taxa,
                codigostatus: item.codigostatus,
                codigoMotivo: item.codigoMotivo,
            };
        },

        async editar() {

            this.taxaEdit.codigoMotivo = 10; //motivo default

            this.errors = [];

            try {

                let response = await axios.post(`${this.router}/taxaIva/update/${this.taxaEdit.codigo}`, this.taxaEdit);

                if (response.data.status == 401) {
                    this.$toasted.global.defaultError({
                        msg: response.data.errors,
                    });
                    return;
                }
                if (response.status === 200 && response.data.status != 401) {
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

                }

            } catch (error) {
                console.log("Erro api", error)
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
                     axios.get(`${this.router}/taxaIva/deletar/${item.codigo}`).then((res) => {
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
                            msg: "Sem Permissão para eliminar a taxa, contacte o administrador do sistema",
                        });
                    });
                }
            });
        },

        reset() {
            this.taxa = {};
        }
    },

    mounted() {
        //this.pegarDependencias();
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
