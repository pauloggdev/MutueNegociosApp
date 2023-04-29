@extends('layout.appEmpresa')
@section('title','Rectificação Factura')
@section('content')
    <section class="content">
        <rectificacao-create-component :guard="{{$guard}}" ></rectificacao-create-component>
    </section>
@endsection

