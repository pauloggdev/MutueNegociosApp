@section('title','Fecho de caixa')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            FECHO DE CAIXA
        </h1>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="alert alert-warning hidden-sm hidden-xs">
                <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
                </button>
                Será impresso o fecho de caixa da data selecionada no intervalo de hora das 07:30:00 à 22:00:00
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
                                    <label class="control-label bold label-select2" for="data">Selecione a data<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="date" wire:model="data" class="form-control" id="data" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('data') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                        </span>
                                    </div>
                                    @if ($errors->has('data'))
                                    <span class="help-block" style="color: red; position: absolute; margin-top: -2px;font-size: 12px;">
                                        <strong>{{ $errors->first('data') }}</strong>
                                    </span>
                                    @endif
                                </div>


                            </div>

                        </div>
                    </div>
                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button wire:click.prevent="imprimirFechoCaixa" class="search-btn" style="border-radius: 10px;">
                                <span wire:loading.remove="" wire:target="imprimirFechoCaixa"><i class="ace-icon fa fa-print bigger-110"></i>
                                    IMPRIMIR PDF
                                </span>
                                <span wire:loading="" wire:target="imprimirFechoCaixa">
                                    <span class="loading">

                                    </span>
                                    Aguarde...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
