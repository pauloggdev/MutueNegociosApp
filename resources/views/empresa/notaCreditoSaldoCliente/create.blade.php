@section('title','Nota de crédito')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            DAR SALDO AO CLIENTE
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
                                    <select wire:model="clienteId" id="cliente" class="col-md-12 select2" style="height:35px;<?= $errors->has('notaCredito.cliente_id') ? 'border-color: #ff9292;' : '' ?>">
                                        <option value="">-- Selecione --</option>
                                        @foreach($clientes as $cliente)
                                        <option value="{{$cliente}}">{{ $cliente->nome }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('notaCredito.cliente_id'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('notaCredito.cliente_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="nomeCliente">Nome do cliente<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="notaCredito.cliente_nome" disabled class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="contaCorrente">Conta corrente<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="notaCredito.cliente_conta_corrente" disabled name="recibo.cliente_conta_corrente" class="form-control" id="contaCorrente" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="saldoAtual">Saldo actual</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="notaCredito.cliente_saldo" disabled name="recibo.cliente_saldo" class="form-control" id="saldoAtual" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="saldoAtual">Valor entregue<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="number" wire:model="notaCredito.valor_credito" name="notaCredito.valor_credito" class="form-control" id="saldoAtual" data-target="form_supply_price" style="height: 35px; font-size: 10pt;<?= $errors->has('notaCredito.valor_credito') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('notaCredito.valor_credito'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('notaCredito.valor_credito') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-12">
                                    <label class="control-label bold label-select2" for="saldoAtual">Observação</label>
                                    <div class="input-group">
                                        <textarea wire:model="notaCredito.descricao" id="" cols="200" rows="2" class="form-control" style="font-size: 16px; z-index: 1;<?= $errors->has('notaCredito.descricao') ? 'border-color: #ff9292;' : '' ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="search-btn" type="submit" style="border-radius: 10px" wire:click.prevent="emitirNotaCredito">
                                <span wire:loading.remove wire:target="emitirNotaCredito">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Salvar
                                </span>
                                <span wire:loading wire:target="emitirNotaCredito">
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