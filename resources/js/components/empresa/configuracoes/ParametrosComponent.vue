<template>
  <div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
      <h1>
        Definir parametros
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
                  v-model="searchQuery"
                  required
                  autocomplete="on"
                  class="form-control search-query"
                  placeholder="Buscar Por parametros..."
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
    </div>
    <div class="row" style="left: 0%; position: relative">
      <div class="col-md-12">
        <div class="second-row">
          <div class="tabbable">
            <ul class="nav nav-tabs padding-16">
              <li class="active">
                <a data-toggle="tab" href="#dados_user">
                  <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                  Parametro empresa
                </a>
              </li>

              <!-- <li>
                            <a data-toggle="tab" href="#dadoLicenca">
                                <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                                Dados da Licença
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#dadosPgt">
                                <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                                Dados do Pagamento
                            </a>
                        </li> -->
            </ul>

            <div class="tab-content profile-edit-tab-content">
              <div id="dados_user" class="tab-pane in active">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <th scope="row">{{ impressao.designacao }}</th>
                      <td>{{ impressao.valor }}</td>
                      <td>
                        <a
                          data-toggle="modal"
                          href="#modalEditarImpressao"
                          @click="showModalImpressao(impressao)"
                          title="Editar impressão"
                          target="_blanck"
                          class="btn btn-primary widget-box widget-color-blue"
                          id="botoes"
                        >
                          <i class="fa fa-print text-default"></i> editar
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">{{ retencao.designacao }}</th>
                      <td>{{ retencao.valor }}</td>
                      <td>
                        <a
                          data-toggle="modal"
                          href="#modalEditarRetencao"
                          title="Editar impressão"
                          target="_blanck"
                          class="btn btn-primary widget-box widget-color-blue"
                          id="botoes"
                        >
                          <i class="fa fa-print text-default"></i> editar
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">{{ desconto.designacao }}</th>
                      <td>{{ desconto.valor }}</td>
                      <td>
                        <a
                          data-toggle="modal"
                          href="#modalEditarDesconto"
                          title="Editar impressão"
                          target="_blanck"
                          class="btn btn-primary widget-box widget-color-blue"
                          id="botoes"
                        >
                          <i class="fa fa-print text-default"></i> editar
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">{{ vencimentofactura.designacao }}</th>
                      <td>{{ vencimentofactura.vida }}</td>
                      <td>
                        <a
                          data-toggle="modal"
                          href="#modalEditarDiasVencimentoFactura"
                          title="Editar dias vencimento factura"
                          target="_blanck"
                          class="btn btn-primary widget-box widget-color-blue"
                          id="botoes"
                        >
                          <i class="fa fa-print text-default"></i> editar
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">{{ vencimentoftproforma.designacao }}</th>
                      <td>{{ vencimentoftproforma.vida }}</td>
                      <td>
                        <a
                          data-toggle="modal"
                          href="#modalEditarDiasVencimentoFacturaProforma"
                          title="Editar dias vencimento factura"
                          target="_blanck"
                          class="btn btn-primary widget-box widget-color-blue"
                          id="botoes"
                        >
                          <i class="fa fa-print text-default"></i> editar
                        </a>
                      </td>
                    </tr>
                     <tr>
                      <th scope="row">Série do Documento</th>
                      <td>{{ documentoserie.serie }}</td>
                      <td>
                        <a
                          data-toggle="modal"
                          href="#modalEditarSerie"
                          title="Editar série documento"
                          target="_blanck"
                          class="btn btn-primary widget-box widget-color-blue"
                          id="botoes"
                        >
                          <i class="fa fa-print text-default"></i> editar
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Observação da factura</th>
                      <td>{{observacaofactura}}</td>
                      <td>
                        <a
                          data-toggle="modal"
                          href="#modalObservacaoFactura"
                          title="Editar série documento"
                          target="_blanck"
                          class="btn btn-primary widget-box widget-color-blue"
                          id="botoes"
                        >
                          <i class="fa fa-print text-default"></i> editar
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <th scope="row">Nº VIA DE IMPRESSÃO</th>
                      <td>{{viaimpressao.valor}}</td>

                      <td>
                        <a
                          data-toggle="modal"
                          href="#modalViaImpressao"
                          @click="showModalViaImpressao(viaimpressao)"

                          title="Editar série documento"
                          target="_blanck"
                          class="btn btn-primary widget-box widget-color-blue"
                          id="botoes"
                        >
                          <i class="fa fa-print text-default"></i> editar
                        </a>
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

    <!-- MODAL EDITAR IMPRESSÃO  -->
    <div
      class="modal fade"
      id="modalEditarImpressao"
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
              <i class="fa fa-print bigger-110 text-default"></i> Editar
              impressão
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
                              <label for>IMPRESSÃO</label>
                              <Select2
                                :options="impressaoOptions"
                                v-model="impressaoData.folha"
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
                    @click.prevent="mudarImpressao"
                  >
                    <i class="fa fa-print bigger-110 text-default"></i>
                    Salvar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
     <!-- MODAL EDITAR VIA IMPRESSAO  -->
     <div
      class="modal fade"
      id="modalViaImpressao"
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
              <i class="fa fa-print bigger-110 text-default"></i> Editar
              nº via de impressão
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
                              <label for>Nº VIAS</label>
                              <Select2
                                :options="viasImpressoaOptions"
                                v-model="numeroViaImpressao.valor">
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
                    @click.prevent="mudarNumeroViaImpressao"
                  >
                    <i class="fa fa-print bigger-110 text-default"></i>
                    Salvar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /MODAL EDITAR IMPRESSÃO-->

    <!-- MODAL EDITAR RETENÇÃO  -->
    <div
      class="modal fade"
      id="modalEditarRetencao"
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
              <i class="fa fa-print bigger-110 text-default"></i> Editar
              retenção
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
                              <label for>RETENÇÃO</label>
                              <input
                                type="number"
                                v-model="retencao.valor"
                                class="col-md-12 search-query"
                                autofocus
                              />
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
                    @click.prevent="alterarRetencao"
                  >
                    <i class="fa fa-print bigger-110 text-default"></i>
                    Salvar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /MODAL EDITAR RETENÇÃO-->

    <!-- MODAL EDITAR DESCONTO  -->
    <div
      class="modal fade"
      id="modalEditarDesconto"
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
              <i class="fa fa-print bigger-110 text-default"></i> Editar
              desconto
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
                              <label for>DESCONTO</label>
                              <input
                                type="number"
                                :min="0"
                                :max="100"
                                v-model="desconto.valor"
                                class="col-md-12 search-query"
                                autofocus
                              />
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
                    @click.prevent="alterarDesconto"
                  >
                    <i class="fa fa-print bigger-110 text-default"></i>
                    Salvar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /MODAL EDITAR DESCONTO-->
    <!-- MODAL EDITAR DIAS VENCIMENTO FACTURAS  -->
    <div
      class="modal fade"
      id="modalEditarDiasVencimentoFactura"
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
              <i class="fa fa-print bigger-110 text-default"></i> Editar
              Dias vencimento da factura
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
                              <label for>Dias Vencimento Factura</label>
                              <input
                                type="number"
                                :min="1"
                                v-model="vencimentofactura.vida"
                                class="col-md-12 search-query"
                                autofocus
                              />
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
                    @click.prevent="alterarDiasVencimentoFactura"
                  >
                    <i class="fa fa-print bigger-110 text-default"></i>
                    Salvar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL EDITAR DIAS VENCIMENTO FACTURAS -->

     <!-- MODAL EDITAR DIAS VENCIMENTO FACTURAS PROFORMA  -->
    <div
      class="modal fade"
      id="modalEditarDiasVencimentoFacturaProforma"
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
              <i class="fa fa-print bigger-110 text-default"></i> Editar
              Dias vencimento da factura Proforma
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
                              <label for>Dias Vencimento Factura Proforma</label>
                              <input
                                type="number"
                                :min="1"
                                v-model="vencimentoftproforma.vida"
                                class="col-md-12 search-query"
                                autofocus
                              />
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
                    @click.prevent="alterarDiasVencimentoFtProforma"
                  >
                    <i class="fa fa-print bigger-110 text-default"></i>
                    Salvar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL EDITAR DIAS VENCIMENTO FACTURAS -->

     <!-- MODAL EDITAR SERIE  -->
    <div
      class="modal fade"
      id="modalEditarSerie"
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
              <i class="fa fa-print bigger-110 text-default"></i> Editar
              série documento
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
                              <label for>Serie documento</label>
                              <input
                                type="text"
                                v-model="documentoserie.serie"
                                class="col-md-12 search-query"
                                autofocus
                              />
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
                    @click.prevent="alterarSerieDocumento"
                  >
                    <i class="fa fa-print bigger-110 text-default"></i>
                    Salvar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL EDITAR DIAS VENCIMENTO FACTURAS -->

    <!-- MODAL OBSERVAÇÃO FACTURA  -->
    <div
      class="modal fade"
      id="modalObservacaoFactura"
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
              <i class="fa fa-print bigger-110 text-default"></i> Editar
              observação da factura
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
                              <label for>Observação</label>
                              <textarea class="col-md-12 search-query" v-model="observacaofactura" id="" cols="30" rows="10"></textarea>
                              <!-- <input
                                type="text"
                                v-model="documentoserie.serie"
                                class="col-md-12 search-query"
                                autofocus
                              /> -->
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
                    @click.prevent="alterarObservacaoFactura"
                  >
                    <i class="fa fa-print bigger-110 text-default"></i>
                    Salvar
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->
</template>

<script>
import axios from "axios";
import Select2 from "v-select2-component";
import VueNumericInput from "vue-numeric-input";

import { maska } from "maska";
import { showError } from "./../../../config/global";
import { mapState } from "vuex";
import Swal from "sweetalert2";

export default {
  directives: {
    maska,
  },
  components: {
    Select2,
    VueNumericInput,
  },
  props: ["impressao", 
  "retencao", "desconto","viaimpressao", 
  "status","vencimentofactura",
  "vencimentoftproforma", "guard",
  "documentoserie", "observacaofactura"],
  data() {
    return {
      searchQuery: null,
      numeroViaImpressao:{
        valor:this.viaimpressao,
      },
      viasImpressoaOptions:[
       {
          id: 1,
          text: "1",
       },
       {
          id: 2,
          text: "2",
       },
       {
          id: 3,
          text: "3",
       },

      ],
      impressaoOptions: [
        {
          id: 1,
          text: "A4",
        },
        {
          id: 2,
          text: "A5",
        },
        {
          id: 3,
          text: "TICKET",
        },
      ],
      impressaoData: {
        folha: 1,
      },

      errors: [],

      USUARIO_EMPRESA: 2,
      router: "",
    };
  },

  created() {

    this.router =
      this.guard.tipo_user_id == this.USUARIO_EMPRESA
        ? window.location.origin + `/empresa`
        : window.location.origin + `/empresa/funcionario`;
  },

  mounted() {},
  methods: {
    mudarNumeroViaImpressao(){

      axios
        .post(`${this.router}/viaImpressao/adicionar`, this.numeroViaImpressao)
        .then((response) => {
          if (response.status == 200) {
            this.$toasted.global.defaultSuccess();

            Swal.fire({
              title: "Sucesso",
              text: "Operação realizada com sucesso!",
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
            msg: "Erro ao editar",
          });
        });

    },
    showModalViaImpressao(viaImpressao){
      this.numeroViaImpressao.valor = viaImpressao.valor;

    },
    alterarObservacaoFactura(){


      let data = [ this.observacaofactura];
      axios
          .post(`${this.router}/alterarObservacaoFactura`, data)
          .then((response) => {

            if (response.status == 200) {
              this.$toasted.global.defaultSuccess();

              Swal.fire({
                title: "Sucesso",
                text: "Operação realizada com sucesso!",
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
              msg: "Erro ao editar",
            });
          });


    },
    alterarSerieDocumento(){

      axios
          .post(`${this.router}/alterarSerieDocumento`, this.documentoserie)
          .then((response) => {

            if (response.status == 200) {
              this.$toasted.global.defaultSuccess();

              Swal.fire({
                title: "Sucesso",
                text: "Operação realizada com sucesso!",
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
              msg: "Erro ao editar",
            });
          });

    },
    alterarDiasVencimentoFtProforma(){

      axios
          .post(`${this.router}/alterarDiasVencimentoFtProforma`, this.vencimentoftproforma)
          .then((response) => {

            if (response.status == 200) {
              this.$toasted.global.defaultSuccess();

              Swal.fire({
                title: "Sucesso",
                text: "Operação realizada com sucesso!",
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
              msg: "Erro ao editar",
            });
          });

    },
    alterarDiasVencimentoFactura(){
      axios
          .post(`${this.router}/alterarDiasVencimentoFactura`, this.vencimentofactura)
          .then((response) => {

            if (response.status == 200) {
              this.$toasted.global.defaultSuccess();

              Swal.fire({
                title: "Sucesso",
                text: "Operação realizada com sucesso!",
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
              msg: "Erro ao editar",
            });
          });
    },
    alterarDesconto() {
      if (this.desconto.valor <= 100) {
        axios
          .post(`${this.router}/desconto/atualizarDesconto`, this.desconto)
          .then((response) => {
            if (response.status == 200) {
              this.$toasted.global.defaultSuccess();

              Swal.fire({
                title: "Sucesso",
                text: "Operação realizada com sucesso!",
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
              msg: "Erro ao editar",
            });
          });
      }
    },

    alterarRetencao() {
      axios
        .post(`${this.router}/retencao/atualizarRetencao`, this.retencao)
        .then((response) => {
          if (response.status == 200) {
            this.$toasted.global.defaultSuccess();

            Swal.fire({
              title: "Sucesso",
              text: "Operação realizada com sucesso!",
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
            msg: "Erro ao editar",
          });
        });
    },
    showModalImpressao(parametro) {
      this.impressaoData.folha = parametro.vida;

      //   this.impressao = parametro;
      //   this.impressao.folha = parametro.vida;
    },
    

    mudarImpressao() {
      axios
        .post(`${this.router}/impressao/adicionar`, this.impressaoData)
        .then((response) => {
          console.log(response.data);

          if (response.status == 200) {
            this.$toasted.global.defaultSuccess();

            Swal.fire({
              title: "Sucesso",
              text: "Operação realizada com sucesso!",
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
            msg: "Erro ao editar",
          });
        });
    },

    // mudarImpressao() {
    //     if (this.impressao[0].empresa_id) {
    //         this.editarImpressao(this.impressaoData.formato);
    //     }
    //     if (this.impressao[0].empresa_id == null && this.impressaoData.formato != 1) {
    //         this.cadastrarImpressao(this.impressaoData.formato);
    //     }
    // },
    // editarImpressao(formatoFolha) {

    //     const formatoImpresao = {
    //         formatoImpresao: formatoFolha
    //     }

    //     axios.post(`${this.router}/impressao/editar`, formatoImpresao).then((response) => {

    //             if (response.status == 200) {
    //                 this.$toasted.global.defaultSuccess();

    //                 Swal.fire({
    //                     title: 'Sucesso',
    //                     text: 'Operação realizada com sucesso!',
    //                     icon: 'success',
    //                     confirmButtonColor: '#3d5476',
    //                     confirmButtonText: 'Ok',
    //                     onClose: () => {
    //                         document.location.reload(true)
    //                     }
    //                 });
    //             }

    //         })
    //         .catch((error) => {
    //             this.$toasted.global.defaultError({
    //                 msg: "Erro ao editar",
    //             });
    //         });

    // },
    cadastrarImpressao(formatoFolha) {
      const formatoImpresao = {
        formatoImpresao: formatoFolha,
      };
      axios
        .post(`${this.router}/impressao/adicionar`, formatoImpresao)
        .then((response) => {
          console.log(response.data);

          if (response.status == 200) {
            this.$toasted.global.defaultSuccess();

            Swal.fire({
              title: "Sucesso",
              text: "Operação realizada com sucesso!",
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
            msg: "Erro ao editar",
          });
        });
    },
  },
};
</script>

<style scoped>
.has-error {
  border-color: #f2a696 !important;
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
