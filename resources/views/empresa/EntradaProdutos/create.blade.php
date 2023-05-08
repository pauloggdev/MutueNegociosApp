<?php

use Illuminate\Support\Str;

?>
@section('title','Entrada de produtos')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            ENTRADA DE PRODUTOS
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
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="num_factura_fornecedor">Nº Factura<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="entrada.num_factura_fornecedor" autofocus placeholder="Nº da factura" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('entrada.num_factura_fornecedor') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('entrada.num_factura_fornecedor'))
                                    <span class="help-block" style="color:#de4949;">
                                        <span>{{ $errors->first('entrada.num_factura_fornecedor') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="fornecedorId">Fornecedor</label>
                                    <div wire:ignore>
                                        <select wire:model="entrada.fornecedor_id" id="fornecedorId" class="col-md-12" style="height:35px; <?= $errors->has('entrada.fornecedor_id') ? 'border-color: #ff9292;' : '' ?>">
                                            @foreach($fornecedores as $fornecedor)
                                            <option value="{{ $fornecedor->id }}">{{ Str::upper($fornecedor->nome) }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('entrada.fornecedor_id'))
                                        <span class="help-block" style="color:#de4949;position:absolute;top:67px;">
                                            <span>{{ $errors->first('entrada.fornecedor_id') }}</span>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="armazemId">Armazéns</label>
                                    <div wire:ignore>
                                        <select wire:model="entrada.armazem_id" id="armazemId" class="col-md-12" style="height:35px; <?= $errors->has('entrada.armazem_id') ? 'border-color: #ff9292;' : '' ?>">
                                            @foreach($armazens as $armazem)
                                            <option value="{{ $armazem->id }}">{{ Str::upper($armazem->designacao) }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('entrada.armazem_id'))
                                        <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                            <span>{{ $errors->first('entrada.armazem_id') }}</span>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left:0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="dataFacturaFornecedor">Data/factura do fornecedor<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="date" wire:model="entrada.data_factura_fornecedor" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('entrada.data_factura_fornecedor') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('entrada.data_factura_fornecedor'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 67px;">
                                        <span>{{ $errors->first('entrada.data_factura_fornecedor') }}</span>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="dataEntrada">Data de entrada<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="date" wire:model="entrada.created_at" class="form-control" s style="height: 35px; font-size: 10pt;<?= $errors->has('entrada.created_at') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="dataEntrada">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('entrada.created_at'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 67px;">
                                        <span>{{ $errors->first('entrada.created_at') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="formaPagamentoId">Forma de Pagamento</label>
                                    <div wire:ignore>
                                        <select wire:model="entrada.forma_pagamento_id" id="formaPagamentoId" class="col-md-12" style="height:35px; <?= $errors->has('entrada.forma_pagamento_id') ? 'border-color: #ff9292;' : '' ?>">
                                            @foreach($formaPagamentos as $formaPagamento)
                                            <option value="{{ $formaPagamento->id }}">{{ Str::upper($formaPagamento->descricao) }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('entrada.forma_pagamento_id'))
                                        <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                            <span>{{ $errors->first('entrada.forma_pagamento_id') }}</span>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="produtoId">Selecione o Produto<b class="red fa fa-question-circle"></b></label>
                                    <div wire:ignore>
                                        <select wire:model="entrada.produto_id" id="produtoId" class="col-md-12" style="height:35px; <?= $errors->has('entrada.produto_id') ? 'border-color: #ff9292;' : '' ?>">
                                            <option value="">Nenhum</option>
                                            @foreach($produtos as $produto)
                                            <option value="{{ $produto->id }}">{{ Str::upper($produto->designacao) }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('entrada.produto_id'))
                                        <span class="help-block" style="color:#de4949;position:absolute;top: 67px;">
                                            <span>{{ $errors->first('entrada.produto_id') }}</span>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="precoVenda">Preço de venda/unidade</label>
                                    <input type="text" disabled wire:model="precoVenda" placeholder="0,00" value="0" class="form-control" style="height: 35px; font-size: 10pt;" />

                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="preco_compra">Preço de compra/unidade<b class="red fa fa-question-circle"></b></label>
                                    <input type="number" step="any" wire:model="entrada.preco_compra" value="0" placeholder="0,00" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('entrada.preco_compra') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('entrada.preco_compra'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 67px;">
                                        <span>{{ $errors->first('entrada.preco_compra') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="descontoPerc">Desconto(%)<b class="red fa fa-question-circle"></b></label>
                                    <input type="number" step="any" wire:model="entrada.descontoPerc" placeholder="0,00" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('entrada.descontoPerc') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('entrada.descontoPerc'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 67px;">
                                        <span>{{ $errors->first('entrada.descontoPerc') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="quantidade">Quantidade<b class="red fa fa-question-circle"></b></label>
                                    <input type="number" step="any" wire:model="entrada.quantidade" placeholder="0,00" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('entrada.quantidade') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('entrada.quantidade'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 67px;">
                                        <span>{{ $errors->first('entrada.quantidade') }}</span>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-12">
                                    <label class="control-label bold label-select2" for="saldoAtual">Descrição</label>
                                    <div class="input-group">
                                        <textarea wire:model="entrada.descricao" id="" cols="200" rows="2" class="form-control" style="font-size: 16px; z-index: 1;<?= $errors->has('entrada.descricao') ? 'border-color: #ff9292;' : '' ?>"></textarea>
                                    </div>
                                    @if ($errors->has('entrada.descricao'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('entrada.descricao') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-2">
                                    <button wire:click.prevent="addCarrinho" class="btn btn-sm btn-success">
                                        <i class="glyphicon glyphicon-plus bigger-110"></i>
                                        <span class="bigger-110 no-text-shadow">Adicionar</span>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-12">
                                    <form id="adimitirCandidatos" method="POST" action>
                                        <input type="hidden" name="_token" value />
                                        <div class="col-xs-12 widget-box widget-color-green" style="left: 0%">
                                            <div class="table-header widget-header">
                                                Todas os produtos de entrada adicionados
                                            </div>
                                            <div>
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Designação</th>
                                                            <th style="text-align: right">Preço Venda unit.</th>
                                                            <th style="text-align: right">Preço Compra unit.</th>
                                                            <th style="text-align: center">Qtd</th>
                                                            <th style="text-align: right">Desconto</th>
                                                            <th style="text-align: right">Total Compra</th>
                                                            <th style="text-align: right">Total Venda</th>
                                                            <th style="text-align: right">Total Lucro</th>
                                                            <th style="text-align: center">Ações</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($entrada['items'] as $key=> $entradaItem)
                                                        <tr>
                                                            <td>{{ Str::of($entradaItem['produtoDesignacao'])->upper()}}</td>
                                                            <td style="text-align: right">{{number_format($entradaItem['preco_venda_unitario'],2,',','.')}}</td>
                                                            <td style="text-align: right">{{number_format($entradaItem['preco_compra_unitario'],2,',','.')}}</td>
                                                            <td style="text-align: center">{{number_format($entradaItem['quantidade'],1,',','.')}}</td>
                                                            <td style="text-align: right">{{number_format($entradaItem['descontoValor'],2,',','.')}}</td>
                                                            <td style="text-align: right">{{number_format($entradaItem['preco_compra'],2,',','.')}}</td>
                                                            <td style="text-align: right">{{number_format($entradaItem['preco_venda'],2,',','.')}}</td>
                                                            <td style="text-align: right">{{number_format($entradaItem['lucroUnitario'],2,',','.')}}</td>
                                                            <td style="text-align: center">
                                                                <a wire:click.prevent="delItemCar({{$key}})" style="cursor: pointer;">
                                                                    <i class="ace-icon fa fa-trash-o fa-2x icon-only bigger-130" style="color:red"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="designacao">Total S/Imposto,Desc<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                    <input type="text" disabled value="{{number_format($entrada['totalSemImposto'],2,',','.')}}" class="col-md-12 col-xs-12 col-sm-4" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
                                        </span>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="designacao">Total Desconto<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                    <input type="text" wire:model="entrada.total_desconto" class="col-md-12 col-xs-12 col-sm-4" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
                                        </span>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="designacao">Total Retenção<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                    <input type="text" wire:model="entrada.total_retencao" class="col-md-12 col-xs-12 col-sm-4" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
                                        </span>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="designacao">Total IVA<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                    <input type="text" wire:model="entrada.total_iva" class="col-md-12 col-xs-12 col-sm-4" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="designacao">Total da compra<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                    <input type="text" disabled value="{{number_format($entrada['total_compras'],2,',','.')}}" class="col-md-12 col-xs-12 col-sm-4" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
                                        </span>

                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="designacao">Total da venda<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                    <input type="text" disabled value="{{number_format($entrada['total_venda'],2,',','.')}}" class="col-md-12 col-xs-12 col-sm-4" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="search-btn" type="submit" style="border-radius: 10px" wire:click.prevent="cadastrarEntradaProduto">
                                <span wire:loading.remove wire:target="cadastrarEntradaProduto">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Salvar
                                </span>
                                <span wire:loading wire:target="cadastrarEntradaProduto">
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
