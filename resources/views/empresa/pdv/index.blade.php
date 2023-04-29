@extends('layout.appPdv')
@section('title','PDV')
@section('content')

<section class="content">
    <pdv-component :tipoempressao="{{json_encode($tipoempressao)}}"></pdv-component>
</section>
@endsection