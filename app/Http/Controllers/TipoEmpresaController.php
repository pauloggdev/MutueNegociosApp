<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TipoEmpresaController extends Controller
{
    public function index()
    {
        $data['tipoEmpresa'] = DB::table('tipos_clientes')->get();
        return response()->json($data, 200);
    }
}
