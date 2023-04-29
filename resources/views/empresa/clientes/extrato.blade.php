@section('title','Extrado do cliente')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            EMITIR EXTRATO
        </h1>
        <h1>
            CLIENTE: <?= Str::upper($cliente->nome) ?>
        </h1>
    </div>

    <div class="modal-body">
        <div class="row" style="left: 0%; position: relative;">
            <div class="col-md-12">
                <form class="filter-form form-horizontal validation-form">
                    <div class="second-row">
                        <div class="tabbable">
                            <div class="tab-content profile-edit-tab-content">
                                <div id="dados_motivo" class="tab-pane in active">
                                    <div class="form-group has-info">
                                        <div class="col-md-6">
                                            <label class="control-label bold label-select2" for="dataInicio">Escolha a data Inferior<b class="red fa fa-question-circle"></b></label>
                                            <div>
                                                <input type="date" lang="pt"  wire:model="dataInicio" id="dataInicio" class="col-md-12 col-xs-12 col-sm-4" style="height:35px;<?= $errors->has('dataInicio') ? 'border-color: #ff9292;' : '' ?>" />
                                            </div>
                                            @if ($errors->has('dataInicio'))
                                            <span class="help-block" style="color: red; font-weight: bold">
                                                <strong>{{ $errors->first('dataInicio') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label bold label-select2" for="dataFim">Escolha a data Superior<b class="red fa fa-question-circle"></b></label>
                                            <div>
                                                <input type="date" wire:model="dataFim" id="dataFim" class="col-md-12 col-xs-12 col-sm-4" style="height:35px;<?= $errors->has('dataFim') ? 'border-color: #ff9292;' : '' ?>" />
                                            </div>
                                            @if ($errors->has('dataFim'))
                                            <span class="help-block" style="color: red; font-weight: bold">
                                                <strong>{{ $errors->first('dataFim') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group has-info">
                                        <div class="col-md-2">
                                            <label class="control-label bold label-select2" for="dataInicio">Todo periodo</label>
                                            <div>
                                                <input type="checkbox" lang="pt"  wire:model="checkTodoPeriodo" id="dataInicio" class="col-md-12 col-xs-12 col-sm-4" style="height:35px; width: 35px" />
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-9">
                                    <button class="search-btn" style="border-radius: 10px" wire:click.prevent="imprimirExtratoCliente">

                                        <span wire:loading.remove wire:target="imprimirExtratoCliente">
                                        <i class="ace-icon fa fa-print bigger-110"></i>
                                            EMITIR EXTRATO
                                        </span>
                                        <span wire:loading wire:target="imprimirExtratoCliente">
                                            <span class="loading"></span>
                                            Aguarde...</span>
                                    </button>

                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
