@extends('layouts.app')
@section('title','Listar Produtos')
@section('content')
<div class="alert alert-danger" role="alert">
  PRODUTOS COM QUANTIDADE CRITICA ,ACTUALIZA O SEU STOCK
</div>

<div class>
  <div class="row">
    <form id="adimitirCandidatos" method="POST" action>
      <input type="hidden" name="_token" value />

      <div class="col-xs-12 widget-box widget-color-green" style="left: 0%">
        <div class="clearfix">
          <div class="pull-right tableTools-container"></div>
        </div>
        <div class="table-header widget-header">
        Quantidade Criticas
        </div>

        <!-- div.dataTables_borderWrap -->
        <div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>Codigo do produto</th>
                <th>Designação</th>
                <th>Quantidade Critica</th>
                <th>Quantidade Minima</th>
              </tr>
            </thead>
            <tbody>
              @foreach($existenciaStock as $existstock)
              <tr>
                <td>{{$existstock->produtos->id}}</td>
                <td>{{$existstock->produtos->designacao}}</td>
                <td>{{$existstock->produtos->quantidade_critica}}</td>
                <td>{{$existstock->produtos->quantidade_minima}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </form>

  </div>
</div>
</div>
</div>

@endsection