<template>
  <div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
      <h1>
        Vendas Mensal
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
                type="month"
                id="dataInicial"
                v-model="filterData.data_inicio"
                style="width: 250px"
              />
            </div>
            <div class="col-md-4">
              <label for="dataFinal"><strong>Data Final</strong></label
              ><br />
              <input
                type="month"
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

              <div class="table-header widget-header">Vendas Mensal</div>

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
                        {{ factura.mes }}/{{ factura.ano }}
                      </td>

                      <td>
                        <div class="hidden-sm hidden-xs action-buttons">
                          <!-- <a
                            :href="
                              baseUrl +
                              '/empresa/facturas-mensalImprimir?mes=' +
                              factura.mes +
                              '&ano=' +
                              factura.ano
                            " target="_blank"
                            class="blue"
                            style="cursor: pointer"
                          >
                            <i class="fa fa-print bigger-150 text-default"></i>
                          </a> -->

                          <a
                            class="blue"
                            style="cursor: pointer"
                            @click.prevent="
                              mostrarRelatorioMensal(factura.mes, factura.ano)
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
  props:['facturas'],
  data() {
    return {
     //facturas: [],
      filterData:{},
      searchQuery: "",
      searchMonthYear: "",
      baseUrl: window.origin,
      date_criada: "",
    };
  },

  computed: {
queryFacturas() {

  if ((this.filterData.data_inicio && this.filterData.data_fim) 
  
  || this.filterData.data_fim && this.filterData.data_inicio) {
        var startDate = moment(String(this.filterData.data_inicio)).format("YYYY-MM")
        var endDate = moment(String(this.filterData.data_fim)).format("YYYY-MM")

        var startDate = new Date(startDate);
        var endDate = new Date(endDate);

        var result = this.facturas.filter(function (factura) {
            
            let data = factura.ano+'-'+factura.mes;
            var date = new Date(data);

          return date >= startDate && date <= endDate;
        });
        return result ? result : [];
      } else {
        return this.facturas;
      }
    },






    // queryFacturas() {
    //   if (this.searchMonthYear) {
    //     let result = this.facturas.filter((item) => {
    //       return moment(String(item.data_criada))
    //         .format("DD-MM-YYYY")
    //         .match(this.date_criada);
    //     });

    //     return result ? result : [];
    //   } else {
    //     return this.facturas;
    //   }
    // },
  },
  mounted() {
    //this.historioMensalFacturacao();

    //this.current_date = this.current_date();
  },

  // watch:{
  //     date_criada(){
  //         console.log(this.date_criada)
  //     }
  // },

  methods: {

    formatData(value) {
      if (value) {
        return moment(String(value)).format("YYYY-MM");
      }
    },
    // current_date() {
    //   var today = new Date();
    //   var dd = String(today.getDate()).padStart(2, "0");
    //   var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
    //   var yyyy = today.getFullYear();

    //   today = mm + "-" + yyyy;

    //   return today;
    // },

    // async historioMensalFacturacao() {
    //   try {
    //     let response = await axios.get(`${baseUrl}/empresa/facturas-mensal`);

    //     if (response.status === 200) {
    //       response.data.forEach((element) => {
    //         this.facturas.push({
    //           total_desconto: element.total_desconto,
    //           total_factura: element.total_factura,
    //           total_iva: element.total_iva,
    //           total_troco: element.total_troco,
    //           total_entregue: element.total_entregue,
    //           mesAno: element.mes + "-" + element.ano,
    //           mes: element.mes,
    //           ano: element.ano,
    //         });
    //       });
    //     }
    //   } catch (error) {
    //     console.log("Erro API");
    //   }
    // },

    async mostrarRelatorioMensal(mes, ano) {
      this.$loading(true);
      try {
        let response = await axios.get(
          `${baseUrl}/empresa/facturas-mensalImprimir?mes=${mes}&ano=${ano}`,
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
