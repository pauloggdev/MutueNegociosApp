@section('title','Modelo Documento')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            MODELOS DE DOCUMENTOS
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

                            <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar por nome do documento" />
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
                            Todos modelos do documentos
                        </div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nº</th>
                                        <th>Nome documento</th>
                                        <th style="text-align: center">Status</th>
                                        <th style="width: 150px">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modeloDocumentos as $key=> $modelo)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ Str::upper($modelo->designacao) }}</td>
                                        <td style="text-align: center">
                                            <span class="label label-sm <?= $modelo->modeloDocumentoAtivo->empresa_id == auth()->user()->empresa_id ? 'label-success' : 'label-danger' ?>"><?= $modelo->modeloDocumentoAtivo->empresa_id == auth()->user()->empresa_id ? "Sim" : "Não" ?></span>
                                        </td>
                                        <td style="display: flex;width: 150px;align-items: center">
                                            <a class="blue" wire:click="visualizarDocumento({{$modelo}})" title="Visualizar o modelo" style="cursor: pointer">
                                                <i class="ace-icon fa fa-print bigger-160"></i>
                                                <span wire:loading wire:target="visualizarDocumento({{$modelo}})" class="loading">
                                                    <i class="ace-icon fa fa-print bigger-160"></i>
                                                </span>
                                            </a>
                                            <input style="width: 50px;cursor: pointer;" <?= $modelo->modeloDocumentoAtivo->empresa_id == auth()->user()->empresa_id ? 'checked' : '' ?> type="checkbox" wire:click="selecionarModelo({{$modelo}})" class="form-control"/>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
                {{$modeloDocumentos->links()}}
            </div>
        </div>
    </div>
</div>