@extends('layout.appEmpresa')
@section('title','Documentos anulados')
@section('content')
<section class="content">
    <Anulacao-Factura-Index-Component :guard="{{$guard}}" :datadocumentosanulados="{{$documentosAnulados}}"></Anulacao-Factura-Index-Component>
</section>
@endsection