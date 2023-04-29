@component('frontOffice/header', ['title'=>'Cadastro empresa'])
@endcomponent
</div>
</div>
<div class="contact">
    <div class="container">
        <div class="section-header">
            <p>CADASTRA A SUA EMPRESA</p>
        </div>

        @if(isset($mensagem) && !empty($mensagem))
        <div class="alert alert-warning" role="alert">
            {{$mensagem}}
        </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="contact-form">
                    <form method="POST" action="{{ url('validar-empresa') }}" id="validation-form" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input type='hidden' name='remember_token' value='{{Session::token()}}'>
                        <input type='hidden' name='role_name' value='Empresa'>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="validationServerUsername">Nome Empresa*</label>
                                <input type="text" name="nome" value="{{ old('nome')}}" placeholder="Nome empresa" class="form-control {{ $errors->has('nome') ? ' has-error' : '' }}" id="validationCustomUsername" aria-describedby="inputGroupPrepend">
                                @if ($errors->has('nome'))
                                <div class="help-block">
                                    {{ $errors->first('nome') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="usr">Email*</label>
                                <input type="email" name="email" value="{{ old('email')}}" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" placeholder="E-mail" />
                                @if ($errors->has('email'))
                                <div class="help-block">
                                    {{ $errors->first('email') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="usr">NIF*</label>
                                <input type="text" name="nif" value="{{ old('nif')}}" class="form-control {{ $errors->has('nif') ? ' has-error' : '' }}" maxlength="14" placeholder="Nº de identificação fiscal" />
                                @if ($errors->has('nif'))
                                <div class="help-block">
                                    {{ $errors->first('nif') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="usr">Contacto*</label>
                                <input type="text" maxlength="9" name="pessoal_Contacto" value="{{ old('pessoal_Contacto')}}" class="form-control {{ $errors->has('pessoal_Contacto') ? ' has-error' : '' }}" placeholder="Telefone"="" />
                                @if ($errors->has('pessoal_Contacto'))
                                <div class="help-block">
                                    {{ $errors->first('pessoal_Contacto') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="usr">Web Site</label>
                                <input type="text" name="website" value="{{ old('website')}}" class="form-control {{ $errors->has('website') ? ' has-error' : '' }}" v-model="empresa.website" placeholder="www.exemplo.ao" />
                                @if ($errors->has('website'))
                                <div class="help-block">
                                    {{ $errors->first('website') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="usr">Endereço*</label>
                                <input type="text" name="endereco" value="{{ old('endereco')}}" class="form-control {{ $errors->has('endereco') ? ' has-error' : '' }}" v-model="empresa.endereco" placeholder="Cidade, rua, número edificio"="" />
                                @if ($errors->has('endereco'))
                                <div class="help-block">
                                    {{ $errors->first('endereco') }}
                                </div>
                                @endif
                            </div>
                            <div class="control-group col-md-2">
                                <label for="usr">País*</label>
                                <select name="pais_id" class="form-control select2 {{ $errors->has('pais_id') ? ' has-error' : '' }}" data-placeholder="Selecione o País..." id="pais_id">
                                    <option value=""></option>
                                    @foreach ($paises as $pais)
                                    <option value="{{$pais->id}}" {{(old('pais_id')==$pais->id)? 'selected':''}}>{{$pais->designacao}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('pais_id'))
                                <div class="help-block">
                                    {{ $errors->first('pais_id') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="usr">Cidade*</label>
                                <input type="text" name="cidade" value="{{ old('cidade')}}" class="form-control {{ $errors->has('cidade') ? ' has-error' : '' }}" v-model="empresa.cidade" placeholder="Ex:Luanda"="" />
                                @if ($errors->has('cidade'))
                                <div class="help-block">
                                    {{ $errors->first('cidade') }}
                                </div>
                                @endif
                            </div>
                            <div class="control-group col-md-4">
                                <label for="usr">Tipo de Empresa*</label>
                                <select class="form-control select2 {{ $errors->has('tipo_cliente_id') ? ' has-error' : '' }}" name="tipo_cliente_id" data-placeholder="Selecione o tipo de empresa..." id="tipo_cliente_id">
                                    <option value=""></option>
                                    @foreach ($tipoEmpresa as $empresa)
                                    <option value="{{$empresa->id}}" {{(old('tipo_cliente_id')==$empresa->id)? 'selected':''}}>{{$empresa->designacao}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('tipo_cliente_id'))
                                <div class="help-block">
                                    {{ $errors->first('tipo_cliente_id') }}
                                </div>
                                @endif
                            </div>
                            <div class="control-group col-md-4">
                                <label for="usr">Tipo de Regime*</label>
                                <select class="form-control select2 {{ $errors->has('tipo_regime_id') ? ' has-error' : '' }}" name="tipo_regime_id" data-placeholder="Selecione o tipo de empresa..." id="tipo_cliente_id">
                                    <option value=""></option>
                                    @foreach ($tipoRegime as $regime)
                                    <option value="{{$regime->id}}" {{(old('tipo_regime_id')==$regime->id)? 'selected':''}}>{{$regime->Designacao}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('tipo_regime_id'))
                                <div class="help-block">
                                    {{ $errors->first('tipo_regime_id') }}
                                </div>
                                @endif
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="id-input-file-alvara">Alvará</label>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="file_alvara" accept="application/pdf" class="id-input-file-3" id="id-input-file-alvara" />
                                </div>
                                @if ($errors->has('file_alvara'))
                                <span class="help-block" style="color: red; font-weight: bold">
                                    <strong>{{ $errors->first('file_alvara') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <label for="id-input-file-nif">NIF</label>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="file_nif" accept="application/pdf" class="id-input-file-3" id="id-input-file-nif" />
                                </div>
                                @if ($errors->has('file_nif'))
                                <span class="help-block" style="color: red; font-weight: bold">
                                    <strong>{{ $errors->first('file_nif') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="usr">Logotipo</label>
                                <input type="file" name="logotipo" accept="image/*" />
                            </div>
                            @if ($errors->has('logotipo'))
                            <span class="help-block" style="color: red; font-weight: bold">
                                <strong>{{ $errors->first('logotipo') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-row">
                            <button type="submit" id="btn-cadastro" class="btn">Cadastre sua empresa</button>
                            <!-- <a href="#" id="btn-cadastro" class="btn" @click.prevent="cadastrarEmpresa"></a> -->
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .contact .contact-form .btn {
        height: 50px !important;
        padding: 14px 20px !important;
        color: #fff !important;
        font-size: 16px !important;
        /* text-transform: uppercase; */
        background: #00539C !important;
        border-radius: 5px !important;
        transition: .3s !important;
    }

    .form-control .select2 .has-error {
        border: 1px solid #ec1515 !important;
    }

    .contact .contact-form .has-error {
        border: 1px solid #ec1515 !important;
    }

    .control-group label,
    .form-group label {
        color: black;
        font-weight: 400;
    }

    .help-block {
        color: red !important;
        font-size: 12px !important;
    }

    .contact .contact-form .btn:hover {
        background: #0e5da2 !important;

    }
</style>
@component('frontOffice/footer')
@endcomponent
