@extends('layout.appAdmin')
@section('title','Listar Coordernadas bancarias')
@section('content')

<section class="content">
    <Coordernada-bancaria-admin-component :coordernadasbancaria="{{$coordernadasbancaria}}" :bancos="{{$bancos}}" :status="{{$status}}"></Coordernada-bancaria-admin-component>
</section>
@endsection


    
