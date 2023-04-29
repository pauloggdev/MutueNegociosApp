<template>
  <div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
      <h1>
        FACTURAS
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
                  name="query"
                  v-model="searchQuery"
                  required
                  autocomplete="on"
                  class="form-control search-query"
                  placeholder="Buscar Por nome, tipo de documento e numeração da factura"
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
              <div class="table-header widget-header">
                Todas facturas do Sistema
              </div>

              <!-- div.dataTables_borderWrap -->
              <div>
                <table
                  class="table table-striped table-bordered table-hover"
                  :items="facturas.data"
                >
                  <thead>
                    <tr>
                      <th>Codigo</th>
                      <th>Cliente</th>
                      <th>Tel.</th>
                      <th style="text-align: right">Total Factura</th>
                      <th style="text-align: right">Valor a Pagar</th>
                      <th>Tipo Documento</th>
                      <th>Numeração</th>
                      <th>Emitido</th>
                      <th style="text-align: center">Anulado</th>
                      <th style="text-align: center">Retificado</th>
                      <th>Pago</th>
                      <th>Ações</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="factura in queryFacturas" :key="factura.id">
                      <td>{{ factura.id }}</td>
                      <td>{{ factura.nome_do_cliente }}</td>
                      <td>{{ factura.telefone_cliente }}</td>
                      <td style="text-align: right">
                        {{ factura.total_preco_factura | currency }}
                      </td>
                      <td style="text-align: right">
                        {{ factura.valor_a_pagar | currency }}
                      </td>
                      <td>{{ factura.tipo_documento.designacao }}</td>
                      <td>{{ factura.numeracaoFactura }}</td>
                      <td>{{ factura.created_at | formatDate }}</td>

                      <td class="hidden-480" style="text-align: center">
                        <span
                          class="label label-sm"
                          :class="
                            factura.anulado == 1
                              ? 'label-success'
                              : 'label-danger'
                          "
                          >{{ factura.anulado == 1 ? "Não" : "Sim" }}</span
                        >
                      </td>
                      <td class="hidden-480" style="text-align: center">
                        <span
                          class="label label-sm"
                          :class="
                            factura.retificado == 'Sim'
                              ? 'label-danger'
                              : 'label-success'
                          "
                          >{{ factura.retificado }}</span
                        >
                      </td>
                      <td class="hidden-480">
                        <span
                          class="label label-sm"
                          :class="
                            factura.statusFactura == 1
                              ? 'label-danger'
                              : 'label-success'
                          "
                          >{{
                            factura.statusFactura == 1 ? "Não" : "Sim"
                          }}</span
                        >
                      </td>

                      <td>
                        <a
                          class="blue"
                          @click.prevent="ImprimirFactura(factura)"
                          title="Reimprimir factura"
                          style="cursor: pointer"
                        >
                          <i class="ace-icon fa fa-print bigger-160"></i>
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <pagination
              :limit="3"
              :data="facturas"
              @pagination-change-page="listarFacturas"
            >
              <span slot="prev-nav">&lt; Anterior</span>
              <span slot="next-nav">Próximo &gt;</span>
            </pagination>
            <!-- /.col-xs-12 -->
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->
</template>

<script>
import Swal from "sweetalert2";
import pagination from "laravel-vue-pagination";

export default {
  props: ["guard", "status", "tipoempressao"],
  components: {
    pagination,
  },
  name: "facturas",

  data() {
    return {
      searchQuery: "",
      facturas: {},
      /**
       * constantes usados
       */
      USUARIO_EMPRESA: 2,
      USUARIO_FUNCIONARIO: 3,
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
    this.listarFacturas();
    // Fetch initial results
  },
  computed: {
    queryFacturas() {
      if (this.searchQuery) {
        let result = this.facturas.data.filter((item) => {
          return (
            item.nome_do_cliente
              .toLowerCase()
              .match(this.searchQuery.toLowerCase()) ||
            item.numeracaoFactura.match(this.searchQuery) ||
            item.tipo_documento.designacao
              .toLowerCase()
              .match(this.searchQuery.toLowerCase())
          );
        });
        return result ? result : [];
      } else {
        return this.facturas.data;
      }
    },
  },

  methods: {
    async listarFacturas(page = 1) {
      try {
        let response = await axios.get(
          this.router + "/listarFacturas?page=" + page
        );
        if (response.status == 200) {
          this.facturas = response.data;
        }
      } catch (error) {}
    },

    /*
        ImprimirFactura(id) {
                            
                Swal.fire({
                    title: 'Deseja Reimprimir a factura?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ok'
                }).then((result) => {
                    if (result.value) {
                        window.open(`${this.router}/facturacao/imprimir-factura/${id}`);

                    }
                })
            
        }
        */
    async ImprimirFactura(factura) {
      this.$loading(true);

      if (this.tipoempressao.valor !== "A4") {
        window.location.href = `/reimprimirFactura?facturaId=${factura.id}`;
        return;
      }

      if (factura.anulado == 2) {
        var response = await axios.get(
          `${this.router}/factura/imprimir-factura-anulada/${factura.id}`,
          {
            responseType: "arraybuffer",
          }
        );
      } else {
        var response = await axios.get(
          `${this.router}/facturacao/imprimir-factura/${factura.id}?viaImpressao=2`,
          {
            responseType: "arraybuffer",
          }
        );
      }

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
    },
  },
  // computed: {

  //     queryFacturas() {
  //         if (this.searchQuery) {
  //             let searchQuery = this.searchQuery.toLowerCase();
  //             let result = this.facturas.filter(item => {
  //                 return item.nome_do_cliente.toLowerCase().match(searchQuery) ||
  //                     item.nif_cliente.toLowerCase().match(searchQuery) ||
  //                     item.telefone_cliente.toLowerCase().match(searchQuery) ||
  //                     item.numeracaoFactura.toLowerCase().match(searchQuery) ||
  //                     item.tipo_documento.designacao.toLowerCase().match(searchQuery)

  //             });
  //             return result ? result : []
  //         } else {
  //             return this.facturas
  //         }
  //     }
  // },
};
</script>

<style scoped>
</style>
