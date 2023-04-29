<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class PaisController extends Controller
{

    public function index()
    {
        $paises = DB::connection('mysql2')->table('paises')->get();
        return response()->json($paises, 200);
    }
}
