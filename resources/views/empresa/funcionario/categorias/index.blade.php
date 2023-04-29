@extends('layout.appEmpresa')
@section('title','Listar Categoria de Produtos')
@section('content')

<section class="content">
    <Categorias-component :categorias="{{$categorias}}" :status="{{$status}}"></Categorias-component>
</section>
@endsection