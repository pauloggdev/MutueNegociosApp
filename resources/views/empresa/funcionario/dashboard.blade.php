@extends('layout.appDashboardEmpresa')
@section('title','Dashboard')
@section('content')

<section class="content">
    <Dashboard-funcionario-component :auth="{{$auth}}"></Dashboard-funcionario-component>
</section>
@endsection

    
