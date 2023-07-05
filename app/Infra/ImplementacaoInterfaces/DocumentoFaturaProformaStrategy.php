<?php

namespace App\Infra\ImplementacaoInterfaces;
use App\Domain\Interfaces\INumSequenciaRepository;
use App\Domain\Interfaces\TipoDocumentoStrategy;
use App\Enums\EnumTipoDocumento;

class DocumentoFaturaProformaStrategy implements TipoDocumentoStrategy
{
    public function gerarNumeracao($nomeEmpresa, $numSequencia, $ano): string
    {
        return "FP $nomeEmpresa$ano/$numSequencia";
    }
    public function obterNumSequencia($numeroSerieDocumento, $ano, INumSequenciaRepository $repository): int
    {
        return $repository->obterNumSequencia($numeroSerieDocumento, $ano, EnumTipoDocumento::$FATURA_PROFORMA);
    }
}
