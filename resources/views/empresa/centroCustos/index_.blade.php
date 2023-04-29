<?php

use Illuminate\Support\Str;

?>
@section('title','Centro de custos')
<div>
    <div class="row">
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                CENTROS DE CUSTO
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

                                <input type="text" wire:model="search" autofocus class="form-control search-query" placeholder="Buscar por nome, email, nif, telefone" />
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
                                <a href="{{ route('centroCusto.create') }}" title="emitir novo recibo" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                    <i class="fa icofont-plus-circle"></i> CENTROS DE CUSTO
                                </a>
                                <a title="imprimir centro de custo" href="#" wire:click.prevent="imprimirCentroCusto" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                    <span wire:loading wire:target="imprimirCentroCusto" class="loading"></span>
                                    <i class="fa fa-print text-default"></i> Imprimir
                                </a>

                                <div class="pull-right tableTools-container"></div>
                            </div>
                            <div class="table-header widget-header">
                                Todos os centros de custo do sistema
                            </div>

                            <!-- div.dataTables_borderWrap -->
                            <div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>E-mail</th>
                                            <th>NIF</th>
                                            <th>Telefone</th>
                                            <th>Endereco</th>
                                            <th style="text-align: center">Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($centrosCusto as $centroCusto)
                                        <tr>
                                            <td>{{ Str::upper($centroCusto->nome) }}</td>
                                            <td>{{ $centroCusto->email }}</td>
                                            <td>{{ $centroCusto->nif }}</td>
                                            <td>{{ $centroCusto->telefone }}</td>
                                            <td>{{ $centroCusto->endereco }}</td>
                                            <td style="text-align: center">
                                                <span class="label label-sm <?= $centroCusto->status_id == 1 ? 'label-success' : 'label-warning' ?>" style="border-radius: 20px;">{{ $centroCusto->statu->designacao }}</span>
                                            </td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a href="{{ route('centroCusto.update', $centroCusto->uuid) }}" class="pink" title="Editar este registo">
                                                        <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    <div>{{ $centrosCusto->links()}}</div>
                </div>
            </div>
        </div>
    </div>

</div>
