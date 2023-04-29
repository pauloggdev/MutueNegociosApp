@extends('layout.appEmpresa')
@section('title','Listar Produtos')
@section('content')
    <section class="content">
    <produto-index-component :produtos="{{$produtos}}" :guard="{{$guard}}" :status="{{$status}}"></produto-index-component>
    </section>
@endsection
