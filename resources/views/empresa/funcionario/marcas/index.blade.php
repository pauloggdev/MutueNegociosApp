@extends('layout.appEmpresa')
@section('title','Listar Marcas de Produtos')
@section('content')

<section class="content">
    <Marcas-component :marcas="{{$marcas}}" :status="{{$status}}"></Marcas-component>
</section>
@endsection