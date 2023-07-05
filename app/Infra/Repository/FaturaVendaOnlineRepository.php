<?php

namespace App\Infra\Repository;

use App\Domain\Entity\FaturaVendaOnline;
use App\Models\admin\FaturaVendaOnline as FaturaVendaOnlineDatabase;
use App\Traits\FormadorNumeroExtenso;

class FaturaVendaOnlineRepository
{
    use FormadorNumeroExtenso;
    public function salvar(FaturaVendaOnline $fatura)
    {
        FaturaVendaOnlineDatabase::create([
            'total_fatura' => $fatura->getTotal(),
            'valor_a_pagar' => $fatura->getTotalPagar(),
            'total_incidencia' => $fatura->getTotalIncidencia(),
            'retencao' => $fatura->getRetencao(),
            'total_iva' => $fatura->getTaxaIva(),
            'desconto' => $fatura->getDesconto(),
            'troco' => $fatura->getTroco(),
            'valor_extenso' => $this->formatarNumeroExtenso($fatura->getTotalPagar()),
            'texto_hash' => 'fdaskldfakj',
            'hashValor' => 'klfdjalfjadlf',
            'numeroItems' => $fatura->getQuantItems(),
            'fatura_referencia' => '',
            'numSequencia' => $fatura->getNumSequenciaDocumento(),
            'numeracaoFatura' => $fatura->getNumeracaoDocumento(),
            'observacao' => $fatura->getObservacao(),
            'nome_do_cliente' => $fatura->getNomeCliente(),
            'nif_cliente' => $fatura->getNifCliente(),
            'email_cliente' => $fatura->getEmailCliente(),
            'telefone_cliente' => $fatura->getTelefoneCliente(),
            'endereco_cliente' => $fatura->getEnderecoCliente(),
            'empresa_id' => auth()->user()->empresa_id??158,
            'conta_corrente_cliente' => $fatura->getContaCorrenteCliente(),
        ]);
    }
}
