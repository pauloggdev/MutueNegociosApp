<?php

use Illuminate\Support\Str;

?>

@section('title','editar categoria')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            ADICIONAR SUB-CATEGORIA DE: <b>{{Str::upper($categoria['designacao'])}}</b>
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
                    <button wire:click.prevent="addSubCategoria">+</button>
                    <div class="tabbable">
                        <div class="tab-content profile-edit-tab-content">
                            @foreach($subCategorias as $key=> $subCategoria)
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="subCategoria.{{$key}}.Designacao">Nome da Categoria <b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" wire:model="subCategorias.{{$key}}.designacao" class="form-control" id="subCategoria.{{$key}}.Designacao" autofocus style="height: 35px; font-size: 10pt;<?= $errors->has('subCategorias.{{$key}}.designacao') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon.{{$key}}.">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('subCategorias.{{$key}}.designacao'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('subCategorias.$key.designacao') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="newImg.{{$key}}.categoria">Imagem</label>
                                    <div class="input-group">
                                        <input type="file" accept="application/image/*" wire:model="subCategorias.{{$key}}.imagem" class="form-control" id="newImg.{{$key}}.categoria" style="height: 35px; font-size: 10pt;<?= $errors->has('subCategoria.{{$key}}.imagem') ? 'border-color: #ff9292;' : '' ?>" />
                                        <span class="input-group-addon" id="basic-addon1.{{$key}}.">
                                            <i class="ace-icon fa fa-info bigger-150 text-info" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('subCategorias.{{$key}}.imagem'))
                                    <span class="help-block" style="color: red; font-weight: bold;position:absolute;">
                                        <strong>{{ $errors->first('subCategorias.$key.imagem') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div>
                                <a title="Eliminar este Registro" style="    cursor: pointer;
    position: absolute;
    right: -10px;
    top: 36px;" wire:click.prevent="removerSubCategoria({{$key}})">
                                    <i class="ace-icon fa fa-trash-o bigger-150 bolder danger red"></i>
                                </a>
                            </div>
                            </div>

                            @endforeach

                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="search-btn" type="submit" style="border-radius: 10px" wire:click.prevent=" CategoriaUpdate">
                                <span wire:loading.remove wire:target=" CategoriaUpdate">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Salvar
                                </span>
                                <span wire:loading wire:target=" CategoriaUpdate">
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
