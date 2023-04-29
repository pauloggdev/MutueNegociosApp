<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MotivoIvaController extends Controller
{

    public function listarMotivos()
    {

        $REGIME_GERAL = 1;
        $REGIME_SIMPLIFICADO = 2;
        $REGIME_EXCLUSAO = 3;

        if (auth()->user()->empresa->tipo_regime_id == $REGIME_EXCLUSAO) {
            $tipoMotivoIva = DB::connection('mysql2')->table('motivo')
                ->whereIn('codigo', [7, 8])->where('empresa_id', NULL)->orWhere('empresa_id', auth()->user()->empresa_id)
                ->get();
        } else if (auth()->user()->empresa->tipo_regime_id == $REGIME_GERAL) {

            $tipoMotivoIva = DB::connection('mysql2')->table('motivo')
                ->where('empresa_id', NULL)->where('codigo', '!=', 9)
                ->where('codigo', '!=', 7)
                //->where('codigo','!=',8)
                ->orWhere('empresa_id', auth()->user()->empresa_id)
                ->get();
        } else if (auth()->user()->empresa->tipo_regime_id == $REGIME_SIMPLIFICADO) {

            $tipoMotivoIva = DB::connection('mysql2')->table('motivo')
                ->whereIn('codigo', [8, 9])->where('empresa_id', NULL)->orWhere('empresa_id', auth()->user()->empresa_id)
                ->get();
        }
        return response()->json($tipoMotivoIva, 200);
    }
}
