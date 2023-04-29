@section('title','Categorias')

<div>


    <div class="row">

        <!-- VER DETALHES  -->

        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Categorias de Produtos
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Listagem
                </small>
            </h1>
        </div>

        <div class="col-md-12">
            <div class>
                <form class="form-search" method="get" action>
                    <div class="row">
                        <div class>
                            <div class="input-group input-group-sm" style="margin-bottom: 10px">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-search"></i>
                                </span>

                                <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar por nome do cliente, nif, telefone, conta corrente" />
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

            <div class>
                <div class="row">
                    <form id="adimitirCandidatos" method="POST" action>
                        <input type="hidden" name="_token" value />

                        <div class="col-xs-12 widget-box widget-color-green" style="left: 0%">
                            <div class="clearfix">
                                <a href="{{ route('categorias.create') }}" title="emitir novo recibo" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                    <i class="fa icofont-plus-circle"></i> Nova Categoria
                                </a>
                                <a title="Imprimir Categoria" wire:click.prevent="imprimirCategoria" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                    <span wire:loading wire:target="imprimirCategoria" class="loading"></span>
                                    <i class="fa fa-print text-default"></i> Imprimir
                                </a>
                                <div class="pull-right tableTools-container"></div>
                            </div>
                            <div class="table-header widget-header">
                                Todas Categorias do sistema
                            </div>

                            <!-- div.dataTables_borderWrap -->
                            <div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Imagem</th>
                                            <th>designação</th>
                                            <th style="text-align: center">Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categorias as $categoria)
                                        <tr>
                                            <td><img src="{{$categoria['imagem']}}" width="120px" height="80px" alt="{{$categoria['designacao']}}"></td>
                                            <td>{{$categoria['categoria']['designacao'] == $categoria['designacao']? $categoria['categoria']['designacao']:$categoria['categoria']['designacao']."/". $categoria['designacao']}}</td>
                                            <td class="hidden-480" style="text-align: center">
                                                <span class="label label-sm <?= $categoria['statuGeral']['id'] == 1 ? 'label-success' : 'label-warning' ?>" style="border-radius: 20px;">{{$categoria['statuGeral']['designacao'] }}</span>
                                            </td>

                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="pink" title="Editar este registo">
                                                        <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                    </a>
                                                    @if(!count($categoria['produtos']))
                                                    <a href="{{ route('categorias.addSubCategoria', $categoria->id) }}" class="pink" title="Adicionar sub categorias">
                                                        <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                    </a>
                                                    @endif;
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
