@section('title','Fornecedores')

<div>
    <div class="row">
        <!-- VER DETALHES  -->
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Fornecedores
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

                                <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar por nome do cliente, nif, telefone, conta corrente" />
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
                                <a href="{{ route('fornecedores.create') }}" title="cadastrar novo fornecedor" class="btn btn-success widget-box widget-color-blue" id="botoes">
                                    <i class="fa icofont-plus-circle"></i> Novo Fornecedor
                                </a>

                                <a title="Imprimir Fornecedor" wire:click.prevent="imprimirFornecedor" class="btn btn-primary widget-box widget-color-blue" id="botoes">
                                    <span wire:loading wire:target="imprimirFornecedor" class="loading"></span>
                                    <i class="fa fa-print text-default"></i> Imprimir
                                </a>
                                <div class="pull-right tableTools-container"></div>
                            </div>
                            <div class="table-header widget-header">
                                Todos os Fornecedores do sistema
                            </div>

                            <!-- div.dataTables_borderWrap -->
                            <div>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>E-mail</th>
                                            <th>NIF</th>
                                            <th>web site</th>
                                            <th>Endereço</th>
                                            <th>Telefone</th>
                                            <th>E-mail de Contacto</th>
                                            <th>Conta corrente</th>
                                            <th style="text-align: center">Status</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($fornecedores as $fornecedor)
                                        <tr>
                                            <td>{{$fornecedor['nome']}}</td>
                                            <td>{{$fornecedor['email_empresa']}}</td>
                                            <td>{{$fornecedor['nif']}}</td>
                                            <td>{{$fornecedor['website']}}</td>
                                            <td>{{$fornecedor['endereco']}}</td>
                                            <td>{{$fornecedor['telefone_empresa']}}</td>
                                            <td>{{$fornecedor['email_contacto']}}</td>
                                            <td>{{$fornecedor['conta_corrente']}}</td>
                                            <td class="hidden-480" style="text-align: center">
                                                <span class="label label-sm <?= $fornecedor['statuGeral']['id'] == 1 ? 'label-success' : 'label-warning' ?>" style="border-radius: 20px;">{{$fornecedor['statuGeral']['designacao'] }}</span>
                                            </td>
                                            <td>
                                                @if($fornecedor->diversos != 1)
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a class="pink" title="Editar este registo">
                                                        <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                    </a>
                                                    <a href="{{ route('fornecedores.edit', $fornecedor->id) }}" class="pink" title="Editar este registo">
                                                        <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                    </a>
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                    {{$fornecedores->links()}}
                </div>
            </div>
        </div>
    </div>

</div>
