<?php

use Illuminate\Support\Str;
?>
@section('title','Minhas licenças')
<div>
    <div class="row">
        <div class="page-header">
            <h1>
                MINNAS LICENÇAS
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

                                <input type="text" wire:model="search" autofocus class="form-control search-query" placeholder="Buscar..." />
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
                                Todas minhas licenças do sistema
                            </div>

                            <!-- div.dataTables_borderWrap -->
                            <div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Licença</th>
                                            <th>Data activação</th>
                                            <th>Data inicio</th>
                                            <th>Data fim</th>
                                            <th style="text-align: center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($licencas as $lc)
                                        <tr>
                                            <td>{{ $lc->id }}</td>
                                            <td>{{ Str::upper($lc->licenca->designacao)}}</td>
                                            <td>{{ $lc->data_activacao?date_format(date_create($lc->data_activacao),"d/m/Y"):''}}</td>
                                            <td>{{ $lc->data_inicio?date_format(date_create($lc->data_inicio),"d/m/Y"):''}}</td>
                                            <td>{{ $lc->data_fim?date_format(date_create($lc->data_fim),"d/m/Y"):''}}</td>
                                            <td style="text-align: center">
                                                <span class="label label-sm <?= $lc->status_licenca_id == 1 ? 'label-success' : ($lc->status_licenca_id == 2 ? 'label-danger' : 'label-warning') ?>" style="border-radius: 20px;">{{ $lc->statusLicenca->designacao }}</span>
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
