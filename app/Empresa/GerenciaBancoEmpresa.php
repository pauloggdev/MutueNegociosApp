<?php

namespace App\Empresa;

use App\Models\admin\Empresa;
use App\Models\empresa\Empresa_Cliente;
use App\Models\empresa\Banco;
use App\Models\empresa\CoordenadasBancaria;
use Illuminate\Support\Facades\Auth;

class GerenciaBancoEmpresa{


    public function getEmpresaIdentificacao(){


        if (Auth::guard('web')->check()) {
            $referencia = Empresa::where('user_id', Auth::user()->id)->first()->referencia;
            $empresa_id = Empresa_Cliente::where('referencia', $referencia)->first()->id;
            $banco_id = Banco::where('empresa_id', $empresa_id)->first()->id;
            $coordenada_id = CoordenadasBancaria::where('banco_id', $banco_id)->first()->id;  
        } else {
            $empresa_id = Auth::user()->empresa_id;
            $banco_id = Banco::where('empresa_id', $empresa_id)->first()->id;
            $coordenada_id = CoordenadasBancaria::where('banco_id', $banco_id)->first()->id;
        }

        return $banco_id;
    }

}