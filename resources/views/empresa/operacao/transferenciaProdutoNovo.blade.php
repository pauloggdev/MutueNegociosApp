@extends('layout.appEmpresa')
@section('title','transferencia de produtos')
@section('content')

<section class="content">
    <Transferencia-Produto-Novo-Component :existenciastock="{{$existenciastock}}" :guard="{{$guard}}" :produtos="{{$produtos}}" :armazens="{{$armazens}}"></Transferencia-Produto-Novo-Component>
</section>
@endsection