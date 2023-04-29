@extends('layout.appAdmin')
@section('title','Listar Clientes')
@section('content')

<section class="content">
    <Cliente-admin-component :clientes="{{$clientes}}"></Cliente-admin-component>
</section>
@endsection


    
