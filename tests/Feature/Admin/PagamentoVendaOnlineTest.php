<?php

namespace Tests\Feature;
use App\Application\UseCase\EnviarPagamentoVendaOnline;
use App\Infra\Factory\DatabaseRepositoryFactory;
use App\Infra\Service\EmailNotificacao;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PagamentoVendaOnlineTest extends TestCase
{


    public function testDeveEnviaPagamentoVendaOnline()
    {

        $input = [
            'comprovativoBancario' => '',
            'dataPagamentoBanco' => Carbon::now(),
            'formaPagamentoId' => 3,
            'bancoId' => 1,
            'codigoCoupon' => 'VALE20',
            'iban' => 'AO06 0045.0951.0317.9526.6262.8',
        ];
        DB::beginTransaction();

        $notificacoesService = [
            new EmailNotificacao()
        ];
        $pagamento = new EnviarPagamentoVendaOnline(new DatabaseRepositoryFactory(), $notificacoesService);
        $output = $pagamento->execute($input);
        DB::rollBack();
        $this->assertNotNull($output);

    }
}
