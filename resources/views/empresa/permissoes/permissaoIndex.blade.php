@extends('layout.appEmpresa')
@section('title','Permissões')
@section('content')
<section class="content">
    <Permissoes-component :guard="{{$guard}}" :permissions="{{$permissions}}"></Permissoes-component>
</section>
@endsection