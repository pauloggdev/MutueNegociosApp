@component('frontOffice/header', ['title'=>'Recuperar senha'])
@endcomponent

<div class="hero row align-items-center">

    <div class="col-md-6">
        <!-- <h2>Best & Trusted</h2> -->
        <h2><span>Mutue</span> Negócios</h2>
        <h2>A solução da sua empresa</h2><br>
    </div>

    <div class="col-md-6">
        <div class="form">
            <h3>Informe o email</h3>
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" class="php-email-form" id="form-submit">
                @csrf
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="Email" autofocus />
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

                <button class="btn btn-block" type="submit">{{ __('redefinição a senha') }}</button>
            </form>
        </div>
    </div>
</div>
</div>
</div>
