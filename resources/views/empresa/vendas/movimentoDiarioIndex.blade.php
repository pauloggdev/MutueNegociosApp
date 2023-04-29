@extends('layout.appEmpresa')
@section('title','Movimento diário')
@section('content')

<section class="content">
    <Movimento-diario-index 
        :formapagamento="{{$formapagamento}}" 
        :clientes="{{$clientes}}" 
        :armazens="{{$armazens}}" 
        :tipofactura="{{$tipofactura}}" 
        :guard="{{$guard}}">
    </Movimento-diario-index>
</section>
@endsection