@section('title','Atualizar cliente')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            ATUALIZAR CLIENTE
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
                                    <label class="control-label bold label-select2" for="nomeCliente">Nome do cliente<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="cliente.nome" class="form-control" id="nomeCliente" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('cliente.nome') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('cliente.nome'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('cliente.nome') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="emailCliente">E-mail</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="cliente.email" id="emailCliente" class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="telefoneCliente">Telefone<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="cliente.telefone_cliente" maxlength="9" id="telefoneCliente" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('cliente.telefone_cliente') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('cliente.telefone_cliente'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('cliente.telefone_cliente') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="webSiteCliente">Web site</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="cliente.website" class="form-control" id="webSiteCliente" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="enderecoCliente">Endereço<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="cliente.endereco" class="form-control" id="enderecoCliente" style="height: 35px; font-size: 10pt;<?= $errors->has('cliente.endereco') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('cliente.endereco'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('cliente.endereco') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="cidadeCliente">Cidade<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="cliente.cidade" class="form-control" id="cidadeCliente" style="height: 35px; font-size: 10pt;<?= $errors->has('cliente.cidade') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('cliente.cidade'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('cliente.cidade') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="nacionalidadeCliente">Nacionalidade</label>
                                    <select wire:model="cliente.pais_id" class="col-md-12 select2" id="facturaId" style="height:35px;<?= $errors->has('cliente.pais_id') ? 'border-color: #ff9292;' : '' ?>">
                                        @foreach($paises as $pais)
                                        <option value="{{$pais->id}}">{{$pais->designacao}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="nifCliente">NIF<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="cliente.nif" class="form-control" id="nifCliente" style="height: 35px; font-size: 10pt;<?= $errors->has('cliente.nif') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('cliente.nif'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('cliente.nif') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="tipoCliente">Tipo cliente<b class="red fa fa-question-circle"></b></label>
                                    <select wire:model="cliente.tipo_cliente_id" class="col-md-12 select2" id="tipoCliente" style="height:35px;<?= $errors->has('cliente.tipo_cliente_id') ? 'border-color: #ff9292;' : '' ?>">
                                        <option value="">-- Selecionar --</option>
                                        @foreach($tiposClientes as $tipoCliente)
                                        <option value="{{$tipoCliente->id}}">{{ $tipoCliente->designacao }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('cliente.tipo_cliente_id'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('cliente.tipo_cliente_id') }}</strong>
                                    </span>
                                    @endif
                                </div>


                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="PessoaDeContacto">Pessoa de Contacto<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="cliente.pessoa_contacto" class="form-control" id="PessoaDeContacto" style="height: 35px; font-size: 10pt;<?= $errors->has('cliente.pessoa_contacto') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('cliente.pessoa_contacto'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('cliente.pessoa_contacto') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="NumeroDeContracto">Número de Contracto</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="cliente.numero_contrato" id="NumeroDeContracto" class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="contaCorrente">Conta Corrente<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" value="31.1.2.1.***" disabled id="contaCorrente" class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="taxaDesconto">Taxa de Desconto</label>
                                    <div class="input-group">
                                        <input type="number" wire:model="cliente.taxa_de_desconto" class="form-control" id="taxaDesconto" autofocus style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="LimiteCredito">Limite de Crédito</label>
                                    <div class="input-group">
                                        <input type="number" wire:model="cliente.limite_de_credito" id="LimiteCredito" class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="dataContracto">Data Contracto<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="date" wire:model="cliente.data_contrato" id="dataContracto" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('cliente.data_contrato') ? 'border-color: #ff9292;' : '' ?> " />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('cliente.data_contrato'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('cliente.data_contrato') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="search-btn" type="submit" style="border-radius: 10px" wire:click.prevent="updateCliente">
                                <span wire:loading.remove wire:target="updateCliente">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Salvar
                                </span>
                                <span wire:loading wire:target="updateCliente">Aguarde...</span>
                            </button>

                            &nbsp; &nbsp;
                            <a href="{{ route('clientes.index') }}" class="btn btn-danger" type="reset" style="border-radius: 10px">
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