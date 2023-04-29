<template>
  <div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
      <h1>
        ASSINATURA
        <small>
          <i class="ace-icon fa fa-angle-double-right"></i>
          Activação
        </small>
      </h1>
    </div>
    <!-- /.page-header -->

    <div class="row">
      <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="clearfix">
          <div class="pull-right">
            <span class="green middle bolder">Escolha a operação: &nbsp;</span>

            <div class="btn-toolbar inline middle no-margin">
              <div id="toggle-result-page" data-toggle="buttons" class="btn-group no-margin">
                <label class="btn btn-sm btn-pink btn-xs active">
                  <i class="ace-icon glyphicon glyphicon-barcode bigger-130 bold"></i>
                  <span class="bigger-130 bold">SOLICITAR FACTURA</span>
                  <input type="radio" value="1" />
                </label>

                <label class="btn btn-sm btn-purple btn-xs">
                  <i class="ace-icon fa fa-money bigger-150 bold"></i>
                  <span class="bigger-130 bold">PAGAR LICENÇA</span>
                  <input type="radio" value="2" />
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div>
      <div class="row search-page" id="search-page-1">
        <div class="col-xs-12">
          <!-- PAGE CONTENT BEGINS -->

          <div class="space-24"></div>
          <div class="row">
            <div class="col-xs-4 col-sm-3 pricing-span-header">
              <div class="widget-box transparent">
                <div class="widget-header">
                  <h5 class="widget-title bigger lighter">
                    Informações adicionais
                  </h5>
                </div>

                <div class="widget-body">
                  <div class="widget-main no-padding">
                    <ul class="list-unstyled list-striped pricing-table-header">
                      <li>Facturas ilimitadas</li>
                      <li>Clientes ilimitadas</li>
                      <li>Dominio Grátis</li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xs-8 col-sm-9 pricing-span-body">
              <div
                class="pricing-span"
                v-for="(data, i) in licencas"
                :key="i"
                style="margin-right: 10px"
              >
                <div class="widget-box pricing-box-small widget-color-red3">
                  <div class="widget-header">
                    <h5 class="widget-title bigger lighter">
                      {{ data.licenca.designacao }}
                    </h5>
                  </div>

                  <div class="widget-body">
                    <div class="widget-main no-padding">
                      <ul class="list-unstyled list-striped pricing-table">
                        <li v-if="data.licenca.tipo_licenca_id == 1">
                          Armazenamento limitado
                        </li>
                        <li v-else>Armazenamento ilimitado</li>
                        <li>Acesso aplicativo</li>
                        <li>{{ data.licenca.limite_usuario | formatQt }}
                          Utilizadores
                        </li>
                        <li>Exportação do ficheiro SAFT</li>
                        <li>Facturação em Backoffice</li>
                        <li>Capacidade ilimitada</li>
                        <li>Acesso App</li>
                        <li v-if="data.licenca.tipo_licenca_id == 1">
                          <i class="ace-icon fa fa-times red"></i>
                        </li>
                        <li v-else>
                          <i class="ace-icon fa fa-check green"></i>
                        </li>
                      </ul>

                      <div class="price">
                        <span
                          class="
                            label label-lg label-inverse
                            arrowed-in arrowed-in-right
                          "
                        >
                          {{ data.valor | currency }} /
                          <small>{{ data.licenca.designacao }}</small>
                        </span>
                      </div>
                    </div>

                    <div v-if="data.licenca.tipo_licenca_id != 1">
                      <a
                        href="#imprimirFactura"
                        data-toggle="modal"
                        class="btn btn-block btn-sm btn-danger"
                        @click.prevent="modalEfectuarPagamento(data)"
                      >
                        <span>Pagar</span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- PAGE CONTENT ENDS -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <div class="container hide">
      <div class="row search-page" id="search-page-2">
        <div class="row">
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
          <form
            enctype="multipart/form-data"
            class="filter-form form-horizontal validation-form"
            id
          >
            <div class="second-row">
              <div class="tabbable">
                <div class="tab-content profile-edit-tab-content">
                  <div id="dados_cliente" class="tab-pane in active">
                    <h4 class="header bolder smaller" style="color: #3d5476">
                      Dados do Pagamento
                    </h4>

                    <div class="form-group has-info">
                      <div class="col-md-2">
                        <label class="control-label" for="designacao">
                          Referência da factura
                          <span
                            class="tooltip-target"
                            data-toggle="tooltip"
                            data-placement="top"
                          >
                            <i
                              class="fa fa-question-circle bold text-danger"
                            ></i>
                          </span>
                        </label>
                        <Select2
                          :options="referenciasFacturas"
                          :v-model="referenciaFactura"
                          @select="onchangeReferencia"
                          placeholder="Referência"
                        >
                        </Select2>
                        <span v-if="errors.referenciaFactura" class="error">{{
                          errors.referenciaFactura[0]
                        }}</span>
                      </div>
                      <div class="col-md-3">
                        <label class="control-label" for="gestor">
                          Data pagamento no banco
                          <span
                            class="tooltip-target"
                            data-toggle="tooltip"
                            data-placement="top"
                          >
                            <i
                              class="fa fa-question-circle bold text-danger"
                            ></i>
                          </span>
                        </label>
                        <div class>
                          <date-pick
                            id="datapickEdit"
                            v-model="dataPgtBanco"
                            :format="'DD-MM-YYYY'"
                          ></date-pick>
                        </div>
                        <span v-if="errors.data_pago_banco" class="error">{{
                          errors.data_pago_banco[0]
                        }}</span>
                      </div>
                      <div class="col-md-3">
                        <label class="control-label" for="designacao">
                          Nº Operação Bancária
                          <span
                            class="tooltip-target"
                            data-toggle="tooltip"
                            data-placement="top"
                          >
                            <i
                              class="fa fa-question-circle bold text-danger"
                            ></i>
                          </span>
                        </label>
                        <div class>
                          <input
                            type="text"
                            v-model="numero_operacao_bancaria"
                            :class="
                              errors.numero_operacao_bancaria ? 'has-error' : ''
                            "
                            class="col-md-12 col-xs-12 col-sm-4"
                            placeholder="Nº 00000000"
                          />
                        </div>
                        <span
                          v-if="errors.numero_operacao_bancaria"
                          class="error"
                          >{{ errors.numero_operacao_bancaria[0] }}</span
                        >
                      </div>
                      <div class="col-md-4">
                        <label class="control-label" for="designacao">
                          Conta Movimentada
                          <span
                            class="tooltip-target"
                            data-toggle="tooltip"
                            data-placement="top"
                          >
                            <i
                              class="fa fa-question-circle bold text-danger"
                            ></i>
                          </span>
                        </label>
                        <Select2
                          :options="coordenadaBancarias"
                          v-model="conta_movimentada_id"
                          :class="
                            errors.conta_movimentada_id ? 'has-error' : ''
                          "
                          placeholder="Selecione a conta movimentada"
                        >
                        </Select2>
                        <span
                          v-if="errors.conta_movimentada_id"
                          class="error"
                          >{{ errors.conta_movimentada_id[0] }}</span
                        >
                      </div>
                    </div>
                    <div class="form-group has-info">
                      <div class="col-md-4">
                        <label class="control-label" for="designacao">
                          Forma de Pagamento
                          <span
                            class="tooltip-target"
                            data-toggle="tooltip"
                            data-placement="top"
                          >
                            <i
                              class="fa fa-question-circle bold text-danger"
                            ></i>
                          </span>
                        </label>
                        <Select2
                          :options="formaPagamentos"
                          v-model="forma_pagamento_id"
                          placeholder="Selecione a conta movimentada"
                        >
                        </Select2>
                        <span v-if="errors.forma_pagamento_id" class="error">{{
                          errors.forma_pagamento_id[0]
                        }}</span>
                      </div>
                    </div>

                    <h4
                      class="header bolder smaller"
                      v-if="mostrarDadosLicenca"
                      style="color: #3d5476"
                    >
                      Informações da licença
                    </h4>
                    <div class="form-group has-info" v-if="mostrarDadosLicenca">
                      <div class="col-md-3">
                        <label class="control-label" for="designacao">
                          Tipo de Licença
                        </label>

                        <div class>
                          <input
                            type="text"
                            disabled
                            v-model="designacao"
                            class="col-md-12 col-xs-12 col-sm-4"
                            placeholder="Ref.123456789"
                          />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label class="control-label" for="designacao">
                          Valor da Licença
                        </label>
                        <div class>
                          <input
                            type="text"
                            disabled
                            :value="custo_licenca | currency"
                            class="col-md-12 col-xs-12 col-sm-4"
                            placeholder="Ref.123456789"
                          />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label class="control-label" for="designacao">
                          Quantidade
                        </label>
                        <div class>
                          <input
                            type="text"
                            disabled
                            :value="quantidadePgt | formatQt"
                            class="col-md-12 col-xs-12 col-sm-4"
                            placeholder="Ref.123456789"
                          />
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label class="control-label" for="designacao">
                          Total a Pagar
                        </label>
                        <div class>
                          <input
                            type="text"
                            disabled
                            :value="totalPago | currency"
                            class="col-md-12 col-xs-12 col-sm-4"
                            placeholder="Ref.123456789"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="form-group has-info">
                      <div class="col-md-12">
                        <label class="control-label" for="designacao">
                          Observação
                        </label>
                        <div class>
                          <textarea
                            name=""
                            v-model="observacao"
                            id=""
                            cols="30"
                            style="height: 50px"
                            class="col-md-12 col-xs-12 col-sm-4"
                            rows="10"
                          ></textarea>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <label class="control-label" for="id-input-file-2">
                          Comprovativo bancário (jpeg,png,jpg,pdf)
                          <b class="red"
                            ><i
                              class="fa fa-question-circle bold text-danger"
                            ></i
                          ></b>
                        </label>
                        <div class="widget-body">
                          <div class="widget-main">
                            <div class="form-group has-info">
                              <div class="col-mb-10">
                                <input
                                  type="file"
                                  :value="comprovativo_bancario"
                                  v-on:change="onComprovativoChange"
                                  accept="application/jpeg,png,jpg,pdf"
                                  id="id-input-file-3"
                                  :class="
                                    errors.comprovativo_bancario
                                      ? 'has-error'
                                      : ''
                                  "
                                  required
                                />
                              </div>
                              <span
                                v-if="errors.comprovativo_bancario"
                                class="error"
                                >{{ errors.comprovativo_bancario[0] }}</span
                              >
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
                    class="search-btn"
                    style="border-radius: 10px"
                    @click.prevent="salvarPagamento"
                  >
                    <i class="ace-icon fa fa-check bigger-110"></i>
                    Enviar o Pagamento
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.row -->
    </div>

    <!-- MODAL COMPRAR LICENÇA -->
    <div id="imprimirFactura" class="modal fade">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header text-center">
            <button type="button" class="close red bolder" data-dismiss="modal">
              ×
            </button>
            <h4 class="smaller">
              Solicitação da Factura da Licença
              {{ dataLicenca.licenca.designacao }}
            </h4>
          </div>
          <div class="modal-body">
            <div class="row" style="left: 0%; position: relative">
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
              <div class="col-md-12">
                <div class="search-form-text">
                  <div class="search-text">
                    <i class="fa fa-pencil"></i>
                    Informações preliminares da Factura
                  </div>
                </div>
              </div>

              <form
                enctype="multipart/form-data"
                class="filter-form form-horizontal validation-form"
                id
              >
                <div class="second-row">
                  <div class="tabbable">
                    <ul class="nav nav-tabs padding-16"></ul>

                    <div class="tab-content profile-edit-tab-content">
                      <div id="dados_cliente" class="tab-pane in active">
                        <div class="form-group has-info">
                          <div class="col-md-6">
                            <label class="control-label" for="designacao">
                              Designação da Licença
                              <span
                                class="tooltip-target"
                                data-toggle="tooltip"
                                data-placement="top"
                              >
                                <i
                                  class="fa fa-question-circle bold text-danger"
                                ></i>
                              </span>
                            </label>
                            <div class="input-icon">
                              <input
                                type="text"
                                v-model="dataLicenca.licenca.designacao"
                                id="designacao"
                                class="col-md-12 col-xs-12 col-sm-4"
                                :class="errors.designacao ? 'has-error' : ''"
                                readonly="true"
                                disabled
                              />
                              <i class="ace-icon fa fa-key"></i>
                              <span v-if="errors.designacao" class="error">{{
                                errors.designacao[0]
                              }}</span>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <label class="control-label" for="quantidade">
                              Quantidade
                              <b class="red"
                                ><i
                                  class="fa fa-question-circle bold text-danger"
                                ></i
                              ></b>
                            </label>
                            <div class="input-icon">
                              <vue-numeric-input
                                v-model="quantidade"
                                :disabled="true"
                                :min="1"
                                :max="
                                  dataLicenca.licenca.tipo_licenca_id == 4
                                    ? 1
                                    : 10000000
                                "
                                :step="1"
                                :class="errors.quantidade ? 'has-error' : ''"
                                class="col-md-12 col-xs-12 col-sm-4"
                              ></vue-numeric-input>
                              <span v-if="errors.quantidade" class="error">{{
                                errors.quantidade[0]
                              }}</span>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <label class="control-label" for="designacao">
                              Tipo Folha
                              <span
                                class="tooltip-target"
                                data-toggle="tooltip"
                                data-placement="top"
                              >
                                <i
                                  class="fa fa-question-circle bold text-danger"
                                ></i>
                              </span>
                            </label>
                            <div class>
                              <Select2
                                :options="tipoFolhas"
                                v-model="dataLicenca.tipoFolha"
                                placeholder="selecione a folha"
                              >
                              </Select2>
                              <span v-if="errors.tipoFolha" class="error">{{
                                errors.tipoFolha[0]
                              }}</span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group has-info">
                          <div class="col-md-6">
                            <label class="control-label" for="designacao">
                              Total a Pagar
                              <span
                                class="tooltip-target"
                                data-toggle="tooltip"
                                data-placement="top"
                              >
                                <i
                                  class="fa fa-question-circle bold text-danger"
                                ></i>
                              </span>
                            </label>
                            <div class="input-icon">
                              <input
                                type="text"
                                id="designacao"
                                :value="valor_pagar | currency"
                                disabled
                                class="col-md-12 col-xs-12 col-sm-4"
                                :class="errors.valor_a_pagar ? 'has-error' : ''"
                              />
                              <i class="ace-icon fa fa-money"></i>
                              <!-- <span v-if="errors.valor_pagar" class="error">{{errors.valor_pagar[0]}}</span> -->
                            </div>
                          </div>
                          <div
                            class="col-md-6"
                            style="background: orange; margin-top: 25px"
                          >
                            <span>
                              Caso tenha dúvida do valor a pagar, entre em
                              contacto com empresa desenvolvedora da aplicação
                            </span>
                          </div>
                        </div>
                        <div class="form-group has-info">
                          <div class="col-md-12">
                            <label class="control-label" for="designacao">
                              Total por extenso
                              <span
                                class="tooltip-target"
                                data-toggle="tooltip"
                                data-placement="top"
                              >
                                <i
                                  class="fa fa-question-circle bold text-danger"
                                ></i>
                              </span>
                            </label>
                            <div class="input-icon">
                              <input
                                type="text"
                                :value="total_extenso"
                                id="designacao"
                                class="col-md-12 col-xs-12 col-sm-4"
                                :class="errors.valor_extenso ? 'has-error' : ''"
                                readonly="true"
                                disabled
                              />
                              <i class="ace-icon fa fa-money"></i>
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
                        style="border-radius: 10px"
                        data-dismiss="modal"
                        @click.prevent="imprimirFactura"
                      >
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Imprimir factura
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  </div>

  <!-- /.row -->
</template>

<script>
import axios from "axios";
import { showError, baseUrl } from "./../../../config/global";
import { mapState } from "vuex";
import Select2 from "v-select2-component";
import Multiselect from "vue-multiselect";
import DatePick from "vue-date-pick";
import "vue-date-pick/dist/vueDatePick.css";
import VueNumericInput from "vue-numeric-input";
import Swal from "sweetalert2";

export default {
  props: ["licencas", "guard"],
  components: {
    Select2,
    Multiselect,
    DatePick,
    VueNumericInput,
  },
  data() {
    return {
      dataLicenca: {
        licenca: {},
        tipoFolha: 1,
        valor_extenso: "",
      },
      quantidade: 1,
      valor_pagar: 0,
      total_extenso: "",
      errors: [],
      tipoFolhas: [
        {
          id: 1,
          text: "A4",
        },
      ],
      USUARIO_EMPRESA: 2,
      router: "",

      //SLIDE 2
      referenciasFacturas: [],
      coordenadaBancarias: [],
      formaPagamentos: [],
      mostrarDadosLicenca: false,
      referenciaFactura: "",
      quantidadePgt: 0,
      designacao: "",
      custo_licenca: 0,
      totalPago: 0,
      dataPgtBanco: this.formatDate(),
      numero_operacao_bancaria: "",
      conta_movimentada_id: "",
      comprovativo_bancario: "",
      forma_pagamento_id: "",
      nFactura: "",
      observacao: "",
      factura_id: "",
      empresa_id: "",
      canal_id: "",
      licenca_id: "",

      // pagamentoLicenca: {
      //     quantidade: "",
      //     observacao: "",
      // },
    };
  },
  computed: {
    // valor_pagar() {
    //     let quantidade = this.quantidade ? this.quantidade : 1;
    //     return parseInt(quantidade) * Number(this.valor_pagar);
    // },
  },
  watch: {
    quantidade() {
      if (Number(this.valor_pagar) > 0) {
        this.valor_pagar = Number(this.valor_pagar) * this.quantidade;
      }
    },

    valor_pagar() {
      const quantidade = Number(this.quantidade) ? this.quantidade : 1;

      if (Number(this.valor_pagar) > 0) {
        var extenso = require("extenso");
        const valorPagar = Number(this.valor_pagar) * quantidade;
        let valor_pagar_toFixed = Number(valorPagar).toFixed(2);
        let valor_a_pagar = valor_pagar_toFixed.toString().replace(".", ",");

        this.total_extenso = extenso(valor_a_pagar, {
          number: {
            decimal: "informal",
          },
        });
      }
    },
  },

  created() {
    this.router =
      this.guard.tipo_user_id == this.USUARIO_EMPRESA
        ? window.location.origin + `/empresa`
        : window.location.origin + `/empresa/funcionario`;
    this.listarReferenciasFacturas();
    this.listarCoordenadaBancarias();
    this.listarFormaPagamentos();
  },
  methods: {
    onchangeReferencia(e) {
      this.mostrarDadosLicenca = true;

      this.numero_operacao_bancaria = "";
      this.conta_movimentada_id = "";
      this.forma_pagamento_id = "";
      this.listarCoordenadaBancarias();
      this.listarFormaPagamentos();

      this.quantidadePgt = e.quantidade_produto;
      this.designacao = e.designacao;
      this.custo_licenca = e.preco_produto;
      this.totalPago = e.total_preco_produto;

      this.referenciaFactura = e.faturaReference;
      this.nFactura = e.numeracaoFactura;

      this.factura_id = e.factura_id;
      this.empresa_id = e.empresa_id;
      this.canal_id = e.canal_id;
      this.licenca_id = e.licenca_id;

      // this.pagamentoLicenca = {
      //     quantidade: e.quantidade_produto,
      //     designacao: e.designacao,
      //     preco_produto: e.preco_produto,
      //     valor_a_pagar: e.valor_a_pagar
      // }
    },

    listarFormaPagamentos() {
      axios
        .get(`${this.router}/planos-assinaturas/pegar-dependecias`)
        .then((response) => {
          this.formaPagamentos = [];
          response.data.formaPagamentos.forEach((item, index) => {
            this.formaPagamentos.push({
              id: item.id,
              text: item.descricao,
            });
          });
        })
        .catch((error) => {
          console.log("ERRO API");
        });
    },

    listarCoordenadaBancarias() {
      axios
        .get(`${this.router}/planos-assinaturas/pegar-dependecias`)
        .then((response) => {
          //coordernadas bancarias
          this.coordenadaBancarias = [];
          response.data.coordenadaBancarias.forEach((item, index) => {
            this.coordenadaBancarias.push({
              id: item.id,
              text: item.sigla + " - " + item.iban,
            });
          });
        })
        .catch((error) => {
          console.log("ERRO API");
        });
    },

    listarReferenciasFacturas() {
      axios
        .get(`${this.router}/planos-assinaturas/pegar-dependecias`)
        .then((response) => {
          response.data.buscaReferencias.forEach((item, index) => {
            //referencias da facturas
            // this.referenciasFacturas = []
            this.referenciasFacturas.push({
              id: item.faturaReference, //Adiciona o id na value do option do Select2
              text: item.faturaReference, //Adiciona a descrição na option do Select2
              ...item,
            });
          });
        })
        .catch((error) => {
          console.log("ERRO API");
        });
    },
    formatDate() {
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, "0");
      var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
      var yyyy = today.getFullYear();

      today = dd + "-" + mm + "-" + yyyy;

      return today;
    },
    modalEfectuarPagamento(data) {
      this.dataLicenca = {
        tipoFolha: this.dataLicenca.tipoFolha,
        ...data,
      };
      this.quantidade = 1;
      this.valor_pagar = data.valor;

      console.log(this.dataLicenca);
    },
    currency(value) {
      return value.toLocaleString("de-DE", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 3,
      });
    },
    onComprovativoChange(e) {
      this.comprovativo_bancario = e.target.files[0];
    },
    async salvarPagamento() {
      this.errors = [];
      this.$loading(true);

      const config = {
        headers: {
          "content-type": "multipart/form-data",
        },
      };

      let dadosPagamentos = {
        valor_depositado: this.custo_licenca,
        quantidade: this.quantidadePgt,
        totalPago: this.totalPago,
        data_pago_banco: this.dataPgtBanco,
        numero_operacao_bancaria: this.numero_operacao_bancaria,
        forma_pagamento_id: this.forma_pagamento_id,
        conta_movimentada_id: this.conta_movimentada_id,
        referenciaFactura: this.referenciaFactura,
        observacao: this.observacao,
        factura_id: this.factura_id,
        empresa_id: this.empresa_id,
        canal_id: 2, //canal cliente
        licenca_id: this.licenca_id,
        nFactura: this.nFactura,
      };

      let formData = new FormData();
      var pagamentos = JSON.stringify(dadosPagamentos);
      formData.append("addPagamento", pagamentos);
      formData.append("comprovativo_bancario", this.comprovativo_bancario);


      this.errors = [];

      axios
        .post(
          `${this.router}/planos-assinaturas/salvar-pagamento`,
          formData,
          config
        )
        .then((response) => {
          if (response.status == 200) {
            Swal.fire({
              position: "top-end",
              icon: "success",
              text: "Pagamento enviado, aguarde a sua validação.",
              showConfirmButton: true,
              confirmButtonText: "Ok",
              onClose: () => {
                document.location.reload(true);
              },
            });

            // // return;

            // Swal.fire({
            //     title: 'Sucesso',
            //     text: 'Operação realizada com sucesso!',
            //     icon: 'success',
            //     confirmButtonColor: '#3d5476',
            //     confirmButtonText: 'Ok',
            //     onClose: () => {
            //         this.ImprimirRecibo(response.data.id);
            //         document.location.reload(true)
            //     }
            // });
          }
        })
        .catch((error) => {
          this.errors = [];
          this.$loading(false);

          if (error.response.data.isValid == false) {
            this.$toasted.global.defaultError({
              msg: error.response.data.errors,
            });
            return;
          }
          this.$toasted.global.defaultError({
            msg: "Erro ao salvar pagamento",
          });
          this.errors = error.response.data.errors;
          return;
        });
    },
    async ImprimirRecibo(id) {
      let response = await axios.get(
        `${this.router}/recibosFacturasLicenca/${id}?viaImpressao=1`,
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
    },
    async imprimirFactura() {
      if (!this.quantidade) {
        this.$toasted.global.defaultError({
          msg: "Informe a quantidade",
        });
        return;
      }

      // console.log(this.dataLicenca);return;

      const licenca = {
        id: this.dataLicenca.licenca.id,
        quantidade: this.quantidade,
        total_a_pagar: this.valor_pagar,
        valor_extenso: this.total_extenso,
        designacao: this.dataLicenca.licenca.designacao,

        ...this.licenca,
      };

      try {
        this.$loading(true);

        let response = await axios.post(
          `${this.router}/planos-assinaturas/salvar-factura`,
          licenca
        );
        if (response.status == 200) {
          this.$toasted.global.defaultSuccess();
          Swal.fire({
            title: "Sucesso",
            text: "Factura registada com sucesso!",
            icon: "success",
            confirmButtonColor: "#3d5476",
            confirmButtonText: "Ok",
          });

          let responseFactura = await axios.get(
            `${this.router}/planos-assinaturas/imprimir-factura/${response.data}?viaImpressao=1`,
            {
              responseType: "arraybuffer",
            }
          );

          if (responseFactura.status == 200) {
            this.$loading(false);
            var file = new Blob([responseFactura.data], {
              type: "application/pdf",
            });
            var fileURL = URL.createObjectURL(file);
            window.open(fileURL);
            document.location.reload(true);
          } else {
            this.$loading(false);
            console.log("Erro ao carregar pdf");
          }
        }
      } catch (error) {}
    },
  },
};
</script>

<style>
#datapickEdit input {
  height: 34px !important;
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

.widget-color-dark {
  border-color: #b41717;
}
</style>
