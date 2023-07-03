@section('title','Atualizar produto em destaque')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            ATUALIZAR PRODUTO EM DESTAQUE
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
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="produtoId">Buscar produto<b class="red fa fa-question-circle"></b></label>
                                    <div wire:ignore>
                                        <!-- <select wire:model="destaque.produtoId" id="produtoId" class="col-md-12 select3" style="height:35px;"> -->
                                        <select wire:model="destaque.produtoId" id="produtoId" disabled class="col-md-12" style="height:35px;<?= $errors->has('destaque.produtoId') ? 'border-color: #ff9292;' : '' ?>">
                                            <option value="">Selecione...</option>
                                            @foreach($produtos as $produto)
                                            <option value="{{ $produto->id }}">{{ $produto->designacao }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if ($errors->has('destaque.produtoId'))
                                    <span class="help-block" style="color: red; font-weight: bold;margin-top: 32px;">
                                        <strong>{{ $errors->first('destaque.produtoId') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="designacao">Designação<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="destaque.designacao"  class="form-control" id="designacao" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('destaque.designacao') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('destaque.designacao'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('destaque.designacao') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-12">
                                    <label class="control-label bold label-select2" for="descricao">Descrição<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <textarea wire:model="destaque.descricao" id="descricao" cols="200" rows="2" class="form-control" style="font-size: 16px; z-index: 1;<?= $errors->has('destaque.descricao') ? 'border-color: #ff9292;' : '' ?>"></textarea>
                                    </div>
                                    @if ($errors->has('destaque.descricao'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('destaque.descricao') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="search-btn" type="submit" style="border-radius: 10px" wire:click.prevent="atualizarProdutoDestaque">
                                <span wire:loading.remove wire:target="atualizarProdutoDestaque">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Salvar
                                </span>
                                <span wire:loading wire:target="atualizarProdutoDestaque">
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
