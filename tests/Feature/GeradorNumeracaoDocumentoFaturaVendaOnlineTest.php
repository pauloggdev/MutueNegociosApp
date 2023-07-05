<?php


use App\Domain\Factory\TipoDocumentoFactory;
use App\Infra\ImplementacaoInterfaces\DocumentoFaturaProformaStrategy;
use App\Infra\ImplementacaoInterfaces\DocumentoFaturaReciboStrategy;
use App\Infra\ImplementacaoInterfaces\DocumentoFaturaStrategy;
use App\Infra\ImplementacaoInterfaces\DocumentoReciboStrategy;
use App\Infra\ImplementacaoInterfaces\GeradorNumeracaoDocumentoAgt;
use App\Infra\Repository\NumSequenciaFaturaVendaOnlineRepository;
use App\Repositories\Empresa\TraitSerieDocumento;
use Carbon\Carbon;
use Tests\TestCase;

class GeradorNumeracaoDocumentoFaturaVendaOnlineTest extends TestCase
{
    use TraitSerieDocumento;

    public function testDeveGerarNumeracaoFatura(){

        $numeroSerieDocumeto = $this->mostrarSerieDocumento();
        $NumSequenciaRepository = new NumSequenciaFaturaVendaOnlineRepository();
        $numeracaoDocumento = new GeradorNumeracaoDocumentoAgt(new DocumentoFaturaStrategy(),$numeroSerieDocumeto,$NumSequenciaRepository, Carbon::parse('2023-07-05')->year);
        $this->assertSame('FT AGT2023/1', $numeracaoDocumento->gerarNumeracao());
    }
    public function testDeveGerarNumeracaoFaturaRecibo(){
        $numeroSerieDocumeto = $this->mostrarSerieDocumento();
        $NumSequenciaRepository = new NumSequenciaFaturaVendaOnlineRepository();
        $numeracaoDocumento = new GeradorNumeracaoDocumentoAgt(new DocumentoFaturaReciboStrategy(),$numeroSerieDocumeto,$NumSequenciaRepository, Carbon::parse('2023-07-05')->year);
        $this->assertSame('FR AGT2023/1', $numeracaoDocumento->gerarNumeracao());
    }
    public function testDeveGerarNumeracaoFaturaProforma(){
        $numeroSerieDocumeto = $this->mostrarSerieDocumento();
        $NumSequenciaRepository = new NumSequenciaFaturaVendaOnlineRepository();
        $numeracaoDocumento = new GeradorNumeracaoDocumentoAgt(new DocumentoFaturaProformaStrategy(),$numeroSerieDocumeto,$NumSequenciaRepository, Carbon::parse('2023-07-05')->year);
        $this->assertSame('FP AGT2023/1', $numeracaoDocumento->gerarNumeracao());
    }
    public function testDeveGerarNumeracaoRecibo(){
        $numeroSerieDocumeto = $this->mostrarSerieDocumento();
        $NumSequenciaRepository = new NumSequenciaFaturaVendaOnlineRepository();
        $numeracaoDocumento = new GeradorNumeracaoDocumentoAgt(new DocumentoReciboStrategy(),$numeroSerieDocumeto,$NumSequenciaRepository, Carbon::parse('2023-07-05')->year);
        $this->assertSame('RC AGT2023/1', $numeracaoDocumento->gerarNumeracao());
    }
}
