@section('title','Facturas proforma')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            FACTURAS PROFORMA
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
                        <div class="input-group input-group-sm" style="margin-bottom: 10px">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-search"></i>
                            </span>

                            <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar por nome,nif,telefone do cliente e numeração da factura" />
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
                            Todas facturas proforma do sistema
                        </div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Cliente</th>
                                        <th>NIF</th>
                                        <th style="text-align:right">Total Factura</th>
                                        <th style="text-align:right">Valor a Pagar</th>
                                        <th>Numeração</th>
                                        <th>Emitido</th>
                                        <th style="text-align: center">Convertido</th>
                                        <th>Pago</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if(count($facturas) > 0)
                                    @foreach($facturas as $factura)
                                    <tr>
                                        <td> {{ $factura->id }}</td>
                                        <td> {{ $factura->nome_do_cliente }}</td>
                                        <td> {{ $factura->nif_cliente }}</td>
                                        <td style="text-align:right"> {{ number_format($factura->total_preco_factura,2,',','.') }}</td>
                                        <td style="text-align:right"> {{ number_format($factura->valor_a_pagar,2,',','.') }}</td>
                                        <td> {{ $factura->numeracaoFactura }}</td>
                                        <td> {{ date_format($factura->created_at,'d/m/Y') }}</td>
                                        <td style="text-align: center">
                                            <span class="label label-sm <?= $factura->convertidoFactura == 2 ? 'label-success' : 'label-danger' ?>"><?= $factura->convertidoFactura == 2 ? "Sim" : "Não" ?></span>
                                        </td>
                                        <td class="hidden-480">
                                            <span class="label label-sm <?= $factura->statusFactura == 1 ? 'label-danger' : 'label-success' ?>"><?= $factura->statusFactura == 1 ? "Não" : "Sim" ?></span>
                                        </td>
                                        <td>
                                            <a class="blue" wire:click="ImprimirFactura({{$factura->id}})" title="Reimprimir factura proforma" style="cursor: pointer">
                                                <i class="ace-icon fa fa-print bigger-160"></i>
                                                <span wire:loading wire:target="ImprimirFactura({{$factura->id}})" class="loading">
                                                    <i class="ace-icon fa fa-print bigger-160"></i>
                                                </span>
                                            </a>
                                            <a class="blue" href="#converterFacturaProforma" wire:click="mostrarModalConverterFactura({{$factura}})" data-toggle="modal" title="Converter factura proforma" style="cursor:pointer;">
                                                <i class="ace-icon fa fa-exchange bigger-160"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
                {{$facturas->links()}}

            </div>

        </div>

    </div>

    <!-- CRIAR FACTURA PROFORMA -->
    <div wire:ignore.self  id="converterFacturaProforma" class="modal fade closeModal" tabindex="-1" role="dialog" aria-labelledby="converterFacturaProforma" aria-hidden="true" >
        <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Converter factura proforma
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
                                Os campos classedos com <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span> são de preenchimento obrigatório.
                            </div>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                    <div class="row" style="left: 0%; position: relative;">
                        <div class="col-md-12">
                            <div class="search-form-text">
                                <div class="search-text">
                                    <i class="fa fa-pencil"></i>
                                    Dados da factura
                                </div>
                            </div>

                            <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                                <div class="second-row">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs padding-16">
                                            <li class="active">
                                                <a data-toggle="tab" href="#dados_banco">
                                                    <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                    Dados da factura Proforma
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_banco" class="tab-pane in active">
                                                <div class="form-group has-info">
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="total_preco_factura">
                                                            Total factura
                                                        </label>
                                                        <div class>
                                                            <input disabled type="text" value="<?= number_format($totalPrecoFactura ?? 0, 2, ',', '.') ?>" id="total_preco_factura" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label" for="valor_a_pagar">
                                                            Total a Pagar
                                                        </label>
                                                        <div class>
                                                            <input disabled type="text" value="<?= number_format($valorPagar ?? 0, 2, ',', '.') ?>" id="valor_a_pagar" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="formaPagamento">
                                                            Forma de Pagamentos
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <select wire:model="factura.formas_pagamento_id" class="col-md-12 select2" id="formaPagamento" style="height:35px;">
                                                            @foreach($formaPagamentos as $formaPagamento)
                                                            <option value="{{$formaPagamento->id}}">{{ $formaPagamento->descricao??"" }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="valor_entregue">
                                                            Valor entregue
                                                            <span class="tooltip-target" data-toggle="tooltip" data-placement="top">
                                                                <i class="fa fa-question-circle bold text-danger"></i>
                                                            </span>
                                                        </label>
                                                        <div class>
                                                            <input type="text" wire:model="factura.valor_entregue" wire:keyup="updateValorEntregue" id="valor_entregue" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="control-label" for="troco">
                                                            Troco
                                                        </label>
                                                        <div class>
                                                            <input disabled type="text" wire:model="factura.troco" id="troco" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" style="border-radius: 10px" id="btnConverte" wire:click.prevent="converterFactura">
                                                    <span wire:loading.remove wire:target="converterFactura">
                                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                                        Converter e Imprimir
                                                    </span>
                                                    <span wire:loading wire:target="converterFactura">
                                                        <span class="loading"></span>
                                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                                        Aguarde...
                                                    </span>
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
</div>