@extends('layout.appAdmin')
@section('title','Funções')
@section('content')

<section class="content">
    <Funcoes-admin-component :roles="{{$roles}}"></Funcoes-admin-component>
</section>
@endsection