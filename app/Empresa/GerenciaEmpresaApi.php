<?php

namespace App\Empresa;

use App\Models\admin\Empresa;
use App\Models\empresa\Empresa_Cliente;
use Illuminate\Support\Facades\Auth;

class GerenciaEmpresaApi{


    public function getEmpresaIdentificacao(){


        //Admin 
        if (Auth::guard('WebApi')->check()) {

            
            $referencia = Empresa::where('user_id', auth('WebApi')->user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            
        }
        //Empresa
        else {
            $empresa_id = auth('EmpresaApi')->user()->empresa_id;
        }


        return $empresa_id;
    }

}