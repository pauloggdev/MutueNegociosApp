@extends('layout.appEmpresa')
@section('title','Listar Facturas de Licença')
@section('content')

<section class="content">
   <Factura-Licenca-Index-Component :facturas="{{$facturas}}" :guard="{{$guard}}"></Factura-Licenca-Index-Component>
</section>
@endsection