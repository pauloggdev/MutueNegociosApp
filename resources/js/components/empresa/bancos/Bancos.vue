<template>
  <div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
      <h1>
        Bancos
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
              <div
                class="input-group input-group-sm"
                style="margin-bottom: 10px"
              >
                <span class="input-group-addon">
                  <i class="ace-icon fa fa-search"></i>
                </span>

                <input
                  type="text"
                  v-model="searchQuery"
                  required
                  autocomplete="on"
                  class="form-control search-query"
                  placeholder="Buscar Por banco..."
                />
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-primary btn-lg upload">
                    <span
                      class="ace-icon fa fa-search icon-on-right bigger-130"
                    ></span>
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

            <div
              class="col-xs-12 widget-box widget-color-green"
              style="left: 0%"
            >
              <div class="clearfix">
                <a
                  href="#criar_banco"
                  v-if="window.user.can['gerir bancos']"
                  data-toggle="modal"
                  title="Adicionar novo banco"
                  class="btn btn-success widget-box widget-color-blue"
                  id="botoes"
                >
                  <i class="fa fa-banco-plus"></i> Novo banco
                </a>
                <!-- <a href="/empresa/imprimir/bancos" data-toggle="modal" href="#modalClientes" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                </a>-->
                <a
                  data-toggle="modal"
                  href="#modalFiltrarBancos"
                  title="Lista de bancos"
                  target="_blanck"
                  class="btn btn-primary widget-box widget-color-blue"
                  id="botoes"
                >
                  <i class="fa fa-print text-default"></i> Imprimir
                </a>
                <div class="pull-right tableTools-container"></div>
              </div>

              <div class="table-header widget-header">
                Todos banco do Sistema
              </div>

              <!-- div.dataTables_borderWrap -->
              <div>
                <table
                  id="dynamic-table"
                  class="tabela1 table table-striped table-bordered table-hover"
                >
                  <thead>
                    <tr>
                      <th class="center">
                        <label class="pos-rel">
                          <input type="checkbox" class="ace" />
                          <span class="lbl"></span>
                        </label>
                      </th>
                      <th class="center">Código</th>
                      <th>Nome do banco</th>
                      <th class="center">Sigla</th>
                      <th>Nº Conta</th>
                      <th>IBAN</th>
                      <th class="center">Data do Registro</th>
                      <th class="center">Status</th>
                      <th>Opções</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="bc in queryBancos" :key="bc.id">
                      <td class="center">
                        <label class="pos-rel">
                          <input type="checkbox" class="ace" />
                          <span class="lbl"></span>
                        </label>
                      </td>

                      <td class="center">{{ bc.id }}</td>
                      <td>{{ bc.designacao }}</td>
                      <td class="center">{{ bc.sigla }}</td>
                      <td>{{ bc.num_conta }}</td>
                      <td>{{ bc.iban }}</td>
                      <td class="center">{{ bc.created_at | formatDate }}</td>
                      <td class="hidden-480" style="text-align: center">
                        <span
                          v-if="bc.statu_geral.id == 1"
                          class="label label-sm label-success"
                          style="border-radius: 20px"
                          >{{ bc.statu_geral.designacao }}</span
                        >
                        <span
                          v-else
                          class="label label-sm label-warning"
                          style="border-radius: 20px"
                          >{{ bc.statu_geral.designacao }}</span
                        >
                      </td>
                      <td>
                        <div class="hidden-sm hidden-xs action-buttons">
                          <a v-if="window.user.can['gerir bancos']"
                            href="#edit_banco"
                            data-toggle="modal"
                            @click.prevent="showModal(bc)"
                            class="pink"
                            title="Editar este registo"
                          >
                            <i
                              class="
                                ace-icon
                                fa fa-pencil
                                bigger-150
                                bolder
                                success
                                text-success
                              "
                            ></i>
                          </a>
                          <a v-if="window.user.can['gerir bancos']"
                            data-toggle="modal"
                            title="Eliminar este Registro"
                            @click.prevent="deletar(bc)"
                            style="cursor: pointer"
                          >
                            <i
                              class="
                                ace-icon
                                fa fa-trash-o
                                bigger-150
                                bolder
                                danger
                                red
                              "
                            ></i>
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

      <!-- CRIAR BANCOS -->
      <div id="criar_banco" class="modal fade">
        <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
          <div class="modal-content">
            <div class="modal-header text-center">
              <button
                type="button"
                class="close red bolder"
                data-dismiss="modal"
              >
                ×
              </button>
              <h4 class="smaller">
                <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i>
                Adicionar banco
              </h4>
            </div>
            <div class="modal-body">
              <div class="row" style="left: 0%; position: relative">
                <div class="col-md-12">
                  <div class="search-form-text">
                    <div class="search-text">
                      <i class="fa fa-pencil"></i>
                      Dados do banco
                    </div>
                  </div>

                  <form
                    enctype="multipart/form-data"
                    class="filter-form form-horizontal validation-form"
                    id
                  >
                    <div class="second-row">
                      <div class="tabbable">
                        <ul class="nav nav-tabs padding-16">
                          <li class="active">
                            <a data-toggle="tab" href="#dados_banco">
                              <i
                                class="
                                  green
                                  ace-icon
                                  fa fa-pencil-square
                                  bigger-125
                                "
                              ></i>
                              Dados do banco
                            </a>
                          </li>
                        </ul>

                        <div class="tab-content profile-edit-tab-content">
                          <div id="dados_banco" class="tab-pane in active">
                            <div class="form-group has-info">
                              <div class="col-md-5">
                                <label class="control-label" for="designacao">
                                  Nome do banco
                                  <span
                                    class="tooltip-target"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                  >
                                    <i
                                      class="
                                        fa fa-question-circle
                                        bold
                                        text-danger
                                      "
                                    ></i>
                                  </span>
                                </label>
                                <div class>
                                  <input
                                    type="text"
                                    v-model="banco.designacao"
                                    id="designacao"
                                    class="col-md-12 col-xs-12 col-sm-4"
                                    :class="
                                      errors.designacao ? 'has-error' : ''
                                    "
                                    placeholder="Informe a designação/nome do Banco"
                                  />
                                  <span
                                    v-if="errors.designacao"
                                    class="error"
                                    >{{ errors.designacao[0] }}</span
                                  >
                                </div>
                              </div>
                              <div class="col-md-3">
                                <label class="control-label" for="designacao"
                                  >Sigla</label
                                >
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                                <div class>
                                  <input
                                    type="text"
                                    v-model="banco.sigla"
                                    id="sigla"
                                    class="col-md-12 col-xs-12 col-sm-4"
                                    :class="errors.sigla ? 'has-error' : ''"
                                    placeholder="Informe a sigla do Banco"
                                  />
                                  <span v-if="errors.sigla" class="error">{{
                                    errors.sigla[0]
                                  }}</span>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <label class="control-label" for="status_id">
                                  status
                                  <span
                                    class="tooltip-target"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                  >
                                    <i
                                      class="
                                        fa fa-question-circle
                                        bold
                                        text-danger
                                      "
                                    ></i>
                                  </span>
                                </label>
                                <div class>
                                  <Select2
                                    :options="OptionsStatus"
                                    v-model="banco.status_id"
                                    placeholder="Escolha o Status"
                                  >
                                  </Select2>
                                </div>
                              </div>
                            </div>

                            <div class="form-group has-info">
                              <div class="col-md-6">
                                <label class="control-label" for="num_conta">
                                  Número da conta
                                  <span
                                    class="tooltip-target"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                  >
                                    <i
                                      class="
                                        fa fa-question-circle
                                        bold
                                        text-danger
                                      "
                                    ></i>
                                  </span>
                                </label>
                                <div class>
                                  <input
                                    type="text"
                                    maxlength="20"
                                    v-model="banco.num_conta"
                                    id="num_conta"
                                    class="col-md-12 col-xs-12 col-sm-4"
                                    :class="errors.num_conta ? 'has-error' : ''"
                                    placeholder="Informe o número da conta"
                                  />
                                  <span v-if="errors.num_conta" class="error">{{
                                    errors.num_conta[0]
                                  }}</span>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <label class="control-label" for="iban"
                                  >IBAN
                                  <span
                                    class="tooltip-target"
                                    data-toggle="tooltip"
                                    data-placement="top"
                                  >
                                    <i
                                      class="
                                        fa fa-question-circle
                                        bold
                                        text-danger
                                      "
                                    ></i>
                                  </span>
                                </label>
                                <div class>
                                  <input
                                    type="text"
                                    v-model="banco.iban"
                                    id="iban"
                                    class="col-md-12 col-xs-12 col-sm-4"
                                    :class="errors.iban ? 'has-error' : ''"
                                    placeholder="Informe o IBAN da conta"
                                  />
                                  <span v-if="errors.iban" class="error">{{
                                    errors.iban[0]
                                  }}</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="clearfix form-actions">
                          <div class="col-md-offset-3 col-md-9">
                            <button
                              class="search-btn"
                              style="border-radius: 10px"
                              @click.prevent="salvar"
                            >
                              <i class="ace-icon fa fa-check bigger-110"></i>
                              Salvar
                            </button>
                            &nbsp; &nbsp;
                            <button
                              class="btn btn-danger"
                              type="reset"
                              style="border-radius: 10px"
                            >
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

    <!-- EDITAR BANCOS -->
    <div id="edit_banco" class="modal fade">
      <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
        <div class="modal-content">
          <div class="modal-header text-center">
            <button type="button" class="close red bolder" data-dismiss="modal">
              ×
            </button>
            <h4 class="smaller">
              <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Editar
              banco
            </h4>
          </div>
          <div class="modal-body">
            <div class="row" style="left: 0%; position: relative">
              <div class="col-md-12">
                <div class="search-form-text">
                  <div class="search-text">
                    <i class="fa fa-pencil"></i>
                    Dados do banco
                  </div>
                </div>

                <form
                  enctype="multipart/form-data"
                  class="filter-form form-horizontal validation-form"
                  id
                >
                  <div class="second-row">
                    <div class="tabbable">
                      <ul class="nav nav-tabs padding-16">
                        <li class="active">
                          <a data-toggle="tab" href="#dados_banco">
                            <i
                              class="
                                green
                                ace-icon
                                fa fa-pencil-square
                                bigger-125
                              "
                            ></i>
                            Dados do banco
                          </a>
                        </li>
                      </ul>

                      <div class="tab-content profile-edit-tab-content">
                        <div id="dados_banco" class="tab-pane in active">
                          <div class="form-group has-info">
                            <div class="col-md-5">
                              <label class="control-label" for="designacao">
                                Nome do banco
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                              </label>
                              <div class>
                                <input
                                  type="text"
                                  v-model="bancoEdit.designacao"
                                  id="designacao"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.designacao ? 'has-error' : ''"
                                  placeholder="Informe a designação/nome do Banco"
                                />
                                <span v-if="errors.designacao" class="error">{{
                                  errors.designacao[0]
                                }}</span>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <label class="control-label" for="designacao"
                                >Sigla</label
                              >
                              <span
                                class="tooltip-target"
                                data-toggle="tooltip"
                                data-placement="top"
                              >
                                <i
                                  class="fa fa-question-circle bold text-danger"
                                ></i>
                              </span>
                              <div class>
                                <input
                                  type="text"
                                  v-model="bancoEdit.sigla"
                                  id="sigla"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.sigla ? 'has-error' : ''"
                                  placeholder="Informe a sigla do Banco"
                                />
                                <span v-if="errors.sigla" class="error">{{
                                  errors.sigla[0]
                                }}</span>
                              </div>
                            </div>

                            <div class="col-md-4">
                              <label class="control-label" for="status_id">
                                status
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                              </label>
                              <div class>
                                <Select2
                                  :options="OptionsStatus"
                                  v-model="bancoEdit.status_id"
                                  placeholder="Escolha o Status"
                                >
                                </Select2>
                              </div>
                            </div>
                          </div>

                          <div class="form-group has-info">
                            <div class="col-md-6">
                              <label class="control-label" for="num_conta">
                                Número da conta
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                              </label>
                              <div class>
                                <input
                                  type="text"
                                  maxlength="20"
                                  v-model="bancoEdit.num_conta"
                                  id="num_conta"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.num_conta ? 'has-error' : ''"
                                  placeholder="Informe o número da conta"
                                />
                                <span v-if="errors.num_conta" class="error">{{
                                  errors.num_conta[0]
                                }}</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label class="control-label" for="iban"
                                >IBAN
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                              </label>
                              <div class>
                                <input
                                  type="text"
                                  v-model="bancoEdit.iban"
                                  id="iban"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.iban ? 'has-error' : ''"
                                  placeholder="Informe o IBAN da conta"
                                />
                                <span v-if="errors.iban" class="error">{{
                                  errors.iban[0]
                                }}</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                          <button
                            class="search-btn"
                            style="border-radius: 10px"
                            @click.prevent="editar"
                          >
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            Editar
                          </button>
                          &nbsp; &nbsp;
                          <button
                            class="btn btn-danger"
                            type="reset"
                            style="border-radius: 10px"
                          >
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

    <!-- MODAL FILTRAR BANCOS  -->
    <div
      class="modal fade"
      id="modalFiltrarBancos"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 460px">
          <div class="modal-header text-center" id="logomarca-header">
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true" class="white">&times;</span>
            </button>
            <h4 class="smaller">
              <i class="fa fa-print bigger-110 text-default"></i> Imprimir por
              filtragem
            </h4>
          </div>
          <div class="modal-body" style>
            <form
              method="POST"
              class="form-horizontal validation-form"
              role="form"
            >
              <input type="hidden" name="_token" />

              <div class="tabbable">
                <div
                  class="tab-content profile-edit-tab-content"
                  style="padding: 8px 33px 0px"
                >
                  <div id="edit-basic" class="tab-pane in active">
                    <div class="box box-primary">
                      <div class="box-body">
                        <div class="row">
                          <div class="form-group has-info">
                            <div class="col-md-12">
                              <label for>Status</label>

                              <Select2
                                :options="statusOptions"
                                v-model="filter.status_id"
                              >
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
                  <button
                    class="btn btn-danger"
                    type="reset"
                    data-dismiss="modal"
                  >
                    <i class="ace-icon fa fa-close bigger-110"></i>
                    Cancelar
                  </button>

                  &nbsp; &nbsp;&nbsp; &nbsp;
                  <button
                    class="btn btn-info"
                    data-dismiss="modal"
                    type="submit"
                    @click.prevent="imprimir"
                  >
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
import { maska } from "maska";
import { showError } from "./../../../config/global";
import { mapState } from "vuex";
import Swal from "sweetalert2";

export default {
  directives: {
    maska,
  },
  components: {
    Select2,
  },
  props: ["bancos", "status", "guard"],
  data() {
    return {
      searchQuery: null,
      //bc: {},
      banco: {
        status_id: 1, //inicia com status do select2 ativo
      },
      bancoEdit: {},
      OptionsStatus: [],
      statusOptions: [
        {
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
      errors: [],

      options: [], //usado para preencher o select2
      USUARIO_EMPRESA: 2,
      router: "",
    };
  },

  created() {
    this.router =
      this.guard.tipo_user_id == this.USUARIO_EMPRESA
        ? window.location.origin + `/empresa`
        : window.location.origin + `/empresa/funcionario`;
    this.listarStatus();
  },

  mounted() {},

  computed: {
    window() {
      return window.Laravel;
    },

    queryBancos() {
      if (this.searchQuery) {
        let result = this.bancos.filter((item) => {
          return (
            item.designacao.toLowerCase().match(this.searchQuery) ||
            item.sigla.toLowerCase().match(this.searchQuery) ||
            item.sigla.toUpperCase().match(this.searchQuery) ||
            item.id == this.searchQuery
          );
        });

        return result ? result : [];
      } else {
        return this.bancos;
      }
    },
  },

  methods: {
    listarStatus() {
      this.status.forEach((element) => {
        this.OptionsStatus.push({
          id: element.id,
          text: element.designacao,
        });
      });
    },

    salvar() {
      this.errors = [];
      axios
        .post(`${this.router}/bancos/adicionar`, this.banco)
        .then((res) => {
          this.$toasted.global.defaultSuccess();

          Swal.fire({
            title: "Sucesso",
            text: "Banco registado com sucesso!...",
            icon: "success",
            confirmButtonColor: "#3d5476",
            confirmButtonText: "Ok",
            onClose: () => {
              document.location.reload(true);
            },
          });

          this.reset();
        })
        .catch((error) => {
          this.$toasted.global.defaultError({
            msg: "Erro ao cadastrar",
          });
          this.errors = error.response.data.errors;
        });
    },

    showModal(item) {
      // Abre a modal para editar os bancos
      this.reset();
      this.errors = [];

      this.bancoEdit = {
        //ou simplesmente this.bancoEdit = Object.assign({}, order);
        designacao: item.designacao,
        id: item.id,
        sigla: item.sigla,
        status_id: item.status_id,
        num_conta: item.num_conta,
        iban: item.iban,
      };

      /*let order = {
                designacao: item.designacao,
                id: item.id,
                sigla: item.sigla,
                status_id: item.status_id,
                num_conta: item.num_conta,
                iban: item.iban,
              }
              this.bancoEdit = Object.assign({}, order);
              */
    },

    async editar() {
      try {
        this.errors = [];
        let response = await axios.post(
          `${this.router}/bancos/update/${this.bancoEdit.id}`,
          this.bancoEdit
        );

        if (response.status == 200) {
          this.$toasted.global.defaultSuccess();
          Swal.fire({
            title: "Sucesso",
            text: "Banco registado com sucesso!",
            icon: "success",
            confirmButtonColor: "#3d5476",
            confirmButtonText: "Ok",
            onClose: () => {
              document.location.reload(true);
            },
          });
        }
      } catch (error) {
        this.$toasted.global.defaultError({
          msg: "Erro ao Actualizar o Banco",
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
          axios
            .get(`${this.router}/bancos/deletar/${item.id}`)
            .then((response) => {
              if (response.status == 200) {
                this.$toasted.global.defaultSuccess();
                Swal.fire({
                  title: "Sucesso",
                  text: "Banco removido com sucesso!",
                  icon: "success",
                  confirmButtonColor: "#3d5476",
                  confirmButtonText: "Ok",
                  onClose: () => {
                    document.location.reload(true);
                  },
                });
              }
            })
            .catch((error) => {
              if (error.response.data.isValid == false) {
                this.$toasted.global.defaultError({
                  msg: error.response.data.errors,
                });
              } else {
                this.$toasted.global.defaultError({
                  msg: "Sem Permissão para eliminar o banco, contacte o administrador do sistema",
                });
              }
            });
        }
      });
    },

    reset() {
      this.banco = {};
      this.bancoEdit = {};
    },

    imprimir() {
      this.$loading(true);
      axios
        .get(`${this.router}/imprimir/bancos?status=` + this.filter.status_id, {
          responseType: "arraybuffer",
        })
        .then((response) => {
          if (response.status === 200) {
            this.$loading(false);
            var file = new Blob([response.data], {
              type: "application/pdf",
            });
            var fileURL = URL.createObjectURL(file);
            window.open(fileURL);
          } else {
            this.$loading(false);
            console.log("Erro ao carregar pdf");
          }
          //window.open("/empresa/imprimir/bancos?status=" + this.filter.status_id); //This will open Google in a new window.
        });
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
