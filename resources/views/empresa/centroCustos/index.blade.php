@extends('layout.appEmpresa')
@section('title','Centro de custos')
@section('content')
<section class="content">
    <centro-custos-index-component :centrocustos="{{$centrocustos}}"></centro-custos-index-component>
</section>
@endsection