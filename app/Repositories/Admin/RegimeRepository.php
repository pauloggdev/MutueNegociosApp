<?php

namespace App\Repositories\Admin;
use App\Models\admin\TiposRegime;

class RegimeRepository
{

    protected $entity;

    public function __construct(TiposRegime $regime)
    {
        $this->entity = $regime;
    }

    public function getRegimes()
    {
        $regimes = $this->entity::get();
        return $regimes;
    }
}
