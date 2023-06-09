@section('title','Gerar cupon desconto')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            GERAR CUPON
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
                                    <label class="control-label bold label-select2" for="codigoCupon">Código Cupon<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="cupon.codigo" disabled class="form-control" id="codigoCupon" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('cupon.codigo') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('cupon.codigo'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('cupon.codigo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="desconto">Desconto(%)<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="number" maxlength="100" minlength="0"  wire:model="cupon.percentagem" class="form-control" id="desconto" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('cupon.percentagem') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('cupon.percentagem'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('cupon.percentagem') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="dataExpiracao">Data Expiração<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="datetime-local" wire:model="cupon.data_expiracao" id="dataExpiracao" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('cupon.data_expiracao') ? 'border-color: #ff9292;' : '' ?> " />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('cupon.data_expiracao'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('cupon.data_expiracao') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="search-btn" type="submit" style="border-radius: 10px" wire:click.prevent="gerarCuponDesconto">
                                <span wire:loading.remove wire:target="gerarCuponDesconto">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Salvar
                                </span>
                                <span wire:loading wire:target="gerarCuponDesconto">
                                <span class="loading"></span>    
                                Aguarde...</span>
                            </button>

                            &nbsp; &nbsp;
                            <a href="{{ route('cuponDesconto.index') }}" class="btn btn-danger" type="reset" style="border-radius: 10px">
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