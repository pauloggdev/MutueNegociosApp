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
                                    <label class="control-label bold label-select2" for="cliente">Buscar factura<b class="red fa fa-question-circle"></b></label>
                                    <input type="text" wire:model="numeracaoFactura" autofocus placeholder="buscar pela numeração da factura" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('numeracaoFactura') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('numeracaoFactura'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('numeracaoFactura') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="nomeCliente">Nome do cliente<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" value="<?= $factura['nome_do_cliente'] ?>" disabled class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="contaCorrente">Conta corrente<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" value="<?= $factura['conta_corrente_cliente'] ?>" disabled class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="saldoAtual">Nº Factura</label>
                                    <div class="input-group">
                                        <input type="text" value="<?= $factura['numeracaoFactura'] ?>" disabled class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="saldoAtual">Saldo actual</label>
                                    <div class="input-group">
                                        <input type="text" value="<?= $factura['cliente_saldo'] ?>" disabled class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="contaCorrente">Valor Factura<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" value="<?= number_format($factura['valor_a_pagar'], 2, ',', '.') ?>" disabled class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="total_debito">Total Débitado</label>
                                    <div class="input-group">
                                        <input type="text" value="<?= $factura['total_debito'] ?>" disabled class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="formaPagamentoId">Forma pagamento<b class="red fa fa-question-circle"></b></label>
                                    <div wire:ignore>
                                        <select wire:model="formaPagamentoId" id="formaPagamentoId" class="col-md-12 select3" style="height:35px;">
                                            @foreach($formaPagamentos as $formaPagamento)
                                            <option value="{{ $formaPagamento->id }}"  @if($formaPagamento->id == $formaPagamentoId) selected @endif>{{ $formaPagamento->descricao }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="total_debito">Total à Débitar</label>
                                    <div class="input-group">
                                        <input type="text" value="<?= $factura['faltante'] ?>" disabled class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <label class="control-label bold label-select2" for="saldoAtual">Valor Entregue<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="number" step="any" wire:model="factura.valor_total_entregue" name="factura.valor_total_entregue" class="form-control" id="saldoAtual" data-target="form_supply_price" style="height: 35px; font-size: 10pt;<?= $errors->has('factura.valor_total_entregue') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('factura.valor_total_entregue'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('factura.valor_total_entregue') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-12">
                                    <label class="control-label bold label-select2" for="saldoAtual">Observação</label>
                                    <div class="input-group">
                                        <textarea wire:model="factura.observacao" id="" cols="200" rows="2" class="form-control" style="font-size: 16px; z-index: 1;"></textarea>
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
