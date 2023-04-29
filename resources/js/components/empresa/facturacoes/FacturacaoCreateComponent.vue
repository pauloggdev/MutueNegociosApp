<template>
  <div class="facturaRegibo">
    <div class="modal-content">
      <div class="modal-body">
        <div class="row">
          <div>
            <a
              @click.prevent="imprimirRelatorioDiario"
              title="Relatório de venda do dia"
              target="_blanck"
              class="btn btn-primary widget-box widget-color-blue"
              id="botoes"
            >
              <i class="fa fa-print text-default"></i> Relatório do dia
            </a>
            <a
              href="#vendaRapida"
              data-toggle="modal"
              title="vendas rapidas"
              target="_blanck"
              class="btn btn-primary widget-box widget-color-blue"
              id="botoes"
            >
              Descrição adicional
            </a>
            <div class="search-form-text" id="headerTitle">
              <div class="search-text">
                <i class="menu-icon glyphicon glyphicon-barcode"></i>
                Facturação
              </div>
              <div class="search-text" id="valorPgt">
                Total {{ facturacao.valor_a_pagar | currency }}
                <i class="menu-icon fa fa-opencart">
                  <span id="quantProdutoCarrinho">
                    {{ quantidadeProdutoCarrinho() }}
                  </span>
                </i>
              </div>
            </div>
          </div>
        </div>
        <div class="row" id="content-facturacao">
          <div class="col-md-4 grid-facturacao" id="produto-item">
            <div class="clearfix">
              <div class="pull-right tableTools-container"></div>
            </div>
            <div id="info-total">
              <div>
                <div class="total-item">
                  Total a pagar<span>{{
                    facturacao.valor_a_pagar | currency
                  }}</span>
                </div>
                <div class="total-item">
                  Troco
                  <span>{{
                    facturacao.troco ? facturacao.troco : 0 | currency
                  }}</span>
                </div>
                <div class="total-item">
                  Desconto <span>{{ facturacao.desconto | currency }}</span>
                </div>
                <div class="total-item">
                  Total da factura
                  <span>{{ facturacao.total_preco_factura | currency }}</span>
                </div>
                <div class="total-item">
                  Total Iva <span>{{ facturacao.total_iva | currency }}</span>
                </div>
                <div class="total-item">
                  Total Retenção
                  <span>{{ facturacao.total_retencao | currency }}</span>
                </div>
                <div class="total-item">
                  Valor extenso
                  <span style="color: red">{{ facturacao.valor_extenso }}</span>
                </div>
              </div>
            </div>
            <div class="table-header">Produtos e serviços</div>

            <table
              class="table table-striped table-hover"
              v-if="facturacao.produtos.length"
            >
              <thead style="display: table; width: 100%; table-layout: fixed">
                <tr>
                  <th style="width: 250px">Descrição</th>
                  <th style="text-align: rigth; width: 82px">Preço.Unit.</th>
                  <th></th>
                </tr>
              </thead>
              <tbody style="display: block; height: 430px; overflow: auto">
                <tr
                  v-for="prod in facturacao.produtos"
                  :key="prod.id"
                  @click="showModal(prod)"
                  style="display: table; width: 100%; table-layout: fixed"
                >
                  <td style="width: 250px">
                    {{ prod.designacao }}
                    <b>({{ prod.quantidade_produto | formatQt }})</b> <br />
                    <span v-if="prod.categoria_id !== 1">
                      <strong>{{ prod.categoria.toLowerCase() }}</strong></span
                    >
                  </td>
                  <td style="text-align: right; width: 82px">
                    <span>{{ prod.preco_venda_produto | currency }}</span>
                  </td>
                  <td colspan="1">
                    <div class="hidden-sm hidden-xs action-buttons">
                      <a
                        class="red"
                        @click.stop="removeItemFacturacao(prod.produto_id)"
                      >
                        <i
                          class="ace-icon glyphicon glyphicon-remove bigger-130"
                        ></i>
                      </a>
                    </div>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <td colspan="1">
                  <button
                    type="button"
                    class="btn btn-white btn-danger btn-sm mt-4"
                    @click="limparTodosItem"
                  >
                    <i
                      class="ace-icon glyphicon glyphicon-remove"
                      aria-hidden="true"
                    ></i>
                    Limpar
                  </button>
                </td>
              </tfoot>
            </table>
            <div v-else id="semProduto">
              <div class="semProdutoDescription">
                <div>
                  <i class="glyphicon glyphicon-list"></i>
                </div>
                <div>
                  <div class="text">Não existe produto/serviços na lista</div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-5">
            <div class="row">
              <div class="col-md-12">
                <label class="control-label bold" for="preco_compra">
                  Loja/Armazém
                </label>
                <Select2
                  :options="optionsArmazens"
                  v-model="armazen_selecionado"
                >
                  <!-- <option disabled value="0">Select one</option> -->
                </Select2>
              </div>
              <div class="col-md-12" style="z-index: 1">
                <div class="row" style="margin-top: 10px">
                  <!-- PESQUISA PRODUTOS  -->
                  <div class="col-md-12">
                    <span class="input-form-icon">
                      <form action id="search-form">
                        <input
                          type="text"
                          class="col-md-12 search-query"
                          placeholder="Buscar produtos e serviços..."
                          autocomplete="off"
                          v-model="queryProduto"
                          autofocus
                        />
                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                        <!-- <i class="ace-icon fa fa-remove nav-search-icon" id="icon-remove" @click="clearInput"></i> -->
                        <a
                          v-if="guard.tipo_user_id == 2"
                          href="#criar_produto"
                          title="Adicionar Produto"
                          data-toggle="modal"
                          class="pull-right"
                          style="margin-top: -27px; position: relative"
                        >
                          <i
                            class="fa icofont-plus-circle bigger-150 pull-right"
                            style="color: #337ab7"
                          ></i>
                        </a>
                      </form>
                    </span>
                  </div>
                  <!-- FIM PESQUISA PRODUTOS  -->
                </div>
                <!-- <hr> -->
              </div>

              <div
                class="col-md-12"
                v-if="!resultQueryProduto.length"
                style="margin-top: 10px"
              >
                <div id="semProduto">
                  <div class="semProdutoDescription">
                    <div>
                      <i class="glyphicon glyphicon-list"></i>
                    </div>
                    <div>
                      <div class="text" style="color: red">
                        Não existe produto/serviços neste armazem
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row" style="overflow-y: scroll; height: 620px">
              <div
                class="col-md-4 content-produto"
                v-for="(prod, i) in resultQueryProduto"
                :key="i"
                @onmousemove="popUp"
              >
                <abbr
                  v-if="prod.categoria_id != 1"
                  :title="prod.categoria.toUpperCase()"
                >
                  <div
                    class="
                      widget-box widget-color-dark
                      light-border
                      produto-item
                      produtoItem
                    "
                    style="heigth: 100px"
                    id="widget-box-6"
                  >
                    <div class="widget-header">
                      <div class="widget-title smaller">
                        <span class="badge badge-danger">{{
                          prod.preco_venda_produto | currency
                        }}</span>
                        <!-- <a href="#editar_produto" data-toggle="modal" @click="mostrarModalEditarProduto(prod, $event)">Editar</a> -->
                      </div>
                    </div>

                    <div
                      class="widget-body produto-info produtoItem"
                      @dblclick="adicionarProduto(prod)"
                    >
                      <div class="widget-main padding-6">
                        <div class="alert alert-info">
                          {{ prod.designacao.toUpperCase() }} <br />
                          <span
                            v-if="prod.stocavel == 'Sim'"
                            style="text-align-right"
                            class="badge badge-danger"
                            >stock: {{ prod.quantidade | formatQt }}
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </abbr>
                <div
                  v-else
                  class="
                    widget-box widget-color-dark
                    light-border
                    produto-item
                    produtoItem
                  "
                  style="heigth: 100px"
                  id="widget-box-6"
                >
                  <div class="widget-header">
                    <div class="widget-title smaller">
                      <span class="badge badge-danger">{{
                        prod.preco_venda_produto | currency
                      }}</span>
                      <!-- <a href="#editar_produto" data-toggle="modal" @click="mostrarModalEditarProduto(prod, $event)">Editar</a> -->
                    </div>
                  </div>
                  <div
                    class="widget-body produto-info produtoItem"
                    @dblclick="adicionarProduto(prod)"
                  >
                    <div class="widget-main padding-6">
                      <div class="alert alert-info">
                        {{ prod.designacao.toUpperCase() }} <br />
                        <span
                          v-if="prod.stocavel == 'Sim'"
                          style="text-align-right"
                          class="badge badge-danger"
                          >stock: {{ prod.quantidade | formatQt }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- <div class="popUp" v-if="prod.categoria_id != 1">
                                <p>{{ prod.categoria.toUpperCase()}}</p>
                            </div> -->
              </div>
            </div>
          </div>

          <!-- AREA DO CLIENTE  -->
          <div class="col-md-3">
            <div class="row">
              <!-- <Select2 :options="optionsClientes" @select="adicionarCliente($event)">
                            </Select2> -->
              <PesquisarCliente
                :guard="guard"
                @onAddCliente="adicionarCliente"
              ></PesquisarCliente>
            </div>
            <div class="row">
              <div class="col-md-12" style="padding: 0px">
                <div class="tabbable">
                  <ul
                    class="
                      nav nav-tabs
                      padding-12
                      tab-color-blue
                      background-blue
                    "
                    id="myTab4"
                  >
                    <li class="active">
                      <a data-toggle="tab" href="#dropdown14">Pagamento</a>
                    </li>
                    <li>
                      <a data-toggle="tab" href="#dropdown16"
                        >Desconto/Retenção</a
                      >
                    </li>
                  </ul>

                  <div class="tab-content">
                    <div id="dropdown14" class="tab-pane in active">
                      <div class="row">
                        <div class="col-md-12 inputFormPag">
                          <label class="control-label bold" for="preco_compra">
                            Forma Pagamento
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
                          <div class="inputFormPag">
                            <Select2
                              :options="optionsFormaPagamentos"
                              @select="selecionarFormaPagamento"
                              id="disabled-pagamento"
                              v-model.number="facturacao.formas_pagamento_id"
                            >
                            </Select2>
                            <a
                              v-if="guard.tipo_user_id == 2"
                              href="#criar_formapagamento"
                              title="Adicionar formas de Pagamento"
                              data-toggle="modal"
                              class="pull-right"
                              style="margin-top: -27px; position: relative"
                            >
                              <i
                                class="
                                  fa
                                  icofont-plus-circle
                                  bigger-150
                                  pull-right
                                "
                                style="color: #337ab7"
                              ></i>
                            </a>
                          </div>

                          <div class="inputFormPag">
                            <label
                              class="control-label bold"
                              for="preco_compra"
                            >
                              Valor Entregue
                            </label>
                            <input
                              type="number"
                              v-model="valorEntregue"
                              id="disabled-valor_pagar"
                              class="form-control"
                            />
                          </div>
                        </div>
                      </div>
                    </div>

                    <div id="dropdown16" class="tab-pane">
                      <div class="row">
                        <div class="col-md-12 inputFormPag">
                          <div class="inputFormPag">
                            <label
                              class="control-label bold"
                              for="preco_compra"
                            >
                              Desconto
                            </label>

                            <input
                              type="number"
                              v-model.number="descontoTotal"
                              :max="descontomax"
                              :min="1"
                              class="form-control"
                            />
                          </div>
                          <div class="checkbox">
                            <label class="block">
                              <input
                                v-model="checkRetencao"
                                name="form-field-checkbox"
                                type="checkbox"
                                class="ace input-sm"
                              />
                              <span class="lbl bigger-100"
                                >Aplicar retenção na fonte</span
                              >
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12" style="padding: 0px">
                        <div class="tabbable">
                          <ul
                            class="
                              nav nav-tabs
                              padding-12
                              tab-color-blue
                              background-blue
                            "
                            id="myTab4"
                          >
                            <li class="active">
                              <a data-toggle="tab" href="#dropdown17"
                                >Tipo Factura</a
                              >
                            </li>
                            <li>
                              <a data-toggle="tab" href="#dropdown18"
                                >Formato factura</a
                              >
                            </li>
                          </ul>
                          <div class="tab-content">
                            <div id="dropdown17" class="tab-pane in active">
                              <div class="radio">
                                <label>
                                  <input
                                    name="form-field-radio1"
                                    v-model="checkTipoDocumento"
                                    :value="1"
                                    type="radio"
                                    class="ace input-sm"
                                  />
                                  <span class="lbl bigger-100">FT.Recibo</span>
                                </label>
                                <label>
                                  <input
                                    name="form-field-radio2"
                                    v-model="checkTipoDocumento"
                                    :value="2"
                                    type="radio"
                                    class="ace input-sm"
                                  />
                                  <span class="lbl bigger-100">Factura</span>
                                </label>

                                <label>
                                  <input
                                    name="form-field-radio3"
                                    v-model="checkTipoDocumento"
                                    :value="3"
                                    type="radio"
                                    class="ace input-sm"
                                  />
                                  <span class="lbl bigger-100">Proforma</span>
                                </label>
                              </div>
                            </div>

                            <div id="dropdown18" class="tab-pane">
                              <div class="row">
                                <div class="col-md-12 FormatoImpressao">
                                  <div class="form-group">
                                    <div class="form-check" style="float: left">
                                      <label class="form-check-label">
                                        <input
                                          class="form-check-input"
                                          :value="facturacao.tipoFolha"
                                          @change="alterarFolha(1)"
                                          :checked="
                                            impressao.vida == 1 ? true : false
                                          "
                                          type="radio"
                                          name="radio1"
                                        />
                                        A4
                                      </label>
                                    </div>
                                    <div class="form-check" style="float: left">
                                      <label class="form-check-label">
                                        <input
                                          class="form-check-input"
                                          :value="facturacao.tipoFolha"
                                          @change="alterarFolha(2)"
                                          :checked="
                                            impressao.vida == 2 ? true : false
                                          "
                                          type="radio"
                                          name="radio1"
                                        />
                                        A5
                                      </label>
                                    </div>
                                    <div class="form-check" style="float: left">
                                      <label class="form-check-label">
                                        <input
                                          class="form-check-input"
                                          :value="facturacao.tipoFolha"
                                          @change="alterarFolha(3)"
                                          :checked="
                                            impressao.vida == 3 ? true : false
                                          "
                                          type="radio"
                                          name="radio1"
                                        />
                                        Ticket
                                      </label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12" style="padding: 0px">
                        <div class="tabbable">
                          <ul
                            class="
                              nav nav-tabs
                              padding-12
                              tab-color-blue
                              background-blue
                            "
                            id="myTab4"
                          >
                            <li class="active">
                              <a data-toggle="tab" href="#clienteDiverso1"
                                >Clientes-Gerais</a
                              >
                            </li>

                            <li>
                              <a data-toggle="tab" href="#clienteDiverso2"
                                >Clientes-Outros</a
                              >
                            </li>
                          </ul>
                          <div class="tab-content">
                            <div
                              id="clienteDiverso1"
                              class="tab-pane in active"
                            >
                              <div class="row inputCliente">
                                <div class="col-md-12 inputFormPag">
                                  <label
                                    class="control-label bold"
                                    for="preco_compra"
                                  >
                                    Nome
                                    <span
                                      class="tooltip-target"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                    >
                                      <i
                                        class="
                                          fa fa-question-circle
                                          bold
                                          text-danger
                                        "
                                      ></i>
                                    </span>
                                  </label>
                                  <input
                                    autocomplete="true"
                                    type="text"
                                    v-model="facturacao.cliente.nome_do_cliente"
                                    class="form-control"
                                  />
                                </div>
                                <div class="col-md-12 inputFormPag">
                                  <label
                                    class="control-label bold"
                                    for="preco_compra"
                                  >
                                    NIF
                                    <span
                                      class="tooltip-target"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                    >
                                      <i
                                        class="
                                          fa fa-question-circle
                                          bold
                                          text-danger
                                        "
                                      ></i>
                                    </span>
                                  </label>
                                  <input
                                    type="text"
                                    v-model="facturacao.cliente.nif_cliente"
                                    class="form-control"
                                  />
                                </div>
                                <div class="col-md-12 inputFormPag">
                                  <label
                                    class="control-label bold"
                                    for="preco_compra"
                                  >
                                    Telefone
                                    <span
                                      class="tooltip-target"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                    >
                                      <i
                                        class="
                                          fa fa-question-circle
                                          bold
                                          text-danger
                                        "
                                      ></i>
                                    </span>
                                  </label>
                                  <input
                                    type="text"
                                    v-model="
                                      facturacao.cliente.telefone_cliente
                                    "
                                    class="form-control"
                                  />
                                </div>

                                <div class="col-md-12 inputFormPag">
                                  <label
                                    class="control-label bold"
                                    for="preco_compra"
                                  >
                                    Endereço
                                    <span
                                      class="tooltip-target"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                    >
                                      <i
                                        class="
                                          fa fa-question-circle
                                          bold
                                          text-danger
                                        "
                                      ></i>
                                    </span>
                                  </label>

                                  <input
                                    type="text"
                                    v-model="
                                      facturacao.cliente.endereco_cliente
                                    "
                                    class="form-control"
                                  />
                                </div>
                              </div>
                            </div>
                            <div id="clienteDiverso2" class="tab-pane">
                              <div class="row inputCliente">
                                <div class="col-md-12 inputFormPag">
                                  <label
                                    class="control-label bold"
                                    for="conta_corrente"
                                  >
                                    Conta Corrente
                                    <!-- <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                        <i class="fa fa-question-circle bold text-danger"></i>
                                                    </span> -->
                                  </label>
                                  <input
                                    autocomplete="true"
                                    type="text"
                                    v-model="
                                      facturacao.cliente.conta_corrente_cliente
                                    "
                                    class="form-control"
                                  />
                                </div>
                                <div class="col-md-12 inputFormPag">
                                  <label
                                    class="control-label bold"
                                    for="preco_compra"
                                  >
                                    Email
                                  </label>

                                  <input
                                    type="text"
                                    v-model="facturacao.cliente.email_cliente"
                                    class="form-control"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-12" id="btnFechoCaixa">
                                <a
                                  data-toggle="modal"
                                  href="#modalFechoCaixa"
                                  @click.prevent="inicializarDataFechoCaixa"
                                >
                                  <i
                                    class="menu-icon glyphicon glyphicon-time"
                                  ></i>
                                  Fecho de caixa
                                </a>
                              </div>
                              <!-- <div class="col-md-12" id="btnFechoCaixa" style="margin-top:20px">
                                                            <a @click.prevent="imprimirRelatorioDiario">
                                                                 <i class="fa fa-print bold"></i>
                                                                Relatório do dia
                                                            </a>
                                                        </div> -->
                            </div>

                            <!-- <button v-if="facturacao.cliente.nome_do_cliente" @click="limparInputCliente" type="button" class="btn btn-white btn-danger btn-sm">
                                                            <i class="ace-icon glyphicon glyphicon-remove" aria-hidden="true"></i>
                                                            Limpar
                                                        </button> -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- FIM AREA DO CLIENTE  -->
        </div>
      </div>

      <!-- BUTTON FACTURAÇÃO  -->

      <div class="row">
        <div
          class=""
          style="float: right; padding-right: 10px; margin-right: 10px"
        >
          <!-- <a href="">
                    <i class="menu-icon glyphicon glyphicon-time"></i>
                    Fecho de caixa
                </a> -->

          <a
            href="#"
            id="btnFacturacao"
            class="btn btn-app btn-primary btn-xs"
            @click.prevent="cadastrarFactura"
          >
            <i class="ace-icon fa fa-print bigger-160"></i>
            Facturar
          </a>
        </div>
      </div>

      <!-- FIM BUTTON FACTURAÇÃO  -->
    </div>

    <!-- MODAL PARA EDITAR QUANTIDADE DE PRODUTOS, DESCONTO  -->
    <modal name="set-edit-facturacao">
      <div class="modal-header" id="modalEditFactura">
        <button
          type="button"
          class="close"
          @click="CloseModal"
          aria-hidden="true"
        >
          &times;
        </button>
        <h3 class="smaller lighter blue no-margin">{{ produto.designacao }}</h3>
      </div>
      <div class>
        <form action>
          <div class="form-group">
            <div class="col-md-12" style="margin-bottom: 5px">
              <label class="control-label" for="nome">Quantidade</label>
              <div class="input-icon">
                <input
                  type="number"
                  min="1"
                  v-model.number="produto.quantidade_produto"
                  autocomplete="off"
                  style="height: 35px"
                  class="col-md-12"
                />
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-md-6">
              <label class="control-label" for="desconto">Desc(%)</label>
              <div class="input-icon">
                <input
                  disabled
                  type="number"
                  min="0"
                  v-model.number="produto.descontoAnterior"
                  class="col-md-12 col-xs-12 col-sm-4"
                />
                <i class="ace-icon fa fa-percent"></i>
              </div>
            </div>
            <div class="col-md-6">
              <label class="control-label" for="desconto">Desconto</label>
              <div class="input-icon">
                <input
                  autofocus
                  type="number"
                  min="0"
                  v-model.number="produto.desconto_produto"
                  class="col-md-12 col-xs-12 col-sm-4"
                />
                <i class="ace-icon fa fa-percent"></i>
              </div>
            </div>
            <!-- <div class="col-md-6">
              <label class="control-label" for="desconto">Retenção</label>
              <div class="checkbox" style="margin-top: 0">
                <label class="block">
                  <input
                    name="form-field-checkbox"
                    v-model="produto.retencao_produto"
                    type="checkbox"
                    class="ace input-sm"
                  />
                  <span class="lbl bigger-100" style="padding: 7px"
                    >Aplicar retenção no item</span
                  >
                </label>
              </div>
            </div> -->
          </div>

          <div class="form-group">
            <div class="col-md-12" style="margin-top: 10px">
              <button
                class="btn btn-sm btn-success pull-left"
                @click.prevent="EditItemProduto"
                data-dismiss="modal"
              >
                <i class="ace-icon fa fa-check"></i>
                Salvar
              </button>
            </div>
          </div>
        </form>
      </div>
    </modal>
    <!-- FIM MODAL EDITAR QUANTIDADE DE PRODUTOS!-->

    <!-- MODAL DE CRIAR formapagamentos -->
    <div id="criar_formapagamento" class="modal fade criar_formapagamento">
      <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
        <div class="modal-content">
          <div class="modal-header text-center">
            <button type="button" class="close red bolder" data-dismiss="modal">
              ×
            </button>
            <h4 class="smaller">
              <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i>
              Adicionar Formas de Pagamento
            </h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-xs-12">
                <!-- AVISO -->
                <div class="alert alert-warning hidden-sm hidden-xs">
                  <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                  </button>
                  Os campos formapagamentodos com
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
            <div class="row" style="left: 0%; position: relative">
              <div class="col-md-12">
                <div class="search-form-text">
                  <div class="search-text">
                    <i class="fa fa-pencil"></i>
                    Formas de Pagamento
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
                        <div
                          id="dados_formapagamento"
                          class="tab-pane in active"
                        >
                          <div class="row">
                            <div class="form-group has-info">
                              <br /><br />
                              <label
                                style="padding-top: 10px"
                                class="
                                  col-sm-3
                                  control-label
                                  no-padding-right
                                  bold
                                "
                                for="designacao"
                                >Designação<span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                ></span>
                                <b class="red"
                                  ><i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i
                                ></b>
                              </label>
                              <div class="col-md-6">
                                <div class="input-group">
                                  <input
                                    type="text"
                                    v-model="formapagamento.designacao"
                                    placeholder="Informe a forma de pagamento"
                                    class="col-xs-12"
                                    :class="
                                      errors.designacao ? 'has-error' : ''
                                    "
                                    id="designacao"
                                    required
                                    style=""
                                  />
                                  <span class="input-group-addon">
                                    <i
                                      class="
                                        ace-icon
                                        fa fa-info
                                        bigger-150
                                        text-info
                                      "
                                    ></i>
                                  </span>
                                </div>
                                <span v-if="errors.designacao" class="error">{{
                                  errors.designacao[0]
                                }}</span>
                              </div>
                            </div>

                            <div class="form-group has-info">
                              <label
                                style="padding-top: 10px"
                                class="
                                  col-sm-3
                                  control-label
                                  no-padding-right
                                  bold
                                "
                                for="password"
                                >Tipo Pagamento
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                ></span
                              ></label>
                              <div class="col-md-6">
                                <div class>
                                  <Select2
                                    :options="tipoFormaPgt"
                                    v-model="formapagamento.tipoFormaPgt"
                                    placeholder="Selecione o status"
                                  >
                                  </Select2>
                                </div>
                              </div>
                            </div>

                            <div class="form-group has-info">
                              <label
                                style="padding-top: 10px"
                                class="
                                  col-sm-3
                                  control-label
                                  no-padding-right
                                  bold
                                "
                                for="password"
                                >Status
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                ></span
                              ></label>
                              <div class="col-md-6">
                                <div class>
                                  <Select2
                                    :options="statusGerais"
                                    v-model="formapagamento.status_id"
                                    placeholder="Selecione o status"
                                  >
                                  </Select2>
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
                          @click.prevent="salvarFormaPagamento"
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
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!--/ MODAL DE CRIAR formapagamentos-->

    <!-- MODAL Fecho de caixa  -->
    <div
      class="modal fade"
      id="modalFechoCaixa"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 460px">
          <div
            class="modal-header text-center"
            id="logomarca-header"
            style="background-color: #194969"
          >
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true" class="white">&times;</span>
            </button>
            <h4 class="smaller">
              <i class="fa fa-print bigger-110 text-default"></i> Imprimir Fecho
              de caixa
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
                  style="padding: 8px 19px 47px"
                >
                  <div id="edit-basic" class="tab-pane in active">
                    <div class="box box-primary">
                      <div class="box-body">
                        <div class="row">
                          <div class="col-md-6">
                            <label for="dataFinal" class="control-label"
                              >Data Inicio</label
                            >
                            <input
                              type="datetime-local"
                              autofocus
                              class="form-control"
                              v-model="fechoCaixa.dataFecho"
                              :class="errors.dataFecho ? 'is-invalid' : ''"
                              id="dataFinal"
                            />
                            <span v-if="errors.dataFecho" class="error">{{
                              errors.dataFecho[0]
                            }}</span>
                          </div>
                          <div class="col-md-6">
                            <label for="dataFinal" class="control-label"
                              >Data Final</label
                            >
                            <input
                              type="datetime-local"
                              autofocus
                              class="form-control"
                              v-model="fechoCaixa.dataFechoFim"
                              :class="errors.dataFechoFim ? 'is-invalid' : ''"
                              id="dataFinal"
                            />
                            <span v-if="errors.dataFechoFim" class="error">{{
                              errors.dataFechoFim[0]
                            }}</span>
                          </div>
                        </div>

                        <div class="row radio col-md-6">
                          <label>
                            <input
                              name="form-field-radio1"
                              v-model="fechoCaixa.tipoDoc"
                              :value="3"
                              type="radio"
                              class="ace input-sm"
                            />
                            <span class="lbl bigger-100">Ticket</span>
                          </label>
                          <label>
                            <input
                              name="form-field-radio2"
                              v-model="fechoCaixa.tipoDoc"
                              :value="1"
                              type="radio"
                              class="ace input-sm"
                            />
                            <span class="lbl bigger-100">A4</span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="clearfix form-actions">
                <div class="col-md-9">
                  <button
                    class="btn btn-info"
                    data-dismiss="modal"
                    type="submit"
                    @click.prevent="imprimirFechoCaixa"
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
    <!-- /MODAL Fecho de caixa-->

    <!-- CRIAR BANCOS -->
    <div id="editar_produto" class="modal fade">
      <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
        <div class="modal-content">
          <div class="modal-header text-center">
            <button type="button" class="close red bolder" data-dismiss="modal">
              ×
            </button>
            <h4 class="smaller">
              <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i>Editar
              produto
            </h4>
          </div>
          <div class="modal-body">
            <div class="row" style="left: 0%; position: relative">
              <div class="col-md-12">
                <form
                  enctype="multipart/form-data"
                  class="filter-form form-horizontal validation-form"
                  id
                >
                  <div class="second-row">
                    <div class="tabbable">
                      <ul class="nav nav-tabs padding-16">
                        <li class="active">
                          <a data-toggle="tab" href="#dados_banco">
                            <i
                              class="
                                green
                                ace-icon
                                fa fa-pencil-square
                                bigger-125
                              "
                            ></i>
                            Dados do Produto
                          </a>
                        </li>
                      </ul>

                      <div class="tab-content profile-edit-tab-content">
                        <div id="dados_banco" class="tab-pane in active">
                          <div class="form-group has-info">
                            <div class="col-md-4">
                              <label class="control-label" for="designacao">
                                Nome do produto
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                              </label>
                              <div class>
                                <input
                                  type="text"
                                  v-model="produtoEditar.designacao"
                                  id="designacao"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.designacao ? 'has-error' : ''"
                                  placeholder="Informe nome do produto"
                                />
                                <span v-if="errors.designacao" class="error">{{
                                  errors.designacao[0]
                                }}</span>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <label class="control-label" for="designacao">
                                Preço de Venda
                                <span
                                  class="tooltip-target"
                                  data-toggle="tooltip"
                                  data-placement="top"
                                >
                                  <i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i>
                                </span>
                              </label>
                              <div class>
                                <input
                                  type="number"
                                  v-model="produtoEditar.preco_venda"
                                  id="designacao"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="errors.preco_venda ? 'has-error' : ''"
                                  placeholder="Informe o preço de venda"
                                />
                                <span v-if="errors.preco_venda" class="error">{{
                                  errors.preco_venda[0]
                                }}</span>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <label class="control-label" for="designacao">
                                Preço de Compra
                              </label>
                              <div class>
                                <input
                                  type="number"
                                  v-model="produtoEditar.preco_compra"
                                  id="designacao"
                                  class="col-md-12 col-xs-12 col-sm-4"
                                  :class="
                                    errors.preco_compra ? 'has-error' : ''
                                  "
                                  placeholder="Informe o preço de compra"
                                />
                                <span
                                  v-if="errors.preco_compra"
                                  class="error"
                                  >{{ errors.preco_compra[0] }}</span
                                >
                              </div>
                            </div>
                          </div>
                          <div class="form-group has-info">
                            <div class="col-md-2">
                              <label class="control-label" for="status_id">
                                status
                                <b class="red"
                                  ><i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i
                                ></b>
                              </label>
                              <div class>
                                <Select2
                                  :options="statusGerais"
                                  v-model="produtoEditar.status_id"
                                  style="width: 100%"
                                >
                                </Select2>
                                <span v-if="errors.status_id" class="error">{{
                                  errors.status_id[0]
                                }}</span>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <label class="control-label" for="status_id">
                                Imposto/Taxas
                                <b class="red"
                                  ><i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i
                                ></b>
                              </label>
                              <div class>
                                <Select2
                                  :options="optionsTaxas"
                                  v-model="produtoEditar.codigo_taxa"
                                  @select="selecionarTaxa"
                                  style="width: 100%"
                                >
                                </Select2>
                                <span v-if="errors.codigo_taxa" class="error">{{
                                  errors.codigo_taxa[0]
                                }}</span>
                              </div>
                            </div>
                            <div class="col-md-7">
                              <label class="control-label" for="status_id">
                                Motivo de Isenção
                                <b class="red"
                                  ><i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i
                                ></b>
                              </label>
                              <div class>
                                <Select2
                                  :options="optionsMotivos"
                                  :disabled="disabledMotivos"
                                  v-model="produtoEditar.motivo_isencao_id"
                                  style="width: 100%"
                                >
                                </Select2>
                                <span
                                  v-if="errors.motivo_isencao_id"
                                  class="error"
                                  >{{ errors.motivo_isencao_id[0] }}</span
                                >
                              </div>
                            </div>
                          </div>
                          <div class="form-group has-info">
                            <div class="col-md-3">
                              <label class="control-label" for="status_id">
                                Controlar Stock
                                <b class="red"
                                  ><i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i
                                ></b>
                              </label>
                              <div class>
                                <Select2
                                  :options="controleStock"
                                  v-model="produtoEditar.stocavel"
                                  style="width: 100%"
                                >
                                </Select2>
                                <span v-if="errors.stocavel" class="error">{{
                                  errors.stocavel[0]
                                }}</span>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <label class="control-label" for="status_id">
                                Armazém
                                <b class="red"
                                  ><i
                                    class="
                                      fa fa-question-circle
                                      bold
                                      text-danger
                                    "
                                  ></i
                                ></b>
                              </label>
                              <div class>
                                <Select2
                                  :options="optionsArmazens"
                                  v-model="produtoEditar.armazem_id"
                                  :disabled="disabledArmazem"
                                  style="width: 100%"
                                >
                                </Select2>
                                <span v-if="errors.armazem_id" class="error">{{
                                  errors.armazem_id[0]
                                }}</span>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <label
                                class="control-label bold label-select2"
                                for="spinner3"
                              >
                                Existência no Stock<b
                                  class="red fa fa-question-circle"
                                ></b>
                              </label>
                              <div class="input-icon" id="quantidadeArmazem">
                                <vue-numeric-input
                                  id="quantidadeArmazem"
                                  v-model="produtoEditar.quantidade"
                                  :min="0"
                                ></vue-numeric-input>
                              </div>
                              <span v-if="errors.quantidade" class="error">{{
                                errors.quantidade[0]
                              }}</span>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                          <button
                            class="search-btn"
                            style="border-radius: 10px"
                            id="editarProduto1"
                            @click.prevent="editarProduto"
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
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- MODAL FILTRAR MENSAL  -->
    <div
      class="modal fade"
      id="modalRelatorioMensal"
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
                              <input type="month" v-model="filterMonthYear" />

                              <!-- <Select2 :options="statusOptions" v-model="filter.status_id">
                                                        </Select2> -->
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
                    @click.prevent="imprimirRelatorioMensal"
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
    <!-- /MODAL FILTRAR MENSAL-->

    <!-- MODAL FILTRAR MENSAL  -->
    <div
      class="modal fade"
      id="modalRelatorioPorFuncionarios"
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
                              <input type="date" v-model="filterDate" />
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
                    @click.prevent="imprimirTodosRelatorioDiarioPorFuncionario"
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
    <!-- /MODAL FILTRAR MENSAL-->

    <!-- MODAL DE CRIAR armazens -->
    <div id="vendaRapida" class="modal fade vendaRapida">
      <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
        <div class="modal-content">
          <div class="modal-header text-center">
            <button type="button" class="close red bolder" data-dismiss="modal">
              ×
            </button>
            <h4 class="smaller">
              <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i>
              Vendas Rápida
            </h4>
          </div>
          <div class="modal-body">
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
            <div class="row">
              <form
                method="POST"
                action
                enctype="multipart/form-data"
                class="filter-form form-horizontal validation-form"
                id="validation-form"
              >
                <div class="second-row">
                  <div class="form-group has-info">
                    <div class="col-md-12">
                      <label class="control-label" for="designacao">
                        Descrição do Produto/Serviço
                        <b class="red"
                          ><i class="fa fa-question-circle bold text-danger"></i
                        ></b>
                      </label>
                      <div class>
                        <input
                          type="text"
                          v-model="produt.designacao"
                          id="designacao"
                          class="col-md-12 col-xs-12 col-sm-4"
                          :class="errors.designacao ? 'has-error' : ''"
                          placeholder="descrição do produto ou serviço"
                        />
                        <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                      </div>
                    </div>
                  </div>
                  <div class="form-group has-info">
                    <div class="col-md-2">
                      <label class="control-label" for="designacao">
                        Qtd
                        <b class="red"
                          ><i class="fa fa-question-circle bold text-danger"></i
                        ></b>
                      </label>
                      <div class>
                        <input
                          type="number"
                          v-model="produt.quantidade_produto"
                          id="designacao"
                          class="col-md-12 col-xs-12 col-sm-4"
                          :class="errors.designacao ? 'has-error' : ''"
                          placeholder="0,00"
                        />
                        <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label class="control-label" for="designacao">
                        Valor
                        <b class="red"
                          ><i class="fa fa-question-circle bold text-danger"></i
                        ></b>
                      </label>
                      <div class>
                        <input
                          type="number"
                          v-model="produt.preco_venda_produto"
                          :min="0"
                          id="designacao"
                          class="col-md-12 col-xs-12 col-sm-4"
                          :class="errors.designacao ? 'has-error' : ''"
                          placeholder="0,00"
                        />
                        <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                      </div>
                    </div>
                    <div class="col-md-2">
                      <label class="control-label" for="designacao">
                        Desconto
                      </label>
                      <div class>
                        <input
                          type="number"
                          :min="0"
                          :max="100"
                          v-model="produt.produto_desconto"
                          id="designacao"
                          class="col-md-12 col-xs-12 col-sm-4"
                          :class="errors.designacao ? 'has-error' : ''"
                          placeholder="0,00"
                        />
                        <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                      </div>
                    </div>
                    <div class="col-md-1">
                      <label class="control-label" for="designacao">
                        IVA
                      </label>
                      <div class>
                        <input
                          type="checkbox"
                          v-model="produt.iva_produto"
                          id="designacao"
                          class="col-md-12 col-xs-12 col-sm-4"
                        />
                        <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class>
                        <label class="control-label" for="designacao">
                          Retenção
                        </label>
                        <input
                          type="checkbox"
                          v-model="produt.produto_retencao"
                          class="col-md-12 col-xs-12 col-sm-4"
                        />
                        <!-- <span v-if="errors.designacao" class="error">{{errors.designacao[0]}}</span> -->
                      </div>
                    </div>
                  </div>

                  <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                      <button
                        class="search-btn"
                        type="submit"
                        style="border-radius: 10px"
                        @click.prevent="adicionar"
                      >
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Adicionar
                      </button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ MODAL DE CRIAR armazens-->
  </div>
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";
import Swal from "sweetalert2";
import PesquisarCliente from "./PesquisarCliente";
import DatePicker from "vue2-datepicker";
import VueNumericInput from "vue-numeric-input";

import { showError, baseUrl } from "../../../config/global";

export default {
  components: {
    Select2,
    PesquisarCliente,
    DatePicker,
    VueNumericInput,
  },

  props: [
    "vencimentofacturaproforma",
    "vencimentofactura",
    "guard",
    "status",
    "taxas",
    "motivos",
    "impressao",
    "valorretencao",
    "descontomax",
  ],

  data() {
    return {
      filterMonthYear: "",
      filterYear: "",
      fechoCaixa: {
        dataFecho: "",
        dataFechoFim: "",
        tipoDoc: "",
      },
      filterDate: "",
      hora: "",
      existenciastock: [],
      disabledArmazem: true,
      controleStock: [
        {
          id: 1,
          text: "SIM",
        },
        {
          id: 2,
          text: "NÃO",
        },
      ],
      //produtos: [], //lista todos os produtos ao inicializar o craated
      optionsArmazens: [], //usado no selects para listagem dos armazens,
      tipoFormaPgt: [],
      produtos: [], //usado no selects para listagem de produtos,
      optionsClientes: [], //usado no selects para listagem de clientes,
      optionsMotivos: [],
      optionsTaxas: [],
      optionsFormaPagamentos: [],
      checkRetencao: false, //verifica se foi checado a retenção total,
      checkTipoDocumento: 1,
      descontoTotal: 0.0, //valor do desconto total,
      valorEntregue: 0.0,
      armazen_selecionado: null,
      queryProduto: null, //Pesquisa produtos e serviços,
      produto: {}, //object usado na hora de editar a quant, desconto, retenção de um produto
      facturacao: {
        produtos: [],
        cliente: {},
        desconto: 0.0, //desconto total
        retencao: 0.0, //valor da retencao total,
        total_preco_factura: 0,
        total_incidencia: 0,
        total_iva: 0,
        valor_a_pagar: 0,
        valor_entregue: 0,
        troco: 0,
        valor_extenso: "",
        codigo_moeda: 1,
        multa: 0,
        numeroItems: 0,
        tipo_documento: 1,
        tipoFolha: this.impressao.vida,
        total_retencao: 0,
        retificado: "Não",
        formaPagamento: 1,
        descricao: "",
        observacao: "",
        armazen_id: null,
        cliente_id: null,
        status_id: 1,
        canal_id: 2,
        formas_pagamento_id: null,
        desconto_max: this.descontomax,
      },
      disabledMotivos: false,
      errors: [],
      statusGerais: [],
      formapagamento: {
        status_id: 1, //inicia com status do select2 ativo
      },
      USUARIO_EMPRESA: 2,
      router: "",
      produtoEditar: {},
      produt: {
        id: 1,
        designacao: "",
        preco_venda_produto: 0,
        quantidade_produto: 1,
        iva_produto: false,
        taxa: 0,
        produto_desconto: 0,
      },

      /**
       * constantes usados
       */
      TIPODOC_FACTURA_RECIBO: 1,
      TIPODOC_FACTURA: 2,
      TIPODOC_PROFORMA: 3,
      USUARIO_FUNCIONARIO: 3,
    };
  },
  created() {
    // setInterval(() => {

    //     var agora = new Date();
    //     var hora = agora.getHours() + ":" + agora.getMinutes() + ":" + agora.getSeconds();
    //     this.hora = hora;

    // }, 1000);

    this.router =
      this.guard.tipo_user_id == this.USUARIO_EMPRESA
        ? window.location.origin + `/empresa`
        : window.location.origin + `/empresa/funcionario`;

    //this.listarTipoFormaPagamento();
    this.listarMotivos();
    this.listarTaxas();
    this.listarExistenciaStock();
    //this.listarArmazens()

    this.status.forEach((element) => {
      this.statusGerais.push({
        id: element.id,
        text: element.designacao,
      });
    });

    this.listar_armazens();
    this.listaClienteDiversos();
  },
  mounted() {
    //this.listar_produtos();
    this.listar_clientes();
    this.listar_pagamentos();
    //  this.setarFormatoFolha();
  },

  methods: {
    adicionar() {
      if (
        this.produt.quantidade_produto <= 0 ||
        this.produt.preco_venda_produto <= 0 ||
        !this.produt.designacao
      ) {
        this.$toasted.global.defaultError({
          msg: "Adicionar os campos obrigatório",
        });
        return;
      }

      const TAXA = 14;
      const taxa = this.produt.iva_produto ? TAXA : 0;

      const produto = {
        produto_id: this.produt.iva_produto ? 2 : 1,
        stocavel: "Não",
        desconto_produto: this.valor_desconto(
          this.produt,
          this.produt.quantidade_produto
        ),
        preco_venda_produto: parseFloat(this.produt.preco_venda_produto),
        preco_compra_produto: 0,
        total_preco_produto: this.total_preco_produto(
          this.produt,
          this.produt.quantidade_produto
        ),
        designacao: this.produt.designacao,
        retencao_produto: this.valor_retencao(
          this.produt,
          this.produt.quantidade_produto
        ),
        incidencia_produto: this.valor_incidencia(
          this.produt,
          this.produt.quantidade_produto
        ),
        quantidade_produto: this.produt.quantidade_produto,
        unidade: "un",
        iva_produto: this.iva_produto(
          this.produt,
          this.produt.quantidade_produto
        ),
        taxa: taxa,
        valor_com_iva: this.valor_com_iva(
          this.produt,
          this.produt.quantidade_produto
        ),
        categoria: "Diverso",
        categoria_id: 1,
      };

      this.facturacao.produtos.unshift(produto);
      this.setarValorTotalFacturacao();
      this.resetProdut();
    },
    resetProdut() {
      this.produt = {
        id: 1,
        designacao: "",
        preco_venda_produto: 0,
        quantidade_produto: 1,
        iva_produto: false,
        taxa: 0,
        produto_desconto: 0,
      };
    },

    adicionarProdut(prod, quant) {
      // this.facturacao.produtos.unshift({

      //   produto_id = parseInt(prod.id)

      // });

      console.log(prod);

      // this.facturacao.produtos.unshift({
      //   produto_id: parseInt(prod.id),
      //   quantidade_produto: quant,
      //   stocavel: "Não",
      //   desconto_produto: prod.desconto_produto,
      //   preco_venda_produto: prod.preco_venda_produto,
      //   preco_compra_produto: 0,
      //   total_preco_produto: this.total_preco_produto(prod, quant),
      //   designacao: prod.designacao,
      //   retencao_produto: this.valorRetencao(prod, quant),

      //   incidencia_produto: this.valorIncidencia(prod, quant),
      //   unidade: 1,
      //   iva_produto: this.ivaProduto(prod, quant),
      //   taxa: prod.taxa,
      //   valor_com_iva: this.valor_com_iva(prod, quant),
      //   categoria: prod.categoria,
      //   categoria_id: prod.categoria_id,
      // });
    },
    ivaProduto(produto, quantidade) {
      const TAXA = 14;
      return (TAXA / 100) * this.valorIncidencia(produto, quantidade);
    },
    valorRetencao(produto, quantidade) {
      return (
        this.valorIncidencia(produto, quantidade) * produto.retencao_produto
      );
    },
    valorIncidencia(produto, quantidade) {
      //valor incidencia por produto
      return (
        produto.preco_venda_produto * quantidade -
        this.valorDesconto(produto, quantidade)
      );
    },
    valorDesconto(produto, quantidade) {
      //valor desconto por produto
      return (
        (produto.preco_venda_produto * quantidade * produto.produto_desconto) /
        100
      );
    },
    popUp() {
      console.log("errro");
    },

    async imprimirTodosRelatorioDiarioPorFuncionario() {
      this.$loading(true);

      try {
        let response = await axios.get(
          `${this.router}/imprimirTodosRelatorioDiarioPorFuncionario?filterDate=${this.filterDate}`,
          {
            responseType: "arraybuffer",
          }
        );

        if (response.status == 200) {
          this.$loading(false);
          var file = new Blob([response.data], {
            type: "application/pdf",
          });
          var fileURL = URL.createObjectURL(file);
          window.open(fileURL);
          // document.location.reload(true)
        }
      } catch (error) {
        this.$loading(false);
        this.$toasted.global.defaultError({
          msg: "Nenhuma factura recibo efectuada no dia selecionado",
        });
        return;
      }
    },

    alterarFolha(tipoFolha) {
      this.facturacao.tipoFolha = tipoFolha;
    },

    // setarFormatoFolha() {

    //     const inputs = Array.from(document.querySelectorAll("#formatoFolha input"));
    //     inputs.forEach(input => {

    //         const value = input.getAttribute("value");

    //         console.log

    //         if (value == 2) {
    //             this.checked = true;

    //         }

    //         console.log(input);

    //     });

    //     console.log(document.querySelectorAll("#formatoFolha input"));

    // },

    selecionarTaxa(tx) {
      if (tx.taxa > 0) {
        this.produtoEditar.motivo_isencao_id = null;
        this.disabledMotivos = true;
      } else {
        this.disabledMotivos = false;
      }
      this.produtoEditar.taxa = tx.taxa;
    },

    async listarExistenciaStock() {
      try {
        let response = await axios.get(
          `${this.router}/produtos/existenciaStock`
        );

        if (response.status === 200) {
          return response.data.existenciastock;
        }
      } catch (error) {
        this.$toasted.global.defaultError({
          msg: "Erro ao editar Produto",
        });
        this.errors = error.response.data;
      }
    },

    async editarProduto() {
      this.errors = [];

      try {
        let response = await axios.put(
          `${this.router}/facturacao/produto/editar`,
          this.produtoEditar
        );
        if (response.status === 200) {
          this.listar_produtos();
          this.$toasted.global.defaultSuccess();
          // $('#editar_produto').modal('hide');
          // document.getElementById("editar_produto").style.display = "none";
        }
      } catch (error) {
        this.$toasted.global.defaultError({
          msg: "Erro ao editar Produto",
        });
        this.errors = error.response.data;
      }
    },

    listarMotivos() {
      this.motivos.forEach((motivo) => {
        this.optionsMotivos.push({
          id: motivo.codigo,
          text: motivo.descricao,
        });
      });
    },
    listarTaxas() {
      this.taxas.forEach((tx) => {
        this.optionsTaxas.push({
          id: tx.codigo,
          text: tx.descricao,
          taxa: tx.taxa,
        });
      });
    },
    setarTaxaMotivo(produtoTaxa) {
      if (produtoTaxa > 0) {
        this.produtoEditar.motivo_isencao_id = null;
        this.disabledMotivos = true;
      } else {
        this.disabledMotivos = false;
      }
    },
    async mostrarModalEditarProduto(produto, event) {
      this.setarTaxaMotivo(produto.taxa);

      this.listarExistenciaStock().then((existProd) => {
        existProd.find((existencia) => {
          if (
            existencia.produto_id === Number(produto.id) &&
            existencia.armazem_id === Number(this.armazen_selecionado)
          ) {
            this.produtoEditar = {
              designacao: produto.designacao,
              preco_venda: produto.preco_venda_produto,
              preco_compra: produto.preco_compra,
              status_id: produto.status_id,
              motivo_isencao_id: produto.motivo_isencao_id,
              codigo_taxa: produto.codigo_taxa,
              stocavel: produto.stocavel == "Sim" ? 1 : 2,
              armazem_id: existencia.armazem_id,
              quantidade: existencia.quantidade,
              produto_id: produto.id,
              taxa: produto.taxa,
            };
          }
        });
      });

      // console.log(existencia);
      // return;

      this.errors = [];

      // const existencia = this.existenciastock.find(existencia => {
      //     if (existencia.produto_id === Number(produto.id) && existencia.armazem_id === Number(this.armazen_selecionado)) {
      //         return existencia;
      //     }
      // });
    },

    inicializarDataFechoCaixa() {
      this.fechoCaixa.dataFecho = this.formatDate();
      this.fechoCaixa.dataFechoFim = this.formatDate();
      this.fechoCaixa.tipoDoc = 3;
    },
    formatDate() {
      var today = new Date();
      var dd = String(today.getDate()).padStart(2, "0");
      var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
      var yyyy = today.getFullYear();

      today = dd + "-" + mm + "-" + yyyy;

      return today;
    },

    async listarTipoFormaPagamento() {
      try {
        let response = await axios.get(
          `${baseUrl}/empresa/tipoFormaPagamentos`
        );
        if (response.status === 200) {
          response.data.forEach((element) => {
            this.tipoFormaPgt.push({
              id: element.id,
              designacao: element.designacao,
              sigla: element.sigla,
              text: element.sigla + " - " + element.designacao,
            });
          });
          /**
           * inicializa com pgt numerário
           */
          this.formapagamento.tipoFormaPgt = response.data[2].id;
        }
      } catch (error) {
        console.log("ERRO API");
      }
    },

    async listar_clientes() {
      let response = await axios.get(`${this.router}/listarClienteFacturacao`);

      if (response.status === 200) {
        response.data.forEach((item, index) => {
          this.optionsClientes.push({
            id: item.id,
            text: item.nome,
            canal_id: item.canal_id,
            conta_corrente: item.conta_corrente,
            data_contrato: item.data_contrato,
            email: item.email,
            empresa_id: item.empresa_id,
            endereco: item.endereco,
            gestor_id: item.gestor_id,
            limite_de_credito: item.limite_de_credito,
            nif: item.nif,
            numero_contrato: item.numero_contrato,
            operador: item.operador,
            pais_id: item.pais_id,
            pessoa_contacto: item.pessoa_contacto,
            status_id: item.status_id,
            taxa_de_desconto: item.taxa_de_desconto,
            telefone_cliente: item.telefone_cliente,
            tipo_cliente_id: item.tipo_cliente_id,
            tipo_conta_corrente: item.tipo_conta_corrente,
            website: item.website,
          });
        });

        // this.armazen_selecionado = response.data.armazens[0].id //seta o primeiro armazem no select2

        //res.data.armazens[0].id
        // console.log(response.data.armazens[0].id)
      }
    },
    async listaClienteDiversos() {
      try {
        let response = await axios.get(
          `${this.router}/facturacao/cliente_default`
        );
        if (response.status === 200) {
          let cliente = {
            nome_do_cliente: response.data.nome,
            telefone_cliente: response.data.telefone_cliente,
            nif_cliente: response.data.nif,
            email_cliente: response.data.email,
            endereco_cliente: response.data.endereco,
            conta_corrente_cliente: response.data.conta_corrente,
            cliente_id: response.data.id,
            diverso: response.data.diversos,
          };
          this.facturacao.cliente = Object.assign({}, cliente);

          return response.data;
        }
      } catch (error) {
        console.log(error);
      }
    },
    selecionaVendaNumerario() {
      this.facturacao.formas_pagamento_id = this.optionsFormaPagamentos[0].id;
    },

    listaFormaPagamentoCredito() {
      this.facturacao.formas_pagamento_id = this.optionsFormaPagamentos[1].id;

      // try {

      //     let response = await axios.get(`${this.router}/facturacao/formaPagamentos`);

      //     if (response.status === 200) {
      //         this.optionsFormaPagamentos = [] // REINICIALIZA CADA VEZ QUE É ADICIONADO NO SELECT2
      //         response.data.formasPagamento.forEach((item, index) => {
      //             this.optionsFormaPagamentos.push({
      //                 id: item.id,
      //                 text: item.designacao
      //             })
      //         });
      //         this.facturacao.formas_pagamento_id = response.data.formasPagamento[1].id
      //     }

      // } catch (error) {

      //     console.log("Erro na API LISTAR PAGAMENTO CREDITO")

      // }
    },

    async listar_pagamentos() {
      try {
        let response = await axios.get(
          `${this.router}/facturacao/formaPagamentos`
        );

        if (response.status === 200) {
          this.optionsFormaPagamentos = []; // REINICIALIZA CADA VEZ QUE É ADICIONADO NO SELECT2
          response.data.formasPagamento.forEach((item, index) => {
            this.optionsFormaPagamentos.push({
              id: item.id,
              text: item.descricao,
              tipo_credito: item.tipo_credito,
            });
          });
          this.facturacao.formas_pagamento_id =
            response.data.formasPagamento[0].id;
        }
      } catch (error) {
        console.log("Erro na API");
      }
    },

    async listar_armazens() {
      this.optionsArmazens = [];

      try {
        let response = await axios.get(`${this.router}/facturacao/armazens`);
        if (response.status === 200) {
          response.data.armazens.forEach((item, index) => {
            this.optionsArmazens.push({
              id: item.id,
              text: item.designacao,
            });
          });
          this.armazen_selecionado = response.data.armazens[0].id; //seta o primeiro armazem no select2
        }
      } catch (error) {
        console.log("Erro na API");
      }
    },
    async listar_produtos() {
      try {
        this.produtos = [];
        let response = await axios.get(
          `${this.router}/facturacao/produtos/${parseInt(
            this.armazen_selecionado
          )}`
        );
        if (response.status === 200) {
          response.data.produtos.forEach((element) => {
            this.produtos.push({
              id: element.id,
              text: element.designacao,
              designacao: element.designacao,
              preco_venda_produto: element.preco_venda,
              preco_compra: element.preco_compra,
              categoria_id: element.categoria_id,
              categoria: element.categoria,
              classe_id: element.classe_id,
              unidade: element.designacao_unidade_medida,
              fabricante_id: element.fabricante_id,
              user_id: element.user_id,
              status_id: element.status_id,
              codigo_taxa: element.codigo_taxa,
              motivo_isencao_id: element.motivo_isencao_id,
              quantidade_minima: element.quantidade_minima,
              quantidade: element.quantidade,
              quantidade_critica: element.quantidade_critica,
              referencia: element.referencia,
              codigo_barra: element.codigo_barra,
              data_expiracao: element.data_expiracao,
              descricao: element.descricao,
              stocavel: element.stocavel,
              taxa: element.taxa,
            });
          });

          // console.log(this.produtos)
        }
      } catch (error) {
        console.log("Erro na API");
      }
    },
    async imprimirRelatorioDiario() {
      this.$loading(true);

      try {
        let response = await axios.get(
          `${this.router}/imprimirRelatorioDiario`,
          {
            responseType: "arraybuffer",
          }
        );

        if (response.status == 200) {
          this.$loading(false);
          var file = new Blob([response.data], {
            type: "application/pdf",
          });
          var fileURL = URL.createObjectURL(file);
          window.open(fileURL);
          // document.location.reload(true);
        }
      } catch (error) {
        this.$loading(false);
        this.$toasted.global.defaultError({
          msg: "Nenhuma factura recibo efectuada na data de hoje",
        });
        return;
      }
    },
    async imprimirRelatorioMensal() {
      this.$loading(true);

      try {
        let response = await axios.get(
          `${this.router}/imprimirRelatorioMensal?filterMonthYear=${this.filterMonthYear}`,
          {
            responseType: "arraybuffer",
          }
        );

        if (response.status == 200) {
          this.$loading(false);
          var file = new Blob([response.data], {
            type: "application/pdf",
          });
          var fileURL = URL.createObjectURL(file);
          window.open(fileURL);
          document.location.reload(true);
        }
      } catch (error) {
        this.$loading(false);
        this.$toasted.global.defaultError({
          msg: "Nenhuma factura recibo efectuada no mês selecionado",
        });
        return;
      }
    },
    async imprimirRelatorioAnual() {
      this.$loading(true);

      try {
        let response = await axios.get(
          `${this.router}/imprimirRelatorioAnual`,
          {
            responseType: "arraybuffer",
          }
        );

        if (response.status == 200) {
          this.$loading(false);
          var file = new Blob([response.data], {
            type: "application/pdf",
          });
          var fileURL = URL.createObjectURL(file);
          window.open(fileURL);
          document.location.reload(true);
        }
      } catch (error) {
        this.$loading(false);
        this.$toasted.global.defaultError({
          msg: "Nenhuma factura recibo efectuada no ano selecionado",
        });
        return;
      }
    },

    async cadastrarFactura() {
      if (this.facturacao.tipo_documento === this.TIPODOC_FACTURA_RECIBO) {
        if (
          !this.facturacao.formas_pagamento_id ||
          this.facturacao.formas_pagamento_id === null
        ) {
          this.$toasted.global.defaultError({
            msg: "A forma de pagamento é obrigatório",
          });
          this.error = true;
          return;
        }
        if (this.facturacao.valor_entregue === null) {
          this.$toasted.global.defaultError({
            msg: "Informe o valor entregar",
          });
          this.error = true;
          return;
        }
        if (this.facturacao.valor_entregue < this.facturacao.valor_a_pagar) {
          this.$toasted.global.defaultError({
            msg: "O valor entregue é menor ao valor a pagar",
          });
          this.error = true;
          return;
        }
      }

      if (
        this.isEmpty(this.facturacao.cliente) &&
        this.isEmpty(this.facturacao.cliente)
      ) {
        this.$toasted.global.defaultError({
          msg: "Informe dados do cliente",
        });
        return;
      } else if (this.isEmpty(this.facturacao.produtos)) {
        this.$toasted.global.defaultError({
          msg: "Adicione item na facturação",
        });
        return;
      } else if (
        this.facturacao.cliente.diverso == "Sim" &&
        this.facturacao.tipo_documento == this.TIPODOC_FACTURA
      ) {
        this.$toasted.global.defaultError({
          msg: "Cliente diverso não emite factura",
        });
        return;
      } else {
        try {
          this.$loading(true);

          let response = await axios.post(
            `${this.router}/facturacao/salvar`,
            this.facturacao
          );

          if (response.data.status == 401) {
            this.$loading(false);
            this.$toasted.global.defaultError({
              msg: response.data.errors,
            });
            return;
          }

          if (response.status === 200 && response.data.status != 401) {
            this.$toasted.global.defaultSuccess();
            Swal.fire({
              title: "Sucesso",
              text: "Factura registada com sucesso!",
              icon: "success",
              confirmButtonColor: "#3d5476",
              confirmButtonText: "Ok",
            });

            if (this.impressao.valor !== "A4") {
              window.location.href = `/imprimirFacturaPdv1?facturaId=${response.data.factura.id}`;
              return;
            }

            let responseFactura = await axios.get(
              `${this.router}/facturacao/imprimir-factura/${response.data.factura.id}/${this.facturacao.tipoFolha}?nVia=1`,
              {
                responseType: "arraybuffer",
              }
            );

            let factura2 = await axios.get(
              `${this.router}/facturacao/imprimir-factura/${response.data.factura.id}/${this.facturacao.tipoFolha}?nVia=2`,
              {
                responseType: "arraybuffer",
              }
            );

            let factura3 = await axios.get(
              `${this.router}/facturacao/imprimir-factura/${response.data.factura.id}/${this.facturacao.tipoFolha}?nVia=3`,
              {
                responseType: "arraybuffer",
              }
            );

            if (responseFactura.status === 200) {
              this.$loading(false);
              var file = new Blob([responseFactura.data], {
                type: "application/pdf",
              });
              var file2 = new Blob([factura2.data], {
                type: "application/pdf",
              });
              var file3 = new Blob([factura3.data], {
                type: "application/pdf",
              });
              var fileURL = URL.createObjectURL(file);
              var fileURL2 = URL.createObjectURL(file2);
              var fileURL3 = URL.createObjectURL(file3);
              window.open(fileURL);
              window.open(fileURL2);
              window.open(fileURL3);
              this.limparTodosDadosFacturacao();
              // document.location.reload(true);
            } else {
              this.$loading(false);
              console.log("Erro ao carregar pdf");
            }
          }
        } catch (error) {
          console.log("Erro na API");
        }
      }
    },

    //Verifica objeto vazio
    isEmpty(obj) {
      return Object.keys(obj).length === 0;
    },

    showModal(produto) {
      let percentagemDesconto =
        (produto.desconto_produto * 100) /
        (produto.preco_venda_produto * produto.quantidade_produto);
      let order = {
        produto_id: produto.produto_id,
        designacao: produto.designacao,
        descontoAnterior: percentagemDesconto,
        quantidade_produto: produto.quantidade_produto,
        retencao_produto:
          produto.retencao_produto || this.facturacao.retencao ? true : false,
      };
      this.produto = Object.assign({}, order);
      this.$modal.show("set-edit-facturacao");
    },
    CloseModal() {
      this.$modal.hide("set-edit-facturacao");
    },
    EditItemProduto() {
      // console.log(this.produto);return;
      this.editaDadosProdutoNoCarrinho(this.produto);
      this.setarValorTotalFacturacao();
      this.$modal.hide("set-edit-facturacao");

      /*
      return;
      
      this.produto.quantidade_produto = parseInt(this.produto.quantidade_produto); //converte int
      this.produto.desconto_produto = parseInt(this.produto.desconto_produto); //converte int


      //Verifica se existe uma retenção geral
      if (this.checkRetencao && !this.produto.retencao_produto) {
        this.$toasted.global.defaultError({
          msg: "Encontra activo a retenção na fonte",
        });
      }else {
        //ENTRA AQUI CASO NÃO FOR SETADO UM DESCONTO GERAL E UM RETENÇÃO GERAL
        if (this.produto.desconto_produto >= 0 && this.produto.quantidade_produto >= 0) {

          let totalDesconto = this.produto.desconto_produto ? this.produto.desconto_produto:0 + this.descontoTotal?this.descontoTotal:0;


          if (totalDesconto > this.facturacao.desconto_max) {
            this.$toasted.global.defaultError({
              msg: `O valor máximo de desconto é de ${this.facturacao.desconto_max}%`,
            });
            //this.desconto_produto = this.desconto_max
          } else {
            this.editaDadosProdutoNoCarrinho(this.produto);
            this.$modal.hide("set-edit-facturacao");
          }
        } else {
          this.produto.desconto_produto = this.produto.desconto_produto;
          this.produto.quantidade_produto = this.produto.quantidade_produto;
        }
      }
      */
    },
    //Este metodo edita a quantidade, desconto, e retenção que estão no carrinho da facturação
    editaDadosProdutoNoCarrinho(order) {
      const prod = this.facturacao.produtos.find(
        (element) => element.produto_id == order.produto_id
      );

      let retencao = order.retencao_produto ? this.valorretencao / 100 : 0.0;

      // //Verifica se produto encontra no carrinho
      if (prod != undefined) {
        // console.log(prod);
        // return;

        const produtoInfo = this.produtos.find((produto) => {
          return produto.id == prod.produto_id;
        });

        if (
          this.verificarQtProdutoEstoque(produtoInfo, order.quantidade_produto)
        ) {
          var totalDesconto =
            (order.desconto_produto ? order.desconto_produto : 0) +
            (this.descontoTotal ? this.descontoTotal : 0);

          prod.quantidade_produto = order.quantidade_produto;

          prod.desconto_produto =
            (prod.preco_venda_produto *
              prod.quantidade_produto *
              totalDesconto) /
            100;

          prod.total_preco_produto = this.total_preco_produto(
            prod,
            prod.quantidade_produto
          );

          prod.retencao_produto =
            (prod.preco_venda_produto * prod.quantidade_produto -
              prod.desconto_produto) *
            retencao;

          prod.incidencia_produto =
            prod.preco_venda_produto * prod.quantidade_produto -
            prod.desconto_produto;
          prod.iva_produto = (prod.taxa / 100) * prod.incidencia_produto;
          prod.valor_com_iva =
            prod.incidencia_produto + prod.iva_produto - prod.retencao_produto;

          this.setarValorTotalFacturacao();
        } else {
          this.$toasted.global.defaultError({
            msg: "Quantidade indisponivel no stock",
          });
          return;
        }

        // prod.quantidade_produto = order.quantidade_produto;
        // //aplica desconto cada haver
        // let desconto_produto = (prod.preco_venda_produto * prod.quantidade_produto) * order.desconto_produto / 100

        // //calculo da incidencia de cada produto
        // let incidencia = (prod.preco_venda_produto * prod.quantidade_produto) - desconto_produto;

        // //calculo retencao de cada produto
        // let retencao_produto = (prod.preco_venda_produto * prod.quantidade_produto) * retencao

        // //aplica desconto cada haver
        // prod.desconto_produto = desconto_produto
        // prod.total = prod.quantidade_produto * prod.quantidade_produto

        // prod.retencao_produto = retencao_produto
        // prod.incidencia_produto = incidencia
        // prod.iva_produto = this.iva_produto(prod, prod.quantidade_produto)
        // prod.total_preco_produto = (prod.preco_venda_produto * prod.quantidade_produto)
        // prod.valor_com_iva = (incidencia + prod.iva_produto) - retencao_produto
      }
      //this.setarValorTotalFacturacao();

      // this.commit("SET_VALORES_TOTAL_FACTURACAO");
    },
    adicionarProduto(produto) {
      var prod = this.verificaProdutoExisteCarrinho(produto);
      if (prod != undefined) {
        //params el existe no carrinho
        let quant = prod.quantidade_produto;
        quant++;

        if (this.verificarQtProdutoEstoque(produto, quant)) {
          prod.quantidade_produto++;

          prod.desconto_produto = this.valor_desconto(
            prod,
            prod.quantidade_produto
          );
          prod.total_preco_produto = this.total_preco_produto(
            prod,
            prod.quantidade_produto
          );

          prod.retencao_produto = this.valor_retencao(
            prod,
            prod.quantidade_produto
          );
          prod.incidencia_produto = this.valor_incidencia(
            prod,
            prod.quantidade_produto
          );
          prod.iva_produto = this.iva_produto(prod, prod.quantidade_produto);
          prod.valor_com_iva = this.valor_com_iva(
            prod,
            prod.quantidade_produto
          );

          this.setarValorTotalFacturacao();
        } else {
          this.$toasted.global.defaultError({
            msg: "Quantidade indisponivel no stock",
          });
          return;
        }
      } else {
        //Nao Existe no carrinho
        let quant = 1;
        if (this.verificarQtProdutoEstoque(produto, quant)) {
          this.adicionarProdutoNoCarrinho(produto, quant);
          this.setarValorTotalFacturacao();
        } else {
          this.$toasted.global.defaultError({
            msg: "Quantidade indisponivel no stock",
          });
        }
      }
    },

    verificarQtProdutoEstoque(produto, quantAdicionado) {
      const PROFORMA = 3;

      if (
        produto.stocavel == "Não" ||
        this.facturacao.tipo_documento === PROFORMA
      ) {
        return true;
      } else {
        return produto.quantidade >= quantAdicionado ? true : false;
      }
    },

    adicionarCliente(el) {
      this.facturacao.cliente = {
        cliente_id: parseInt(el.id),
        conta_corrente_cliente: el.conta_corrente,
        endereco_cliente: el.endereco,
        email_cliente: el.email,
        nif_cliente: el.nif,
        telefone_cliente: el.telefone_cliente,
        nome_do_cliente: el.text,
      };
      this.desactivaInputsCliente();
    },

    desactivaInputsCliente() {
      $(".inputCliente input").attr("disabled", "true");
    },
    ativaInputsClientes() {
      $(".inputCliente input").removeAttr("disabled");
    },
    limparInputCliente() {
      Swal.fire({
        title: "Deseja limpar dados do cliente?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ok",
      }).then((result) => {
        if (result.value) {
          this.facturacao.cliente = {};
          this.ativaInputsClientes();
        }
      });
    },
    limparTodosItem() {
      //limpar todos itens da facturação

      Swal.fire({
        title: "Deseja limpar todos itens?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ok",
      }).then((result) => {
        if (result.value) {
          this.limparTodosDadosFacturacao(); //limpar
        }
      });
    },
    limparTodosDadosFacturacao() {
      this.checkRetencao = false; //verifica se foi checado a retenção total,
      this.checkTipoDocumento = 1;
      this.descontoTotal = 0.0; //valor do desconto total,
      (this.facturacao.produtos = []), (this.valorEntregue = 0);
      this.facturacao.cliente = Object.assign({}, this.listaClienteDiversos());
      this.facturacao.desconto = 0.0; //desconto total
      this.facturacao.retencao = 0.0; //valor da retencao total,
      this.facturacao.total_preco_factura = 0;
      this.facturacao.total_incidencia = 0;
      this.facturacao.total_iva = 0;
      this.facturacao.valor_a_pagar = 0;
      this.facturacao.valor_entregue = 0;
      this.facturacao.troco = 0;
      this.facturacao.valor_extenso = "";
      this.facturacao.codigo_moeda = 1;
      this.facturacao.multa = 0;
      this.facturacao.numeroItems = 0;
      this.facturacao.tipo_documento = 1;
      this.facturacao.tipoFolha = this.impressao.vida;
      this.facturacao.total_retencao = 0;
      this.facturacao.retificado = "Não";
      this.facturacao.formaPagamento = 1;
      this.facturacao.descricao = "";
      this.facturacao.observacao = "";
      this.facturacao.armazen_id = this.armazen_selecionado;
      this.facturacao.status_id = 1;
      // this.facturacao.formas_pagamento_id = null

      this.ativaInputsClientes();
    },
    //Adiciona elementos no carrinho
    adicionarProdutoNoCarrinho(prod, quant) {
      this.facturacao.produtos.unshift({
        produto_id: parseInt(prod.id),
        quantidade_produto: quant,
        stocavel: prod.stocavel,
        desconto_produto: this.valor_desconto(prod, quant),
        preco_venda_produto: prod.preco_venda_produto,
        preco_compra_produto: prod.preco_compra,
        total_preco_produto: this.total_preco_produto(prod, quant),
        designacao: prod.designacao,
        retencao_produto: this.valor_retencao(prod, quant),
        incidencia_produto: this.valor_incidencia(prod, quant),
        unidade: prod.unidade,
        iva_produto: this.iva_produto(prod, quant),
        taxa: prod.taxa,
        valor_com_iva: this.valor_com_iva(prod, quant),
        categoria: prod.categoria,
        categoria_id: prod.categoria_id,
      });
    },

    quantidadeProdutoCarrinho() {
      return this.facturacao.produtos.length;
    },
    // setarValorNoPush(prod, quant) { //seta valor no push do metodo adicionarProdutoNoCarrinho

    //     return {
    //         produto_id: parseInt(prod.id),
    //         quantidade_produto: quant,
    //         stocavel: prod.stocavel,
    //         desconto_produto: this.valor_desconto(prod, quant),
    //         preco_venda_produto: prod.preco_venda_produto,
    //         preco_compra_produto: prod.preco_compra,
    //         total_preco_produto: this.total_preco_produto(prod, quant),
    //         descricao_produto: prod.designacao,
    //         retencao_produto: this.valor_retencao(prod, quant),
    //         incidencia_produto: this.valor_incidencia(prod, quant),
    //         unidade: prod.unidade,
    //         iva_produto: this.iva_produto(prod, quant),
    //         taxa: prod.taxa,
    //         valor_com_iva: this.valor_com_iva(prod, quant)
    //     }

    // },

    verificaProdutoExisteCarrinho(produto) {
      return this.facturacao.produtos.find(
        (element) => element.produto_id === parseInt(produto.id)
      );
    },
    setarValorTotalFacturacao() {
      //seta todos os valores totais da facturação

      //console.log(this.facturacao.desconto)
      this.facturacao.total_preco_factura = 0;
      this.facturacao.valor_a_pagar = 0;
      this.facturacao.desconto = 0;
      this.facturacao.numeroItems = 0;
      this.facturacao.total_retencao = 0;
      this.facturacao.total_incidencia = 0;
      this.facturacao.total_iva = 0;
      this.facturacao.troco = 0;

      this.facturacao.produtos.map((item, index) => {
        this.facturacao.desconto +=
          this.facturacao.produtos[index].desconto_produto;
        this.facturacao.numeroItems +=
          this.facturacao.produtos[index].quantidade_produto;
        this.facturacao.total_retencao +=
          this.facturacao.produtos[index].retencao_produto;
        this.facturacao.total_incidencia +=
          this.facturacao.produtos[index].incidencia_produto;
        this.facturacao.total_iva +=
          this.facturacao.produtos[index].iva_produto;
        this.facturacao.total_preco_factura +=
          this.facturacao.produtos[index].total_preco_produto;
      });

      this.facturacao.valor_a_pagar =
        this.facturacao.total_preco_factura +
        this.facturacao.total_iva -
        (this.facturacao.desconto + this.facturacao.total_retencao);
      //valor troco

      // console.log(this.descontoTotal)

      if (parseInt(this.valorEntregue)) {
        if (this.facturacao.valor_a_pagar) {
          this.facturacao.troco =
            parseInt(this.facturacao.valor_entregue) -
            this.facturacao.valor_a_pagar;
        }
      } else {
        this.facturacao.troco = 0;
      }

      //Formatação do valor extenso
      var extenso = require("extenso");
      let valor_pagar_toFixed = this.facturacao.valor_a_pagar.toFixed(2);
      let valor_a_pagar = valor_pagar_toFixed.toString().replace(".", ",");

      this.facturacao.valor_extenso = extenso(valor_a_pagar, {
        number: {
          decimal: "informal",
        },
      });
    },
    removeItemFacturacao(prodId) {
      //metodo para remover um item na carrinho

      Swal.fire({
        title: "Deseja remover o item?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ok",
      }).then((result) => {
        if (result.value) {
          this.facturacao.produtos.forEach((data, index) => {
            if (data.produto_id === prodId) {
              this.facturacao.desconto -=
                this.facturacao.produtos[index].desconto_produto;
              this.facturacao.numeroItems -=
                this.facturacao.produtos[index].quantidade_produto;
              this.facturacao.total_retencao -=
                this.facturacao.produtos[index].retencao_produto;
              this.facturacao.total_incidencia -=
                this.facturacao.produtos[index].incidencia_produto;
              this.facturacao.total_iva -=
                this.facturacao.produtos[index].iva_produto;
              this.facturacao.total_preco_factura -=
                this.facturacao.produtos[index].total_preco_produto;
              this.facturacao.produtos.splice(index, 1); //remove um item no array pelo index
            }
          });
          this.setarValorTotalFacturacao();
        }
      });
    },
    adicionarRetencaoTodoItem() {
      //aplica retenção em todo item

      // this.facturacao.total_preco_factura = 0;
      // this.facturacao.valor_a_pagar = 0;
      // this.facturacao.numeroItems = 0;
      // this.facturacao.total_retencao = 0;
      // this.facturacao.total_incidencia = 0;
      // this.facturacao.total_iva = 0;

      this.facturacao.produtos.map((item, index) => {
        //aplica desconto cada haver
        //let desconto_produto = this.valor_desconto(item, item.quantidade_produto)

        let incidencia = this.valor_incidencia(item, item.quantidade_produto);
        //calcula iva produto
        let iva_produto = this.iva_produto(item, item.quantidade_produto);
        //calculo retencao de cada produto
        let retencao_produto = this.valor_retencao(
          item,
          item.quantidade_produto
        );
        //console.log(iva_produto)
        this.facturacao.produtos[index].retencao_produto = retencao_produto;
        this.facturacao.produtos[index].valor_com_iva =
          incidencia + iva_produto - retencao_produto;
      });
      this.setarValorTotalFacturacao();
    },
    adicionaDescontoTodoItem() {
      //adiciona desconto para cada item

      this.facturacao.produtos.map((item, index) => {
        //aplica desconto cada haver
        let desconto_produto = this.valor_desconto(
          item,
          item.quantidade_produto
        );

        let incidencia = this.valor_incidencia(item, item.quantidade_produto);
        //calcula iva produto
        let iva_produto = this.iva_produto(item, item.quantidade_produto);
        //calculo retencao de cada produto
        let retencao_produto = this.valor_retencao(
          item,
          item.quantidade_produto
        );

        this.facturacao.produtos[index].desconto_produto = desconto_produto;
        this.facturacao.produtos[index].retencao_produto = retencao_produto;
        this.facturacao.produtos[index].iva_produto = iva_produto;
        this.facturacao.produtos[index].valor_com_iva =
          incidencia + iva_produto - retencao_produto;
        this.facturacao.produtos[index].incidencia_produto = incidencia;
      });
      this.setarValorTotalFacturacao();
    },
    valor_desconto(produto, quantidade) {
      var descontoItem =
        produto.produto_desconto == undefined ? 0 : produto.produto_desconto;
      var descontoGeral =
        this.descontoTotal == undefined ? 0 : this.descontoTotal;

      let desconto = parseInt(descontoItem) + parseInt(descontoGeral);

      return (produto.preco_venda_produto * quantidade * desconto) / 100;
    },
    valor_incidencia(produto, quantidade) {
      //valor incidencia por produto
      return (
        produto.preco_venda_produto * quantidade -
        this.valor_desconto(produto, quantidade)
      );
    },
    iva_produto(produto, quantidade) {
      //valor iva por produto
      // console.log(produto);
      // const TAXA = 14;
      // let taxa = produto.iva_produto ? TAXA : produto.taxa;
      return (produto.taxa / 100) * this.valor_incidencia(produto, quantidade);
    },
    total_preco_produto(produto, quantidade) {
      return produto.preco_venda_produto * quantidade;
    },
    valor_retencao(produto, quantidade) {
      let retencao = produto.produto_retencao
        ? this.valorretencao / 100
        : this.facturacao.retencao;
      return this.valor_incidencia(produto, quantidade) * retencao;
    },
    valor_com_iva(produto, quantidade) {
      return (
        this.valor_incidencia(produto, quantidade) +
        this.iva_produto(produto, quantidade) -
        this.valor_retencao(produto, quantidade)
      );
    },
    // watch: {
    //     retencao() {
    //         this.totalPagar = this.retencao;
    //     }
    // },
    // computed: {
    //     incidencia() {
    //         return (this.preco * this.quant) - this.desconto;

    //     },
    //     desconto() {
    //         return (this.preco * this.quant) * this.desconto / 100
    //     },
    //     ivaProduto(){
    //         return  this.(order.iva_produto / 100) * incidencia
    //     }
    // }

    // SALVAR DEPENDÊNCIAS

    // Formas de Pagamento
    salvarFormaPagamento() {
      this.errors = [];

      let el = this.tipoFormaPgt.find((el) => {
        if (el.id == this.formapagamento.tipoFormaPgt) {
          return el;
        }
      });

      let newEl = {
        descricao_tipo_pagamento: el.designacao,
        sigla_tipo_pagamento: el.sigla,
        tipo_pagamento_id: el.id,
      };

      this.formapagamento = Object.assign(this.formapagamento, newEl);

      axios
        .post(`${this.router}/formapagamento/adicionar`, this.formapagamento)
        .then((res) => {
          if (res.status === 200) {
            this.$toasted.global.defaultSuccess();
            Swal.fire({
              title: "Sucesso",
              text: "formapagamento registada com sucesso!",
              icon: "success",
              confirmButtonColor: "#3d5476",
              confirmButtonText: "Ok",
              onClose: () => {
                document.location.reload(true);
              },
            });

            // this.listarTipoFormaPagamento();

            // this.formapagamento = {
            //     status_id: 1, //inicia com status do select2 ativo
            // }
            // this.reset();
          }
        })
        .catch((error) => {
          if (error.response.status == 422) {
            this.$toasted.global.defaultError({
              msg: "Erro ao cadastrar",
            });
            this.errors = error.response.data.errors;
          }
        });
    },
    limparCarrinho() {
      this.facturacao.produtos = [];
    },
    async imprimirFechoCaixa() {
      this.$loading(true);

      try {
        let response = await axios.post(
          `${this.router}/fechocaixa/imprimir`,
          this.fechoCaixa,
          { responseType: "arraybuffer" }
        );
        // let response = await axios.post(`${this.router}/fechocaixa/imprimir`,this.fechoCaixa,{responseType: "arraybuffer"});
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
        if (error.response.status == 401) {
          this.$toasted.global.defaultError({
            msg: "Não existe documento referente esta data",
          });
          this.$loading(false);
          return;
        }
      }
    },
    selecionarFormaPagamento(pagamento) {
      const TIPO_CREDITO = 1;

      if (pagamento.tipo_credito == TIPO_CREDITO) {
        this.checkTipoDocumento = 2; //checked factura
        this.facturacao.tipo_documento = 2; //factura
        this.facturacao.valor_entregue = 0;
        this.facturacao.troco = 0;
        this.valorEntregue = 0; //valor entregue do input Geral

        this.listaFormaPagamentoCredito();
        // this.optionsFormaPagamentos = []
        this.limparCarrinho();
        $("#disabled-pagamento").attr("disabled", "true");
        $("#disabled-valor_pagar").attr("disabled", "true");
      }
    },

    currency(value) {
      return value.toLocaleString("de-DE", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 3,
      });
    },
  },

  watch: {
    "produt.preco_venda_produto"() {
      this.produt.preco_venda_produto =
        this.produt.preco_venda_produto < 0
          ? 0
          : this.produt.preco_venda_produto;
    },
    "produt.quantidade_produto"() {
      this.produt.quantidade_produto =
        this.produt.quantidade_produto < 0 ? 0 : this.produt.quantidade_produto;
    },
    "produt.produto_desconto"() {
      this.produt.produto_desconto =
        this.produt.produto_desconto < 0
          ? 0
          : this.produt.produto_desconto > 100
          ? 100
          : this.produt.produto_desconto;
    },
    checkRetencao() {
      this.facturacao.retencao = this.checkRetencao
        ? this.valorretencao / 100
        : 0.0;

      if (this.facturacao.produtos.length) {
        this.adicionarRetencaoTodoItem();
      }
    },
    descontoTotal() {
      if (this.descontoTotal >= 0) {
        if (this.descontoTotal > this.facturacao.desconto_max) {
          this.$toasted.global.defaultError({
            msg: `O valor máximo de desconto é de ${this.facturacao.desconto_max}%`,
          });
          this.descontoTotal = this.facturacao.desconto_max;
          this.facturacao.desconto = this.descontoTotal;
        } else {
          this.facturacao.desconto = this.descontoTotal; //30
          this.adicionaDescontoTodoItem();
        }
      } else {
        this.descontoTotal = 0;
      }
    },
    armazen_selecionado() {
      this.produtos = [];
      this.facturacao.armazen_id = parseInt(this.armazen_selecionado);
      this.limparTodosDadosFacturacao();
      this.listar_produtos();
    },
    valorEntregue() {
      if (this.valorEntregue && this.valorEntregue >= 0) {
        //if (this.facturacao.valor_a_pagar) {
        this.facturacao.valor_entregue = this.valorEntregue;
        this.facturacao.troco = this.facturacao.valor_a_pagar
          ? this.valorEntregue - this.facturacao.valor_a_pagar
          : 0;

        // }
      } else {
        if (this.valorEntregue < 0) {
          this.valorEntregue = 0;
        }
        this.facturacao.troco = 0;
        //  this.valorEntregue = 0;
      }
    },

    checkTipoDocumento() {
      switch (this.checkTipoDocumento) {
        case 1:
          this.facturacao.tipo_documento = 1; //factura recibo

          this.limparCarrinho();
          this.selecionaVendaNumerario();
          $("#disabled-pagamento").removeAttr("disabled");
          $("#disabled-valor_pagar").removeAttr("disabled");

          //$("#disabled-pagamento").re("disabled", "false");
          break;
        case 2:
          this.facturacao.tipo_documento = 2; //factura
          this.facturacao.valor_entregue = 0;
          this.facturacao.troco = 0;
          this.valorEntregue = 0; //valor entregue do input Geral

          this.listaFormaPagamentoCredito();
          // this.optionsFormaPagamentos = []
          this.limparCarrinho();
          $("#disabled-pagamento").attr("disabled", "true");
          $("#disabled-valor_pagar").attr("disabled", "true");
          break;
        case 3:
          this.facturacao.tipo_documento = 3;
          this.facturacao.valor_entregue = 0;
          this.facturacao.formas_pagamento_id = null;
          this.valorEntregue = 0; //valor entregue do input Geral
          this.facturacao.troco = 0;
          // this.optionsFormaPagamentos = []
          this.limparCarrinho();
          $("#disabled-pagamento").attr("disabled", "true");
          $("#disabled-valor_pagar").attr("disabled", "true");
          break;
      }
      // this.limparTodosDadosFacturacao();
    },
  },

  computed: {
    resultQueryProduto() {
      if (this.queryProduto) {
        return this.produtos.filter((item) => {
          return (
            item.designacao.toLowerCase().match(this.queryProduto) ||
            item.id == this.searchQuery
          ); // quando o valor a pesquisar é um inteiro
        });
      } else {
        return this.produtos;
      }
    },
  },
};
</script>

<style scoped>
.popUp {
  top: -28px;
  left: 0px;
  /* width: 100%; */
  width: 140px;
  /* height: 50px; */
  background: #307ecc;
  color: white;
  border-radius: 5px;
  position: unset;
}
.tooltip:hover .tooltiptext {
  visibility: visible;
}

.produtoItem:hover {
  background: #bcd4e0;
}
.popUp p {
  font-size: 12px;
  margin: 0;
  padding-left: 5px;
}
.FormatoImpressao label {
  font-weight: 600;
  font-size: 14px;
  display: flex;
  align-items: center;
  cursor: pointer;
  /* margin-left: -19px; */
  background: #ccc;
  padding: -3px;
  border-radius: 6px;
  padding-right: 11px;
  padding-left: 11px;
  margin-right: 10px;
  color: #333;
}

.FormatoImpressao input {
  height: 25px;
}

#quantProdutoCarrinho {
  position: absolute;
  font-size: 15px;
  color: white;
  font-weight: 600;
}

#btnFechoCaixa {
  margin-top: 10px;
}

#btnFechoCaixa a {
  padding: 10px;
  background: #2f8fce;
  color: white;
  cursor: pointer;
  border-radius: 5px;
  font-size: 14px;
}

::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey;
  border-radius: 10px;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #103d54;
  border-radius: 10px;
}

#content-facturacao {
  margin-top: 20px;
}

#content-facturacao {
}

.alert {
  padding: 8px;
  font-size: 11px;
}

.nav-tabs.tab-color-blue > li > a {
  background-color: #307ecc;
}

.nav-tabs.tab-color-blue > li.active > a,
.nav-tabs.tab-color-blue > li.active > a:focus,
.nav-tabs.tab-color-blue > li.active > a:hover {
  background-color: white;
  color: #333;
}

#info-total {
  display: flex;
  flex-direction: column;
  border: 1px solid #ccbfbf;
  background: #0c1b25;
  color: white;
  padding: 10px;
  border-radius: 5px 5px 0px 0;
}

.total-item {
  padding: 2px;
  border-bottom: 1px solid #504848;
  display: flex;
  justify-content: space-between;
}

.total-item span {
  color: #fff;
}

.checkbox label input[type="checkbox"].ace + .lbl {
  margin-left: -19px;
  background: #ccc;
  padding: 10px;
  border-radius: 5px;
  color: #333;
}

.radio label input[type="radio"].ace + .lbl {
  margin-left: -19px;

  background: #ccc;
  padding: 4px;
  border-radius: 5px;
  color: #333;
}

.tipoFacturar {
  display: flex;
}

.inputFormPag {
  margin-bottom: 7px;
}

input {
  height: 35px;
  border-radius: 5px !important;
}

.alert-info {
  background: #103d54;
  color: white;
  height: 73px;
}

.widget-color-dark > .widget-header {
  background: #333;
}

.content-produto {
  border-bottom: 1px solid #e2dbdb;
  padding-bottom: 10px !important;
  padding-top: 10px !important;
}

.produto-item:hover {
  cursor: pointer;
}

.produto-info {
  height: 85px;
  color: white;
}

.grid-facturacao {
  border: 1px solid #e8e8e8;
  height: 100%;
}

#content-facturacao {
  height: 688px;
}

.search-query {
  border: 1px solid #6fb3e0;
  border-radius: 4px !important;
  padding-left: 24px;
}

.search-query:focus {
  border: 1px solid #6fb3e0;
}

span.input-form-icon {
  position: relative;
}

span.input-form-icon .ace-icon {
  padding: 0 3px;
  z-index: 2;
  position: absolute;
  top: 1px;
  bottom: 1px;
  left: 3px;
  line-height: 30px;
  display: inline-block;
  color: #6fb3e0 !important;
  font-size: 16px;
}

#icon-remove {
  left: 236px;
  cursor: pointer;
}

table tr,
th {
  height: 20px;
  font-size: 13px;
  font-family: unset;
  cursor: pointer;
}

#semProduto {
  display: flex;
  justify-content: center;
  text-align: center;
  padding-top: 15px;
  border: 1px solid #ccc;
  padding-bottom: 20px;
}

#semProduto .text {
  font-size: 13px;
  font-weight: 500;
  /* letter-spacing: 0.2rem; */
}

.semProdutoDescription {
  display: flex;
  flex-direction: column;
}

#btn-modal-edit-facturacao button {
  margin-top: 20px;
}

.modal-header#modalEditFactura {
  background-color: #307ecc;
  color: white;
}

.modal-header#modalEditFactura h3.smaller {
  color: white !important;
}

.search-form-text #valorPgt {
  display: inline-block;
  font-size: 20px;
  color: #fff;
  text-transform: uppercase;
  background: #333;
  padding: 13px 30px;
  font-weight: 700;
}

#headerTitle {
  display: flex;
  justify-content: space-between;
}

.scroller {
  width: 100%;
  height: 457px;
  overflow-y: scroll;
  scrollbar-color: rebeccapurple green;
}

abbr {
  position: relative;
}

abbr:hover::after {
  background: #add8e6;
  border-radius: 4px;
  bottom: 100%;
  content: attr(title);
  display: block;
  left: 100%;
  padding: 1em;
  position: absolute;
  width: 140px;
  z-index: 99999999;
}
</style>
