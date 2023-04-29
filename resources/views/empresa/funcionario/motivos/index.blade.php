@extends('layout.appEmpresa')
@section('title','Listar Motivos de Isenção')
@section('content')

<section class="content">
    <Motivos-component :motivos="{{$motivos}}" :status="{{$status}}" :user="{{$user}}"></Motivos-component>
</section>
@endsection
