<template>
  <section class="content">
    <div class="row">
      <div class="space-6"></div>
      <div class="page-header" style="left: 0.5%; position: relative">
        <h1>Anulação de Facturas/Recibos</h1>
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
            <div class="search-text">Anular Factura/recibo</div>
          </div>
        </div>
      </div>
      <form
        method="POST"
        action
        enctype="multipart/form-data"
        class="filter-form form-horizontal validation-form"
        id="validation-form"
      >
        <div class="second-row">
          <div class="tabbable">
            <div class="tab-content profile-edit-tab-content">
              <div id="dados_formapagamento" class="tab-pane in active">
                <div class="row">
                  <div class="form-group has-info">
                    <div class="col-md-12">
                      <label
                        class="
                          control-label
                          bold
                          label-select2
                          header
                          bolder
                          smaller
                        "
                        for="controlo_stock"
                      >
                        Pesquise o cliente
                        <b class="red fa fa-question-circle"></b>
                      </label>
                      <Select2
                        @select="selectCliente($event)"
                        v-model="dataAnulacao.cliente_id"
                        :options="clientes"
                        placeholder="pesquise por nif, nome, telefone"
                      >
                      </Select2>
                      <span v-if="errors.cliente_id" class="error">{{
                        errors.cliente_id[0]
                      }}</span>
                    </div>
                  </div>
                  <div class="form-group has-info">
                    <div class="col-md-4">
                      <label
                        class="control-label bold label-select2"
                        for="referencia"
                        >Nome cliente<b class="red fa fa-question-"></b
                      ></label>
                      <div class="input-group">
                        <input
                          type="text"
                          disabled
                          id="referencia"
                          v-model="nomeCliente"
                          class="col-md-12 col-xs-12 col-sm-3"
                          required
                        />
                        <span class="input-group-addon">
                          <i
                            class="ace-icon fa fa-info bigger-150 text-info"
                          ></i>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label
                        class="control-label bold label-select2"
                        for="referencia"
                        >Conta Corrente<b class="red fa fa-question-"></b
                      ></label>
                      <div class="input-group">
                        <input
                          type="text"
                          disabled
                          id="referencia"
                          v-model="conta_corrente"
                          class="col-md-12 col-xs-12 col-sm-3"
                          required
                        />
                        <span class="input-group-addon">
                          <i
                            class="ace-icon fa fa-info bigger-150 text-info"
                          ></i>
                        </span>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label
                        class="control-label bold label-select2"
                        for="referencia"
                        >Saldo Actual<b class="red fa fa-question-"></b
                      ></label>
                      <div class="input-group">
                        <input
                          type="text"
                          disabled
                          id="referencia"
                          v-model="saldoActualCliente"
                          class="col-md-12 col-xs-12 col-sm-3"
                          required
                        />
                        <span class="input-group-addon">
                          <i
                            class="ace-icon fa fa-info bigger-150 text-info"
                          ></i>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div
                    class="form-group has-info bold"
                    style="left: 0%; position: relative"
                  >
                    <div class="col-md-3">
                      <label
                        class="control-label bold label-select2"
                        for="controlo_stock"
                        >Selecione o documento<b
                          class="red fa fa-question-circle"
                        ></b
                      ></label>
                      <Select2
                        :options="documentos"
                        v-model="dataAnulacao.tipo_documento"
                        @change="documentoChange($event)"
                        placeholder="Selecione o documento"
                      >
                      </Select2>
                      <span v-if="errors.tipo_documento" class="error">{{
                        errors.tipo_documento[0]
                      }}</span>
                    </div>
                    <div class="col-md-3">
                      <label
                        class="control-label bold label-select2"
                        for="controlo_stock"
                        >Selecione Factura/Recibo
                        <b class="red fa fa-question-circle"></b>
                      </label>
                      <Select2
                        :options="optionsDocumento"
                        v-model="dataAnulacao.documento_id"
                        @change="facturaChange($event)"
                        placeholder="Selecione a factura"
                      >
                      </Select2>
                      <span v-if="errors.documento_id" class="error">{{
                        errors.documento_id[0]
                      }}</span>
                    </div>
                    <div class="col-md-6">
                      <label
                        class="control-label bold label-select2"
                        for="controlo_stock"
                        >Descrição<b class="red fa fa-question-circle"></b
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
                </div>
              </div>
            </div>
          </div>

          <div class="clearfix form-actions">
            <div class="col-md-offset-3 col-md-9">
              <button
                class="search-btn"
                type="submit"
                style="border-radius: 10px"
                @click.prevent="salvar"
              >
                <i class="ace-icon fa fa-check bigger-110"></i>
                Salvar
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
      </form>
    </div>
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
      clientes: [],
      dataAnulacao: {},
      conta_corrente: "",
      nomeCliente: "",
      saldoActualCliente: "",
      documentos: [],
      optionsDocumento: [],
      USUARIO_EMPRESA: 2,
      router: "",
      errors: [],
    };
  },
  created() {
    this.router =
      this.guard.tipo_user_id == this.USUARIO_EMPRESA
        ? window.location.origin + `/empresa`
        : window.location.origin + `/empresa/funcionario`;

    this.listarClientes();
    this.listarTipoDocumentos();
  },
  methods: {
    selectCliente(c) {
      this.conta_corrente = c.conta_corrente;
      this.nomeCliente = c.nome;
      this.dataAnulacao.cliente_id = c.id;
      this.dataAnulacao.nome_do_cliente = c.nome;
      this.dataAnulacao.telefone_cliente = c.telefone_cliente;
      this.dataAnulacao.nif_cliente = c.nif;
      this.dataAnulacao.email_cliente = c.email;
      this.dataAnulacao.endereco_cliente = c.endereco;
      this.dataAnulacao.conta_corrente_cliente = c.conta_corrente;
      this.mostrarSaldoCliente(c.id);
    },
    async listarClientes() {
      try {
        let response = await axios.get(
          `${this.router}/recibo/ListarClientesComFacturasRecibo`
        );

        if (response.status === 200) {
          response.data.forEach((element) => {
            this.clientes.push({
              id: element.id,
              nome: element.nome,
              text: element.nome + " - NIF- " + element.nif,
              conta_corrente: element.conta_corrente,
              email: element.email,
              website: element.website,
              telefone_cliente: element.telefone_cliente,
              nif: element.nif,
              cidade: element.cidade,
              endereco: element.endereco,
            });

            // if (this.clientes.length) {
            //     let result = this.clientes.find(el => {
            //         return el.id === element.cliente.id
            //     });

            //     if (!result) {
            //         this.clientes.push({
            //             id: element.cliente.id,
            //             nome: element.cliente.nome,
            //             text: element.cliente.nome + " - NIF- " + element.cliente.nif,
            //             conta_corrente: element.cliente.conta_corrente,

            //         })
            //     }

            // } else {
            //     this.clientes.push({
            //         id: element.cliente.id,
            //         nome: element.cliente.nome,
            //         text: element.cliente.nome + " - NIF- " + element.cliente.nif,
            //         conta_corrente: element.cliente.conta_corrente,

            //     })
            // }
          });
        }
      } catch (error) {
        console.log("ERRO API");
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

    async listarTipoDocumentos() {
      try {
        let response = await axios.get(
          `${this.router}/factura/anulacacao/listarTipoDocumentos`
        );

        if (response.status === 200) {
          response.data.forEach((element) => {
            this.documentos.push({
              id: element.id,
              text: element.designacao,
            });
          });
        }
      } catch (error) {
        console.log("ERRO API");
      }
    },
    documentoChange(documento) {
      if (documento && this.dataAnulacao.cliente_id) {
        let idCliente = this.dataAnulacao.cliente_id;
        this.listarFacturasRefDocumento(documento, idCliente);
      }
    },
    async listarFacturasRefDocumento(documento, idcliente) {
      this.optionsDocumento = [];

      if (documento == 6) {
        //é apenas recibo

        let response = await axios.get(
          `${this.router}/anulacacao/listarReciboRefCliente/${idcliente}`
        );

        if (response.status === 200) {
          if (response.data.length) {
            response.data.forEach((element) => {
              this.optionsDocumento.push({
                id: element.id,
                text: element.numeracao_recibo,
              });
            });
          } else {
            //array vazio

            this.$toasted.global.defaultError({
              msg: "cliente sem recibo no sistema",
            });
            // return
          }
        } else {
          console.log("Erro api");
        }
      } else {
        //apenas facturas e factura recibo

        let response = await axios.get(
          `${this.router}/factura/anulacacao/listarFacturasRefDocumentoEcliente/${documento}/${idcliente}`
        );

        this.optionsDocumento = [];
        if (response.status === 200) {
          if (response.data.length) {
            response.data.forEach((element) => {
              this.optionsDocumento.push({
                id: element.id,
                text: element.numeracaoFactura,
              });
            });
          } else {
            //array vazio

            var msg = "";

            if (this.dataAnulacao.tipo_documento == 1) {
              msg = "cliente sem factura recibo no sistema";
            } else {
              msg = "cliente sem factura no sistema";
            }

            this.$toasted.global.defaultError({
              msg: msg,
            });
            return;
          }
        } else {
          console.log("Erro api");
        }
      }
    },

    facturaChange(documento) {
      //console.log(factura);
    },

    salvar() {
      const FT_RECIBO = 1;
      const FACTURA = 2;
      let retornarStock = false;

      //try {

      axios
        .get(`${this.router}/comparaDataDocumento?tabela=documento_anulados`)
        .then((responseComparaData) => {
          if (responseComparaData.data.status == 401) {
            this.$toasted.global.defaultError({
              msg: responseComparaData.data.errors,
            });
            this.$loading(false);
            return;
          }
        });

      if (
        this.dataAnulacao.tipo_documento == FACTURA ||
        this.dataAnulacao.tipo_documento == FT_RECIBO
      ) {
        Swal.fire({
          title: "Deseja voltar os produtos no estoque?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          cancelButtonText: "Não",
          confirmButtonText: "Sim",
        }).then((result) => {
          retornarStock = result.isConfirmed;
          this.requestAnulacaoDocumento(retornarStock);
        });
      } else {
        this.requestAnulacaoDocumento(retornarStock);
      }
    },
    requestAnulacaoDocumento(retornarStock) {
      this.$loading(true);

      axios
        .post(
          `${this.router}/documentoAnulado/salvar?retornarStock=${retornarStock}`,
          this.dataAnulacao
        )
        .then((documentoAnulado) => {

          if (documentoAnulado.status === 200) {
            this.$toasted.global.defaultSuccess();
            Swal.fire({
              title: "Sucesso",
              text: "Factura registada com sucesso!",
              icon: "success",
              confirmButtonColor: "#3d5476",
              confirmButtonText: "Ok",
            });

            axios
              .get(
                `${this.router}/imprimirDocumentoAnulado/${documentoAnulado.data.id}/${documentoAnulado.data.tipo_documento}?viaImpressao=1`,
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
