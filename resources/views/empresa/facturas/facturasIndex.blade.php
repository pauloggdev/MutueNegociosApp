@section('title','Facturas')
<div>
    <div class="row">
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                FACTURAS
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
                                <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar pela numeração da factura, nome do cliente" />
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
                                <div class="pull-right tableTools-container"></div>
                            </div>
                            <div class="table-header widget-header">
                                Todas as facturas do sistema
                            </div>
                            <div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Numeração</th>
                                            <th>Tipo Documento</th>
                                            <th style="text-align: right">Total Factura</th>
                                            <th style="text-align: right">Valor a Pagar</th>
                                            <th>Emitido</th>
                                            <th>Cliente</th>
                                            <th>Tel.</th>
                                            <th style="text-align: center">Anulado</th>
                                            <th style="text-align: center">Retificado</th>
                                            <th>Pago</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($facturas as $factura)
                                    <tr>
                                        <td>{{$factura['id']}}</td>
                                        <td>{{$factura['numeracaoFactura']}}</td>
                                        <td>{{$factura['tipoDocumento']['designacao']}}</td>
                                        <td style="text-align: right">{{number_format($factura['total_preco_factura'],2,',','.')}}</td>
                                        <td style="text-align: right">{{number_format($factura['valor_a_pagar'],2,',','.')}}</td>
                                        <td>{{date_format($factura['created_at'],'d/m/Y')}}</td>
                                        <td>{{$factura['nome_do_cliente']}}</td>
                                        <td>{{$factura['telefone_cliente']}}</td>
                                        <td class="hidden-480" style="text-align: center">
                                            <span class="label label-sm <?= $factura['anulado'] == 1 ? 'label-success' : 'label-danger' ?>">{{ $factura['anulado'] == 1 ? "Não" : "Sim" }}</span>
                                        </td>
                                        <td class="hidden-480" style="text-align: center">
                                            <span class="label label-sm <?= $factura['retificado'] == 'Não' ? 'label-success' : 'label-danger' ?>">{{ $factura['retificado']}}</span>
                                        </td>
                                        <td class="hidden-480" style="text-align: center">
                                            <span class="label label-sm <?= $factura['statusFactura'] == 1 ? 'label-danger' : 'label-success' ?>">{{ $factura['statusFactura'] == 1 ? "Não" : "Sim" }}</span>
                                        </td>
                                        <td>
                                            <a class="blue" wire:click="imprimirFactura({{$factura['id']}})" title="Reimprimir o factura" style="cursor: pointer">
                                                <i class="ace-icon fa fa-print bigger-160"></i>
                                                <span wire:loading wire:target="imprimirFactura({{$factura['id']}})" class="loading">
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
                    {{$facturas->links()}}
                </div>

            </div>
        </div>
    </div>

</div>
