@extends('layout.appEmpresa')
@section('title','Listar Unidades de Medida')
@section('content')

<section class="content">
    <Unidades-component :unidades="{{$unidades}}" :status="{{$status}}"></Unidades-component>
</section>
@endsection