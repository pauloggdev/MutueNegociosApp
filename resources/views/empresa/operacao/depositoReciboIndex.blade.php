@extends('layout.appEmpresa')
@section('title','Déposito Recibo')
@section('content')

<section class="content">
<Deposito-Recibo-Index-Component :datarecibos="{{$dataRecibos}}" :guard="{{$guard}}"></Deposito-Recibo-Index-Component>
</section>
@endsection