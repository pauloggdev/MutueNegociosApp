@extends('layout.appAdmin')
@section('title','Permissões')
@section('content')

<section class="content">
    <Permissoes-admin-component :permissions="{{$permissions}}"></Permissoes-admin-component>
</section>
@endsection