@section('title','Retificar facturas')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            RETIFICAÇÃO DE FACTURAS
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
                                    <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                                        <span class="input-group-addon">
                                            <i class="ace-icon fa fa-search"></i>
                                        </span>
                                        <input type="text" onkeyup="this.value = this.value.toUpperCase();" wire:model="facturaSearch" wire:keyup="buscarFactura" autocomplete="on" autofocus class="form-control search-query" placeholder="Buscar factura pela numeração" style="<?= $errors->has('facturaSearch') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary btn-lg upload">
                                                <span class="ace-icon fa fa-search icon-on-right bigger-130"></span>
                                            </button>
                                        </span>
                                    </div>

                                    @if ($errors->has('facturaSearch'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('facturaSearch') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="nomeCliente">Nome do cliente<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" value="<?= $notaCredito['factura']['nome_do_cliente'] ?? '' ?>" disabled class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="nif">NIF<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" value="<?= $notaCredito['factura']['nif_cliente'] ?? '' ?>" disabled name="factura.nif_cliente" class="form-control" id="nif" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="contaCorrente">Conta corrente<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" value="<?= $notaCredito['factura']['conta_corrente_cliente'] ?? '' ?>" disabled name="factura.cliente_conta_corrente" class="form-control" id="contaCorrente" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="saldoCiente">Saldo actual</label>
                                    <div class="input-group">
                                        <input type="text" value="<?= $saldoCliente ?? '0,00' ?>" disabled class="form-control" id="saldoCiente" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="nomeCliente">Data factura<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        @if(isset($notaCredito['factura']))
                                        <input type="text" value="<?= isset($factura['created_at']) ? date_format($factura['created_at'], 'd/m/Y') : "" ?>" disabled class="form-control" style="height: 35px; font-size: 10pt" />
                                        @else
                                        <input type="text" disabled class="form-control" style="height: 35px; font-size: 10pt" />
                                        @endif
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="totalFactura">Total factura<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" value="<?= number_format($notaCredito['factura']['total_preco_factura'] ?? 0, 2, ',', '.') ?? '' ?>" disabled name="recibo.cliente_conta_corrente" class="form-control" id="totalFactura" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="totalFactura">Total desconto<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" value="<?= number_format($notaCredito['factura']['desconto'] ?? 0, 2, ',', '.') ?? '' ?>" disabled class="form-control" id="totalDesconto" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="totalFactura">Total retenção<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" value="<?= number_format($notaCredito['factura']['retencao'] ?? 0, 2, ',', '.') ?? '' ?>" disabled class="form-control" id="totalDesconto" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="totalFactura">Total IVA<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" value="<?= number_format($notaCredito['factura']['total_iva'] ?? 0, 2, ',', '.') ?? '' ?>" disabled class="form-control" id="totalDesconto" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="totalPagar">Total Pago /Total a Pagar<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" value="<?= number_format($notaCredito['factura']['valor_a_pagar'] ?? 0, 2, ',', '.') ?? '' ?>" disabled name="factura.cliente_conta_corrente" class="form-control" id="totalPagar" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="totalPagar"><strong>Total entregue</strong><b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <input type="text" value="<?= number_format($notaCredito['factura']['valor_entregue'] ?? 0, 2, ',', '.') ?? '' ?>" disabled name="factura.cliente_conta_corrente" class="form-control" id="totalPagar" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="saldoAtual"><strong>Troco</strong></label>
                                    <div class="input-group">
                                        <input type="text" value="<?= number_format($notaCredito['factura']['troco'] ?? 0, 2, ',', '.') ?? '' ?>" disabled name="recibo.cliente_saldo" class="form-control" id="saldoAtual" data-target="form_supply_price" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-12">
                                    <label class="control-label bold label-select2" for="saldoAtual">Observação<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <textarea wire:model="notaCredito.descricao" id="" cols="200" rows="2" class="form-control" style="font-size: 16px; z-index: 1;<?= $errors->has('notaCredito.descricao') ? 'border-color: #ff9292;' : '' ?>"></textarea>
                                    </div>
                                    @if ($errors->has('notaCredito.descricao'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('notaCredito.descricao') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-12">
                                    <form id="adimitirCandidatos" method="POST" action>
                                        <input type="hidden" name="_token" value />
                                        <div class="col-xs-12 widget-box widget-color-green" style="left: 0%">
                                            <div class="table-header widget-header">
                                                Todos items da factura
                                            </div>

                                            <!-- div.dataTables_borderWrap -->
                                            <div>
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Código</th>
                                                            <th>Designação</th>
                                                            <th style="text-align: right">Preço</th>
                                                            <th style="text-align: center">Qtd</th>
                                                            <th style="text-align: center">Qtd atual</th>
                                                            <th style="text-align: right">Iva</th>
                                                            <th style="text-align: right">Retenção</th>
                                                            <th style="text-align: right">Desconto</th>
                                                            <th style="text-align: right">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(isset($notaCredito['factura']))
                                                        @foreach($notaCredito['factura']['facturas_items'] as $key=> $facturaItem)
                                                        <tr>
                                                            <td><?= $facturaItem['id'] ?></td>
                                                            <td>{{Str::upper($facturaItem['descricao_produto'])}}</td>
                                                            <td style="text-align: right">{{ number_format($facturaItem['preco_venda_produto']??0,2,',','.')}}</td>
                                                            <td style="text-align: center">{{ number_format($facturaItem['quantidade_produto']??0,1,',','.')}}</td>
                                                            <td style="text-align: center;display: flex;justify-content: center;">
                                                                <input type="number" min="0" value="<?= $facturaItem['quantidade_produto'] ?>" wire:mouseup="alterarQuantidadeItem({{$key}},$event.target.value)" wire:keyup="alterarQuantidadeItem({{$key}},$event.target.value)" class="form-control" style="width: 70px;" max="{{$facturaItem['quantidade_produto']}}">
                                                            </td>
                                                            <td style="text-align: right">{{ number_format($facturaItem['iva_produto']??0,2,',','.')}}</td>
                                                            <td style="text-align: right">{{ number_format($facturaItem['retencao_produto']??0,2,',','.')}}</td>
                                                            <td style="text-align: right">{{ number_format($facturaItem['desconto_produto']??0,2,',','.')}}</td>
                                                            <td style="text-align: right">{{ number_format($facturaItem['total_preco_produto']??0,2,',','.')}}</td>
                                                        </tr>
                                                        @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="search-btn" type="submit" style="border-radius: 10px" wire:click.prevent="emitirNotaCreditoRetificacaoFactura">
                                <span wire:loading.remove wire:target="emitirNotaCreditoRetificacaoFactura">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Salvar
                                </span>
                                <span wire:loading wire:target="emitirNotaCreditoRetificacaoFactura">
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