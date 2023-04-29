@section('title',"Relatórios - $centroCusto->nome")
<div>
    <div class="modal fade" id="relatorio_venda" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> RELATÓRIO DE VENDAS - {{ strtoupper($centroCusto->nome) }}
                    </h4>

                </div>

                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">

                        <div class="col-md-12">
                            <form class="filter-form form-horizontal validation-form">
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <span>{{ $errors->all()[0] }}</span>
                                </div>
                                @endif
                                <div class="second-row">
                                    <div class="tabbable">
                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_motivo" class="tab-pane in active">
                                                <div class="form-group has-info">
                                                    <div class="col-md-6">
                                                        <label class="control-label bold label-select2" for="dataInicio">Escolha a data Inferior<b class="red fa fa-question-circle"></b></label>
                                                        <div>
                                                            <input type="datetime-local" wire:model="venda.dataInicio" id="dataInicio" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label bold label-select2" for="dataFim">Escolha a data Superior<b class="red fa fa-question-circle"></b></label>
                                                        <div>
                                                            <input type="datetime-local" wire:model="venda.dataFim" id="dataFim" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-9">
                                                <button class="search-btn" style="border-radius: 10px" wire:click.prevent="printRelatorioVendaPdf('pdf')">

                                                    <span wire:loading.remove wire:target="printRelatorioVendaPdf('pdf')">
                                                        <i class="ace-icon fa fa-print bigger-110"></i>
                                                        IMPRIMIR PDF
                                                    </span>
                                                    <span wire:loading wire:target="printRelatorioVendaPdf('pdf')">
                                                        <span class="loading"></span>
                                                        Aguarde...</span>



                                                </button>
                                                <!-- <button class="search-btn" style="border-radius: 10px" wire:click.prevent="printRelatorioVendaXls('xls')">
                                                    <span wire:loading.remove wire:target="printRelatorioVendaXls('xls')">
                                                        <i class="ace-icon fa fa-print bigger-110"></i>
                                                        IMPRIMIR EXCEL
                                                    </span>
                                                    <span wire:loading wire:target="printRelatorioVendaXls('xls')">
                                                        <span class="loading"></span>

                                                    Aguarde...</span>
                                                </button> -->
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="relatorio_estoque" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> RELATÓRIO DE ESTOQUE - {{ strtoupper($centroCusto->nome) }}
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">
                        <div class="col-md-12">
                            <form enctype="multipart/form-data" method="POST" action="{{ route('relatorioEstoque', $centroCusto->uuid) }}" class="filter-form form-horizontal validation-form" id>

                                @csrf
                                <div class="second-row">
                                    <div class="tabbable">
                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_motivo" class="tab-pane in active">
                                                <div class="form-group has-info">
                                                    <div class="col-md-6">
                                                        <label class="control-label bold label-select2" for="designacao">Escolha a data Inferior<b class="red fa fa-question-circle"></b></label>
                                                        <div>
                                                            <input type="datetime-local" name="dataInicio" id="designacao" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label bold label-select2" for="designacao">Escolha a data Superior<b class="red fa fa-question-circle"></b></label>
                                                        <div>
                                                            <input type="datetime-local" name="dataFim" id="designacao" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-9">
                                                <button class="search-btn" type="submit" style="border-radius: 10px">
                                                    <i class="ace-icon fa fa-print bigger-110"></i>
                                                    Imprimir
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="relatorioVendaTodosOperadores" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> RELATÓRIO DE VENDAS - {{ strtoupper($centroCusto->nome) }}
                    </h4>

                </div>

                <div class="row" style="left: 0%; position: relative;">

                    <div class="col-md-12">
                        <form class="filter-form form-horizontal validation-form">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <span>{{ $errors->all()[0] }}</span>
                            </div>
                            @endif
                            <div class="second-row">
                                <div class="tabbable">
                                    <div id="dados_motivo">
                                        <div role="alert" class="alert alert-warning">
                                            Será impresso relatório de venda da data selecionada no intervalo
                                            de hora das 07:30:00 à 22:00:00.
                                        </div>
                                        <div class="form-group has-info">
                                            <div class="col-md-12">
                                                <label class="control-label bold label-select2" for="dataInicio">Selecione a data<b class="red fa fa-question-circle"></b></label>
                                                <div>
                                                    <input type="date" wire:model="dataVendaTodoOperador" style="<?= $errors->has('dataVendaTodoOperador') ? 'border-color: #ff9292;' : '' ?>" id="dataInicio" class="col-md-12 col-xs-12 col-sm-4" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix form-actions" style="margin-top: 60px">
                                        <div class="col-md-9">
                                            <button class="search-btn" style="border-radius: 10px" wire:click.prevent="printRelatorioVendaTodosOperadoresPdf('pdf')">

                                                <span wire:loading.remove wire:target="printRelatorioVendaTodosOperadoresPdf('pdf')">
                                                    <i class="ace-icon fa fa-print bigger-110"></i>
                                                    IMPRIMIR PDF
                                                </span>
                                                <span wire:loading wire:target="printRelatorioVendaTodosOperadoresPdf('pdf')">
                                                    <span class="loading"></span>
                                                    Aguarde...</span>



                                            </button>
                                            <!-- <button class="search-btn" style="border-radius: 10px" wire:click.prevent="printRelatorioVendaXls('xls')">
                                                    <span wire:loading.remove wire:target="printRelatorioVendaXls('xls')">
                                                        <i class="ace-icon fa fa-print bigger-110"></i>
                                                        IMPRIMIR EXCEL
                                                    </span>
                                                    <span wire:loading wire:target="printRelatorioVendaXls('xls')">
                                                        <span class="loading"></span>

                                                    Aguarde...</span>
                                                </button> -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="space-6"></div>
        <div class="page-header" style="left: 0.5%; position: relative">
            <h1>
                RELATÓRIOS CENTRO DE CUSTO - {{ strtoupper($centroCusto->nome) }}

            </h1>
        </div>


        <div class="col-xs-12">
            <div class>
                <div class="row">
                    <form id="adimitirCandidatos" method="POST" action>
                        <input type="hidden" name="_token" value />

                        <div class="col-xs-12 widget-box widget-color-green" style="left: 0%">
                            <div class="clearfix">
                                <div class="dt-buttons btn-overlap btn-group pull-right">
                                    <a class="
                      dt-button
                      buttons-collection buttons-colvis
                      btn btn-white btn-primary btn-bold
                    " tabindex="0" aria-controls="dynamic-table">
                                        <span>
                                            <i class="fa fa-search bigger-110 text-primary"></i>
                                            <span class="hidden">Mostrar/Ocultar Colunas</span>
                                        </span>
                                    </a>
                                    <a class="
                      dt-button
                      buttons-copy buttons-html5
                      btn btn-white btn-primary btn-bold
                    " tabindex="0" aria-controls="dynamic-table">
                                        <span>
                                            <i class="fa fa-copy bigger-110 text-pink"></i>
                                            <span class="hidden">Copiar para uma tabela</span>
                                        </span>
                                    </a>
                                    <a class="
                      dt-button
                      buttons-csv buttons-html5
                      btn btn-white btn-primary btn-bold
                    " tabindex="0" aria-controls="dynamic-table">
                                        <span>
                                            <i class="fa fa-database bigger-110 text-orange" style="color: orange"></i>
                                            <span class="hidden">Exportar para CSV</span>
                                        </span>
                                    </a>
                                    <a class="
                      dt-button
                      buttons-print
                      btn btn-white btn-primary btn-bold
                    " tabindex="0" aria-controls="dynamic-table" href="#modalFiltrarClientes" data-toggle="modal">
                                        <span><i class="fa fa-print bigger-110 text-default"></i>
                                            <span class="hidden">Imprimir toda Tabela</span>
                                        </span>
                                    </a>
                                </div>
                                <!-- <div class="pull-right tableTools-container"></div> -->
                            </div>

                            <div class="table-header widget-header">
                                Relatórios centro de custo
                            </div>

                            <!-- div.dataTables_borderWrap -->
                            <div>
                                <table id="dynamic-table" class="tabela1 table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nome</th>
                                            <th>Opções</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <tr>
                                            <td>1</td>
                                            <td>{{ strtoupper('Existência de produto no estoque') }}</td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a href=" {{ route('relatorioExistenciaStock', $centroCusto->uuid) }}" target="blank" class="pink" title="Editar centro de custo">
                                                        <i class="fa fa-file bigger-150 text-primary"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>{{ strtoupper('Relatório de vendas') }}</td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a href="#relatorio_venda" data-toggle="modal" class="pink" title="Editar centro de custo">
                                                        <i class="fa fa-file bigger-150 text-primary"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>{{ strtoupper('Relatório de vendas todos operadores') }}</td>
                                            <td>
                                                <div class="hidden-sm hidden-xs action-buttons">
                                                    <a href="#relatorioVendaTodosOperadores" data-toggle="modal" class="pink" title="relatorio de vendas todos operadores">
                                                        <i class="fa fa-file bigger-150 text-primary"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                                        <td>3</td>
                                        <td>{{ strtoupper('Relatório de stock') }}</td>
                                        <td>
                                            <div class="hidden-sm hidden-xs action-buttons">
                                                <a href="#relatorio_estoque" data-toggle="modal" class="pink" title="Editar centro de custo">
                                                    <i class="fa fa-file bigger-150 text-primary"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- /.col-xs-12 -->
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="relatorioExistenciaStock" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <button type="button" class="close red bolder" data-dismiss="modal">×</button>
                    <h4 class="smaller">
                        <i class="ace-icon fa fa-plus-circle bigger-150 blue"></i> RELATÓRIO DE EXISTÊNCIA ESTOQUE - {{ strtoupper($centroCusto->nome) }}
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="left: 0%; position: relative;">
                        <div class="col-md-12">
                            <form enctype="multipart/form-data" method="POST" action="{{ route('relatorioExistenciaStock', $centroCusto->uuid) }}" class="filter-form form-horizontal validation-form" id>
                                @csrf
                                <div class="second-row">
                                    <div class="tabbable">
                                        <div class="tab-content profile-edit-tab-content">
                                            <div id="dados_motivo" class="tab-pane in active">
                                                <div class="form-group has-info">
                                                    <div class="col-md-6">
                                                        <label class="control-label bold label-select2" for="designacao">Escolha a data Inferior<b class="red fa fa-question-circle"></b></label>
                                                        <div>
                                                            <input type="datetime-local" name="dataInicio" id="designacao" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label bold label-select2" for="designacao">Escolha a data Superior<b class="red fa fa-question-circle"></b></label>
                                                        <div>
                                                            <input type="datetime-local" name="dataFim" id="designacao" class="col-md-12 col-xs-12 col-sm-4" />
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-9">
                                                <button class="search-btn" style="border-radius: 10px">
                                                    <i class="ace-icon fa fa-print bigger-110"></i>
                                                    Imprimir
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <!-- /.col-xs-12 -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
