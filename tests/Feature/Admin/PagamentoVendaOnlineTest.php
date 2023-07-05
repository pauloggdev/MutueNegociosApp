<?php

namespace Tests\Feature;
use App\Application\UseCase\EnviarPagamentoVendaOnline;
use App\Domain\Factory\TipoDocumentoFactory;
use App\Infra\Factory\DatabaseRepositoryFactory;
use App\Infra\ImplementacaoInterfaces\GeradorNumeracaoDocumentoAgt;
use App\Infra\Repository\NumSequenciaFaturaVendaOnlineRepository;
use App\Infra\Service\EmailNotificacao;
use App\Repositories\Empresa\TraitSerieDocumento;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PagamentoVendaOnlineTest extends TestCase
{
    use TraitSerieDocumento;


    public function testDeveEnviaPagamentoVendaOnline()
    {

        //$this->assertTrue(true);

        $input = [
            'comprovativoBancario' => '',
            'dataPagamentoBanco' => Carbon::now(),
            'formaPagamentoId' => 3,
            'bancoId' => 1,
            'codigoCoupon' => 'VALE20',
            'iban' => 'AO06 0045.0951.0317.9526.6262.8',
            'observacao' => null,
            'tipoDocumento' => 1,
        ];
        DB::beginTransaction();

        $notificacoesService = [
            new EmailNotificacao()
        ];

        $tipoDocumentoStrategy = TipoDocumentoFactory::execute($input['tipoDocumento']);
        $numeroSerieDocumeto = $this->mostrarSerieDocumento();
        $NumSequenciaRepository = new NumSequenciaFaturaVendaOnlineRepository();
        $geradorNumeracaoDocumento = new GeradorNumeracaoDocumentoAgt($tipoDocumentoStrategy,$numeroSerieDocumeto,$NumSequenciaRepository,Carbon::now()->year);
        $pagamento = new EnviarPagamentoVendaOnline(new DatabaseRepositoryFactory(), $notificacoesService, $geradorNumeracaoDocumento);
        $output = $pagamento->execute($input);
        DB::rollBack();
        $this->assertNotNull($output);
    }
}
