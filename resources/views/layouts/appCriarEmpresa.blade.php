<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Criar Conta</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Cleaning Company Website Template" name="keywords">
    <meta content="Cleaning Company Website Template" name="description">

    {{-- FAVICON  --}}
    <link rel="shortcut icon" sizes="57x57" href="{{asset('favicon/apple-icon-57x57.png')}}">
    <link rel="shortcut icon" sizes="60x60" href="{{asset('favicon/apple-icon-60x60.png')}}">
    <link rel="shortcut icon" sizes="72x72" href="{{asset('favicon/apple-icon-72x72.png')}}">
    <link rel="shortcut icon" sizes="76x76" href="{{asset('favicon/apple-icon-76x76.png')}}">
    <link rel="shortcut icon" sizes="114x114" href="{{asset('favicon/apple-icon-114x114.png')}}">
    <link rel="shortcut icon" sizes="120x120" href="{{asset('favicon/apple-icon-120x120.png')}}">
    <link rel="shortcut icon" sizes="144x144" href="{{asset('favicon/apple-icon-144x144.png')}}">
    <link rel="shortcut icon" sizes="152x152" href="{{asset('favicon/apple-icon-152x152.png')}}">
    <link rel="shortcut icon" sizes="180x180" href="{{asset('favicon/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset('favicon/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('favicon/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('favicon/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('favicon/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    {{-- FIM FAVICON  --}}

    <!-- Favicon -->
    <link href="{{asset('assets/frontOffice/img/favicon.ico')}}" rel="icon">

    <!-- Google Font -->
    <link href="{{asset('assets/frontOffice/googleapis/googleapis.css')}}" rel="stylesheet">

    <!-- CSS Libraries -->
    <link href="{{asset('assets/frontOffice/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="{{asset('assets/frontOffice/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/frontOffice/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">
    <!-- Template Stylesheet -->
    <link href="{{asset('assets/frontOffice/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/frontOffice/css/style2.css')}}" rel="stylesheet">
    <!-- <link href="{{asset('assets/css/style.css')}}" rel="stylesheet"> -->
    @livewireStyles

</head>

<body>
    <div>
        <div class="header home">
            <div class="container-fluid">
                <div class="header-top row align-items-center">
                    <div class="col-lg-3">
                        <div class="brand">
                            <a href="/">
                                <img src="{{asset('assets/frontOffice/img/logoNovo.png')}}" class="img-fluid" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="topbar">
                            <div class="topbar-col">
                                <a href="tel:+012 345 67890"><i class="fa fa-phone"></i>+244 922969192</a>
                            </div>
                            <div class="topbar-col">
                                <a href="mailto:info@example.com"><i class="fa fa-envelope"></i>geral@mutue.net</a>
                            </div>
                        </div>
                        <div class="navbar navbar-expand-lg bg-light navbar-light">
                            <a href="#" class="navbar-brand">MENU</a>
                            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                                <div class="navbar-nav ml-auto">
                                    <a href="/" class="nav-item nav-link active">Home</a>
                                    <a href="/sobre" class="nav-item nav-link">Sobre nós</a>
                                    <a href="/servicos" class="nav-item nav-link">Serviços</a>
                                    <a href="/contacto" class="nav-item nav-link">Contacto</a>
                                    <!-- <a href="#" class="btn">Cadastre sua empresa</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="main-content-inner">
                <div class="page-content">
                    <div class="content-wrapper">
                        <div id="app">
                            @if(isset($slot))
                            {{$slot}}
                            @else
                            @yield('content')
                            @endif
                        </div>
                    </div>
                </div><!-- /.page-content -->
            </div>
        </div><!-- /.main-content -->

        <!-- Footer Start -->
        <div class="footer header home">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-contact">
                            <h2>CONTACTO</h2>
                            <p><i class="fa fa-map-marker"></i>Rua Nossa senhora da Muxima, nº 10 - 8º andar - Luanda - Angola</p>
                            <p><i class="fa fa-phone"></i>+244 922969192</p>
                            <p><i class="fa fa-envelope"></i>geral@mutue.net</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-link">
                            <h2>Acesso Rápido</h2>
                            <a href="/">Home</a>
                            <a href="/sobre">Sobre</a>
                            <a href="/servicos">Serviços</a>
                            <a href="/contacto">Contacto</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-link">
                            <h2>Link úteis</h2>
                            <a href="">Nossos clientes</a>
                            <a href="">Avalicação dos clientes</a>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="footer-form">
                            <h2>NOTA INFORMATIVA</h2>
                            <p>
                                Para efeito de algum esclarecimento, deixe-nos o seu e-mail e mantenha-se informado. Obrigado!
                            </p>

                            <input class="form-control" placeholder="Email...">
                            <textarea class="form-control" placeholder="Mensagem..." style="margin-top:10px; height:100px" name="" id="" cols="30" rows="10"></textarea>
                            <button class="btn" style="background: #00539c; color:white;">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container copyright">
                <div class="row">
                    <div class="col-md-6">
                        <p>
                            Copyright &copy; <script>
                                document.write(new Date().getFullYear());
                            </script> Mutue-Soluções Tecnológicas Inteligentes</p>

                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>Todos os direitos reservado</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->

        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    </div>

    @livewireScripts


    <!-- Script VUE.JS-->
    <script src="{{asset('js/app.js')}}"></script>
    <!-- JavaScript Libraries -->
    <script src="{{asset('assets/frontOffice/js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('assets/frontOffice/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/frontOffice/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('assets/frontOffice/lib/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/frontOffice/lib/isotope/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('assets/frontOffice/lib/lightbox/js/lightbox.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('assets/frontOffice/js/main.js')}}"></script>
</body>

</html>

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
<style>
    /* Absolute Center Spinner */
    .loading {
        position: fixed;
        z-index: 999;
        height: 2em;
        width: 2em;
        overflow: visible;
        margin: auto;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
    }

    /* Transparent Overlay */
    .loading:before {
        content: '';
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.3);
    }

    /* :not(:required) hides these rules from IE9 and below */
    .loading:not(:required) {
        /* hide "loading..." text */
        font: 0/0 a;
        color: transparent;
        text-shadow: none;
        background-color: transparent;
        border: 0;
    }

    .loading:not(:required):after {
        content: '';
        display: block;
        font-size: 10px;
        width: 1em;
        height: 1em;
        margin-top: -0.5em;
        -webkit-animation: spinner 1500ms infinite linear;
        -moz-animation: spinner 1500ms infinite linear;
        -ms-animation: spinner 1500ms infinite linear;
        -o-animation: spinner 1500ms infinite linear;
        animation: spinner 1500ms infinite linear;
        border-radius: 0.5em;
        -webkit-box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.5) -1.5em 0 0 0, rgba(0, 0, 0, 0.5) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
        box-shadow: rgba(0, 0, 0, 0.75) 1.5em 0 0 0, rgba(0, 0, 0, 0.75) 1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) 0 1.5em 0 0, rgba(0, 0, 0, 0.75) -1.1em 1.1em 0 0, rgba(0, 0, 0, 0.75) -1.5em 0 0 0, rgba(0, 0, 0, 0.75) -1.1em -1.1em 0 0, rgba(0, 0, 0, 0.75) 0 -1.5em 0 0, rgba(0, 0, 0, 0.75) 1.1em -1.1em 0 0;
    }

    /* Animation */

    @-webkit-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-moz-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-o-keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes spinner {
        0% {
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }

        100% {
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
</style>
