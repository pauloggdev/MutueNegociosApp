@extends('layout.appEmpresa')
@section('title','Listar Assinaturas')
@section('content')

<section class="content">
    <Assinatura-component :licencas="{{$licencas}}" ></Assinatura-component>
</section>

@endsection
