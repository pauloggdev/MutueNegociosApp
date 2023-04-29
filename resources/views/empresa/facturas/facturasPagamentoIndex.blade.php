@extends('layout.appEmpresa')
@section('title','Listar Facturas')
@section('content')

<section class="content">
   <Factura-Pagamento-Index-Component :facturas="{{$facturas}}"></Factura-Pagamento-Index-Component>
</section>
@endsection