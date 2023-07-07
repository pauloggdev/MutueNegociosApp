<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoRegimeAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposRegimes = [
            'Regime Geral','Regime Simplificado', 'Regime de Exclusão'
        ];
        foreach ($tiposRegimes as $designacao){
            DB::connection('mysql')->table('tipos_regimes')->insert([
                'Designacao' => $designacao,
            ]);
        }
    }
}
