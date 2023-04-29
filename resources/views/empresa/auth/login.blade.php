<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title style=" font-weight: bolder">{{ config('app.name', 'MUTUE - Login') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

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
        <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('favicon/android-icon-192x192.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('favicon/favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{asset('favicon/favicon-96x96.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('favicon/favicon-16x16.png')}}">
        <link rel="manifest" href="{{asset('favicon/manifest.json')}}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{asset('favicon/ms-icon-144x144.png')}}">
        <meta name="theme-color" content="#ffffff">
        {{-- FIM FAVICON  --}}


        <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/front_office/assets/img/favicon.ico')}}">

        <!-- CSS here -->
        <link rel="stylesheet" href="{{asset('assets/front_office/assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front_office/assets/css/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front_office/assets/css/slicknav.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front_office/assets/css/animate.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front_office/assets/css/magnific-popup.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front_office/assets/css/fontawesome-all.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front_office/assets/css/themify-icons.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front_office/assets/css/flaticon.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front_office/assets/css/slick.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front_office/assets/css/nice-select.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front_office/assets/css/style.css')}}">
    </head>
    <body>

        <header>
            <!-- Header Start -->
            <div class="header-area header-sticky">
                <div class="container-fluid">
                    <div class="row align-items-center">
                        <!-- Logo -->
                        <div class="col-xl-2 col-lg-1 col-md-1">
                            <div class="logo">
                            <a href="{{ url('/')}}"><img src="{{ asset('assets/images/logo1.jpg')}}" width="70" height="50" alt=""></a>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-8 col-md-6">
                            <!-- Main-menu -->
                            <div class="main-menu f-right d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a href="/">Home</a></li>
                                        <li><a href="services.html">Serviços</a></li>
                                        <li><a href="about.html">Sobre</a></li>
                                        <li><a href="caseStudies.html">Contacto</a></li>

                                        {{-- <li><a href="#">Faça Login</a>
                                            <ul class="submenu">
                                                <li><a href="contact.html">Contact</a></li>
                                                <li><a href="elements.html">Element</a></li>
                                                <li><a href="case_details.html">Case Details</a></li>
                                            </ul>
                                        </li> --}}
                                        <li><a href=" {{url('/cadastro-empresa')}}">Cadastra-se</a></li>

                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <!-- Header-btn -->
                            <div class="header-btn d-none d-lg-block f-right">
                                <a href="{{url('empresa-login')}}" class="btn header-btn" style="background-color: #bf0100; color:white">Login Empresa</a>
                            </div>
                        </div>
                        <!-- Mobile Menu -->
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header End -->
        </header>

        <!-- Contact form Start -->
        <div class="contact-form bg-height pb-160" data-background="{{ asset('assets/front_office/assets/img/testmonial/testi_bg.png')}}">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-8 offset-lg-3 offset-xl-3">
                        <div class="form-wrapper">
                            <!--Section Tittle  -->
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="section-tittle text-center mb-30">
                                        <h2>Credenciais</h2>
                                    </div>
                                </div>
                            </div>
                            <!--End Section Tittle  -->
                            <form method="POST" action="{{route('login-cliente')}}" id="contact-form" action="#" method="POST">
                                {{ csrf_field() }}
                                <div class="row">

                                    <div class="col-md-12{{ $errors->has('email') ? ' has-error' : '' }}">
                                        @if ($errors->has('email'))
                                        <span class="block input-icon input-icon-right">
                                            <strong style="color: red;">{{ $errors->first('email') }}</strong>
                                        </span>
                                       @endif
                                        <span class="block input-icon input-icon-right">
                                            <div class="form-box user-icon mb-30">
                                                <input type="text" name="email" placeholder="Email ou Telefone" id="inputEmail" value="{{ old('email')}}" required >
                                            </div>
                                        </span>
                                    </div>

                                    <div class="col-md-12{{ $errors->has('password') ? ' has-error' : '' }}">
                                        <span class="block input-icon input-icon-right">
                                            <div class="form-box user-icon mb-30">
                                                <input type="password" name="password" placeholder="Senha" id="inputPassword" value="{{ old('password')}}" required>
                                            </div>
                                        </span>
                                        @if ($errors->has('password'))
                                        <span class="help-block" style="color: red; font-weight: ">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                        @endif
                                    </div>

                                    @if (Route::has('password.reset'))
                                    <div class="col-md-12">
                                        <a href="{{ route('password.reset') }}">Esqueceu a senha?</a>
                                    </div>
                                    @endif

                                    <div class="col-lg-12">
                                        <div class="submit-info">
                                            <button class="submit-btn2" type="submit">Entrar</button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <!-- Footer Start-->
            <div class="footer-area footer-bg footer-padding">
                <div class="container">
                    <div class="row d-flex justify-content-between">
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-7">
                            <div class="single-footer-caption mb-50">
                                <!-- logo -->
                                <div class="footer-logo">
                                    <a href="index.html"><img src="{{ asset('assets/front_office/assets/img/logo/logo.png')}}" alt=""></a>
                                </div>
                                <div class="single-footer-caption mb-30">
                                    <div class="footer-tittle">
                                        <div class="footer-pera">
                                            <p>Seddo eiusmod tempor incididunt ut labore et dolore magna aliqua. consectetur pisicin elit, sed do eiusmod tempor.</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- footer social -->
                                <div class="footer-social">
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fas fa-globe"></i></a>
                                    <a href="#"><i class="fab fa-behance"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-5">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-tittle">
                                    <h4>Company</h4>
                                    <ul>
                                        <li><a href="{{ url('/welcome')}}">Home</a></li>
                                        <li><a href="about.html"> About Us</a></li>
                                        <li><a href="#">Browse Pets</a></li>
                                        <li><a href="blog.html">Blog</a></li>
                                        <li><a href="contact.html">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-3 col-sm-5">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-tittle">
                                    <h4>Services</h4>
                                    <ul>
                                        <li><a href="#">O’Connor Group</a></li>
                                        <li><a href="#">Our Business Model</a></li>
                                        <li><a href="#">Our Lawyers Team</a></li>
                                        <li><a href="#"> Most Recent Cases</a></li>
                                        <li><a href="#"> Hot Lawyers News</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-5 col-sm-5">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-tittle">
                                    <h4>Newsletter</h4>
                                    <div class="footer-pera footer-pera2">
                                        <p>For Lastest update Sign up here</p>
                                    </div>
                                    <!-- Form -->
                                    <div class="footer-form" >
                                        <div id="mc_embed_signup">
                                            <form target="_blank" action="https://spondonit.us12.list-manage.com/subscribe/post?u=1462626880ade1ac87bd9c93a&amp;id=92a4423d01"
                                                  method="get" class="subscribe_form relative mail_part">
                                                <input type="email" name="email" id="newsletter-form-email" placeholder="Email Address"
                                                       class="placeholder hide-on-focus" onfocus="this.placeholder = ''"
                                                       onblur="this.placeholder = ' Email Address '">
                                                <div class="submit-btn">
                                                    <button type="submit" name="submit" id="newsletter-submit"
                                                            class="email_icon newsletter-submit button-contactForm">

                                                        Subscribe <i class="ti-angle-double-right"></i></button>
                                                </div>
                                                <div class="mt-10 info"></div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer-bottom aera -->
            <div class="footer-bottom-area footer-bg">
                <div class="container">
                    <div class="footer-border">
                        <div class="row d-flex align-items-center">
                            <div class="col-xl-12">
                                <div class="footer-copy-right text-center">
                                    <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End-->
        </footer>


        <!-- All JS Custom Plugins Link Here here -->
        <script src="{{asset('assets/front_office/assets/js/vendor/modernizr-3.5.0.min.js')}}"></script>
        <!-- Jquery, Popper, Bootstrap -->
        <script src="{{asset('assets/front_office/assets/js/vendor/jquery-1.12.4.min.js')}}"></script>
        <script src="{{asset('assets/front_office/assets/js/jquery.validate.min.js')}}"></script>
        <script src="{{asset('assets/front_office/assets/js/popper.min.js')}}"></script>
        <script src="{{asset('assets/front_office/assets/js/bootstrap.min.js')}}"></script>
        <!-- Jquery Mobile Menu -->
        <script src="{{asset('assets/front_office/assets/js/jquery.slicknav.min.js')}}"></script>

        <!-- Jquery Slick , Owl-Carousel Plugins -->
        <script src="{{asset('assets/front_office/assets/js/owl.carousel.min.js')}}"></script>
        <script src="{{asset('assets/front_office/assets/js/slick.min.js')}}"></script>

        <!-- One Page, Animated-HeadLin -->
        <script src="{{asset('assets/front_office/assets/js/wow.min.js')}}"></script>
        <script src="{{asset('assets/front_office/assets/js/animated.headline.js')}}"></script>
        <script src="{{asset('assets/front_office/assets/js/jquery.magnific-popup.js')}}"></script>

        <!-- Scrollup, nice-select, sticky -->
        <script src="{{asset('assets/front_office/assets/js/jquery.scrollUp.min.js')}}"></script>
        <script src="{{asset('assets/front_office/assets/js/jquery.nice-select.min.js')}}"></script>
        <script src="{{asset('assets/front_office/assets/js/jquery.sticky.js')}}"></script>

        <!-- Jquery Plugins, main Jquery -->
        <script src="{{asset('assets/front_office/assets/js/plugins.js')}}"></script>
        <script src="{{asset('assets/front_office/assets/js/main.js')}}"></script>

         <script type="text/javascript">
            jQuery(function($) {
                $(document).on('click', '.toolbar a[data-target]', function(e) {
                    e.preventDefault();
                    var target = $(this).data('target');
                    $('.widget-box.visible').removeClass('visible');//hide others
                    $(target).addClass('visible');//show target
                });
            });

            //LOGAR NO SISTEMA
            $(document).ready(function(){

                $('#contact-form').validate({
                  rules:{
                        email:{
                          required: true
                        },
                        password:{
                          required: true
                        },
                        contrato:{
                          required: true,
                        }
                  },
                  messages:{
                        email:{
                          required: "<span style='color: red; font-weight: bold'>O campo email ou telefone é obrigatório, preencha-o por favor.</span>"
                        },
                        password:{
                          required: "<span style='color: red; font-weight: bold'>O campo senha é obrigatório, preencha-o por favor.</span>"
                        },
                        contrato:{
                          required: "<span style='color: red; font-weight: bold'>Deves aceitar os termos e condições</span>",
                        }
                  }
                });
            });

            //RECUPERAR SENHA
            $('#FormRecuperarSenha').validate({
                rules:{
                      email:{
                        required: true
                      },
                  },
                  messages:{
                      email:{
                        required: "<span style='color: red; font-weight: bold'>O campo email é obrigatório, preencha-o por favor.</span>"
                      },
                  }
            });

            //CRIAR CONTA DE UTILIZADOR
            $('#formularioRegister').validate({
                rules:{
                    name:{
                      required: true,
                      minlength: 6,
                      maxlength: 255
                    },
                    email:{
                      required: true,
                      email: true
                    },
                    telefone:{
                      required: true,
                      minlength: 9,
                      maxlength: 9
                    },
                    password:{
                      required: true,
                      rangelength: [6, 20]
                    },
                    password_confirmed:{
                      required: true,
                      rangelength: [6, 20],
                      equalTo: "#password"
                    },
                    contrato:{
                      required: true,
                    }
                },
                messages:{
                    name:{
                        required: " <span style='color: red; font-weight: bold'>O campo nome é obrigatório, preencha-o por favor.</span>",
                        minlength: " <span style='color: red; font-weight: bold'>Informe um nome válido, deve pelo menos conter um mínimo de 6 e um máximo de 255 caracteres</span>"
                    },
                    telefone:{
                        required:"<span style='color: red; font-weight: bold'>O campo telefone é obrigatório, preencha-o por favor.</span>",
                        minlength:"<span style='color: red; font-weight: bold'>Nome de Agente deve ter no mínimo 4 caracteres</span>",
                        maxlength:"<span style='color: red; font-weight: bold'>Nome de Agente deve ter no máximo 10 caracteres</span>"
                    },
                    email:{
                        required:"<span style='color: red; font-weight: bold'>O campo email é obrigatório, preencha-o por favor.</span>",
                        email:"<span style='color: red; font-weight: bold'>Informe um Email válido</span>"
                    },
                    password:{
                        required:"<span style='color: red; font-weight: bold'>O campo senha é obrigatório, preencha-o por favor.</span>",
                        rangelength:"<span style='color: red; font-weight: bold'>A senha deve conter no mínimo 6 à 20 caracteres</span>"
                    },
                    password_confirmed:{
                        required:"<span style='color: red; font-weight: bold'>O campo confirmação da senha é obrigatório, preencha-o por favor.</span>",
                        rangelength:"<span style='color: red; font-weight: bold'>A senha deve conter no mínimo 6 à 20 caracteres</span>",
                        equalTo:"<span style='color: red; font-weight: bold'>As senhas não correspondem</span>"
                    },
                     contrato:{
                        required:"<span style='color: red; font-weight: bold'>Deves aceitar os termos e as condições de utilizador</span>",
                    }
                }
            });
        </script>
    </body>
</html>
