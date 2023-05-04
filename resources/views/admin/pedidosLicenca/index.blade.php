@section('title','Pedidos licenças')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            PEDIDOS LICENÇA
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                Listagem
            </small>
        </h1>
    </div>

    <div class="col-md-12">

        <div class>
            <div class="row">
                <form id="adimitirCandidatos" method="POST" action>
                    <input type="hidden" name="_token" value />

                    <div class="col-xs-12 widget-color-green" style="left: 0%">
                        <div class="clearfix">

                            <a title="Lista de bancos" wire:click.prevent="imprimirPedidos" class="btn btn-primary widget-box widget-color-blue url" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                                <span wire:loading wire:target="imprimirPedidos" class="loading">
                                    <i class="ace-icon fa fa-print bigger-160"></i>
                                </span>
                            </a>

                            <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="row">

                            <div class="col-md-2">
                                <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                                    <span class="input-group-addon">
                                        <i class="ace-icon fa fa-search"></i>
                                    </span>
                                    <select class="input-sm form-control input-s-sm inline" wire:model="byStatus">
                                        <option value="" class="form-control">Filtrar status</option>
                                        <option value="1" class="form-control">ATIVO</option>
                                        <option value="3" class="form-control">PENDENTE</option>
                                        <option value="2" class="form-control">REJEITADO</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                                    <span class="input-group-addon">
                                        <i class="ace-icon fa fa-search"></i>
                                    </span>
                                    <select class="input-sm form-control input-s-sm inline" wire:model="byLicencas">
                                        <option value="" class="form-control">Filtrar licença</option>
                                        <option value="1" class="form-control">GRÁTIS</option>
                                        <option value="2" class="form-control">MENSAL</option>
                                        <option value="3" class="form-control">ANUAL</option>
                                        <option value="4" class="form-control">DEFINITIVO</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="input-group input-group-sm" style="margin-bottom: 10px;">

                                    <input type="text" autofocus wire:model.debounce.350ms="search" id="search" autocomplete="on" class="form-control search-query" placeholder="Buscar por nome, nif da empresa" />
                                    <span class="input-group-addon">
                                        <i class="ace-icon fa fa-search"></i>
                                    </span>
                                </div>
                            </div>


                        </div>
                        <div class="table-header widget-header" style="color:white">
                            Todos pedidos de licenças
                        </div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome empresa</th>
                                        <th>NIF</th>
                                        <th style="text-align:center">Licença</th>
                                        <th>Data pedido</th>
                                        <th>Data activação</th>
                                        <th>Data inicio</th>
                                        <th>Data final</th>
                                        <th style="text-align:center">Status</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pedidosLicenca as $pedido)
                                    <tr>
                                        <td>{{ Str::upper($pedido->empresa->nome) }}</td>
                                        <td>{{ $pedido->empresa->nif }}</td>
                                        @if($pedido->licenca->id == 1)
                                        <td style="text-align:center; color:white" class="label-danger">{{ $pedido->licenca->designacao }}</td>
                                        @elseif($pedido->licenca->id == 2)
                                        <td style="text-align:center; color:white" class="label-primary">{{ $pedido->licenca->designacao }}</td>
                                        @elseif($pedido->licenca->id == 3)
                                        <td style="text-align:center; color:white" class="label-warning">{{ $pedido->licenca->designacao }}</td>
                                        @else
                                        <td style="text-align:center; color:white" class="label-success">{{ $pedido->licenca->designacao }}</td>
                                        @endif
                                        <td>{{ date_format( $pedido->created_at, 'd/m/y H:i') }}</td>
                                        <td>{{ $pedido->data_activacao}}</td>
                                        <td>{{ $pedido->data_inicio}}</td>
                                        <td>{{ $pedido->data_fim}}</td>
                                        @if($pedido->status_licenca_id == 1)
                                        <td class="label-success" style="border-radius: 20px; color:white;text-align:center">{{ $pedido->statusLicenca->designacao }}</td>
                                        @elseif($pedido->status_licenca_id == 2)
                                        <td class="label-danger" style="border-radius: 20px; color:white;text-align:center">{{ $pedido->statusLicenca->designacao }}</td>
                                        @else
                                        <td class="label-warning" style="border-radius: 20px; color:white;text-align:center">{{ $pedido->statusLicenca->designacao }}</td>
                                        @endif
                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a class="pink" title="visualizar dado da empresa" href="{{ route('pedidoLicencaDetalhes', $pedido->id) }}" style="cursor: pointer;">
                                                    <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                </a>
                                                @if($pedido->status_licenca_id == 1 && $pedido->licenca_id !== 1)
                                                <a class="pink" title="Rejeitar pedido de licença" href=" {{ route('pedidoLicencaRejeitadoAdmin', $pedido->id) }}" style="cursor: pointer;">
                                                    <i class="ace-icon fa fa-remove bigger-150 bolder danger text-danger"></i>
                                                </a>
                                                @endif
                                                @if(($pedido->status_licenca_id == 2 || $pedido->status_licenca_id == 3) && $pedido->licenca_id !== 1)
                                                <a class="pink" title="Aceitar pedido de licença" href="{{ route('pedidoLicencaAtivarAdmin', $pedido->id) }}" style="cursor: pointer;">
                                                    <i class="ace-icon fa fa-check bigger-150 bolder sucess text-success"></i>
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
                </form>

            </div>

        </div>

    </div>
    <div> {{ $pedidosLicenca->links() }}</div>

</div>
