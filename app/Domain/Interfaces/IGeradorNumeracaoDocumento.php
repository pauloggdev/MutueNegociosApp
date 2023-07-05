<?php

namespace App\Domain\Interfaces;

use Carbon\Carbon;

interface IGeradorNumeracaoDocumento
{
    public function gerarNumeracao();
    public function numSequenciaDocumento();
}
