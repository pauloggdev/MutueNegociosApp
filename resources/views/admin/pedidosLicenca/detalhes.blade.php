@section('title','Detalhes do pedido')

<div class="modal-content">

    <div class="row" style="left: 0%; position: relative;">

        <div class="col-md-12">
            <div class="search-form-text">
                <div class="search-text">
                    <i class="fa fa-pencil"></i>
                    Detalhes do pedido de Licença
                </div>
            </div>
        </div>
        <div class="col-md-12">

            <div class="tabbable" style="margin-top:30px">
                <ul class="nav nav-tabs padding-16">
                    <li class="active">
                        <a data-toggle="tab" href="#dados_user">
                            <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                            Dados da empresa
                        </a>
                    </li>

                    <li>
                        <a data-toggle="tab" href="#dadoLicenca">
                            <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                            Licença
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#dadosDocumento">
                            <i class="green ace-icon fa fa fa-id-card-o bigger-125"></i>
                            Pagamento
                        </a>
                    </li>

                </ul>

                <div class="tab-content profile-edit-tab-content">
                    <div id="dados_user" class="tab-pane in active">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Nome da empresa</th>
                                    <td>{{ $pedido->empresa->nome }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">NIF</th>
                                    <td>{{ $pedido->empresa->nif }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">E-mail</th>
                                    <td>{{ $pedido->empresa->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Endereco</th>
                                    <td>{{ $pedido->empresa->endereco }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Website</th>
                                    <td>{{ $pedido->empresa->website }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Contato</th>
                                    <td>{{ $pedido->empresa->pessoal_Contacto }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Logotipo</th>
                                    <td>
                                        <img src="{{ asset('upload/'.$pedido->empresa->logotipo)}}" style="width:150px" alt="">
                                    </td>
                                </tr>
                            </tbody>

                        </table>

                    </div>

                    <div id="dadoLicenca" class="tab-pane">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">Licença</th>
                                    <td>{{ $pedido->licenca->designacao }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Valor</th>
                                    <td>{{ number_format($pedido->licenca->valor, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Limite utilizadores </th>
                                    <td>{{ number_format($pedido->licenca->limite_usuario, 1, ',', '.')  }}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                    <div id="dadosDocumento" class="tab-pane">
                        @if($pedido->pagamento)
                        <table class="table table-bordered">
                            <tr>
                                <th scope="row">Número Operação bancaria</th>
                                <td>{{ $pedido->pagamento->numero_operacao_bancaria}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Banco</th>
                                <td>{{ $pedido->pagamento->contaMovimento->designacao }} ({{($pedido->pagamento->contaMovimento->sigla)}})</td>
                            </tr>
                            <tr>
                                <th scope="row">IBAN</th>
                                <td>{{ $pedido->pagamento->contaMovimento->coordernadaBancaria->iban }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Valor depositado</th>
                                <td>{{ number_format($pedido->pagamento->totalPago, 2, ',', '.')  }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Forma Pagamento</th>
                                <td>{{ $pedido->pagamento->formaPagamento->descricao }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Data Pagamento no banco</th>
                                <td>{{ date_format(date_create($pedido->pagamento->data_pago_banco),"d/m/Y")  }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Ref. da factura paga</th>
                                <td>{{ $pedido->pagamento->factura->faturaReference }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Comprovativo bancario</th>
                                <td>
                                    <a style="text-decoration: none;background: #005360;padding: 6px;color: white;" href="{{ asset('upload/'.$pedido->pagamento->comprovativo_bancario)}}" target="blank">Baixar o comprovativo bancario</a>
                                </td>
                            </tr>
                        </table>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>



</div>