<?php

use Illuminate\Support\Str;
?>

@section('title','Pedidos licenças')
<div class="row">

    <div id="visualizarComprovativo" class="modal fade" wire:ignore>
        <div class="modal-dialog modal-lg" style="display: flex;justify-content: center">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller"><i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> COMPROVATIVO ANEXADO</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">
                        <img id="imgComprovativo" src="" alt="comprovativo anexado">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modalRejeicaoActivacaoUtilizador" class="modal fade" wire:ignore>
        <div class="modal-dialog modal-lg" style="display: flex;justify-content: center">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller"><i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> MOTIVO DA REJEIÇÃO DA ATIVAÇÃO DO UTILIZADOR</h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">
                        <div class="input-group input-group-sm" style="margin-bottom: 10px;">
                            <textarea type="text" wire:model="motivo" class="form-control" style="width: 500px; height: 200px;<?= $errors->has('motivo') ? 'border-color: #ff9292;' : '' ?>"></textarea>
                        </div>
                        @if ($errors->has('motivo'))
                        <span class="help-block" style="    color: red;
    position: absolute;
    margin-top: -2px;
    font-size: 12px;">
                            <strong>{{ $errors->first('motivo') }}</strong>
                        </span>
                        @endif
                        <div style="display: flex;justify-content: center">
                            <a title="enviar o motivo" wire:click="enviarMotivoRejeicaoActivacaoUtilizador" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                ENVIAR O MOTIVO
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            PEDIDOS ACTIVAÇÃO UTILIZADOR
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

                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group input-group-sm" style="margin-bottom: 10px;">

                                    <input type="text" autofocus wire:model.debounce.350ms="search" id="search" autocomplete="on" class="form-control search-query" placeholder="Buscar por nome" />
                                    <span class="input-group-addon">
                                        <i class="ace-icon fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="table-header widget-header" style="color:white">
                            Todos pedidos de ativação do utilizador
                        </div>
                        <div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th style="text-align:center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($comprovativos as $comprovativo)
                                    <tr>
                                        <td>Comprovativo para activação do utilizador: <strong>{{ Str::upper($comprovativo->factura->nome_utilizador_adicionado)}}</strong></td>
                                        <td style="text-align:center">
                                            <a class="pink" title="Imprimir a factura a pagar" wire:click="imprimirFactura({{$comprovativo}})" style="cursor: pointer;">
                                                <i class="ace-icon fa fa-print bigger-150 bolder" style="color: blue"></i>
                                                <span wire:loading wire:target="imprimirFactura({{$comprovativo}})" class="loading">
                                                    <i class="ace-icon fa fa-print bigger-150 bolder" style="color: blue"></i>
                                                </span>
                                            </a>
                                            <a class="pink" title="visualizar dado da empresa" href="#visualizarComprovativo" data-toggle="modal" wire:click="visualizarComprovativo({{$comprovativo}})" style="cursor: pointer;">
                                                <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                            </a>
                                            @if($comprovativo->status_id != 3)
                                            <a class="pink" title="Rejeitar pedido de activação utilizador" href="#modalRejeicaoActivacaoUtilizador" data-toggle="modal" wire:click="modalRejeicaoActivacaoUtilizador({{$comprovativo}})" style="cursor: pointer;">
                                                <i class="ace-icon fa fa-remove bigger-150 bolder danger text-danger"></i>
                                            </a>
                                            @endif

                                            @if($comprovativo->status_id == 3)
                                            <a class="pink" title="Aceitar pedido de activação de utilizador" wire:click="modalActivarUtilizador({{$comprovativo}})" style="cursor: pointer;">
                                                <i class="ace-icon fa fa-check bigger-150 bolder sucess text-success"></i>
                                            </a>
                                            @endif
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

<style>
    .modal.fade:not(.show) {
        opacity: 0;
        transition: opacity 10s ease-out;
        background-color: rgba(0, 0, 0, 0);
        /* Cambia el valor de los colores RGB para cambiar el color de fondo */
    }

    .modal.fade.show {
        opacity: 1;
        transition: opacity 10s ease-in;
    }
</style>
