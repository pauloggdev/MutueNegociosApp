<template>
  <div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
      <h1>
        Vendas diaria
        <small>
          <i class="ace-icon fa fa-angle-double-right"></i>
          Listagem
        </small>
      </h1>
    </div>

    <div class="col-md-12">
      <div style="margin-bottom: 15px">
        <form class="form-search" method="get" action>
          <div class="row">
            <div class="col-md-4">
              <label for="dataInicial"><strong>Data Inicial</strong></label
              ><br />
              <input
                type="date"
                id="dataInicial"
                v-model="filterData.data_inicio"
                style="width: 250px"
              />
            </div>
            <div class="col-md-4">
              <label for="dataFinal"><strong>Data Final</strong></label
              ><br />
              <input
                type="date"
                v-model="filterData.data_fim"
                id="dataFinal"
                style="width: 250px"
              />
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
                <div class="pull-right tableTools-container"></div>
              </div>

              <div class="table-header widget-header">Vendas diaria</div>

              <!-- div.dataTables_borderWrap -->
              <div>
                <table
                  id="dynamic-table"
                  class="tabela1 table table-striped table-bordered table-hover"
                >
                  <thead>
                    <tr>
                      <th>Nº</th>
                      <th style="text-align: right">Total factura</th>
                      <th style="text-align: right">Total desconto</th>
                      <th style="text-align: right">Total IVA</th>
                      <th style="text-align: right">Total troco</th>
                      <th style="text-align: right">Total Entregue</th>
                      <th>Data</th>
                      <th>Ações</th>
                    </tr>
                  </thead>

                  <tbody v-if="facturas.length">
                    <tr
                      v-for="(factura, idx) in queryFacturas"
                      :key="factura.id"
                    >
                      <td style="text-align: center">{{ idx + 1 }}</td>
                      <td style="text-align: right">
                        {{ factura.total_factura | currency }}
                      </td>
                      <td style="text-align: right">
                        {{ factura.total_desconto | currency }}
                      </td>
                      <td style="text-align: right">
                        {{ factura.total_iva | currency }}
                      </td>
                      <td style="text-align: right">
                        {{ factura.total_troco | currency }}
                      </td>
                      <td style="text-align: right">
                        {{ factura.total_entregue | currency }}
                      </td>
                      <td>
                        {{ factura.data_criada | formatDate }}
                       
                      </td>

                      <td>
                        <div class="hidden-sm hidden-xs action-buttons">
                          <a
                            class="blue"
                            style="cursor: pointer"
                            @click.prevent="
                              mostrarRelatorioDiario(factura.data_criada)
                            "
                          >
                            <i class="fa fa-print bigger-150 text-default"></i>
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
    </div>
  </div>
  <!-- /.row -->
</template>

<script>
import axios from "axios";
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import { showError, baseUrl } from "./../../../config/global";
import { mapState } from "vuex";
import Select2 from "v-select2-component";

export default {
  components: {
    Select2,
    DatePicker,
  },
  props: ["produtos", "status", "facturas"],
  data() {
    return {
      //facturas: [],
      searchQuery: "",
      date_criada: "",
      filterData: {},
      baseUrl: window.origin,

      produto: {},
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
    };
  },

  computed: {
    queryFacturas() {

  if ((this.filterData.data_inicio && this.filterData.data_fim) 
  
  || this.filterData.data_fim && this.filterData.data_inicio) {
        var startDate = new Date(this.filterData.data_inicio);
        var endDate = new Date(this.filterData.data_fim);

        var result = this.facturas.filter(function (factura) {
          var date = new Date(factura.data_criada);
          return date >= startDate && date <= endDate;
        });
        return result ? result : [];
      } else {
        return this.facturas;
      }
    },
  },
  mounted() {
    //console.log(this.facturas);exit;
    // this.historioDiarioFacturacao();
  },
  // watch:{
  //     date_criada(){
  //         console.log(this.date_criada)
  //     }
  // },

  methods: {
    
    formatData(value) {
      if (value) {
        return moment(String(value)).format("YYYY-MM-DD");
      }
    },

    async historioDiarioFacturacao() {
      try {
        let response = await axios.get(`${baseUrl}/empresa/facturacao-diaria`);

        if (response.status === 200) {
          this.facturas = response.data;
        }
      } catch (error) {
        console.log("Erro API");
      }
    },

    // imprimir usando ireport
    async mostrarRelatorioDiario(data) {
      this.$loading(true);
      try {
        let response = await axios.get(
          `${baseUrl}/empresa/facturacao-diaria/${data}`,
          {
            responseType: "arraybuffer",
          }
        );

        if (response.status === 200) {
          this.$loading(false);
          var file = new Blob([response.data], {
            type: "application/pdf",
          });
          var fileURL = URL.createObjectURL(file);
          window.open(fileURL);
        }
      } catch (error) {
        this.$loading(false);
        console.log("Erro ao carregar pdf");
      }

      // console.log(produto)
    },
  },
};
</script>

<style scoped>
#filter {
  margin-bottom: 15px;
}

.box-content {
  background: rgb(236, 241, 247);
  padding: 20px;
  height: 100%;
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
