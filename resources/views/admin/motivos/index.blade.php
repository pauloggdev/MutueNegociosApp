@extends('layout.appAdmin')
@section('title','Listar Motivos de Isenção')
@section('content')

<section class="content">
    <Motivos-component :guard="{{$guard}}" :motivos="{{$motivos}}" :status="{{$status}}" :user="{{$user}}"></Motivos-component>
</section>
@endsection
