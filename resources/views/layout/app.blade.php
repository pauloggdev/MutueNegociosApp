<?php

use App\Models\admin\Empresa;
use App\Models\empresa\Empresa_Cliente;
use Illuminate\Support\Facades\Auth;

if (Auth::guard('web')->check()) {
    $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
    $empresa = Empresa_Cliente::where('referencia', $referencia)->first();
} else {
    $empresa_id = Auth::user()->empresa_id;
    $empresa = Empresa_Cliente::where('id', $empresa_id)->first();
}

?>



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

    @yield('css_dashboard')

    <!-- bootstrap & fontawesome sem uso-->
    @yield('css_fontawesome')
    <!--  FIM -->

    <!-- ========================================================================================= -->
    <!-- text fonts sem uso-->
    @yield('css_fonts')
    <!-- --- fim -- -->
    <!-- ========================================================================================= -->

    <!-- Estilos Gerais das pÃ¡ginas -->
    <link rel="stylesheet" href="{{asset('assets/css/ace.min.css')}}" class="ace-main-stylesheet" id="main-ace-style" />
    <link rel="stylesheet" href="{{asset('assets/css/ace-skins.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/ace-rtl.min.css')}}" />
    <!-- ========================================================================================= -->

    <!-- Css para combobox com caixa de pesquisa, data e hora range, input do tipo number dinÃ¢mico e etc... sem uso-->
    @yield('css_combobox_pesquisa_data_hora')
    <!-- --- fim -- -->

    <!-- Css para collapse-->
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css')}}" />

    <!-- Css para Galerias de Imagem de Fundo de qualquer registo -->
    @yield('css_colorbox')

    <!-- ========================================================================================= -->

    <!-- ESTILOS CSS DE OUTROS TEMPLATES-->
    <!-- CSS do template Anzenta, para os contornos de alguns formulÃ¡rios-->
    <link rel="stylesheet" href="{{ asset('assets/plugin/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/plugin/css/style.css')}}" type="text/css">
    <!-- ========================================================================================= -->
    @livewireStyles
</head>

<!-- #0D47A1 !important, #174284 !important  #242424 -->

<body class="skin-1" id="body">
    <div id="navbar" class="navbar navbar-default ace-save-state">

        @if(!empty($alertaAtivacaoLicenca))
        @if($alertaAtivacaoLicenca['diasRestantes'] > 0)
        @component('empresa/components/AssineAgora', ['diasRestantes'=> $alertaAtivacaoLicenca['diasRestantes'], 'licencaGratis'=> $alertaAtivacaoLicenca['licencaGratis']]))
        @endcomponent
        @endif
        @if($alertaAtivacaoLicenca['diasRestantes'] === 0)
        @component('empresa/components/licencaExpirada')
        @endcomponent
        @endif
        @endif
        <div class="navbar-container ace-save-state" id="navbar-container">
            <div class="navbar-header pull-left">
                <a href="/empresa/home" class="navbar-brand">
                    <small>MUTUE-NEGÓCIOS</small>
                </a>
            </div>


            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">
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
                                <a href="/empresa/configuracao">
                                    <i class="ace-icon fa fa-cog"></i>
                                    Definições
                                </a>
                            </li>
                            <!-- <li>
                                <a href="/empresa/perfil">
                                    <i class="ace-icon fa fa-user"></i>
                                    Perfil
                                </a>
                            </li> -->
                            <li>
                                <a href="/empresa/usuario/perfil">
                                    <i class="ace-icon fa fa-user"></i>
                                    Perfil
                                </a>
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

            <div id="app_notification">
                <notificacao-component router="">
                    <notificacao-component />
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




            <ul class="nav nav-list">
                <li class="">
                    <span class="">
                        <a href="" data-target=".actualizar_logomarca{{Auth::user()->id}}" data-toggle="modal">
                            <img class="nav-user-photo" src="{{ url('/upload/'.$empresa->logotipo)}}" style="max-width: 100%; border-radius: 100px; height: 72px; width: 75px; left: 14px; position: sticky" />
                        </a>
                    </span>
                </li>

                <li class="">
                    <a href="/empresa/home">
                        <i class="menu-icon glyphicon glyphicon-home"></i>
                        <span class="menu-text"> INICIO </span>
                    </a>
                    <b class="arrow"></b>
                </li>

                <li class=""></li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-list-alt"></i>
                        <span class="menu-text">CADASTROS</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">

                        <!-- <li class="hover">
                            <a href="/empresa/gestores">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Gestor
                            </a>

                            <b class="arrow"></b>
                        </li> -->

                        <li class="hover">
                            <a href="/empresa/fornecedores">
                                <i class="menu-icon fa fa-caret-right"></i>
                                FORNECEDORES
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="/empresa/fabricantes">
                                <i class="menu-icon fa fa-caret-right"></i>
                                FABRICANTES
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="/empresa/armazens">
                                <i class="menu-icon fa fa-caret-right"></i>
                                ARMAZÉNS
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="bancos.index">
                                <i class="menu-icon fa fa-caret-right"></i>
                                BANCOS
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="/empresa/marcas">
                                <i class="menu-icon fa fa-caret-right"></i>
                                MARCAS
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="/empresa/categorias">
                                <i class="menu-icon fa fa-caret-right"></i>
                                CATEGORIAS
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{ route('unidadeMedidas.index')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                UNIDADE DE MEDIDA
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <!-- <li class="hover">
                            <a href="/empresa/classes">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Classe de bem
                            </a>
                            <b class="arrow"></b>
                        </li> -->

                        <li class="hover">
                            <a href="/empresa/formapagamento">
                                <i class="menu-icon fa fa-caret-right"></i>
                                FORMA DE PAGAMENTO
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-users"></i>
                        <span class="menu-text">
                            UTILIZADORES
                        </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="/empresa/usuarios">
                                <i class="menu-icon fa fa-list"></i>
                                LISTAR UTILIZADORES
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="{{ route('roles.index') }}">
                                <i class="menu-icon fa fa-plus"></i>
                                FUNÇÕES
                            </a>

                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="/empresa/permissoes">
                                <i class="menu-icon fa fa-plus"></i>
                                PERMISSÕES
                            </a>

                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-users"></i>
                        <span class="menu-text"> CLIENTES </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="/empresa/clientes">
                                <i class="menu-icon fa fa-list"></i>
                                LISTAR CLIENTES
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <!-- <li class="hover">
                            <a href="">
                                <i class="menu-icon fa fa-list"></i>
                                Conta corrente
                            </a>
                            <b class="arrow"></b>
                        </li> -->
                    </ul>
                </li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-opencart"></i>
                        <span class="menu-text">PRODUTOS</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="/empresa/produtos">
                                <i class="menu-icon fa fa-list"></i>
                                LISTAR PRODUTOS
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="/empresa/produtos-mais-vendidos">
                                <i class="menu-icon fa fa-list"></i>
                                LISTAR PRODUTOS MAIS VENDIDOS
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="/empresa/produtos/stock">
                                <i class="menu-icon fa fa-opencart"></i>
                                ÁNALISE DE STOCK
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <!-- <li class="hover">
                            <a href="/empresa/produtos-vendidos">
                                <i class="menu-icon fa fa-list"></i>
                                Listar produtos vendidos
                            </a>
                            <b class="arrow"></b>
                        </li> -->
                    </ul>
                </li>
                @if(Auth::user()->empresa_id == 156)
                <li class="">
                    <a href="{{route('empresa.vendas')}}">
                    <i class="menu-icon fa fa-opencart"></i>
                        <span class="menu-text"> VENDAS </span>
                    </a>
                    <b class="arrow"></b>
                </li>
                @endif()




                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-wpforms"></i>
                        <span class="menu-text"> FATURAÇÃO </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>



                    <b class="arrow"></b>

                    <ul class="submenu">
                    @if(Auth::user()->empresa_id != 156)
                        <li class="hover">
                            <a href="/empresa/facturacao/criar">
                                <i class="menu-icon fa fa-wpforms"></i>
                                FATURAÇÃO
                            </a>
                            <b class="arrow"></b>
                        </li>
                    @endif()
                        <li class="hover">
                            <a href="/empresa/facturas">
                                <i class="menu-icon fa fa-list"></i>
                                LISTAR FATURAS
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="/empresa/facturas-proformas">
                                <i class="menu-icon glyphicon glyphicon-refresh"></i>
                                CONVERTER FATURAS PROFORMA
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-tasks"></i>

                        <span class="menu-text"> OPERAÇÕES </span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">

                        <li class="hover">
                            <a href="{{ route('recibo.index')}}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                DEPÓSITO DE VALORES - RECIBOS</a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="/empresa/notacredito">
                                <i class="menu-icon fa fa-caret-right"></i>
                                NOTA DE CRÉDITO
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="/empresa/notadebito">
                                <i class="menu-icon fa fa-caret-right"></i>
                                NOTA DE DÉBITO
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{ route('notaCreditoRetificacaoDoc.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                RETIFICAÇÃO DE DOCUMENTOS
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{ route('notaCreditoAnulacaoDoc.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                ANULAÇÃO DE DOCUMENTOS
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="/empresa/produto/actualizar-stock">
                                <i class="menu-icon fa fa-caret-right"></i>
                                ATUALIZAR ESTOQUE</a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="/empresa/produtos/transferencia">
                                <i class="menu-icon fa fa-caret-right"></i>
                                TRANSFERÊNCIA DE PRODUTOS
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="/empresa/produtos/entrada">
                                <i class="menu-icon fa fa-caret-right"></i>
                                ENTRADA DE PRODUTOS
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="/empresa/pagamento/fornecedor">
                                <i class="menu-icon fa fa-caret-right"></i>
                                PAGAMENTO DE FORNECEDOR
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>


                @if(Auth::user()->hasRole('Super-Admin'))

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-shopping-cart"></i>
                        <span class="menu-text">VENDAS</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <!-- <li class="hover">
                            <a href="/empresa/vendas-produtos">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Lista de vendas por produtos
                            </a>

                            <b class="arrow"></b>
                        </li> -->

                        <li class="hover">
                            <a href="/empresa/vendas-diaria">
                                <i class="menu-icon fa fa-caret-right"></i>
                                VENDA DIÁRIA
                            </a>

                            <b class="arrow"></b>
                        </li>
                        <li class="hover">

                            <a href="/empresa/vendas-mensal">
                                <i class="menu-icon fa fa-caret-right"></i>
                                VENDAS MENSAL
                            </a>

                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="/empresa/relatorios-vendas">
                                <i class="menu-icon fa fa-caret-right"></i>
                                RELATÓRIOS DE VENDAS GERAIS
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
                @if(auth()->user()->empresa->venda_online == 'Y')
                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-shopping-cart"></i>
                        <span class="menu-text">VENDAS ONLINE</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                    <b class="arrow"></b>
                    <ul class="submenu">
                        <li class="hover">
                            <a href="/empresa/cupons-desconto">
                                <i class="menu-icon fa fa-caret-right"></i>
                                GERAR CUPON DESCONTO
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="/empresa/produtos/destaques">
                                <i class="menu-icon fa fa-caret-right"></i>
                                PRODUTOS DESTAQUES
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
                @endif
                @endif;
                <li class="hover">
                    <a href="/empresa/inventarios" style="color: #ffffff">
                        <i class="menu-icon glyphicon glyphicon-refresh"></i>
                        <span class="menu-text">INVENTÁRIOS</span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                </li>

                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-cog"></i>
                        <span class="menu-text">CONFIGURAÇÕES</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">

                        <li class="hover">
                            <a href="/empresa/configuracao">
                                <i class="menu-icon fa fa-pencil" style="color: white;"></i>
                                CONFIGURAR MINHA CONTA
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="/empresa/modelo-documentos">
                                <i class="menu-icon fa fa-list" style="color: white;"></i>
                                MODELO DOCUMENTOS
                            </a>
                            <b class="arrow"></b>
                        </li>

                        <li class="hover">

                            <a href="/empresa/definir-parametros">
                                <i class="menu-icon fa fa-pencil" style="color: white;"></i>
                                DEFINIR PARAMETROS
                            </a>

                            <b class="arrow"></b>
                        </li>

                    </ul>
                </li>
                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-list-alt"></i>
                        <span class="menu-text">LISTAGENS</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">

                            <a href="/empresa/minhas-licencas">
                                <i class="fa fa-list" aria-hidden="true"></i>
                                MINHAS LICENÇAS
                            </a>

                            <b class="arrow"></b>
                        </li>
                        <!-- <li class="hover">

                            <a href="/empresa/facturas-licencas">
                                <i class="fa fa-list" aria-hidden="true"></i>
                                Facturas de Licenças
                            </a>

                            <b class="arrow"></b>
                        </li>
                        <li class="hover">

                            <a href="/empresa/recibos-facturas-licenca">
                                <i class="fa fa-list" aria-hidden="true"></i>
                                Recibos Pagamento de Licenças
                            </a>

                            <b class="arrow"></b>
                        </li> -->
                        <li class="hover">

                            <!-- <a href="/empresa/movimento/diario">
                                <i class="fa fa-history" aria-hidden="true"></i>
                                Movimento diário
                            </a> -->

                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="{{route('relatorio.index')}}">
                        <i class="menu-icon fa fa-file-pdf-o"></i>
                        <span class="menu-text">RELATÓRIOS</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{route('fechoCaixa.index')}}">
                        <i class="menu-icon fa fa-file-pdf-o"></i>
                        <span class="menu-text">FECHO DE CAIXA</span>
                    </a>
                </li>
                <li class="">
                    <a href="{{route('centroCusto.index')}}">
                        <i class="menu-icon fa fa-shopping-basket"></i>
                        <span class="menu-text">CENTRO DE CUSTOS</span>
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-file-text"></i>
                        <span class="menu-text">IVA</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="/empresa/taxaIva">
                                <i class="menu-icon fa fa-caret-right"></i>
                                DEFINIR TAXAS DO IVA
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href="/empresa/motivoIva">
                                <i class="menu-icon fa fa-caret-right"></i>
                                MOTIVOS DE ISENÇÃO
                            </a>

                            <b class="arrow"></b>
                        </li>

                        <li class="hover">
                            <a href=" /empresa/gerarSaft">
                                <i class="menu-icon fa fa-caret-right"></i>
                                GERAR O FICHEIRO SAFT
                            </a>

                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="{{route('manual.index')}}">
                        <i class="menu-icon fa fa-download"></i>
                        <span class="menu-text">MANUAL UTILIZADOR</span>
                    </a>
                    <b class="arrow"></b>
                </li>
                <!-- <li class="hover">
                    <a href="{{url('empresa/fechoCaixa')}}">
                    <i class="menu-icon glyphicon glyphicon-time"></i>
                        <span class="menu-text">Fecho de caixa</span>
                        <b class="arrow fa fa-angle-down"></b>
                    </a>
                </li> -->
            </ul><!-- /.nav-list -->

            <!--  MODAL MUDAR O LOGOMARCA  -->
            <div id="bs-modal-lg" class="modal fade actualizar_logomarca{{Auth::user()->id}}">
                <div class="modal-dialog modal-lg" style="width: 400px">
                    <div class="modal-content">
                        <div class="modal-header text-center red" id="logomarca-header">
                            <button type="button" class="close white bolder" data-dismiss="modal"></button>
                            <h4 class="smaller white"><i class="ace-icon fa fa-pencil bigger-150 white"></i> Alterar Logomarca</h4>
                        </div>
                        <div class="modal-body" style="padding: 0px; position: relative;">
                            <div class="row">
                                <div class="space-6"></div>
                                <div class="">
                                    <div id="" class="row">
                                        <div class="col-sm-offset-1 col-sm-10">
                                            <form method='post' action='{{url('/empresa/update_logomarca')}}/{{$empresa->id}}' enctype="multipart/form-data" class="form-horizontal">
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
                <div class="page-content">

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

    <script type="text/javascript">
        window.Laravel = {!!json_encode(['user' => Auth::user() ? Auth::user() : null,'roles' => Auth::user()->roles, 'isSuperAdmin' => (Auth::user()->hasRole('Super-Admin') || Auth::user()->hasRole('Admin')),'isFuncionario' => Auth::user()->hasRole('Funcionario')])!!};
    </script>


    <!-- Script VUE.JS-->
    <script src="{{asset('js/app.js')}}"></script>


    <!-- Script do qual dependem todas as funcionalidades do template, como toda a funcionalidade dos menus e o estilo de vÃ¡rios inputs -->
    <!-- script principal-->
    <script src="{{asset('assets/js/jquery-1.11.3.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/ace-elements.min.js')}}"></script>
    <script src="{{asset('assets/js/ace.min.js')}}"></script>


    <!-- COLLAPSE BOOTSTRAP -->
    <script src="{{ asset('assets/js/jquery-ui.min.js')}}"></script>

    <!-- ==================================================================================== -->

    <!-- SCRIPT PARA FORMULÃRIOS DE REGISTO, COM TODOS ELEMENTOS NECESSÃRIOS-->
    <!-- Scripts diferentes tipos de inputs adicionais para o formulÃ¡rio-->
    @yield('js_input_formulario')
    <!-- --- FIM -- -->


    <!-- script de alterar foto template-->
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
    <!-- ---- FIM --- -->

    <!--Scripts para validaÃ§Ã£o em tempo real do formulÃ¡rio -->
    <script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>
    <!-- ========================================================================================= -->


    <!-- Script para tabelas Simples & DinÃ¢mica(Para listagem dos dados) -->
    @yield('js_tabela_simples_dinamico')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/js/dataTables.buttons.min.js')}}"></script>

    @yield('js_email_notificacao')

    <!-- Css para Galerias de Imagem de Fundo de qualquer registo -->
    <script src="{{ asset('assets/js/jquery.colorbox.min.js')}}"></script>
    <!-- ========================================================================================= -->


    <!-- Script para modelos de licenÃ§a -->
    <script src="{{ asset('assets/js/holder.min.js')}}"></script>







    <!--INICIO DO SCRIPT PARA MANDAR INFORMAÃ‡Ã•ES NO COMPONENT VUE-->
    <script type="text/javascript">
        window.baseUrl = "{{config('app.url', 'http://localhost:8000')}}";
        window.Laravel = {
            json_encode(['csrfToken'=>csrf_token(),
                //'user' => Auth::user(),
                'roles' => Auth::user()->roles,
                'user' => [
                    'authenticated'=>auth()->check(),
                    'id' => auth()->check() ? auth()->user()->id : null,
                    'nome' => auth()->check() ? auth()->user()->name : null,
                    'email' => auth()->check() ? auth()->user()->email : null,
                ],
                'user' => Auth::user(),
            ]);
        };
    </script>
    <!--FIM DO SCRIPT PARA MANDAR INFORMAÃ‡Ã•ES NO COMPONENT VUE-->

    <!-- Scripts para grÃ¡ficos estatisticos do dashboard -->
    @yield('js_dashboard')



    <!-- Script para abrir pÃ¡ginas laterais para facturaÃ§Ã£o -->
    @yield('js_modal_facturacao')
    <!--Fim do Script para abrir pÃ¡ginas laterais para facturaÃ§Ã£o -->

    <!-- Script para solicitaÃ§Ã£o de factura e compra de licenÃ§a -->
    @yield('js_solicitacao_factura_licenca')

    <!--Fim do Script para solicitaÃ§Ã£o de factura e compra de licenÃ§a -->

    <!--INICIO DO SCRIPT PARA GALERIA DE IMAGENS-->
    @yield('js_galeria_imagem')
    <!-- ---fim-- -->



    <!-- WIZARD & VALIDAÃ‡Ã•ES sem uso -->
    @yield('js_validacao')
    <!-- / fim WIZARD & VALIDAÃ‡Ã•ES -->

    <!--ESCONDER E TORNAR VÃSIVEL sem uso -->
    @yield('js_esconder_tornar_visivel')
    <!--ESCONDER E TORNAR VÃSIVEL) -->


    <!-- SCRIPT PARA UPLOAD DE IMAGEM DROP E OUTROS INPUTS DE FORMULÃRIOS-->

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
    </script>


    <!-- FIM DO SCRIPT PARA UPLOAD DE IMAGEM DROP E OUTROS INPUTS DE FORMULÃRIOS-->

    <!-- INICO DO SCRIPT PARA TABELA DE LISTAGEM DE DADOS, SIMPLES & DINÃ‚MICO-->

    <script type="text/javascript">
        $(document).ready(function() {
            $('.tabela1').dataTable({
                "lengthMenu": [
                    [15, 20, 30, 50, 100, -1],
                    [15, 20, 30, 50, 100, "Todos"]
                ],
                "language": {
                    "emptyTable": "Sem dados disponÃ­veis na tabela",
                    "info": "<span class='text-primary' style='font-size: 12pt; left: 8%;'>Mostrar de _START_ a _END_ Registos(_TOTAL_ no total)</span>",
                    "infoEmpty": "Mostrar de 0 a 0 registos",
                    "infoFiltered": "(Filtrada de _MAX_  registos)",
                    "lengthMenu": "<span class='text-primary' style='font-size:13pt; position: absolute; left: 1%;'>Mostrar _MENU_ </span>",
                    "search": "<span class='text-primary' style='font-size: 13pt; float: left; left:-25%; position: relative;'>Pesquisar</span>",
                    "zeroRecords": "<span style='color: red'>Nenhum registo correspondente encontrado</span>",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Ãšltimo",
                        "previous": "Anterior",
                        "next": "Proximo",
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
    </script><!-- FIM DO SCRIPT PARA TABELA DE LISTAGEM DE DADOS, SIMPLES & DINÃ‚MICO-->


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

@livewireScripts

</body>

</html>
