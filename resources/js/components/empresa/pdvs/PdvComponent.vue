<template>
  <div id="estrutura">
    <div id="container">
      <div class="caixa_01">
        <div id="buscarCliente">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="input-group" style="height: 30px">
                  <input
                    v-model="pedido.nome_do_cliente"
                    type="text"
                    :disabled="disabledInputCliente"
                    class="form-control"
                    placeholder="Buscar cliente"
                  />
                  <div
                    class="input-group-append"
                    id="btn_add_cliente"
                    data-toggle="modal"
                    data-target="#modalAdicionarCliente"
                  >
                    <div
                      class="input-group-text"
                      style="
                        width: 27px;
                        display: flex;
                        justify-content: center;
                        height: 30px;
                      "
                    >
                      <i class="fas fa-search"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="carrinho">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- /.card-header -->
                <div class="card-body" style="padding: 0 !important">
                  <table
                    id="example2"
                    class="table table-sm table-hover table-striped"
                  >
                    <thead>
                      <tr>
                        <th style="width: 300px">Produto</th>
                        <th style="text-align: right">Preço</th>
                        <th style="width: 50px; text-align: center">Qtd.</th>
                        <!-- <th style="width: 80px; text-align: center">Iva</th> -->
                        <th style="text-align: right">Total</th>
                        <th style="text-align: center">X</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="(produto, i) in pedido.pedidoItems" :key="i">
                        <td>{{ produto.descricao_produto.toLowerCase() }}</td>
                        <td style="text-align: right">
                          {{ produto.preco_venda_produto | currency }}
                        </td>
                        <td style="text-align: center">
                          <input
                            type="number"
                            style="width: 50px"
                            :min="1"
                            :max="
                              produto.stocavel == 'SIM'
                                ? produto.quantidade_stock
                                : 1000000000000000
                            "
                            v-model="produto.quantidade_produto"
                            @keyup="recalcularPedido(i)"
                            @change="recalcularPedido(i)"
                          />
                        </td>
                        <!-- <td style="text-align: right">
                                                {{ produto.taxaIva }} %
                                            </td> -->
                        <td style="text-align: right">
                          {{
                            (Number(produto.preco_venda_produto) *
                              Number(produto.quantidade_produto) +
                              Number(produto.iva_produto))
                              | currency
                          }}
                        </td>
                        <td style="text-align: center">
                          <span
                            class="badge bg-danger"
                            @click="deletarProdutoCarrinho(i)"
                            style="cursor: pointer; padding: 8px"
                            >X</span
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div>
      </div>
      <div class="caixa_02">
        <div id="buscarProduto">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="input-group">
                  <input
                    v-model="searchQuery"
                    type="text"
                    class="form-control"
                    autofocus
                    placeholder="Buscar produtos"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="listarProdutos">
          <template v-if="produtoData.length">
            <div class="grid-container grid-container--fill">
              <div
                class="grid-element"
                style="height: 170px"
                v-for="(produto, i) in produtoData"
                @dblclick="addProdutoCarrinho(produto)"
                :key="i"
              >
                <div style="position: relative">
                  <template v-if="produto.imagem_produto">
                    <img
                      alt=""
                      :src="BASE + '/upload/' + produto.imagem_produto"
                      height="120px"
                      width="100%"
                    />
                  </template>
                  <template v-else>
                    <img
                      alt=""
                      :src="BASE + '/upload/produtos/defaultImg.jpeg'"
                      height="120px"
                      width="100%"
                    />
                  </template>
                  <span style="text-align: center">{{
                    produto.designacao.toLowerCase()
                  }}</span>
                  <span
                    v-if="produto.stocavel == 'Sim'"
                    style="color: #ff0357; position: absolute; left: 0; top: 0"
                    >{{
                      produto.existencia_estock[0].quantidade | formatQt
                    }}</span
                  >

                  <br />
                  <span style="text-align: center">{{
                    produto.preco_venda | currency
                  }}</span>
                </div>
              </div>
            </div>
          </template>
          <template v-else>
            <h1>Produto não encontrado</h1>
          </template>
        </div>
      </div>
      <div class="caixa_03">
        <div class="area_caixa_03">
          <div class="item_area_caixa_03_01">
            <div class="item_descricao">Desconto:</div>
            <div class="item_valor">{{ pedido.desconto | currency }}</div>
          </div>
          <div class="item_area_caixa_03_01">
            <div class="item_descricao">IVA:</div>
            <div class="item_valor">{{ pedido.total_iva | currency }}</div>
          </div>
          <div class="item_area_caixa_03_01">
            <div class="item_descricao">Retenção:</div>
            <div class="item_valor">{{ pedido.retencao | currency }}</div>
          </div>
          <div class="item_area_caixa_03_01">
            <div class="item_descricao">Total items:</div>
            {{ pedido.pedidoItems.length | formatQt }}
          </div>
        </div>
        <div class="area_caixa_03">
          <div class="item_area_caixa_03_02">
            <div class="item_descricao">Armazém:</div>
            <div class="item_valor">LOJA PRINCIPAL</div>
          </div>
          <div class="item_area_caixa_03_02">
            <div class="item_descricao">Operador:</div>
            <div class="item_valor">{{ operador.substring(0, 28) }}</div>
          </div>
          <div class="item_area_caixa_03_02">
            <div class="">
              <button
                type="button"
                class="btn"
                style="
                  background: #f44336;
                  color: white;
                  width: 100%;
                  padding: 10px;
                "
                @click="cancelarVenda"
              >
                <i class="far fa-credit-card"></i> CANCELAR
              </button>
            </div>
            <div class="">
              <button
                type="button"
                class="btn"
                style="
                  background: #3490dc;
                  color: white;
                  width: 100%;
                  padding: 10px;
                "
                data-toggle="modal"
                data-target="#modalFechoDeCaixa"
              >
                <i class="far fa-credit-card"></i> FECHO DE CAIXA
              </button>
            </div>
          </div>
        </div>
        <div class="area_caixa_03">
          <div class="item_area_caixa_03_03" style="">
            <div class="item_descricao" style="font-size: 20px">
              Total a Pagar:
            </div>
            <div class="item_valor" style="font-size: 20px">
              {{ pedido.valor_a_pagar | currency }}
            </div>
          </div>
          <div class="item_area_caixa_03_03">
            <button
              @click="btnPagamento"
              style="width: 100%; padding: 10px"
              type="button"
              class="btn btn-success"
              :data-toggle="pedido.pedidoItems.length ? 'modal' : ''"
              :data-target="pedido.pedidoItems ? '#modalFinalizar' : ''"
            >
              <i class="far fa-credit-card"></i> PAGAMENTO
            </button>

            <!-- <a
              href="#"
              @click="btnPagamento2"
              style="width: 100%; padding: 10px"
              type="button"
              class="btn btn-success"
            >
              <i class="far fa-credit-card"></i> PAGAMENTO 2
            </a> -->
          </div>
          <div class="item_area_caixa_03_03">
            <a
              href="/empresa/home"
              style="
                padding: 0px 20px !important;
                background: #2196f3 !important;
                color: white !important;
                margin-top: 5px !important;
              "
            >
              <i class="fa fa-arrow-left" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="modalAdicionarCliente">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">ADICIONAR CLIENTE</h4>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <select
              class="form-control"
              style="font-size: 21px"
              @change="adicionarCliente($event)"
            >
              <option
                v-for="(cliente, i) in clientes"
                :value="cliente.id"
                :key="i"
              >
                {{ cliente.nome }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalFinalizar">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-body">
            <form>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="desconto" style="font-size: 17px"
                        >DOCUMENTO</label
                      >
                      <select
                        class="form-control"
                        style="font-size: 21px"
                        @change="adicionarTipoDocumento($event)"
                      >
                        <option
                          v-for="(tipoDocumento, i) in tipoDocumentos"
                          :value="tipoDocumento.id"
                          :key="i"
                        >
                          {{ tipoDocumento.designacao }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div v-if="montanteVisivel" class="col-md-6">
                    <div class="form-group">
                      <label for="desconto" style="font-size: 17px"
                        >FORMA PAGAMENTO</label
                      >
                      <select
                        @change="selecionarFormaPagamento($event)"
                        v-model="pedido.forma_pagamento_id"
                        class="form-control"
                        style="font-size: 22px"
                      >
                        <option
                          v-for="(formaPagamento, i) in formaPagamentos"
                          :value="formaPagamento.id"
                          :key="i"
                        >
                          {{ formaPagamento.descricao }}
                        </option>
                      </select>
                    </div>
                  </div>
                </div>
                <div
                  class="row"
                  v-if="isPagamentoDuplo && pedido.tipo_documento_id == 1"
                >
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="desconto" style="font-size: 17px">CASH</label>
                      <input
                        :min="0"
                        ref="valor_cash"
                        v-model="pedido.valor_cash"
                        style="font-size: 28px; padding: 20px"
                        type="number"
                        class="form-control"
                      />
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="desconto" style="font-size: 17px"
                        >MULTICAIXA</label
                      >
                      <input
                        :min="0"
                        v-model="pedido.valor_multicaixa"
                        style="font-size: 28px; padding: 20px"
                        type="number"
                        class="form-control"
                      />
                    </div>
                  </div>
                  <!-- <div class="col-md-2" v-if="montanteVisivel">
                    <div class="form-group" style="position: absolute">
                      <label for="desconto" style="font-size: 17px"
                        >COZINHA</label
                      >
                      <input
                        style="font-size: 29px; padding: 20px"
                        type="checkbox"
                        v-model="checkCozinha"
                        class="form-control"
                      />
                    </div>
                  </div> -->
                </div>
                <div class="row" v-if="!isPagamentoDuplo">
                  <div class="col-md-10" v-if="montanteVisivel">
                    <div class="form-group">
                      <label for="desconto" style="font-size: 17px"
                        >MONTANTE RECEBIDO</label
                      >
                      <input
                        v-if="aplicarMontante"
                        style="font-size: 28px; padding: 20px"
                        type="text"
                        :disabled="aplicarMontante"
                        :value="pedido.valor_entregue | currency"
                        :min="1"
                        class="form-control"
                      />
                      <input
                        v-if="!aplicarMontante"
                        id="inputMontante"
                        ref="inputMontante"
                        style="font-size: 28px; padding: 20px"
                        type="number"
                        v-model="pedido.valor_entregue"
                        :min="1"
                        class="form-control"
                      />
                    </div>
                  </div>
                  <div class="col-md-2" v-if="montanteVisivel">
                    <div class="form-group" style="position: absolute">
                      <label for="desconto" style="font-size: 17px"
                        >APLICAR</label
                      >
                      <input
                        @change="aplicarMontante2($event)"
                        style="font-size: 29px; padding: 20px"
                        type="checkbox"
                        v-model="aplicarMontante"
                        class="form-control"
                      />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8" v-if="montanteVisivel">
                    <div class="form-group">
                      <label for="desconto" style="font-size: 17px"
                        >TOTAL À PAGAR</label
                      >
                      <input
                        style="font-size: 28px; padding: 20px"
                        type="text"
                        :disabled="true"
                        :value="pedido.valor_a_pagar | currency"
                        :min="1"
                        class="form-control"
                      />
                    </div>
                  </div>
                  <div class="col-md-4" v-if="montanteVisivel">
                    <div class="form-group">
                      <label for="desconto" style="font-size: 17px"
                        >TROCO</label
                      >
                      <input
                        style="font-size: 28px; padding: 20px"
                        type="text"
                        :disabled="true"
                        :value="pedido.troco | currency"
                        :min="1"
                        class="form-control"
                      />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label
                        for="desconto"
                        style="font-size: 17px"
                        data-card-widget="collapse"
                        >OBSERVAÇÃO</label
                      >
                      <textarea
                        name=""
                        v-model="pedido.descricao"
                        cols="5"
                        rows="3"
                        style="height: 74px; font-size: 24px"
                        class="form-control"
                      >
                      </textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <a
                      :disabled="btnImprimir"
                      id="btnImprimir"
                      class="btn btn-primary btn-block"
                      style="padding: 10px; color: white"
                      @click.prevent="finalizarVenda"
                    >
                      <i class="fa fa-print" aria-hidden="true"></i>
                      IMPRIMIR
                    </a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="modalFechoDeCaixa">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">FECHO DE CAIXA</h4>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="form-horizontal">
              <div class="row form-group">
                <label for="inputDataInicial" class="col-sm-4 control-label"
                  >Data inicial</label
                >
                <div class="col-md-12">
                  <input
                    type="datetime-local"
                    class="form-control"
                    v-model="fechoCaixaData.dataInicial"
                    id="inputDataInicial"
                    placeholder="Nome"
                  />
                </div>
              </div>
              <div class="row form-group">
                <label for="inputDataFinal" class="col-sm-4 control-label"
                  >Data final</label
                >
                <div class="col-md-12">
                  <input
                    type="datetime-local"
                    class="form-control"
                    v-model="fechoCaixaData.dataFinal"
                    id="inputDataFinal"
                    placeholder="Nome"
                  />
                </div>
              </div>

              <div class="row form-group">
                <div class="col-sm-offset-2 col-sm-12">
                  <button
                    @click.prevent="imprimirFechoCaixa"
                    type="submit"
                    class="btn btn-success"
                  >
                    Imprimir fecho
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["armazem", "impressao", "tipoempressao"],
  components: {},
  data() {
    return {
      produtos: [],
      searchQuery: "",
      BASE: window.origin,
      descontoGeral: 0,
      tipoDocumentos: [],
      formaPagamentos: [],
      fechoCaixaData: {},
      clientes: [],
      operador: window.user.name,
      montanteVisivel: true,
      aplicarMontante: false,
      isPagamentoDuplo: false,
      disabledInputCliente: false,
      btnImprimir: true,
      pedido: {
        desconto: 0,
        total_iva: 0,
        numeroItems: 0,
        total_incidencia: 0,
        total_preco_factura: 0,
        valor_a_pagar: 0,
        valor_entregue: 0,
        troco: 0,
        valor_extenso: 0,
        desconto: 0,
        total_iva: 0,
        multa: 0,
        cliente_id: "",
        nome_do_cliente: "",
        telefone_cliente: "",
        nif_cliente: "999999999",
        email_cliente: "",
        endereco_cliente: "",
        conta_corrente_cliente: "31.1.2.1.1",
        numeroItems: 0,
        tipo_folha: "ticket",
        retencao: 0,
        total_incidencia: 0,
        retificado: "n",
        convertido_factura: "n",
        pedidodivida: "n",
        anulado: "n",
        descricao: "",
        data_vencimento: "",
        moeda_id: 1, //AKZ
        tipo_documento_id: 1, //Factura Recibo
        forma_pagamento_id: 1, //Numerario
        statu_id: 1, //activo
        pedidoItems: [],
        valor_multicaixa: 0,
        valor_cash: 0,
        user_id: window.user.id,
      },
    };
  },
  updated() {
    // this.verificarUserLogado();
  },
  created() {
    this.listarProdutos();
    this.listarClientes();
    this.pegarClienteDiverso();
    this.listarTipoDocumento();
    this.listarFormaPagamento();
    this.getPedidoLocalStorage();
  },
  methods: {
    async pegarClienteDiverso() {
      try {
        let response = await axios.get(`/empresa/vendas/pegarClienteDiverso`);
        if (response.status == 200) {
          this.pedido.cliente_id = response.data;
        }
      } catch (error) {
        if (error.status === 401) {
          document.location.reload(true);
        }
        console.log("Erro API listar cliente diverso");
      }
    },
    async listarClientes() {
      try {
        let response = await axios.get(
          `/empresa/vendas/listarClientesInputFactura`
        );
        if (response.status == 200) {
          this.clientes = response.data;
        }
      } catch (error) {
        if (error.status === 401) {
          document.location.reload(true);
        }
        console.log("Erro API listar clientes");
      }
    },
    async listarProdutos() {
      try {
        let response = await axios.get(`/empresa/vendas/listarProdutosVendas`);
        if (response.status == 200) {
          this.produtos = [];
          this.produtos = response.data;
        }
      } catch (error) {
        if (error.status === 401) {
          document.location.reload(true);
        }
        console.log("Erro API listar produtos");
      }
    },
    async listarTipoDocumento() {
      try {
        let response = await axios.get(`/empresa/vendas/listarDocumentoVenda`);
        if (response.status == 200) {
          this.tipoDocumentos = response.data;
        }
      } catch (error) {
        if (error.status === 401) {
          document.location.reload(true);
        }
        console.log("Erro API listar tipo documentos");
      }
    },
    async listarFormaPagamento() {
      try {
        let response = await axios.get(
          `/empresa/vendas/listarFormaPagamentoVendas`
        );
        if (response.status == 200) {
          this.formaPagamentos = response.data;
        }
      } catch (error) {
        if (error.status === 401) {
          document.location.reload(true);
        }
        console.log("Erro API listar produtos");
      }
    },
    async imprimirFechoCaixa() {
      const dataInicial = new Date(this.fechoCaixaData.dataInicial);
      const dataFinal = new Date(this.fechoCaixaData.dataFinal);
      const dataAtual = new Date();

      if (dataInicial == "Invalid Date" || dataFinal == "Invalid Date") {
        this.$toasted.global.defaultError({
          msg: "Informe a data inicial e final",
        });
        return;
      }
      if (dataInicial > dataAtual || dataFinal > dataAtual) {
        this.$toasted.global.defaultError({
          msg: "As datas não devem ser superior a data atual",
        });
        return;
      }
      if (dataInicial > dataFinal) {
        this.$toasted.global.defaultError({
          msg: "A data inicial não deve ser maior que a data final",
        });
        return;
      }

      try {
        this.$loading(true);
        let response = await axios.post(
          `/empresa/fechocaixaVenda/imprimir`,
          this.fechoCaixaData,
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
        console.log("Erro ao carregar pdf venda");
      }
    },
    selecionarFormaPagamento(e) {
      this.pedido.forma_pagamento_id = e.target.value;

      if (e.target.value == 6) {
        //pagamento duplo
        this.isPagamentoDuplo = true;
        this.pedido.tipo_documento_id = 1;
        this.pedido.valor_multicaixa = 0;
        this.pedido.valor_cash = 0;
        this.pedido.valor_entregue = 0;
        this.$nextTick(() => this.$refs.valor_cash.focus());
      } else if (e.target.value == 3) {
        //Pagamento multicaixa
        this.isPagamentoDuplo = false;
        this.pedido.tipo_documento_id = 1;
        this.pedido.valor_multicaixa = 0;
        this.pedido.valor_cash = 0;
        this.pedido.valor_entregue = 0;
        this.$nextTick(() => this.$refs.inputMontante.focus());
      } else if (e.target.value == 1) {
        this.isPagamentoDuplo = false;
        this.pedido.tipo_documento_id = 1;
        this.pedido.valor_cash = this.pedido.valor_entregue;
        this.pedido.valor_multicaixa = "";

        if (!this.aplicarMontante) {
          this.$nextTick(() => this.$refs.inputMontante.focus());
        }
      } else {
        this.isPagamentoDuplo = false;
        this.pedido.valor_cash = this.pedido.valor_entregue;
        this.pedido.valor_multicaixa = "";
        if (!this.aplicarMontante) {
          this.$nextTick(() => this.$refs.inputMontante.focus());
        }
      }
      // this.pedido.valor_entregue = "";
    },
    aplicarMontante2(event) {
      if (event.target.checked) {
        this.pedido.valor_entregue = this.pedido.valor_a_pagar;
      } else {
        this.pedido.valor_entregue = 0;
      }
    },
    getPedidoLocalStorage() {
      const json = localStorage.getItem(`pedido_${window.user.id}`);
      const pedido = JSON.parse(json);
      if (pedido && pedido.user_id == window.user.id) {
        this.pedido = pedido;
      }
    },
    cancelarVenda() {
      if (this.pedido.pedidoItems.length) {
        this.setarPedido();
        localStorage.removeItem(`pedido_${window.user.id}`);
      }
    },
    addProdutoCarrinho(produto) {
      let prod = this.pedido.pedidoItems.find(
        (value, i) => value.produto_id == produto.id
      );

      if (
        produto.existencia_estock[0].quantidade <= 0 &&
        produto.stocavel == "Sim"
      ) {
        alert(`${produto.designacao} está quantidade 0 no stock`);
        return;
      }

      if (
        produto.existencia_estock[0].quantidade > 0 &&
        prod &&
        produto.stocavel == "Sim"
      ) {
        if (
          prod.quantidade_produto >= produto.existencia_estock[0].quantidade &&
          produto.stocavel == "Sim"
        ) {
          alert(
            `existe apenas ${produto.existencia_estock[0].quantidade} ${produto.designacao} no stock`
          );
          return;
        }
      }
      let index = this.pedido.pedidoItems.findIndex(
        (value, i) => value.produto_id == produto.id
      );

      const produtoCarrinho = {
        descricao_produto: produto.designacao,
        preco_compra_produto: produto.preco_compra,
        preco_venda_produto: produto.preco_venda,
        quantidade_produto: 1,
        quantidade_stock: produto.existencia_estock[0].quantidade,
        desconto_produto: this.valor_desconto({
          preco_venda_produto: produto.preco_venda,
          quantidade_produto: 1,
          desconto_produto: 0,
        }),
        incidencia_produto: this.valor_incidencia({
          preco_venda_produto: produto.preco_venda,
          quantidade_produto: 1,
          desconto_produto: 0,
        }),
        retencao_produto: this.valor_retencao({
          preco_venda_produto: produto.preco_venda,
          quantidade_produto: 1,
          desconto_produto: 0,
          retencao_produto: 0,
        }),
        taxaIva: produto.tipo_taxa.taxa,
        iva_produto: this.iva_produto({
          preco_venda_produto: produto.preco_venda,
          quantidade_produto: 1,
          desconto_produto: 0,
          taxaIva: produto.tipo_taxa.taxa,
        }),
        total_preco_produto: this.total_preco_produto({
          preco_venda_produto: produto.preco_venda,
          quantidade_produto: 1,
        }),
        produto_id: produto.id,
      };
      if (index < 0) {
        this.pedido.pedidoItems.push(produtoCarrinho);
        this.setarValorTotalFacturacao();
      } else {
        this.pedido.pedidoItems[index].quantidade_produto += 1;
        this.recalcularPedido(index);
        console.log(
          `----- adicionar ${this.pedido.pedidoItems[index].quantidade_produto}º vez mesmo produto ------`
        );
      }
      localStorage.setItem(
        `pedido_${window.user.id}`,
        JSON.stringify(this.pedido)
      );
    },
    btnPagamento() {
      this.aplicarMontante = false;
      this.pedido.valor_entregue = 0;
      this.pedido.valor_cash = 0;
      this.pedido.valor_multicaixa = 0;
      this.btnImprimir = false;

      // this.$nextTick(() => this.$refs.inputMontante.focus())

      setTimeout(() => {
        const input = document.getElementById("inputMontante");
        input.focus();
      }, 500);
    },
    valor_desconto(item) {
      return (
        (item.preco_venda_produto *
          item.quantidade_produto *
          this.descontoGeral) /
        100
      );
    },
    valor_incidencia(item) {
      return (
        Number(item.preco_venda_produto) * Number(item.quantidade_produto) -
        Number(this.valor_desconto(item))
      );
    },
    valor_retencao(item) {
      return this.valor_incidencia(item) * Number(item.retencao_produto);
    },
    iva_produto(item) {
      //valor iva por produto
      return (item.taxaIva / 100) * this.valor_incidencia(item);
    },
    total_preco_produto(item) {
      return Number(item.preco_venda_produto) * Number(item.quantidade_produto);
    },
    setarValorTotalFacturacao() {
      //seta todos os valores totais da facturação
      this.pedido.total_preco_factura = 0;
      this.pedido.valor_a_pagar = 0;
      this.pedido.desconto = 0;
      this.pedido.total_iva = 0;
      this.pedido.numeroItems = 0;
      this.pedido.total_incidencia = 0;

      this.pedido.pedidoItems.map((item, index) => {
        this.pedido.total_preco_factura +=
          this.pedido.pedidoItems[index].total_preco_produto;
        this.pedido.numeroItems += Number(
          this.pedido.pedidoItems[index].quantidade_produto
        );
        this.pedido.desconto += this.pedido.pedidoItems[index].desconto_produto;
        this.pedido.total_iva += this.pedido.pedidoItems[index].iva_produto;
        this.pedido.total_incidencia +=
          this.pedido.pedidoItems[index].incidencia_produto;
      });

      this.pedido.valor_a_pagar =
        this.pedido.total_preco_factura +
        this.pedido.total_iva -
        (this.pedido.desconto + this.pedido.retencao);
      if (parseInt(this.pedido.valor_entregue)) {
        this.pedido.troco =
          Number(this.pedido.valor_entregue) -
          Number(this.pedido.valor_a_pagar);
      } else {
        const valorEntregue = this.pedido.valor_entregue
          ? parseInt(this.pedido.valor_entregue)
          : 0;
        this.pedido.troco = 0;
      }
      //Formatação do valor extenso
      var extenso = require("extenso");
      let valor_pagar_toFixed = this.pedido.valor_a_pagar.toFixed(2);
      let valor_a_pagar = valor_pagar_toFixed.toString().replace(".", ",");

      this.pedido.valor_extenso = extenso(valor_a_pagar, {
        number: {
          decimal: "informal",
        },
      });
      this.pedido.multa = 0;
    },
    recalcularPedido(index = null) {
      this.pedido.pedidoItems.map((el, i, _array) => {
        if (!el.quantidade_produto) {
          el.quantidade_produto = 1;
          // return;
        }
        if (el.quantidade_produto == 0) {
          el.quantidade_produto = 1;
        }
        if (this.verificarProdutoStocavel(el.produto_id)) {
          el.quantidade_produto =
            el.quantidade_produto > el.quantidade_stock
              ? el.quantidade_stock
              : el.quantidade_produto;
        }

        if (i === index) {
          el.desconto_produto = this.valor_desconto(el);
          el.incidencia_produto = this.valor_incidencia(el);
          el.retencao_produto = this.valor_retencao(el);
          el.iva_produto = this.iva_produto(el);
          el.total_preco_produto = this.total_preco_produto(el);
        } else {
          el.desconto_produto = this.valor_desconto(el);
          el.incidencia_produto = this.valor_incidencia(el);
          el.retencao_produto = this.valor_retencao(el);
          el.iva_produto = this.iva_produto(el);
          el.total_preco_produto = this.total_preco_produto(el);
          console.log("RECALCULAR APLICANDO DESCONTO");
          return;
        }
      });
      this.setarValorTotalFacturacao();
      localStorage.setItem(
        `pedido_${window.user.id}`,
        JSON.stringify(this.pedido)
      );
    },
    deletarProdutoCarrinho(index) {
      this.pedido.pedidoItems.splice(index, 1);
      this.recalcularPedido(index);

      localStorage.setItem(
        `pedido_${window.user.id}`,
        JSON.stringify(this.pedido)
      );

      console.log(
        `-------------- excluindo produto index - ${index}---------------`
      );
    },
    verificarProdutoStocavel(produtoId) {
      let produto = this.produtos.find((produto) => produtoId == produto.id);
      return produto.stocavel == "Sim";
    },
    adicionarTipoDocumento(event) {
      this.pedido.tipo_documento_id = event.target.value;

      this.pedido.valor_cash = "";
      this.pedido.valor_multicaixa = "";
      this.descontoGeral = 0;

      if (event.target.value != 1) {
        if (event.target.value == 2) {
          // this.pedido.valor_cash = 0;
          // this.pedido.valor_multicaixa = 0;
          this.pedido.valor_entregue = 0;
          this.pedido.troco = 0;
          this.pedido.forma_pagamento_id = 2;
          this.montanteVisivel = false;
        }
        if (event.target.value == 3) {
          // this.pedido.valor_cash = 0;
          // this.pedido.valor_multicaixa = 0;
          this.pedido.valor_entregue = 0;
          this.pedido.troco = 0;
          this.pedido.forma_pagamento_id = null;
          this.montanteVisivel = false;
        }
        this.checkCozinha = false;
        this.aplicarMontante = false;
      } else {
        this.pedido.forma_pagamento_id = 1;
        this.montanteVisivel = true;
        this.isPagamentoDuplo = false;
        // this.pedido.valor_cash = 0;
        // this.pedido.valor_multicaixa = 0;
        this.pedido.valor_entregue = 0;
        this.$nextTick(() => this.$refs.inputMontante.focus());
      }
    },
    adicionarCliente(event) {
      let cliente = this.clientes.find(
        (cliente) => cliente.id == event.target.value
      );

      if (cliente.diversos == "Sim") {
        this.disabledInputCliente = false;
      } else {
        this.disabledInputCliente = true;
      }
      this.pedido.nome_do_cliente = cliente.nome;
      this.pedido.telefone_cliente = cliente.telefone;
      this.pedido.nif_cliente = cliente.nif;
      this.pedido.email_cliente = cliente.email;
      this.pedido.endereco_cliente = cliente.endereco;
      this.pedido.conta_corrente_cliente = cliente.conta_corrente;
      this.pedido.cliente_id = cliente.id;
      this.pedido.cliente_diverso = cliente.diversos;

      $(".modal-backdrop").removeClass("modal-backdrop fade show");
      $("#modalAdicionarCliente").modal("toggle");
      localStorage.setItem(
        `pedido_${window.user.id}`,
        JSON.stringify(this.pedido)
      );
    },
    setarPedido() {
      this.pedido = {
        desconto: 0,
        total_iva: 0,
        numeroItems: 0,
        total_incidencia: 0,
        total_preco_factura: 0,
        valor_a_pagar: 0,
        valor_entregue: 0,
        troco: 0,
        valor_extenso: 0,
        desconto: 0,
        total_iva: 0,
        multa: 0,
        cliente_id: 1,
        nome_do_cliente: "",
        telefone_cliente: "",
        nif_cliente: "999999999",
        email_cliente: "",
        endereco_cliente: "",
        conta_corrente_cliente: "31.1.2.1.1",
        numeroItems: 0,
        tipo_folha: "ticket",
        retencao: 0,
        total_incidencia: 0,
        retificado: "n",
        convertido_factura: "n",
        pedidodivida: "n",
        anulado: "n",
        descricao: "",
        data_vencimento: "",
        moeda_id: 1, //AKZ
        tipo_documento_id: 1, //Factura Recibo
        forma_pagamento_id: 1, //Numerario
        statu_id: 1, //activo
        pedidoItems: [],
        valor_multicaixa: 0,
        valor_cash: 0,
        user_id: window.user.id,
      };
    },
    async finalizarVenda() {
      if (
        this.pedido.tipo_documento_id == 1 &&
        this.pedido.valor_entregue < this.pedido.valor_a_pagar
      ) {
        this.$toasted.global.defaultError({
          msg: "O valor recebido é menor que o valor a pagar",
        });

        return;
      }

      if (
        this.pedido.tipo_documento_id == 2 &&
        this.pedido.cliente_diverso == "Sim"
      ) {
        this.$toasted.global.defaultError({
          msg: "Seleciona um cliente cadastrado",
        });
        return;
      }
      this.btnImprimir = true;

      this.$loading(true);

      try {
        let response = await axios.post(
          `/empresa/vendas/finalizarVenda`,
          this.pedido
        );
        if (response.status == 200) {
          this.$loading(false);
          localStorage.removeItem(`pedido_${window.user.id}`);
          if (this.tipoempressao.valor == "TICKET") {
            window.location.href = `/reimprimirFactura?facturaId=${response.data}`;
            return;
          }
          if (this.tipoempressao.valor == "A4") {
            window.open(`/empresa/facturacao/imprimir-factura/${response.data}`,"_blank");
            document.location.reload(true);
          }
        }
      } catch (error) {
        console.log("Erro API ao finalizar a venda");
      }
    },
  },
  watch: {
    "pedido.valor_multicaixa"() {
      const valor_multicaixa =
        this.pedido.valor_multicaixa == undefined
          ? 0
          : Number(this.pedido.valor_multicaixa);
      const valor_cash =
        this.pedido.valor_cash == undefined
          ? 0
          : Number(this.pedido.valor_cash);

      if (valor_multicaixa > this.pedido.valor_a_pagar) {
        this.pedido.valor_multicaixa = this.pedido.valor_a_pagar;
        return;
      }
      this.pedido.valor_entregue = valor_cash + valor_multicaixa;
      this.setarValorTotalFacturacao();
    },
    "pedido.valor_cash"() {
      const valor_multicaixa =
        this.pedido.valor_multicaixa == undefined
          ? 0
          : Number(this.pedido.valor_multicaixa);
      const valor_cash =
        this.pedido.valor_cash == undefined
          ? 0
          : Number(this.pedido.valor_cash);

      this.pedido.valor_entregue = valor_cash + valor_multicaixa;
      this.setarValorTotalFacturacao();
    },
    "pedido.valor_entregue"() {
      if (
        this.pedido.forma_pagamento_id != 6 &&
        this.pedido.forma_pagamento_id != 3
      ) {
        //diferente de pagamento duplo e Pgt multicaixa
        this.pedido.valor_cash = this.pedido.valor_entregue;
      } else if (this.pedido.forma_pagamento_id == 3) {
        this.pedido.valor_cash = 0;
        this.pedido.valor_multicaixa = this.pedido.valor_entregue;
      }
      this.setarValorTotalFacturacao();
    },
    descontoGeral() {
      if (this.descontoGeral > 100) {
        this.descontoGeral = 100;
      }
      this.pedido.pedidoItems.map((el, index) => {
        el.desconto_produto = Number(this.descontoGeral);
      });
      this.recalcularPedido();
    },
  },
  computed: {
    produtoData() {
      if (this.searchQuery) {
        let result = this.produtos.filter((item) => {
          return item.designacao
            .toLowerCase()
            .match(this.searchQuery.toLowerCase());
        });
        return result ? result : [];
      } else {
        return this.produtos;
      }
    },
  },
};
</script>

<style scoped>
* {
  /* margin: 0;
  padding: 0; */
  font-family: "Nunito", sans-serif;
  font-size: 0.9rem;
  font-weight: 400;
  line-height: 1.6;
}

.modal-open {
  height: auto !important;
  padding-right: 17px !important;
}

#container {
  display: grid;
  grid-template-columns: minmax(380px, 380px) 1fr;
  grid-template-areas:
    "caixa_01 caixa_02"
    "caixa_01 caixa_02"
    "caixa_03 caixa_03";
  grid-template-rows: 1fr 1fr 130px;
  height: 100vh;
}

.caixa_01 {
  grid-area: caixa_01;
  background-color: #0c1b25;
  padding: 10px 3px;

  /* padding: 10px; */
}

.caixa_02 {
  grid-area: caixa_02;
  background-color: #f8fafc;
  padding: 10px 5px;
}

.caixa_03 {
  grid-area: caixa_03;
  display: flex;
  background-color: #0c1b25;
  padding: 0px 0px 10px 10px;
}

h1 {
  margin: 0;
  padding: 0;
}

#buscarProduto input,
#buscarCliente input {
  height: 30px;
  outline: none;
  border: 1px solid #ccc;
  background: #4f5962;
  color: #fff;
  padding-left: 10px;
  font-size: 14px;
  margin-bottom: 20px;
}

/* listar produtos  */
.listarProdutos {
  max-height: 400px;
  overflow-y: scroll;
}

.listarProdutos::-webkit-scrollbar {
  width: 2px;
}

#btn_add_cliente .input-group-text:hover {
  background-color: tomato !important;
  color: white;
}

#btn_add_cliente:hover {
  background-color: tomato !important;
  cursor: pointer;
  height: 30px;
  border-radius: 2px;
}

.grid-container {
  display: grid;
  grid-gap: 5px;
  cursor: pointer;
}

.grid-container--fill {
  grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
}

.grid-container--fit {
  grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
}

.grid-container .grid-container--fill {
  height: 170px;
  overflow-y: scroll;
}

.grid-element {
  text-align: center;
  background-color: #0c1b25;
  padding: 2px;
  color: #fff;
  border: 1px solid #fff;
}

.grid-element:hover {
  background-color: #616e7a;
}

.fa,
.fas {
  font-family: "Font Awesome 5 Free" !important;
  font-weight: 900;
}

.far {
  font-family: "Font Awesome 5 Free" !important;
  font-weight: 400;
}

.area_caixa_03 {
  width: calc(100% / 3 - 20px);
}

.item_area_caixa_03_01,
.item_area_caixa_03_02,
.item_area_caixa_03_03 {
  display: flex;
  width: 50%;
  justify-content: space-between;
  /* background: black; */
  color: #fff;
  font-weight: 500;
  font-size: 18px;
}

.item_area_caixa_03_02 {
  width: 75%;
}

.item_area_caixa_03_03 {
  width: 75%;
  font-size: 21px;
}
</style>
