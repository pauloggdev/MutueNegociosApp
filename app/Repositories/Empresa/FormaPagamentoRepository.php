<?php

namespace App\Repositories\Empresa;

use App\Models\empresa\FormaPagamentoGeral;

class FormaPagamentoRepository
{

    protected $entity;

    public function __construct(FormaPagamentoGeral $formaPagamento)
    {
        $this->entity = $formaPagamento;
    }

    public function getFormasPagamento()
    {
        $formaPagamentos = $this->entity::with(['statuGeral'])->get();
        return $formaPagamentos;
    }

    public function listarFormaPagamentos()
    {
        $formaPagamentos = $this->entity::where('id', '!=', 2)->get();
        return $formaPagamentos;
    }
    public function listarFormaPagamentosSemPagamentoDuplo()
    {
        $formaPagamentos = $this->entity::where('id', '!=', 6)->get();
        return $formaPagamentos;
    }
}
