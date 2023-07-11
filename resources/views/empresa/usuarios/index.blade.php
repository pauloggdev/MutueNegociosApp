@section('title','Usuários')
<div>

    <div class="modal fade" id="enviarComprovativo" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i>COMPROVATIVO DE PAGAMENTO DA FATURA
                    </h4>

                </div>

                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">

                        <div class="col-md-12">
                            <form class="filter-form form-horizontal validation-form">
                                <div class="second-row">
                                    <div class="tabbable">
                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_motivo" class="tab-pane in active">
                                                <div class="form-group has-info">
                                                    <div class="col-md-12">
                                                        <label class="control-label bold label-select2" for="numero_operacao_bancaria">Número de operação bancária<b class="red fa fa-question-circle"></b></label>
                                                        <div>
                                                            <input type="text" autofocus wire:model="numero_operacao_bancaria" id="numero_operacao_bancaria" class="col-md-12 col-xs-12 col-sm-4" style="height: 35px; font-size: 10pt;<?= $errors->has('numero_operacao_bancaria') ? 'border-color: #ff9292;' : '' ?>" />
                                                        </div>
                                                        @if ($errors->has('numero_operacao_bancaria'))
                                                        <span class="help-block" style="color: red; font-weight: bold;top: 67px;">
                                                            <strong>{{ $errors->first('numero_operacao_bancaria') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>


                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-12">
                                                        <label class="control-label bold label-select2" for="comprovativoPgtFactura">Comprovativo bancário<b class="red fa fa-question-circle"></b></label>
                                                        <div>
                                                            <input type="file" wire:model="comprovativoPgtFactura" class="form-control" id="nomeUtilizador" style="height: 35px; font-size: 10pt;<?= $errors->has('comprovativoPgtFactura') ? 'border-color: #ff9292;' : '' ?>" />
                                                        </div>
                                                        @if ($errors->has('comprovativoPgtFactura'))
                                                    <span class="help-block" style="color: red; font-weight: bold">
                                                        <strong>{{ $errors->first('comprovativoPgtFactura') }}</strong>
                                                    </span>
                                                    @endif
                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-9" style="display: flex;justify-content: center;width:100%;">
                                                <button class="search-btn" style="border-radius: 10px" wire:click.prevent="enviarComprovativo">

                                                    <span wire:loading.remove wire:target="enviarComprovativo">
                                                        ENVIAR COMPROVATIVO
                                                    </span>
                                                    <span wire:loading wire:target="enviarComprovativo">
                                                        <span class="loading"></span>
                                                        Aguarde...</span>



                                                </button>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CRIAR INVENTARIO -->
    <div id="enviarComprovativo1" class="modal fade" wire:ignore>
        <div class="modal-dialog modal-lg" style="left: 6%; position: relative">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Comprovativo de pagamento da factura 02
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <form enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id>
                            <div class="second-row" style="display: flex;justify-content: center;">

                                <div class="col-md-12">
                                    <input type="file" wire:model="comprovativoPgtFactura" class="form-control" id="nomeUtilizador" style="height: 35px; font-size: 10pt;<?= $errors->has('user.name') ? 'border-color: #ff9292;' : '' ?>" />
                                </div>
                                @if ($errors->has('comprovativoPgtFactura'))
                                <span class="help-block" style="    color: red; position: absolute; margin-top: -2px;font-size: 12px;">
                                    <strong>{{ $errors->first('comprovativoPgtFactura') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="numero_operacao_bancaria">Numero operação bancária</label>
                                    <input type="text" wire:model="numero_operacao_bancaria" class="form-control" id="numero_operacao_bancaria" style="height: 35px; font-size: 10pt;<?= $errors->has('numero_operacao_bancaria') ? 'border-color: #ff9292;' : '' ?>" />
                                </div>
                            </div>
                            <div class="clearfix form-actions">
                                <div class="col-md-offset-3 col-md-9">
                                    <button class="search-btn" style="border-radius: 10px;
    padding-left: 80px;
    padding-right: 80px;
    padding-top: 15px;
    padding-bottom: 15px;
    font-size: 18px;
    background: #214565;
    color: white;" wire:click.prevent="enviarComprovativo">
                                        <i class="ace-icon fa fa-check bigger-110"></i>
                                        Enviar comprovativo
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                USUÁRIOS
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

                                <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar por nome, email do utilizador" />
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
                                <a href="{{ route('users.create') }}" title="emitir novo recibo" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                    <i class="fa icofont-plus-circle"></i> Novo utilizador
                                </a>
                                <a title="imprimir utilizadores" wire:click.prevent="imprimirUtilizadores" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                    <span wire:loading wire:target="imprimirUtilizadores" class="loading"></span>
                                    <i class="fa fa-print text-default"></i> Imprimir
                                </a>
                                <div class="pull-right tableTools-container"></div>
                            </div>
                            <div class="table-header widget-header">
                                Todos os utilizadores do sistema
                            </div>
                            <div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nº</th>
                                            <th>Nome do utilizador</th>
                                            <th>E-mail</th>
                                            <th>Telefone</th>
                                            <th>Data</th>
                                            <th style="text-align: center">Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->telefone }}</td>
                                            <td>{{ date_format($user->created_at,'d/m/Y') }}</td>
                                            <td class="hidden-480" style="text-align: center">
                                                <span class="label label-sm <?= $user['statuGeral']['id'] == 1 ? 'label-success' : 'label-warning' ?>" style="border-radius: 20px;">{{ $user['statuGeral']['designacao'] }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('users.edit', $user->uuid)}}" class="pink" title="Editar este registo">
                                                    <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                </a>
                                                <a href="{{ route('users.permissions', $user->uuid)}}" style="cursor:pointer;">
                                                    <i class="ace-icon fa fa-unlock bigger-150 bolder success text-danger"></i>
                                                </a>
                                                <a title="Eliminar este Registro" style="cursor:pointer;" wire:click="modalDel({{$user->id}})">
                                                    <i class="ace-icon fa fa-trash-o bigger-150 bolder danger red"></i>
                                                </a>
                                                @if($user->statusUserAdicional == 2)
                                                <a class="blue" wire:click="mostrarFactura({{$user->id}})" title="Facturas para activação do utilizador" style="cursor: pointer">
                                                    <i class="ace-icon fa fa-print bigger-160"></i>
                                                    <span wire:loading wire:target="mostrarFactura({{$user->id}})" class="loading">
                                                        <i class="ace-icon fa fa-print bigger-160"></i>
                                                    </span>
                                                </a>
                                                <a title="Enviar o comprovativo de pagamento da factura de adição de utilizador" wire:click="modalComprovativo({{$user->id}})" style="cursor:pointer;" href="#enviarComprovativo" data-toggle="modal">
                                                    <i class="ace-icon fa fa-send-o bigger-150 bolder blue"></i>
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{$users->links()}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
