@section('title','clientes')
<div>
    <div class="row">
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                CLIENTES
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
                                <a href="{{ route('clientes.create') }}" title="emitir novo recibo" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                    <i class="fa icofont-plus-circle"></i> Novo cliente
                                </a>
                                <a title="imprimir clientes" href="#" wire:click.prevent="imprimirClientes" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                    <span wire:loading wire:target="imprimirClientes" class="loading"></span>
                                    <i class="fa fa-print text-default"></i> Imprimir
                                </a>

                                <div class="pull-right tableTools-container"></div>
                            </div>
                            <div class="table-header widget-header">
                                Todos os clientes do sistema
                            </div>

                            <!-- div.dataTables_borderWrap -->
                            <div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nome do cliente</th>
                                            <th>E-mail</th>
                                            <th>NIF</th>
                                            <th>Telefone</th>
                                            <th>Conta corrente</th>
                                            <th>Tipo cliente</th>
                                            <th>País</th>
                                            <th style="text-align: center">Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clientes as $cliente)
                                        <tr>
                                            <td>{{$cliente['nome']}}</td>
                                            <td>{{$cliente['email']}}</td>
                                            <td>{{$cliente['nif']}}</td>
                                            <td>{{$cliente['telefone_cliente']}}</td>
                                            <td>{{$cliente['conta_corrente']}}</td>
                                            <td>{{$cliente['tipocliente']['designacao']}}</td>
                                            <td>{{$cliente['pais']['designacao']}}</td>
                                            <td class="hidden-480" style="text-align: center">
                                                <span class="label label-sm <?= $cliente['statuGeral']['id'] == 1 ? 'label-success' : 'label-warning' ?>" style="border-radius: 20px;">{{ $cliente['statuGeral']['designacao'] }}</span>
                                            </td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    @if($cliente['diversos'] != "Sim")
                                                    <a href="{{ route('clientes.detalhes', $cliente->id) }}" class="pink" title="Editar este registo">
                                                        <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                    </a>
                                                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="pink" title="Editar este registo">
                                                        <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                    </a>
                                                    <a href="{{ route('clientes.extrato', $cliente->uuid) }}" class="pink" title="Extrato do cliente">
                                                        <i class="ace-icon fa fa-file bigger-150 bolder primary text-primary"></i>
                                                    </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ $clientes->links() }}
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
