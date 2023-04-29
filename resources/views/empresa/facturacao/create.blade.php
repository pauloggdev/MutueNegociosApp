@extends('layout.appEmpresa')
@section('title','Fazer Factura')
@section('content')

<section class="content">
    <facturacao-create-component :guard="{{$guard}}" :valorretencao="{{$valorretencao}}" :descontomax="{{$descontomax}}"  :impressao="{{json_encode($impressao)}}" :existenciastock="{{$existenciastock}}" :taxas="{{$taxas}}" :motivos="{{$motivos}}" :status="{{$status}}"></facturacao-create-component>
</section>
@endsection
