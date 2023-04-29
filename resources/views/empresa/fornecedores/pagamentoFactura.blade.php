@extends('layout.appEmpresa')
@section('title','Pagamento Fornecedor')
@section('content')

<section class="content">
    <Pagamento-fornecedor-component :fornecedores="{{$fornecedores}}" :pagamentos="{{$pagamentos}}" :pagamentofornecedor="{{$pagamentofornecedor}}" :guard="{{$guard}}"></Pagamento-fornecedor-component>
</section>
@endsection