@section('title','Nota de crédito')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            NOTA CRÉDITO - DAR SALDO AO CLIENTE
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

                            <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar por nome do cliente, nif, numeração da nota" />
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
                            <a href="{{ route('notaCredito.create') }}" title="emitir novo recibo" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa icofont-plus-circle"></i> Adicionar
                            </a>

                            <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="table-header widget-header">
                            Todas nota de crédito do sistema
                        </div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Numeração</th>
                                        <th>Nome do cliente</th>
                                        <th>Conta corrente</th>
                                        <th>NIF</th>
                                        <th style="text-align: right">Valor crédito</th>
                                        <th>Data criada</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notaCreditos as $notaCredito)
                                    <tr>
                                        <td>{{ $notaCredito->numeracaoDocumento }}</td>
                                        <td>{{ $notaCredito->nome_do_cliente }}</td>
                                        <td>{{ $notaCredito->conta_corrente_cliente }}</td>
                                        <td>{{ $notaCredito->nif_cliente }}</td>
                                        <td style="text-align: right">{{ number_format($notaCredito->valor_credito,2,',','.') }}</td>
                                        <td>{{ date_format($notaCredito->created_at, 'd/m/Y') }}</td>
                                        <td>
                                            <a class="blue" wire:click="printNotaCredito({{$notaCredito}})" title="Reimprimir nota credito" style="cursor: pointer">
                                                <i class="ace-icon fa fa-print bigger-160"></i>
                                                <span wire:loading wire:target="printNotaCredito({{$notaCredito}})" class="loading">
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
                {{ $notaCreditos->links() }}
            </div>
        </div>
    </div>
</div>