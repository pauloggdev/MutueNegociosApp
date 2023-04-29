@extends('layout.appEmpresa')
@section('title','Documentos rectificadas')
@section('content')

<section class="content">
   <Rectificacao-Factura-Index-Component :status="{{$status}}":facturas="{{$facturas}}":guard="{{$guard}}"></Rectificacao-Factura-Index-Component>
</section>
@endsection