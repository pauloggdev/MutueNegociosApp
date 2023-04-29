@section('title','Nova taxa')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            NOVA TAXA
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
                @csrf
                <div class="second-row">
                    <div class="tabbable">
                        <div class="tab-content profile-edit-tab-content">


                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="name">Taxa<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" autofocus wire:model="taxaIva.taxa" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('taxaIva.taxa') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('taxaIva.taxa'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('taxaIva.taxa') }}</strong>
                                    </span>
                                    @endif
                                </div>
                             
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="status_id">Status</label>
                                    <select wire:model="taxaIva.codigostatus" class="col-md-12 select2" id="status_id" style="height:35px;<?= $errors->has('taxaIva.codigostatus') ? 'border-color: #ff9292;' : '' ?>">
                                        <option value="1">Ativo</option>
                                        <option value="2">Desactivo</option>

                                    </select>
                                    @if ($errors->has('taxaIva.codigostatus'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('taxaIva.codigostatus') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="search-btn" type="submit" style="border-radius: 10px" wire:click.prevent="salvarTaxa">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                <span wire:loading.remove wire:target="salvarTaxa">
                                    Salvar
                                </span>
                                <span wire:loading wire:target="salvarTaxa">
                                    <span class="loading"></span>

                                    Aguarde...</span>
                            </button>

                            &nbsp; &nbsp;
                            <a class="btn btn-danger" type="reset" href="{{ route('taxaIva.index') }}" style="border-radius: 10px">
                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>