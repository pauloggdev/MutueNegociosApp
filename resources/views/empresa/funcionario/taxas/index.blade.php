@extends('layout.appEmpresa')
@section('title','Listar Taxas do IVA')
@section('content')

<section class="content">
    <Taxas-component :taxas="{{$taxas}}" :status="{{$status}}" :user="{{$user}}"></Taxas-component>
</section>
@endsection
