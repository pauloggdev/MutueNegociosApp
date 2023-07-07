@section('title','taxa iva')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            TAXAS
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

                            <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar pela taxa" />
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
                            <a href="{{ route('admin.taxas.create') }}" title="emitir novo recibo" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                <i class="fa icofont-plus-circle"></i> Nova taxa
                            </a>
                            <!-- <a title="Lista de bancos" href="" target="blank" class="btn btn-primary widget-box widget-color-blue url" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                            </a> -->

                            <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="table-header widget-header">
                            Todas taxas do sistema
                        </div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="text-align: center">Taxa</th>
                                        <th>Descricao</th>
                                        <th style="text-align: center">Estado</th>
                                        <th style="text-align: center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($taxaIvas as $key=> $taxa)
                                    <tr>
                                        <td>{{ $key+1}}</td>
                                        <td style="text-align: center">{{ $taxa->taxa}} %</td>
                                        <td>{{ $taxa->descricao}}</td>
                                        <td style="text-align: center">
                                            <span class="label label-sm <?= $taxa->codigostatus == 1 ? 'label-success' : 'label-danger' ?>">{{$taxa->statuGeral->designacao}}</span>
                                        </td>
                                        <td style="text-align: center">
                                            <a title="Editar este registo" href="{{ route('admin.taxas.edit', $taxa->codigo) }}" class="pink" style="cursor: pointer;">
                                                <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                            </a>
                                            <span  wire:click.prevent="modalDel({{$taxa->codigo}})" style="cursor: pointer;"><i class="ace-icon fa fa-trash-o bigger-150 bolder danger red"></i></span>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
                {{$taxaIvas->links()}}
            </div>
        </div>
    </div>
</div>
