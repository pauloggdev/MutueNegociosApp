@section('title','Assinaturas')
<div class="row">
  @if($showSolicitacao)
  <div class="page-header" style="left: 0.5%; position: relative">
    <h1>
      ASSINATURAS
      <small>
        <i class="ace-icon fa fa-angle-double-right"></i>
        Listagem
      </small>
    </h1>
  </div>
  @endif

  <div class="row">
    <div class="col-xs-12">
      <!-- PAGE CONTENT BEGINS -->
      <div class="clearfix">
        <div class="pull-right">
          <span class="green middle bolder">Escolha a operação: &nbsp;</span>

          <div class="btn-toolbar inline middle no-margin">
            <div id="toggle-result-page" data-toggle="buttons" class="btn-group no-margin">
              <label class="btn btn-sm btn-pink btn-xs active" wire:click.prevent="toggleSolicitar">
                <i class="ace-icon glyphicon glyphicon-barcode bigger-130 bold"></i>
                <span class="bigger-130 bold">SOLICITAR FACTURA</span>
                <input type="radio" value="1" />
              </label>
              <label class="btn btn-sm btn-purple btn-xs" wire:click.prevent="toggleFacturaEmitidas">
                <i class="ace-icon fa fa-money bigger-150 bold"></i>
                <span class="bigger-130 bold">FACTURAS EMITIDAS</span>
                <input type="radio" value="2" />
              </label>

              <label class="btn btn-sm btn-purple btn-xs" wire:click.prevent="togglePagarLicenca">
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
  @if($showSolicitacao)
  <div>
    <div class="row search-page" id="search-page-1">
      <div class="col-xs-12">
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
            @foreach($licencas as $licenca)
            <div class="pricing-span" style="margin-right: 10px">
              <div class="widget-box pricing-box-small widget-color-red3">
                <div class="widget-header">
                  <h5 class="widget-title bigger lighter">
                    {{ $licenca->designacao }}
                  </h5>
                </div>

                <div class="widget-body">
                  <div class="widget-main no-padding">
                    <ul class="list-unstyled list-striped pricing-table">
                      @if($licenca->tipo_licenca_id == 1)
                      <li>Armazenamento limitado</li>
                      @endif
                      <li>Armazenamento ilimitado</li>
                      <li>Acesso aplicativo</li>
                      <li>{{ number_format($licenca->limite_usuario, 1, ',','.')}} Utilizadores</li>
                      <li>Exportação do ficheiro SAFT</li>
                      <li>Facturação em Backoffice</li>
                      <li>Capacidade ilimitada</li>
                      <li>Acesso App</li>
                      @if($licenca->tipo_licenca_id == 1)
                      <li>
                        <i class="ace-icon fa fa-times red"></i>
                      </li>
                      @else
                      <li>
                        <i class="ace-icon fa fa-check green"></i>
                      </li>
                      @endif

                    </ul>

                    <div class="price">
                      <span class="
                            label label-lg label-inverse
                            arrowed-in arrowed-in-right
                          ">{{ number_format($licenca->valor, 2,',','.')}} /
                        <small>{{ $licenca->designacao }}</small>
                      </span>
                    </div>
                  </div>

                  @if($licenca->tipo_licenca_id != 1)
                  <div wire:click="mostrarModalPagamento({{ $licenca }})">
                    <a href="#imprimirFactura" data-toggle="modal" class="btn btn-block btn-sm btn-danger">
                      <span>Pagar</span>
                    </a>
                  </div>
                  @endif
                </div>
              </div>
            </div>
            @endforeach
          </div>


        </div>
        <!-- PAGE CONTENT ENDS -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  @endif
  @if($showFacturaEmitida)
  <div>
    <div class="row search-page" id="search-page-2">
      <div class="col-xs-12">
        <div class="space-24"></div>
        <div class="row">
          <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
              FACTURAS
              <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Listagem
              </small>
            </h1>
          </div>
        </div>
        <div class="row">
          <div class="page-header" style="padding: 15px">
            <div class="col-md-12">
              <div class>
                <form class="form-search" method="get" action>
                  <div class="row">
                    <div class>
                      <div class="input-group input-group-sm" style="margin-bottom: 10px">
                        <span class="input-group-addon">
                          <i class="ace-icon fa fa-search"></i>
                        </span>

                        <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar por nome do cliente, numeração da factura" />
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-primary btn-lg upload">
                            <span class="ace-icon fa fa-search icon-on-right bigger-130"></span>
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

                    <div class="col-xs-12 widget-box widget-color-green" style="left: 0%">
                      <div class="clearfix">

                        <div class="pull-right tableTools-container"></div>
                      </div>
                      <div class="table-header widget-header">
                        Todas facturas
                      </div>

                      <!-- div.dataTables_borderWrap -->
                      <div>
                        <table class="table table-striped table-bordered table-hover">
                          <thead>
                            <tr>
                              <th>Nº Factura</th>
                              <th>Referência Factura</th>
                              <th>Nome do cliente</th>
                              <th>NIF do cliente</th>
                              <th>Licença</th>
                              <th style="text-align: right">Valor</th>
                              <th>Emitido</th>
                              <th>Ações</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($facturas as $factura)
                            <tr>
                              <td>{{$factura->numeracaoFactura}}</td>
                              <td>{{$factura->faturaReference}}</td>
                              <td>{{$factura->nome_do_cliente}}</td>
                              <td>{{$factura->nif_cliente}}</td>
                              <td>{{$factura->descricao}}</td>
                              <td style="text-align: right">{{number_format($factura->valor_a_pagar, 2, ',','.')}}</td>
                              <td>{{date_format($factura->created_at,'d/m/Y')}}</td>

                              <td>
                                <a class="blue" wire:click="printFactura({{json_encode($factura->id)}})" title="Reimprimir a factura" style="cursor: pointer">
                                  <i class="ace-icon fa fa-print bigger-160"></i>
                                  <span wire:loading wire:target="printFactura({{json_encode($factura->id)}})" class="loading">
                                    <i class="ace-icon fa fa-print bigger-160"></i>
                                  </span>
                                </a>
                              </td>
                            </tr>
                            @endforeach

                          </tbody>
                        </table>
                      </div>
                    </div>
                  </form>
                  {{ $facturas->links() }}


                </div>

              </div>

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  @endif
  @if($showPagarLicenca)
  <div>
    <div class="row search-page" id="search-page-2">
      <div class="col-xs-12">
        <div class="space-24"></div>
        <div class="row">
          <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
              PAGAMENTO LICENÇA
            </h1>
          </div>
        </div>
        <div class="row">
          <div class="page-header" style="padding: 15px">
            <div class="col-md-12">

              <form class="filter-form form-horizontal" id="validation-form">
                <div class="second-row">

                  <div>
                    <div class="tab-content profile-edit-tab-content">
                      <div class="form-group has-info bold" style="left: 0%; position: relative">
                        <div class="col-md-4">
                          <label class="control-label bold label-select2" for="cliente">Buscar pela referência da factura<b class="red fa fa-question-circle"></b></label>
                          <select wire:model="facturaId" id="cliente" class="col-md-12 select2" style="height:35px;<?= $errors->has('recibo.cliente_id') ? 'border-color: #ff9292;' : '' ?>">
                            <option value="">-- Selecione --</option>
                            @foreach($facturas as $factura)
                            <option value="{{$factura}}">{{ $factura->faturaReference }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label class="control-label bold label-select2" for="licenca">Licenca</label>
                          <div class="input-group">
                            <input type="text" wire:model="facturaDescription.descricao" disabled class="form-control" id="licenca" style="height: 35px; font-size: 10pt" />
                            <span class="input-group-addon" id="basic-addon1">
                              <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                            </span>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <label class="control-label bold label-select2" for="contaCorrente">Valor<b class="red fa fa-question-"></b></label>
                          <div class="input-group">
                            <input type="text" disabled wire:model="facturaDescription.valor_a_pagar" class="form-control" id="contaCorrente" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                            <span class="input-group-addon" id="basic-addon1">
                              <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="form-group has-info bold" style="left: 0%; position: relative">

                        <div class="col-md-3">
                          <label class="control-label bold label-select2" for="saldoAtual">Data Pgt banco<b class="red fa fa-question-circle"></b></label>
                          <div class="input-group">
                            <input type="date" wire:model="facturaData.dataPagamentoBanco" class="form-control" id="saldoAtual" data-target="form_supply_price" style="height: 35px; font-size: 10pt;<?= $errors->has('facturaData.dataPagamentoBanco') ? 'border-color: #ff9292;' : '' ?>" />
                            <span class="input-group-addon" id="basic-addon1">
                              <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                            </span>
                          </div>
                          @if ($errors->has('facturaData.dataPagamentoBanco'))
                          <span class="help-block" style="color: red; font-weight: bold">
                            <strong>{{ $errors->first('facturaData.dataPagamentoBanco') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-md-3">
                          <label class="control-label bold label-select2" for="numeroOperacaoBancaria">Nº Operação Bancária<b class="red fa fa-question-circle"></b></label>
                          <div class="input-group">
                            <input type="text" wire:model="facturaData.numero_operacao_bancaria" placeholder="Nº 0000-0000" class="form-control" id="numeroOperacaoBancaria" data-target="form_supply_price" style="height: 35px; font-size: 10pt;<?= $errors->has('facturaData.numero_operacao_bancaria') ? 'border-color: #ff9292;' : '' ?>" />
                            <span class="input-group-addon" id="basic-addon1">
                              <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                            </span>
                          </div>
                          @if ($errors->has('facturaData.numero_operacao_bancaria'))
                          <span class="help-block" style="color: red; font-weight: bold">
                            <strong>{{ $errors->first('facturaData.numero_operacao_bancaria') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-md-3">
                          <label class="control-label bold label-select2" for="forma_pagamento_id">Forma pagamento<b class="red fa fa-question-circle"></b></label>
                          <select wire:model="facturaData.forma_pagamento_id" id="forma_pagamento_id" class="col-md-12 select2" style="height:35px;<?= $errors->has('facturaData.forma_pagamento_id') ? 'border-color: #ff9292;' : '' ?>">
                            <option value="">-- Selecione --</option>
                            @foreach($formaPagamentos as $formaPagamento)
                            <option value="{{$formaPagamento->id}}">{{ $formaPagamento->descricao }}</option>
                            @endforeach
                          </select>
                          @if ($errors->has('facturaData.forma_pagamento_id'))
                          <span class="help-block" style="color: red; font-weight: bold">
                            <strong>{{ $errors->first('facturaData.forma_pagamento_id') }}</strong>
                          </span>
                          @endif
                        </div>
                        <div class="col-md-3">
                          <label class="control-label bold label-select2" for="conta_movimentada_id">Conta Movimentada<b class="red fa fa-question-circle"></b> </label>
                          <select wire:model="facturaData.conta_movimentada_id" id="conta_movimentada_id" class="col-md-12 select2" style="height:35px;<?= $errors->has('facturaData.conta_movimentada_id') ? 'border-color: #ff9292;' : '' ?>">
                            <option value="">-- Selecione --</option>
                            @foreach($coordernadaBancarias as $coordernadaBancaria)
                            <option value="{{$coordernadaBancaria->banco_id}}">{{ $coordernadaBancaria->iban }}</option>
                            @endforeach
                          </select>
                          @if ($errors->has('facturaData.conta_movimentada_id'))
                          <span class="help-block" style="color: red; font-weight: bold">
                            <strong>{{ $errors->first('facturaData.conta_movimentada_id') }}</strong>
                          </span>
                          @endif
                        </div>
                      </div>
                      <div class="form-group has-info bold" style="left: 0%; position: relative">
                        <div class="col-md-6">
                          <label class="control-label" for="id-input-file-2">
                            Comprovativo bancário (jpeg,png,jpg,pdf)
                            <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                          </label>
                          <div class="widget-body">
                            <div class="widget-main">
                              <div class="form-group has-info">
                                <div class="col-mb-10"style="<?= $errors->has('facturaData.comprovativo_bancario') ? 'border-color: #ff9292;' : '' ?>">
                                  <input type="file" wire:model="facturaData.comprovativo_bancario" accept="application/jpeg,png,jpg,pdf" id="id-input-file-3"  required />
                                </div>
                              </div>
                            </div>
                          </div>
                          @if ($errors->has('facturaData.comprovativo_bancario'))
                          <span class="help-block" style="color: red; font-weight: bold">
                            <strong>{{ $errors->first('facturaData.comprovativo_bancario') }}</strong>
                          </span>
                          @endif
                        </div>

                      </div>
                      <div class="form-group has-info bold" style="left: 0%; position: relative">
                        <div class="col-md-12">
                          <label class="control-label bold label-select2" for="observacao">Observação</label>
                          <div class="input-group">
                            <textarea cols="200" rows="2" wire:model="facturaData.observacao" class="form-control" style="font-size: 16px; z-index: 1;"></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                      <button class="search-btn" type="submit" style="border-radius: 10px" wire:click.prevent="pagamentoFactura">
                        <span wire:loading.remove wire:target="pagamentoFactura">
                          <i class="ace-icon fa fa-check bigger-110"></i>
                          Salvar
                        </span>
                        <span wire:loading wire:target="pagamentoFactura">
                          <span class="loading"></span>
                          Aguarde...</span>
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
  </div>
  @endif


  <!-- modal  -->
  <div wire:ignore.self id="imprimirFactura" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header text-center">
          <button type="button" class="close red bolder" data-dismiss="modal">
            ×
          </button>
          <h4 class="smaller">
            Solicitação da Factura da Licença Anual
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
                  <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span>
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

            <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
              <div class="second-row">
                <div class="tabbable">
                  <ul class="nav nav-tabs padding-16"></ul>

                  <div class="tab-content profile-edit-tab-content">
                    <div id="dados_cliente" class="tab-pane in active">
                      <div class="form-group has-info">
                        <div class="col-md-6">
                          <label class="control-label" for="designacao">
                            Designação da Licença
                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                              <i class="fa fa-question-circle bold text-danger"></i>
                            </span>
                          </label>
                          <div class="input-icon">
                            <input type="text" value="<?= $licencaData['designacao'] ?? '' ?>" id="designacao" class="col-md-12 col-xs-12 col-sm-4" disabled />
                            <i class="ace-icon fa fa-info"></i>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <label class="control-label" for="quantidade">
                            Quantidade
                            <b class="red"><i class="fa fa-question-circle bold text-danger"></i></b>
                          </label>
                          <div class="input-icon">
                            <input type="number" value="<?= $licencaData['quantidade'] ?? 1 ?>" id="qty" class="col-md-12 col-xs-12 col-sm-4" disabled />
                            <i class="ace-icon fa fa-info"></i>
                          </div>
                        </div>
                      </div>
                      <div class="form-group has-info">
                        <div class="col-md-6">
                          <label class="control-label" for="designacao">
                            Total a Pagar
                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                              <i class="fa fa-question-circle bold text-danger"></i>
                            </span>
                          </label>
                          <div class="input-icon">
                            <input type="text" value="<?= number_format($licencaData['valor'] ?? 0, 2, ',', '.') ?>" id="valorPagar" disabled class="col-md-12 col-xs-12 col-sm-4" />
                            <i class="ace-icon fa fa-money"></i>
                          </div>
                        </div>
                        <div class="col-md-6" style="background: orange; margin-top: 25px">
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
                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                              <i class="fa fa-question-circle bold text-danger"></i>
                            </span>
                          </label>
                          <div class="input-icon">
                            <input type="text" value="<?= $licencaData['valor_extenso'] ?? '' ?>" class="col-md-12 col-xs-12 col-sm-4" disabled />
                            <i class="ace-icon fa fa-money"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="clearfix form-actions">
                  <div class="col-md-offset-3 col-md-9">
                    <button class="search-btn" style="border-radius: 10px" wire:click.prevent="imprimirFactura({{ json_encode($licencaData) }})">
                      <span wire:loading.remove wire:target="imprimirFactura">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Imprimir factura
                      </span>
                      <span wire:loading wire:target="imprimirFactura">
                        <span class="loading"></span>
                        Aguarde...</span>
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
  <!-- fim modal  -->


</div>
