<?php

namespace App\Empresa;

use App\Models\admin\Empresa;
use App\Models\empresa\Empresa_Cliente;
use Illuminate\Support\Facades\Auth;

class GerenciaEmpresa{

    public function getEmpresaIdentificacao(){
        //Admin

        if (Auth::guard('web')->check() && (Auth::guard('web')->user()->tipo_user_id == 1)) {
            $empresa = Empresa::select('id')->where('id', 1)->first();
            $empresa_id = $empresa->id;
        }
        //Empresa
        else if (Auth::guard('empresa')->check() && (Auth::guard('empresa')->user()->tipo_user_id == 2)) {
            $empresa_id = Empresa_Cliente::where('id', Auth::user()->empresa_id)->first()->id;
        }
       
        return $empresa_id;
    }

}
