<?php

namespace App\Http\Controllers\admin\Traits;

use Illuminate\Support\Facades\DB;

trait TraitEmpresa
{
    public function getPathCompany()
    {
        $empresaLogotipo = DB::connection("mysql")->select('select logotipo from empresas where id = :id', ['id' => 1]);
        $diretorio = public_path() .'\\upload\\'. $empresaLogotipo[0]->logotipo;
        return $diretorio;
    }
}
