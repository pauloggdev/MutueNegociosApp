@extends('layout.appEmpresa')
@section('title','Anulação de Recibo')
@section('content')
    <section class="content">
        <anulacao-recibo-create-component :guard="{{$guard}}" ></anulacao-recibo-create-component>
    </section>
@endsection

