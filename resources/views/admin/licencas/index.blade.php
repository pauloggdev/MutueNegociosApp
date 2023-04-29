@section('title','Licenças')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            LICENÇAS
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

                            <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar pelo nome" />
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

                            <a title="Lista de bancos" wire:click.prevent="imprimirLicencas" class="btn btn-primary widget-box widget-color-blue url" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                                <span wire:loading wire:target="imprimirLicencas" class="loading">
                                    <i class="ace-icon fa fa-print bigger-160"></i>
                                </span>
                            </a>

                            <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="table-header widget-header">
                            Todas licenças do sistema
                        </div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Licenças</th>
                                        <th style="text-align: right">Valor</th>
                                        <th>Descrição</th>
                                        <th style="text-align: right">Limite utilizador</th>
                                        <th style="text-align: center">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($licencas as $licenca)
                                    <tr>
                                        <td>{{ Str::upper($licenca->designacao)}}</td>
                                        <td style="text-align: right">{{ number_format($licenca->valor,2,',','.') }}</td>
                                        <td>{{ $licenca->descricao }}</td>
                                        <td style="text-align: right">{{ number_format($licenca->limite_usuario,1,',','.') }}</td>
                                        <td style="text-align: center">
                                            <span class="label label-sm <?= $licenca->status_licenca_id == 1 ? 'label-success' : 'label-danger' ?>">{{$licenca->statuGeral->designacao}}</span>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
                {{$licencas->links()}}
            </div>
        </div>
    </div>
</div>