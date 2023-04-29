@section('title','Entrada produto')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            ENTRADA PRODUTO
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
                                    <label class="control-label bold label-select2" for="numFacturaFornecedor">Nº Factura<b class="red fa fa-question-circle"></b></label>
                                    <input type="text" wire:model="numFacturaFornecedor" autofocus placeholder="buscar pela numeração da factura" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('numFacturaFornecedor') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('numFacturaFornecedor'))
                                    <span class="help-block" style="color:#de4949;">
                                        <span>{{ $errors->first('numFacturaFornecedor') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="fornecedorId">Fornecedor<b class="red fa fa-question-circle"></b></label>
                                    <div wire:ignore>
                                        <select wire:model="fornecedorId" id="fornecedorId" class="col-md-12" style="height:35px; <?= $errors->has('fornecedorId') ? 'border-color: #ff9292;' : '' ?>">
                                            @foreach($fornecedores as $fornecedor)
                                            <option value="{{ $fornecedor->id }}">{{ Str::upper($fornecedor->nome) }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('fornecedorId'))
                                        <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                            <span>{{ $errors->first('fornecedorId') }}</span>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="armazemId">Armazéns<b class="red fa fa-question-circle"></b></label>
                                    <div wire:ignore>
                                        <select wire:model="armazemId" id="armazemId" class="col-md-12" style="height:35px; <?= $errors->has('armazemId') ? 'border-color: #ff9292;' : '' ?>">
                                            @foreach($armazens as $armazem)
                                            <option value="{{ $armazem->id }}">{{ Str::upper($armazem->designacao) }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('armazemId'))
                                        <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                            <span>{{ $errors->first('armazemId') }}</span>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="dataFacturaFornecedor">Factura/Data<b class="red fa fa-question-circle"></b></label>
                                    <input type="date" wire:model="dataFacturaFornecedor" class="form-control" s style="height: 35px; font-size: 10pt;<?= $errors->has('dataFacturaFornecedor') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('dataFacturaFornecedor'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                        <span>{{ $errors->first('dataFacturaFornecedor') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="dataEntrada">Data de entrada<b class="red fa fa-question-circle"></b></label>
                                    <input type="date" wire:model="dataEntrada" class="form-control" s style="height: 35px; font-size: 10pt;<?= $errors->has('dataEntrada') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('dataEntrada'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                        <span>{{ $errors->first('dataEntrada') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="formaPagamentoId">Forma de Pagamento<b class="red fa fa-question-circle"></b></label>
                                    <div wire:ignore>
                                        <select wire:model="formaPagamentoId" id="formaPagamentoId" class="col-md-12" style="height:35px; <?= $errors->has('formaPagamentoId') ? 'border-color: #ff9292;' : '' ?>">
                                            @foreach($formaPagamentos as $formaPagamento)
                                            <option value="{{ $formaPagamento->id }}">{{ Str::upper($formaPagamento->descricao) }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('formaPagamentoId'))
                                        <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                            <span>{{ $errors->first('formaPagamentoId') }}</span>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" >Produto<b class="red fa fa-question-circle"></b></label>
                                    <div wire:ignore>
                                        <select wire:model="produto" class="col-md-12" style="height:35px; <?= $errors->has('produto') ? 'border-color: #ff9292;' : '' ?>">
                                            <option value="">Selecione o produto</option>
                                            @foreach($produtos as $produtoDB)
                                            <option value="{{ $produtoDB }}">{{ Str::upper($produtoDB->designacao) }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('produto'))
                                        <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                            <span>{{ $errors->first('produto') }}</span>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="cliente">Preço de compra<b class="red fa fa-question-circle"></b></label>
                                    <input type="number" step="any" wire:model="precoCompra" placeholder="0,00" class="form-control" s style="height: 35px; font-size: 10pt;<?= $errors->has('precoCompra') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('precoCompra'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                        <span>{{ $errors->first('precoCompra') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="cliente">Desc(%)<b class="red fa fa-question-circle"></b></label>
                                    <input type="number" wire:model="desconto" placeholder="0,0%" class="form-control" s style="height: 35px; font-size: 10pt;<?= $errors->has('desconto') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('desconto'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                        <span>{{ $errors->first('desconto') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="cliente">Quantidade<b class="red fa fa-question-circle"></b></label>
                                    <input type="number" wire:model="quantidade" placeholder="0,0" class="form-control" s style="height: 35px; font-size: 10pt;<?= $errors->has('quantidade') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('quantidade'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                        <span>{{ $errors->first('quantidade') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <button class="btn btn-sm btn-success" wire:click.prevent="addCarrinho" style="position: absolute;top: 27px;">
                                    <span wire:loading.remove wire:target="addCarrinho">
                                        <i class="glyphicon glyphicon-plus bigger-110"></i>
                                    </span>
                                    <span wire:loading wire:target="addCarrinho">
                                        <span class="loading"></span>
                                        <i class="glyphicon glyphicon-plus bigger-110"></i>
                                    </span>
                                </button>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>Produto</th>
                                                <th>Qtd</th>
                                                <th style="text-align: right">Preço compra</th>
                                                <th style="text-align: right">Preço venda</th>
                                                <th style="text-align: right">Desc(%)</th>
                                                <th style="text-align: right">Total compra</th>
                                                <th style="text-align: right">Total venda</th>
                                                <th style="text-align: right">Total lucro</th>
                                                <th style="text-align: center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($entrada['itens'] as $key=> $item)

                                            <tr>
                                                <td>{{ $item['produto_designacao']}}</td>
                                                <td>{{ number_format($item['quantidade'], 1, ',','.')}}</td>
                                                <td style="text-align: right">{{ number_format($item['preco_compra'], 2,',','.')}}</td>
                                                <td style="text-align: right">{{ number_format($item['preco_venda'], 2,',','.')}}</td>
                                                <td style="text-align: right">{{ number_format($item['desconto'], 1,',','.')}}</td>
                                                <td style="text-align: right">{{ number_format($item['total_compras'], 2,',','.')}}</td>
                                                <td style="text-align: right">{{ number_format($item['total_vendas'], 2,',','.')}}</td>
                                                <td style="text-align: right">{{ number_format($item['total_lucro'], 2,',','.')}}</td>
                                                <td style="text-align: center">
                                                    <div class="hidden-sm hidden-xs action-buttons">
                                                        <button class="red" style="cursor: pointer;" wire:click.prevent="removeItemCart({{$key}})">
                                                            <span wire:loading.remove wire:target="removeItemCart({{$key}})">
                                                            <i class="ace-icon fa fa-trash-o fa-2x icon-only bigger-130" style="color: red"></i>
                                                            </span>
                                                            <span wire:loading wire:target="removeItemCart({{$key}})">
                                                                <span class="loading"></span>
                                                                <i class="ace-icon fa fa-trash-o fa-2x icon-only bigger-130" style="color: red"></i>
                                                            </span>



                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                             <div class="form-group has-info bold" style="left: 0%; position: relative">

                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="totalSemImpostoSemDesconto">Total S/Imposto,Desc<b class="red fa fa-question-circle"></b></label>
                                    <input type="number" step="any" wire:model="totalSemImpostoSemDesconto" placeholder="0,00" class="form-control" s style="height: 35px; font-size: 10pt;<?= $errors->has('totalSemImpostoSemDesconto') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('totalSemImpostoSemDesconto'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                        <span>{{ $errors->first('totalSemImpostoSemDesconto') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="totalDesconto">Desconto<b class="red fa fa-question-circle"></b></label>
                                    <input type="number" step="any" wire:model="totalDesconto" placeholder="0,00" class="form-control" s style="height: 35px; font-size: 10pt;<?= $errors->has('totalDesconto') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('totalDesconto'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                        <span>{{ $errors->first('totalDesconto') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="cliente">Retenção<b class="red fa fa-question-circle"></b></label>
                                    <input type="number" step="any" wire:model="precoCompra" placeholder="0,00" class="form-control" s style="height: 35px; font-size: 10pt;<?= $errors->has('precoCompra') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('precoCompra'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                        <span>{{ $errors->first('precoCompra') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="cliente">IVA<b class="red fa fa-question-circle"></b></label>
                                    <input type="number" step="any" wire:model="precoCompra" placeholder="0,00" class="form-control" s style="height: 35px; font-size: 10pt;<?= $errors->has('precoCompra') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('precoCompra'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                        <span>{{ $errors->first('precoCompra') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="cliente">Total da compra<b class="red fa fa-question-circle"></b></label>
                                    <input type="number" step="any" wire:model="precoCompra" disabled placeholder="0,00" class="form-control" s style="height: 35px; font-size: 10pt;<?= $errors->has('precoCompra') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('precoCompra'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                        <span>{{ $errors->first('precoCompra') }}</span>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <label class="control-label bold label-select2" for="cliente">Total da venda<b class="red fa fa-question-circle"></b></label>
                                    <input type="number" step="any" wire:model="precoCompra" disabled placeholder="0,00" class="form-control" s style="height: 35px; font-size: 10pt;<?= $errors->has('precoCompra') ? 'border-color: #ff9292;' : '' ?>" />
                                    @if ($errors->has('precoCompra'))
                                    <span class="help-block" style="color:#de4949;position:absolute;top: 54px;">
                                        <span>{{ $errors->first('precoCompra') }}</span>
                                    </span>
                                    @endif
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
