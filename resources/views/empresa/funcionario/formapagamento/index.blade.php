@extends('layout.appEmpresa')
@section('title','Listar Formas de Pagamento')
@section('content')

<section class="content">
    <Marcas-component :formapagamentos="{{$formapagamentos}}" :status="{{$status}}"></Marcas-component>
</section>
@endsection