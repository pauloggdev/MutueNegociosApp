@section('title','Editar Empresa')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            EDITAR EMPRESA
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
                                        <input type="text" wire:model="empresa.nome" class="form-control" id="nome" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.nome') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('empresa.nome'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('empresa.nome') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="nif">NIF<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.nif" class="form-control" id="nif" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.nif') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('empresa.nif'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('empresa.nif') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="email">E-mail<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.email" class="form-control" id="email" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.email') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('empresa.email'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('empresa.email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="cidade">Cidade<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.cidade" class="form-control" id="cidade" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.cidade') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('empresa.cidade'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('empresa.cidade') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="nome">Endereço<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.endereco" class="form-control" id="endereco" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.endereco') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('empresa.endereco'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('empresa.endereco') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="telefone">Telefone<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.pessoal_Contacto" class="form-control" id="nif" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.pessoal_Contacto') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('empresa.pessoal_Contacto'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('empresa.pessoal_Contacto') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="website">Website</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.website" class="form-control" id="website" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.website') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('empresa.website'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('empresa.website') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="pessoa_de_contacto">Pessoa de contato</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.pessoa_de_contacto" class="form-control" id="pessoa_de_contacto" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.pessoa_de_contacto') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('empresa.pessoa_de_contacto'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('empresa.pessoa_de_contacto') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="tipo_cliente_id">Tipo empresa</label>
                                    <select wire:model="empresa.tipo_cliente_id" class="col-md-12 select2" id="facturaId" style="height:35px;<?= $errors->has('empresa.tipo_cliente_id') ? 'border-color: #ff9292;' : '' ?>">
                                        @foreach($tipoEmpresas as $tipoEmpresa)
                                        <option value="{{$tipoEmpresa->id}}">{{ $tipoEmpresa->designacao }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="tipo_regime_id">Tipo regime</label>
                                    <select wire:model="empresa.tipo_regime_id" class="col-md-12 select2" id="tipo_regime_id" style="height:35px;<?= $errors->has('empresa.tipo_regime_id') ? 'border-color: #ff9292;' : '' ?>">
                                        @foreach($tipoRegimes as $tipoRegime)
                                        <option value="{{$tipoRegime->id}}">{{ $tipoRegime->Designacao }}</option>
                                        @endforeach </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="newFileAlvara">Alvará&nbsp;&nbsp;<a href="/upload/{{$empresa->file_alvara}}" target="blank" style="color: #337ab7;">baixar arquivo pdf</a></label>
                                    <div class="input-group">
                                        <input type="file" wire:model="newFileAlvara" class="form-control" id="newFileAlvara" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.file_alvara') ? 'border-color: #ff9292;' : '' ?>" />
                                    </div>
                                    @if ($errors->has('empresa.file_alvara'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('empresa.file_alvara') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="file_nif">NIF&nbsp;&nbsp;<a href="/upload/{{$empresa->file_nif}}" target="blank" style="color: #337ab7;">baixar arquivo pdf</a></label>
                                    <div class="input-group">
                                        <input type="file" wire:model="newFileNIF" class="form-control" id="file_nif" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.file_nif') ? 'border-color: #ff9292;' : '' ?>" />
                                    </div>
                                    @if ($errors->has('empresa.file_nif'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('empresa.file_nif') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">

                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="logotipo">Logotipo</label>
                                    <div class="input-group">
                                        <input type="file" wire:model="newLogotipo" class="form-control" id="logotipo" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.logotipo') ? 'border-color: #ff9292;' : '' ?>" />
                                    </div>
                                    @if ($errors->has('empresa.logotipo'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('empresa.logotipo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group has-info">
                                <div class="col-md-12">
                                    <img src='{{ url("upload/$empresa->logotipo")}}' width="112px" alt="">
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
