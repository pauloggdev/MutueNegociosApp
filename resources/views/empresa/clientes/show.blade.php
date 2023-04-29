@section('title','Detalhes do cliente')

<div>


    <div class="row">

        <!-- VER DETALHES  -->

        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                DETALHES DO CLIENTE
            </h1>
        </div>

        <div class="col-md-12">


            <div class="row">
                <form id="adimitirCandidatos" method="POST" action>
                    <input type="hidden" name="_token" value />

                    <div class="col-xs-12 widget-box widget-color-green" style="left: 0%">

                        <div class="table-header widget-header">
                            Informações adicionais do cliente
                        </div>

                        <!-- div.dataTables_borderWrap -->
                        <div>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome do cliente</th>
                                        <th style="text-align: right">Saldo</th>
                                        <th style="text-align: right">Limite crédito</th>
                                        <th style="text-align: right">Limite desconto</th>
                                        <th>Endereço</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$cliente['nome']}}</td>
                                        <td style="text-align: right">{{ $saldoCliente }}</td>
                                        <td style="text-align: right">{{ number_format($cliente['limite_de_credito'], 2,',','.')}}</td>
                                        <td style="text-align: right">{{ number_format($cliente['taxa_de_desconto'], 1, ',','.')}} %</td>
                                        <td>{{ $cliente['endereco']}}</td>
                                    </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>