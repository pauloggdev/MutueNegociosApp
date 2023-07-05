<?php

namespace App\Domain\Factory;

use App\Enums\EnumTipoDocumento;
use App\Infra\ImplementacaoInterfaces\DocumentoFaturaProformaStrategy;
use App\Infra\ImplementacaoInterfaces\DocumentoFaturaReciboStrategy;
use App\Infra\ImplementacaoInterfaces\DocumentoFaturaStrategy;
use App\Infra\ImplementacaoInterfaces\DocumentoReciboStrategy;

class TipoDocumentoFactory
{
    public static function execute($tipoDocumento){

        switch ($tipoDocumento){
            case EnumTipoDocumento::$FATURA_RECIBO:
                return new DocumentoFaturaReciboStrategy();
                break;
            case EnumTipoDocumento::$FATURA:
                return new DocumentoFaturaStrategy();
                break;
            case EnumTipoDocumento::$FATURA_PROFORMA:
                return new DocumentoFaturaProformaStrategy();
            case EnumTipoDocumento::$RECIBO:
                return new DocumentoReciboStrategy();
                break;
            default:
                throw new \Error('Tipo de documento não encontrado');
                break;
        }

    }

}
