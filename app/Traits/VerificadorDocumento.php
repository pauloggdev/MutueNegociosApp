<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use App\Traits\Empresa\TraitEmpresaAutenticada;


trait VerificadorDocumento{

    use TraitEmpresaAutenticada;


    
    public function comparaDataDocumentoAnteriorComActual($tabela){

        
        $query = DB::table($tabela)->where('empresa_id', $this->pegarEmpresaAutenticadaGuardOperador()['empresa']['id'])
        ->orderBy('id', 'DESC')->limit(1)->first();

        if($query == null){
            return true;
        }

        if($query){

            $dataAnteriorDocumento = Carbon::createFromFormat('Y-m-d H:i:s', $query->created_at);
            $dataAtualDocumento = Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
            if($dataAtualDocumento > $dataAnteriorDocumento){
                return true;
            }
            else{
                return false;
            }
        }
    }
}