@extends('layout.appEmpresa')
@section('title','Listar Taxas do IVA')
@section('content')

<section class="content">
<Taxas-empresa-component :taxas="{{$taxas}}" :guard="{{$guard}}" :status="{{$status}}" :user="{{$user}}"></Taxas-empresa-component>
</section>
@endsection
