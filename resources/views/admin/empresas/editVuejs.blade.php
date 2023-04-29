@extends('layout.appEmpresa')
@section('title','Listar Clientes')
@section('content')

    <section class="content">
        <div class="row">

            <div class="space-6"></div>
            <div class="page-header" style="left: 0.5%; position: relative">
                <h1>
                    EMPRESA
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        Configurações
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
                        <div id="" class="user-profile row">
                            <div class="col-sm-offset-1 col-sm-10">
                                <!-- <div class="well well-sm">
                                   
                                    <div class="inline middle blue bigger-110"> Seu perfil está 80% completo</div>

                                    &nbsp; &nbsp; &nbsp;
                                    <div style="width:200px;" data-percent="70%"
                                        class="inline middle no-margin progress progress-striped active pos-rel">
                                        <div class="progress-bar progress-bar-success" style="width:70%"></div>
                                    </div>
                                </div> -->
                                

                                <div class="space"></div>

                                <form class="form-horizontal">
                                    <div class="tabbable">
                                        <ul class="nav nav-tabs padding-16">
                                    
                                            <li>
                                                <a data-toggle="tab" href="#edit-settings">
                                                    <i class="purple ace-icon icofont-info-circle bigger-125"></i>
                                                    Informações da empresa
                                                </a>
                                            </li>

                                            <li>
                                                <a data-toggle="tab" href="#edit-password">
                                                    <i class="blue ace-icon fa fa-key bigger-125"></i>
                                                    Password
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="edit-basic" class="tab-pane in active">
                                                <h4 class="header blue bolder smaller">General</h4>

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-4">
                                                        <input type="file" />
                                                    </div>

                                                    <div class="vspace-12-sm"></div>

                                                    <div class="col-xs-12 col-sm-8">
                                                        <div class="form-group has-info">
                                                            <label
                                                                class="col-sm-4 control-label no-padding-right"
                                                                for="form-field-username">Nome da Empresa</label>

                                                            <div class="col-sm-8">
                                                                <input class="col-xs-12 col-sm-10" type="text" id="form-field-username" placeholder="Username" value="alexdoe" />
                                                            </div>
                                                        </div>

                                                        <div class="space-4"></div>

                                                        <div class="form-group has-info">
                                                            <label
                                                                class="col-sm-4 control-label no-padding-right"
                                                                for="form-field-username">NIF</label>

                                                            <div class="col-sm-8">
                                                                <input class="col-xs-12 col-sm-10" type="text" id="form-field-username" placeholder="Username" value="alexdoe" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr />
                                                <div class="form-group has-info">
                                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Nome da Empresa</label>
                                                    <div class="col-sm-8">
                                                        <select name="pais_nacionalidade_id" class="col-md-8 col-xs-12 col-sm-4 select2" id="pais_nacionalidade" data-placeholder="Selecione o país" required="">
                                                            <option value="1">Angola</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Tipo de Empresa</label>
                                                    <div class="col-sm-8">
                                                        <select name="pais_nacionalidade_id" class="col-md-8 col-xs-12 col-sm-4 select2" id="pais_nacionalidade" data-placeholder="Selecione o país" required="">
                                                            <option value="1">Tipo de Empresa</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Tipo de Regime</label>
                                                    <div class="col-sm-8">
                                                        <select name="pais_nacionalidade_id" class="col-md-8 col-xs-12 col-sm-4 select2" id="pais_nacionalidade" data-placeholder="Selecione o país" required="">
                                                            <option value="1">Tipo de Regime</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="space"></div>
                                                <h4 class="header blue bolder smaller">Contactos</h4>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-email">Email</label>
                                                    <div class="col-sm-9">
                                                        <span class="input-icon input-icon-right">
                                                            <input type="email" id="form-field-email" class="col-xs-12" value="alexdoe@gmail.com"  />
                                                            <i class="ace-icon fa fa-envelope"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-website">Website</label>

                                                    <div class="col-sm-9">
                                                        <span class="input-icon input-icon-right">
                                                            <input type="url" id="form-field-website" class="col-xs-12" value="http://www.alexdoe.com/" />
                                                            <i class="ace-icon fa fa-globe"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-phone">Telefone</label>

                                                    <div class="col-sm-9">
                                                        <span class="input-icon input-icon-right">
                                                            <input class="input-medium input-mask-phone col-xs-12" type="text" id="form-field-phone" />
                                                            <i class="ace-icon fa fa-phone fa-flip-horizontal"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="space"></div>
                                                <h4 class="header blue bolder smaller">Outros</h4>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Pessoa de Contacto</label>
                                                    <div class="col-sm-8">
                                                        <input class="col-xs-12 col-sm-8" type="text" id="form-field-username" placeholder="Username" value="alexdoe" />
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Endereço</label>
                                                    <div class="col-sm-8">
                                                        <input class="col-xs-12 col-sm-8" type="text" id="form-field-username" placeholder="Username" value="alexdoe" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="edit-settings" class="tab-pane">
                                                <div class="space-10"></div>

                                                <h4 class="header blue bolder smaller">General</h4>

                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-4">
                                                        <input type="file" />
                                                    </div>

                                                    <div class="vspace-12-sm"></div>

                                                    <div class="col-xs-12 col-sm-8">
                                                        <div class="form-group has-info">
                                                            <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Nome da Empresa</label>

                                                            <div class="col-sm-8">
                                                                <input class="col-xs-12 col-sm-10" type="text" id="form-field-username" placeholder="Nome da Empresa"/>
                                                            </div>
                                                        </div>

                                                        <div class="space-4"></div>

                                                        <div class="form-group has-info">
                                                            <label
                                                                class="col-sm-4 control-label no-padding-right"
                                                                for="form-field-username">NIF</label>

                                                            <div class="col-sm-8">
                                                                <input class="col-xs-12 col-sm-10" type="text" id="form-field-username" placeholder="Username" value="alexdoe" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr />
                                                <div class="form-group has-info">
                                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Nome da Empresa</label>
                                                    <div class="col-sm-8">
                                                        <select name="pais_nacionalidade_id" class="col-md-8 col-xs-12 col-sm-4 select2" id="pais_nacionalidade" data-placeholder="Selecione o país" required="">
                                                            <option value="1">Angola</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Tipo de Empresa</label>
                                                    <div class="col-sm-8">
                                                        <select name="pais_nacionalidade_id" class="col-md-8 col-xs-12 col-sm-4 select2" id="pais_nacionalidade" data-placeholder="Selecione o país" required="">
                                                            <option value="1">Tipo de Empresa</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Tipo de Regime</label>
                                                    <div class="col-sm-8">
                                                        <select name="pais_nacionalidade_id" class="col-md-8 col-xs-12 col-sm-4 select2" id="pais_nacionalidade" data-placeholder="Selecione o país" required="">
                                                            <option value="1">Tipo de Regime</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="space"></div>
                                                <h4 class="header blue bolder smaller">Contactos</h4>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-email">Email</label>
                                                    <div class="col-sm-9">
                                                        <span class="input-icon input-icon-right">
                                                            <input type="email" id="form-field-email" class="col-xs-12" value="alexdoe@gmail.com"  />
                                                            <i class="ace-icon fa fa-envelope"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-website">Website</label>

                                                    <div class="col-sm-9">
                                                        <span class="input-icon input-icon-right">
                                                            <input type="url" id="form-field-website" class="col-xs-12" value="http://www.alexdoe.com/" />
                                                            <i class="ace-icon fa fa-globe"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-phone">Telefone</label>

                                                    <div class="col-sm-9">
                                                        <span class="input-icon input-icon-right">
                                                            <input class="input-medium input-mask-phone col-xs-12" type="text" id="form-field-phone" />
                                                            <i class="ace-icon fa fa-phone fa-flip-horizontal"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="space"></div>
                                                <h4 class="header blue bolder smaller">Outros</h4>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Pessoa de Contacto</label>
                                                    <div class="col-sm-8">
                                                        <input class="col-xs-12 col-sm-8" type="text" id="form-field-username" placeholder="Username" value="alexdoe" />
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-4 control-label no-padding-right" for="form-field-username">Endereço</label>
                                                    <div class="col-sm-8">
                                                        <input class="col-xs-12 col-sm-8" type="text" id="form-field-username" placeholder="Username" value="alexdoe" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="edit-password" class="tab-pane">
                                                <div class="space-10"></div>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-pass1">Antiga Password</label>

                                                    <div class="col-sm-9">
                                                        <input type="password" id="form-field-pass1" />
                                                    </div>
                                                </div>

                                                <div class="space-4"></div>

                                                <div class="form-group has-info">
                                                    <label class="col-sm-3 control-label no-padding-right" for="form-field-pass2">Nova Password</label>

                                                    <div class="col-sm-9">
                                                        <input type="password" id="form-field-pass2" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix form-actions">
                                        <div class="col-md-offset-3 col-md-9">
                                            <button class="btn btn-info" type="button">
                                                <i class="ace-icon fa fa-check bigger-110"></i>
                                                Salvar
                                            </button>

                                            &nbsp; &nbsp;
                                            <button class="btn" type="reset">
                                                <i class="ace-icon fa fa-undo bigger-110"></i>
                                                Cancelar
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div><!-- /.span -->
                        </div><!-- /.user-profile -->
                    </div>
                </div>
            </div><!-- /.col -->
    </section>
@endsection
