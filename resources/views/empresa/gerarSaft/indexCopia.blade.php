@extends('layout.appEmpresa')
@section('title','Gerar Saft')
@section('content')

<section class="content">
<Gerar-saft-component :guard="{{ $guard}}"></Gerar-saft-component>
</section>
@endsection