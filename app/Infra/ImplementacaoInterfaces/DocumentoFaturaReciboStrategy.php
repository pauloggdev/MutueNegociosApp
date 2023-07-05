<?php

namespace App\Infra\ImplementacaoInterfaces;
use App\Domain\Interfaces\INumSequenciaRepository;
use App\Domain\Interfaces\TipoDocumentoStrategy;
use App\Enums\EnumTipoDocumento;

class DocumentoFaturaReciboStrategy implements TipoDocumentoStrategy
{
    public function gerarNumeracao($nomeEmpresa, $numSequencia, $ano): string
    {
        return "FR $nomeEmpresa$ano/$numSequencia";
    }
    public function obterNumSequencia($numeroSerieDocumento, $ano, INumSequenciaRepository $repository): int
    {
        return $repository->obterNumSequencia($numeroSerieDocumento, $ano, EnumTipoDocumento::$FATURA_RECIBO);
    }
}
