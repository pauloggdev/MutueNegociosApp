<?php

namespace App\Repositories\Admin;

use App\Models\admin\AtivacaoLicenca;
use App\Models\admin\Licenca;

class ActivacaoLicencaRepository
{

    protected $activacaoLicenca;
    protected $licenca;
    protected $empresaRepository;
    protected $LICENCA_DEFINITIVO = 4;
    protected $STATUS_ACTIVO = 1;

    public function __construct(
        AtivacaoLicenca $activacaoLicenca,
        Licenca $licenca,
        EmpresaRepository $empresaRepository
    ) {
        $this->activacaoLicenca = $activacaoLicenca;
        $this->licenca = $licenca;
        $this->empresaRepository = $empresaRepository;
    }
    public function getLicencaDefinitivo($empresaId)
    {
        return $this->activacaoLicenca::where('empresa_id', $empresaId)
            ->where('licenca_id', $this->LICENCA_DEFINITIVO)
            ->where('status_licenca_id', $this->STATUS_ACTIVO)
            ->first();
    }
    public function getLicenca($licencaId)
    {
        return $this->licenca::where('id', $licencaId)->first();
    }

    public function pegarUltimaLicencaActiva()
    {
        $empresa = $this->empresaRepository->getEmpresaPelaReferencia(auth()->user()->empresa->referencia);
        if ($this->getLicencaDefinitivo($empresa->id)) {
            return $this->getLicenca($this->LICENCA_DEFINITIVO);
        }

        $licenca =  $this->activacaoLicenca::where('empresa_id', $empresa->id)
            ->where('status_licenca_id', $this->STATUS_ACTIVO)
            ->orderByDesc('id')->first();

        return $this->getLicenca($licenca->licenca_id);
    }
}
