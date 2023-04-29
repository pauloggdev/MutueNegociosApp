@section('title','Editar o centro de custo')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            EDITAR CENTRO DE CUSTO
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
                                    <label class="control-label bold label-select2" for="nome">Empresa<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="centroCusto.nome" class="form-control" id="nome" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('centroCusto.nome') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('centroCusto.nome'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('centroCusto.nome') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="nif">NIF<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="centroCusto.nif" class="form-control" id="nif" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('centroCusto.nif') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('centroCusto.nif'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('centroCusto.nif') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="email">E-mail<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="centroCusto.email" class="form-control" id="email" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('centroCusto.email') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('centroCusto.email'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('centroCusto.email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="cidade">Cidade<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="centroCusto.cidade" class="form-control" id="cidade" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('centroCusto.cidade') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('centroCusto.cidade'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('centroCusto.cidade') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="nome">Endereço<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="centroCusto.endereco" class="form-control" id="endereco" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('centroCusto.endereco') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('centroCusto.endereco'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('centroCusto.endereco') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="telefone">Telefone<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="centroCusto.telefone" class="form-control" id="nif" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('centroCusto.telefone') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('centroCusto.telefone'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('centroCusto.telefone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="website">Website</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="centroCusto.website" class="form-control" id="website" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('centroCusto.website') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('centroCusto.website'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('centroCusto.website') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="pessoa_de_contacto">Pessoa de contato</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="centroCusto.pessoa_de_contacto" class="form-control" id="pessoa_de_contacto" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('centroCusto.pessoa_de_contacto') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('centroCusto.pessoa_de_contacto'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('centroCusto.pessoa_de_contacto') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="status">Status</label>
                                    <select wire:model="centroCusto.status_id" class="col-md-12 select2" id="status" style="height:35px;<?= $errors->has('centroCusto.status_id') ? 'border-color: #ff9292;' : '' ?>">
                                        <option value="1">Activo</option>
                                        <option value="2">Desactivo</option>
                                    </select>
                                </div>

                            </div>

                            <div class="form-group has-info bold" style="left: 0%; position: relative">

                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="logotipo">Logotipo</label>
                                    <div class="input-group">
                                        <input type="file" wire:model="newLogotipo" class="form-control" id="logotipo" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('centroCusto.logotipo') ? 'border-color: #ff9292;' : '' ?>" />
                                    </div>
                                    @if ($errors->has('centroCusto.logotipo'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('centroCusto.logotipo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="newAlvara">Alvará&nbsp;&nbsp;<a href="/upload/{{$centroCusto->file_alvara}}" target="blank" style="color: #337ab7;">baixar arquivo pdf</a></label>
                                    <div class="input-group">
                                        <input type="file" wire:model="newAlvara" class="form-control" id="newAlvara" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('newAlvara') ? 'border-color: #ff9292;' : '' ?>" />
                                    </div>
                                    @if ($errors->has('newAlvara'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('newAlvara') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="newNIF">NIF&nbsp;&nbsp;<a href="/upload/{{$centroCusto->file_nif}}" target="blank" style="color: #337ab7;">baixar arquivo pdf</a></label>
                                    <div class="input-group">
                                        <input type="file" wire:model="newNIF" class="form-control" id="newNIF" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('newNIF') ? 'border-color: #ff9292;' : '' ?>" />
                                    </div>
                                    @if ($errors->has('newNIF'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('newNIF') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-info">
                                <div class="col-md-12">
                                    <img src='{{ url("upload/$centroCusto->logotipo")}}' width="112px" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="search-btn" type="submit" style="border-radius: 10px" wire:click.prevent="update">
                                <span wire:loading.remove wire:target="update">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Salvar
                                </span>
                                <span wire:loading wire:target="update">
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
