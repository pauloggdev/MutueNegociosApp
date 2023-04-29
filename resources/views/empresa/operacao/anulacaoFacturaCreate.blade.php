@extends('layout.appEmpresa')
@section('title','Anulação de documento')
@section('content')
    <section class="content">
        <anulacao-create-component :guard="{{$guard}}" ></anulacao-create-component>
    </section>
@endsection

