@extends('layout.appEmpresa')
@section('title','Listar bancos')
@section('content')

<section class="content">
    <Bancos-component :bancos="{{$bancos}}" :status="{{$status}}"></Bancos-component>
</section>
@endsection