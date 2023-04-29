@extends('layout.appEmpresa')
@section('title','Listar transferencia produtos')
@section('content')

<section class="content">
    <Transferencia-Produto-Index-Component :guard="{{$guard}}" :transferencia="{{$transferencia}}"></Transferencia-Produto-Index-Component>
</section>
@endsection