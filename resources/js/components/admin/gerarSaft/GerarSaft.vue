<template>
  <section class="content">
    <div class="row">
      <div class="space-6"></div>
      <div class="page-header" style="left: 0.5%; position: relative">
        <h1>Gerar Saft</h1>
      </div>

      <div class="row">
        <div class="col-xs-12">
          <!-- AVISO -->
          <div class="alert alert-warning hidden-sm hidden-xs">
            <button type="button" class="close" data-dismiss="alert">
              <i class="ace-icon fa fa-times"></i>
            </button>
            Os campos marcados com
            <span
              class="tooltip-target"
              data-toggle="tooltip"
              data-placement="top"
              ><i class="fa fa-question-circle bold text-danger"></i
            ></span>
            são de preenchimento obrigatório.
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="search-form-text">
            <div class="search-text">
              <i class="fa fa-product-hunt"></i>
              Dados Referentes ao saft
            </div>
          </div>
          <form
            method="POST"
            action
            enctype="multipart/form-data"
            class="filter-form form-horizontal validation-form"
            id="validation-form"
          >
            <div class="second-row">
              <div class="tabbable">
                <div
                  v-if="isValid == false"
                  class="alert alert-danger hidden-sm hidden-xs"
                >
                  <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                  </button>
                  Não foram efectuados nenhum documento nestes periodos
                </div>
                <ul class="nav nav-tabs padding-16">
                  <li class="active">
                    <a data-toggle="tab" href="#dados_motivo">
                      <i
                        class="green ace-icon fa fa-pencil-square bigger-125"
                      ></i>

                      Dados do Saft
                    </a>
                  </li>
                </ul>

                <div class="tab-content profile-edit-tab-content">
                  <div id="dados_motivo" class="tab-pane in active">
                    <div class="form-group has-info">
                      <div class="col-md-6">
                        <label class="control-label" for="codigo">
                          Data Inicial

                          <b class="red"
                            ><i
                              class="fa fa-question-circle bold text-danger"
                            ></i
                          ></b>
                        </label>

                        <div class>

                          <input type="date" v-model="saft.dataInicio" name="" id="">
                          <!-- <date-picker
                            v-model="saft.dataInicio"
                            class="dataPicker"
                            format="DD-MM-YYYY"
                            valueType="format"
                          ></date-picker> -->

                          <!-- <input type="text" v-model="saft.dataInicio" id="codigo" class="col-md-12 col-xs-12 col-sm-4" /> -->
                        </div>
                      </div>

                      <div class="col-md-6">
                        <label class="control-label" for="codigo">
                          Data Final

                          <b class="red"
                            ><i
                              class="fa fa-question-circle bold text-danger"
                            ></i
                          ></b>
                        </label>

                        <div class>
                            <input type="date" v-model="saft.dataFinal" name="" id="">

                          <!-- <date-picker
                            v-model="saft.dataFinal"
                            class="dataPicker"
                            format="DD-MM-YYYY"
                            valueType="format"
                          ></date-picker> -->

                          <!-- <input type="text" v-model="saft.dataInicio" id="codigo" class="col-md-12 col-xs-12 col-sm-4" /> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                  <button
                    class="search-btn"
                    type="submit"
                    style="border-radius: 10px"
                    @click.prevent="gerarSaft"
                  >
                    <i class="ace-icon fa fa-check bigger-110"></i>

                    Gerar Saft
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
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import DatePicker from "vue2-datepicker";
import Swal from "sweetalert2";

import { showError, baseUrl } from "./../../../config/global";
export default {
  props: ["guard"],
  components: {
    DatePicker,
  },

  data() {
    return {
      saft: {},
      isValid: true,
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
  methods: {
    async gerarSaft() {
      this.$loading(true);

      if (!this.saft.dataInicio || !this.saft.dataFinal) {
        this.$toasted.global.defaultError({
          msg: "Informe a data inicial e final",
        });
        this.$loading(false);
        return;
      }
      try {
        let response = await axios.get(
          `${this.router}/gerarSaftXml?dataInicio=${this.saft.dataInicio}&dataFinal=${this.saft.dataFinal}`,
          {
            responseType: "arraybuffer",
          }
        );

        // let response = await axios.get(`${this.router}/gerarSaftXml?dataInicio=${this.saft.dataInicio}&dataFinal=${this.saft.dataFinal}`);

        if (response.status === 200) {
          let date = new Date();

          this.$loading(false);

          var file = new Blob([response.data], {
            type: "application/xml",
          });

          let link = document.createElement("a");

          // link.href = URL.createObjectURL(file);
          // link.download =
          //   "ficheiroSaft_" + date.getDate() + "_" + date.getFullYear();
          // link.click();
          // document.location.reload(true);
        } else {
          this.$loading(false);
          console.log("Erro ao carregar pdf");
        }
      } catch (error) {
        if (error.response.status == 400) {
          this.$toasted.global.defaultError({
            msg: "NA data final não deve ser maior que data actual",
          });
        } else if (error.response.status == 402) {
          this.$toasted.global.defaultError({
            msg: "A data inicial não deve ser maior que data final",
          });
        } else if (error.response.status == 500) {
          this.$toasted.global.defaultError({
            msg: "Não foram efectuados nenhum documento nestes periodos",
          });
        }
        this.$loading(false);
        // this.isValid = false;
      }
    },
    dataMaiorAtual(date) {
      let parts = date.split("/"); // separa a data pelo caracter '/'
      let today = new Date(); // pega a data atual

      date = new Date(parts[2], parts[1] - 1, parts[0]); // formata 'date'

      // compara se a data informada é maior que a data atual
      // e retorna true ou false
      return date >= today ? true : false;
    },
    clearInput() {
      this.saft = {};
    },
  },
};
</script>

<style scoped>
.mx-datepicker {
  width: 340px !important;
}
</style>
