<?php

namespace App\Repositories\Admin;

use App\Models\admin\Licenca;


class LicencaRepository
{

    protected $licenca;

    public function __construct(Licenca $licenca)
    {
        $this->licenca = $licenca;
    }
    public function getLicencas($search = null)
    {
        $licencas = Licenca::with(['statuGeral'])->search(trim($search))->paginate();
        return $licencas;
    }
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where("designacao", "like", $term);
        });
    }
    public function pegarUltimaLicencaActiva(){
        
    }
}
