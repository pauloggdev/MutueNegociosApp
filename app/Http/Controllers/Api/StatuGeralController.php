<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StatuGeralController extends Controller
{
    public function index()
    {
        $statusGerais = DB::connection('mysql2')->table('status_gerais')->get();
        return response()->json($statusGerais, 200);
    }
}
