@extends('layout.appEmpresa')
@section('title','Listar Recibo de Licenças')
@section('content')

<section class="content">
   <Recibo-Licenca-Index-Component :recibos="{{$recibos}}" :guard="{{$guard}}"></Recibo-Pagamento-Index-Component>
</section>
@endsection