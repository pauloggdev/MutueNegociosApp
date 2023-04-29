<template>
  <div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
      <h1>
        Modelo de Documentos
        <small>
          <i class="ace-icon fa fa-angle-double-right"></i>
          Listagem
        </small>
      </h1>
    </div>
    <div class="tabbable">
      <ul
        class="nav nav-tabs padding-12 tab-color-blue background-blue"
        id="myTab4"
      >
        <li class="active">
          <a data-toggle="tab" href="#a4">A4</a>
        </li>

        <li>
          <a data-toggle="tab" href="#a5">A5</a>
        </li>

        <li>
          <a data-toggle="tab" href="#ticket">TICKET</a>
        </li>
      </ul>

      <div class="tab-content">
        <div id="a4" class="tab-pane in active">
          <div class="row" style="left: 0%; position: relative">
            <div class="col-md-12">
              <div class="second-row">
                <div class="tabbable">
                  <ul class="nav nav-tabs padding-16">
                    <li class="active">
                      <a data-toggle="tab" href="#dados_user">
                        <i
                          class="green ace-icon fa fa fa-id-card-o bigger-125"
                        ></i>
                        Parametro empresa
                      </a>
                    </li>
                  </ul>
                  <div class="tab-content profile-edit-tab-content">
                    <div id="dados_user" class="tab-pane in active">
                      <table class="table table-bordered">
                        <tbody>
                          <tr v-for="(modelofactura, i) in modelofacturas" :key="i">
                            <th scope="row" style="width: 70%">
                              {{ modelofactura.designacao }}
                            </th>
                            <td>
                              <a
                                :href="modelofactura.name_pdf"
                                title="Visualizar pdf"
                                target="_blanck"
                                class="
                                  btn btn-primary
                                  widget-box widget-color-blue
                                "
                                id="botoes"
                              >
                                <i class="fa fa-print text-default"></i>
                                Visualizar
                              </a>
                            </td>
                            <td>
                              <input
                                type="radio"
                                :value="modelofactura.id"
                                v-model="modeloactivo.id"
                                @click="selecionarModelo(modelofactura)"
                                name="radio"
                                class="form-control"
                              />
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
        </div>
      </div>
    </div>

    <!-- MODAL EDITAR DIAS VENCIMENTO FACTURAS -->
  </div>
  <!-- /.row -->
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";
import VueNumericInput from "vue-numeric-input";

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
    VueNumericInput,
  },
  props: ["modelofacturas", "modeloactivo", "guard"],
  data() {
    return {
      errors: [],
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

  mounted() {},
  methods: {
    selecionarModelo(modelo) {
      axios
        .post(`${this.router}/setar-modelo-documento`, modelo)
        .then((response) => {
          if (response.status === 200) {
            console.log("alterado o modelo");
            return;
          }
        })
        .catch((error) => {
          console.log(error);
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
