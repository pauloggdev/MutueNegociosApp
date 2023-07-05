<?php

namespace App\Infra\ImplementacaoInterfaces;
use App\Domain\Interfaces\IGeradorNumeracaoDocumento;
use App\Domain\Interfaces\INumSequenciaRepository;
use App\Domain\Interfaces\TipoDocumentoStrategy;

class GeradorNumeracaoDocumentoAgt implements IGeradorNumeracaoDocumento
{
    private $tipoDocumento;
    private $numeroSerieDocumento;
    private $INumSequenciaRepository;
    private $ano;

    public function __construct(TipoDocumentoStrategy $tipoDocumento, $numeroSerieDocumento, INumSequenciaRepository $INumSequenciaRepository, $ano)
    {
        $this->tipoDocumento = $tipoDocumento;
        $this->numeroSerieDocumento = $numeroSerieDocumento;
        $this->INumSequenciaRepository = $INumSequenciaRepository;
        $this->ano = $ano;
    }
    public function gerarNumeracao()
    {
        $numSequencia = $this->numSequenciaDocumento();
        return $this->tipoDocumento->gerarNumeracao(
            $this->numeroSerieDocumento,
            $numSequencia,
            $this->ano
        );
    }
    public function numSequenciaDocumento(){
        return $this->tipoDocumento->obterNumSequencia($this->numeroSerieDocumento, $this->ano, $this->INumSequenciaRepository);
    }

}
