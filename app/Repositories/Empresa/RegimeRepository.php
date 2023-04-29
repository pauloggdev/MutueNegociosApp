<?php

namespace App\Repositories\Empresa;
use App\Models\admin\TiposRegime;

class RegimeRepository
{

    protected $regime;

    public function __construct(TiposRegime $regime)
    {
        $this->regime = $regime;
    }

    public function getRegimes()
    {
        return $this->regime->get();
    }
}
