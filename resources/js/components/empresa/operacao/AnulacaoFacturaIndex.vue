<template>
  <div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
      <h1>
        Documentos Anulados
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
                  placeholder="Buscar por nome, nif do cliente e numeração Doc..."
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

      <div class="row">
        <form id="adimitirCandidatos" method="POST">
          <div class="col-xs-12 widget-box widget-color-green" style="left: 0%">
            <div class="clearfix">
              <a
                :href="router + '/facturas/anulacao/novo'"
                title="Adicionar novo formapagamento"
                class="btn btn-success widget-box widget-color-blue"
                id="botoes"
              >
                <i class="fa icofont-plus-circle"></i> Anular Facturas
              </a>
              <a
                :href="router + '/recibos/anulacao/novo'"
                title="Adicionar novo formapagamento"
                class="btn btn-success widget-box widget-color-blue"
                id="botoes"
              >
                <i class="fa icofont-plus-circle"></i> Anular Recibos
              </a>
              <!-- <a data-toggle="modal" @click.prevent="imprimir" title="Lista de bancos" target="_blanck" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a> -->
              <div class="pull-right tableTools-container"></div>
            </div>

            <div class="table-header widget-header">
              Todas facturas anuladas
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
                    <th class="">Cliente</th>
                    <th class="">Tipo Documento</th>
                    <th class="">Numeração Doc.</th>
                    <th class="">Descrição</th>
                    <th class="">Data anulação</th>
                    <th style="text-align: center">Retornou stock</th>
                    <th>Opções</th>
                  </tr>
                </thead>

                <tbody v-if="queryDocumentoAnuladosData.length">
                  <tr
                    v-for="docAnulados in queryDocumentoAnuladosData"
                    :key="docAnulados.id"
                  >
                    <td class="center">
                      <label class="pos-rel">
                        <input type="checkbox" class="ace" />
                        <span class="lbl"></span>
                      </label>
                    </td>

                    <td class="">{{ docAnulados.cliente.nome }}</td>
                    <td class="">
                      {{ docAnulados.tipo_documento.designacao }}
                    </td>
                    <td class="">{{ docAnulados.numeracaoDocumento }}</td>
                    <td class="">{{ docAnulados.descricao }}</td>
                    <td class="">
                      {{ docAnulados.created_at | formatDateTime }}
                    </td>
                    <td v-if="docAnulados.tipo_documento == '6'"></td>
                    <td v-else class="hidden-480" style="text-align: center">
                      <span
                        v-if="docAnulados.retornaStock == 'Sim'"
                        class="label label-sm label-success"
                        style="border-radius: 20px"
                        >{{ docAnulados.retornaStock }}</span
                      >
                      <span
                        v-else-if="
                          docAnulados.retornaStock == 'Não' &&
                          docAnulados.tipo_documento.id === 6
                        "
                        class="label label-sm label-warning"
                        style="border-radius: 20px"
                      ></span>
                      <span
                        v-else
                        class="label label-sm label-warning"
                        style="border-radius: 20px"
                        >{{ docAnulados.retornaStock }}</span
                      >
                    </td>

                    <td>
                      <div class="hidden-sm hidden-xs action-buttons">
                        <a
                          @click.prevent="printDocumentoAnulado(docAnulados)"
                          style="cursor: pointer"
                          class="pink"
                          title="Editar este registo"
                        >
                          <i
                            class="
                              ace-icon
                              fa fa-print
                              bigger-150
                              bolder
                              success
                              text-primary
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
    <!-- /.col -->
  </div>
  <!-- /.row -->
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";
import Swal from "sweetalert2";
import { showError, baseUrl } from "./../../../config/global";
import { mapState } from "vuex";

export default {
  props: ["datadocumentosanulados", "guard"],
  components: {
    Select2,
  },

  data() {
    return {
      searchQuery: "",
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
    imprimir() {
      this.$loading(true);
      // axios
      //     .get(
      //         `${this.router}/imprimir/bancos?status=` + this.filter.status_id, {
      //             responseType: "arraybuffer",
      //         }
      //     )
      //     .then((response) => {
      //         if (response.status === 200) {

      //             this.$loading(false)
      //             var file = new Blob([response.data], {
      //                 type: "application/pdf",
      //             });
      //             var fileURL = URL.createObjectURL(file);
      //             window.open(fileURL);
      //         } else {
      //             this.$loading(false)
      //             console.log("Erro ao carregar pdf");
      //         }
      //         //window.open("/empresa/imprimir/bancos?status=" + this.filter.status_id); //This will open Google in a new window.
      //     });
    },

    async printDocumentoAnulado(docAnulado) {
      this.$loading(true);

      try {
        const router =
          docAnulado.tipo_documento.id == 6
            ? `${this.router}/imprimirDocumentoAnuladoRecibos/${docAnulado.id}?viaImpressao=2`
            : `${this.router}/imprimirDocumentoAnuladoFacturas/${docAnulado.id}?viaImpressao=2`;

        let response = await axios.get(`${router}`, {
          responseType: "arraybuffer",
        });
        if (response.status === 200) {
          this.$loading(false);
          var file = new Blob([response.data], {
            type: "application/pdf",
          });
          var fileURL = URL.createObjectURL(file);
          window.open(fileURL);
          //document.location.reload(true)
        } else {
          this.$loading(false);
          console.log("Erro ao carregar pdf");
        }
      } catch (error) {
        console.log("ERRO API");
      }
    },
  },
  computed: {
    queryDocumentoAnuladosData() {
      if (this.searchQuery) {
        let result = this.datadocumentosanulados.filter((item) => {
          console.log(item);

          let searchQuery = this.searchQuery.toLowerCase();
          return (
            item.cliente.nome.toLowerCase().match(searchQuery) ||
            item.cliente.nif.toLowerCase().match(searchQuery)
          );
        });

        return result ? result : [];
      } else {
        return this.datadocumentosanulados;
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
