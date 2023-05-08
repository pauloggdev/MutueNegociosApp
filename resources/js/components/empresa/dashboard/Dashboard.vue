<template>
  <div class="page-content">
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
    </div>

    <div class="row">
      <div class="col-xs-12">
        <!-- PÁGINA INICIAL DE CONTEÚDOS -->
        <div v-if="auth.status_senha_id == 1">
          <div class="alert alert-block alert-danger col-xs-12">
            <button type="button" class="close" data-dismiss="alert">
              <i class="ace-icon fa fa-times white"></i>
            </button>
            <i class="ace-icon fa fa-warning white"></i>
            <span style="font-size: 12pt">Caro cliente, é obrigatória a alteração da sua password para
              maior segurança, e poderes ter acesso as outras funcionalidades do
              sistema</span>
            <a href="#alterarSenha" data-toggle="modal" class="btn btn-success widget-box widget-color-blue center"
              style="border-radius: 8px; font-size: 12pt; float: right">
              &nbsp;
              <i class="fa fa-lock"></i>&nbsp;Alterar &nbsp;
            </a>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-7">
            <!-- Usuarios -->
            <a href="/empresa/usuarios">
              <div class="infobox infobox-green">
                <div class="infobox-icon">
                  <i class="ace-icon fa fa-users"></i>
                </div>

                <div class="infobox-data">
                  <span class="infobox-data-number">{{
                    countusers | formatQt
                  }}</span>
                  <div class="infobox-content bold" style="color: black">
                    Utilizadores
                  </div>
                </div>
              </div>
            </a>

            <!-- Clientes -->
            <a href="/empresa/clientes">
              <div class="infobox infobox-blue2">
                <div class="infobox-icon">
                  <i class="ace-icon glyphicon glyphicon-user"></i>
                </div>

                <div class="infobox-data">
                  <span class="infobox-data-number">{{
                    countclientes | formatQt
                  }}</span>
                  <div class="infobox-content bold" style="color: black">
                    Clientes
                  </div>
                </div>
              </div>
            </a>

            <a href="/empresa/armazens">
              <div class="infobox infobox-pink">
                <div class="infobox-icon">
                  <i class="ace-icon fa fa-shopping-cart"></i>
                </div>

                <div class="infobox-data">
                  <span class="infobox-data-number">{{
                    countarmazens | formatQt
                  }}</span>
                  <div class="infobox-content bold" style="color: black">
                    Lojas/Armazém
                  </div>
                </div>
              </div>
            </a>

            <a href="/empresa/fornecedores">
              <div class="infobox infobox-red">
                <div class="infobox-icon">
                  <i class="ace-icon fa fa-home"></i>
                </div>
                <div class="infobox-data">
                  <span class="infobox-data-number">{{
                    countfornecedores | formatQt
                  }}</span>
                  <div class="infobox-content bold" style="color: black">
                    Fornecedores
                  </div>
                </div>
              </div>
            </a>

            <a href="/empresa/fabricantes">
              <div class="infobox infobox-purple">
                <div class="infobox-icon">
                  <i class="ace-icon fa fa-flask"></i>
                </div>
                <div class="infobox-data">
                  <span class="infobox-data-number">{{
                    countfabricantes | formatQt
                  }}</span>
                  <div class="infobox-content" style="color: black">
                    Fabricantes
                  </div>
                </div>
              </div>
            </a>

            <a href="/empresa/bancos">
              <div class="infobox infobox-orange2">
                <div class="infobox-icon">
                  <i class="ace-icon fa fa-bank"></i>
                </div>
                <div class="infobox-data">
                  <span class="infobox-data-number">{{
                    countbancos | formatQt
                  }}</span>
                  <div class="infobox-content" style="color: black">Bancos</div>
                </div>
              </div>
            </a>

            <a href="/empresa/produtos">
              <div class="infobox infobox-orange">
                <div class="infobox-icon">
                  <i class="ace-icon fa fa-product-hunt"></i>
                </div>
                <div class="infobox-data">
                  <span class="infobox-data-number">{{
                    countprodutos | formatQt
                  }}</span>
                  <div class="infobox-content" style="color: black">
                    Produtos
                  </div>
                </div>
              </div>
            </a>

            <div class="infobox infobox-green2">
              <div class="infobox-icon">
                <i class="ace-icon fa fa-product-hunt"></i>
              </div>
              <div class="infobox-data">
                <span class="infobox-data-number">{{
                  countvendas | formatQt
                }}</span>
                <div class="infobox-content" style="color: black">Vendas</div>
              </div>
            </div>

            <div class="infobox infobox-red" v-if="window.isSuperAdmin">
              <div class="infobox-data">
                <span class="infobox-data-number">{{
                  counttotalvendas | currency
                }}</span>
                <div class="infobox-content">
                  <span class="bigger-110" style="color: black">Total de Vendas</span>
                </div>
              </div>
            </div>
          </div>

          <div class="vspace-12-sm"></div>

          <div class="col-sm-5">
            <div class="widget-box">
              <div class="widget-header widget-header-flat widget-header-small">
                <h5 class="widget-title">
                  <i class="ace-icon fa fa-signal"></i>
                  Produtos mais Vendidos
                </h5>
              </div>

              <div class="widget-body">
                <div class="widget-main">
                  <div id="piechart-placeholder"></div>
                </div>
              </div>
              <!-- /.widget-body -->
            </div>
            <!-- /.widget-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- FIM DA PÁGINA DE CONTEÚDOS -->
      </div>
      <!-- /.col -->

      <!-- MODAL EDITAR SENHA DO UTILIZADOR  -->
      <div class="modal fade" id="alterarSenha" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content" style="width: 460px">
            <div class="modal-header text-center" id="logomarca-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="white">&times;</span>
              </button>
              <h4 class="smaller">
                <i class="ace-icon fa fa-pencil-square bigger-130 white"></i>
                Alteração da Senha
              </h4>
            </div>
            <div class="modal-body" style>
              <form method="POST" class="form-horizontal validation-form" role="form">
                <input type="hidden" name="_token" />

                <div class="tabbable">
                  <div class="tab-content profile-edit-tab-content">
                    <div id="edit-basic" class="tab-pane in active">
                      <div class="box box-primary">
                        <div class="box-body">
                          <div class="row">
                            <div class="form-group has-info">
                              <br />
                              <br />
                              <label class="col-sm-3 control-label no-padding-right bold" for="old_password">
                                Senha Antiga
                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span>
                              </label>
                              <div class="col-md-9">
                                <div class="input-group">
                                  <input type="password" v-model="senhaEdit.old_password"
                                    placeholder="Informe a Senha Antiga" class="col-xs-12" id="old_password" required
                                    style="padding: 2px 8px 9px" />
                                  <span class="input-group-addon">
                                    <i class="ace-icon fa fa-key bigger-150 text-info"></i>
                                  </span>
                                </div>
                              </div>
                            </div>

                            <div class="form-group has-info">
                              <label class="col-sm-3 control-label no-padding-right bold" for="password">
                                Nova Senha
                                <span class="tooltip-target" data-toggle="tooltip" data-placement="top"></span>
                              </label>
                              <div class="col-md-9">
                                <div class="input-group">
                                  <input type="password" v-model="senhaEdit.password" placeholder="Informe a nova Senha"
                                    class="col-xs-12" id="password" required style="padding: 2px 8px 9px" />
                                  <span class="input-group-addon">
                                    <i class="ace-icon fa fa-key bigger-150 text-info"></i>
                                  </span>
                                </div>
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
                    <button class="btn btn-info" type="submit" @click.prevent="AlterarSenha">
                      <i class="ace-icon fa fa-check bigger-110"></i>
                      Salvar
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- /MODAL EDITAR SENHA DO UTILIZADORR -->
    </div>
    <div class="row" v-if="window.isSuperAdmin">
      <div class="col-md-6">
        <BarChart :vendasmensal="vendasmensal" />
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
import Select2 from "v-select2-component";
import BarChart from "../../BarChart.vue";
import LineChart from "../../LineChart.vue";

import { showError, baseUrl } from "./../../../config/global";
import { mapState } from "vuex";

export default {
  components: {
    Select2,
    BarChart,
    LineChart,
  },

  props: [
    "dashboards",
    "countbancos",
    "countprodutos",
    "countvendas",
    "counttotalvendas",
    "countusers",
    "countclientes",
    "countarmazens",
    "countfornecedores",
    "countfabricantes",
    "auth",
    "guard",
    "vendasmensal",
  ],

  data() {
    return {
      user: "",
      searchQuery: null,

      senhaEdit: {
        id: this.auth.id,
      },
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
      USUARIO_EMPRESA: 2,
      router: "",
    };
  },

  created() {
    this.router =
      this.guard.tipo_user_id == this.USUARIO_EMPRESA
        ? window.location.origin + `/empresa`
        : window.location.origin + `/empresa/funcionario`;
  },

  mounted() {
    console.log(window.Laravel);
    return;
  },

  computed: {
    window() {
      return window.Laravel;
    },
  },

  methods: {
    $can(permissionName) {
      console.log(window.Laravel);
      return;
      return Permissions.indexOf(permissionName) !== -1;
    },

    AlterarSenha() {
      this.errors = [];
      axios
        .post(`/empresa/update_senha/${this.senhaEdit.id}`, this.senhaEdit)
        .then((res) => {
          this.$toasted.global.defaultSuccess();
          Swal.fire({
            title: "Sucesso",
            timer: 3000,
            text: "Senha alterado com sucesso!",
            icon: "success",
            confirmButtonColor: "#3d5476",
            confirmButtonText: "Ok",
            onClose: () => {
              document.location.reload(true);
            },
          });
        })
        .catch((error) => {
          Swal.fire({
            title:
              "Ups!, A senha antiga não corresponde com a deste utilizador!",
            timer: 3000,
            icon: "warning",
            showConfirmButton: false,
          });
          this.$toasted.global.defaultError({
            msg: "Erro na alteração",
          });
          this.errors = error.response.data.errors;
        });
    },

    reset() {
      this.senhaEdit = {};
    },
  },
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
