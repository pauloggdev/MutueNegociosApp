@extends('layout.appEmpresa')
@section('title','Vendas Mensal')
@section('content')

    <section class="content">
        <vendas-Mensal-Index :facturas="{{json_encode($facturas,TRUE)}}"></vendas-Mensal-Index>
    </section>
@endsection