@extends('layout.appEmpresa')
@section('title','Listar Gestão')
@section('content')

<section class="content">
<Gestores-component :guard="{{$guard}}":gestores="{{$gestores}}" :status="{{$status}}"></Gestores-component>
</section>
@endsection