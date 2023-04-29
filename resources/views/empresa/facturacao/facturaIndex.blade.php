@extends('layout.appEmpresa')
@section('title','Listar Facturas')
@section('content')
<section class="content">
    <factura-index-component :guard="{{$guard}}" :tipoempressao="{{json_encode($tipoempressao)}}" :status="{{$status}}"></factura-index-component>
</section>
@endsection

