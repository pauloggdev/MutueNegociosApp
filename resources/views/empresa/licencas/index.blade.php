@extends('layout.appEmpresa')
@section('title','Listar Assinaturas')
@section('content')

<section class="content">
    <Assinatura-component :licencas="{{$licencas}}" :guard="{{$guard}}"></Assinatura-component>
</section>



@section('js_solicitacao_factura_licenca')
<script src="{{asset('assets/js/jquery-1.11.3.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/js/accordion.js')}}"></script>

<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/ace-elements.min.js')}}"></script>

<script src="{{ asset('assets/js/jquery.maskedinput.min.js')}}"></script>
<script src="{{ asset('assets/js/chosen.jquery.min.js')}}"></script>
<script src="{{ asset('assets/js/jquery.inputlimiter.min.js')}}"></script>


@endsection



@endsection