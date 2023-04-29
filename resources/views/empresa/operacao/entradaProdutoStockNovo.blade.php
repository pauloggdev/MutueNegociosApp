@extends('layout.appEmpresa')
@section('title','Entrada de produto no Estoque')
@section('content')

<section class="content">
    <entrada-estoque-novo-Component :guard="{{$guard}}" :formapagamentos="{{$formapagamentos}}"></entrada-estoque-novo-Component>
</section>
@endsection