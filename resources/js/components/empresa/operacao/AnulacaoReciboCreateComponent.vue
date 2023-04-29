<template>
  <section class="content">
    <div class="row">
      <div class="space-6"></div>
      <div class="page-header" style="left: 0.5%; position: relative">
        <h1>Anulação de Recibos</h1>
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-12">
          <div class="search-form-text">
            <div class="search-text">Anular Recibos</div>
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
          @keyup="searchRecibos"
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
          <div class="col-md-2">
            <label class="control-label bold label-select2" for="referencia"
              >Recibo<b class="red fa fa-question-"></b
            ></label>
            <div class="input-group">
              <input
                type="text"
                disabled
                v-model="dataAnulacao.numeracao_recibo"
                class="col-md-12 col-xs-12 col-sm-3"
                required
              />
              <span class="input-group-addon">
                <i class="ace-icon fa fa-info bigger-150 text-info"></i>
              </span>
            </div>
          </div>
          <div class="col-md-4">
            <label class="control-label bold label-select2" for="referencia"
              >Nome cliente<b class="red fa fa-question-"></b
            ></label>
            <div class="input-group">
              <input
                type="text"
                disabled
                v-model="dataAnulacao.nome_do_cliente"
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
              >Conta Corrente<b class="red fa fa-question-"></b
            ></label>
            <div class="input-group">
              <input
                type="text"
                disabled
                v-model="dataAnulacao.conta_corrente_cliente"
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
                v-model="dataAnulacao.nif_cliente"
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
              >Recibo Referente a factura<b class="red fa fa-question-"></b
            ></label>
            <div class="input-group">
              <input
                type="text"
                disabled
                v-model="facturaReferente.numeracaoFactura"
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
                v-model="facturaReferente.total_preco_factura"
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
                v-model="facturaReferente.valor_a_pagar"
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
            v-model="dataAnulacao.descricao"
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
import { showError, baseUrl } from "./../../../config/global";

export default {
  props: ["guard"],

  components: {
    Select2,
    DatePick,
  },

  data() {
    return {
      searchQuery: "",
      facturaReferente: {},
      dataAnulacao: {},
      saldoActualCliente: "",
      USUARIO_EMPRESA: 2,
      router: "",
      errors: [],
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
    searchRecibos() {
      this.searchQuery = this.searchQuery.toUpperCase();
      if (this.searchQuery.length >= 12) {
        clearTimeout(this.debounce);
        this.debounce = setTimeout(() => {
          axios
            .get(`${this.router}/searchRecibos?q=${this.searchQuery}`)
            .then((response) => {
              if (Object.keys(response.data).length == 0) {
                this.$toasted.global.defaultError({
                  msg: "Recibo não encontrada",
                });
                this.dataAnulacao = {};
                return;
              }
              if (response.status === 200) {
                this.dataAnulacao = response.data;
                this.mostrarSaldoCliente(response.data.cliente_id);
                this.facturaReferente =
                  this.dataAnulacao.recibos_items[0].factura;
              }
            })
            .catch((error) => {
              this.dataAnulacao = {};
              return;
            });
        }, 1000);
      }
    },
    async mostrarSaldoCliente(idCliente) {
      let response = await axios.get(
        `${this.router}/clientes/saldoActual/${idCliente}`
      );
      if (response.status === 200) {
        this.saldoActualCliente = response.data;
      }
    },

    AnularDocumento() {
      if (!this.dataAnulacao.descricao) {
        this.$toasted.global.defaultError({
          msg: "Informe o motivo da anulação do recibo",
        });
        return;
      }
      this.$loading(true);

      axios
        .post(
          `${this.router}/documentoAnuladoRecibos/salvar`,
          this.dataAnulacao
        )
        .then((documentoAnulado) => {
          if (documentoAnulado.status === 200) {
            this.$toasted.global.defaultSuccess();
            Swal.fire({
              title: "Sucesso",
              text: "Operação realizada com sucesso!",
              icon: "success",
              confirmButtonColor: "#3d5476",
              confirmButtonText: "Ok",
            });
            axios
              .get(
                `${this.router}/imprimirDocumentoAnuladoRecibos/${documentoAnulado.data}?viaImpressao=1`,
                {
                  responseType: "arraybuffer",
                }
              )
              .then((response) => {
                this.$loading(false);
                var file = new Blob([response.data], {
                  type: "application/pdf",
                });
                var fileURL = URL.createObjectURL(file);
                window.open(fileURL);
                document.location.reload(true);
              });
          }
        })
        .catch((error) => {
          if (error.response.data.isValid == false) {
            this.$toasted.global.defaultError({
              msg: error.response.data.errors,
            });
            this.$loading(false);
            return;
          }
          this.errors = error.response.data.errors;
          this.$loading(false);
        });
    },
  },
};
</script>

<style>
</style>
