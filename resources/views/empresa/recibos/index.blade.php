@section('title','Recibos')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            RECIBOS
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

                            <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar por nome do cliente, numeração do recibo" />
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
                            <a href="{{ route('recibos.create') }}" title="emitir novo recibo" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa icofont-plus-circle"></i> Novo recibo
                            </a>

                            <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="table-header widget-header">
                            Todas recibos do sistema
                        </div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nº Recibo</th>
                                        <th>Factura referente</th>
                                        <th>Nome do cliente</th>
                                        <th style="text-align: right">Valor entregue</th>
                                        <th>Forma pagamento</th>
                                        <th>Emitido</th>
                                        <th style="text-align: center">Anulado</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recibos as $recibo)
                                    <tr>
                                        <td>{{$recibo->numeracao_recibo}}</td>
                                        <td>{{$recibo->factura->numeracaoFactura}}</td>
                                        <td>{{$recibo->nome_do_cliente}}</td>
                                        <td style="text-align: right">{{number_format($recibo->valor_total_entregue, 2, ',','.')}}</td>
                                        <td>{{$recibo->formaPagamento->descricao}}</td>
                                        <td>{{date_format($recibo->created_at,'d/m/Y')}}</td>
                                        <td style="text-align: center">
                                            <span class="label label-sm <?= $recibo->anulado == 1 ? 'label-success' : 'label-danger' ?>"><?= $recibo->anulado == 1 ? "Não" : "Sim" ?></span>
                                        </td>
                                        <td>
                                            <a class="blue" wire:click="printRecibo({{$recibo->id}})" title="Reimprimir o recibo" style="cursor: pointer">
                                                <i class="ace-icon fa fa-print bigger-160"></i>
                                                <span wire:loading wire:target="printRecibo({{$recibo->id}})" class="loading">
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
                {{ $recibos->links() }}

            </div>

        </div>

    </div>
</div>
