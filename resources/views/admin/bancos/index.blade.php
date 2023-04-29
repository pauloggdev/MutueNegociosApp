@section('title','Bancos')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            BANCOS
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

                            <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar pelo nome, sigla" />
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
                            <a href="{{ route('admin.bancos.create') }}" title="emitir novo recibo" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa icofont-plus-circle"></i> Novo banco
                            </a>
                            <a title="Lista de bancos" wire:click.prevent="imprimirBancos" href="" target="blank" class="btn btn-primary widget-box widget-color-blue url" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                                <span wire:loading wire:target="imprimirBancos" class="loading">
                                    <i class="ace-icon fa fa-print bigger-160"></i>
                                </span>
                            </a>

                            <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="table-header widget-header">
                            Todos bancos do sistema
                        </div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Sigla</th>
                                        <th>Nº Conta</th>
                                        <th>IBAN</th>
                                        <th style="text-align: center">Estado</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bancos as $banco)
                                    <tr>
                                        <td>{{Str::upper($banco->designacao)}}</td>
                                        <td>{{$banco->sigla}}</td>
                                        <td>{{$banco->coordernadaBancaria->num_conta}}</td>
                                        <td>{{$banco->coordernadaBancaria->iban}}</td>
                                        <td style="text-align: center">
                                            <span class="label label-sm <?= $banco->status_id == 1 ? 'label-success' : 'label-danger' ?>">{{$banco->statuGeral->designacao}}</span>
                                        </td>
                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a class="pink" href="{{ route('admin.bancos.edit', $banco->uuid) }}" title="Editar" style="cursor: pointer;">
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
                {{$bancos->links()}}
            </div>
        </div>
    </div>
</div>