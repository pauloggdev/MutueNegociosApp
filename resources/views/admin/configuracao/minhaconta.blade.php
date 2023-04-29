@section('title','Minha conta')
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

    <div class="row">
        <div class="col-md-12">
            <form class="filter-form form-horizontal validation-form" id="validation-form">
                @csrf
                <div class="second-row">
                    <div class="tabbable">
                        <div class="tab-content profile-edit-tab-content">
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-8">
                                    <label class="control-label bold label-select2" for="name">Nome empresa<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.nome" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.nome') ? 'border-color: #ff9292;' : '' ?>" />
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
                                    <label class="control-label bold label-select2" for="NIF">NIF<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.nif" class="form-control" id="NIF" data-target="form_supply_price" style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.nif') ? 'border-color: #ff9292;' : '' ?>" />
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

                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="pessoal_Contacto">Telefone<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.pessoal_Contacto" class="form-control" id="pessoal_Contacto" data-target="form_supply_price" style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.pessoal_Contacto') ? 'border-color: #ff9292;' : '' ?>" />
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

                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="email">E-mail<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.email" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.email') ? 'border-color: #ff9292;' : '' ?>" />
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
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="pessoa_de_contacto">Pessoa de contato</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.pessoa_de_contacto" class="form-control" id="pessoa_de_contacto" data-target="form_supply_price" style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.pessoa_de_contacto') ? 'border-color: #ff9292;' : '' ?>" />
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
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-8">
                                    <label class="control-label bold label-select2" for="endereco">Endereço<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.endereco" class="form-control" id="endereco" data-target="form_supply_price" style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.endereco') ? 'border-color: #ff9292;' : '' ?>" />
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
                                    <label class="control-label bold label-select2" for="tipo_regime_id">Regime<b class="red fa fa-question-circle"></b></label>
                                    <select wire:model="empresa.tipo_regime_id" class="col-md-12 select2" id="tipo_regime_id" style="height:35px;<?= $errors->has('empresa.tipo_regime_id') ? 'border-color: #ff9292;' : '' ?>">
                                        @foreach($regimes as $regime)
                                        <option value="{{$regime->id}}">{{$regime->Designacao}}</option>
                                        @endforeach

                                    </select>
                                    @if ($errors->has('empresa.tipo_regime_id'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('empresa.tipo_regime_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="website">Website<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.website" id="website" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.website') ? 'border-color: #ff9292;' : '' ?>" />
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
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="cidade">Cidade<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="empresa.cidade" placeholder="Luanda" class="form-control" id="cidade" data-target="form_supply_price" style="height: 35px; font-size: 10pt;<?= $errors->has('empresa.cidade') ? 'border-color: #ff9292;' : '' ?>" />
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
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="logotipo">Logotipo</label>
                                    <div class="input-group">
                                        <input type="file" wire:model="logotipoAtual" class="form-control" id="logotipo" style="height: 35px; font-size: 10pt" />
                                    </div>
                                </div>

                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <img src="<?= '/upload/' . $logotipoAnterior ?>" alt="" width="150px">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="search-btn" type="submit" style="border-radius: 10px" wire:click.prevent="atualizarEmpresa">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                <span wire:loading.remove wire:target="atualizarEmpresa">
                                    Salvar
                                </span>
                                <span wire:loading wire:target="atualizarEmpresa">
                                    <span class="loading"></span>

                                    Aguarde...</span>
                            </button>

                            &nbsp; &nbsp;
                            <a class="btn btn-danger" type="reset" href="{{ route('admin.users.index') }}" style="border-radius: 10px">
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