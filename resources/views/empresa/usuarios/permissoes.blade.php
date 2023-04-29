@section('title','Permissões')
<div class="row">
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            {{ Str::upper($user->name)}}
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

                            <input type="text" wire:model="search" autofocus autocomplete="on" class="form-control search-query" placeholder="Buscar por permissão" />
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
                            Todos permissão do sistema
                        </div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nº</th>
                                        <th>Permissão</th>
                                        <th style="text-align: center">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($permissoes as $key=> $permissao)
                                    <tr>
                                        <td>{{$permissao->id}}</td>
                                        <td>{{ Str::upper($permissao->name)}}</td>
                                        <td style="text-align: center">
                                            <label class="pos-rel">
                                                <input type="checkbox" wire:model="selectedPermissoes" value="{{$permissao->id}}" wire:click="checkPermissaoPorUsuario({{$permissao->id}})" value="{{$permissao['id']}}" @if(in_array($permissao['id'],$selectedPermissoes )) checked @endif class="ace" />
                                                <span class="lbl"></span>
                                            </label>
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
