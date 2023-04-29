@extends('layout.appEmpresa')
@section('title','Actualizar estoque')
@section('content')

<section class="content">
    <existencia-stock-index-component :atualizacaostock="{{$atualizacaostock}}" :guard="{{$guard}}"></existencia-stock-index-component>
</section>
@endsection
