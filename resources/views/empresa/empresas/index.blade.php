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
                                <input type="text" wire:model="empresa.nome" style="<?= $errors->has('empresa.nome') ? 'border-color: #ff9292;' : '' ?>" autofocus placeholder="Nome empresa" class="form-control" aria-describedby="inputGroupPrepend">
                                @if ($errors->has('empresa.nome'))
                                <div class="help-block">
                                    {{ $errors->first('empresa.nome') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationServerUsername">E-mail*</label>
                                <input type="text" wire:model="empresa.email" style="<?= $errors->has('empresa.email') ? 'border-color: #ff9292;' : '' ?>" placeholder="E-mail" class="form-control" aria-describedby="inputGroupPrepend">
                                @if ($errors->has('empresa.email'))
                                <div class="help-block">
                                    {{ $errors->first('empresa.email') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="validationServerUsername">NIF*</label>
                                <input type="text" wire:model="empresa.nif" style="<?= $errors->has('empresa.nif') ? 'border-color: #ff9292;' : '' ?>" placeholder="NIF" class="form-control" aria-describedby="inputGroupPrepend">
                                @if ($errors->has('empresa.nif'))
                                <div class="help-block">
                                    {{ $errors->first('empresa.nif') }}
                                </div>
                                @endif
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="usr">Contacto*</label>
                                <input type="text" maxlength="9" class="form-control" placeholder="Telefone" />
                            </div>
                            <div class="form-group col-md-4">
                                <label>Web Site</label>
                                <input type="text" wire:model="empresa.website" class="form-control" placeholder="www.exemplo.ao" />
                                @if ($errors->has('website'))
                                <div class="help-block">
                                    {{ $errors->first('website') }}
                                </div>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label>Endereço*</label>
                                <input type="text" wire:model="empresa.endereco" class="form-control" placeholder="www.exemplo.ao" />
                                @if ($errors->has('website'))
                                <div class="help-block">
                                    {{ $errors->first('website') }}
                                </div>
                                @endif
                            </div>
                            <div class="control-group col-md-2">
                                <label for="usr">País*</label>
                                <select wire:model="empresa.pais_id" class="form-control select2" data-placeholder="Selecione o País..." id="pais_id">
                                    <option value="">Selecione...</option>
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
                                <label for="cidade">Cidade*</label>
                                <input type="text" wire:model="empresa.cidade" style="<?= $errors->has('empresa.cidade') ? 'border-color: #ff9292;' : '' ?>" class="form-control" placeholder="Ex:Luanda" />
                                @if ($errors->has('empresa.cidade'))
                                <div class="help-block">
                                    {{ $errors->first('empresa.cidade') }}
                                </div>
                                @endif
                            </div>
                            <div class="control-group col-md-4">
                                <label for="tipoEmpresa">Tipo de Empresa*</label>
                                <select wire:model="empresa.tipo_cliente_id" class="form-control select2" data-placeholder="Selecione o tipo de empresa..." id="tipoEmpresa">
                                    <option value="">Selecione...</option>
                                    @foreach ($tipoEmpresa as $empresa)
                                    <option value="{{$empresa->id}}">{{$empresa->designacao}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('empresa.tipo_cliente_id'))
                                <div class="help-block">
                                    {{ $errors->first('empresa.tipo_cliente_id') }}
                                </div>
                                @endif
                            </div>
                            <div class="control-group col-md-4">
                                <label for="regime">Tipo de Regime*</label>
                                <select wire:model="empresa.tipo_regime_id" class="form-control select2 {{ $errors->has('tipo_regime_id') ? ' has-error' : '' }}" data-placeholder="Selecione o tipo de empresa..." id="tipo_cliente_id">
                                    <option value="">Selecione...</option>
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
                                    <input type="file" wire:model="empresa.file_alvara" accept="application/pdf" class="id-input-file-3" id="id-input-file-alvara" />
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
                                    <input type="file" wire:model="empresa.file_nif" accept="application/pdf" class="id-input-file-3" id="id-input-file-nif" />
                                </div>
                                @if ($errors->has('file_nif'))
                                <span class="help-block" style="color: red; font-weight: bold">
                                    <strong>{{ $errors->first('file_nif') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label for="usr">Logotipo</label>
                                <input type="file" wire:model="empresa.logotipo" accept="image/*" />
                            </div>
                            @if ($errors->has('logotipo'))
                            <span class="help-block" style="color: red; font-weight: bold">
                                <strong>{{ $errors->first('logotipo') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-row">
                            <button type="submit" id="btn-cadastro" wire:click.prevent="cadastrarEmpresa" class="btn">
                                <span wire:loading.remove wire:target="cadastrarEmpresa">
                                    Cadastre sua empresa
                                </span>
                                <span wire:loading wire:target="cadastrarEmpresa">
                                    <span class="loading"></span>
                                    Aguarde...</span>
                            </button>
                            <!-- <a href="#" id="btn-cadastro" class="btn" @click.prevent="cadastrarEmpresa"></a> -->
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>