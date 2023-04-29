@extends('layout.appEmpresa')
@section('title','Produtos em Estoque')
@section('content')
    <section class="content">
        <produto-stock-index-component :guard="{{$guard}}" :armazens="{{$armazens}}" :produtoStock="{{$produtoStock}}"></produto-stock-index-component>
    </section>
@endsection