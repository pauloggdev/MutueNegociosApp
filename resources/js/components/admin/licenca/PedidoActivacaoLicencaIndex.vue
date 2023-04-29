<template>
  <div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
      <h1>
        Pedidos activação de licenças
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
                  placeholder="buscar pelo nome da empresa"
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
                Pedidos activação de licenças
              </div>

              <!-- div.dataTables_borderWrap -->
              <div>
                <table
                  class="table table-striped table-bordered table-hover"
                  :items="pedidosLicenca.data"
                >
                  <thead>
                    <tr>
                      <th>Empresa</th>
                      <th>NIF</th>
                      <th>Licença</th>
                      <th>Data pedido</th>
                      <th>Data activação</th>
                      <th>Data inicio</th>
                      <th>Data final</th>
                      <th>Status</th>
                      <th>Ações</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(pedido, i) in queryPedidosLicenca" :key="i">
                      <td>{{ pedido.empresa.nome }}</td>
                      <td>{{ pedido.empresa.nif }}</td>
                      <td>{{ pedido.licenca.designacao }}</td>
                      <td>{{ pedido.created_at | formatDate }}</td>
                      <td>{{ pedido.data_activacao | formatDate }}</td>
                      <td>{{ pedido.data_inicio | formatDate }}</td>
                      <td>{{ pedido.data_fim | formatDate }}</td>
                      <td class="hidden-480" style="text-align: center">
                        <span
                          v-if="pedido.status_licenca.id == 1"
                          class="label label-sm label-success"
                          style="border-radius: 20px"
                          >{{ pedido.status_licenca.designacao }}</span
                        >
                        <span
                          v-else-if="pedido.status_licenca.id == 3"
                          class="label label-sm label-warning"
                          style="border-radius: 20px"
                          >{{ pedido.status_licenca.designacao }}</span
                        >
                        <span
                          v-else
                          class="label label-sm label-danger"
                          style="border-radius: 20px"
                          >{{ pedido.status_licenca.designacao }}</span
                        >
                      </td>
                      <td>
                        <div class="hidden-sm hidden-xs action-buttons">
                          <a
                            href="#ver_detalhes"
                            data-toggle="modal"
                            @click.prevent="mostrarModalDetalhes(pedido)"
                            class="pink"
                            title="Editar este registo"
                          >
                            <i
                              class="
                                ace-icon
                                fa fa-eye
                                bigger-150
                                bolder
                                success
                                pink
                              "
                            ></i>
                          </a>
                          <template v-if="pedido.licenca_id != 1">
                            <a
                              v-if="pedido.status_licenca.id != 1"
                              data-toggle="modal"
                              title="Eliminar este Registro"
                              @click.prevent="activarPedidoLicenca(pedido)"
                              style="cursor: pointer"
                            >
                              <i
                                class="
                                  ace-icon
                                  fa fa-check
                                  bigger-150
                                  bolder
                                  success
                                  text-success
                                "
                              ></i>
                            </a>
                            <a
                              v-if="pedido.status_licenca.id != 2"
                              href="#modalRejeicao"
                              data-toggle="modal"
                              title="Eliminar este Registro"
                              @click.prevent="mostrarModalRejeitar(pedido)"
                              style="cursor: pointer"
                            >
                              <i
                                class="
                                  ace-icon
                                  fa fa-remove
                                  bigger-150
                                  bolder
                                  red2
                                "
                              ></i>
                            </a>
                          </template>

                          <a
                            data-toggle="modal"
                            title="Imprimir pedido licenca"
                            @click.prevent="imprimirPedidoLicenca(pedido)"
                            style="cursor: pointer"
                          >
                            <i
                              class="
                                ace-icon
                                fa fa-print
                                bigger-150
                                bolder
                                primary
                                blue
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
            <pagination
              :limit="3"
              :data="pedidosLicenca"
              @pagination-change-page="listarPedidoLicencas"
            >
              <span slot="prev-nav">&lt; Anterior</span>
              <span slot="next-nav">Próximo &gt;</span>
            </pagination>
          </form>
        </div>
      </div>
    </div>

    <!-- VER DETALHES  -->
    <div id="ver_detalhes" class="modal fade">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header text-center">
            <button type="button" class="close red bolder" data-dismiss="modal">
              ×
            </button>
            <h4 class="smaller">
              <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Ver
              mais detalhes do pagamento
            </h4>
          </div>
          <div class="modal-body">
            <div class="row" style="left: 0%; position: relative">
              <div class="col-md-12">
                <div class="search-form-text">
                  <div class="search-text">
                    <i class="fa fa-pencil"></i>
                    Detalhes do Pagamento
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-body">
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
                          Dados da empresa
                        </a>
                      </li>

                      <li>
                        <a data-toggle="tab" href="#dadoLicenca">
                          <i
                            class="green ace-icon fa fa fa-id-card-o bigger-125"
                          ></i>
                          Dados da Licença
                        </a>
                      </li>
                      <li>
                        <a data-toggle="tab" href="#dadosPgt">
                          <i
                            class="green ace-icon fa fa fa-id-card-o bigger-125"
                          ></i>
                          Dados do Pagamento
                        </a>
                      </li>
                    </ul>

                    <div class="tab-content profile-edit-tab-content">
                      <div id="dados_user" class="tab-pane in active">
                        <table class="table table-bordered">
                          <tbody>
                            <tr>
                              <th scope="row">Empresa</th>
                              <td>{{ pedidoDetalhes.empresa.nome }}</td>
                            </tr>
                            <tr>
                              <th scope="row">NIF</th>
                              <td>{{ pedidoDetalhes.empresa.nif }}</td>
                            </tr>
                            <tr>
                              <th scope="row">Email Empresa</th>
                              <td>{{ pedidoDetalhes.empresa.email }}</td>
                            </tr>
                            <tr>
                              <th scope="row">Endereço</th>
                              <td>{{ pedidoDetalhes.empresa.endereco }}</td>
                            </tr>
                            <tr>
                              <th scope="row">web site</th>
                              <td>
                                <a href="" target="_blank">{{
                                  pedidoDetalhes.empresa.Website
                                }}</a>
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Contato</th>
                              <td>
                                {{ pedidoDetalhes.empresa.pessoal_Contacto }}
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Logotipo</th>
                              <td>
                                <img
                                  style="width: 150px"
                                  v-if="
                                    Object.values(pedidoDetalhes.empresa).length
                                  "
                                  class="img-fluid"
                                  :src="
                                    '/upload/' + pedidoDetalhes.empresa.logotipo
                                  "
                                  alt=""
                                />
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div id="dadoLicenca" class="tab-pane">
                        <table class="table table-bordered">
                          <tbody>
                            <tr>
                              <th scope="row">Nome da Licença</th>
                              <td>{{ pedidoDetalhes.licenca.designacao }}</td>
                            </tr>

                            <tr>
                              <th scope="row">Valor da licença</th>
                              <td>
                                {{
                                  (pedidoDetalhes.licenca.valor
                                    ? pedidoDetalhes.licenca.valor
                                    : 0) | currency
                                }}
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Limite utilizadores</th>
                              <td>
                                {{
                                  (pedidoDetalhes.licenca.limite_usuario
                                    ? pedidoDetalhes.licenca.limite_usuario
                                    : 0) | formatQt
                                }}
                              </td>
                            </tr>
                            <tr v-if="pedidoDetalhes.pagamento">
                              <th scope="row">Quantidade Licença paga</th>
                              <td>
                                {{
                                  (pedidoDetalhes.pagamento.quantidade
                                    ? pedidoDetalhes.pagamento.quantidade
                                    : 0) | formatQt
                                }}
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <div id="dadosPgt" class="tab-pane">
                        <table class="table table-bordered">
                          <tbody v-if="pedidoDetalhes.pagamento">
                            <tr>
                              <th scope="row">Número Operação bancaria</th>
                              <td>
                                {{
                                  pedidoDetalhes.pagamento
                                    .numero_operacao_bancaria
                                }}
                              </td>
                            </tr>
                            
                            <tr>
                              <th scope="row">Banco</th>
                              <td>
                                {{
                                  pedidoDetalhes.pagamento.conta_movimento.sigla
                                }}
                                
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">IBAN</th>
                              <td v-if="pedidoDetalhes.pagamento.conta_movimento.coordernada_bancaria">
                                {{
                                  pedidoDetalhes.pagamento.conta_movimento.coordernada_bancaria.iban
                                }}
                                
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Valor depositado</th>
                              <td>
                                {{
                                  (pedidoDetalhes.pagamento.totalPago
                                    ? pedidoDetalhes.pagamento.totalPago
                                    : 0) | currency
                                }}
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Forma Pagamento</th>
                              <td>
                                {{
                                  pedidoDetalhes.pagamento.forma_pagamento
                                    .descricao
                                }}
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Data Pagamento no banco</th>
                              <td>
                                {{
                                  (pedidoDetalhes.pagamento.data_pago_banco
                                    ? pedidoDetalhes.pagamento.data_pago_banco
                                    : "") | formatDate
                                }}
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Ref. da factura paga</th>
                              <td>
                                {{
                                  pedidoDetalhes.pagamento.factura
                                    .faturaReference
                                }}
                              </td>
                            </tr>
                            <tr>
                              <th scope="row">Comprovativo bancario</th>
                              <td>
                                <a
                                  :href="
                                    '/upload/' +
                                    pedidoDetalhes.pagamento
                                      .comprovativo_bancario
                                  "
                                  target="_blank"
                                  id="comprovativoBancario"
                                  >ver comprovativo bancario</a
                                >
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
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>

     <div id="modalRejeicao" class="modal fade">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header text-center">
            <button type="button" class="close red bolder" data-dismiss="modal">
              ×
            </button>
            <h4 class="smaller">
              <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Motivo
              da rejeição da pedido de licença
            </h4>
          </div>
          <div class="modal-body">
            <div class="row" style="left: 0%; position: relative">
              <div class="col-md-12">
                <div class="form-group has-info">
                  <div class="col-md-12">
                    <label class="control-label" for="designacao">
                      Descrição
                      <span
                        class="tooltip-target"
                        data-toggle="tooltip"
                        data-placement="top"
                      >
                        <i class="fa fa-question-circle bold text-danger"></i>
                      </span>
                    </label>
                    <div class>
                      <textarea
                        name=""
                        v-model="dataRejeitacao.observacao"
                        id=""
                        class="col-md-12 col-xs-12 col-sm-4"
                        cols="30"
                        rows="10"
                      ></textarea>
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
                  style="border-radius: 10px"
                  @click.prevent="rejeitarPedido"
                >
                  <i class="ace-icon fa fa-remove bigger-110"></i>
                  Rejeitar Pedido de ativação Licença
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div>
</template>

<script>
import Swal from "sweetalert2";
import pagination from "laravel-vue-pagination";

export default {
  props: [],
  components: {
    pagination,
  },
  name: "facturas",

  data() {
    return {
      searchQuery: "",
      router: window.location.origin,
      pedidosLicenca: {},
      dataRejeitacao: {},
      pedidoDetalhes: {
        empresa: {},
        licenca: {},
        pagamento: {
          conta_movimento: {},
          coordernada_bancaria: {},
          numero_operacao_bancaria: "",
          forma_pagamento: {},
          factura: {},
        },
      },
    };
  },

  created() {},

  mounted() {
    this.listarPedidoLicencas();
  },
  computed: {
    queryPedidosLicenca() {
      if (this.searchQuery) {
        let result = this.pedidosLicenca.data.filter((item) => {
          return item.empresa.nome
            .toLowerCase()
            .match(this.searchQuery.toLowerCase());
        });
        return result ? result : [];
      } else {
        return this.pedidosLicenca.data;
      }
    },
  },

  methods: {
    async listarPedidoLicencas(page = 1) {
      try {
        let response = await axios.get(
          this.router + "/admin/listarPedidoLicencas?page=" + page
        );

        console.log(response);
        if (response.status == 200) {
          this.pedidosLicenca = response.data;
        }
      } catch (error) {
        console.log("Erro ao listar pedido licenças");
      }
    },
     rejeitarPedido() {
      if (!this.dataRejeitacao.observacao.trim()) {
        this.$toasted.global.defaultError({
          msg: "Informe o motivo da rejeição do pedido",
        });
        return;
      }

      axios
        .post(
          `${this.router}/admin/cancelar-licenca/${this.dataRejeitacao.licenca_id}`,
          this.dataRejeitacao
        )
        .then((res) => {
          if (res.status == 200) {
            Swal.fire({
              title: "Aviso",
              text: `Pedido activação de licença negado!`,
              icon: "warning",
              confirmButtonColor: "#3d5476",
              confirmButtonText: "Ok",
              onClose: () => {
                document.location.reload(true);
              },
            });
          }
        })
        .catch((error) => {
          this.$toasted.global.defaultError({
            msg: "Erro ao activar pedido licença",
          });
        });
    },
    mostrarModalRejeitar(pedido) {
      this.dataRejeitacao = {
        licenca_id: pedido.id,
        observacao: "",
      };
    },
    mostrarModalDetalhes(pedido) {
      this.pedidoDetalhes = {
        empresa: {},
        licenca: {},
        pagamento: {
          conta_movimento: {},
          coordernada_bancaria: {},
          forma_pagamento: {},
          factura: {},
        },
      };
      this.pedidoDetalhes = Object.assign({}, pedido);
    },
    activarPedidoLicenca(pedido) {
      Swal.fire({
        title: "Deseja activar o pedido de Licença?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ok",
      }).then((result) => {
        if (result.value) {
          axios
            .post(`${this.router}/admin/ativar-licenca/${pedido.id}`)
            .then((res) => {
              if (res.status == 200) {
                this.$toasted.global.defaultSuccess();

                Swal.fire({
                  title: "Sucesso",
                  text: `Licenca ${pedido.licenca.designacao} activo com sucesso!`,
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
              this.$toasted.global.defaultError({
                msg: "Erro ao activar pedido licença",
              });
            });
        }
      });
    },
    async imprimirPedidoLicenca(pedido) {
      this.$loading(true);
      try {
        let response = await axios
          .get(`${this.router}/imprimirPedidoLicenca/${pedido.id}`, {
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
          });
      } catch (error) {
        this.$loading(false);
        console.log("Erro ao carregar pdf");
      }
    },
  },
};
</script>

<style scoped>
</style>
