<?php

use Illuminate\Support\Str;

?>

@section('title','Produtos')
<div>
    <div class="row">
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                PRODUTOS
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Listagem
                </small>
            </h1>
        </div>
        <div class>
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-sm" style="margin-bottom: 10px">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-search"></i>
                                </span>
                                <select wire:model="vendaOnline" class="form-control">
                                    <option value="N">Mostrar todos</option>
                                    @if(auth()->user()->empresa->venda_online == 'Y')
                                    <option value="Y">Produto vendas online</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-sm" style="margin-bottom: 10px">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-search"></i>
                                </span>
                                <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar por nome do produto" />
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary btn-lg upload">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-130"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        <div class="col-md-12">

            <div class>
                <div class="row">
                    <form id="adimitirCandidatos" method="POST" action>
                        <input type="hidden" name="_token" value />

                        <div class="col-xs-12 widget-box widget-color-green" style="left: 0%">
                            <div class="clearfix">
                                <a href="{{ route('produto.create') }}" title="adicionar novo produto" class="btn btn-success widget-box widget-color-blue botoes">
                                    <i class="fa icofont-plus-circle"></i> Novo produto
                                </a>
                                <a title="imprimir produtos" href="#" wire:click.prevent="imprimirProdutos" class="btn btn-primary widget-box widget-color-blue botoes" >
                                    <span wire:loading wire:target="imprimirProdutos" class="loading"></span>
                                    <i class="fa fa-print text-default"></i> Imprimir
                                </a>
                                <div class="pull-right tableTools-container"></div>
                            </div>
                            <div class="table-header widget-header">
                                Todos os produtos do sistema
                            </div>

                            <!-- div.dataTables_borderWrap -->
                            <div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nome</th>
                                            <th>Categoria</th>
                                            <th style="text-align:right">Taxa</th>
                                            <th style="text-align:right">Preço Compra</th>
                                            <th style="text-align:right">Preço Venda</th>
                                            <th style="text-align:center">Estocavel</th>
                                            <th style="text-align:center">Venda online</th>
                                            <th style="text-align: center">Estado</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($produtos as $produto)
                                        <tr>
                                            <td>{{ $produto['id'] }}</td>
                                            <td>{{ Str::upper($produto['designacao'])}}</td>
                                            <td>{{ Str::upper($produto['categoria']['designacao'])}}</td>
                                            <td style="text-align:right">{{ $produto['tipoTaxa']['descricao'] }}</td>
                                            <td style="text-align:right">{{ number_format($produto['preco_compra'],2, ',','.')}}</td>
                                            <td style="text-align:right">{{ number_format($produto['preco_venda'],2, ',','.')}}</td>
                                            <td style="text-align:center">

                                                @if($produto['stocavel'] == 'Sim')
                                                <span class="label label-sm label-success">{{ $produto['stocavel']}}</span>
                                                @else
                                                <span class="label label-sm label-warning">{{ $produto['stocavel']}}</span>
                                                @endif

                                            </td>
                                            <td style="text-align:center">

                                                @if($produto['venda_online'] == 'Y')
                                                <span class="label label-sm label-success">Sim</span>
                                                @else
                                                <span class="label label-sm label-warning">Não</span>
                                                @endif

                                            </td>
                                            <td style="text-align:center">
                                                @if($produto['status_id'] == 1)
                                                <span class="label label-sm label-success">{{ $produto['statuGeral']['designacao']}}</span>
                                                @else
                                                <span class="label label-sm label-warning">{{ $produto['statuGeral']['designacao']}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a href="{{ route('produto.edit', $produto['uuid']) }}">
                                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    <div>{{$produtos->links()}}</div>
                </div>
            </div>
        </div>
    </div>

</div>
