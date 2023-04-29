@extends('layout.appEmpresa')
@section('title','Listar Facturas')
@section('content')

<section class="content">
<factura-index-component :facturas="{{$facturas}}"></factura-index-component>
</section>
@endsection