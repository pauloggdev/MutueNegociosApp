<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoLicencaAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tiposLicencas = [
            'Grátis','Mensal', 'Anual'
        ];
        foreach ($tiposLicencas as $designacao){
            DB::connection('mysql')->table('tipos_licencas')->insert([
                'designacao' => $designacao,
            ]);
        }
    }
}
