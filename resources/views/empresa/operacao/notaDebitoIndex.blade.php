@extends('layout.appEmpresa')
@section('title','Nota de débito')
@section('content')

<section class="content">
   <Nota-Debito-Index-Component :guard="{{$guard}}" :datanotadebito="{{$dataNotaDebito}}" ></Nota-Debito-Index-Component>
</section>
@endsection