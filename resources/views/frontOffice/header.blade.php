<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{$title}}</title>
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
</head>

<body>
    <div>
        <!-- Header Start -->
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
