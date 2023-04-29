@extends('layout.appEmpresa')
@section('title','Listar Clientes')
@section('content')

<section class="content">
<Clientes-funcionario-component :clientes="{{$clientes}}" :status="{{$status}}" :paises="{{$paises}}" :tipos_clientes="{{$tipos_clientes}}"></Clientes-funcionario-component>
</section>
@endsection
