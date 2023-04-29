@extends('layout.appEmpresa')
@section('title','Listar Motivos de Isenção')
@section('content')

<section class="content">
    <Motivos-empresa-component :guard="{{$guard}}" :motivos="{{$motivos}}" :status="{{$status}}" :user="{{$user}}"></Motivos-empresa-component>
</section>
@endsection
