@extends('layout.appEmpresa')
@section('title','Produtos em Estoque')
@section('content')

    <section class="content">
        <produto-stock-index-funcionario-component :produtoStock="{{$produtoStock}}"></produto-stock-index-funcionario-component>
    </section>
@endsection