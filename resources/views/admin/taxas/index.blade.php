@extends('layout.appAdmin')
@section('title','Listar Taxas do IVA')
@section('content')

<section class="content">
<Taxas-component :taxas="{{$taxas}}" :guard="{{$guard}}" :status="{{$status}}" :user="{{$user}}"></Taxas-component>
</section>
@endsection
