<?php

namespace App\Http\Controllers;

use App\Models\empresa\Pais;
use App\Models\empresa\TiposCliente;
use Illuminate\Http\Request;

class GenericoController extends Controller
{

    public function paises(){
        $paises = Pais::all();
        return response()->json($paises);
    }

    public function tipoCliente(){
        $tipoCliente = TiposCliente::all();
        return response()->json($tipoCliente);
    }
}
