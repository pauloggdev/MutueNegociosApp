@extends('layout.appEmpresa')
@section('title','Listar Fornecedores')
@section('content')

<section class="content">
    <Fornecedores-component :fornecedores="{{$fornecedores}}" :paises="{{$paises}}" :status="{{$status}}" :guard="{{$guard}}"></Fornecedores-component>
</section>
@endsection