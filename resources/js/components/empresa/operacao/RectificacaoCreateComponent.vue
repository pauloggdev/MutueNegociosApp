<template>
  <section class="content">
    <div class="row">
      <div class="space-6"></div>
      <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
          Rectificação
          <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Documento
          </small>
        </h1>
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
            <div class="search-text">Rectificação</div>
          </div>
        </div>
      </div>
      <div
        class="input-group input-group-sm"
        style="margin-bottom: 10px; margin-top: 15px"
      >
        <span class="input-group-addon">
          <i class="ace-icon fa fa-search"></i>
        </span>

        <input
          type="text"
          v-model="searchQuery"
          @keyup="searchFacturas"
          required
          autocomplete="on"
          class="form-control search-query"
          placeholder="Buscar por numeração ou referência da factura"
        />
        <span class="input-group-btn">
          <button type="submit" class="btn btn-primary btn-lg upload">
            <span class="ace-icon fa fa-search icon-on-right bigger-130"></span>
          </button>
        </span>
      </div>
    </div>
    <form
      method="POST"
      action
      enctype="multipart/form-data"
      class="filter-form form-horizontal validation-form"
    >
      <h5 style="margin: 0; color: #657ba0">Dados do cliente</h5>
      <hr style="margin: 0" />

      <div class="row" style="margin-bottom: 20px">
        <div class="form-group has-info">
          <div class="col-md-4">
            <label class="control-label bold label-select2" for="referencia"
              >Nome cliente<b class="red fa fa-question-"></b
            ></label>
            <div class="input-group">
              <input
                type="text"
                disabled
                v-model="dadoAnulacao.nome_do_cliente"
                class="col-md-12 col-xs-12 col-sm-3"
                required
              />
              <span class="input-group-addon">
                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
              </span>
            </div>
          </div>
          <div class="col-md-3">
            <label class="control-label bold label-select2" for="referencia"
              >Conta Corrente<b class="red fa fa-question-"></b
            ></label>
            <div class="input-group">
              <input
                type="text"
                disabled
                v-model="dadoAnulacao.conta_corrente_cliente"
                class="col-md-12 col-xs-12 col-sm-3"
                required
              />
              <span class="input-group-addon">
                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
              </span>
            </div>
          </div>
          <div class="col-md-2">
            <label class="control-label bold label-select2" for="referencia"
              >NIF<b class="red fa fa-question-"></b
            ></label>
            <div class="input-group">
              <input
                type="text"
                disabled
                v-model="dadoAnulacao.nif_cliente"
                class="col-md-12 col-xs-12 col-sm-3"
                required
              />
              <span class="input-group-addon">
                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
              </span>
            </div>
          </div>
          <div class="col-md-3">
            <label class="control-label bold label-select2" for="referencia"
              >Saldo Actual<b class="red fa fa-question-"></b
            ></label>
            <div class="input-group">
              <input
                type="text"
                disabled
                v-model="saldoActualCliente"
                class="col-md-12 col-xs-12 col-sm-3"
                required
              />
              <span class="input-group-addon">
                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <h5 style="margin: 0; color: #657ba0">Dados da factura</h5>
      <hr style="margin: 0" />
      <div class="row" style="margin-bottom: 20px">
        <div class="form-group has-info">
          <div class="col-md-2">
            <label class="control-label bold label-select2" for="referencia"
              >Data factura<b class="red fa fa-question-"></b
            ></label>
            <div class="input-group">
              <input
                type="text"
                disabled
                v-model="dadoAnulacao.created_at"
                class="col-md-12 col-xs-12 col-sm-3"
                required
              />
              <span class="input-group-addon">
                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
              </span>
            </div>
          </div>
          <div class="col-md-3">
            <label class="control-label bold label-select2" for="referencia"
              >Total factura<b class="red fa fa-question-"></b
            ></label>
            <div class="input-group">
              <input
                type="text"
                disabled
                v-model="dadoAnulacao.total_preco_factura"
                class="col-md-12 col-xs-12 col-sm-3"
                required
              />
              <span class="input-group-addon">
                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
              </span>
            </div>
          </div>
          <div class="col-md-3">
            <label class="control-label bold label-select2" for="referencia"
              >Total Pago /Total a Pagar<b class="red fa fa-question-"></b
            ></label>
            <div class="input-group">
              <input
                type="text"
                disabled
                v-model="dadoAnulacao.valor_a_pagar"
                class="col-md-12 col-xs-12 col-sm-3"
                required
              />
              <span class="input-group-addon">
                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
              </span>
            </div>
          </div>
          <div class="col-md-2">
            <label class="control-label bold label-select2" for="referencia"
              >Total Entregue<b class="red fa fa-question-"></b
            ></label>
            <div class="input-group">
              <input
                type="text"
                disabled
                v-model="dadoAnulacao.valor_entregue"
                class="col-md-12 col-xs-12 col-sm-3"
                required
              />
              <span class="input-group-addon">
                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
              </span>
            </div>
          </div>
          <div class="col-md-2">
            <label class="control-label bold label-select2" for="referencia"
              >Troco<b class="red fa fa-question-"></b
            ></label>
            <div class="input-group">
              <input
                type="text"
                disabled
                v-model="dadoAnulacao.troco"
                class="col-md-12 col-xs-12 col-sm-3"
                required
              />
              <span class="input-group-addon">
                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <div class="row" style="margin-bottom: 20px">
        <div class="col-md-12">
          <label class="control-label bold label-select2" for="controlo_stock"
            >Motivo da anulação<b class="red fa fa-question-circle"></b
          ></label>

          <textarea
            style="height: 70px"
            v-model="dadoAnulacao.descricao"
            class="col-xs-12"
            cols="20"
            rows="5"
          ></textarea>
          <div>
            <span v-if="errors.descricao" class="error">{{
              errors.descricao[0]
            }}</span>
          </div>
        </div>
      </div>
      <div class="widget-box widget-color-green" style="left: 0%">
        <div class="table-header widget-header">Todos items adicionados</div>

        <!-- div.dataTables_borderWrap -->
        <table class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th>Codigo</th>
              <th>Designação</th>
              <th style="text-align: right">Preço</th>
              <th style="text-align: center">Qtd factura</th>
              <th style="text-align: center">Qtd atual</th>
              <th style="text-align: right">IVA</th>
              <th style="text-align: right">Retenção</th>
              <th style="text-align: right">Desconto</th>
              <th style="text-align: right">Total</th>
            </tr>
          </thead>

          <tbody>
            <tr
              v-for="produto in this.dadoAnulacao.facturas_items"
              :key="produto.id"
            >
              <td>{{ produto.id }}</td>
              <td>{{ produto.descricao_produto }}</td>
              <td style="text-align: right">
                {{ produto.preco_venda_produto | currency }}
              </td>
              <td style="text-align: center">
                {{ produto.quantidade_produto | formatQt }}
              </td>
              <td style="text-align: center">
                <input
                  type="number"
                  :min="quantidadeMinima"
                  :max="2"
                  @keypress="recalcularFactura(produto, $event)"
                  @keydown="recalcularFactura(produto, $event)"
                />
                <!-- <vue-numeric-input
                  :min="quantidadeMinima"
                  @change="recalcularFactura(produto, $event)"
                  :max="produto.quantidade_produto"
                  :value="produto.quantidade_produto"
                  :step="1"
                ></vue-numeric-input> -->
              </td>
              <td style="text-align: right">
                {{ produto.iva_produto | currency }}
              </td>
              <td style="text-align: right">
                {{ produto.retencao_produto | currency }}
              </td>
              <td style="text-align: right">
                {{ produto.desconto_produto | currency }}
              </td>
              <td style="text-align: right">
                {{ produto.total_preco_produto | currency }}
              </td>
            </tr>
          </tbody>
        </table>

        <!-- fim tabela de carrinho  -->

        <!-- <a href="" @click.prevent="addCarrinho">Adicionar</a> -->
      </div>
      <div class="row">
        <div class="second-row">
          <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
              <button
                class="search-btn"
                type="submit"
                style="border-radius: 10px"
                @click.prevent="AnularDocumento"
              >
                <i class="ace-icon fa fa-check bigger-110"></i>
                Anular
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
      </div>
    </form>
  </section>
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";
import DatePick from "vue-date-pick";
import Swal from "sweetalert2";
import VueNumericInput from "vue-numeric-input";

import { showError, baseUrl } from "./../../../config/global";

export default {
  props: ["guard"],
  components: {
    Select2,
    DatePick,
    VueNumericInput,
  },

  data() {
    return {
      searchQuery: "FT REP2021/1",
      dadoAnulacao: {},
      saldoActualCliente: "",
      USUARIO_EMPRESA: 2,
      router: "",
      errors: [],
      quantidadeMinima: 0,
      debounce: null,
    };
  },
  created() {
    this.router =
      this.guard.tipo_user_id == this.USUARIO_EMPRESA
        ? window.location.origin + `/empresa`
        : window.location.origin + `/empresa/funcionario`;
  },
  methods: {
    searchFacturas() {
      this.searchQuery = this.searchQuery.toUpperCase();
      if (this.searchQuery.length >= 12) {
        clearTimeout(this.debounce);
        this.debounce = setTimeout(() => {
          axios
            .get(`${this.router}/searchFacturas?q=${this.searchQuery}`)
            .then((response) => {
              if (Object.keys(response.data).length == 0) {
                this.$toasted.global.defaultError({
                  msg: "Factura não encontrada",
                });
                this.dadoAnulacao = {};
                return;
              }
              if (response.status === 200) {
                this.dadoAnulacao = response.data;
                this.mostrarSaldoCliente(response.data.cliente_id);
              }
            })
            .catch((error) => {
              this.dadoAnulacao = {};
              return;
            });
        }, 1000);
      }
    },
    recalcularFactura(facturaItem, quantAtual) {
      console.log(facturaItem);
      return;

      this.dadoAnulacao.facturas_items.map((item, index) => {
        console.log(item);
        return;
      });

      // this.facturacao.factura.facturas_items.map((item, index) => {
    },

    async mostrarSaldoCliente(idCliente) {
      let response = await axios.get(
        `${this.router}/clientes/saldoActual/${idCliente}`
      );
      if (response.status === 200) {
        this.saldoActualCliente = response.data;
      }
    },
  },
};
</script>

<style scoped>
.vue-numeric-input {
  width: 100px !important;
}
</style>
