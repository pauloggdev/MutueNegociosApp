@section('title','Novo fornecedor')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            NOVO FORNECEDOR
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
                                    <label class="control-label bold label-select2" for="nomeCliente">Nome do fornecedor<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="fornecedor.nome" class="form-control" id="nomeCliente" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('fornecedor.nome') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('fornecedor.nome'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('fornecedor.nome') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="emailCliente">E-mail</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="fornecedor.email_empresa" id="emailCliente" class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="telefoneCliente">Telefone<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="fornecedor.telefone_empresa" maxlength="9" id="telefoneCliente" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('fornecedor.telefone_empresa') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('fornecedor.telefone_empresa'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('fornecedor.telefone_empresa') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="webSiteCliente">Web site</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="fornecedor.website" class="form-control" id="webSiteCliente" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="enderecoCliente">Endereço<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="fornecedor.endereco" class="form-control" id="enderecoCliente" style="height: 35px; font-size: 10pt;<?= $errors->has('fornecedor.endereco') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('fornecedor.endereco'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('fornecedor.endereco') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="cidadeCliente">E-mail de Contacto</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="fornecedor.email_contacto" class="form-control" id="cidadeCliente" style="height: 35px; font-size: 10pt;<?= $errors->has('fornecedor.email_contacto') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('fornecedor.email_contacto'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('fornecedor.email_contacto') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="nacionalidadeCliente">Nacionalidade</label>
                                    <span wire:ignore>
                                        <select data-livewire="@this" id="nacionalidadeId" wire:model="nacionalidadeId"  class="col-md-12 select3" style="height:35px;">
                                            <option value=""></option>
                                            @foreach($paises as $pais)
                                            <option value="{{$pais->id}}">{{$pais->designacao}}</option>
                                            @endforeach
                                        </select>
                                    </span>
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="nifCliente">NIF<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="fornecedor.nif" class="form-control" id="nifCliente" style="height: 35px; font-size: 10pt;<?= $errors->has('fornecedor.nif') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>

                                    </div>


                                </div>

                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="dataContracto">Data Contracto<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="date" wire:model="fornecedor.data_contracto" id="dataContracto" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('cliente.data_contracto') ? 'border-color: #ff9292;' : '' ?> " />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('fornecedor.data_contracto'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('fornecedor.data_contracto') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="PessoaDeContacto">Pessoa de Contacto</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="fornecedor.pessoal_contacto" class="form-control" id="PessoaDeContacto" style="height: 35px; font-size: 10pt;<?= $errors->has('fornecedor.pessoal_contacto') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('fornecedor.pessoal_contacto'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('fornecedor.pessoal_contacto') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="telefoneCliente">Telefone de Contacto</label>
                                    <div class="input-group">
                                        <input type="text" wire:model="fornecedor.telefone_contacto" maxlength="9" id="telefoneCliente" class="form-control" style="height: 35px; font-size: 10pt;<?= $errors->has('fornecedor.telefone_contacto') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('fornecedor.telefone_contacto'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('fornecedor.telefone_contacto') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="contaCorrente">Conta Corrente</label>
                                    <div class="input-group">
                                        <input type="text" value="31.1.2.1.***" disabled id="contaCorrente" class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>



                                <!-- <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="taxaDesconto">Taxa de Desconto</label>
                                    <div class="input-group">
                                        <input type="number" wire:model="cliente.taxa_de_desconto" class="form-control" id="taxaDesconto" autofocus style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div> -->
                                <!-- <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="LimiteCredito">Limite de Crédito</label>
                                    <div class="input-group">
                                        <input type="number" wire:model="cliente.limite_de_credito" id="LimiteCredito" class="form-control" style="height: 35px; font-size: 10pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div> -->


                            </div>
                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="search-btn" type="submit" style="border-radius: 10px" wire:click.prevent="salvarFornecedor">
                                <span wire:loading.remove wire:target="salvarFornecedor">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Salvar
                                </span>
                                <span wire:loading wire:target="salvarFornecedor">
                                    <span class="loading"></span>
                                    Aguarde...</span>
                            </button>

                            &nbsp; &nbsp;
                            <a href="{{ route('fornecedores.index') }}" class="btn btn-danger" type="reset" style="border-radius: 10px">
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
