@extends('layout.appEmpresa')
@section('title','Listar Fornecedor')
@section('content')



<section class="content">
<fabricante-index-component :fabricantes="{{$fabricantes}}" :status="{{$status}}"></fabricante-index-component>
    {{-- <Facturacao-component></Facturacao-component> --}}
</section>


@endsection