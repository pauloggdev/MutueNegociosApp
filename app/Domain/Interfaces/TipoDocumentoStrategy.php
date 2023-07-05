<?php

namespace App\Domain\Interfaces;

interface TipoDocumentoStrategy
{
    public function gerarNumeracao($numeroSerieDocumento, $numSequencia, $ano): string;
    public function obterNumSequencia($numeroSerieDocumento, $ano, INumSequenciaRepository $INumSequenciaRepository): int;
}
