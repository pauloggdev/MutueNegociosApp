@section('title','Exportar banco de dados')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
            EXPORTAR BANCO DE DADOS
        </h1>
    </div>
    <div style="    display: flex;
    justify-content: center;">
        <form action="{{ route('exportarBancoDadoCliente') }}" method="POST" class="filter-form form-horizontal validation-form" id="validation-form" style="box-shadow: none;">
            @csrf
            <div class="second-row">
                <div class="clearfix">
                    <div class="col-md-12">
                        <button class="search-btn" type="submit" style="border-radius: 10px;" id="btn_export">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            BAIXAR BANCO CLIENTE
                        </button>
                    </div>
                </div>
            </div>
        </form>
        <form action="{{ route('exportarBancoDadoAdmin') }}" method="POST" class="filter-form form-horizontal validation-form" id="validation-form" style="box-shadow: none;">
            @csrf
            <div class="second-row">
                <div class="clearfix">
                    <div class="col-md-12">
                        <button class="search-btn" type="submit" style="border-radius: 10px;" id="btn_export">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            BAIXAR BANCO ADMIN
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>