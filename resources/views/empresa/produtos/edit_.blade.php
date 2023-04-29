<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            EDITAR PRODUTO
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
            <form method="POST" action="{{ route('produto.update', $produto->uuid) }}" enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                @csrf
                <div class="second-row">
                    <div class="tabbable">
                        <div class="tab-content profile-edit-tab-content">
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="designacao">Nome do Produto<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <input type="text" id="designacao" value="{{ $produto->designacao ?? old('designacao')}}" name="designacao" autofocus class="col-md-12 col-xs-12 col-sm-4" style="<?= $errors->has('designacao') ? 'border-color: #ff9292 !important' : '' ?>" />
                                        <span class="input-group-addon">
                                            <i class="fa fa-info-circle bigger-110 text-info"></i>
                                        </span>
                                    </div>
                                    @if ($errors->has('designacao'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('designacao') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="categoria_id">Categoria<b class="red"></b></label>
                                    <select name="categoria_id" class="col-md-12 select2" data-placeholder="Selecione o status" id="statu_id" style="height:35px ;">
                                        @foreach($categorias as $categoria)
                                        <option <?= $produto->categoria_id == $categoria->id ? 'selected' : '' ?> value="{{$categoria->id}}">{{$categoria->designacao}}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('categoria_id'))
                                    <span class="help-block" style="color: red;">
                                        <strong>{{ $errors->first('categoria_id') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <h4 class="header bolder smaller" style="color: #3d5476">
                                Vendas
                            </h4>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="preco_compra">Preço de Compra<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">Kz</div>
                                        <input type="number" value="{{ $produto->preco_compra ?? old('preco_compra')}}" name="preco_compra" class="form-control" id="preco_compra" data-target="form_supply_price" style="height: 35px; font-size: 13pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="fa fa-calculator price-popup-icon" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="preco_venda">Preço de Venda<b class="red fa fa-question-circle"></b></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">Kz</div>
                                        <input id="preco_venda" value="{{ $produto->preco_venda ?? old('preco_venda')}}" name="preco_venda" type="number" class="price_with_tax form-control" style="height: 35px; font-size: 13pt; <?= $errors->has('preco_venda') ? 'border-color: #ff9292 !important;' : '' ?>" />
                                    </div>
                                    @if ($errors->has('preco_venda'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('preco_venda') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <label class="control-label bold label-select2" for="categoria_id">Status<b class="red"></b></label>
                                    <select name="status_id" class="col-md-12 select2" data-placeholder="Selecione o status" id="statu_id" style="height:35px ;">
                                        @foreach($status as $statu)
                                        <option value="{{$statu->id}}" <?= $produto->status_id == $statu->id ? 'selected' : '' ?>>{{$statu->designacao}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="preco_compra">Qtd. Mínima<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">0.0</div>
                                        <input type="number" value="{{ $produto->quantidade_minima ?? old('quantidade_minima')}}" name="quantidade_minima" class="form-control" id="preco_compra" data-target="form_supply_price" style="height: 35px; font-size: 13pt" />
                                        <span class="input-group-addon" id="basic-addon1">
                                            <i class="fa fa-calculator price-popup-icon" data-target="form_supply_price_smartprice"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="control-label bold label-select2" for="margem_lucro">Qtd. Crítica<b class="red fa fa-question-"></b></label>
                                    <div class="input-group">
                                        <div class="input-group-addon">0.0</div>
                                        <input type="number" value="{{ $produto->quantidade_critica ?? old('quantidade_critica')}}" name="quantidade_critica" class="markup form-control" id="margem_lucro" title="Margem de lucro que pretende ter na venda do produto." style="height: 35px; font-size: 13pt" />
                                        <input type="hidden" name="canal_id" value="2" class="markup form-control" style="height: 35px; font-size: 13pt" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="preco_venda">Controlar Stock <b class="red fa fa-question-circle"></b></label>
                                    <select name="stocavel" class="col-md-12 select2" data-placeholder="Selecione o status" id="statu_id" style="height:35px ;">
                                        <option value="Sim" <?= $produto->stocavel == 'Sim' ? 'selected' : '' ?>>Sim</option>
                                        <option value="Não" <?= $produto->stocavel == 'Não' ? 'selected' : '' ?>>Não</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="preco_compra">Imposto/Taxas<b class="red fa fa-question-"></b></label>
                                    <select name="codigo_taxa" class="col-md-12 select2" data-placeholder="Selecione o status" id="statu_id" style="height:35px ;">
                                        @foreach($taxas as $taxa)
                                        <option value="{{$taxa->codigo}}" <?= $produto->codigo_taxa == $taxa->codigo ? 'selected' : '' ?>>{{$taxa->descricao}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="margem_lucro">Motivo de Isenção<b class="red fa fa-question-"></b></label>
                                    <select name="motivo_isencao_id" class="col-md-12 select2" data-placeholder="Selecione o status" id="statu_id" style="height:35px ;">
                                        @foreach($motivos as $motivo)
                                        <option value="{{$motivo->codigo}}" <?= $produto->motivo_isencao_id == $motivo->codigo ? 'selected' : '' ?>>{{$motivo->descricao}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-6">
                                    <label for="id-input-file-2" class="text-info">Imagem</label>
                                    <div class="file-upload-wrapper">
                                        <input type="file" name="imagem_produto" accept="application/image/*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="preco_compra">Armazém<b class="red fa fa-question-"></b></label>
                                    <select name="armazem_id" class="col-md-12 select2" data-placeholder="Selecione o status" id="statu_id" style="height:35px ;">
                                        @foreach($armazens as $armazem)
                                        <option value="{{$armazem->id}}" <?= $produto->armazem_id == $armazem->id ? 'selected' : '' ?>>{{$armazem->designacao}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <h4 class="header bolder smaller" style="color: #3d5476;cursor:pointer">
                                Características
                                <i class="ace-icon fa fa-angle-down icon-on-right big-150" style="cursor:pointer"></i>
                            </h4>
                            <div class="form-group has-info bold" style="left: 0%; position: relative">
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="preco_compra">Unidade<b class="red fa fa-question-"></b></label>
                                    <select name="unidade_medida_id" class="col-md-12 select2" data-placeholder="Selecione o status" id="statu_id" style="height:35px ;">
                                        @foreach($unidades as $unidade)
                                        <option value="{{$unidade->id}}" <?= $produto->unidade_medida_id == $unidade->id ? 'selected' : '' ?>>{{$unidade->designacao}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="control-label bold label-select2" for="preco_compra">Fabricantes<b class="red fa fa-question-"></b></label>
                                    <select name="fabricante_id" class="col-md-12 select2" data-placeholder="Selecione o status" id="statu_id" style="height:35px ;">
                                        @foreach($fabricantes as $fabricante)
                                        <option value="{{$fabricante->id}}" <?= $produto->fabricante_id == $fabricante->id ? 'selected' : '' ?>>{{$fabricante->designacao}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="clearfix form-actions">
                        <div class="col-md-offset-3 col-md-9">
                            <button class="search-btn" type="submit" style="border-radius: 10px">
                                <i class="ace-icon fa fa-check bigger-110"></i>
                                Salvar
                            </button>

                            &nbsp; &nbsp;
                            <button class="btn btn-danger" type="reset" style="border-radius: 10px">
                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                Cancelar
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


