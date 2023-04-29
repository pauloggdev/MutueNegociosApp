@extends('layout.appEmpresa')
@section('title','Emissão de Recibo')
@section('content')
    <section class="content">
        <recibo-create-component :guard="{{$guard}}" :formapagamentos="{{$formapagamentos}}"></recibo-create-component>
    </section>
@endsection