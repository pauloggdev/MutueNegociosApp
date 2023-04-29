<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- Estilos VUE.JS-->
    <meta name="csrf-token" content="{{ csrf_token() }}" />



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


    <link rel="stylesheet" href="{{ asset('css/app.css')}}">

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{ asset('assets/font-awesome/4.5.0/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/icofont/icofont.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/icofont/icofont.min.css')}}" />
    <!-- ========================================================================================= -->
    <!-- text fonts -->
    <link rel="stylesheet" href="{{asset('assets/css/fonts.googleapis.com.css')}}" />
    <!-- ========================================================================================= -->

    <!-- Estilos Gerais das páginas -->
    <link rel="stylesheet" href="{{asset('assets/css/ace.min.css')}}" class="ace-main-stylesheet" id="main-ace-style" />
    <link rel="stylesheet" href="{{asset('assets/css/ace-skins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/ace-rtl.min.css')}}" />
    <!-- ========================================================================================= -->

    <!-- Css para combobox com caixa de pesquisa, data e hora range, input do tipo number dinâmico e etc... -->
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.custom.min.css')}}" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css')}}" /> --}}
    <link rel="stylesheet" href="{{asset('assets/css/chosen.min.css')}}" />
    <!-- {{-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css')}}" /> --}}
        {{-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css')}}" /> --}}
        {{-- <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.min.css')}}" /> --}}
        {{-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css')}}" /> --}} -->
    <!-- ========================================================================================= -->

    <!-- Css para collapse-->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css')}}" />

    <!-- Css para Galerias de Imagem de Fundo de qualquer registo -->
    <link rel="stylesheet" href="{{ asset('assets/css/colorbox.min.css') }}" />
    <!-- ========================================================================================= -->

    <!-- ESTILOS CSS DE OUTROS TEMPLATES-->
    <!-- CSS do template Anzenta, para os contornos de alguns formulários-->
    <link rel="stylesheet" href="{{ asset('assets/plugin/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/plugin/css/style.css')}}" type="text/css">
    <!-- ========================================================================================= -->
</head>

<!-- #0D47A1 !important, #174284 !important  #242424 -->

<body class="skin-1" id="body">
    <div id="navbar" class="navbar navbar-default ace-save-state">

        @if(Auth::guard('web')->check())
        @if(!empty($alertaAtivacaoLicenca))
        @if($alertaAtivacaoLicenca['diasRestantes'] > 0)

        @component('empresa/components/AssineAgora', ['diasRestantes' => $alertaAtivacaoLicenca['diasRestantes']]))
        @endcomponent

        @else
        @component('empresa/components/licencaExpirada')
        @endcomponent

        @endif
        @endif
        @endif
        <div class="navbar-container ace-save-state" id="navbar-container">
            <div class="navbar-header pull-left">
                @if(Auth::guard('web')->check())
                <a href="{{url('home')}}" class="navbar-brand">
                    <small>MUTUE-NEGÓCIO</small>
                </a>
                @endif

                @if(Auth::guard('empresa')->check())
                <a href="{{url('empresa/home')}}" class="navbar-brand">
                    <small>MUTUE-NEGÓCIO</small>
                </a>
                @endif
            </div>

            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">

                    <li class="purple dropdown-modal">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                            <span class="badge badge-important">8</span>
                        </a>

                        <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                            <li class="dropdown-header">
                                <i class="ace-icon fa fa-exclamation-triangle"></i>
                                8 Notifications
                            </li>

                            <!-- <li class="dropdown-content">
                                    <ul class="dropdown-menu dropdown-navbar navbar-pink">
                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <span class="pull-left">
                                                        <i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
                                                        New Comments
                                                    </span>
                                                    <span class="pull-right badge badge-info">+12</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="btn btn-xs btn-primary fa fa-user"></i>
                                                Bob just signed up as an editor ...
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <span class="pull-left">
                                                        <i class="btn btn-xs no-hover btn-success fa fa-shopping-cart"></i>
                                                        New Orders
                                                    </span>
                                                    <span class="pull-right badge badge-success">+8</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <div class="clearfix">
                                                    <span class="pull-left">
                                                        <i class="btn btn-xs no-hover btn-info fa fa-twitter"></i>
                                                        Followers
                                                    </span>
                                                    <span class="pull-right badge badge-info">+11</span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="dropdown-footer">
                                    <a href="#">
                                        See all notifications
                                        <i class="ace-icon fa fa-arrow-right"></i>
                                    </a>
                                </li> -->
                        </ul>
                    </li>

                    <li class="green dropdown-modal">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="ace-icon fa fa-envelope icon-animated-vertical"></i>
                            <span class="badge badge-success">5</span>
                        </a>

                        <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
                            <li class="dropdown-header">
                                <i class="ace-icon fa fa-envelope-o"></i>
                                5 Messages
                            </li>
                        </ul>
                    </li>


                    <li class="light-blue dropdown-modal">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            <img class="nav-user-photo" src="{{ url('/upload/'.Auth::user()->foto) }}" height="90%" />
                            <span class="user-info">
                                <small>Bem - Vindo,</small>
                                {{Auth::user()['name']}}
                            </span>

                            <i class="ace-icon fa fa-caret-down"></i>
                        </a>

                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <li>
                                <a href="#">
                                    <i class="ace-icon fa fa-cog"></i>
                                    Definições
                                </a>
                            </li>

                            <li>
                                @if(Auth::guard('web')->check())
                                @role('Empresa')
                                <a href="{{url('empresa/perfil')}}">
                                    <i class="ace-icon fa fa-user"></i>
                                    Perfil
                                </a>
                                @endrole
                                @endif

                                @if(Auth::guard('empresa')->check())
                                @role('Funcionario')
                                <a href="{{url('empresa/perfil')}}">
                                    <i class="ace-icon fa fa-user"></i>
                                    Perfil
                                </a>
                                @endrole
                                @endif
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a href="{{ url('/logout') }}" class="" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="ace-icon fa fa-power-off"></i>
                                    Sair
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: block;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{url('logout')}}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            <i class="ace-icon fa fa-power-off"></i>
                            Sair
                        </a>
                    </li>
                </ul>
            </div>
        </div><!-- /.navbar-container -->
    </div>

    <div class="main-container ace-save-state" id="main-container">
        <script type="text/javascript">
            try {
                ace.settings.loadState('main-container')
            } catch (e) {}
        </script>

        <a href="#" class="menu-toggler invisible" id="menu-toggler" data-target="#sidebar"></a>

        <div id="sidebar" class="sidebar responsive-min ace-save-state compact" data-sidebar="true" data-sidebar-scroll="true" data-sidebar-hover="true">
            <script type="text/javascript">
                try {
                    ace.settings.loadState('sidebar')
                } catch (e) {}
            </script>

            <!-- <div class="sidebar-shortcuts" id="sidebar-shortcuts">
                    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                        <button class="btn btn-success">
                            <i class="ace-icon fa fa-signal"></i>
                        </button>

                        <button class="btn btn-info">
                            <i class="ace-icon fa fa-pencil"></i>
                        </button>

                        <button class="btn btn-warning">
                            <i class="ace-icon fa fa-users"></i>
                        </button>

                        <button class="btn btn-danger">
                            <i class="ace-icon fa fa-cogs"></i>
                        </button>
                    </div>

                    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                        <span class="btn btn-success"></span>

                        <span class="btn btn-info"></span>

                        <span class="btn btn-warning"></span>

                        <span class="btn btn-danger"></span>
                    </div>
                </div> -->
            <!--/.sidebar-shortcuts -->

            <!-- EMPRESA -->
            @if(Auth::guard('web')->check())
            @role('Empresa')
            <ul class="nav nav-list">
                <li class="">
                    <span class="">
                        <a href="" data-target=".actualizar_logomarca{{Auth::user()->id}}" data-toggle="modal">
                            <img class="nav-user-photo" src="{{ url('/upload/'.Auth::user()->foto)}}" style="max-width: 100%; border-radius: 100px; height: 72px; width: 75px; left: 14px; position: sticky" />
                        </a>
                    </span>
                </li>

                <li class="">
                    <a href="{{url('home')}}">
                        <i class="menu-icon glyphicon glyphicon-home"></i>
                        <span class="menu-text"> Inicio </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class=""></li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-list-alt"></i>
                        <span class="menu-text">Cadastros</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">

                        <li class="hover">
                            <a href="{{url('/empresa/gestores')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Gestor
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/fornecedores')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Fornecedores
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/fabricantes')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Fabricantes
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/armazens')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Armazens
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/bancos')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Bancos
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/marcas')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Marcas
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/categorias')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Categorias
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/unidades')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Unidade de Medida
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/classes')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Classe de bem
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('/empresa/formapagamento')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Forma de Pagamento
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                @can('gerir utilizadores')
                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-users"></i>
                        <span class="menu-text">
                            Utilizadores
                        </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        @can('gerir utilizadores')
                        <li class="hover">
                            <a href="{{url('empresa/usuarios')}}">
                                <i class="menu-icon fa fa-table"></i>
                                Listar Utilizadores
                            </a>
                            <b class="arrow"></b>
                        </li>
                        @endcan

                        @can('gerir permissões')
                        <li class="hover">
                            <a href="{{url('empresa/funcoes-permissoes')}}">
                                <i class="menu-icon fa fa-plus"></i>
                                Funções & Permissões
                            </a>

                            <b class="arrow"></b>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon icofont-group bigger-150" style="font-size: 15pt"></i>
                        <span class="menu-text"> Clentes </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="{{url('empresa/clientes')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Listar Clientes
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="">
                                <i class="menu-icon fa fa-list"></i>
                                Conta corrente
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-product-hunt"></i>
                        <span class="menu-text">Produtos </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="{{url('empresa/produtos')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Listar Produtos
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/produtos/stock')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Ánalise de Stock
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/produtos-vendidos')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Listar produtos vendidos
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon glyphicon glyphicon-barcode"></i>
                        <span class="menu-text"> Facturação </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="{{url('empresa/facturacao/criar')}}">
                                <i class="menu-icon glyphicon glyphicon-barcode"></i>
                                Facturação
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/facturas')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Listar facturas
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/listarFacturaProformas')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Converter Factura Proforma
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon glyphicon glyphicon-barcode"></i>
                        <span class="menu-text"> Operações </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">

                        <li class="hover">
                            <a href="{{url('empresa/facturas/operacao-deposito-recibo')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Déposito de valores - recibos </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/notacredito')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Nota de Crédito
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/notadebito')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Nota de Débito
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/facturas/rectificacao')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Rectificação de documentos
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/facturas/anulacao')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Anulação de documentos
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/produto/actualizar-stock')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Actualizar estoque </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/produtos/entrada')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Entrada de produtos
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/produtos/transferencia')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Transferência de produtos
                            </a>
                            <b class="arrow"></b>
                        </li>

                    </ul>
                </li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa icofont-bank"></i>
                        <span class="menu-text">IVA</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="{{url('empresa/taxaIva')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Definir Taxas do IVA
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/motivoIva')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Definir Motivos de Isenção
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/gerarSaft')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Gerar o ficheiro SAFT
                            </a>

                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa icofont-bank"></i>
                        <span class="menu-text">Vendas</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="{{url('empresa/vendas-produtos')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Lista de vendas por produtos
                            </a>

                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/vendas-diaria')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Venda diária
                            </a>

                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/vendas-mensal')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Vendas mensal
                            </a>

                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa icofont-settings-alt"></i>
                        <span class="menu-text">Configurações</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="{{url('empresa/configuracao')}}">
                                <i class="menu-icon fa fa-pencil" style="color: white;"></i>
                                Configurar minha conta
                            </a>

                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
                <!-- <li class="hover">
                    <a href="{{url('empresa/fechoCaixa')}}">
                    <i class="menu-icon glyphicon glyphicon-time"></i>
                        <span class="menu-text">Fecho de caixa</span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                </li> -->
            </ul><!-- /.nav-list -->
            @endrole
            @endif


            <!-- FUNCIONARIOS EMPRESA -->
            @if(Auth::guard('empresa')->check())
            @role('Funcionario')
            <ul class="nav nav-list">
                <li class="">
                    <span class="">
                        <a href="" data-target="actualizar_logomarca{{Auth::user()->id}}" data-toggle="modal">
                            <img class="nav-user-photo" src="{{ url('/upload/'.Auth::user()->empresa->logotipo)}}" style="max-width: 100%; border-radius: 100px; height: 72px; width: 75px; left: 14px; position: sticky" />
                        </a>
                    </span>
                </li>

                <li class="">
                    <a href="{{url('empresa/home')}}">
                        <i class="menu-icon glyphicon glyphicon-home"></i>
                        <span class="menu-text"> Inicio </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class=""></li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-list-alt"></i>
                        <span class="menu-text">Cadastros</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        @role('Empresa')
                        <li class="hover">
                            <a href="{{url('/empresa/gestores')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Gestor
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/fornecedores')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Fornecedores
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/fabricantes')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Fabricantes
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/armazens')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Armazens
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/bancos')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Bancos
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('/empresa/formapagamento')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Forma de Pagamento
                            </a>
                            <b class="arrow"></b>
                        </li>
                        @endrole

                        <li class="hover">
                            <a href="{{url('empresa/marcas')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Marcas
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/categorias')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Categorias
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/unidades')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Unidade de Medida
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/classes')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Classe de bem
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                @can('gerir utilizadores')
                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-users"></i>
                        <span class="menu-text">
                            Utilizadores
                        </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        @can('gerir utilizadores')
                        <li class="hover">
                            <a href="{{url('empresa/usuarios')}}">
                                <i class="menu-icon fa fa-table"></i>
                                Listar Utilizadores
                            </a>
                            <b class="arrow"></b>
                        </li>
                        @endcan


                        @can('gerir permissões')
                        <li class="hover">
                            <a href="{{url('empresa/funcoes-permissoes')}}">
                                <i class="menu-icon fa fa-plus"></i>
                                Funções & Permissões
                            </a>

                            <b class="arrow"></b>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon icofont-group bigger-150" style="font-size: 15pt"></i>
                        <span class="menu-text"> Clentes </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="{{url('empresa/clientes')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Listar Clientes
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="">
                                <i class="menu-icon fa fa-list"></i>
                                Conta corrente
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-product-hunt"></i>
                        <span class="menu-text">Produtos</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="{{url('empresa/produtos')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Listar Produtos
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{url('empresa/produtos/stock')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Ánalise de Stock
                            </a>
                            <b class="arrow"></b>
                        </li>

                    </ul>
                </li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon glyphicon glyphicon-barcode"></i>
                        <span class="menu-text"> Facturação </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="{{url('empresa/facturacao/criar')}}">
                                <i class="menu-icon glyphicon glyphicon-barcode"></i>
                                Facturação
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/facturas')}}">
                                <i class="menu-icon fa fa-list"></i>
                                Listar facturas
                            </a>
                            <b class="arrow"></b>
                        </li>

                    </ul>
                </li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon glyphicon glyphicon-barcode"></i>
                        <span class="menu-text"> Operações </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="{{url('empresa/facturas/operacao-deposito-recibo')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Déposito de valores - recibos </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/notacredito')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Nota de Crédito
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/notadebito')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Nota de Débito
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/facturas/rectificacao')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Rectificação de documentos
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{url('empresa/facturas/anulacao')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Anulação de documentos
                            </a>
                            <b class="arrow"></b>
                        </li>

                    </ul>

                    {{-- <b class="arrow"></b>

                            <ul class="submenu">
                                <li class="hover">
                                    <a href="{{url('empresa/facturas/operacao-deposito-recibo')}}">
                    <i class="menu-icon glyphicon glyphicon-barcode"></i>
                    Déposito de Valores - recibos
                    </a>
                    <b class="arrow"></b>
                </li>

            </ul> --}}
            </li>

            <li class="hover">
                <a href="#" class="dropdown-toggle" style="color: #ffffff">
                    <i class="menu-icon fa icofont-bank"></i>
                    <span class="menu-text">Vendas</span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="hover">
                        <a href="{{url('empresa/vendas-produtos')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Lista de vendas por produtos
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li class="hover">
                        <a href="{{url('empresa/vendas-diaria')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Venda diária
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li class="hover">
                        <a href="{{url('empresa/vendas-mensal')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Vendas mensal
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>

            @role('Empresa')
            <li class="hover">
                <a href="#" class="dropdown-toggle" style="color: #ffffff">
                    <i class="menu-icon fa icofont-bank"></i>
                    <span class="menu-text">IVA</span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="hover">
                        <a href="{{url('empresa/taxaIva')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Definir Taxas do IVA
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="hover">
                        <a href="{{url('empresa/motivoIva')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Definir Motivos de Isenção
                        </a>
                        <b class="arrow"></b>
                    </li>


                    <li class="hover">
                        <a href="{{url('empresa/motivoIva')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                            Gerar o ficheiro SAFT
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
            @endrole
            </ul><!-- /.nav-list -->
            @endrole
            @endif


            <!--  MODAL MUDAR O LOGOMARCA  -->
            <div id="bs-modal-lg" class="modal fade actualizar_logomarca{{Auth::user()->id}}">
                <div class="modal-dialog modal-lg" style="width: 400px">
                    <div class="modal-content">
                        <div class="modal-header text-center red" id="logomarca-header">
                            <button type="button" class="close white bolder" data-dismiss="modal">×</button>
                            <h4 class="smaller white"><i class="ace-icon fa fa-pencil bigger-150 white"></i> Alterar Logomarca</h4>
                        </div>
                        <div class="modal-body" style="padding: 0px; position: relative;">
                            <div class="row">
                                <div class="space-6"></div>
                                <div class="">
                                    <div id="" class="row">
                                        <div class="col-sm-offset-1 col-sm-10">
                                            <form method='post' action='{{url('/update_logomarca')}}/{{Auth::user()->id}}' enctype="multipart/form-data" class="form-horizontal">
                                                {{ csrf_field() }}
                                                <div id="user-profile-" class="user-profile row">
                                                    <div class="tabbable">
                                                        <div class="tab-content profile-edit-tab-content">
                                                            <div id="edit-basic" class="tab-pane in active">
                                                                <h4 class="header blue bolder smaller">Logomarca</h4>

                                                                <div class="row">
                                                                    <div class="col-md-11">
                                                                        <div class="file-upload-wrapper">
                                                                            <input type="file" name="logotipo" accept="image/*" id="id-input-file-4" class="file-upload" required />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="clearfix form-actions">
                                                        <div class="col-md-offset-1 col-md-10">
                                                            &nbsp; &nbsp;
                                                            <button class="btn btn-success bigger-150" id="logomarca-butom" type="submit" style="border-radius: 14px;">
                                                                <i class="ace-icon fa fa-check bigger-120"></i>
                                                                Salvar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.row -->
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
            <!--/ MODAL MUDAR O LOGOMARCA -->

            <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
                <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
            </div>

            <div class="sidebar-toggle sidebar-expand" id="sidebar-expand">
                <i class="ace-icon fa fa-angle-double-right" data-icon1="ace-icon fa fa-angle-double-right" data-icon2="ace-icon fa fa-angle-double-left"></i>
            </div>
        </div>

        <div class="main-content">
            <div class="main-content-inner">
                <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                    <div class="nav-search col-lg-4" id="nav-search">
                        <form class="form-search" action='{!!url("pesquisar")!!}' method="get">
                            {!! csrf_field() !!}
                            <span class="input-icon">
                                <input type="text" placeholder="Buscar..." class="nav-search-input" name="texto" value="" id="validation-form" autocomplete="off" style="width: 150%;" required="" />
                                <i class="ace-icon fa fa-search nav-search-icon"></i>
                            </span>
                        </form>
                    </div><!-- /.nav-search -->
                </div>

                <div class="page-content">
                    <div class="ace-settings-container" id="ace-settings-container">
                        <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                            <i class="ace-icon fa fa-cog bigger-130"></i>
                        </div>

                        <div class="ace-settings-box clearfix" id="ace-settings-box">
                            <div class="pull-left width-50">
                                <div class="ace-settings-item">
                                    <div class="pull-left">
                                        <select id="skin-colorpicker" class="hide">
                                            <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                                            <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                                            <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                                            <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                                        </select>
                                    </div>
                                    <span>&nbsp; Choose Skin</span>
                                </div>

                                <div class="ace-settings-item">
                                    <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-navbar" autocomplete="off" />
                                    <label class="lbl" for="ace-settings-navbar"> Fixed Navbar</label>
                                </div>

                                <div class="ace-settings-item">
                                    <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-sidebar" autocomplete="off" />
                                    <label class="lbl" for="ace-settings-sidebar"> Fixed Sidebar</label>
                                </div>

                                <div class="ace-settings-item">
                                    <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-breadcrumbs" autocomplete="off" />
                                    <label class="lbl" for="ace-settings-breadcrumbs"> Fixed Breadcrumbs</label>
                                </div>

                                <div class="ace-settings-item">
                                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" autocomplete="off" />
                                    <label class="lbl" for="ace-settings-rtl"> Right To Left (rtl)</label>
                                </div>

                                <div class="ace-settings-item">
                                    <input type="checkbox" class="ace ace-checkbox-2 ace-save-state" id="ace-settings-add-container" autocomplete="off" />
                                    <label class="lbl" for="ace-settings-add-container">
                                        Inside
                                        <b>.container</b>
                                    </label>
                                </div>
                            </div><!-- /.pull-left -->

                            <div class="pull-left width-50">
                                <div class="ace-settings-item">
                                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover" autocomplete="off" />
                                    <label class="lbl" for="ace-settings-hover"> Submenu on Hover</label>
                                </div>

                                <div class="ace-settings-item">
                                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact" autocomplete="off" />
                                    <label class="lbl" for="ace-settings-compact"> Compact Sidebar</label>
                                </div>

                                <div class="ace-settings-item">
                                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight" autocomplete="off" />
                                    <label class="lbl" for="ace-settings-highlight"> Alt. Active Item</label>
                                </div>
                            </div><!-- /.pull-left -->
                        </div><!-- /.ace-settings-box -->
                    </div><!-- /.ace-settings-container -->

                    <div class="content-wrapper">
                        <div id="app">
                            @yield('content')
                        </div>
                    </div>

                </div><!-- /.page-content -->
            </div>
        </div><!-- /.main-content -->

        <div class="footer">
            <div class="footer-inner">
                <div class="footer-content">
                    <span class="bigger-120">
                        <a href="#" class="text-primary">&copy; <?php echo date('Y') ?><span class="bolder" style=""> Mutue negócios. Todos os direitos reservados</span></a>
                    </span>
                    &nbsp; &nbsp;
                </div>
            </div>
        </div>

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
    </div><!-- /.main-container -->


    <!-- Script VUE.JS-->
    <script src="{{asset('js/app.js')}}"></script>

    <!-- Script do qual dependem todas as funcionalidades do template, como toda a funcionalidade dos menus e o estilo de vários inputs -->
    <script src="{{asset('assets/js/jquery-1.11.3.min.js')}}"></script><!-- script principal-->
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/ace-elements.min.js')}}"></script>
    <script src="{{asset('assets/js/ace.min.js')}}"></script>


    <!-- COLLAPSE BOOTSTRAP -->
    <script src="{{ asset('assets/js/jquery-ui.min.js')}}"></script>

    <!-- ==================================================================================== -->

    <!-- SCRIPT PARA FORMULÁRIOS DE REGISTO, COM TODOS ELEMENTOS NECESSÁRIOS-->
    <!-- Scripts diferentes tipos de inputs adicionais para o formulário -->
    <script src="{{ asset('assets/js/jquery-ui.custom.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.ui.touch-punch.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.gritter.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootbox.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.easypiechart.min.js')}}"></script>
    <!-- {{-- <script src="{{ asset('assets/js/bootstrap-datepicker.min.js')}}"></script> --}} -->
    <script src="{{ asset('assets/js/jquery.hotkeys.index.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap-wysiwyg.min.js')}}"></script>
    <!-- <script src="{{ asset('assets/js/select2.min.js')}}"></script> -->
    <script src="{{ asset('assets/js/spinbox.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap-editable.min.js')}}"></script>
    <script src="{{ asset('assets/js/ace-editable.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.maskedinput.min.js')}}"></script>

    <script src="{{ asset('assets/js/chosen.jquery.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap-timepicker.min.js')}}"></script>
    <script src="{{ asset('assets/js/moment.min.js')}}"></script>
    <script src="{{ asset('assets/js/daterangepicker.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap-colorpicker.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.knob.min.js')}}"></script>
    <script src="{{ asset('assets/js/autosize.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.inputlimiter.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap-tag.min.js')}}"></script>
    <script src="{{ asset('assets/js/dropzone.min.js')}}"></script>

    <!--Scripts para validação em tempo real do formulário -->
    <script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>
    <!-- ========================================================================================= -->


    <!-- Script para tabelas Simples & Dinâmica(Para listagem dos dados) -->
    <script src="{{ asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('assets/js/buttons.flash.min.js')}}"></script>
    <script src="{{ asset('assets/js/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('assets/js/buttons.print.min.js')}}"></script>
    <script src="{{ asset('assets/js/buttons.colVis.min.js')}}"></script>
    <script src="{{ asset('assets/js/dataTables.select.min.js')}}"></script>
    <!-- ========================================================================================= -->

    <!-- Css para Galerias de Imagem de Fundo de qualquer registo -->
    <script src="{{ asset('assets/js/jquery.colorbox.min.js')}}"></script>
    <!-- ========================================================================================= -->

    <!-- Script de formulário por etapa ou Wizard com validação vinda de um outro templete -->
    <!--        <script type="text/javascript" src="{{ asset('assets/js/_jquery-steps.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/_parsley.js')}}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/_wizard.js')}}"></script>-->
    <!-- ========================================================================================= -->

    <!-- Script para modelos de licença -->
    <script src="{{ asset('assets/js/holder.min.js')}}"></script>

    <!--INICIO DO SCRIPT PARA MANDAR INFORMAÇÕES NO COMPONENT VUE-->
    <script type="text/javascript">
        window.baseUrl = "{{config('app.url', 'http://localhost:8000')}}";
        window.Laravel = {
            !!json_encode([
                'csrfToken' => csrf_token(),

                //'user' => Auth::user(),
                'roles' => Auth::user()->roles,
                'user' => [
                    'authenticated' => auth() - > check(),
                    'id' => auth() - > check() ? auth() - > user() - > id : null,
                    'nome' => auth() - > check() ? auth() - > user() - > name : null,
                    'email' => auth() - > check() ? auth() - > user() - > email : null,
                ],
                'user' => Auth::user(),
            ]) !!
        };
    </script>
    <!--FIM DO SCRIPT PARA MANDAR INFORMAÇÕES NO COMPONENT VUE-->

    <!-- Script para abrir páginas laterais para facturação -->
    <script type="text/javascript">
        jQuery(function($) {
            $('.modal.aside').ace_aside();
            $('#aside-inside-modal').addClass('aside').ace_aside({
                container: '#my-modal > .modal-dialog'
            });

            $(document).one('ajaxloadstart.page', function(e) {
                //in ajax mode, remove before leaving page
                $('.modal.aside').remove();
                $(window).off('.aside')
            });
        })
    </script>
    <!--Fim do Script para abrir páginas laterais para facturação -->

    <!-- Script para solicitação de factura e compra de licença -->
    <script type="text/javascript">
        jQuery(function($) {
            //COLLAPSE
            //jquery accordion
            $("#accordion").accordion({
                collapsible: true,
                heightStyle: "content",
                animate: 250,
                header: ".accordion-header"
            }).sortable({
                axis: "y",
                handle: ".accordion-header",
                stop: function(event, ui) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.children(".accordion-header").triggerHandler("focusout");
                }
            });
            //FIM

            //data for tree element
            var category = {
                'for-sale': {
                    text: 'For Sale',
                    type: 'folder'
                },
                'vehicles': {
                    text: 'Vehicles',
                    type: 'item'
                },
                'rentals': {
                    text: 'Rentals',
                    type: 'item'
                },
                'real-estate': {
                    text: 'Real Estate',
                    type: 'item'
                },
                'pets': {
                    text: 'Pets',
                    type: 'item'
                },
                'tickets': {
                    text: 'Tickets',
                    type: 'item'
                }
            }

            var dataSource1 = function(options, callback) {
                var $data = null
                if (!("text" in options) && !("type" in options)) {
                    $data = category; //the root tree
                    callback({
                        data: $data
                    });
                    return;
                } else if ("type" in options && options.type == "folder") {
                    if ("additionalParameters" in options && "children" in options.additionalParameters)
                        $data = options.additionalParameters.children || {};
                    else
                        $data = {} //no data
                }

                callback({
                    data: $data
                })
            }

            ////////////////////
            //show different search page
            $('#toggle-result-page .btn').on('click', function(e) {
                var target = $(this).find('input[type=radio]');
                var which = parseInt(target.val());
                $('.search-page').parent().addClass('hide');
                $('#search-page-' + which).parent().removeClass('hide');
            });
        });
    </script>
    <!--Fim do Script para solicitação de factura e compra de licença -->

    <!--INICIO DO SCRIPT PARA GALERIA DE IMAGENS-->
    <script type="text/javascript">
        jQuery(function($) {
            var $overflow = '';
            var colorbox_params = {
                rel: 'colorbox',
                reposition: true,
                scalePhotos: true,
                scrolling: false,
                previous: '<i class="ace-icon fa fa-arrow-left"></i>',
                next: '<i class="ace-icon fa fa-arrow-right"></i>',
                close: '&times;',
                current: '{current} of {total}',
                maxWidth: '105%',
                maxHeight: '105%',
                onOpen: function() {
                    $overflow = document.body.style.overflow;
                    document.body.style.overflow = 'hidden';
                },
                onClosed: function() {
                    document.body.style.overflow = $overflow;
                },
                onComplete: function() {
                    $.colorbox.resize();
                }
            };

            $('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
            $("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>"); //let's add a custom loading icon

            $(document).one('ajaxloadstart.page', function(e) {
                $('#colorbox, #cboxOverlay').remove();
            });
        })
    </script>

    <!-- WIZARD & VALIDAÇÕES -->
    <script type="text/javascript">
        $(document).ready(function() {

            $('#validation-form').validate({
                rules: {

                    name: {
                        required: true,
                        minlength: 6,
                        maxlength: 255
                    },

                    username: {
                        required: true,
                        minlength: 8,
                        maxlength: 30
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    password2: {
                        required: true,
                        minlength: 5,
                        equalTo: "#password"
                    },

                    descricao: {
                        required: true
                    },

                    bi: {
                        required: true
                    },

                    phone: {
                        required: true,
                        phone: 'required'
                    },
                    url: {
                        required: true,
                        url: true
                    },
                    comment: {
                        required: true
                    },
                    state: {
                        required: true
                    },
                    platform: {
                        required: true
                    },
                    subscription: {
                        required: true
                    },
                    gender: {
                        required: true,
                    },
                    agree: {
                        required: true,
                    }
                },

                messages: {
                    polo_id: {
                        required: "Este Campo é Obrigatório, Por favor preencha-o.",
                        email: "Por favor, introduza um email válido."
                    },

                    descricao: {
                        required: "Este Campo é Obrigatório, Por favor preencha-o.",
                    },

                    password: {
                        required: "Por favor especifique uma palavra pass.",
                        minlength: "Por favor especifique uma palavra pass segura."
                    },

                    password_confirmed: {
                        required: "<span style='color: red; font-weight: bold'>O campo confirmação da senha é obrigatório, preencha-o por favor.</span>",
                        rangelength: "<span style='color: red; font-weight: bold'>A senha deve conter no mínimo 6 à 20 caracteres</span>",
                        equalTo: "<span style='color: red; font-weight: bold'>As senhas não correspondem</span>"
                    },

                    name: {
                        required: "Este Campo é Obrigatório, Por favor preencha-o.",
                        minlength: "Nome de utilizador muitissimo curo, deve ter pelo menos 8 caracteres ou mais",
                        maxlength: "Nome de utilizador muitissimo grande, deve ter apenas 255 caracteres ou menos",
                    },

                    username: {
                        required: "Este Campo é Obrigatório, Por favor preencha-o.",
                        minlength: "Nome de utilizador muitissimo curo, deve ter pelo menos 8 caracteres ou mais",
                        maxlength: "Nome de utilizador muitissimo grande, deve ter apenas 30 caracteres ou menos",
                    },

                    state: "Por favor escolha um estado",
                    subscription: "Por favor escolha uma das opções da lista",
                    gender: "Por favor escolha o gênero",
                    agree: "Por favor aceite a nossa política"
                },
            });
        });

        jQuery(function($) {

            $('[data-rel=tooltip]').tooltip();

            // $('.select2').css('width','100%').select2({allowClear:true})
            // .on('change', function(){
            //         $(this).closest('form').validate().element($(this));
            // });


            var $validation = false;
            $('#fuelux-wizard-container').ace_wizard({
                    //step: 2 //optional argument. wizard will jump to step "2" at first
                    //buttons: '.wizard-actions:eq(0)'
                })
                .on('actionclicked.fu.wizard', function(e, info) {
                    if (info.step == 1 && $validation) {
                        if (!$('#validation-form').valid())
                            e.preventDefault();
                    }
                })
                //.on('changed.fu.wizard', function() {
                //})
                .on('finished.fu.wizard', function(e) {
                    document.getElementById('validation-form').submit({
                        //                              bootbox.dialog({
                        message: "Obrigado! Sua informação foi salva com sucesso!",
                        buttons: {
                            "success": {
                                "label": "OK",
                                "className": "btn-sm btn-primary"
                            }
                        }
                    });
                }).on('stepclick.fu.wizard', function(e) {
                    //e.preventDefault();//this will prevent clicking and selecting steps
                });

            //hide or show the other form which requires validation
            //this is for demo only, you usullay want just one form in your application
            $('#skip-validation').removeAttr('checked').on('click', function() {
                $validation = this.checked;
                if (this.checked) {
                    $('#sample-form').hide();
                    $('#validation-form').removeClass('hide');
                } else {
                    $('#validation-form').addClass('hide');
                    $('#sample-form').show();
                }
            })


            $.mask.definitions['~'] = '[+-]';
            $('#phone').mask('999999999');

            jQuery.validator.addMethod("phone", function(value, element) {
                return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{3}( x\d{1,6})?$/.test(value);
            }, "Introduza um número de telefone válido.");

            $('.validation-form').validate({
                errorElement: 'div',
                errorClass: 'help-block',
                focusInvalid: false,
                ignore: "",

                highlight: function(e) {
                    $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
                },

                success: function(e) {
                    $(e).closest('.form-group').removeClass('has-error'); //.addClass('has-info');
                    $(e).remove();
                },

                errorPlacement: function(error, element) {
                    if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                        var controls = element.closest('div[class*="col-"]');
                        if (controls.find(':checkbox,:radio').length > 1) controls.append(error);
                        else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                    }
                    // else if(element.is('.select2')) {
                    //         error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                    // }
                    else if (element.is('.chosen-select')) {
                        error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                    } else error.insertAfter(element.parent());
                },
            });


            $('#modal-wizard-container').ace_wizard();
            $('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');

            $(document).one('ajaxloadstart.page', function(e) {
                //in ajax mode, remove remaining elements before leaving page
                //$('[class*=select2]').remove();
            });
        })
    </script><!-- / WIZARD & VALIDAÇÕES -->

    <!--ESCONDER E TORNAR VÍSIVEL) -->
    <script type="text/javascript">
        jQuery(function($) {
            /* SCRIPT PARA OCULTAR OU EXIBIR QUANDO FAZ UM CHEKBOX*/
            /* Script para o Borderaux e Talão de Pagamento*/
            $('#borderaux').removeAttr('checked').on('click', function() {
                if (this.checked) {
                    $('#numero_talao').removeClass('hide');
                    $('#borderaux_marca').removeClass('hide');
                } else {
                    $('#numero_talao').addClass('hide');
                    $('#borderaux_marca').addClass('hide');
                }
            })

        });
    </script>
    <!--ESCONDER E TORNAR VÍSIVEL) -->


    <!-- SCRIPT PARA UPLOAD DE IMAGEM DROP E OUTROS INPUTS DE FORMULÁRIOS-->
    <script type="text/javascript">
        jQuery(function($) {
            $('#id-disable-check').on('click', function() {
                var inp = $('#form-input-readonly').get(0);
                if (inp.hasAttribute('disabled')) {
                    inp.setAttribute('readonly', 'true');
                    inp.removeAttribute('disabled');
                    inp.value = "This text field is readonly!";
                } else {
                    inp.setAttribute('disabled', 'disabled');
                    inp.removeAttribute('readonly');
                    inp.value = "This text field is disabled!";
                }
            });


            if (!ace.vars['touch']) {
                $('.chosen-select').chosen({
                    allow_single_deselect: true
                });
                //resize the chosen on window resize

                $(window)
                    .off('resize.chosen')
                    .on('resize.chosen', function() {
                        $('.chosen-select').each(function() {
                            var $this = $(this);
                            $this.next().css({
                                'width': $this.parent().width()
                            });
                        })
                    }).trigger('resize.chosen');
                //resize chosen on sidebar collapse/expand
                $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
                    if (event_name != 'sidebar_collapsed') return;
                    $('.chosen-select').each(function() {
                        var $this = $(this);
                        $this.next().css({
                            'width': $this.parent().width()
                        });
                    })
                });


                $('#chosen-multiple-style .btn').on('click', function(e) {
                    var target = $(this).find('input[type=radio]');
                    var which = parseInt(target.val());
                    if (which == 2) $('#form-field-select-4').addClass('tag-input-style');
                    else $('#form-field-select-4').removeClass('tag-input-style');
                });
            }


            $('[data-rel=tooltip]').tooltip({
                container: 'body'
            });
            $('[data-rel=popover]').popover({
                container: 'body'
            });

            autosize($('textarea[class*=autosize]'));

            $('textarea.limited').inputlimiter({
                remText: '%n character%s remaining...',
                limitText: 'max allowed : %n.'
            });

            $.mask.definitions['~'] = '[+-]';
            $('.input-mask-date').mask('99/99/9999');
            $('.input-mask-phone').mask('999999999');
            $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
            $(".input-mask-product").mask("a*-999-a999", {
                placeholder: " ",
                completed: function() {
                    alert("You typed the following: " + this.val());
                }
            });



            $("#input-size-slider").css('width', '200px').slider({
                value: 1,
                range: "min",
                min: 1,
                max: 8,
                step: 1,
                slide: function(event, ui) {
                    var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
                    var val = parseInt(ui.value);
                    $('#form-field-4').attr('class', sizing[val]).attr('placeholder', '.' + sizing[val]);
                }
            });

            $("#input-span-slider").slider({
                value: 1,
                range: "min",
                min: 1,
                max: 12,
                step: 1,
                slide: function(event, ui) {
                    var val = parseInt(ui.value);
                    $('#form-field-5').attr('class', 'col-xs-' + val).val('.col-xs-' + val);
                }
            });

            //"jQuery UI Slider"
            //range slider tooltip example
            $("#slider-range").css('height', '200px').slider({
                orientation: "vertical",
                range: true,
                min: 0,
                max: 100,
                values: [17, 67],
                slide: function(event, ui) {
                    var val = ui.values[$(ui.handle).index() - 1] + "";

                    if (!ui.handle.firstChild) {
                        $("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>")
                            .prependTo(ui.handle);
                    }
                    $(ui.handle.firstChild).show().children().eq(1).text(val);
                }
            }).find('span.ui-slider-handle').on('blur', function() {
                $(this.firstChild).hide();
            });


            $("#slider-range-max").slider({
                range: "max",
                min: 1,
                max: 10,
                value: 2
            });

            $("#slider-eq > span").css({
                width: '90%',
                'float': 'left',
                margin: '15px'
            }).each(function() {
                // read initial values from markup and remove that
                var value = parseInt($(this).text(), 10);
                $(this).empty().slider({
                    value: value,
                    range: "min",
                    animate: true

                });
            });

            $("#slider-eq > span.ui-slider-purple").slider('disable'); //disable third item


            $('#id-input-file-1 , #id-input-file-2').ace_file_input({
                no_file: 'Nenhum ficheiro ...',
                btn_choose: 'Escolher',
                btn_change: 'Mudar',
                droppable: false,
                onchange: null,
                thumbnail: false //| true | large
            });


            $('#id-input-file-3').ace_file_input({
                style: 'well',
                btn_choose: 'Carregue seu arquivo aqui ou Clique para escolher',
                btn_change: null,
                no_icon: 'ace-icon fa fa-cloud-upload',
                droppable: true,
                thumbnail: 'large' //small | large | fit
                    ,
                preview_error: function(filename, error_code) {}

            }).on('change', function() {});

            //dynamically change allowed formats by changing allowExt && allowMime function
            $('#id-file-format').removeAttr('checked').on('change', function() {
                var whitelist_ext, whitelist_mime;
                var btn_choose
                var no_icon
                if (this.checked) {
                    btn_choose = "Carregue sua imagem aqui ou Clique para escolher";
                    no_icon = "ace-icon fa fa-picture-o";

                    whitelist_ext = ["jpeg", "jpg", "png", "gif", "bmp"];
                    whitelist_mime = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
                } else {
                    btn_choose = "Carregue seu arquivo aqui ou Clique para escolher";
                    no_icon = "ace-icon fa fa-cloud-upload";

                    whitelist_ext = null; //all extensions are acceptable
                    whitelist_mime = null; //all mimes are acceptable
                }
                var file_input = $('#id-input-file-3');
                file_input
                    .ace_file_input('update_settings', {
                        'btn_choose': btn_choose,
                        'no_icon': no_icon,
                        'allowExt': whitelist_ext,
                        'allowMime': whitelist_mime
                    })
                file_input.ace_file_input('reset_input');

                file_input
                    .off('file.error.ace')
                    .on('file.error.ace', function(e, info) {});
            });


            //======================================= id-input-file-3 ===================================================================
            $('#id-input-file-4').ace_file_input({
                style: 'well',
                btn_choose: 'Carregue seu arquivo aqui ou Clique para escolher',
                btn_change: null,
                no_icon: 'ace-icon fa fa-cloud-upload',
                droppable: true,
                thumbnail: 'large' //small | large | fit
                    ,
                preview_error: function(filename, error_code) {}

            }).on('change', function() {});

            //dynamically change allowed formats by changing allowExt && allowMime function
            $('#id-file-format').removeAttr('checked').on('change', function() {
                var whitelist_ext, whitelist_mime;
                var btn_choose
                var no_icon
                if (this.checked) {
                    btn_choose = "Carregue sua imagem aqui ou Clique para escolher";
                    no_icon = "ace-icon fa fa-picture-o";

                    whitelist_ext = ["jpeg", "jpg", "png", "gif", "bmp"];
                    whitelist_mime = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
                } else {
                    btn_choose = "Carregue seu arquivo aqui ou Clique para escolher";
                    no_icon = "ace-icon fa fa-cloud-upload";

                    whitelist_ext = null; //all extensions are acceptable
                    whitelist_mime = null; //all mimes are acceptable
                }
                var file_input = $('#id-input-file-4');
                file_input
                    .ace_file_input('update_settings', {
                        'btn_choose': btn_choose,
                        'no_icon': no_icon,
                        'allowExt': whitelist_ext,
                        'allowMime': whitelist_mime
                    })
                file_input.ace_file_input('reset_input');

                file_input
                    .off('file.error.ace')
                    .on('file.error.ace', function(e, info) {});
            });
            //======================================= id-input-file-4 ===================================================================

            $('#spinner1').ace_spinner({
                    value: 1,
                    min: 1,
                    max: 9999999999999999999999999999999999999999999999999999,
                    step: 1,
                    btn_up_class: 'btn-info',
                    btn_down_class: 'btn-info'
                })
                .closest('.ace-spinner')
                .on('changed.fu.spinbox', function() {
                    //console.log($('#spinner1').val())
                });
            $('#spinner2').ace_spinner({
                value: 1,
                min: 1,
                max: 9999999999999999999999999999999999999999999999999999,
                step: 1,
                touch_spinner: true,
                icon_up: 'ace-icon fa fa-caret-up bigger-120',
                icon_down: 'ace-icon fa fa-caret-down bigger-120'
            });
            $('#spinner3').ace_spinner({
                value: 1,
                min: 1,
                max: 9999999999999999999999999999999999999999999999999999,
                step: 1,
                on_sides: true,
                icon_up: 'ace-icon fa fa-plus bigger-110',
                icon_down: 'ace-icon fa fa-minus bigger-110',
                btn_up_class: 'btn-success',
                btn_down_class: 'btn-danger'
            });
            $('#spinner4').ace_spinner({
                value: 1,
                min: 1,
                max: 9999999999999999999999999999999999999999999999999999,
                step: 1,
                on_sides: true,
                icon_up: 'ace-icon fa fa-plus',
                icon_down: 'ace-icon fa fa-minus',
                btn_up_class: 'btn-purple',
                btn_down_class: 'btn-purple'
            });

            //datepicker plugin
            //link
            $('.date-picker').datepicker({
                    autoclose: true,
                    todayHighlight: true
                })
                //show datepicker when clicking on the icon
                .next().on(ace.click_event, function() {
                    $(this).prev().focus();
                });

            //or change it into a date range picker
            $('.input-daterange').datepicker({
                autoclose: true
            });


            //to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
            $('input[name=date-range-picker]').daterangepicker({
                    'applyClass': 'btn-sm btn-success',
                    'cancelClass': 'btn-sm btn-default',
                    locale: {
                        applyLabel: 'Apply',
                        cancelLabel: 'Cancel',
                    }
                })
                .prev().on(ace.click_event, function() {
                    $(this).next().focus();
                });


            $('#timepicker1').timepicker({
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false,
                disableFocus: true,
                icons: {
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down'
                }
            }).on('focus', function() {
                $('#timepicker1').timepicker('showWidget');
            }).next().on(ace.click_event, function() {
                $(this).prev().focus();
            });




            if (!ace.vars['old_ie']) $('#date-timepicker1').datetimepicker({
                //format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
                icons: {
                    time: 'fa fa-clock-o',
                    date: 'fa fa-calendar',
                    up: 'fa fa-chevron-up',
                    down: 'fa fa-chevron-down',
                    previous: 'fa fa-chevron-left',
                    next: 'fa fa-chevron-right',
                    today: 'fa fa-arrows ',
                    clear: 'fa fa-trash',
                    close: 'fa fa-times'
                }
            }).next().on(ace.click_event, function() {
                $(this).prev().focus();
            });


            $('#colorpicker1').colorpicker();
            //$('.colorpicker').last().css('z-index', 2000);//if colorpicker is inside a modal, its z-index should be higher than modal'safe

            $('#simple-colorpicker-1').ace_colorpicker();

            $(".knob").knob();


            var tag_input = $('#form-field-tags');
            try {
                tag_input.tag({
                    placeholder: tag_input.attr('placeholder'),
                    //enable typeahead by specifying the source array
                    source: ace.vars['US_STATES'], //defined in ace.js >> ace.enable_search_ahead
                })

                //programmatically add/remove a tag
                var $tag_obj = $('#form-field-tags').data('tag');
                $tag_obj.add('Programmatically Added');

                var index = $tag_obj.inValues('some tag');
                $tag_obj.remove(index);
            } catch (e) {
                //display a textarea for old IE, because it doesn't support this plugin or another one I tried!
                tag_input.after('<textarea id="' + tag_input.attr('id') + '" name="' + tag_input.attr('name') + '" rows="3">' + tag_input.val() + '</textarea>').remove();
                //autosize($('#form-field-tags'));
            }

            /////////
            $('#modal-form input[type=file]').ace_file_input({
                style: 'well',
                btn_choose: 'Carregue seu arquivo aqui ou Clique para escolher',
                btn_change: null,
                no_icon: 'ace-icon fa fa-cloud-upload',
                droppable: true,
                thumbnail: 'large'
            })

            //chosen plugin inside a modal will have a zero width because the select element is originally hidden
            //and its width cannot be determined.
            //so we set the width after modal is show
            $('#modal-form').on('shown.bs.modal', function() {
                if (!ace.vars['touch']) {
                    $(this).find('.chosen-container').each(function() {
                        $(this).find('a:first-child').css('width', '210px');
                        $(this).find('.chosen-drop').css('width', '210px');
                        $(this).find('.chosen-search input').css('width', '200px');
                    });
                }
            })

            $(document).one('ajaxloadstart.page', function(e) {
                autosize.destroy('textarea[class*=autosize]')

                $('.limiterBox,.autosizejs').remove();
                $('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
            });
        });
    </script><!-- FIM DO SCRIPT PARA UPLOAD DE IMAGEM DROP E OUTROS INPUTS DE FORMULÁRIOS-->

    <!-- INICO DO SCRIPT PARA TABELA DE LISTAGEM DE DADOS, SIMPLES & DINÂMICO-->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.tabela1').dataTable({
                "lengthMenu": [
                    [15, 20, 30, 50, 100, -1],
                    [15, 20, 30, 50, 100, "Todos"]
                ],
                "language": {
                    "emptyTable": "Sem dados disponíveis na tabela",
                    "info": "<span class='text-primary' style='font-size: 12pt; left: 8%;'>Mostrar de _START_ a _END_ Registos(_TOTAL_ no total)</span>",
                    "infoEmpty": "Mostrar de 0 a 0 registos",
                    "infoFiltered": "(Filtrada de _MAX_  registos)",
                    "lengthMenu": "<span class='text-primary' style='font-size:13pt; position: absolute; left: 1%;'>Mostrar _MENU_ </span>",
                    "search": "<span class='text-primary' style='font-size: 13pt; float: left; left:-25%; position: relative;'>Pesquisar</span>",
                    "zeroRecords": "<span style='color: red'>Nenhum registo correspondente encontrado</span>",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Último",
                        "previous": "« Anterior",
                        "next": "Próximo »",
                    }
                }
            });
        });

        jQuery(function($) {
            //initiate dataTables plugin
            var myTable = $('#dynamic-table')
                //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
                .DataTable({
                    bAutoWidth: false,
                    "aoColumns": [{
                            "bSortable": false
                        },
                        null, null, null, null, null,
                        {
                            "bSortable": false
                        }
                    ],
                    "aaSorting": [],

                    select: {
                        style: 'multi'
                    }
                });

            $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

            new $.fn.dataTable.Buttons(myTable, {
                buttons: [{
                        "extend": "colvis",
                        "text": "<i class='fa fa-search bigger-110 text-primary'></i> <span class='hidden'>Mostrar/Ocultar Colunas</span>",
                        "className": "btn btn-white btn-primary btn-bold",
                        columns: ':not(:first):not(:last)'
                    },
                    {
                        "extend": "copy",
                        "text": "<i class='fa fa-copy bigger-110 text-pink'></i> <span class='hidden'>Copiar para uma tabela</span>",
                        "className": "btn btn-white btn-primary btn-bold"
                    },
                    {
                        "extend": "csv",
                        "text": "<i class='fa fa-database bigger-110 text-orange' style='color: orange'></i> <span class='hidden'>Exportar para CSV</span>",
                        "className": "btn btn-white btn-primary btn-bold"
                    },
                    {
                        "extend": "excel",
                        "text": "<i class='fa fa-file-excel-o bigger-110 text-success' style='color: green'></i> <span class='hidden'>Exportar para Excel</span>",
                        "className": "btn btn-white btn-primary btn-bold"
                    },
                    {
                        "extend": "pdf",
                        "text": "<i class='fa fa-file-pdf-o bigger-110 text-danger' style='color: red'></i> <span class='hidden'>Exportar para PDF</span>",
                        "className": "btn btn-white btn-primary btn-bold"
                    },
                    {
                        "extend": "print",
                        "text": "<i class='fa fa-print bigger-110 text-default'></i> <span class='hidden'>Imprimir toda Tabela</span>",
                        "className": "btn btn-white btn-primary btn-bold",
                        autoPrint: false,
                        message: 'This print was produced using the Print button for DataTables'
                    }
                ]
            });
            myTable.buttons().container().appendTo($('.tableTools-container'));

            //style the message box
            var defaultCopyAction = myTable.button(1).action();
            myTable.button(1).action(function(e, dt, button, config) {
                defaultCopyAction(e, dt, button, config);
                $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
            });

            var defaultColvisAction = myTable.button(0).action();
            myTable.button(0).action(function(e, dt, button, config) {

                defaultColvisAction(e, dt, button, config);

                if ($('.dt-button-collection > .dropdown-menu').length == 0) {
                    $('.dt-button-collection')
                        .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
                        .find('a').attr('href', '#').wrap("<li />")
                }
                $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
            });

            ////

            setTimeout(function() {
                $($('.tableTools-container')).find('a.dt-button').each(function() {
                    var div = $(this).find(' > div').first();
                    if (div.length == 1) div.tooltip({
                        container: 'body',
                        title: div.parent().text()
                    });
                    else $(this).tooltip({
                        container: 'body',
                        title: $(this).text()
                    });
                });
            }, 500);


            //                    myTable.on( 'select', function ( e, dt, type, index ) {
            //                        if ( type === 'row' ) {
            //                            $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
            //                        }
            //                    } );
            //                    myTable.on( 'deselect', function ( e, dt, type, index ) {
            //                        if ( type === 'row' ) {
            //                            //COMENTEI PROPOSITADAMENTE
            //                            $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
            //                            $( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
            //                        }
            //                    } );

            /////////////////////////////////
            //table checkboxes
            $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

            //select/deselect all rows according to table header checkbox
            $('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function() {
                var th_checked = this.checked; //checkbox inside "TH" table header


                $('#dynamic-table').find('tbody > tr').each(function() {


                    var row = this;
                    if (th_checked) myTable.row(row).select();
                    else myTable.row(row).deselect();
                });
            });

            //select/deselect a row when the checkbox is checked/unchecked
            $('#dynamic-table').on('click', 'td input[type=checkbox]', function() {


                var row = $(this).closest('tr').get(0);
                if (this.checked) myTable.row(row).deselect();
                else myTable.row(row).select();
            });

            $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
                e.stopImmediatePropagation();
                e.stopPropagation();
                e.preventDefault();
            });

            //And for the first simple table, which doesn't have TableTools or dataTables
            //select/deselect all rows according to table header checkbox
            var active_class = 'active';
            $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function() {
                var th_checked = this.checked; //checkbox inside "TH" table header

                $(this).closest('table').find('tbody > tr').each(function() {
                    var row = this;
                    if (th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                    else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
                });
            });

            //select/deselect a row when the checkbox is checked/unchecked
            $('#simple-table').on('click', 'td input[type=checkbox]', function() {
                var $row = $(this).closest('tr');
                if ($row.is('.detail-row ')) return;
                if (this.checked) $row.addClass(active_class);
                else $row.removeClass(active_class);
            });

            /********************************/
            //add tooltip for small view action buttons in dropdown menu
            $('[data-rel="tooltip"]').tooltip({
                placement: tooltip_placement
            });

            //tooltip placement on right or left
            function tooltip_placement(context, source) {
                var $source = $(source);
                var $parent = $source.closest('table')
                var off1 = $parent.offset();
                var w1 = $parent.width();

                var off2 = $source.offset();
                //var w2 = $source.width();

                if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2)) return 'right';
                return 'left';
            }

            /***************/
            $('.show-details-btn').on('click', function(e) {
                e.preventDefault();
                $(this).closest('tr').next().toggleClass('open');
                $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
            });
            /***************/
        })
    </script><!-- FIM DO SCRIPT PARA TABELA DE LISTAGEM DE DADOS, SIMPLES & DINÂMICO-->

    <style type="text/css">
        #body {
            padding-right: 0px !important;
        }

        #btn-assina {
            left: 0%;
            border-radius: 15px;
            margin-left: 10px;
            margin-top: 0.1%;
            padding: 3px;
            position: relative;
        }

        .assinatura {
            padding: 0px;
            margin-bottom: 0px !important;
        }

        #botoes {
            left: 0%;
            border-radius: 15px;
            margin-top: 0.1%;
            padding: 6px 12px 6px 12px;
            position: relative;
            text-transform: uppercase
        }

        /* .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 35px;
            }
            .select2-container .select2-selection--single {
                height: 35px;
            } */

        .form-control {
            display: block;
            width: 100%;
            height: calc(2.25rem + 2px);
            /* padding: .375rem .75rem; */
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
        }

        .select2-container .select2-selection--single {
            height: 35px !important;
            padding: 4px !important;
        }

        .select2-container {
            width: 100% !important;

        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #444 !important;
        }

        .form-group.has-info input,
        .form-group.has-info select,
        .form-group.has-info textarea {
            color: #444 !important;
        }

        .vdpComponent.vdpWithInput#data_pago_banco>input {
            padding: 6px !important;
            width: 353px !important;
        }

        .error {
            color: red;
        }


        .modal-header#logomarca-header {
            padding: 15px;
            border-bottom: 1px solid #a72d2d;
            background-color: #b32932;
            color: white;
        }

        .btn-success#logomarca-butom,
        .btn-success#logomarca-butom.focus,
        .btn-success#logomarca-butom:focus {
            background-color: #47a447 !important;
            border-color: #47a447;
            padding: 0px 44px 0px 44px;
        }
    </style>
</body>

</html>
