<?php

use Illuminate\Support\Str;
?>
@section('title','Extrado do cliente')
<div>
    <div class="row">
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                EXTRATO DO CLIENTE : <?= Str::upper($cliente->nome) ?>
            </h1>
        </div>

        <div class="col-md-12">
            <div class>
                <form class="form-search" method="get" action>
                    <div class="row">
                        <div class>
                            <div>
                                <div class="form-group has-info">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="control-label bold label-select2" for="dataInicio">Escolha a data Inferior<b class="red fa fa-question-circle"></b></label>
                                            <div>
                                                <input type="date" lang="pt" wire:model="saft.dataInicio" id="dataInicio" class="col-md-12 col-xs-12 col-sm-4" style="height:35px;<?= $errors->has('saft.dataInicio') ? 'border-color: #ff9292;' : '' ?>" />
                                            </div>
                                            @if ($errors->has('saft.dataInicio'))
                                            <span class="help-block" style="color: red; font-weight: bold">
                                                <strong>{{ $errors->first('saft.dataInicio') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label bold label-select2" for="dataFim">Escolha a data Superior<b class="red fa fa-question-circle"></b></label>
                                            <div>
                                                <input type="date" wire:model="saft.dataFinal" id="dataFim" class="col-md-12 col-xs-12 col-sm-4" style="height:35px;<?= $errors->has('saft.dataFinal') ? 'border-color: #ff9292;' : '' ?>" />
                                            </div>
                                            @if ($errors->has('saft.dataFinal'))
                                            <span class="help-block" style="color: red; font-weight: bold">
                                                <strong>{{ $errors->first('saft.dataFinal') }}</strong>
                                            </span>
                                            @endif
                                        </div>

                                    </div>
                                </div>



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

                                <a title="imprimir clientes" href="#" wire:click.prevent="imprimirExtratoCliente" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                    <span wire:loading wire:target="imprimirExtratoCliente" class="loading"></span>
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
                                            <th>Nº documento</th>
                                            <th>Tipo documento</th>
                                            <th>Valor Total</th>
                                            <th>Data emissão</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>


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
