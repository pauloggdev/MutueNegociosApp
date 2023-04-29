<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PaisController extends Controller
{

    public function index()
    {
        $paises = DB::connection('mysql2')->table('paises')->get();
        return response()->json($paises, 200);
    }
}
