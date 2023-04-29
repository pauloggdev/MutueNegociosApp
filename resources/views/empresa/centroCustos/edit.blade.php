@extends('layout.appEmpresa')
@section('title','Editar centro de custos')
@section('content')
<section class="content">
    <div class="row">
        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                CENTRO DE CUSTOS
                <small>
                    <i class="ace-icon fa fa-angle-double-right"></i>
                    Editar
                </small>
            </h1>
        </div>
        @if (Session::has('success'))
        <div class="alert alert-success alert-success col-xs-12" style="left: 0%;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fa fa-check-square-o bigger-150"></i>{{ Session::get('success') }}</h5>
        </div>
        @endif


        <div class="col-xs-12">
            <div class="">
                <div class="row">
                    <div id="" class="user-profile row">
                        <div class="col-sm-offset-1 col-sm-10">

                            <div class="space"></div>

                            <form method="POST" action="{{ route('centroCusto.update', $centroCusto->uuid) }}" enctype="multipart/form-data" class="filter-form form-horizontal validation-form" id="validation-form">
                                {{ csrf_field() }}
                                @method('PUT')

                                <div class="tabbable">
                                    <ul class="nav nav-tabs padding-16">
                                        <li>
                                            <a data-toggle="tab" href="#edit-settings">
                                                <i class="purple ace-icon icofont-info-circle bigger-125"></i>
                                                Informações - centro de custos
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content profile-edit-tab-content">
                                        <div class="row">


                                            <div class="col-md-12">
                                                <div class="form-group has-info">
                                                    <div class="col-md-12">
                                                        <label class="" for="form-field-username">Nome*</label>
                                                        <input type="text" name="nome" value="{{$centroCusto->nome?? old('nome')}}" class="col-md-12" id="name" placeholder="Nome" maxlength="255">
                                                        @if ($errors->has('nome'))
                                                        <span class="help-block" style="color: red; font-weight: bold">
                                                            <strong>{{ $errors->first('nome') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-12">
                                                        <label class="" for="form-field-username">Endereço*</label>
                                                        <input type="text" name="endereco" value="{{$centroCusto->endereco?? old('endereco')}}" class="col-md-12" id="name" placeholder="Endereço">
                                                        @if ($errors->has('endereco'))
                                                        <span class="help-block" style="color: red; font-weight: bold">
                                                            <strong>{{ $errors->first('endereco') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-12">
                                                        <label class="" for="form-field-username">NIF*</label>
                                                        <input type="text" name="nif" value="{{$centroCusto->nif?? old('nif')}}" class="col-md-12" id="nif" placeholder="Nº de identificação fiscal" maxlength="14">
                                                        @if ($errors->has('nif'))
                                                        <span class="help-block" style="color: red; font-weight: bold">
                                                            <strong>{{ $errors->first('nif') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-12">
                                                        <label class="" for="form-field-username">Status</label>
                                                        <select name="statu_id" class="col-md-12 select2" data-placeholder="Selecione o status" id="statu_id">
                                                            <option value="1">Ativo</option>
                                                            <option value="2">Desativo</option>

                                                        </select>
                                                        @if ($errors->has('statu_id'))
                                                        <span class="help-block" style="color: red;">
                                                            <strong>{{ $errors->first('statu_id') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group has-info">
                                                    <div class="col-md-12">
                                                        <label class="" for="form-field-username">Cidade*</label>

                                                        <input class="col-md-12" type="text" name="cidade" value="{{$centroCusto->cidade?? old('cidade')}}" id="form-field-username" placeholder="Cidade" />
                                                        @if ($errors->has('cidade'))
                                                        <span class="help-block" style="color: red;">
                                                            <strong>{{ $errors->first('cidade') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-12">
                                                        <label class="" for="form-field-username">Logotipo</label>
                                                        <div class="file-upload-wrapper">
                                                            <input type="file" name="logotipo" accept="image/*" class="id-input-file-3" id="id-input-file-alvara" />
                                                        </div>
                                                        @if ($errors->has('logotipo'))
                                                        <span class="help-block" style="color: red; font-weight: bold">
                                                            <strong>{{ $errors->first('logotipo') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-12">
                                                        <img src='{{ url("upload/$centroCusto->logotipo")}}' width="112px" alt="">
                                                    </div>
                                                </div>
                                                <h4 class="header blue bolder smaller">Contactos</h4>
                                                <div class="form-group has-info">
                                                    <div class="col-md-12">
                                                        <label class="" for="form-field-username">E-mail</label>
                                                        <input type="text" name="email" value="{{$centroCusto->email?? old('email')}}" class="col-md-12" id="email" placeholder="E-mail">
                                                        @if ($errors->has('email'))
                                                        <span class="help-block" style="color: red; font-weight: bold">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-12">
                                                        <label class="" for="form-field-username">Website</label>
                                                        <input type="text" name="website" value="{{$centroCusto->website?? old('website')}}" class="col-md-12" id="website" placeholder="website">
                                                        @if ($errors->has('website'))
                                                        <span class="help-block" style="color: red; font-weight: bold">
                                                            <strong>{{ $errors->first('website') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group has-info">
                                                    <div class="col-md-12">
                                                        <label class="" for="form-field-username">Telefone*</label>
                                                        <input type="text" name="telefone" value="{{$centroCusto->telefone?? old('telefone')}}" class="col-md-12" id="telefone" placeholder="Telefone">
                                                        @if ($errors->has('telefone'))
                                                        <span class="help-block" style="color: red; font-weight: bold">
                                                            <strong>{{ $errors->first('telefone') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <h4 class="header blue bolder smaller">Outros</h4>
                                                <div class="form-group has-info">
                                                    <div class="col-md-12">
                                                        <label class="" for="form-field-username">Pessoa de contato</label>
                                                        <input type="text" name="pessoa_de_contacto" value="{{$centroCusto->pessoa_de_contacto?? old('pessoa_de_contacto')}}" class="col-md-12" id="pessoa_de_contacto" placeholder="Pessoa de contato">
                                                        @if ($errors->has('pessoa_de_contacto'))
                                                        <span class="help-block" style="color: red; font-weight: bold">
                                                            <strong>{{ $errors->first('pessoa_de_contacto') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group has-info">
                                                    <div class="col-md-6">
                                                        <label for="id-input-file-alvara">Alvará&nbsp;&nbsp;<a href='{{ url("upload/$centroCusto->file_alvara")}}' target="blank" style="color: #337ab7;">baixar arquivo pdf</a></label>
                                                        <div class="file-upload-wrapper">

                                                            <input type="file" name="file_alvara" accept="application/pdf" class="id-input-file-3" id="id-input-file-alvara" />
                                                        </div>
                                                        @if ($errors->has('file_alvara'))
                                                        <span class="help-block" style="color: red; font-weight: bold">
                                                            <strong>{{ $errors->first('file_alvara') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="id-input-file-nif">NIF&nbsp;&nbsp;<a href='{{ url("upload/$centroCusto->file_nif")}}' target="blank" style="color: #337ab7;">baixar arquivo pdf</a></label>
                                                        <div class="file-upload-wrapper">
                                                            <input type="file" name="file_nif" accept="application/pdf" class="id-input-file-3" id="id-input-file-nif" />
                                                        </div>
                                                        @if ($errors->has('file_nif'))
                                                        <span class="help-block" style="color: red; font-weight: bold">
                                                            <strong>{{ $errors->first('file_nif') }}</strong>
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
                                        <button class="btn btn-info" type="submit">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            Salvar
                                        </button>

                                        &nbsp; &nbsp;
                                        <a href="{{ route('centroCusto.index') }}" class="btn" type="reset">
                                        <i class="ace-icon fa fa-undo bigger-110"></i>
                                        Cancelar
                                        </a>
                                        <!-- <button class="btn" type="reset">
                                            Cancelar
                                        </button> -->
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