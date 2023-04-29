@extends('layout.appEmpresa')
@section('title','Listar Fornecedor')
@section('content')

<section class="content">
    <div class="row">

        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Fornecedor
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
                <form class="form-search" method="get" action='{!!url("admin/usuarios")!!}'>
                    <div class="row">
                        <div class="">
                            <div class="input-group input-group-sm">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-search"></i>
                                </span>

                                <input type="text" name="query" required autocomplete="on" class="form-control search-query" placeholder="Buscar Por fornecedor..."/>
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
                            <div class="clearfix">
                                <a href='#criar_fornecedor' data-toggle="modal" title="Adicionar novo fornecedor" class = 'btn btn-success widget-box widget-color-blue' id="botoes"><i class="fa fa-fornecedor-plus"></i> Novo fornecedor</a>
                                <div class="pull-right tableTools-container"></div>
                            </div>

                            <div class="table-header widget-header">
                                Todos fornecedor do Sistema
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
                                            <th>Nome do fornecedor</th>
                                            <th>Email</th>
                                            <th>Telefone</th>
                                            <th>status</th>
                                            <th>Opções</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($fornecedores as $fornecedor)
                                        <tr>
                                            <td class="center">
                                                <label class="pos-rel ">
                                                    <input type="checkbox" class="ace " />
                                                    <span class="lbl"></span>
                                                </label>
                                            </td>

                                            <td>{{$fornecedor->nome}}</td>
                                            <td>{{$fornecedor->email_empresa}}</td>
                                            <td>{{$fornecedor->telefone_contacto}}</td>

                                            <td class="hidden-480" style="text-align: center">
                                                @if($fornecedor->statuGeral->id == 1)
                                                    <span class="label label-sm label-success" style="border-radius: 20px;">{{$fornecedor->statuGeral->designacao}}</span>
                                                @else
                                                    <span class="label label-sm label-warning" style="border-radius: 20px;">{{$fornecedor->statuGeral->designacao}}</span>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a class="" href='{{ url('empresa/fornecedores/detalhes/')}}/{{base64_encode($fornecedor->id)}}' class="pink" title="Ver mais informações">
                                                        <i class="ace-icon fa fa-eye bigger-150 bolder success pink"></i>
                                                    </a>
                                                    <a class="" href='{{ url('empresa/fornecedores/editar/')}}/{{base64_encode($fornecedor->id)}}' class="pink" title="Editar este registo">
                                                        <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                    </a>
                                                    <a data-toggle="modal" data-target=".eliminar{{$fornecedor->id}}" title="Eliminar este Registro">
                                                        <i class="ace-icon fa fa-trash-o bigger-150 bolder danger red"></i>
                                                    </a>
                                                </div>

                                            </td>
                                        </tr>

                                        <!-- Moda eliminar -->
                                        <div class="modal fade width-100 eliminar{{$fornecedor->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-default">
                                                <div class="modal-content">
                                                    <div class="widget-header modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="text-danger">×</span></button>
                                                        <h4 class="smaller"><i class="ace-icon fa fa-exclamation-triangle red"></i> Eliminar fornecedor</h4>
                                                    </div>
                                                <div class="modal-body alert alert-danger bigger-110" >
                                                    <p class="bigger-110 center grey" style="color: orange;">
                                                        <i class="ace-icon fa fa-exclamation-triangle red bigger-110"></i>
                                                        <?php echo "Tem certeza que quer eliminar este registro? "?>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class=" btn btn-inverse btn-flat widget-color-blue1" data-dismiss="modal" style="border-radius: 10px">Cancelar</button>
                                                    <a href="{{url('empresa/fornecedores/deletar/')}}/{{$fornecedor->id}}" class="bigger-10 btn btn-danger btn-flat widget-color-blue1" style="border-radius: 10px"> Eliminar</a>
                                                </div>
                                                </div>
                                            </div>
                                        </div><!-- MODAIS DE COMFIRMAÇÃO PARA ELIMINAR-->
                                     @endforeach
                                    </tbody>
                                </table>
                                 {{$fornecedores->render()}}
                            </div>
                        </div><!-- /.col-xs-12 -->
                   </form>
                </div>
            </div>

           <!-- MODAL DE CRIAR fornecedores -->
           <div id="criar_fornecedor" class="modal fade criar_fornecedor">
            <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller"><i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar fornecedor</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="left: 0%; position: relative;">
                            <div class="col-md-12">
                                <div class="search-form-text">
                                    <div class="search-text">
                                        <i class="fa fa-pencil"></i>
                                        Dados do fornecedor
                                    </div>
                                </div>

                                <form method = 'POST' action='{!!url("/empresa/fornecedores/adicionar")!!}' enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                    {!! csrf_field() !!}
                                    <input type = 'hidden' name = 'remember_token' value = '{{Session::token()}}'>

                                    <div class="second-row">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_fornecedor">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados do Fornecedor
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_fornecedor" class="tab-pane in active" style="left: 4%; position: relative">
                                                    
                                                    <h4 class="header bolder smaller" style="color: #3d5476">Geral</h4>
                                                    <div class="form-group has-info has-info" style="left: 6%; position: relative">
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="nome">Nome<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                            <div class="">
                                                                <input type="text" name="nome" value="{{old('nome')}}" id="nome" required class="col-md-12 col-xs-12 col-sm-4" />
                                                                @if ($errors->has('nome'))
                                                                <span class="help-block" style="color: red; font-weight: ">
                                                                    <strong>{{ $errors->first('nome') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="tipo_cliente">País Nacionalidade<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                            <div class="">
                                                                <select name="pais_nacionalidade_id" class="col-md-12 col-xs-12 col-sm-4 select2" id="pais_nacionalidade" data-placeholder="Selecione o país" required="">
                                                                    @foreach($paises as $pais)
                                                                        <option value="{{$pais->id}}" {{(old('pais_nacionalidade_id')==$pais->id)? 'selected':''}}>{{$pais->designacao}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('pais_nacionalidade_id'))
                                                                <span class="help-block" style="color: red; font-weight: ">
                                                                    
                                                                    <strong>{{ $errors->first('data_contracto') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group has-info" style="left: 6%; position: relative">
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="nif">NIF<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                            <div class="">
                                                                <input type="text" name="nif" required id="nif" value="{{old('nif')}}" required class="col-md-12 col-xs-12  col-sm-4" />
                                                                @if ($errors->has('nif'))
                                                                <span class="help-block" style="color: red; font-weight: ">
                                                                    <strong>{{ $errors->first('nif') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="status_id">Status<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                            <div class="">
                                                                <select name="status_id" style="height: 34px" class="col-md-12 col-xs-12  col-sm-4 select2" data-placeholder="Selecione o status" id="status_id">
                                                                    <option value=""></option>
                                                                    @foreach($status as $statu)
                                                                        <option value="{{$statu->id}}" {{(old('status_id')==$statu->id)? 'selected':''}}>{{$statu->designacao}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('status_id'))
                                                                <span class="help-block" style="color: red; font-weight:">
                                                                    
                                                                    <strong>{{ $errors->first('status_id') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group has-info" style="left: 6%; position: relative">
                                                        
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="id-date-picker-1">Data de Contracto</label>
                                                            <div class="input-group">
                                                                <input type="text" name="data_contracto" value="{{old('data_contracto')}}" class="form-control date-picker" autocomplete="off" style="height: 35px;" autocomplete="off" id="id-date-picker-1" data-date-format="yyyy-mm-dd" />
                                                                <span class="input-group-addon">
                                                                    <i class="fa fa-calendar bigger-110"></i>
                                                                </span>
                                                                @if ($errors->has('data_contracto'))
                                                                <span class="help-block" style="color: red; font-weight: ">
                                                                    
                                                                    <strong>{{ $errors->first('data_contracto') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <h4 class="header bolder smaller" style="color: #3d5476">Contacto</h4>
                                                    <div class="form-group has-info" style="left: 6%; position: relative">
                                                        
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="telefone_empresa">Telefone empresa<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                            <div class="">
                                                                <input type="text" name="telefone_empresa" value="{{old('telefone_empresa')}}" id="telefone_empresa" class="col-md-12 col-xs-12 col-sm-4" required />
                                                                @if ($errors->has('telefone_empresa'))
                                                                <span class="help-block" style="color: red; font-weight: ">
                                                                    <strong>{{ $errors->first('telefone_empresa') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="email_empresa">Email empresa<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                            <div class="">
                                                                <input type="email" name="email_empresa" value="{{old('email_empresa')}}" required id="endereco" class="col-md-12 col-xs-12  col-sm-4" />
                                                                @if ($errors->has('email_empresa'))
                                                                <span class="help-block" style="color: red; font-weight: ">
                                                                    
                                                                    <strong>{{ $errors->first('email_empresa') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group has-info" style="left: 6%; position: relative">
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="pessoal_contacto">Pessoa Contacto<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                            <div class="">
                                                                <input type="text" name="pessoal_contacto" value="{{old('pessoal_contacto')}}"  id="pessoal_contacto" class="col-md-12 col-xs-12  col-sm-4" required="" />
                                                                @if ($errors->has('pessoal_contacto'))
                                                                <span class="help-block" style="color: red; font-weight: ">
                                                                    
                                                                    <strong>{{ $errors->first('pessoal_contacto') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="telefone_contacto">Telefone contacto<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                            <div class="">
                                                                <input type="text" name="telefone_contacto" value="{{old('telefone_contacto')}}" id="telefone_contacto" class="col-md-12 col-xs-12  col-sm-4" required="" />
                                                                @if ($errors->has('telefone_contacto'))
                                                                <span class="help-block" style="color: red; font-weight: ">
                                                                    <strong>{{ $errors->first('telefone_contacto') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group has-info" style="left: 6%; position: relative">
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="email_contacto">Email Contacto<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                            <div class="">
                                                                <input type="email" name="email_contacto" value="{{old('email_contacto')}}" id="email_contacto" class="col-md-12 col-xs-12  col-sm-4" required="" />
                                                                @if ($errors->has('email_contacto'))
                                                                <span class="help-block" style="color: red; font-weight: ">
                                                                    <strong>{{ $errors->first('email_contacto') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="website">Web Site<b class="red"></b></label>
                                                            <div class="">
                                                                <input type="text" name="website" value="{{old('website')}}" id="website" class="col-md-12 col-xs-12  col-sm-4" />
                                                                @if ($errors->has('website'))
                                                                <span class="help-block" style="color: red; font-weight: ">
                                                                    <strong>{{ $errors->first('website') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="search-btn" type="submit" style="border-radius: 10px">
                                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                                    Salvar
                                                </button>

                                                &nbsp; &nbsp;
                                                <button class="btn btn-danger" type="reset" style="border-radius: 10px">
                                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!--/ MODAL DE CRIAR fornecedorS-->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section>


<style type="text/css">
     #botoes{
        left: 0%;
        border-radius: 15px;
        margin-top: 0.1%;
        padding: 6px 12px 6px 12px;
        position: relative;
        text-transform: uppercase
    }
</style>
@endsection
