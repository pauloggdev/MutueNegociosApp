<?php
use Carbon\Carbon;

?>
@section('title','Cupons desconto')
<div>
    <div class="row">
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                CUPONS DE DESCONTO
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
                                <a href="{{ route('cupon.create') }}" title="emitir novo recibo" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                    <i class="fa icofont-plus-circle"></i> Gerar Cupon desconto
                                </a>
                                <a title="imprimir cupon" href="#" wire:click.prevent="imprimirCupon" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                    <span wire:loading wire:target="imprimirClientes" class="loading"></span>
                                    <i class="fa fa-print text-default"></i> Imprimir
                                </a>

                                <div class="pull-right tableTools-container"></div>
                            </div>
                            <div class="table-header widget-header">
                                Todos os cupons desconto do sistema
                            </div>

                            <!-- div.dataTables_borderWrap -->
                            <div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Código</th>
                                            <th>Desconto(%)</th>
                                            <th>Data expiração</th>
                                            <th style="text-align: center">Usado?</th>
                                            <th style="text-align: center">Expirado?</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cupons as $cupon)
                                        <tr>
                                            <td>{{$cupon['codigo']}}</td>
                                            <td>{{number_format($cupon['percentagem'],1,",",".")}} %</td>
                                            <td><?= date_format(date_create($cupon['data_expiracao']), 'd/m/Y H:i:s') ?></td>
                                            <td class="hidden-480" style="text-align: center">
                                                <span class="label label-sm <?= $cupon['used'] == 'N' ? 'label-success' : 'label-warning' ?>" style="border-radius: 20px;">{{ $cupon['used'] == 'N'?'Não':'Sim' }}</span>
                                            </td>
                                            <td class="hidden-480" style="text-align: center">
                                                <span class="label label-sm <?= $cupon['used'] == 'N' ? 'label-success' : 'label-warning' ?>" style="border-radius: 20px;">{{ $cupon['used'] == 'N'?'Não':'Sim' }}</span>
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