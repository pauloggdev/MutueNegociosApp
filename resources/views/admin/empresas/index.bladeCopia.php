@extends('layout.appAdmin')
@section('title','Listar Clientes')
@section('content')

    <section class="content">
        <div class="row">

            <div class="space-6"></div>
            <div class="page-header" style="left: 0.5%; position: relative">
                <h1>
                    CLIENTES
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
                
                <div class="nav-search minimized col-xs-12" style="left: 0%">
                <form class="form-search" method="get" action='{!!url("admin/cliente-empresa")!!}'>
                    <div class="row">
                        <div class="">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-search"></i>
                                </span>

                                <input type="text" name="query" required autocomplete="on" class="form-control search-query" placeholder="Buscar Por Empresas..."/>
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
             @for($i=1; $i<=5; $i++)<div class="space-6"><p><br/></p></div>@endfor
                
                <div class="">
                    <div class="row" >
                        <form id="adimitirCandidatos" method = 'POST' action =''>
                            <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>

                            <div class="col-xs-12 widget-box widget-color-green"  style="left: 0%;">
                                <div class="table-header widget-header">
                                    Todos os Clientes 
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
                                                <th>Referência</th>
                                                <th>Empresa</th>
                                                <th>Tipo</th>
                                                <th>NIF</th>
                                                <th>Telefone</th>
                                                <th>Email</th>
                                                <th>Situação</th>
                                                <th>Opções</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($empresas as $empresa)
                                            <tr>
                                                <td class="center">
                                                    <label class="pos-rel ">
                                                        <input type="checkbox" class="ace " />
                                                        <span class="lbl"></span>
                                                    </label>
                                                </td>
                                                
                                                <td>{{$empresa->referencia}}</td>
                                                <td>{{$empresa->nome}}</td>
                                                <td>{{$empresa->tipocliente->designacao}}</td>
                                                <td>{{$empresa->nif}}</td>
                                                <td>{{$empresa->pessoal_Contacto}}</td>
                                                <td>{{$empresa->email}}</td>
                                                
                                                <td class="hidden-480" style="text-align: center">
                                                    @if($empresa->statusgerais->designacao == 'Activo')
                                                        <span class="label label-sm label-success" style="border-radius: 20px;">{{$empresa->statusgerais->designacao}}</span>
                                                    @elseif($pedido->licenca->statuLicenca->designacao == 'Desactivo')
                                                        <span class="label label-sm label-danger" style="border-radius: 20px;">{{$empresa->statusgerais->designacao}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="hidden-sm hidden-xs action-buttons">
                                                        <a class="" href='{{ url('admin/cliente-empresa/detalhes/')}}/{{base64_encode($empresa->id)}}' class="pink" title="Ver mais informações">
                                                            <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                        </a>
                                                        
                                                        <a class="" data-toggle="modal" href="" data-target=".eliminar{{$empresa->id}}" title="Eliminar este Registro">
                                                            <i class="ace-icon fa fa-trash-o bigger-140 bolder danger red"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <!-- Moda eliminar -->
                                            <div class="modal fade width-100 eliminar{{$empresa->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-default">
                                                    <div class="modal-content">
                                                        <div class="widget-header modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="text-danger">×</span></button>
                                                            <h4 class="smaller"><i class="ace-icon fa fa-exclamation-triangle red"></i> Eliminar Utilizador</h4>
                                                        </div>
                                                        <div class="modal-body alert alert-danger bigger-110" >
                                                            <p class="bigger-110 center grey" style="color: orange;">
                                                                <i class="ace-icon fa fa-exclamation-triangle red bigger-110"></i>
                                                                <?php echo "Tem certeza que quer eliminar este Registro? " ?>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class=" btn btn-inverse btn-flat widget-color-blue1" data-dismiss="modal" style="border-radius: 10px">Cancelar</button>
                                                            <a href="{{url('admin/cliente-empresa')}}/{{$empresa->id}}/delete" class="bigger-10 btn btn-danger btn-flat widget-color-blue1" style="border-radius: 10px"> Eliminar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- MODAIS DE COMFIRMAÇÃO PARA ELIMINAR-->
                                            
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{$empresas->render()}}
                                </div>
                            </div><!-- /.col-xs-12 -->
                        </form>
                    </div>
                </div>
            </div><!-- /.col -->
    </section>
@endsection
