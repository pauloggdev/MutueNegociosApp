<?php

namespace App\Domain\Interfaces;

use App\Enums\EnumTipoDocumento;

interface INumSequenciaRepository
{
    public function obterNumSequencia($numeroSerieDocumento, $ano, EnumTipoDocumento $tipoDocumetno): int;
}
