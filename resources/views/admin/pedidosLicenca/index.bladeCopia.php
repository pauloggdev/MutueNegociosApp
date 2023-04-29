@extends('layout.appAdmin')
@section('title','Pedido - Licença')
@section('content')

    <section class="content">
        <div class="row">

            <div class="space-6"></div>
            <div class="page-header" style="left: 0.5%; position: relative">
                <h1>
                    Pedido de licenças
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Listagem
                    </small>
                </h1>
            </div><!-- /.page-header -->

            @if (Session::has('success'))
                <div class="alert alert-success alert-success col-xs-12" style="left: 0%;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fa fa-check-square-o bigger-150"></i>{{ Session::get('success') }}</h5>
                </div>
            @endif

            @if (Session::has('errors'))
                <div class="alert alert-danger alert-danger col-xs-12" style="left: 0%;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <i class="icon fa fa-exclamation-triangle bigger-150"> Ups!!</i><br/>
                    <h5>
                        @foreach($errors->all() as $erro)
                            <span style="left: 2.5%; position: relative">{{$erro}}<br/></span>
                        @endforeach
                    </h5>
                </div>
            @endif

            <div class="col-xs-12">
                <div class="">
                    <div class="row" >
                        <form id="adimitirCandidatos" method = 'POST' action =''>
                            <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>

                            <div class="col-xs-12 widget-box widget-color-green"  style="left: 0%;">
                                <div class="table-header widget-header">
                                    Todos Pedidos de Licenca
                                </div>

                                <!-- div.dataTables_borderWrap -->
                                <div>
                                    <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">

                                        <thead>
                                        <tr>
                                            <th class="center">
                                                <label class="pos-rel">
                                                    <input type="checkbox" class="ace" />
                                                    <span class="lbl"></span>
                                                </label>
                                            </th>
                                            <th>Empresa</th>
                                            <th>Licença</th>
                                            <th>Tipo de Licença</th>
                                            <th>Status</th>
                                            <th>Opções</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($ativacaoLicencas as $pedido)
                                            <tr>
                                                <td class="center">
                                                    <label class="pos-rel ">
                                                        <input type="checkbox" class="ace " />
                                                        <span class="lbl"></span>
                                                    </label>
                                                </td>

                                                <td>{{$pedido->empresa->nome}}</td>
                                                <td>{{$pedido->licenca->licenca}}</td>
                                                <td>{{$pedido->licenca->tipoLicenca->designacao}}</td>


                                                <td class="hidden-480" style="text-align: center">
                                                @if(isset($pedido->statusLicenca->id))
                                                    @if($pedido->statusLicenca->id == 6)
                                                        <span class="label label-sm label-success" style="border-radius: 20px;">{{$pedido->statusLicenca->designacao}}</span>
                                                    @elseif($pedido->statusLicenca->id == 8)
                                                        <span class="label label-sm label-warning" style="border-radius: 20px;">{{$pedido->statusLicenca->designacao}}</span>
                                                    @else
                                                        <span class="label label-sm label-danger" style="border-radius: 20px;">{{$pedido->statusLicenca->designacao}}</span>
                                                    @endif
                                                @endif
                                                </td>
                                                <td>
                                                    <div class="hidden-sm hidden-xs action-buttons">
                                                        <a class="" href='{{ url('admin/pedido-licencas/detalhes/')}}/{{base64_encode($pedido->id)}}' class="pink" title="Ver mais informações">
                                                            <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                        </a>
                                                    </div>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{$ativacaoLicencas->render()}}
                                </div>
                            </div><!-- /.col-xs-12 -->
                        </form>
                    </div>
                </div>
            </div><!-- /.col -->
    </section>
@endsection
