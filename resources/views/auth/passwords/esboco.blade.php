<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title style=" font-weight: bolder">{{ config('app.name', 'Cadastra-se') }}</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSS here -->
        <link rel="stylesheet" href="{{asset('assets/front_office/assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front_office/assets/css/style.css')}}">         
        <link rel="stylesheet" href="{{asset('assets/front_office/assets/css/cadastro_empresa.css')}}">

        <link rel="stylesheet" href="{{asset('assets/css/ace2.min.css')}}" class="ace-main-stylesheet" />     
        <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css')}}" />

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
                                <a href="/"><img src="{{asset('assets/images/logo1.jpg')}}" width="70" height="50" alt=""></a>
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
                                        <li><a href=" {{url('/cadastro-empresa')}}">Cadastra-se</a></li>

                                    </ul>
                                </nav>
                            </div>
                        </div>             
                        <div class="col-xl-3 col-lg-3 col-md-3">
                            <!-- Header-btn -->
                            <div class="header-btn d-none d-lg-block f-right">
                                <a href="/empresa-login" class="btn header-btn" style="background-color: #bf0100; color:white">Faça Login</a>
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

        <!-- Testimonial Start -->        
        <div class="container-fluid" id="principal">
            @if (Session::has('success'))
            <div class="alert alert-success alert-success col-xs-12" style="left: 0%;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fa fa-check-square-o bigger-150"></i>{{ Session::get('success') }}</h5>
            </div>
            @endif

            @if (Session::has('errors'))
            <div class="alert alert-danger alert-danger col-xs-12" style="left: 0%;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <i class="icon fa fa-exclamation-triangle bigger-150"> Ups!!</i><br/> 
                <h5>
                    @foreach($errors->all() as $erro)
                    <span style="left: 2.5%; position: relative">{{$erro}}<br/></span>
                    @endforeach
                </h5>
            </div>
            @endif
            <div class="row">
                <div class="col-xl-12">
                    <div class="section-tittle text-center mb-70">
                        <h2>Cadastre sua empresa</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <form method="POST" action="{{ route('register') }}" id="validation-form"  enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <input type = 'hidden' name = 'remember_token' value = '{{Session::token()}}'>
                        <input type = 'hidden' name = 'role_name' value = 'Empresa'>
                        
                        <div class="form-row">
                            <div class="col-md-12">
                                <label for="id-input-file-3">Logotipo</label>
                                <div class="file-upload-wrapper">
                                    <input type="file" name="logotipo" accept="image/*" id="id-input-file-3" />
                                    @if ($errors->has('logotipo'))
                                    <span class="help-block" style="color: red; font-weight: bold">
                                        <strong>{{ $errors->first('logotipo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="col-md-4 mb-4">
                                <label for="name">Nome Empresa</label>
                                <input type="text" name="nome" value="{{ old('nome')}}" class="form-control" id="name" placeholder="Nome Completo" maxlength="255" required>
                                @if ($errors->has('nome'))
                                <span class="help-block" style="color: red; font-weight: ">
                                    <strong>{{ $errors->first('nome') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="email">Email</label>
                                <input type="email" name="email" value="{{ old('email')}}" class="form-control" id="email" placeholder="exemplo@gmail.com" maxlength="145" required>
                                @if ($errors->has('email'))
                                <span class="help-block" style="color: red; font-weight: ">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="nif">NIF</label>
                                <input type="text" name="nif" value="{{ old('nif')}}" class="form-control" id="nif" placeholder="Nº de identificação fiscal" maxlength="14" required>
                                @if ($errors->has('nif'))
                                <span class="help-block" style="color: red; font-weight: ">
                                    <strong>{{ $errors->first('nif') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-4">
                                <label for="phone">Contacto</label>
                                <input type="text" name="pessoal_Contacto" value="{{ old('pessoal_Contacto')}}" class="form-control" id="phone" placeholder="Telefone" maxlength="9" required>
                                @if ($errors->has('pessoal_Contacto'))
                                <span class="help-block" style="color: red; font-weight: ">
                                    <strong>{{ $errors->first('pessoal_Contacto') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="website">Web Site</label>
                                <input type="url" name="website" value="{{ old('website')}}" placeholder="www.exemplo.ao" class="form-control" id="website">
                                @if ($errors->has('website'))
                                <span class="help-block" style="color: red; font-weight:">
                                    <strong>{{ $errors->first('website') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="endereco">Endereço</label>
                                <input type="text" name="endereco" value="{{ old('endereco')}}" placeholder="Cidade, rua, número edificio" class="form-control" id="endereco" required>
                                @if ($errors->has('endereco'))
                                <span class="help-block" style="color: red; font-weight: ">
                                    <strong>{{ $errors->first('endereco') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-4 mb-4">
                                <label for="pais_id">País</label>
                                <select name="pais_id" class="form-control select2" data-placeholder="Selecione o País..." id="pais_id" required>
                                    <option value=""></option>
                                    @foreach ($paises as $pais)
                                        <option value="{{$pais->id}}" {{(old('pais_id')==$pais->id)? 'selected':''}}>{{$pais->designacao}}</option>  
                                    @endforeach
                                </select>
                                @if ($errors->has('pais_id'))
                                <span class="help-block" style="color: red; font-weight: ">
                                    <strong>{{ $errors->first('pais_id') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                            <div class="col-md-4 mb-4">
                                <label for="tipo_cliente_id">Tipo de Empresa</label>
                                <select class="form-control select2" name="tipo_cliente_id" data-placeholder="Selecione o tipo de empresa..." id="tipo_cliente_id" required>
                                    <option value=""></option>
                                    @foreach ($tipoEmpresa as $empresa)
                                        <option value="{{$empresa->id}}" {{(old('tipo_cliente_id')==$empresa->id)? 'selected':''}}>{{$empresa->designacao}}</option>  
                                    @endforeach
                                </select>
                                @if ($errors->has('tipo_cliente_id'))
                                <span class="help-block" style="color: red; font-weight: ">
                                    <strong>{{ $errors->first('tipo_cliente_id') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="tipo_cliente_id">Tipo de Regime</label>
                                <select class="form-control select2" name="tipo_regime_id" data-placeholder="Selecione o tipo de empresa..." id="tipo_cliente_id" required>
                                    <option value=""></option>
                                    @foreach ($tipoRegime as $regime)
                                        <option value="{{$regime->id}}" {{(old('tipo_regime_id')==$regime->id)? 'selected':''}}>{{$regime->Designacao}}</option>  
                                    @endforeach
                                </select>
                                @if ($errors->has('tipo_cliente_id'))
                                <span class="help-block" style="color: red; font-weight: ">
                                    <strong>{{ $errors->first('tipo_cliente_id') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>

        <footer>
            <!-- Footer Start-->
            <div class="footer-area footer-bg footer-padding">
                <div class="container">
                    <div class="row d-flex justify-content-between">

                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-5">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-tittle">
                                    <h4>Mutue Negócio</h4>
                                    <p>Seddo eiusmod tempor incididunt ut labore et dolore magna aliqua. consectetur pisicin elit, sed do eiusmod tempor.</p>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-2 col-md-2 col-sm-5">
                            <div class="single-footer-caption mb-50">
                                <div class="footer-tittle">
                                    <h4>Company</h4>
                                    <ul>
                                        <li><a href="index.html">Home</a></li>
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
                                                    <button type="submit" name="submit" id="newsletter-submit" class="email_icon newsletter-submit button-contactForm">
                                                        Subscribe <i class="ti-angle-double-right"></i>
                                                    </button>
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
                                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> Todos os direitos reservados</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer End-->
        </footer>

        
        <!-- SCRIPT PARA FORMULÁRIOS DE REGISTO, COM TODOS ELEMENTOS NECESSÁRIOS-->    
       <!-- Script do qual dependem todas as funcionalidades do template, como toda a funcionalidade dos menus e o estilo de vários inputs -->
       <script src="{{asset('assets/js/jquery-1.11.3.min.js')}}"></script><!-- script principal-->
       <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
       <!-- ==================================================================================== -->

       <!-- All JS Custom Plugins Link Here here -->
       <script src="{{asset('assets/front_office/assets/js/vendor/modernizr-3.5.0.min.js')}}"></script>
       <!-- ========================================================================================= -->

        <!-- SCRIPT PARA INPUTS E COM TODOS ELEMENTOS NECESSÁRIOS-->    
        <script src="{{asset('assets/js/ace-elements.min.js')}}"></script>
        <script src="{{asset('assets/js/ace.min.js')}}"></script>
 
        <!-- Scripts diferentes tipos de inputs adicionais para o formulário -->
        <script src="{{ asset('assets/js/jquery-ui.custom.min.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.maskedinput.min.js')}}"></script>
        <script src="{{ asset('assets/js/select2.min.js')}}"></script>
        
        <!--Scripts para validação em tempo real do formulário -->
        <script src="{{ asset('assets/js/jquery.validate.min.js')}}"></script>

        <script src="{{ asset('assets/js/chosen.jquery.min.js')}}"></script>
        <script src="{{ asset('assets/js/autosize.min.js')}}"></script>
        <script src="{{ asset('assets/js/jquery.inputlimiter.min.js')}}"></script>

        <!-- ========================================================================================= -->

        <!-- /VERIFICAR DADOS EXISTENTES -->
        <script type="text/javascript">
            
            var email = $("#email"); 
                email.blur(function() { 
                    $.ajax({ 
                        url: 'resister-empresa', 
                        type: 'POST', 
                        data:{"email" : email.val()}, 
                        success: function(data) { 
                        console.log(data); 
                        data = $.parseJSON(data); 
                        $("#resposta").text(data.email);
                    } 
                }); 
            }); 
        </script>
    <!-- ========================================================================================= -->
        
        <!-- / WIZARD & VALIDAÇÕES -->
        <script type="text/javascript">
            
            $(document).ready(function(){
                
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
                        
                        password_confirmed:{
                            required:"<span style='color: red; font-weight: bold'>O campo confirmação da senha é obrigatório, preencha-o por favor.</span>",
                            rangelength:"<span style='color: red; font-weight: bold'>A senha deve conter no mínimo 6 à 20 caracteres</span>",
                            equalTo:"<span style='color: red; font-weight: bold'>As senhas não correspondem</span>"
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

                $('.select2').css('width','100%').select2({allowClear:true})
                .on('change', function(){
                        $(this).closest('form').validate().element($(this));
                }); 


                var $validation = false;
                $('#fuelux-wizard-container').ace_wizard({
                        //step: 2 //optional argument. wizard will jump to step "2" at first
                        //buttons: '.wizard-actions:eq(0)'
                })
                .on('actionclicked.fu.wizard' , function(e, info){
                    if(info.step == 1 && $validation) {
                        if(!$('#validation-form').valid()) 
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
                                "success" : {
                                    "label" : "OK",
                                    "className" : "btn-sm btn-primary"
                                }
                            }
                        });
                }).on('stepclick.fu.wizard', function(e){
                        //e.preventDefault();//this will prevent clicking and selecting steps
                });

                //hide or show the other form which requires validation
                //this is for demo only, you usullay want just one form in your application
                $('#skip-validation').removeAttr('checked').on('click', function(){
                        $validation = this.checked; 
                        if(this.checked) {
                                $('#sample-form').hide();
                                $('#validation-form').removeClass('hide');
                        }
                        else {
                                $('#validation-form').addClass('hide');
                                $('#sample-form').show();
                        }
                })


                $.mask.definitions['~']='[+-]';
                $('#phone').mask('999999999');

                jQuery.validator.addMethod("phone", function (value, element) {
                        return this.optional(element) || /^\(\d{3}\) \d{3}\-\d{3}( x\d{1,6})?$/.test(value);
                }, "Introduza um número de telefone válido.");

                $('.validation-form').validate({
                        errorElement: 'div',
                        errorClass: 'help-block',
                        focusInvalid: false,
                        ignore: "",

                        highlight: function (e) {
                                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
                        },

                        success: function (e) {
                                $(e).closest('.form-group').removeClass('has-error');//.addClass('has-info');
                                $(e).remove();
                        },

                        errorPlacement: function (error, element) {
                            if(element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                                var controls = element.closest('div[class*="col-"]');
                                if(controls.find(':checkbox,:radio').length > 1) controls.append(error);
                                else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                            }
                            else if(element.is('.select2')) {
                                    error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                            }
                            else if(element.is('.chosen-select')) {
                                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                            }
                            else error.insertAfter(element.parent());
                        },
                });


                $('#modal-wizard-container').ace_wizard();
                $('#modal-wizard .wizard-actions .btn[data-dismiss=modal]').removeAttr('disabled');

                $(document).one('ajaxloadstart.page', function(e) {
                    //in ajax mode, remove remaining elements before leaving page
                    $('[class*=select2]').remove();
                });
            })

        </script><!-- / WIZARD & VALIDAÇÕES --> 
        <!-- ==================================================================================== -->

        <!-- SCRIPT PARA UPLOAD DE IMAGEM DROP E OUTROS INPUTS DE FORMULÁRIOS-->
            <script type="text/javascript">
                jQuery(function($) {
                    $('#id-disable-check').on('click', function() {
                        var inp = $('#form-input-readonly').get(0);
                        if(inp.hasAttribute('disabled')) {
                            inp.setAttribute('readonly' , 'true');
                            inp.removeAttribute('disabled');
                            inp.value="This text field is readonly!";
                        }
                        else {
                            inp.setAttribute('disabled' , 'disabled');
                            inp.removeAttribute('readonly');
                            inp.value="This text field is disabled!";
                        }
                    });


                    if(!ace.vars['touch']) {
                        $('.chosen-select').chosen({allow_single_deselect:true}); 
                        //resize the chosen on window resize

                        $(window)
                        .off('resize.chosen')
                        .on('resize.chosen', function() {
                                $('.chosen-select').each(function() {
                                        var $this = $(this);
                                        $this.next().css({'width': $this.parent().width()});
                                })
                        }).trigger('resize.chosen');
                        //resize chosen on sidebar collapse/expand
                        $(document).on('settings.ace.chosen', function(e, event_name, event_val) {
                                if(event_name != 'sidebar_collapsed') return;
                                $('.chosen-select').each(function() {
                                        var $this = $(this);
                                        $this.next().css({'width': $this.parent().width()});
                                })
                        });


                        $('#chosen-multiple-style .btn').on('click', function(e){
                                var target = $(this).find('input[type=radio]');
                                var which = parseInt(target.val());
                                if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
                                else $('#form-field-select-4').removeClass('tag-input-style');
                        });
                    }


                    $('[data-rel=tooltip]').tooltip({container:'body'});
                    $('[data-rel=popover]').popover({container:'body'});

                    autosize($('textarea[class*=autosize]'));

                    $('textarea.limited').inputlimiter({
                            remText: '%n character%s remaining...',
                            limitText: 'max allowed : %n.'
                    });

                    $.mask.definitions['~']='[+-]';
                    $('.input-mask-date').mask('99/99/9999');
                    $('.input-mask-phone').mask('999999999');
                    $('.input-mask-eyescript').mask('~9.99 ~9.99 999');
                    $(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});



                    $( "#input-size-slider" ).css('width','200px').slider({
                            value:1,
                            range: "min",
                            min: 1,
                            max: 8,
                            step: 1,
                            slide: function( event, ui ) {
                                    var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
                                    var val = parseInt(ui.value);
                                    $('#form-field-4').attr('class', sizing[val]).attr('placeholder', '.'+sizing[val]);
                            }
                    });

                    $( "#input-span-slider" ).slider({
                            value:1,
                            range: "min",
                            min: 1,
                            max: 12,
                            step: 1,
                            slide: function( event, ui ) {
                                    var val = parseInt(ui.value);
                                    $('#form-field-5').attr('class', 'col-xs-'+val).val('.col-xs-'+val);
                            }
                    });

                    //"jQuery UI Slider"
                    //range slider tooltip example
                    $( "#slider-range" ).css('height','200px').slider({
                            orientation: "vertical",
                            range: true,
                            min: 0,
                            max: 100,
                            values: [ 17, 67 ],
                            slide: function( event, ui ) {
                                    var val = ui.values[$(ui.handle).index()-1] + "";

                                    if( !ui.handle.firstChild ) {
                                            $("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>")
                                            .prependTo(ui.handle);
                                    }
                                    $(ui.handle.firstChild).show().children().eq(1).text(val);
                            }
                    }).find('span.ui-slider-handle').on('blur', function(){
                            $(this.firstChild).hide();
                    });


                    $( "#slider-range-max" ).slider({
                            range: "max",
                            min: 1,
                            max: 10,
                            value: 2
                    });

                    $( "#slider-eq > span" ).css({width:'90%', 'float':'left', margin:'15px'}).each(function() {
                            // read initial values from markup and remove that
                            var value = parseInt( $( this ).text(), 10 );
                            $( this ).empty().slider({
                                    value: value,
                                    range: "min",
                                    animate: true

                            });
                    });

                    $("#slider-eq > span.ui-slider-purple").slider('disable');//disable third item


                    $('#id-input-file-1 , #id-input-file-2').ace_file_input({
                            no_file:'Nenhum ficheiro ...',
                            btn_choose:'Escolher',
                            btn_change:'Mudar',
                            droppable:false,
                            onchange:null,
                            thumbnail:false //| true | large
                    });

                    $('#id-input-file-3').ace_file_input({
                            style: 'well',
                            btn_choose: 'Carregue seu arquivo',
                            btn_change: null,
                            no_icon: 'ace-icon fa fa-cloud-upload',
                            droppable: true,
                            thumbnail: 'large' //small | large | fit
                            ,
                            preview_error : function(filename, error_code) {
                            }

                    }).on('change', function(){
                    });

                    //dynamically change allowed formats by changing allowExt && allowMime function
                    $('#id-file-format').removeAttr('checked').on('change', function() {
                            var whitelist_ext, whitelist_mime;
                            var btn_choose
                            var no_icon
                            if(this.checked) {
                                    btn_choose = "Carregue sua imagem aqui ou Clique para escolher";
                                    no_icon = "ace-icon fa fa-picture-o";

                                    whitelist_ext = ["jpeg", "jpg", "png", "gif" , "bmp"];
                                    whitelist_mime = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
                            }
                            else {
                                    btn_choose = "Carregue seu arquivo aqui ou Clique para escolher";
                                    no_icon = "ace-icon fa fa-cloud-upload";

                                    whitelist_ext = null;//all extensions are acceptable
                                    whitelist_mime = null;//all mimes are acceptable
                            }
                            var file_input = $('#id-input-file-3');
                            file_input
                            .ace_file_input('update_settings',
                            {
                                    'btn_choose': btn_choose,
                                    'no_icon': no_icon,
                                    'allowExt': whitelist_ext,
                                    'allowMime': whitelist_mime
                            })
                            file_input.ace_file_input('reset_input');

                            file_input
                            .off('file.error.ace')
                            .on('file.error.ace', function(e, info) {
                            });
                    });

                    $('#spinner1').ace_spinner({value:0,min:0,max:200,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
                    .closest('.ace-spinner')
                    .on('changed.fu.spinbox', function(){
                            //console.log($('#spinner1').val())
                    }); 
                    $('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'ace-icon fa fa-caret-up bigger-110', icon_down:'ace-icon fa fa-caret-down bigger-110'});
                    $('#spinner3').ace_spinner({value:0,min:0,max:9999999999999999999999999999999999999999999999999999,step:1, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
                    $('#spinner4').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus', icon_down:'ace-icon fa fa-minus', btn_up_class:'btn-purple' , btn_down_class:'btn-purple'});

                    //datepicker plugin
                    //link
                    $('.date-picker').datepicker({
                            autoclose: true,
                            todayHighlight: true
                    })
                    //show datepicker when clicking on the icon
                    .next().on(ace.click_event, function(){
                            $(this).prev().focus();
                    });

                    //or change it into a date range picker
                    $('.input-daterange').datepicker({autoclose:true});


                    //to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
                    $('input[name=date-range-picker]').daterangepicker({
                            'applyClass' : 'btn-sm btn-success',
                            'cancelClass' : 'btn-sm btn-default',
                            locale: {
                                    applyLabel: 'Apply',
                                    cancelLabel: 'Cancel',
                            }
                    })
                    .prev().on(ace.click_event, function(){
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
                    }).next().on(ace.click_event, function(){
                            $(this).prev().focus();
                    });




                    if(!ace.vars['old_ie']) $('#date-timepicker1').datetimepicker({
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
                    }).next().on(ace.click_event, function(){
                            $(this).prev().focus();
                    });


                    $('#colorpicker1').colorpicker();
                    //$('.colorpicker').last().css('z-index', 2000);//if colorpicker is inside a modal, its z-index should be higher than modal'safe

                    $('#simple-colorpicker-1').ace_colorpicker();

                    $(".knob").knob();


                    var tag_input = $('#form-field-tags');
                    try{
                        tag_input.tag(
                        {
                                placeholder:tag_input.attr('placeholder'),
                                //enable typeahead by specifying the source array
                                source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
                        }
                        )

                        //programmatically add/remove a tag
                        var $tag_obj = $('#form-field-tags').data('tag');
                        $tag_obj.add('Programmatically Added');

                        var index = $tag_obj.inValues('some tag');
                        $tag_obj.remove(index);
                }
                catch(e) {
                        //display a textarea for old IE, because it doesn't support this plugin or another one I tried!
                        tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
                        //autosize($('#form-field-tags'));
                }

                /////////
                $('#modal-form input[type=file]').ace_file_input({
                        style:'well',
                        btn_choose:'Carregue seu arquivo aqui ou Clique para escolher',
                        btn_change:null,
                        no_icon:'ace-icon fa fa-cloud-upload',
                        droppable:true,
                        thumbnail:'large'
                })

                //chosen plugin inside a modal will have a zero width because the select element is originally hidden
                //and its width cannot be determined.
                //so we set the width after modal is show
                $('#modal-form').on('shown.bs.modal', function () {
                        if(!ace.vars['touch']) {
                                $(this).find('.chosen-container').each(function(){
                                        $(this).find('a:first-child').css('width' , '210px');
                                        $(this).find('.chosen-drop').css('width' , '210px');
                                        $(this).find('.chosen-search input').css('width' , '200px');
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
            <!-- ==================================================================================== -->
    </body>

    <style>
        .select2-container--default .select2-selection--single{
            height: 37px;
        }
        .error{
            color: red;
        }
    </style>

</html>
