@section('title','Emitir recibo')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            EMITIR RECIBO
        </h1>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-warning hidden-sm hidden-xs">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                Os campos marcados com
                <span class="tooltip-target" data-toggle="tooltip" data-placement="top"><i class="fa fa-question-circle bold text-danger"></i></span>
                são de preenchimento obrigatório.
            </div>
        </div>
    </div>
    @if (Session::has('success'))
    <div class="alert alert-success alert-success col-xs-12" style="left: 0%;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h5><i class="icon fa fa-check-square-o bigger-150"></i>{{ Session::get('success') }}</h5>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <form class="filter-form form-horizontal validation-form" id="validation-form">
                <div class="second-row">

                    <div class="tabbable">
                        <div class="tab-content profile-edit-tab-content">
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-12">
                                    <label class="control-label bold label-select2" for="cliente">Buscar clientes<b class="red fa fa-question-circle"></b></label>
                                    <span wire:ignore>
                                        <select data-livewire="@this" wire:model="clienteId" id="clienteId" class="col-md-12 select3" style="height:35px;<?= $errors->has('recibo.cliente_id') ? 'border-color: #ff9292;' : '' ?>">
                                            <option value=""></option>
                                            @foreach($clientes as $cliente)
                                            <option value="{{$cliente}}">{{ $cliente->nome }}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                    @if ($errors->has('recibo.cliente_id'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('recibo.cliente_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="nomeCliente">Nome do cliente<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="recibo.cliente_nome" disabled class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="contaCorrente">Conta corrente<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="recibo.cliente_conta_corrente" disabled name="recibo.cliente_conta_corrente" class="form-control" id="contaCorrente" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="saldoAtual">Saldo actual</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="recibo.cliente_saldo" disabled name="recibo.cliente_saldo" class="form-control" id="saldoAtual" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="facturaId">Factura Liquidar<b class="red fa fa-question-circle"></b></label>
                                        <select wire:model="facturaId" class="col-md-12 select3" id="facturaId" style="height:35px;">
                                            <option value="">-- Selecione --</option>
                                            @foreach($facturas as $factura)
                                            <option value="{{$factura}}">{{$factura->numeracaoFactura}}</option>
                                            @endforeach
                                        </select>
                                    @if ($errors->has('recibo.factura_id'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('recibo.factura_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="contaCorrente">Valor Factura<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="recibo.valor_a_pagar" disabled name="recibo.valor_a_pagar" class="form-control" id="contaCorrente" data-target="form_supply_price" style="height: 35px; font-size: 10pt;" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="total_debito">Total Débitado</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="recibo.total_debito" disabled name="recibo.total_debito" class="form-control" id="saldoAtual" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="facturaId">Forma pagamento<b class="red fa fa-question-circle"></b></label>
                                    <select name="recibo.forma_pagamento_id" wire:model="recibo.forma_pagamento_id" class="col-md-12 select2" id="facturaId" style="height:35px;<?= $errors->has('recibo.forma_pagamento_id') ? 'border-color: #ff9292;' : '' ?>">
                                        <option value="">-- Selecione --</option>
                                        @foreach($formaPagamentos as $formaPagamento)
                                        <option value="{{ $formaPagamento->id }}">{{ $formaPagamento->descricao }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('recibo.forma_pagamento_id'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('recibo.forma_pagamento_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="total_debito">Total à Débitar</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="recibo.faltante" disabled name="recibo.faltante" class="form-control" id="saldoAtual" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <label class="control-label bold label-select2" for="saldoAtual">Valor Entregue<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="number" step="any" wire:model="recibo.valor_total_entregue" name="recibo.valor_total_entregue" class="form-control" id="saldoAtual" data-target="form_supply_price" style="height: 35px; font-size: 10pt;<?= $errors->has('recibo.valor_total_entregue') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('recibo.valor_total_entregue'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('recibo.valor_total_entregue') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-12">
                                    <label class="control-label bold label-select2" for="saldoAtual">Observação</label>
                                    <div class="input-group">
                                        <textarea wire:model="recibo.observacao" id="" cols="200" rows="2" class="form-control" style="font-size: 16px; z-index: 1;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="search-btn" type="submit" style="border-radius: 10px" wire:click.prevent="emitirRecibo">
                                <span wire:loading.remove wire:target="emitirRecibo">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Salvar
                                </span>
                                <span wire:loading wire:target="emitirRecibo">
                                    <span class="loading"></span>
                                    Aguarde...</span>
                            </button>

                            &nbsp; &nbsp;
                            <button class="btn btn-danger" type="reset" style="border-radius: 10px">
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
