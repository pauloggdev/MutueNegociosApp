@component('frontOffice/header', ['title'=>'Home'])
@endcomponent

<div class="hero row align-items-center">
    <div class="col-md-7">
        <!-- <h2>Best & Trusted</h2> -->
        <h2><span>Mutue</span> Negócios</h2>
        <h2>A solução para sua empresa</h2><br>
        <a class="btn" href="/cadastro-empresa">Cadastre sua empresa</a>
    </div>
    <div class="col-md-5">
        <div class="form">
            <h3>Login</h3>
            <form action="{{route('login')}}" id="contact-form" method="POST">
                @csrf
                @if ($errors->has('email'))
                <span class="block input-icon input-icon-right">
                    <strong style="color: #c73030;font-size: 12px;">{{ $errors->first('email') }}</strong>
                </span>
                @endif
                <input class="form-control" name="email" value="{{ old('email')}}" required type="text" autocomplete="off" placeholder="Email / telefone">
                <input class="form-control" name="password" value="{{ old('password')}}" required type="password" placeholder="Senha">
                @if ($errors->has('password'))
                <span class="help-block" style="color: #c73030;font-size: 12px;">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
                <div class="control-group">
                    <select class="custom-select" name="tipoUser">
                        <option value="2" selected>Empresa</option>
                        <option value="1">Admin</option>
                    </select>
                </div>
                @if (Route::has('password.reset'))
                <div class="control-group">
                    <a href="{{ route('password.reset') }}" style="color: #eadecb;">Esqueceu a senha?</a>
                </div>
                @endif
                <button class="btn btn-block" type="submit">Entrar</button>
            </form>
        </div>
    </div>
</div>
</div>
</div>


<!-- Service Start -->
<div class="service">
    <div class="container">
        <div class="section-header">
            <p>Como funciona?</p>
            <!-- <h4>Provide Services Worldwide</h4> -->
        </div>
        <div class="row">
            <div class="col-md-3 text-center">
                <span class="fa-stack fa-2x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-building fa-stack-1x fa-inverse"></i>
                </span>
                <h5 class="text-weight-strong">
                    1 - Crie a sua empresa
                </h5>
                <p>Adicionar os campos obrigatório da sua empresa</p>
            </div>
            <div class="col-md-3 text-center">
                <span class="fa-stack fa-2x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-cart-plus fa-stack-1x fa-inverse"></i>
                </span>
                <h5 class="text-weight-strong">
                    2 - Cadastre seus produtos/serviços
                </h5>
                <p>Adicione seus produtos e serviços em pouco tempo</p>
            </div>
            <div class="col-md-3 text-center">
                <span class="fa-stack fa-2x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-money fa-stack-1x fa-inverse"></i>
                </span>
                <h5 class="text-weight-strong">
                    3 - Crie banco da sua empresa
                </h5>
                <p>Criei seus bancos para efectuar a facturação</p>
            </div>
            <div class="col-md-3 text-center">
                <span class="fa-stack fa-2x">
                    <i class="fa fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa fa-ticket fa-stack-1x fa-inverse"></i>
                </span>
                <h5 class="text-weight-strong">
                    4 - Efectua a facturação
                </h5>
                <p>Efectua as facturações para seus clientes</p>
            </div>

        </div>

    </div>
</div>
<!-- Service End -->

<!-- About Start -->
<div class="about">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="about-img">
                    <img src="{{asset('assets/images/HomeMutueNegocios.png')}}">
                </div>
            </div>
            <div class="col-md-6">
                <!-- <div class="section-premium--right">
                    <div class="section-premium--item">
                        <div>
                            <h4>DASHBOARD</h4>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed vel eros vitae erat condimentum viverra a nec lacus.<br />
                            -- FEATURE ONE<br />
                            -- FEATURE TWO<br />
                            -- FEATURE THREE
                        </div>
                    </div>
                </div> -->
                <div class="about-text">
                    <span>
                        Dashboard<br>
                        Software de facturação <br> Mutue Negócios
                    </span>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->



<!-- Pricing -->
<div class="block-contained">
    <h2 class="block-title">
        Nossas Licenças
    </h2>
    <div class="row">
        @foreach($licencas as $licenca)
        <div class="col-md-3">
            <div class="panel panel-default panel-pricing panel-pricing-highlighted text-center">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        {{$licenca->designacao}}
                    </h4>
                </div>
                <div class="panel-body" style="height: 250px">
                    <ul class="list-dotted">
                        @if($licenca->tipo_licenca_id == 1)
                        <li>Acesso 30 dias</li>
                        @endif
                        <li>Certificado pela AGT</li>
                        <li>Até {{$licenca->limite_usuario}} utilizadores</li>
                        <li>Exportação do ficheiro SAFT</li>
                        <li>Facturação em Backoffice</li>
                        <li>Capacidade ilimitada</li>
                        <li>Acesso App</li>
                    </ul>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


<!-- Newsletter Start -->
<div class="newsletter">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <p>
                    Use o software por 30/dias grátis
                </p>
            </div>
            <div class="col-md-4">
                <a class="btn" style="position: relative;" href="/cadastro-empresa" style="">Experimente Grátis</a>

            </div>
        </div>
    </div>
</div>
<!-- Newsletter End -->

<style>
    .about .about-text h5 {
        position: relative;
        color: #00539C;
        font-size: 31px;
        margin-bottom: 15px;
    }

    .about .about-text h2 {
        position: relative;
        color: #00539C;
        font-size: 40px;
        margin-bottom: 15px;
    }

    .panel-pricing .panel-pricing-price .digits {
        font-size: 30px;
        color: #ffffff;
    }

    .panel-pricing.panel-pricing-highlighted .panel-pricing-price {
        background: #00539c;
        padding: 25px 0 20px 0;
    }

    .about-text span {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji" !important;
        font-size: 20px;
        line-height: 32px;
        display: block;

    }
</style>
@component('frontOffice/footer')
@endcomponent
