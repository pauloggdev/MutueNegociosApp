<?php

namespace App\Infra\Repository;
use App\Domain\Entity\PagamentoVendaOnline;
use App\Models\admin\PagamentoVendaOnlineDatabase;

class PagamentoVendaOnlineRepository
{
    public function salvar(PagamentoVendaOnline $pagamento)
    {
        return PagamentoVendaOnlineDatabase::create([
            'comprovativoBancario' => $pagamento->getComprovativoBancario(),
            'dataPagamentoBanco' =>$pagamento->getDataPagamentoBanco(),
            'formaPagamentoId' => $pagamento->getFormaPagamentoId(),
            'iban' => $pagamento->getIban()
        ]);
    }
}
