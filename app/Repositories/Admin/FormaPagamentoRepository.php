<?php

namespace App\Repositories\Admin;

use App\Models\admin\FormaPagamento;
use App\Models\empresa\FormaPagamentoGeral;

class FormaPagamentoRepository
{

    protected $formaPagamento;
    protected $formaPagamentoGeral;

    public function __construct(FormaPagamento $formaPagamento, FormaPagamentoGeral $formaPagamentoGeral)
    {
        $this->formaPagamento = $formaPagamento;
        $this->formaPagamentoGeral = $formaPagamentoGeral;
    }

    public function listarFormaPagamentoGeral()
    {
        return $this->formaPagamentoGeral::get();
    }

    public function listarFormaPagamento()
    {
        return $this->formaPagamento::get();
    }
}
