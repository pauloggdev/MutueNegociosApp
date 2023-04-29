<?php

namespace App\Traits\Empresa;
trait TraitEmpresa
{
    public function getPathCompany()
    {
        return public_path() .'\\upload\\'. auth()->user()->empresa->logotipo;
       
    }
}
