@extends('layout.appEmpresa')
@section('title','Modelo Documentos')
@section('content')

<section class="content">
    <Modelo-Documento-Component :guard="{{$guard}}" :modeloactivo="{{json_encode($modeloactivo)}}" :modelofacturas="{{json_encode($modelofacturas)}}"></Modelo-Documento-Component>
</section>
@endsection