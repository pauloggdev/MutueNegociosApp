@section('title','Vendas-mensal')

<div>
    <div class="row">
        <!-- VER DETALHES  -->
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                VENDAS MENSAL
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    LISTAGEM
                </small>
            </h1>
        </div>
        <div class="row" style="margin-bottom: 20px">
            <div class="col-md-6">
                <label class="control-label bold label-select2" for="dataInicio"><strong>Mês inicio</strong></label>
                <div>
                    <input type="month" lang="pt" wire:model="dataInicio" id="dataInicio" class="col-md-12 col-xs-12 col-sm-4" style="height:35px;" />
                </div>
            </div>
            <div class="col-md-6">
                <label class="control-label bold label-select2" for="dataFim"><strong>Mês final</strong></label>
                <div>
                    <input type="month" wire:model="dataFinal" id="dataFim" class="col-md-12 col-xs-12 col-sm-4" style="height:35px;" />
                </div>

            </div>
        </div>
        <div class="col-md-12">


            <div class>
                <div class="row">
                    <form id="adimitirCandidatos" method="POST" action>
                        <input type="hidden" name="_token" value />

                        <div class="col-xs-12 widget-box widget-color-green" style="left: 0%">
                            <div class="clearfix">

                                <div class="pull-right tableTools-container"></div>
                            </div>
                            <div class="table-header widget-header">
                                Todas as vendas mensal do sistema
                            </div>

                            <!-- div.dataTables_borderWrap -->
                            <div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="text-align: right">Total Factura</th>
                                            <th style="text-align: right">Total Desconto</th>
                                            <th style="text-align: right">Total IVA</th>
                                            <th style="text-align: right">Total Troco</th>
                                            <th style="text-align: right">Total Entregue</th>
                                            <th style="text-align: right">Mês/Ano</th>
                                            <th style="text-align: center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($vendas as $venda)
                                        <tr>
                                            <td style="text-align: right">{{ number_format($venda->total_factura,2,",",".") }}</td>
                                            <td style="text-align: right">{{ number_format($venda->total_desconto,2,",",".") }}</td>
                                            <td style="text-align: right">{{ number_format($venda->total_iva,2,",",".") }}</td>
                                            <td style="text-align: right">{{ number_format($venda->total_troco,2,",",".") }}</td>
                                            <td style="text-align: right">{{ number_format($venda->total_entregue,2,",",".") }}</td>
                                            <td style="text-align: right">{{ date_format(date_create($venda->data_criada), 'm/Y') }}</td>
                                            <td style="text-align: center">
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a class="blue" style="cursor: pointer" wire:click.prevent="printVendaMensal({{ json_encode($venda) }})">
                                                    <i class="fa fa-print bigger-150 text-default"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                        <span wire:loading wire:target="printVendaMensal" class="loading"></span>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    <div>{{ $vendas->links()}}</div>
                </div>
            </div>
        </div>
    </div>

</div>
