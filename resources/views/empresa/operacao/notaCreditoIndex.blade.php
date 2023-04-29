@extends('layout.appEmpresa')
@section('title','Nota de crédito')
@section('content')

<section class="content">
         <Nota-Credito-Index-Component :datanotacredito="{{$dataNotaCredito}}" :guard="{{$guard}}"></Nota-Credito-Index-Component>
</section>
@endsection