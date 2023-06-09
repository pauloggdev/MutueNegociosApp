@section('title','Empresas')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            EMPRESAS
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

                            <a title="Lista de bancos" wire:click.prevent="imprimirClientes" class="btn btn-primary widget-box widget-color-blue url" id="botoes">
                                <i class="fa fa-print text-default"></i> Imprimir
                                <span wire:loading wire:target="imprimirClientes" class="loading">
                                    <i class="ace-icon fa fa-print bigger-160"></i>
                                </span>
                            </a>

                            <div class="pull-right tableTools-container"></div>
                        </div>
                        <div class="table-header widget-header">
                            Todos clientes do sistema
                        </div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>Tipo empresa</th>
                                        <th>Regime</th>
                                        <th>NIF</th>
                                        <th>Telefone</th>
                                        <th>E-mail</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($clientes as $cliente)
                                    <tr>
                                        <td>{{$cliente->id}}</td>
                                        <td>{{Str::upper($cliente->nome)}}</td>
                                        <td>{{$cliente->tipocliente->designacao}}</td>
                                        <td>{{$cliente->tiporegime->Designacao}}</td>
                                        <td>{{$cliente->nif}}</td>
                                        <td>{{$cliente->pessoal_Contacto}}</td>
                                        <td>{{$cliente->email}}</td>
                                        <td>
                                            <a href="{{ route('admin.clientes.detalhes', $cliente->id) }}" class="pink"><i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i></a>
                                            @if($cliente->venda_online == 'Y')
                                            <a wire:click="modalDesactivarVendaOnline({{ $cliente }})" style="cursor: pointer" class="pink">
                                                <i class="ace-icon fa fa-check bigger-150 bolder sucess text-success"></i>
                                            </a>
                                            @else
                                            <a wire:click="modalAtivarVendaOnline({{ $cliente }})" style="cursor: pointer" class="pink">
                                                <i class="ace-icon fa fa-remove bigger-150 bolder danger text-danger"></i>
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
                {{$clientes->links()}}
            </div>
        </div>
    </div>
</div>
