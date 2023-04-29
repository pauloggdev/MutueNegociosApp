@extends('layout.appEmpresa')
@section('title','Relatórios de vendas')
@section('content')

    <section class="content">
        <relatorio-vendas :guard="{{$guard}}"></relatorio-vendas>
    </section>
@endsection