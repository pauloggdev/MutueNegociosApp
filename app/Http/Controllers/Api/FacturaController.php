<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\empresa\Factura;

class FacturaController extends Controller
{


    public function listarFacturas()
    {
        $data['facturas'] = Factura::with(
            [
                'tipoUser', 'tipoDocumento', 'facturas_items',
                'formaPagamento', 'armazem',
                'cliente', 'empresa', 'canal',
                'status', 'user'
            ]
        )->where('empresa_id', auth()->user()->empresa_id)->paginate(15);

        return response()->json($data, 200);
    }
}
