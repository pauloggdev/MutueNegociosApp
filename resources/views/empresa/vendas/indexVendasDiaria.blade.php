@extends('layout.appEmpresa')
@section('title','Vendas Diaria')
@section('content')

    <section class="content">
        <vendas-Diaria-Index :facturas="{{json_encode($facturas,TRUE)}}"></vendas-Diaria-Index>
    </section>
@endsection