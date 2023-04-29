@extends('layout.appEmpresa')
@section('title','Actualização de produto no Estoque')
@section('content')

<section class="content">
    <actualizar-estoque-novo-Component :guard="{{$guard}}" :produtos="{{$produtos}}":armazens="{{$armazens}}"></actualizar-estoque-novo-Component>
</section>
@endsection