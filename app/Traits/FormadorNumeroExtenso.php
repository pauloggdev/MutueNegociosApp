<?php

namespace App\Traits;
use NumberFormatter;

trait FormadorNumeroExtenso
{
    public function formatarNumeroExtenso($valor){
        $f = new NumberFormatter("pt", NumberFormatter::SPELLOUT);
        return $f->format($valor);
    }

}
