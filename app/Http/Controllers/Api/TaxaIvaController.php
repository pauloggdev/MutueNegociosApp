<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\empresa\TipoTaxa;

class TaxaIvaController extends Controller
{

    public function listarTaxas()
    {

        $data['taxas'] = TipoTaxa::with('statuGeral')->where('empresa_id', auth()->user()->empresa_id)->orWhere('empresa_id', null)->get();
        return response()->json($data, 200);
    }
}
