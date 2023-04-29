@extends('layout.appEmpresa')
@section('title','Produtos mais vendidos')
@section('content')
<section class="content">
    <produto-mais-vendidos-component :guard="{{$guard}}" :produtomaisvendido="{{json_encode($produtomaisvendido)}}"></produto-mais-vendidos-component>
</section>
@endsection