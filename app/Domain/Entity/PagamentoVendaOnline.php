<?php

namespace App\Domain\Entity;

class PagamentoVendaOnline
{
    private $comprovativoBancario;
    private $dataPagamentoBanco;
    private $formaPagamentoId;
    private $bancoId;
    private $iban;

    /**
     * @param $comprovativoBancario
     * @param $dataPagamentoBanco
     * @param $formaPagamentoId
     * @param $bancoId
     * @param $contaMovimentadaId
     */
    public function __construct($comprovativoBancario, $dataPagamentoBanco, $formaPagamentoId, $bancoId, $iban)
    {
        $this->comprovativoBancario = $comprovativoBancario;
        $this->dataPagamentoBanco = $dataPagamentoBanco;
        $this->formaPagamentoId = $formaPagamentoId;
        $this->bancoId = $bancoId;
        $this->iban = $iban;
    }

    /**
     * @return mixed
     */
    public function getComprovativoBancario()
    {
        return $this->comprovativoBancario;
    }

    /**
     * @return mixed
     */
    public function getDataPagamentoBanco()
    {
        return $this->dataPagamentoBanco;
    }

    /**
     * @return mixed
     */
    public function getFormaPagamentoId()
    {
        return $this->formaPagamentoId;
    }

    /**
     * @return mixed
     */
    public function getBancoId()
    {
        return $this->bancoId;
    }

    /**
     * @return mixed
     */
    public function getIban()
    {
        return $this->iban;
    }



}
