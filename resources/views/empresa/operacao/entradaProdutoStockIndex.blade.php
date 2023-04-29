@extends('layout.appEmpresa')
@section('title','Listar entradas de produto no Estoque')
@section('content')

<section class="content">
    <entrada-estoque-Index-Component :entradastock="{{$entradastock}}" :guard="{{$guard}}"></entrada-estoque-Index-Component>
</section>
@endsection