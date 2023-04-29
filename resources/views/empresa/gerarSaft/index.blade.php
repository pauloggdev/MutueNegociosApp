@section('title','Saft')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            EXPORTAR SAFT
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
                                                <input type="date" lang="pt"  wire:model="saft.dataInicio" id="dataInicio" class="col-md-12 col-xs-12 col-sm-4" style="height:35px;<?= $errors->has('saft.dataInicio') ? 'border-color: #ff9292;' : '' ?>" />
                                            </div>
                                            @if ($errors->has('saft.dataInicio'))
                                            <span class="help-block" style="color: red; font-weight: bold">
                                                <strong>{{ $errors->first('saft.dataInicio') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label bold label-select2" for="dataFim">Escolha a data Superior<b class="red fa fa-question-circle"></b></label>
                                            <div>
                                                <input type="date" wire:model="saft.dataFinal" id="dataFim" class="col-md-12 col-xs-12 col-sm-4" style="height:35px;<?= $errors->has('saft.dataFinal') ? 'border-color: #ff9292;' : '' ?>" />
                                            </div>
                                            @if ($errors->has('saft.dataFinal'))
                                            <span class="help-block" style="color: red; font-weight: bold">
                                                <strong>{{ $errors->first('saft.dataFinal') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-9">
                                    <button class="search-btn" style="border-radius: 10px" wire:click.prevent="printSaft">

                                        <span wire:loading.remove wire:target="printSaft">
                                        <i class="ace-icon fa fa-download bigger-110"></i>
                                            EXPORTAR SAFT
                                        </span>
                                        <span wire:loading wire:target="printSaft">
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
