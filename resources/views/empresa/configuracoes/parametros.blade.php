@extends('layout.appEmpresa')
@section('title','Listar parametros')
@section('content')

<section class="content">
    <Parametros-Component :guard="{{$guard}}" :observacaofactura="{{json_encode($observacaofactura)}}" :documentoserie="{{json_encode($documentoserie)}}" :vencimentoftproforma="{{json_encode($vencimentoftproforma)}}" :vencimentofactura="{{json_encode($vencimentofactura)}}" :retencao="{{json_encode($retencao)}}" :desconto="{{json_encode($desconto)}}" :impressao="{{json_encode($impressao)}}" :viaImpressao="{{json_encode($viaimpressao)}}"></Parametros-Component>
</section>
@endsection