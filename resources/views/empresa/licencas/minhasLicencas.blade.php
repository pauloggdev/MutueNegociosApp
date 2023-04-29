@extends('layout.appEmpresa')
@section('title','Minhas Licenças')
@section('content')

<section class="content">
    <Minha-licenca-component :licencas="{{$licencas}}"></Minha-licenca-component>
</section>

@endsection