@extends('layout.appEmpresa')
@section('title','Listar Armazens')
@section('content')

<section class="content">
    <Armazens-component :armazens="{{$armazens}}" :status="{{$status}}"></Armazens-component>
</section>
@endsection
