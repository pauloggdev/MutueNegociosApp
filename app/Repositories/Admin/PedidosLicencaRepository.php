<?php

namespace App\Repositories\Admin;

use App\Models\admin\AtivacaoLicenca;
use App\Models\admin\StatuLicencas;
use Carbon\Carbon;

class PedidosLicencaRepository
{

    protected $ativacaoLicenca;

    public function __construct(AtivacaoLicenca $ativacaoLicenca)
    {
        $this->ativacaoLicenca = $ativacaoLicenca;
    }
    public function getPedidoLicencas($byStatus, $byLicencas, $search, $perpage)
    {

        $pedidoLicencas = $this->ativacaoLicenca::latest()->with(
            [
                'pagamento.factura',
                'pagamento.formaPagamento',
                'pagamento.contaMovimento.coordernadaBancaria',
                'pagamento.contaMovimento',
                'licenca',
                'statusLicenca',
                'empresa',
                'pagamento',
                'pagamento.formaPagamento'
            ]
        )->when($byStatus, function ($query) use ($byStatus) {
            $query->where('status_licenca_id', $byStatus);
        })->when($byLicencas, function ($query) use ($byLicencas) {
            $query->where('licenca_id', $byLicencas);
        })->search(trim($search))->paginate($perpage);

        return $pedidoLicencas;
    }
    public function getPedidosLicenca(int $id)
    {
        $pedidoLicenca = $this->ativacaoLicenca::with(
            [
                'empresa',
                'licenca',
                'pagamento',
                'pagamento.contaMovimento',
                'pagamento.contaMovimento.coordernadaBancaria',
                'pagamento.formaPagamento',
                'pagamento.factura'

            ]
        )->where('id', $id)->first();
        return $pedidoLicenca;
    }
    public function alterarStatuPedidoLicencaParaAnulado(int $pedidoLicencaId, int $empresaId, string $observacao)
    {
        $ativacaoLicenca = $this->ativacaoLicenca::where('id', $pedidoLicencaId)->where('empresa_id', $empresaId)->first();
        $ativacaoLicenca->status_licenca_id = $this->ativacaoLicenca::REJEITADO;
        $ativacaoLicenca->data_rejeicao = Carbon::now();
        $ativacaoLicenca->user_id = auth()->user()->id;
        $ativacaoLicenca->operador = auth()->user()->name;
        $ativacaoLicenca->observacao = $observacao;
        $ativacaoLicenca->data_inicio = null;
        $ativacaoLicenca->data_fim = null;
        $ativacaoLicenca->data_activacao = null;
        $ativacaoLicenca->save();
    }
    public function getEmpresaPorPedidoLicencaId(int $pedidoLicencaId)
    {
        $pedido = $this->ativacaoLicenca::select('empresa_id')->where('id', $pedidoLicencaId)->first();
        return $pedido->empresa_id;
    }

    public function pegarUltimaDataLicencaDaEmpresa(int $empresaId)
    {

        $ultimaLicenca = AtivacaoLicenca::where('data_fim', '!=', NULL)
            ->where('status_licenca_id', 1)
            ->where('data_inicio', '!=', NULL)
            ->where('data_fim', '!=', NULL)
            ->where('empresa_id', $empresaId)->orderBY('created_at', 'DESC')->first();

        if ($ultimaLicenca) {

            $dataFimUltimaLicenca = Carbon::createFromFormat('Y-m-d', date($ultimaLicenca->data_fim));
            if ($dataFimUltimaLicenca == $this->now()) {
                return $this->now();
            } else if ($this->now() < $dataFimUltimaLicenca) {
                return $dataFimUltimaLicenca->addDays(1);
            } else if ($this->now() > $dataFimUltimaLicenca) {
                return $this->now();
            }
        } else {
            return $this->now();
        }
    }
    public function now()
    {
        return Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
    }

    public function rejeitarPedidoLicenca($observacao, $id)
    {
    }
}
