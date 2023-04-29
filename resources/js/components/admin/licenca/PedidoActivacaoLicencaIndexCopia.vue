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
    <!-- /.page-header -->

    <div class="col-xs-12">
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
                  required
                  autocomplete="on"
                  v-model="searchQuery"
                  class="form-control search-query"
                  placeholder="Buscar Por nome da empresa e nif..."
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
          <div
            class="form-group has-info bold"
            style="left: 0%; position: relative"
          >
            <div class="col-md-3">
              <label class="control-label bold label-select2" for="designacao"
                >Data de inicio<b class="red fa fa-question-circle"></b
              ></label>
              <div class="input-group">
                <input
                  type="date"
                  v-model="filterData.data_inicio"
                  id="designacao"
                  class="col-md-12 col-xs-12 col-sm-4"
                />
              </div>
            </div>
            <div class="col-md-3">
              <label class="control-label bold label-select2" for="designacao"
                >Data de fim<b class="red fa fa-question-circle"></b
              ></label>
              <div class="input-group">
                <input
                  type="date"
                  v-model="filterData.data_fim"
                  id="designacao"
                  class="col-md-12 col-xs-12 col-sm-4"
                />
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
                  data-toggle="modal"
                  href="#modalFiltrarPedido"
                  @click="mostrarModalFiltro"
                  title="Lista de bancos"
                  target="_blanck"
                  class="btn btn-primary widget-box widget-color-blue"
                  id="botoes"
                >
                  <i class="fa fa-print text-default"></i> Imprimir
                </a>

                <div class="dt-buttons btn-overlap btn-group pull-right">
                  <a
                    class="
                      dt-button
                      buttons-collection buttons-colvis
                      btn btn-white btn-primary btn-bold
                    "
                    tabindex="0"
                    aria-controls="dynamic-table"
                  >
                    <span>
                      <i class="fa fa-search bigger-110 text-primary"></i>
                      <span class="hidden">Mostrar/Ocultar Colunas</span>
                    </span>
                  </a>
                  <a
                    class="
                      dt-button
                      buttons-copy buttons-html5
                      btn btn-white btn-primary btn-bold
                    "
                    tabindex="0"
                    aria-controls="dynamic-table"
                  >
                    <span>
                      <i class="fa fa-copy bigger-110 text-pink"></i>
                      <span class="hidden">Copiar para uma tabela</span>
                    </span>
                  </a>
                  <a
                    class="
                      dt-button
                      buttons-csv buttons-html5
                      btn btn-white btn-primary btn-bold
                    "
                    tabindex="0"
                    aria-controls="dynamic-table"
                  >
                    <span>
                      <i
                        class="fa fa-database bigger-110 text-orange"
                        style="color: orange"
                      ></i>
                      <span class="hidden">Exportar para CSV</span>
                    </span>
                  </a>
                  <a
                    class="
                      dt-button
                      buttons-print
                      btn btn-white btn-primary btn-bold
                    "
                    tabindex="0"
                    aria-controls="dynamic-table"
                    href="#modalFiltrarClientes"
                    data-toggle="modal"
                  >
                    <span
                      ><i class="fa fa-print bigger-110 text-default"></i>
                      <span class="hidden">Imprimir toda Tabela</span>
                    </span>
                  </a>
                </div>
                <!-- <div class="pull-right tableTools-container"></div> -->
              </div>

              <div class="table-header widget-header">
                Todos Pedidos activação de licenças
              </div>

              <!-- div.dataTables_borderWrap -->
              <div>
                <table
                  id="dynamic-table"
                  class="tabela1 table table-striped table-bordered table-hover"
                >
                  <thead>
                    <tr>
                      <th>#</th>
                      <th style="width: 170px">Nome da Empresa</th>
                      <th>NIF da Empresa</th>
                      <th>Licença</th>
                      <th>Data Pedido</th>
                      <th>Data Activação</th>
                      <th>Data Inicio</th>
                      <th>Data Final</th>
                      <th>Status</th>
                      <th>Opções</th>
                    </tr>
                  </thead>

                  <tbody>
                    <tr v-for="(pedidos, i) in queryPedidoAtivacao" :key="i">
                      <td>{{ pedidos.id }}</td>
                      <td style="width: 170px">{{ pedidos.empresa.nome }}</td>
                      <td>{{ pedidos.empresa.nif }}</td>
                      <td>{{ pedidos.licenca.designacao }}</td>
                      <td>{{ pedidos.created_at | formatDate }}</td>
                      <td>{{ pedidos.data_activacao | formatDate }}</td>
                      <td>{{ pedidos.data_inicio | formatDate }}</td>
                      <td>{{ pedidos.data_fim | formatDate }}</td>
                      <td class="hidden-480" style="text-align: center">
                        <span
                          v-if="pedidos.status_licenca.id == 1"
                          class="label label-sm label-success"
                          style="border-radius: 20px"
                          >{{ pedidos.status_licenca.designacao }}</span
                        >
                        <span
                          v-else-if="pedidos.status_licenca.id == 3"
                          class="label label-sm label-warning"
                          style="border-radius: 20px"
                          >{{ pedidos.status_licenca.designacao }}</span
                        >
                        <span
                          v-else
                          class="label label-sm label-danger"
                          style="border-radius: 20px"
                          >{{ pedidos.status_licenca.designacao }}</span
                        >
                      </td>
                      <td>
                        <div class="hidden-sm hidden-xs action-buttons">
                          <a
                            href="#ver_detalhes"
                            data-toggle="modal"
                            @click.prevent="mostrarModalDetalhes(pedidos)"
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
                          <template v-if="pedidos.licenca_id != 1">
                            <a
                              v-if="pedidos.status_licenca.id != 1"
                              data-toggle="modal"
                              title="Eliminar este Registro"
                              @click.prevent="activarPedidoLicenca(pedidos)"
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
                              v-if="pedidos.status_licenca.id != 2"
                              href="#modalRejeicao"
                              data-toggle="modal"
                              title="Eliminar este Registro"
                              @click.prevent="mostrarModalRejeitar(pedidos)"
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
                            @click.prevent="imprimirPedidoLicenca(pedidos)"
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
                          <!-- <a href="#modalStatusPedidoLicenca" data-toggle="modal" class="pink" @click.prevent="mostrarModalAtivacaoLicenca(pedidos)" title="mudar status do pedido licença">
                                                    <i class="ace-icon fa fa-check bigger-150 bolder success text-success"></i>
                                                </a> -->
                          <!--
                                                <a data-toggle="modal" title="Eliminar este Registro" @click.prevent="deletarFornecedor(pedidos)" style="cursor:pointer;">
                                                    <i class="ace-icon fa fa-trash-o bigger-150 bolder danger red"></i>
                                                </a> -->
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
                              <th scope="row">Nome empresa</th>
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

    <!-- MODAL FILTRAR PEDIDO  -->
    <div
      v-if="statusOptions.length"
      class="modal fade"
      id="modalFiltrarPedido"
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
                    @click.prevent="imprimirEmpresaLicencas"
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
</template>

<script>
import Select2 from "v-select2-component";
import DatePick from "vue-date-pick";
import Swal from "sweetalert2";

import { baseUrl, showError } from "../../../config/global";
export default {
  components: {
    Select2,
    DatePick,
  },
  props: ["ativacaolicencas"],

  data() {
    return {
      searchQuery: "",
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
      filterData: {},
      statusOptions: "",
      filter: {},
      dataRejeitacao: {},
      observacao: "",
      status_licenca_id: "",

      statusAtivacao: [
        {
          id: 1,
          text: "ACTIVAR",
        },
        {
          id: 2,
          text: "REJEITAR",
        },
      ],
      router: "",
    };
  },
  created() {
    this.router = window.location.origin + `/admin`;
    this.status_licenca_id = this.statusAtivacao[0].id; //usar como padrão o status
    // console.log(this.ativacaolicencas);
  },
  computed: {
    queryPedidoAtivacao() {
      if (this.filterData.data_inicio && this.filterData.data_fim) {
        let result = this.ativacaolicencas.filter((ativacao) => {
          return (
            this.filterData.data_inicio <=
              this.formatData(ativacao.created_at) &&
            this.formatData(ativacao.created_at) <= this.filterData.data_fim
          );
        });
        return result ? result : [];
      }
      if (this.searchQuery) {
        let result = this.ativacaolicencas.filter((item) => {
          let searchQuery = this.searchQuery.toLowerCase();
          return (
            item.empresa.nome.toLowerCase().match(searchQuery) ||
            item.empresa.nif.toLowerCase().match(searchQuery) ||
            item.empresa.email.toLowerCase().match(searchQuery)
          );
        });
        return result ? result : [];
      } else {
        return this.ativacaolicencas;
      }
    },
  },

  methods: {
    formatData(value) {
      if (value) {
        return moment(String(value)).format("YYYY-MM-DD");
      }
    },
    mostrarModalFiltro() {
      this.statusOptions = [
        {
          id: 1,
          text: "Activo",
        },
        {
          id: 2,
          text: "Rejeitado",
        },
        {
          id: 3,
          text: "Pendente",
        },
      ];

      this.filter.status_id = this.statusOptions[0].id;
    },

    async imprimirEmpresaLicencas() {
      this.$loading(true);

      try {
        let response = await axios.get(
          `/admin/imprimirTodasPedidosLicencas?filter=${this.filter.status_id}`,
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
        } else {
          this.$loading(false);
          console.log("Erro ao carregar pdf");
        }
      } catch (error) {
        this.$loading(false);
        console.log("Erro ao carregar pdf");
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
          `${this.router}/cancelar-licenca/${this.dataRejeitacao.licenca_id}`,
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
            .post(`${this.router}/ativar-licenca/${pedido.id}`)
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

<style>
#comprovativoBancario {
  color: #337ab7;
  text-decoration: underline;
}
</style>
