<?php

use App\Models\admin\Empresa;
use Illuminate\Support\Facades\Auth;

if (Auth::guard('web')->check()) {
    $empresa = Empresa::where('id', 1)->first();
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


    <!-- Estilos VUE.JS-->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{asset('css/app.css')}}">




    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/font-awesome/4.5.0/css/font-awesome.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/icofont/icofont.css')}}" />
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
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.custom.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-timepicker.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.min.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css')}}" />
    <!-- ========================================================================================= -->

    <!-- Css para Galerias de Imagem de Fundo de qualquer registo -->
    <link rel="stylesheet" href="{{ asset('assets/css/colorbox.min.css')}}" />
    <!-- ========================================================================================= -->

    <!-- ESTILOS CSS DE OUTROS TEMPLATES-->
    <!-- CSS do template Anzenta, para os contornos de alguns formulários-->
    <link rel="stylesheet" href="{{ asset('assets/plugin/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/plugin/css/style.css')}}" type="text/css">
    <!-- ========================================================================================= -->

    @livewireStyles
</head>
<!-- #0D47A1 !important, #174284 !important  #242424 -->

<body class="skin-1" id="body">
    <div id="navbar" class="navbar navbar-default ace-save-state">


        <div class="navbar-container ace-save-state" id="navbar-container">
            <div class="navbar-header pull-left">
                <a href="" class="navbar-brand">
                    <small>ADMIN</small>
                </a>
            </div>


            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">
                    <li class="light-blue dropdown-modal">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            <?php
                            if (auth()->user()->foto) { ?>
                                <img src="/upload/{{ auth()->user()->foto }}" height="90%" width="50px" class="img-circle elevation-2" alt="User Image">

                            <?php
                            } else { ?>
                                <img src=" {{ auth()->user()->photo }}" width="50px" class="img-circle elevation-2" alt="User Image">
                            <?php

                            }
                            ?>
                            <span class="user-info">
                                <small>Bemvindo</small>
                                {{auth()->user()->name}}
                            </span>

                            <i class="ace-icon fa fa-caret-down"></i>
                        </a>

                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">

                            <li>
                                <a href="/admin/utilizador/perfil">
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

            <!-- <div id="app_notification">
                <notificacao-component router="">
                    <notificacao-component />
            </div> -->
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
            <!-- EMPRESA -->

            <ul class="nav nav-list">
                <li class="">
                    <span class="">
                        <a href="" data-target="" data-toggle="modal">
                            <img class="nav-user-photo" src="/upload/<?= $empresa->logotipo ?>" style="max-width: 100%; border-radius: 100px; height: 72px; width: 75px; left: 14px; position: sticky" />
                        </a>
                    </span>
                </li>
                <li class="">
                    <a href="{{ route('admin.home') }}">
                        <i class="menu-icon glyphicon glyphicon-home"></i>
                        <span class="menu-text"> Inicio </span>
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="{{route('admin.users.index')}}">
                        <i class="menu-icon fa fa-user"></i>
                        <span class="menu-text"> Utilizadores </span>
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="{{route('admin.bancos.index')}}">
                        <i class="menu-icon fa fa-user"></i>
                        <span class="menu-text"> Bancos </span>
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="{{route('admin.clientes.index')}}">
                        <i class="menu-icon fa fa-users"></i>
                        <span class="menu-text"> Clientes </span>
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="{{route('admin.licencas.index')}}">
                        <i class="menu-icon fa fa-list-alt"></i>
                        <span class="menu-text"> Licenças </span>
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-list-alt"></i>
                        <span class="menu-text">Pedidos</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="{{ route('admin.pedidosLicencas.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Pedidos de licenças
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{ route('pedidosActivacaoUtilizador') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Pedidos activação utilizador
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-list-alt"></i>
                        <span class="menu-text">IVA</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="{{ route('taxaIva.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Taxa iva
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{ route('motivoIsencao.index') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Motivo isenção
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>
                <li class="hover">
                    <a href="#" class="dropdown-toggle" style="color: #ffffff">
                        <i class="menu-icon fa fa-list-alt"></i>
                        <span class="menu-text">Configurações</span>

                        <b class="arrow fa fa-angle-down"></b>
                    </a>

                    <b class="arrow"></b>

                    <ul class="submenu">
                        <li class="hover">
                            <a href="{{ route('backupBancoIndex') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Backup Banco
                            </a>
                            <b class="arrow"></b>
                        </li>
                        <li class="hover">
                            <a href="{{ route('configContaEmpresa') }}">
                                <i class="menu-icon fa fa-caret-right"></i>
                                Minha conta
                            </a>
                            <b class="arrow"></b>
                        </li>
                    </ul>
                </li>



            </ul><!-- /.nav-list -->
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

        <div class="footer">
            <div class="footer-inner">
                <div class="footer-content">
                    <span class="bigger-90" style="">
                        <a href="https://www.ramossoft.com/" class="text-primary">&copy; <?php echo date('Y') ?><span class="bolder" style=""> Mutue negócios. Todos os direitos reservados</span></a>
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
    <!-- ==================================================================================== -->

    <!-- SCRIPT PARA FORMULÁRIOS DE REGISTO, COM TODOS ELEMENTOS NECESSÁRIOS-->
    <!-- Scripts diferentes tipos de inputs adicionais para o formulário -->
    <script src="{{ asset('assets/js/jquery-ui.custom.min.js')}}"></script>
    <script src="{{ asset('assets/js/select2.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.maskedinput.min.js')}}"></script>

    <script src="{{ asset('assets/js/chosen.jquery.min.js')}}"></script>
    <script src="{{ asset('assets/js/autosize.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.inputlimiter.min.js')}}"></script>

    <!--Scripts para validação em tempo real do formulário -->
    <script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>
    <!-- ========================================================================================= -->

    <!-- Scripts para gráficos estatisticos do dashboard -->
    <script src="{{ asset('assets/js/jquery.easypiechart.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.sparkline.index.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.flot.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.flot.pie.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.flot.resize.min.js')}}"></script>


    <!-- Scripts para gráficos estatisticos do dashboard -->
    <script type="text/javascript">
        jQuery(function($) {
            $('.easy-pie-chart.percentage').each(function() {
                var $box = $(this).closest('.infobox');
                var barColor = $(this).data('color') || (!$box.hasClass('infobox-dark') ? $box.css('color') : 'rgba(255,255,255,0.95)');
                var trackColor = barColor == 'rgba(255,255,255,0.95)' ? 'rgba(255,255,255,0.25)' : '#E2E2E2';
                var size = parseInt($(this).data('size')) || 50;
                $(this).easyPieChart({
                    barColor: barColor,
                    trackColor: trackColor,
                    scaleColor: false,
                    lineCap: 'butt',
                    lineWidth: parseInt(size / 10),
                    animate: ace.vars['old_ie'] ? false : 1000,
                    size: size
                });
            })

            $('.sparkline').each(function() {
                var $box = $(this).closest('.infobox');
                var barColor = !$box.hasClass('infobox-dark') ? $box.css('color') : '#FFF';
                $(this).sparkline('html', {
                    tagValuesAttribute: 'data-values',
                    type: 'bar',
                    barColor: barColor,
                    chartRangeMin: $(this).data('min') || 0
                });
            });


            //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
            //but sometimes it brings up errors with normal resize event handlers
            $.resize.throttleWindow = false;

            var placeholder = $('#piechart-placeholder').css({
                'width': '90%',
                'min-height': '150px'
            });
            var data = [{
                    label: "Produtos mais vendidos",
                    data: 38.7,
                    color: "#68BC31"
                },
                {
                    label: "search engines",
                    data: 24.5,
                    color: "#2091CF"
                },
                {
                    label: "ad campaigns",
                    data: 8.2,
                    color: "#AF4E96"
                },
                {
                    label: "Produtos menos vendido",
                    data: 18.6,
                    color: "#DA5430"
                },
                {
                    label: "other",
                    data: 10,
                    color: "#FEE074"
                }
            ]

            function drawPieChart(placeholder, data, position) {
                $.plot(placeholder, data, {
                    series: {
                        pie: {
                            show: true,
                            tilt: 0.8,
                            highlight: {
                                opacity: 0.25
                            },
                            stroke: {
                                color: '#fff',
                                width: 2
                            },
                            startAngle: 2
                        }
                    },
                    legend: {
                        show: true,
                        position: position || "ne",
                        labelBoxBorderColor: null,
                        margin: [-30, 15]
                    },
                    grid: {
                        hoverable: true,
                        clickable: true
                    }
                })
            }
            drawPieChart(placeholder, data);

            /**
            we saved the drawing function and the data to redraw with different position later when switching to RTL mode dynamically
            so that's not needed actually.
            */
            placeholder.data('chart', data);
            placeholder.data('draw', drawPieChart);


            //pie chart tooltip example
            var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
            var previousPoint = null;

            placeholder.on('plothover', function(event, pos, item) {
                if (item) {
                    if (previousPoint != item.seriesIndex) {
                        previousPoint = item.seriesIndex;
                        var tip = item.series['label'] + " : " + item.series['percent'] + '%';
                        $tooltip.show().children(0).text(tip);
                    }
                    $tooltip.css({
                        top: pos.pageY + 10,
                        left: pos.pageX + 10
                    });
                } else {
                    $tooltip.hide();
                    previousPoint = null;
                }

            });

            /////////////////////////////////////
            $(document).one('ajaxloadstart.page', function(e) {
                $tooltip.remove();
            });




            var d1 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.5) {
                d1.push([i, Math.sin(i)]);
            }

            var d2 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.5) {
                d2.push([i, Math.cos(i)]);
            }

            var d3 = [];
            for (var i = 0; i < Math.PI * 2; i += 0.2) {
                d3.push([i, Math.tan(i)]);
            }


            var sales_charts = $('#sales-charts').css({
                'width': '100%',
                'height': '220px'
            });
            $.plot("#sales-charts", [{
                    label: "Domains",
                    data: d1
                },
                {
                    label: "Hosting",
                    data: d2
                },
                {
                    label: "Services",
                    data: d3
                }
            ], {
                hoverable: true,
                shadowSize: 0,
                series: {
                    lines: {
                        show: true
                    },
                    points: {
                        show: true
                    }
                },
                xaxis: {
                    tickLength: 0
                },
                yaxis: {
                    ticks: 10,
                    min: -2,
                    max: 2,
                    tickDecimals: 3
                },
                grid: {
                    backgroundColor: {
                        colors: ["#fff", "#fff"]
                    },
                    borderWidth: 1,
                    borderColor: '#555'
                }
            });


            $('#recent-box [data-rel="tooltip"]').tooltip({
                placement: tooltip_placement
            });

            function tooltip_placement(context, source) {
                var $source = $(source);
                var $parent = $source.closest('.tab-content')
                var off1 = $parent.offset();
                var w1 = $parent.width();

                var off2 = $source.offset();
                //var w2 = $source.width();

                if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2)) return 'right';
                return 'left';
            }


            $('.dialogs,.comments').ace_scroll({
                size: 300
            });


            //Android's default browser somehow is confused when tapping on label which will lead to dragging the task
            //so disable dragging when clicking on label
            var agent = navigator.userAgent.toLowerCase();
            if (ace.vars['touch'] && ace.vars['android']) {
                $('#tasks').on('touchstart', function(e) {
                    var li = $(e.target).closest('#tasks li');
                    if (li.length == 0) return;
                    var label = li.find('label.inline').get(0);
                    if (label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation();
                });
            }

            $('#tasks').sortable({
                opacity: 0.8,
                revert: true,
                forceHelperSize: true,
                placeholder: 'draggable-placeholder',
                forcePlaceholderSize: true,
                tolerance: 'pointer',
                stop: function(event, ui) {
                    //just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
                    $(ui.item).css('z-index', 'auto');
                }
            });
            $('#tasks').disableSelection();
            $('#tasks input:checkbox').removeAttr('checked').on('click', function() {
                if (this.checked) $(this).closest('li').addClass('selected');
                else $(this).closest('li').removeClass('selected');
            });


            //show the dropdowns on top or bottom depending on window height and menu position
            $('#task-tab .dropdown-hover').on('mouseenter', function(e) {
                var offset = $(this).offset();

                var $w = $(window)
                if (offset.top > $w.scrollTop() + $w.innerHeight() - 100)
                    $(this).addClass('dropup');
                else $(this).removeClass('dropup');
            });

        })
    </script>

    <!-- SCRIPT PARA UPLOAD DE IMAGEM DROP E OUTROS INPUTS DE FORMULÁRIOS-->
    <script type="text/javascript">
           window.addEventListener('mostrarImagemComprovativo', event => {
            var data = event.detail.data;
            let img = document.getElementById("imgComprovativo");
            img.setAttribute("src", data);

            })
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

            //======================================= id-input-file-4 ===================================================================
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
                    value: 0,
                    min: 0,
                    max: 200,
                    step: 10,
                    btn_up_class: 'btn-info',
                    btn_down_class: 'btn-info'
                })
                .closest('.ace-spinner')
                .on('changed.fu.spinbox', function() {
                    //console.log($('#spinner1').val())
                });
            $('#spinner2').ace_spinner({
                value: 0,
                min: 0,
                max: 10000,
                step: 100,
                touch_spinner: true,
                icon_up: 'ace-icon fa fa-caret-up bigger-110',
                icon_down: 'ace-icon fa fa-caret-down bigger-110'
            });
            $('#spinner3').ace_spinner({
                value: 0,
                min: 0,
                max: 9999999999999999999999999999999999999999999999999999,
                step: 1,
                on_sides: true,
                icon_up: 'ace-icon fa fa-plus bigger-110',
                icon_down: 'ace-icon fa fa-minus bigger-110',
                btn_up_class: 'btn-success',
                btn_down_class: 'btn-danger'
            });
            $('#spinner4').ace_spinner({
                value: 0,
                min: -100,
                max: 100,
                step: 10,
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

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 35px;
        }

        .select2-container .select2-selection--single {
            height: 35px;
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

        .text-incomplete {
            max-width: 159px;
            display: inline-block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            text-align: left;
            vertical-align: top;
            line-height: 26px;
            position: relative;
            top: 6px;
            font-size: 12pt;
        }

        .widget-box {
            padding: 0;
            box-shadow: none;
            margin: 3px 0;
            border: 2px solid #CCC;
        }

        .error {
            color: red;
        }
    </style>
    @livewireScripts
    <script src="{{asset('js/sweetalert.js')}}"></script>
    <x-livewire-alert::scripts />

    <script>

   window.addEventListener('printPdf', event => {

       var data = base64ToArrayBuffer(event.detail.data);
       var file = new Blob([data], {
           type: "application/pdf",
       });
       var fileURL = URL.createObjectURL(file);
       window.open(fileURL);
   })

   function base64ToArrayBuffer(base64) {
       var binary_string = window.atob(base64);
       var len = binary_string.length;
       var bytes = new Uint8Array(len);
       for (var i = 0; i < len; i++) {
           bytes[i] = binary_string.charCodeAt(i);
       }
       return bytes.buffer;
   }
   window.addEventListener('printLink', event => {
       var data = event.detail.data;
       // alert(data)
       window.open(data,'_blank' );
   })

   window.addEventListener('closeModal', event => {
       $('.closeModal').modal('hide');
   })
</script>
</body>

</html>
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
