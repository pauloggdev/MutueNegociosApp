@section('title','Manual do utilizador')
<div class="row">
    <div class="space-6"></div>
    <div class="page-header" style="left: 0.5%; position: relative">
        <h1>
           MANUAL DO UTILIZADOR
        </h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form class="filter-form form-horizontal validation-form" id="validation-form">
                <div class="second-row">
                    <div class="clearfix form-actions">
                        <div style="display: flex; justify-content: center;">
                            <button class="search-btn" type="submit" style="border-radius: 10px" wire:click.prevent="imprimirManualUtilizador">
                                <span wire:loading.remove wire:target="imprimirManualUtilizador">
                                <i class="ace-icon fa fa-download bigger-110"></i>
                                Baixar Manual
                                </span>
                                <span wire:loading wire:target="imprimirManualUtilizador">
                                    <span class="loading"></span>
                                    Aguarde...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
