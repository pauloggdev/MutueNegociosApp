<template>
  <div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
      <h1>Relatórios de vendas</h1>
    </div>
    <div class="row" style="left: 0%; position: relative">
      <div class="col-md-12">
        <div class="second-row">
          <div class="tabbable">
            <ul class="nav nav-tabs padding-16">
              <li class="active">
                <a data-toggle="tab" href="#dados_user">
                  <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                  Imprimir relatórios
                </a>
              </li>
            </ul>
            <div class="tab-content profile-edit-tab-content">
              <div id="dados_user" class="tab-pane in active">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <th scope="row">Relatórios vendas diárias</th>
                      <td>
                        <a
                          data-toggle="modal"
                          href="#modalRelatorioDiario"
                          title="Editar impressão"
                          target="_blanck"
                          class="btn btn-primary widget-box widget-color-blue"
                          id="botoes"
                        >
                          <i class="fa fa-print text-default"></i> imprimir
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Relatórios vendas Mensal</th>
                      <td>
                        <a
                          data-toggle="modal"
                          href="#modalRelatorioMensal"
                          title="Editar impressão"
                          target="_blanck"
                          class="btn btn-primary widget-box widget-color-blue"
                          id="botoes"
                        >
                          <i class="fa fa-print text-default"></i> imprimir
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Relatórios vendas Anual</th>
                      <td>
                        <a
                          data-toggle="modal"
                          href="#modalRelatorioAnual"
                          title="Editar impressão"
                          target="_blanck"
                          class="btn btn-primary widget-box widget-color-blue"
                          id="botoes"
                        >
                          <i class="fa fa-print text-default"></i> imprimir
                        </a>
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
    <!-- MODAL FILTRAR MENSAL  -->
    <div
      class="modal fade"
      id="modalRelatorioDiario"
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
                              <label for>Data</label>
                              <input type="date" v-model="filterDate" />
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="clearfix form-actions">
                <div class="row">
                  <div class="col-md-6">
                    <button @click.prevent="imprimirTodosRelatorioDiario('xls')"
                      class="btn btn-success"
                      type="reset"
                      data-dismiss="modal"
                    >
                      <i class="ace-icon fa fa-close bigger-110"></i>
                      EXPORTAR EXCEL
                    </button>
                  </div>
                  <div class="col-md-6">
                    <button
                      class="btn btn-primary"
                      data-dismiss="modal"
                      @click.prevent="imprimirTodosRelatorioDiario('pdf')"
                    >
                      <i class="fa fa-print bigger-110 text-default"></i>
                      EXPORTAR PDF
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /MODAL FILTRAR MENSAL-->

    <!-- MODAL FILTRAR MENSAL  -->
    <div
      class="modal fade"
      id="modalRelatorioMensal"
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
                              <label for>Data</label>
                              <input type="month" v-model="filterMonthYear" />

                              <!-- <Select2 :options="DataOptions" v-model="filter.Data_id">
                                                        </Select2> -->
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="clearfix form-actions">
                <div class="row">
                  <div class="col-md-6">
                    <button
                      @click.prevent="
                        imprimirRelatorioMensalTodoFuncionario('xls')
                      "
                      class="btn btn-success"
                      type="reset"
                      data-dismiss="modal"
                    >
                      <i class="ace-icon fa fa-close bigger-110"></i>
                      EXPORTAR EXCEL
                    </button>
                  </div>
                  <div class="col-md-6">
                    <button
                      class="btn btn-primary"
                      data-dismiss="modal"
                      @click.prevent="
                        imprimirRelatorioMensalTodoFuncionario('pdf')
                      "
                    >
                      <i class="fa fa-print bigger-110 text-default"></i>
                      EXPORTAR PDF
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /MODAL FILTRAR MENSAL-->

    <!-- MODAL FILTRAR ANUAL  -->
    <div
      class="modal fade"
      id="modalRelatorioAnual"
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
                              <label for>Data</label>
                              <input
                                type="number"
                                style="width: 200px; height: 36px"
                                min="2019"
                                max="2099"
                                step="1"
                                v-model="filterYear"
                              />

                              <!-- <Select2 :options="DataOptions" v-model="filter.Data_id">
                                                        </Select2> -->
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="clearfix form-actions">
                <div class="row">
                  <div class="col-md-6">
                    <button @click.prevent="imprimirRelatorioAnualTodoFuncioario('xls')"
                      class="btn btn-success"
                      type="reset"
                      data-dismiss="modal"
                    >
                      <i class="ace-icon fa fa-close bigger-110"></i>
                      EXPORTAR EXCEL
                    </button>
                  </div>
                  <div class="col-md-6">
                    <button
                      class="btn btn-primary"
                      data-dismiss="modal"
                      @click.prevent="imprimirRelatorioAnualTodoFuncioario('pdf')"
                    >
                      <i class="fa fa-print bigger-110 text-default"></i>
                      EXPORTAR PDF
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /MODAL FILTRAR Anual-->
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
  props: ["guard"],
  data() {
    return {
      errors: [],
      USUARIO_EMPRESA: 2,
      router: "",
      filterDate: "",
      filterMonthYear: "",
      filterYear: new Date().getFullYear(),
    };
  },

  created() {
    this.router =
      this.guard.tipo_user_id == this.USUARIO_EMPRESA
        ? window.location.origin + `/empresa`
        : window.location.origin + `/empresa/funcionario`;
    // this.listarData();
  },

  mounted() {},
  methods: {
    async imprimirRelatorioAnualTodoFuncioario(formato) {
      if (!this.filterYear) {
        this.$toasted.global.defaultError({
          msg: "Informe a ano",
        });
        return;
      }
      this.$loading(true);

      let ano = String(this.filterYear);

      try {
        let response = await axios.get(
          `${this.router}/imprimirRelatorioAnualTodoFuncioario?filterYear=${ano}&formato=${formato}`,
          {
            responseType: "arraybuffer",
          }
        );

         if (response.status == 200) {
          var file = new Blob([response.data], {
            type: response.headers["content-type"],
          });
          const link = document.createElement("a");
          link.href = window.URL.createObjectURL(file);
          link.download = `relatorioDeVendasAnual_${new Date().getTime()}.${formato}`;
          link.click();
          this.$loading(false);
        }

        // if (response.status == 200) {
        //   this.$loading(false);
        //   var file = new Blob([response.data], {
        //     type: "application/pdf",
        //   });
        //   var fileURL = URL.createObjectURL(file);
        //   window.open(fileURL);
        //   // document.location.reload(true)
        // }
      } catch (error) {
        this.$loading(false);
        this.$toasted.global.defaultError({
          msg: "Nenhuma factura recibo efectuada no mês selecionado",
        });
        return;
      }
    },

    async imprimirRelatorioMensalTodoFuncionario(formato) {
      if (!this.filterMonthYear.length) {
        this.$toasted.global.defaultError({
          msg: "Informe a data",
        });
        return;
      }

      this.$loading(true);

      try {
        let response = await axios.get(
          `${this.router}/imprimirRelatorioMensalTodoFuncionario?filterMonthYear=${this.filterMonthYear}&formato=${formato}`,
          {
            responseType: "arraybuffer",
          }
        );

        if (response.status == 200) {
          var file = new Blob([response.data], {
            type: response.headers["content-type"],
          });
          const link = document.createElement("a");
          link.href = window.URL.createObjectURL(file);
          link.download = `relatorioDeVendasMensal_${new Date().getTime()}.${formato}`;
          link.click();
          this.$loading(false);
        }

        //   var file = new Blob([response.data], {
        //     type: "application/pdf",
        //   });
        //   var fileURL = URL.createObjectURL(file);
        //   window.open(fileURL);
        // }
      } catch (error) {
        this.$loading(false);
        this.$toasted.global.defaultError({
          msg: "Nenhuma factura recibo efectuada no mês selecionado",
        });
        return;
      }
    },

    async imprimirTodosRelatorioDiario(formato) {
      if (!this.filterDate.length) {
        this.$toasted.global.defaultError({
          msg: "Informe a data",
        });
        return;
      }
      this.$loading(true);

      try {
        let response = await axios.get(
          `${this.router}/imprimirTodosRelatorioDiario?filterDate=${this.filterDate}&formato=${formato}`,
          {
            responseType: "arraybuffer",
          }
        );

         if (response.status == 200) {
          var file = new Blob([response.data], {
            type: response.headers["content-type"],
          });
          const link = document.createElement("a");
          link.href = window.URL.createObjectURL(file);
          link.download = `relatorioDeVendasDiaria_${new Date().getTime()}.${formato}`;
          link.click();
          this.$loading(false);
        }

        // if (response.status == 200) {
        //   this.$loading(false);
        //   var file = new Blob([response.data], {
        //     type: "application/pdf",
        //   });
        //   var fileURL = URL.createObjectURL(file);
        //   window.open(fileURL);
        //   // document.location.reload(true)
        // }
      } catch (error) {
        this.$loading(false);
        this.$toasted.global.defaultError({
          msg: "Nenhuma factura recibo efectuada no dia selecionado",
        });
        return;
      }
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
