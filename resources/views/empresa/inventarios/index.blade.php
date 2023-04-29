@extends('layout.appEmpresa')
@section('title','Listar Inventários')
@section('content')

<section class="content">
    <Inventarios-component :inventarios="{{$inventarios}}" :existenciastock="{{$existenciastock}}" :atualizastock="{{$atualizastock}}" :armazens="{{$armazens}}" :guard="{{$guard}}"></Inventarios-component>
</section>
@endsection