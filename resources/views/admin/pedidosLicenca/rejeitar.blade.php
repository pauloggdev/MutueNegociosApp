<div>

    <div class="row" style="left: 0%; position: relative;">
        <div class="col-md-12">
            <div class="search-form-text">
                <div class="search-text">
                    <i class="fa fa-pencil"></i>
                    REJEITAR PEDIDO DE LICENÇA
                </div>
            </div>
        </div>

        <div class="col-md-12">

            <div class="tabbable" style="margin-top:30px">
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success')}}
                </div>
                @endif
                @error('observacao')
                <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ $message }}</p>
                @enderror
                <ul class="nav nav-tabs padding-16">
                    <li class="active">
                        <a>
                            <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                            MOTIVO DA REJEIÇÃO DO PEDIDO
                        </a>
                    </li>
                </ul>
                <div class="tab-content profile-edit-tab-content">
                    <div class="tab-pane in active">

                        <form action="" method="post">
                            @csrf
                            <textarea wire:model="observacao" autofocus class="col-md-12 col-xs-12 col-sm-4 @error('observacao') has-error @enderror" cols="30" rows="10" cols="30" rows="10">
                                    </textarea>
                            <button id="botoes" type="submit" wire:click.prevent="rejeitarPedidoLicenca" style="margin-top:20px" class="btn btn-danger widget-box widget-color-blue">REJEITAR</button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>



</div>