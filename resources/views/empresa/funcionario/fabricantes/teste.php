
<section class="content">
    <div class="row">
        
        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                Fabricante   
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

                                <input type="text" name="query" required autocomplete="on" class="form-control search-query" placeholder="Buscar Por fabricante..."/>
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
                                <a href='#criar_fabricante' data-toggle="modal" title="Adicionar novo fabricante" class = 'btn btn-success widget-box widget-color-blue' id="botoes"><i class="fa fa-fabricante-plus"></i> Novo fabricante</a>
                                <div class="pull-right tableTools-container"></div>
                            </div>

                            <div class="table-header widget-header">
                                Todos fabricante do Sistema
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
                                            <th>Nome do fabricante</th>
                                            <th>status</th>
                                            <th>Opções</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @foreach($fabricantes as $fabricante)
                                        <tr>
                                            <td class="center">
                                                <label class="pos-rel ">
                                                    <input type="checkbox" class="ace " />
                                                    <span class="lbl"></span>
                                                </label>
                                            </td>

                                            <td>{{$fabricante->designacao}}</td>

                                            <td class="hidden-480" style="text-align: center">
                                                @if($fabricante->statuGeral->id == 1)
                                                    <span class="label label-sm label-success" style="border-radius: 20px;">{{$fabricante->statuGeral->designacao}}</span>
                                                @else
                                                    <span class="label label-sm label-warning" style="border-radius: 20px;">{{$fabricante->statuGeral->designacao}}</span>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                <a class="" href='{{ url('empresa/fabricantes/editar/')}}/{{$fabricante->id}}' class="pink" title="Editar este registo">
                                                        <i class="ace-icon fa fa-pencil bigger-150 bolder success text-success"></i>
                                                    </a>
                                                    <a class=" " data-toggle="modal" href="" data-target=".eliminar{{$fabricante->id}}" title="Eliminar este Registro">
                                                        <i class="ace-icon fa fa-trash-o bigger-150 bolder danger red"></i>
                                                    </a>
                                                </div>
                                                
                                            </td>
                                        </tr>

                                        <!-- Moda eliminar -->
                                        <div class="modal fade width-100 eliminar{{$fabricante->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-default">
                                                <div class="modal-content">
                                                    <div class="widget-header modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="text-danger">×</span></button>
                                                        <h4 class="smaller"><i class="ace-icon fa fa-exclamation-triangle red"></i> Eliminar fabricante</h4>
                                                    </div>
                                                <div class="modal-body alert alert-danger bigger-110" >
                                                    <p class="bigger-110 center grey" style="color: orange;">
                                                        <i class="ace-icon fa fa-exclamation-triangle red bigger-110"></i>
                                                        <?php echo "Tem certeza que quer eliminar este registro? "?>
                                                    </p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class=" btn btn-inverse btn-flat widget-color-blue1" data-dismiss="modal" style="border-radius: 10px">Cancelar</button>
                                                    <a href="{{url('empresa/fabricantes/deletar/')}}/{{$fabricante->id}}" class="bigger-10 btn btn-danger btn-flat widget-color-blue1" style="border-radius: 10px"> Eliminar</a>
                                                </div>
                                                </div>
                                            </div>
                                        </div><!-- MODAIS DE COMFIRMAÇÃO PARA ELIMINAR-->
                                     @endforeach
                                    </tbody> 
                                </table>
                                 {{$fabricantes->render()}}
                            </div>
                        </div><!-- /.col-xs-12 -->
                   </form>
                </div>
            </div>
             
           <!-- MODAL DE CRIAR fabricanteS -->
           <div id="criar_fabricante" class="modal fade criar_fabricante">
            <div class="modal-dialog modal-lg" style="left: 6%;  position: relative">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                        <h4 class="smaller"><i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> Adicionar fabricante</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" style="left: 0%; position: relative;">
                            <div class="col-md-12">
                                <div class="search-form-text">
                                    <div class="search-text">
                                        <i class="fa fa-pencil"></i>
                                        Dados do fabricante
                                    </div>
                                </div>

                                <form method = 'POST' action='{!!url("/empresa/fabricantes/adicionar")!!}' enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                    {!! csrf_field() !!}
                                    <input type = 'hidden' name = 'remember_token' value = '{{Session::token()}}'>

                                    <div class="second-row">
                                        
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#dados_fabricante">
                                                        <i class="green ace-icon fa fa-pencil-square bigger-125"></i>
                                                        Dados do fabricante
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="dados_fabricante" class="tab-pane in active" style="left: 12%; position: relative">
                                                    <div class="form-group has-info">
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="designacao">Nome do fabricante<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                            <div class="">
                                                                <input type="text" name="designacao" value="{{old('designacao')}}" id="designacao" class="col-md-12 col-xs-12  col-sm-4" required/>
                                                                @if ($errors->has('designacao'))
                                                                <span class="help-block" style="color: red; font-weight: ">
                                                                    <strong>{{ $errors->first('designacao') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="status_id">Status<b class="red"><i class="fa fa-question-circle bold text-danger"></i></b></label>
                                                            <div class="">
                                                                <select style="height: 34px" name="status_id" class="col-md-12 col-xs-12  col-sm-4 select2" data-placeholder="Selecione o status" id="status_id" required="">
                                                                    <option value=""></option>
                                                                    @foreach($status as $statu)
                                                                        <option value="{{$statu->id}}" {{(old('status_id')==$statu->id)? 'selected':''}}>{{$statu->designacao}}</option>
                                                                    @endforeach
                                                                </select>
                                                                @if ($errors->has('status_id'))
                                                                <span class="help-block" style="color: red; font-weight: ">
                                                                    <strong>{{ $errors->first('status_id') }}</strong>
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
        </div><!--/ MODAL DE CRIAR fabricanteS-->  
        </div><!-- /.col -->
    </div><!-- /.row -->
</section>