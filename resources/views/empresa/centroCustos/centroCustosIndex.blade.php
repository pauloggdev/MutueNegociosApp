@extends('layout.appEmpresa')
@section('title','Centro de custos')
@section('content')

<div class="row">
    @foreach($centrocustos as $centrocusto)
    <div class="card-w-20" style="background-color:#2E6589; padding:1px;">
    <div class="card-body">

    <h5 class="card-title"> <a href="{{ route('relatorio.index', $centrocusto->uuid) }}" 
    style="color:white;">   <p> <i class="fa fa-shopping-basket" aria-hidden="true"> </i>  {{ $centrocusto->nome }} </p></a></h5>
       
    
    <!-- <div class="card w-50">
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text"></p> -->

    </div>
    @endforeach


@endsection