@extends('layout.appEmpresa')
@section('title','Listar Classes de Bem')
@section('content')

<section class="content">
    <Classes-component :classes="{{$classes}}" :status="{{$status}}"></Classes-component>
</section>
@endsection