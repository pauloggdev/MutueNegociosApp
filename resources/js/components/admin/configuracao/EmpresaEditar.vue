<template>
<section class="content">
    <div class="row">

        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                EMPRESA
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Configurações
                </small>
            </h1>
        </div><!-- /.page-header -->
        <div class="col-xs-12">
            <div class="">
                <div class="row">
                    <div id="" class="user-profile row">
                        <div class="col-sm-offset-1 col-sm-10">
                            <!-- <div class="well well-sm">
                                <div class="inline middle blue bigger-110"> Seu perfil está 80% completo</div>

                                &nbsp; &nbsp; &nbsp;
                                <div style="width:200px;" data-percent="70%" class="inline middle no-margin progress progress-striped active pos-rel">
                                    <div class="progress-bar progress-bar-success" style="width:70%"></div>
                                </div>
                            </div> -->
                            

                            <div class="space"></div>

                            <form method="POST" enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">

                                <div class="tabbable">
                                    <ul class="nav nav-tabs padding-16">

                                        <li>
                                            <a data-toggle="tab" href="#edit-settings">
                                                <i class="purple ace-icon icofont-info-circle bigger-125"></i>
                                                Informações da empresa
                                            </a>
                                        </li>

                                        <!-- <li>
                                                <a data-toggle="tab" href="#edit-password">
                                                    <i class="blue ace-icon fa fa-key bigger-125"></i>
                                                    Password
                                                </a>
                                            </li> -->
                                    </ul>

                                    <div class="tab-content profile-edit-tab-content">

                                        <div id="edit-settings" class="tab-pane in active">
                                            <h4 class="header blue bolder smaller">Geral</h4>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-4">
                                                    <input type="file" name="logotipo" v-on:change="onLogotipo" accept="application/pdf,image/jpeg,image/png" id="id-input-file-3" :class="errors.comprovativo_bancario?'has-error':''" required />

                                                </div>

                                                <div class="vspace-12-sm"></div>

                                                <div class="col-xs-12 col-sm-8">
                                                    <div class="form-group has-info">
                                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Nome da Empresa</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" name="nome" v-model="empresa.nome" class="col-xs-12 col-sm-10" id="name" placeholder="Nome Completo" maxlength="255" required>

                                                        </div>
                                                    </div>

                                                    <div class="space-4"></div>

                                                    <div class="form-group has-info">
                                                        <label class="col-sm-4 control-label no-padding-right" for="form-field-username">NIF</label>

                                                        <div class="col-sm-8">
                                                            <input type="text" name="nif" v-model="empresa.nif" class="col-xs-12 col-sm-10" id="nif" placeholder="Nº de identificação fiscal" maxlength="14" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr />
                                            <div class="form-group has-info">
                                                <label class="col-sm-4 control-label no-padding-right" for="form-field-username">País</label>
                                                <div class="col-sm-8">
                                                    <Select2 :options="paisesOptions" v-model="empresa.pais_id" placeholder="Selecione o país">
                                                    </Select2>
                                                </div>
                                            </div>
                                            <div class="form-group has-info">
                                                <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Cidade</label>
                                                <div class="col-sm-8">
                                                    <input class="col-xs-12 col-sm-8" type="text" v-model="empresa.cidade" name="cidade" id="form-field-username" placeholder="Cidade" />

                                                </div>
                                            </div>

                                            <div class="space-4"></div>
                                            <div class="form-group has-info">
                                                <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Tipo de Regime</label>
                                                <div class="col-sm-8">
                                                    <Select2 :options="regimesOptions" v-model="empresa.tipo_regime_id" placeholder="Selecione o regime">
                                                    </Select2>

                                                </div>
                                            </div>

                                            <div class="space"></div>
                                            <h4 class="header blue bolder smaller">Contactos</h4>

                                            <div class="form-group has-info">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-email">Email</label>
                                                <div class="col-sm-9">
                                                    <span class="input-icon input-icon-right">
                                                        <input type="email" v-model="empresa.email" name="email" id="form-field-email" class="col-xs-12" />
                                                        <i class="ace-icon fa fa-envelope"></i>
                                                    </span>

                                                </div>
                                            </div>

                                            <div class="space-4"></div>

                                            <div class="form-group has-info">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-website">Website</label>

                                                <div class="col-sm-9">
                                                    <span class="input-icon input-icon-right">
                                                        <input type="url" v-model="empresa.Website" name="Website" id="form-field-website" class="col-xs-12" />
                                                        <i class="ace-icon fa fa-globe"></i>
                                                    </span>

                                                </div>
                                            </div>

                                            <div class="space-4"></div>

                                            <div class="form-group has-info">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-phone">Telefone</label>

                                                <div class="col-sm-9">
                                                    <span class="input-icon input-icon-right">
                                                        <input type="text" name="pessoal_Contacto" v-model="empresa.pessoal_Contacto" class="input-medium input-mask-phone col-xs-12" id="form-field-phone" />
                                                        <i class="ace-icon fa fa-phone fa-flip-horizontal"></i>
                                                    </span>

                                                </div>
                                            </div>

                                            <div class="space"></div>
                                            <h4 class="header blue bolder smaller">Outros</h4>

                                            <div class="form-group has-info">
                                                <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Pessoa de Contacto</label>
                                                <div class="col-sm-8">
                                                    <input class="col-xs-12 col-sm-8" v-model="empresa.pessoa_de_contacto" type="text" name="pessoa_de_contacto" id="form-field-username" placeholder="Pessoa de Contacto" />

                                                </div>
                                            </div>

                                            <div class="space-4"></div>

                                            <div class="form-group has-info">
                                                <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Endereço</label>
                                                <div class="col-sm-8">
                                                    <input class="col-xs-12 col-sm-8" v-model="empresa.endereco" type="text" name="endereco" id="form-field-username" placeholder="Endereço" />
                                                </div>
                                            </div>
                                        </div>

                                        <div id="edit-password" class="tab-pane">
                                            <div class="space-10"></div>

                                            <div class="form-group has-info">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-pass1">Antiga Password</label>

                                                <div class="col-sm-9">
                                                    <input type="password" id="form-field-pass1" />
                                                </div>
                                            </div>

                                            <div class="space-4"></div>

                                            <div class="form-group has-info">
                                                <label class="col-sm-3 control-label no-padding-right" for="form-field-pass2">Nova Password</label>

                                                <div class="col-sm-9">
                                                    <input type="password" id="form-field-pass2" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="clearfix form-actions">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button class="btn btn-info" type="submit" @click.prevent="editarEmpresa">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            Editar
                                        </button>

                                        &nbsp; &nbsp;
                                        <button class="btn" type="reset">
                                            <i class="ace-icon fa fa-undo bigger-110"></i>
                                            Cancelar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div><!-- /.span -->
                    </div><!-- /.user-profile -->
                </div>
            </div>
        </div><!-- /.col -->
    </div>
</section>
</template>

<script>
import Select2 from 'v-select2-component';
import DatePick from 'vue-date-pick';
import Swal from "sweetalert2";
import VueNumericInput from "vue-numeric-input";

import {
    baseUrl,
    showError
} from "../../../config/global";
export default {
    components: {
        Select2,
        DatePick,
        VueNumericInput

    },
    props: ["empresas", "paises", "regimes"],
    data() {

        return {
            empresa: {},
            errors: [],
            router: "",
            paisesOptions: [],
            regimesOptions: [],
            logotipo: "",

        }
    },
    created() {
        this.router = window.location.origin + `/admin`
        this.empresa = Object.assign({}, this.empresas);
        this.listarPaises();
        this.listarRegimes();

    },

    methods: {

        listarPaises() {
            this.paises.forEach(element => {
                this.paisesOptions.push({
                    id: element.id,
                    text: element.designacao
                })
            });
        },
        listarRegimes() {
            this.regimes.forEach(element => {
                this.regimesOptions.push({
                    id: element.id,
                    text: element.Designacao
                })
            });
        },
        onLogotipo(e) {
            this.logotipo = e.target.files[0];
        },

        async editarEmpresa() {

            const config = {
                headers: {
                    'content-type': 'multipart/form-data'
                }
            };

            let formData = new FormData();
            var empresa = JSON.stringify(this.empresa);
            formData.append('empresa', empresa);
            formData.append('logotipo', this.logotipo);

            try {

                let response = await axios.post(`${this.router}/empresa/editar`, formData, config);
                if (response.status == 200) {

                    this.$toasted.global.defaultSuccess();

                    Swal.fire({
                        title: 'Sucesso',
                        text: 'Empresa actualizado com sucesso!',
                        icon: 'success',
                        confirmButtonColor: '#3d5476',
                        confirmButtonText: 'Ok',
                        onClose: () => {
                            document.location.reload(true)
                        }
                    });

                }

            } catch (error) {
                this.$toasted.global.defaultError({
                    msg: "Erro ao editar"
                });
                this.errors = error.response.data.errors;

            }

        },

        currency(valor) {
            return valor.toLocaleString('de-DE', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 3
            })
        },
        formatQt(valor) {
            return valor.toLocaleString('de-DE', {
                minimumFractionDigits: 1,
                maximumFractionDigits: 1
            })
        },

    }
}
</script>
