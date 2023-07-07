<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusLicencaAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statusLicencas = [
            'Activo',
            'Rejeitado',
            'Pendente'
        ];
        foreach ($statusLicencas as $designacao){
            DB::connection('mysql')->table('status_licencas')->insert([
                'designacao' => $designacao,
            ]);
        }
    }
}
