@extends('layout.appEmpresa')
@section('title','Listar Gestão')
@section('content')

<section class="content">
    <Gestores-funcionario-component :gestores="{{$gestores}}" :status="{{$status}}"></Gestores-funcionario-component>
</section>
@endsection