@section('title','Entradas Produtos')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            ENTRADAS PRODUTO
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

        <div class>
            <div class="row">
                <form id="adimitirCandidatos" method="POST" action>
                    <input type="hidden" name="_token" value />

                    <div class="col-xs-12 widget-box widget-color-green" style="left: 0%">
                        <div class="clearfix">
                            <a href="{{ route('entradasProdutosCreate') }}" title="emitir novo recibo" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa icofont-plus-circle"></i> Nova entrada
                            </a>

                            <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="table-header widget-header">
                            Todas entradas de produto do sistema
                        </div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nº factura</th>
                                        <th>Nome do fornecedor</th>
                                        <th>Forma de pagamento</th>
                                        <th>Data entrada</th>
                                        <th>Armazém</th>
                                        <th style="text-align: center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($entradasProdutos as $entrada)
                                    <tr>
                                        <td>{{ $entrada->id }}</td>
                                        <td>{{ $entrada->num_factura_fornecedor }}</td>
                                        <td>{{ $entrada->fornecedor->nome }}</td>
                                        <td>{{ $entrada->formaPagamento->descricao }}</td>
                                        <td>{{ date_format(date_create($entrada->created_at),"d/m/Y") }}</td>
                                        <td>{{ $entrada->armazem->designacao }}</td>
                                        <td style="text-align: center">
                                            <a class="blue" wire:click="printEntrada({{$entrada->id}})" title="Reimprimir o recibo" style="cursor: pointer">
                                                <i class="ace-icon fa fa-print bigger-160"></i>
                                                <span wire:loading wire:target="printEntrada({{$entrada->id}})" class="loading">
                                                    <i class="ace-icon fa fa-print bigger-160"></i>
                                                </span>
                                            </a>
                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
                <div>{{ $entradasProdutos->links() }}</div>
            </div>

        </div>

    </div>
</div>
