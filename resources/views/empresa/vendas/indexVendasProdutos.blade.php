@extends('layout.appEmpresa')
@section('title','Vendas por produtos')
@section('content')

    <section class="content">
        <vendas-Produtos-Index :produtos="{{$produtos}}"></vendas-Produtos-Index>
    </section>
@endsection