@component('frontOffice/header', ['title'=>'Contactos'])
@endcomponent


</div>
</div>
<!-- Contact Start -->
<div class="contact">
    <div class="container">
        <div class="section-header">
            <p>Contactos</p>
        </div>
        @if (Session::has('success'))
        <div class="alert alert-success alert-success col-xs-12" style="left: 0%;">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fa fa-check-square-o bigger-150"></i>{{ Session::get('success') }}</h5>
        </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="faqs">
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header">
                                <span><i class="fa fa-phone"></i> +244 922969192</span>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <span><i class="fa fa-envelope"></i> geral@mutue.net</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="contact-form">
                    <form action="/contacto" id="contact-form" method="POST">
                        {{ csrf_field() }}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control {{ $errors->has('nome') ? ' has-error' : '' }}" name="nome" value="{{ old('nome')}}" placeholder="Nome" />
                                @if ($errors->has('nome'))
                                <span class="help-block" style="color: red;">
                                    <strong>{{ $errors->first('nome') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <input type="email" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" name="email" value="{{ old('email')}}" placeholder="E-mail" />
                                @if ($errors->has('email'))
                                <span class="help-block" style="color: red;">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control {{ $errors->has('assunto') ? ' has-error' : '' }}" name="assunto" value="{{ old('assunto')}}" placeholder="Assunto" />
                            @if ($errors->has('assunto'))
                            <span class="help-block" style="color: red;">
                                <strong>{{ $errors->first('assunto') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <textarea class="form-control {{ $errors->has('mensagem') ? ' has-error' : '' }}" rows="6" name="mensagem" value="{{ old('mensagem')}}" placeholder="Mensagem"></textarea>
                            @if ($errors->has('mensagem'))
                            <span class="help-block" style="color: red;">
                                <strong>{{ $errors->first('mensagem') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div><button class="btn" id="btn-cadastro" type="submit">Enviar Mensagem</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

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
    .has-error {
        border: 1px solid red;
    }

    b,
    strong {
        font-weight: bolder;
        font-size: 12px;
    }
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
@component('frontOffice/footer')
@endcomponent