@component('frontOffice/header', ['title'=>'Redefinir a Senha'])
@endcomponent

<div class="hero row align-items-center">

    <div class="col-md-6">
        <!-- <h2>Best & Trusted</h2> -->
        <h2><span>Mutue</span> Negócios</h2>
        <h2>A solução da sua empresa</h2><br>
    </div>

    <div class="col-md-6">
        <div class="form">
            <h3>Nova senha</h3>
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <form method="POST" action="{{ route('password.update', $token) }}" class="php-email-form">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" placeholder="Email" autofocus/>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Nova senha">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirmar nova senha">

                <button class="btn btn-block" type="submit">{{ __('redefinição a senha') }}</button>
            </form>
        </div>
    </div>
</div>
</div>
</div>
<style>
.is-invalid{
    border: 1px solid red !important;
}
</style>
@component('frontOffice/footer')
@endcomponent
