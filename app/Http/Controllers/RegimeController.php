<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RegimeController extends Controller
{


    public function index()
    {
        $data['tipoRegime'] = DB::table('tipos_regimes')->get();
        return response()->json($data, 200);
    }
    //
}
