<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusGeraisAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusGerais = [
            'Activo',
            'Desactivo'
        ];
        foreach ($statusGerais as $designacao){
            DB::connection('mysql')->table('status_gerais')->insert([
                'designacao' => $designacao
            ]);
        }
    }
}
