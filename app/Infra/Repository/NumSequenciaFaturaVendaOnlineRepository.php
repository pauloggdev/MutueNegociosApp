<?php

namespace App\Infra\Repository;

use App\Domain\Interfaces\INumSequenciaRepository;
use Illuminate\Support\Facades\DB;

class NumSequenciaFaturaVendaOnlineRepository implements INumSequenciaRepository
{
    public function obterNumSequencia($numeroSerieDocumento, $ano,$tipoDocumento): int
    {
        $numSequencia = DB::connection('mysql')->table('facturas_vendas_online')
            ->where('empresa_id', auth()->user()->empresa_id??158)
            ->where('created_at', 'like', '%' . $ano . '%')
            ->where('numeracaoFatura', 'like', '%' . $numeroSerieDocumento . '%')
            ->where('tipo_documento', $tipoDocumento)
            ->orderBy('id','DESC')->count()+1;
        return $numSequencia;
    }
}
