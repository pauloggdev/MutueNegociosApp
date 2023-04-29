<div class="alert alert-warning hidden-sm hidden-xs assinatura" style="position: relative">
    <button type="button" class="close" data-dismiss="alert">
        <i class="ace-icon fa fa-times"></i>
    </button>
    <div class="alert alert-<?php echo $licencaGratis?"warning":"success"?> text-center" style="margin:0; padding:0; font-weight: bold">
        <span class="text-incompleteeee">A sua versão expira daqui a {{$diasRestantes}} dias</span>
        <a href="{{url('empresa/assinaturas')}}" id="btn-assina" class="margin-left-10px btn btn-success icon-animated-vertical">{{$licencaGratis?"Assine agora":"Nova assinatura"}}</a>
    </div>
</div>
