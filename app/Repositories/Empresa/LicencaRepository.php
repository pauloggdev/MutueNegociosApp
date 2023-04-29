<?php

namespace App\Repositories\Empresa;

use App\Models\admin\AtivacaoLicenca;
use App\Models\admin\Empresa;
use Illuminate\Support\Str;

class LicencaRepository
{

    protected $entity;

    public function __construct(AtivacaoLicenca $activacaoLicenca)
    {
        $this->entity = $activacaoLicenca;
    }
    public function listarLicencasEmpresaAuth($search){
        $empresa = Empresa::where('referencia', auth()->user()->empresa->referencia)->first();
        return $this->entity::with(['licenca', 'statusLicenca'])->where('empresa_id', $empresa->id)->get();
    }

}
