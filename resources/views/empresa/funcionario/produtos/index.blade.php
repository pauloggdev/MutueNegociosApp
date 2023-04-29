@extends('layout.appEmpresa')
@section('title','Adicionar Produtos')
@section('content')

    <section class="content">
        <produto-index-funcionario-component :produtos="{{$produtos}}" :status="{{$status}}"></produto-index-funcionario-component>
    </section>
@endsection
