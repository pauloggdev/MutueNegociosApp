@section('title','Utiizadores')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            UTILIZADORES
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

                            <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar pelo nome, email, telefone" />
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
                            <a href="{{ route('admin.users.create') }}" title="emitir novo recibo" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa icofont-plus-circle"></i> Novo utilizadores
                            </a>
                            <a title="Lista de bancos" wire:click.prevent="imprimirUtilizadores" target="blank" class="btn btn-primary widget-box widget-color-blue url" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                                <span wire:loading wire:target="imprimirUtilizadores" class="loading">
                                    <i class="ace-icon fa fa-print bigger-160"></i>
                                </span>
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
                                        <th>Nome</th>
                                        <th>E-mail</th>
                                        <th>Telefone</th>
                                        <th style="text-align: center">Estado</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{ Str::upper($user->name) }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->telefone }}</td>
                                        <td style="text-align: center">
                                            <span class="label label-sm <?= $user->status_id == 1 ? 'label-success' : 'label-danger' ?>">{{$user->statuGeral->designacao}}</span>
                                        </td>
                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a class="pink" href="{{ route('admin.users.edit', $user->id) }}" title="Editar" style="cursor: pointer;">
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

                {{$users->links()}}
            </div>

        </div>

    </div>
</div>